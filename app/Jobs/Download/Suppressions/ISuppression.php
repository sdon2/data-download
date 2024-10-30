<?php

namespace App\Jobs\Download\Suppressions;

use App\Models\Download;
use Illuminate\Database\Eloquent\Builder;

interface ISuppression
{
    public function handle(Download $download, Builder $dataQuery, Builder $suppressionQuery);
}
