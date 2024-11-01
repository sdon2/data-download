<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Download extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = [];

    public $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'suppressions' => 'array',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('downloads')
            ->useDisk('downloads')
            ->acceptsMimeTypes(['text/plain'])
            ->singleFile();
    }
}
