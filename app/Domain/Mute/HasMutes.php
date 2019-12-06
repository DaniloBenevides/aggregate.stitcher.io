<?php

namespace Domain\Mute;

use Domain\Mute\Models\Mute;
use Domain\User\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasMutes
{
    public function mutes(): MorphMany
    {
        return $this->morphMany(
            Mute::class,
            'muteable',
            'muteable_type',
            'muteable_uuid',
            'uuid'
        );
    }

    public function scopeWhereNotMuted(Builder $builder, User $user): Builder
    {
        return $builder->whereDoesntHave('mutes', fn(Builder $builder) => $builder->whereUser($user));
    }

    public function scopeWhereMuted(Builder $builder, User $user): Builder
    {
        return $builder->whereHas('mutes', fn(Builder $builder) => $builder->whereUser($user));
    }
}
