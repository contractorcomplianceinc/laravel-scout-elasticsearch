<?php

declare(strict_types=1);

namespace Matchish\ScoutElasticSearch;

use Illuminate\Support\ServiceProvider;

final class LaravelElasticSearchServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function register(): void
    {
        $this->app->bind(
            'Matchish\ScoutElasticSearch\ElasticSearch\HitsIteratorAggregate',
            'Matchish\ScoutElasticSearch\ElasticSearch\EloquentHitsIteratorAggregate'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function boot(): void
    {

    }

    /**
     * {@inheritdoc}
     */
    public function provides(): array
    {

    }
}
