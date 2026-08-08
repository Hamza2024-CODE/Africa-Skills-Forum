<?php

namespace App\Livewire\Admin;

use App\Models\Video;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.dashboard.app-shell')]
class AdminVideoIndex extends Component
{
    use WithPagination;

    public string $search       = '';
    public string $filterType   = '';
    public string $filterStatus = '';

    // Form
    public bool   $formOpen  = false;
    public bool   $isEditing = false;
    public ?int   $editingId = null;

    #[Validate('required|min:3')] public string $title_ar       = '';
    #[Validate('required|min:3')] public string $title_fr       = '';
    #[Validate('nullable')]       public string $title_en       = '';
    #[Validate('required')]       public string $video_type     = 'YOUTUBE';
    #[Validate('required|url')]   public string $video_url      = '';
    #[Validate('nullable')]       public string $embed_url      = '';
    #[Validate('nullable')]       public string $description_ar = '';
    #[Validate('nullable')]       public string $duration       = '';
    #[Validate('boolean')]        public bool   $is_featured    = false;
    #[Validate('required')]       public string $status         = 'PUBLISHED';

    // Drawer
    public bool   $drawerOpen    = false;
    public ?Video $selectedVideo = null;

    // Delete
    public bool $deleteConfirmOpen = false;
    public ?int $deleteTargetId   = null;

    protected $queryString = ['search', 'filterType', 'filterStatus'];

    public function updatingSearch(): void       { $this->resetPage(); }
    public function updatingFilterType(): void   { $this->resetPage(); }
    public function updatingFilterStatus(): void { $this->resetPage(); }

    public function syncFromChannel(): void
    {
        $importer = new \App\Services\YouTubeChannelImporterService();
        $res = $importer->importFromChannelHandle('@WorldSkillsAlgeria');
        $this->resetPage();
        $this->dispatch('notify', ['type' => 'success', 'msg' => $res['message']]);
    }

    /* ─── Form ─── */
    public function openCreate(): void
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->formOpen  = true;
    }

    public function openEdit(int $id): void
    {
        $v = Video::findOrFail($id);
        $this->editingId      = $id;
        $this->title_ar       = $v->title_ar ?? '';
        $this->title_fr       = $v->title_fr ?? '';
        $this->title_en       = $v->title_en ?? '';
        $this->video_type     = $v->video_type ?? 'YOUTUBE';
        $this->video_url      = $v->video_url ?? '';
        $this->embed_url      = $v->embed_url ?? '';
        $this->description_ar = $v->description_ar ?? '';
        $this->duration       = $v->duration ?? '';
        $this->is_featured    = (bool)$v->is_featured;
        $this->status         = $v->status ?? 'PUBLISHED';
        $this->isEditing      = true;
        $this->formOpen       = true;
    }

    public function save(): void
    {
        $this->validate([
            'title_ar'  => 'required|min:3',
            'title_fr'  => 'required|min:3',
            'video_url' => 'required',
        ]);

        $data = [
            'title_ar'       => $this->title_ar,
            'title_fr'       => $this->title_fr,
            'title_en'       => $this->title_en ?: $this->title_fr,
            'video_type'     => $this->video_type,
            'video_url'      => $this->video_url,
            'embed_url'      => $this->embed_url ?: $this->video_url,
            'description_ar' => $this->description_ar,
            'duration'       => $this->duration,
            'is_featured'    => $this->is_featured,
            'status'         => $this->status,
            'published_at'   => $this->status === 'PUBLISHED' ? now() : null,
        ];

        $this->isEditing
            ? Video::findOrFail($this->editingId)->update($data)
            : Video::create($data);

        $this->formOpen = false;
        $this->resetForm();
        $this->dispatch('notify', ['type' => 'success', 'msg' => 'تم حفظ الفيديو بنجاح']);
    }

    /* ─── Drawer ─── */
    public function openDrawer(int $id): void
    {
        $this->selectedVideo = Video::find($id);
        $this->drawerOpen    = true;
    }

    public function confirmDelete(int $id): void
    {
        $this->deleteTargetId    = $id;
        $this->deleteConfirmOpen = true;
    }

    public function deleteVideo(): void
    {
        Video::findOrFail($this->deleteTargetId)->delete();
        $this->deleteConfirmOpen = false;
        $this->resetPage();
        $this->dispatch('notify', ['type' => 'success', 'msg' => 'تم حذف الفيديو']);
    }

    private function resetForm(): void
    {
        $this->editingId      = null;
        $this->title_ar       = $this->title_fr = $this->title_en = '';
        $this->video_type     = 'YOUTUBE';
        $this->video_url      = $this->embed_url = $this->description_ar = $this->duration = '';
        $this->is_featured    = false;
        $this->status         = 'PUBLISHED';
        $this->resetErrorBag();
    }

    public function render()
    {
        $query = Video::query()
            ->when($this->search, fn($q) => $q->where(function ($q) {
                $q->where('title_ar', 'like', '%'.$this->search.'%')
                  ->orWhere('title_fr', 'like', '%'.$this->search.'%');
            }))
            ->when($this->filterType,   fn($q) => $q->where('video_type', $this->filterType))
            ->when($this->filterStatus, fn($q) => $q->where('status',     $this->filterStatus))
            ->latest();

        return view('livewire.admin.cms.video-index', [
            'videos'      => $query->paginate(12),
            'totalVideos' => Video::count(),
        ]);
    }
}
