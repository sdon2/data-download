<?php

namespace App\Jobs\Download\Suppressions;

use App\Models\Download;
use Illuminate\Database\Eloquent\Builder;

abstract class Suppression implements ISuppression
{
    protected $download;

    public function __construct(Download $download)
    {
        if ($this->download) return;

        $this->download = $download;

        if ($download->data_count) return;

        $file = $download->getFirstMedia('downloads');
        if (!$file) return;

        $r = fopen($file, 'r');
        while (feof($r)) {
            $download->update([
                'data_count' => $download->data_count++,
            ]);
        }
    }
}
