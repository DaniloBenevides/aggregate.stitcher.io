<?php

namespace Domain\Post\Models;

use App\User\Controllers\TagMutesController;
use Domain\Model;
use Domain\Mute\HasMutes;
use Domain\Mute\Muteable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Support\Filterable;
use Support\HasSlug;
use Support\HasUuid;

class Tag extends Model implements Filterable, Muteable
{
    use HasUuid, HasMutes, HasSlug;

    protected $casts = [
        'keywords' => 'array',
    ];

    public function posts(): HasManyThrough
    {
        return $this->hasManyThrough(
            Post::class,
            PostTag::class,
            'tag_id',
            'id',
            'id',
            'post_id'
        );
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function scopeWhereTopic(Builder $builder, Topic $topic): Builder
    {
        return $builder->where('topic_id', $topic->id);
    }

    public function getFilterValue(): string
    {
        return $this->name;
    }

    public function getMuteableType(): string
    {
        return $this->getMorphClass();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMuteUrl(): string
    {
        return action([TagMutesController::class, 'store'], $this);
    }

    public function getUnmuteUrl(): string
    {
        return action([TagMutesController::class, 'delete'], $this);
    }

    public function getAllKeywords(): array
    {
        $keywords = $this->keywords;

        $keywords[] = $this->name;

        return $keywords;
    }
}
