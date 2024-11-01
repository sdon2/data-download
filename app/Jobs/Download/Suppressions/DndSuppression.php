<?php

namespace App\Jobs\Download\Suppressions;

use App\Models\Download;
use Illuminate\Database\Eloquent\Builder;

class DndSuppression extends Suppression
{
    public function handle(Builder $dataQuery, Builder $suppressionQuery)
    {
        $download = $this->download;

        collect($suppressionQuery->pluck('data'))
            ->each(function ($suppression) use ($download, $dataQuery) {
                $result = $dataQuery->where('email', $suppression)->delete();
                if ($result) {
                    $download->update([
                        'suppressed_count' => $download->suppressed_count++,
                    ]);
                }
            });
    }
}
