<?php

/*
 * Fresns (https://fresns.org)
 * Copyright (C) 2021-Present Jevan Tang
 * Released under the Apache-2.0 License.
 */

namespace App\Models;

class File extends Model
{
    const TYPE_ALL = 1234;
    const TYPE_IMAGE = 1;
    const TYPE_VIDEO = 2;
    const TYPE_AUDIO = 3;
    const TYPE_DOCUMENT = 4;

    const TYPE_MAP = [
        File::TYPE_IMAGE => 'Image',
        File::TYPE_VIDEO => 'Video',
        File::TYPE_AUDIO => 'Audio',
        File::TYPE_DOCUMENT => 'Document',
    ];

    const TRANSCODING_STATE_WAIT = 1;
    const TRANSCODING_STATE_ING = 2;
    const TRANSCODING_STATE_DONE = 3;
    const TRANSCODING_STATE_FAILURE = 4;

    const WARNING_NONE = 1;
    const WARNING_NUDITY = 2;
    const WARNING_VIOLENCE = 3;
    const WARNING_SENSITIVE = 4;

    use Traits\FileServiceTrait;
    use Traits\IsEnabledTrait;
    use Traits\FsidTrait;

    protected $casts = [
        'more_info' => 'json',
    ];

    public function getFsidKey()
    {
        return 'fid';
    }

    public function getTypeKey()
    {
        return match ($this->type) {
            default => throw new \RuntimeException("unknown file type of {$this->type}"),
            File::TYPE_IMAGE => 'image',
            File::TYPE_VIDEO => 'video',
            File::TYPE_AUDIO => 'audio',
            File::TYPE_DOCUMENT => 'document',
        };
    }

    public function scopeType($query, int $type)
    {
        return $query->where('type', $type);
    }

    public function fileUsages()
    {
        return $this->hasMany(FileUsage::class);
    }

    public function isImage()
    {
        return $this->type === File::TYPE_IMAGE;
    }

    public function isVideo()
    {
        return $this->type === File::TYPE_VIDEO;
    }

    public function isAudio()
    {
        return $this->type === File::TYPE_AUDIO;
    }

    public function isDocument()
    {
        return $this->type === File::TYPE_DOCUMENT;
    }
}
