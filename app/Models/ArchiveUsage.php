<?php

/*
 * Fresns (https://fresns.org)
 * Copyright (C) 2021-Present Jevan Tang
 * Released under the Apache-2.0 License.
 */

namespace App\Models;

class ArchiveUsage extends Model
{
    const TYPE_USER = 1;
    const TYPE_GROUP = 2;
    const TYPE_HASHTAG = 3;
    const TYPE_GEOTAG = 4;
    const TYPE_POST = 5;
    const TYPE_COMMENT = 6;
    const TYPE_POST_LOG = 7;
    const TYPE_COMMENT_LOG = 8;

    use Traits\IsEnabledTrait;

    public function getArchiveValueAttribute($value)
    {
        $value = match ($this->archive->api_type) {
            default => throw new \Exception("unknown archive type {$this->archive->api_type}"),
            'array', 'object', 'plugins' => json_decode($value, true) ?? [],
            'boolean' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            'number' => intval($value),
        };

        return $value;
    }

    public function setArchiveValueAttribute($value)
    {
        if (in_array($this->archive->api_type, ['array', 'plugins', 'object']) || is_array($value)) {
            if (! is_string($value)) {
                $value = json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
            }
        }

        if ($this->item_type == 'boolean') {
            $value = filter_var($value, FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false';
        }

        if ($this->item_type == 'number') {
            $value = intval($value);
        }

        $this->attributes['archive_value'] = $value;
    }

    public function scopeType($query, int $type)
    {
        return $query->where('usage_type', $type);
    }

    public function archive()
    {
        return $this->belongsTo(Archive::class, 'archive_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'usage_id', 'id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'usage_id', 'id');
    }

    public function hashtag()
    {
        return $this->belongsTo(Hashtag::class, 'usage_id', 'id');
    }

    public function geotag()
    {
        return $this->belongsTo(Geotag::class, 'usage_id', 'id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'usage_id', 'id');
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class, 'usage_id', 'id');
    }
}
