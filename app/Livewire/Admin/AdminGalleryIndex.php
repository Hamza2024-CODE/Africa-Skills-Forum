<?php

namespace App\Livewire\Admin;

use App\Models\Album;
use App\Models\Media;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('components.dashboard.app-shell')]
class AdminGalleryIndex extends Component
{
    use WithPagination, WithFileUploads;

    public string $search       = '';
    public string $filterStatus = '';

    // Form
    public bool   $formOpen  = false;
    public bool   $isEditing = false;
    public ?int   $editingId = null;

    #[Validate('required|min:3')] public string $title_ar       = '';
    #[Validate('required|min:3')] public string $title_fr       = '';
    #[Validate('nullable')]       public string $title_en       = '';
    #[Validate('nullable')]       public string $description_ar = '';
    #[Validate('nullable')]       public string $description_fr = '';
    #[Validate('boolean')]        public bool   $is_featured    = false;
    #[Validate('required')]       public string $status         = 'PUBLISHED';

    // File Uploads
    public array  $newPhotos    = [];

    // Drawer
    public bool   $drawerOpen    = false;
    public ?Album $selectedAlbum = null;

    // Delete
    public bool $deleteConfirmOpen = false;
    public ?int $deleteTargetId   = null;

    protected $queryString = ['search', 'filterStatus'];

    public function updatingSearch(): void       { $this->resetPage(); }
    public function updatingFilterStatus(): void { $this->resetPage(); }

    /* ─── Form ─── */
    public function openCreate(): void
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->formOpen  = true;
    }

    public function openEdit(int $id): void
    {
        $album = Album::findOrFail($id);
        $this->editingId      = $id;
        $this->title_ar       = $album->title_ar ?? '';
        $this->title_fr       = $album->title_fr ?? '';
        $this->title_en       = $album->title_en ?? '';
        $this->description_ar = $album->description_ar ?? '';
        $this->description_fr = $album->description_fr ?? '';
        $this->is_featured    = (bool)$album->is_featured;
        $this->status         = $album->status ?? 'PUBLISHED';
        $this->newPhotos      = [];
        $this->isEditing      = true;
        $this->formOpen       = true;
    }

    public function save(): void
    {
        $this->validate(['title_ar' => 'required|min:3', 'title_fr' => 'required|min:3']);

        $data = [
            'title_ar'       => $this->title_ar,
            'title_fr'       => $this->title_fr,
            'title_en'       => $this->title_en ?: $this->title_fr,
            'description_ar' => $this->description_ar,
            'description_fr' => $this->description_fr,
            'is_featured'    => $this->is_featured,
            'status'         => $this->status,
            'published_at'   => $this->status === 'PUBLISHED' ? now() : null,
        ];

        if ($this->isEditing) {
            $album = Album::findOrFail($this->editingId);
            $album->update($data);
        } else {
            $album = Album::create($data);
        }

        // Process File Uploads
        if (!empty($this->newPhotos)) {
            $this->processUploadedPhotos($album);
        }

        $this->formOpen = false;
        $this->resetForm();
        $this->dispatch('notify', ['type' => 'success', 'msg' => 'تم حفظ ألبوم الصور ورَفْع الصور بنجاح']);
    }

    public function uploadPhotosToSelectedAlbum(): void
    {
        if ($this->selectedAlbum && !empty($this->newPhotos)) {
            $this->processUploadedPhotos($this->selectedAlbum);
            $this->selectedAlbum = Album::with('mediaItems')->find($this->selectedAlbum->id);
            $this->newPhotos = [];
            $this->dispatch('notify', ['type' => 'success', 'msg' => 'تم رفع الصور الإضافية إلى الألبوم بنجاح']);
        }
    }

    private function processUploadedPhotos(Album $album): void
    {
        foreach ($this->newPhotos as $photo) {
            $filename = Str::random(20) . '.' . $photo->getClientOriginalExtension();
            $path = $photo->storeAs('albums', $filename, 'public');

            $media = Media::create([
                'filename'          => $filename,
                'original_filename' => $photo->getClientOriginalName(),
                'mime_type'         => $photo->getMimeType(),
                'file_size'         => $photo->getSize(),
                'storage_path'      => 'storage/' . $path,
                'visibility'        => 'PUBLIC',
                'status'            => 'READY',
            ]);

            $album->mediaItems()->attach($media->id);

            if (!$album->cover_media_id) {
                $album->update(['cover_media_id' => $media->id]);
            }
        }
    }

    public function deleteMediaItem(int $mediaId): void
    {
        if ($this->selectedAlbum) {
            $this->selectedAlbum->mediaItems()->detach($mediaId);
            Media::where('id', $mediaId)->delete();
            $this->selectedAlbum = Album::with('mediaItems')->find($this->selectedAlbum->id);
            $this->dispatch('notify', ['type' => 'success', 'msg' => 'تم حذف الصورة من الألبوم']);
        }
    }

    public function setCoverMedia(int $mediaId): void
    {
        if ($this->selectedAlbum) {
            $this->selectedAlbum->update(['cover_media_id' => $mediaId]);
            $this->selectedAlbum = Album::with('mediaItems')->find($this->selectedAlbum->id);
            $this->dispatch('notify', ['type' => 'success', 'msg' => 'تم تحديد الصورة كغلاف للألبوم']);
        }
    }

    /* ─── Drawer ─── */
    public function openDrawer(int $id): void
    {
        $this->selectedAlbum = Album::with('mediaItems')->find($id);
        $this->drawerOpen    = true;
    }

    public function confirmDelete(int $id): void
    {
        $this->deleteTargetId    = $id;
        $this->deleteConfirmOpen = true;
    }

    public function deleteAlbum(): void
    {
        Album::findOrFail($this->deleteTargetId)->delete();
        $this->deleteConfirmOpen = false;
        $this->drawerOpen        = false;
        $this->selectedAlbum     = null;
        $this->resetPage();
        $this->dispatch('notify', ['type' => 'success', 'msg' => 'تم حذف الألبوم']);
    }

    private function resetForm(): void
    {
        $this->editingId      = null;
        $this->title_ar       = $this->title_fr = $this->title_en = '';
        $this->description_ar = $this->description_fr = '';
        $this->is_featured    = false;
        $this->status         = 'PUBLISHED';
        $this->newPhotos      = [];
        $this->resetErrorBag();
    }

    public function render()
    {
        $query = Album::withCount('mediaItems')->with('coverMedia')
            ->when($this->search, fn($q) => $q->where(function ($q) {
                $q->where('title_ar', 'like', '%'.$this->search.'%')
                  ->orWhere('title_fr', 'like', '%'.$this->search.'%');
            }))
            ->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus))
            ->latest();

        return view('livewire.admin.cms.gallery-index', [
            'albums'      => $query->paginate(12),
            'totalAlbums' => Album::count(),
        ]);
    }
}
