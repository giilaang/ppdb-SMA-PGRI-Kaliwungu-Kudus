<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // View composer for frontend layouts and views
        view()->composer(['layouts.frontend', 'frontend.*'], function ($view) {
            $activeYear = \App\Models\AcademicYear::where('is_active', true)->first() 
                ?? \App\Models\AcademicYear::latest()->first();

            $ppdbSetting = null;
            $brochure = null;
            if ($activeYear) {
                $ppdbSetting = \App\Models\PpdbSetting::where('academic_year_id', $activeYear->id)->first();
                $brochure = \App\Models\Brochure::where('academic_year_id', $activeYear->id)
                    ->where('is_active', true)
                    ->first();
            }

            $contact = \App\Models\SchoolContact::first();

            $view->with(compact('activeYear', 'ppdbSetting', 'brochure', 'contact'));
        });
    }
}
