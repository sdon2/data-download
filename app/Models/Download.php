<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    use HasFactory;

    public $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getIdentifierAttribute()
    {
        return sprintf('%s_%s%s%s', $this->isp, $this->list_id, $this->sub_seg_id, $this->seg_id);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('downloads')
            ->useDisk('downloads')
            ->acceptsMimeTypes(['text/plain'])
            ->singleFile();
    }
}
