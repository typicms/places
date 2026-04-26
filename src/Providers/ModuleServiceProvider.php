<?php

declare(strict_types=1);

namespace TypiCMS\Modules\Places\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Override;
use TypiCMS\Modules\Places\Composers\SidebarViewComposer;

class ModuleServiceProvider extends ServiceProvider
{
    #[Override]
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/places.php', 'typicms.modules.places');
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/places.php');

        $this->loadViewsFrom([
            resource_path('views/admin'),
            __DIR__.'/../../resources/views/admin',
        ], 'admin');

        $this->loadViewsFrom([
            resource_path('views/public'),
            __DIR__.'/../../resources/views/public',
        ], 'public');

        $this->publishes([
            __DIR__.'/../../database/migrations/create_places_table.php.stub' => getMigrationFileName(
                'create_places_table',
            ),
        ], 'typicms-migrations');
        $this->publishes([
            __DIR__.'/../../resources/views/admin/places' => resource_path('views/admin/places'),
        ], ['typicms-views', 'typicms-admin-views', 'typicms-admin-places-views']);
        $this->publishes([
            __DIR__.'/../../resources/views/public/places' => resource_path('views/public/places'),
        ], ['typicms-views', 'typicms-public-views', 'typicms-public-places-views']);
        $this->publishes([__DIR__.'/../../resources' => resource_path()], 'typicms-resources');
        $this->publishes([__DIR__.'/../../public' => public_path()], 'typicms-public');

        View::composer('admin::core._sidebar', SidebarViewComposer::class);

        /*
         * Add the page in the view.
         */
        View::composer('public::places.*', function ($view): void {
            $view->page = getPageLinkedToModule('places');
        });
    }
}
