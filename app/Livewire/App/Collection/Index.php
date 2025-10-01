<?php

namespace App\Livewire\App\Collection;

use App\Models\Category;
use App\Models\Tag;
use App\Models\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public array $selectedCollectionCategories = [];
    public array $selectedItemCategories = [];
    public array $selectedCollectionTags = [];
    public array $selectedItemTags = [];

    public string $search = "";
    public string $sortField = "name";
    public string $sortDirection = "asc";
    public string $viewMode = "card"; // 'card' ou 'list'

    public $allCategories = [];
    public $allItemCategories = [];
    public $allTags = [];

    protected $queryString = [
        "search" => ["except" => ""],
        "selectedCollectionCategories" => ["except" => []],
        "selectedItemCategories" => ["except" => []],
        "selectedCollectionTags" => ["except" => []],
        "selectedItemTags" => ["except" => []],
        "sortField" => ["except" => "name"],
        "sortDirection" => ["except" => "asc"],
        "page" => ["except" => 1],
    ];

    public function mount($slug = null)
    {
        // Carrega categorias e tags
        $this->allCategories = Category::where("type", "collection")->get();
        $this->allItemCategories = Category::where("type", "item")->get();
        $this->allTags = Tag::all(); // tags para collections e items
        $this->sortField = "name";
        if ($slug) {
            $tag = Tag::where("slug", $slug)->first();
            if ($tag) {
                $this->selectedCollectionTags = [$tag->id];
            }
        }
    }

    // Reset da paginação ao atualizar filtros
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatingSelectedCollectionCategories()
    {
        $this->resetPage();
    }
    public function updatingSelectedItemCategories()
    {
        $this->resetPage();
    }
    public function updatingSelectedCollectionTags()
    {
        $this->resetPage();
    }
    public function updatingSelectedItemTags()
    {
        $this->resetPage();
    }
    public function updatingSortField()
    {
        $this->resetPage();
    }
    public function updatingSortDirection()
    {
        $this->resetPage();
    }

    public function toggleSortDirection()
    {
        $this->sortDirection = $this->sortDirection === "asc" ? "desc" : "asc";
    }

    public function toggleViewMode()
    {
        $this->viewMode = $this->viewMode === "card" ? "list" : "card";
    }

    public function render()
    {
        $query = Collection::query()
            ->with(["categories", "tags", "items.tags"])
            ->when($this->search, function ($q) {
                $q->where("name", "like", "%{$this->search}%");
            })
            ->when($this->selectedCollectionCategories, function ($q) {
                $q->whereHas("categories", function ($q2) {
                    $q2->whereIn(
                        "categories.id",
                        $this->selectedCollectionCategories,
                    );
                });
            })
            ->when($this->selectedCollectionTags, function ($q) {
                $q->whereHas("tags", function ($q2) {
                    $q2->whereIn("tags.id", $this->selectedCollectionTags);
                });
            })
            ->when($this->selectedItemTags, function ($q) {
                $selectedItemTags = $this->selectedItemTags; // importante para usar na closure
                $q->whereHas("items", function ($qItem) use (
                    $selectedItemTags,
                ) {
                    $qItem->whereHas("tags", function ($qTag) use (
                        $selectedItemTags,
                    ) {
                        $qTag->whereIn("tags.id", $selectedItemTags);
                    });
                });
            })
            ->orderBy($this->sortField, $this->sortDirection);

        $collections = $query->paginate(9)->withQueryString();

        return view("livewire.app.collections.index", [
            "collections" => $collections,
        ])->title("Coleções");
    }
}
