<?php

namespace App\Traits;

use App\Business\DynamicModel\DynamicModel;
use App\Business\DynamicModel\DynamicModelFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

trait InteractsWithTempTable
{
    private $identifier;

    public function createTable($identifier, $sql)
    {
        $this->identifier = $identifier;
        $sql = sprintf("CREATE TABLE IF NOT EXISTS `%s` (%s);", $this->getTableName(), $sql);

        if(DB::statement($sql)) {
            return $this->getTableName();
        } else {
            return false;
        }
    }

    public function getTableName()
    {
        return $this->identifier;
    }

    public function deleteTable()
    {
        $sql = sprintf("DROP TABLE IF EXISTS `%s`;", $this->getTableName());
        return DB::statement($sql);
    }

    public function getModel(): Model
    {
        return app(DynamicModelFactory::class)->create(DynamicModel::class, $this->getTableName());
    }
}
