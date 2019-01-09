<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Spatie\EventProjector\Projectionist;

class EventServiceProvider extends ServiceProvider
{
    public function boot()
    {
        parent::boot();

        /** @var \Spatie\EventProjector\Projectionist $projectionist */
        $projectionist = $this->app->get(Projectionist::class);

        $projectionist->addProjectors([
            \App\Domain\Source\Projectors\SourceProjector::class,
            \App\Domain\Post\Projectors\VoteProjector::class,
            \App\Domain\Post\Projectors\ViewProjector::class,
            \App\Domain\Post\Projectors\PostProjector::class,
            \App\Domain\Post\Projectors\TopicProjector::class,
            \App\Domain\Post\Projectors\TagProjector::class,
            \App\Domain\Mute\Projectors\MuteProjector::class,
        ]);
    }
}
