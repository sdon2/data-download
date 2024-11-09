<?php

namespace App\Jobs\Download\Suppressions;

use App\Models\DataDownload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class OfferSuppression extends Suppression
{
    public function handle(Builder $dataQuery, Builder $suppressionQuery)
    {
        $download = $this->download;

        collect($suppressionQuery->pluck('data'))
            ->each(function ($suppression) use ($download, $dataQuery) {
                $result = $dataQuery->whereRaw('MD5(email) = ?', [$suppression])->delete();
                if ($result) {
                    $download->update([
                        'suppressed_count' => $download->suppressed_count++,
                    ]);
                }
            });
    }
}
