<?php

use App\Http\Controllers\DownloadController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SubscriptionController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Livewire\Settings\Visibility;
use Livewire\Livewire;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        "prefix" => LaravelLocalization::setLocale(),
        "middleware" => [
            "localeSessionRedirect",
            "localizationRedirect",
            "localeViewPath",
        ],
    ],
    function () {
        Route::get("/", App\Livewire\App\Home::class)->name("home");
        Route::get("/billing", App\Livewire\App\Billing::class)->name(
            "billing",
        );
        Route::get("/plans", App\Livewire\App\Plans::class)->name("plans");

        Route::prefix("profile")
            ->name("profile.")
            ->group(function () {
                Route::get(
                    "/{user:slug}",
                    App\Livewire\App\Profile\Profile::class,
                )->name("user");
            });
        Route::get(
            "/downloads",
            App\Livewire\App\Downloads\Manager::class,
        )->name("download");
        Route::prefix("collection")
            ->name("collection.")
            ->group(function () {
                Route::get(
                    "/{slug?}",
                    App\Livewire\App\Collection\Index::class,
                )->name("index");
                Route::get(
                    "/v/{slug}",
                    App\Livewire\App\Collection\ViewCollection::class,
                )->name("view_collection");
            });

        Route::prefix("checkout")
            ->middleware(["auth", "verified", "subscription"])
            ->name("checkout.")
            ->group(function () {
                Route::get(
                    "/pay/renew/{id}/{sub_id}",
                    App\Livewire\App\Checkout\Renew::class,
                )->name("renew");
                Route::get(
                    "/pay/{id}",
                    App\Livewire\App\Checkout\Pay::class,
                )->name("index");

                // Rota POST para processar o pagamento
                Route::post("/process", [
                    PaymentController::class,
                    "index",
                ])->name("process");
                Route::post("/subscription", [
                    SubscriptionController::class,
                    "renew",
                ])->name("subscription");
            });

        Route::redirect("settings", "settings/profile");
        Route::prefix("settings")
            ->middleware(["auth", "verified"])
            ->name("settings.")
            ->group(function () {
                Route::get("/profile", Profile::class)->name("profile");
                Route::get("/visibility", Visibility::class)->name(
                    "visibility",
                );
                Route::get("/password", Password::class)->name("password");
                Route::get("/appearance", Appearance::class)->name(
                    "appearance",
                );
            });
        Livewire::setUpdateRoute(function ($handle) {
            return Route::post("/livewire/update", $handle);
        });

        Route::prefix("studio")
            ->name("studio.")
            ->middleware(["auth", "verified", "admin"])
            ->group(function () {
                Route::get("/", App\Livewire\Studio\Dashboard::class)->name(
                    "dashboard",
                );
            });
    },
);

require __DIR__ . "/auth.php";
