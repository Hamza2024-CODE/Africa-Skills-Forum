<?php

namespace App\Livewire\Admin;

use App\Models\NewsArticle;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.dashboard.app-shell')]
class AdminNewsIndex extends Component
{
    use WithPagination;

    public string $search       = '';
    public string $filterStatus = '';
    public string $filterCategory = '';

    // Form
    public bool   $formOpen  = false;
    public bool   $isEditing = false;
    public ?int   $editingId = null;

    #[Validate('required|min:3')] public string $title_ar       = '';
    #[Validate('required|min:3')] public string $title_fr       = '';
    #[Validate('nullable')]       public string $title_en       = '';
    #[Validate('nullable')]       public string $category       = 'ANNOUNCEMENT';
    #[Validate('nullable')]       public string $excerpt_ar     = '';
    #[Validate('nullable')]       public string $excerpt_fr     = '';
    #[Validate('nullable')]       public string $content_ar     = '';
    #[Validate('nullable')]       public string $content_fr     = '';
    #[Validate('nullable')]       public string $featured_image = '';
    #[Validate('required')]       public string $status         = 'DRAFT';

    // Drawer
    public bool         $drawerOpen      = false;
    public ?NewsArticle $selectedArticle = null;

    // Delete
    public bool $deleteConfirmOpen = false;
    public ?int $deleteTargetId   = null;

    protected $queryString = ['search', 'filterStatus', 'filterCategory'];

    public function updatingSearch(): void         { $this->resetPage(); }
    public function updatingFilterStatus(): void   { $this->resetPage(); }
    public function updatingFilterCategory(): void { $this->resetPage(); }

    /* ─── Form ─── */
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
        $this->status         = $article->status ?? 'DRAFT';
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
            'category'       => $this->category,
            'excerpt_ar'     => $this->excerpt_ar,
            'excerpt_fr'     => $this->excerpt_fr,
            'content_ar'     => $this->content_ar,
            'content_fr'     => $this->content_fr,
            'featured_image' => $this->featured_image,
            'status'         => $this->status,
            'author_id'      => \Illuminate\Support\Facades\Auth::id(),
            'published_at'   => $this->status === 'PUBLISHED' ? now() : null,
        ];

        $this->isEditing
            ? NewsArticle::findOrFail($this->editingId)->update($data)
            : NewsArticle::create($data);

        $this->formOpen = false;
        $this->resetForm();
        $this->dispatch('notify', ['type' => 'success', 'msg' => 'تم حفظ الخبر بنجاح']);
    }

    /* ─── Drawer ─── */
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

    public function deleteArticle(): void
    {
        NewsArticle::findOrFail($this->deleteTargetId)->delete();
        $this->deleteConfirmOpen = false;
        $this->resetPage();
        $this->dispatch('notify', ['type' => 'success', 'msg' => 'تم حذف المقال']);
    }

    private function resetForm(): void
    {
        $this->editingId      = null;
        $this->title_ar       = $this->title_fr = $this->title_en = '';
        $this->excerpt_ar     = $this->excerpt_fr = $this->content_ar = $this->content_fr = $this->featured_image = '';
        $this->category       = 'ANNOUNCEMENT';
        $this->status         = 'DRAFT';
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
