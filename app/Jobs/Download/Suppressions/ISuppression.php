<?php

namespace App\Jobs\Download\Suppressions;

use Illuminate\Database\Eloquent\Builder;

interface ISuppression
{
    public function handle(Builder $dataQuery, Builder $suppressionQuery);
}
