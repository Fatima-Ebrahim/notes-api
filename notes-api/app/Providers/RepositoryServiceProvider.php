<?php

namespace App\Providers;

use App\Repositories\Interfaces\NoteRepositoryInterface;
use App\Repositories\NoteRepository;
use App\Services\Interfaces\NoteServiceInterface;
use App\Services\NoteService;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->bind(
            NoteRepositoryInterface::class,
            NoteRepository::class
        );

        $this->app->bind(
            NoteServiceInterface::class,
            NoteService::class
        );
    }

    public function boot(): void
    {

    }
}
