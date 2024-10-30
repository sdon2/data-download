<?php

namespace App\Jobs\Download\Suppressions;

use App\Models\Download;
use Illuminate\Database\Eloquent\Builder;

class OptOutSuppression implements ISuppression
{
    public function handle(Download $download, Builder $dataQuery, Builder $suppressionQuery)
    {
        $suppressionQuery
        ->get(['data'])
        ->each(function ($suppression) use ($download, $dataQuery) {
                list($emid, $offerId) = explode('|', $suppression->data);
                $result = $dataQuery->where('emid', $emid)->delete();
                if ($result) {
                    $download->update([
                        'suppression_count' => $download->suppression_count++,
                    ]);
                }
            });
    }
}
