<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TempData extends Model
{
    protected $table = 'temp_data';

    private static $tableName = 'temp_data';

    protected $guarded = [];

    public $timestamps = false;

    public static function importData($sql)
    {
        (new static)->query()->truncate();

        DB::statement(sprintf('INSERT INTO `%s` (%s);', static::$tableName, $sql));
    }

    public static function exportTable($path)
    {
        $file = fopen($path, 'w');
        $query = (new static)->query();
        foreach ($query->get() as $entry) {
            fputs($file, $entry->join('|'));
        }
        fclose($file);
    }

    public static function truncateTable()
    {
        (new static)->query()->truncate();
    }
}
