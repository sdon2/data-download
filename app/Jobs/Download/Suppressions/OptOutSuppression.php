<?php

namespace App\Jobs\Download\Suppressions;

use App\Models\DataDownload;
use Illuminate\Database\Eloquent\Builder;

class OptOutSuppression extends Suppression
{
    public function handle(Builder $dataQuery, Builder $suppressionQuery)
    {
        $download = $this->download;

        collect($suppressionQuery->pluck('data'))
        ->each(function ($suppression) use ($download, $dataQuery) {
                list($emid, $offerId) = explode('|', $suppression);
                $result = $dataQuery->where('emid', $emid)->delete();
                if ($result) {
                    $download->update([
                        'suppressed_count' => $download->suppressed_count++,
                    ]);
                }
            });
    }
}
