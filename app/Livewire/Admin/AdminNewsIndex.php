<?php

namespace App\Livewire\Admin;

use App\Models\NewsArticle;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

#[Layout('components.dashboard.app-shell')]
class AdminNewsIndex extends Component
{
    use WithPagination, WithFileUploads;

    public string $search         = '';
    public string $filterStatus   = '';
    public string $filterCategory = '';

    // Form Modal
    public bool   $formOpen  = false;
    public bool   $isEditing = false;
    public ?int   $editingId = null;

    public string $title_ar       = '';
    public string $title_fr       = '';
    public string $title_en       = '';
    public string $category       = 'ANNOUNCEMENT';
    public string $excerpt_ar     = '';
    public string $excerpt_fr     = '';
    public string $content_ar     = '';
    public string $content_fr     = '';
    public string $featured_image = '';
    public $image; // Temporary uploaded image file
    public string $status         = 'PUBLISHED';

    // Preview Modal / Drawer
    public bool         $drawerOpen      = false;
    public ?NewsArticle $selectedArticle = null;

    // Delete Confirmation Modal
    public bool $deleteConfirmOpen = false;
    public ?int $deleteTargetId    = null;

    protected $queryString = ['search', 'filterStatus', 'filterCategory'];

    public function updatingSearch(): void         { $this->resetPage(); }
    public function updatingFilterStatus(): void   { $this->resetPage(); }
    public function updatingFilterCategory(): void { $this->resetPage(); }

    /* ─── Form Operations ─── */
    public function openCreate(): void
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->formOpen  = true;
    }

    public function openEdit(int $id): void
    {
        $article = NewsArticle::findOrFail($id);
        $this->editingId      = $id;
        $this->title_ar       = $article->title_ar ?? '';
        $this->title_fr       = $article->title_fr ?? '';
        $this->title_en       = $article->title_en ?? '';
        $this->category       = $article->category ?? 'ANNOUNCEMENT';
        $this->excerpt_ar     = $article->excerpt_ar ?? '';
        $this->excerpt_fr     = $article->excerpt_fr ?? '';
        $this->content_ar     = $article->content_ar ?? '';
        $this->content_fr     = $article->content_fr ?? '';
        $this->featured_image = $article->featured_image ?? '';
        $this->status         = $article->status ?? 'PUBLISHED';
        $this->image          = null;
        $this->isEditing      = true;
        $this->formOpen       = true;
    }

    public function save(): void
    {
        $this->validate([
            'title_ar' => 'required|min:3',
            'image'    => $this->image ? 'image|max:5120' : 'nullable',
        ], [
            'title_ar.required' => 'يرجى إدخال عنوان الخبر بالعربية.',
            'title_ar.min'      => 'العنوان يجب أن يتكون من 3 أحرف على الأقل.',
            'image.image'       => 'الملف المرفق يجب أن يكون صورة صالحة (JPG / PNG / WEBP).',
            'image.max'         => 'حجم الصورة يجب ألا يتجاوز 5 ميغابايت.',
        ]);

        $titleFr = !empty($this->title_fr) ? $this->title_fr : $this->title_ar;
        $titleEn = !empty($this->title_en) ? $this->title_en : $titleFr;

        $imagePath = $this->featured_image;
        if ($this->image) {
            $imagePath = $this->image->store('news_images', 'public');
        }

        $data = [
            'title_ar'       => $this->title_ar,
            'title_fr'       => $titleFr,
            'title_en'       => $titleEn,
            'category'       => $this->category ?: 'ANNOUNCEMENT',
            'excerpt_ar'     => $this->excerpt_ar,
            'excerpt_fr'     => $this->excerpt_fr ?: $this->excerpt_ar,
            'content_ar'     => $this->content_ar,
            'content_fr'     => $this->content_fr ?: $this->content_ar,
            'featured_image' => $imagePath,
            'status'         => $this->status ?: 'PUBLISHED',
            'author_id'      => \Illuminate\Support\Facades\Auth::id(),
            'published_at'   => $this->status === 'PUBLISHED' ? now() : null,
        ];

        if ($this->isEditing && $this->editingId) {
            $article = NewsArticle::findOrFail($this->editingId);
            $article->update($data);
            $msg = 'تم تحديث الخبر بنجاح';
        } else {
            NewsArticle::create($data);
            $msg = 'تم إضافة الخبر الجديد بنجاح';
        }

        $this->formOpen = false;
        $this->resetForm();
        $this->dispatch('notify', ['type' => 'success', 'msg' => $msg]);
        session()->flash('message', $msg);
    }

    /* ─── Preview & Delete Operations ─── */
    public function openDrawer(int $id): void
    {
        $this->selectedArticle = NewsArticle::with('author')->find($id);
        $this->drawerOpen      = true;
    }

    public function confirmDelete(int $id): void
    {
        $this->deleteTargetId    = $id;
        $this->deleteConfirmOpen = true;
    }

    public function deleteArticle(int $id = null): void
    {
        $targetId = $id ?: $this->deleteTargetId;
        if ($targetId) {
            NewsArticle::findOrFail($targetId)->delete();
            $msg = 'تم حذف الخبر بنجاح';
            $this->deleteConfirmOpen = false;
            $this->deleteTargetId    = null;
            $this->resetPage();
            $this->dispatch('notify', ['type' => 'success', 'msg' => $msg]);
            session()->flash('message', $msg);
        }
    }

    private function resetForm(): void
    {
        $this->editingId      = null;
        $this->title_ar       = '';
        $this->title_fr       = '';
        $this->title_en       = '';
        $this->excerpt_ar     = '';
        $this->excerpt_fr     = '';
        $this->content_ar     = '';
        $this->content_fr     = '';
        $this->featured_image = '';
        $this->image          = null;
        $this->category       = 'ANNOUNCEMENT';
        $this->status         = 'PUBLISHED';
        $this->resetErrorBag();
    }

    public function render()
    {
        $query = NewsArticle::with('author')
            ->when($this->search, fn($q) => $q->where(function ($q) {
                $q->where('title_ar', 'like', '%'.$this->search.'%')
                  ->orWhere('title_fr', 'like', '%'.$this->search.'%');
            }))
            ->when($this->filterStatus,   fn($q) => $q->where('status',   $this->filterStatus))
            ->when($this->filterCategory, fn($q) => $q->where('category', $this->filterCategory))
            ->latest();

        return view('livewire.admin.cms.news-index', [
            'articles'       => $query->paginate(10),
            'totalArticles'  => NewsArticle::count(),
            'publishedCount' => NewsArticle::where('status', 'PUBLISHED')->count(),
        ]);
    }
}
