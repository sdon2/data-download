<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class DataUpload extends Model implements HasMedia
{
    protected $guarded = [];

    public $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    use HasFactory, InteractsWithMedia;

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('data-uploads')
            ->useDisk('data-uploads')
            ->acceptsMimeTypes(['text/plain'])
            ->singleFile();
    }
}
