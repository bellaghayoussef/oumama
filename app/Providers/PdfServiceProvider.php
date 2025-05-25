<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\FormPdfService;
use Barryvdh\DomPDF\PDF;

class PdfServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(FormPdfService::class, function ($app) {
            return new FormPdfService($app->make(PDF::class));
        });

        $this->app->singleton(PDF::class, function ($app) {
            return new PDF();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
