<?php

declare(strict_types=1);

namespace Matchish\ScoutElasticSearch;

use Matchish\ScoutElasticSearch\ScoutElasticSearchServiceProvider;

final class LaravelElasticSearchServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'scout');

        Builder::macro('count', function () {
            return $this->engine()->getTotalCount(
                $this->engine()->search($this)
            );
        });
        
        $this->app->make(EngineManager::class)->extend(ElasticSearchEngine::class, function () {
            $elasticsearch = app(Client::class);

            return new ElasticSearchEngine($elasticsearch);
        });
        $this->registerCommands();
    }

    /**
     * {@inheritdoc}
     */
    public function register(): void
    {
        $this->app->register(ScoutServiceProvider::class);
        $this->app->bind(ImportSourceFactory::class, DefaultImportSourceFactory::class);
        $this->app->bind(
            'Matchish\ScoutElasticSearch\ElasticSearch\HitsIteratorAggregate',
            'Matchish\ScoutElasticSearch\ElasticSearch\EloquentHitsIteratorAggregate'
        );
    }

    /**
     * Register artisan commands.
     *
     * @return void
     */
    private function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ImportCommand::class,
                FlushCommand::class,
            ]);
        }
    }
}