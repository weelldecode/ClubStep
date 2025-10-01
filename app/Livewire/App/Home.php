<?php

namespace App\Livewire\App;

use App\Models\Collection;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Home extends Component
{
    public $recomendadas;
    public $dosSeguidos;
    public $categorias;
    public $featuredArtists;
    public $perPage = 20;

    public function loadMore()
    {
        $this->perPage += 20;
    }
    public function mount()
    {
        $user = Auth::user();

        // Coleções recomendadas
        $this->recomendadas = Collection::with("user")
            ->latest()
            ->take(8)
            ->get();

        $this->featuredArtists = User::withCount("collections")
            ->orderByDesc("collections_count")
            ->take(8)
            ->get();

        if (Auth::check()) {
            // Coleções dos que você segue
            $this->dosSeguidos = Collection::with("user")
                ->whereIn("user_id", $user->following()->pluck("users.id"))
                ->latest()
                ->take(8)
                ->get();
        }
        // Por categorias (pegar até X categorias e coleções delas)
        $this->categorias = \App\Models\Category::with([
            "collections" => fn($q) => $q->with("user")->latest()->take(6),
        ])
            ->take(5)
            ->get();
    }

    public function render()
    {
        return view("livewire.app.home")->title("Pagina Inicial");
    }
}
