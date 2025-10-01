<?php

namespace App\Livewire\App\Collection;

use App\Jobs\ProcessDownload;
use App\Models\Category;
use App\Models\Download;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Collection;
use App\Models\Item;

class ViewCollection extends Component
{
    use WithPagination;

    public array $selectedCollectionCategories = [];
    public array $selectedItemCategories = [];

    public string $search = "";
    public string $sortField = "name";
    public string $sortDirection = "asc";

    public $allCategories = [];
    public $allItemCategories = [];

    public string $viewMode = "card"; // 'card' ou 'list'

    // Separamos slug de collection e slug de category para evitar confusão
    public ?string $categorySlug = null;
    public ?string $collectionSlug = null;
    public ?int $selectedCategoryId = null;

    public $collection = "";
    // Variável para a view (evita "Undefined variable")
    public bool $isItemView = false;
    public $relatedItems = [];
    public $selectedItem = null;
    public $showModal = false;

    protected $queryString = [
        "search" => ["except" => ""],
        "selectedCollectionCategories" => ["except" => []],
        "selectedItemCategories" => ["except" => []],
        "sortField" => ["except" => "name"],
        "sortDirection" => ["except" => "asc"],
        "page" => ["except" => 1],
    ];

    public function mount($slug = null)
    {
        $this->categorySlug = null;
        $this->collectionSlug = null;
        $this->isItemView = false;

        if ($slug) {
            // primeiro verifica se existe uma Collection com esse slug
            $collection = Collection::where("slug", $slug)->first();
            $this->collection = $collection;
            if ($collection) {
                $this->isItemView = true;
                $this->collectionSlug = $slug;
            } else {
                // senão, tenta como Category (filtrar coleções por categoria)
                $category = Category::where("slug", $slug)->first();
                if ($category) {
                    $this->categorySlug = $slug;
                    $this->selectedCategoryId = $category->id;
                    $this->selectedCollectionCategories = [$category->id];
                }
            }
        }

        $this->allCategories = Category::where("type", "collection")->get();
        $this->allItemCategories = Category::where("type", "item")->get();
    }

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

    public function showItem($id)
    {
        $this->selectedItem = Item::findOrFail($id);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedItem = null;
    }

    public function startDownload($collectionId)
    {
        $user = Auth::user();

        if (!$user->hasActiveSubscription()) {
            $this->dispatch(
                "notify",
                message: "Você precisa de uma assinatura ativa para baixar coleções.",
            );
            return;
        }
        // Verifica se já existe um download pronto para este user + coleção
        $existingDownload = Download::where("user_id", $user->id)
            ->where("collection_id", $collectionId)
            ->where("status", "ready")
            ->first();

        if ($existingDownload) {
            $this->dispatch(
                "notify",
                message: "Você já tem este download disponível na sua página de downloads.",
            );
            return;
        }
        $download = Download::create([
            "user_id" => $user->id,
            "collection_id" => $collectionId,
            "status" => "pending",
        ]);

        ProcessDownload::dispatch($download);

        $this->dispatch(
            "notify",
            message: "Seu download foi iniciado! Vá até a página de downloads para acompanhar.",
        );
    }

    public function render()
    {
        if ($this->isItemView && $this->collectionSlug) {
            $collection = Collection::with([
                "items.categories",
                "categories",
                "author",
            ])
                ->where("slug", $this->collectionSlug)
                ->first();

            if (!$collection) {
                abort(404, "Coleção não encontrada");
            }

            $query = $collection
                ->items()
                ->with("categories")
                ->when(
                    $this->search,
                    fn($q) => $q->where("name", "like", "%{$this->search}%"),
                )
                ->when(
                    $this->selectedItemCategories,
                    fn($q) => $q->whereHas(
                        "categories",
                        fn($q2) => $q2->whereIn(
                            "categories.id",
                            $this->selectedItemCategories,
                        ),
                    ),
                )
                ->orderBy($this->sortField, $this->sortDirection);

            $items = $query->paginate(9);

            // Coleções relacionadas (mesmas categorias da coleção atual)
            $relatedCollections = Collection::whereHas("categories", function (
                $q,
            ) use ($collection) {
                $q->whereIn(
                    "categories.id",
                    $collection->categories->pluck("id"),
                );
            })
                ->where("id", "!=", $collection->id)
                ->limit(4)
                ->get();

            return view("livewire.app.collections.view-collection", [
                "collection" => $collection,
                "items" => $items,
                "relatedCollections" => $relatedCollections,
                "isItemView" => true,
            ])->title($this->collection->name);
        }
    }
}
