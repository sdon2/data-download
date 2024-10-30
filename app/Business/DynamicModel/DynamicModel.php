<?php

namespace App\Business\DynamicModel;

use Illuminate\Database\Eloquent\Model;

/**
 * https://github.com/laracraft-tech/laravel-dynamic-model
 */
class DynamicModel extends Model implements DynamicModelInterface
{
    /**
     * The standard DynamicModel is not guarded,
     * feel free to create your own dynamic model by using the BindsDynamically trait
     * and implementing the DynamicModelInterface!
     */
    protected $guarded = [];
}
