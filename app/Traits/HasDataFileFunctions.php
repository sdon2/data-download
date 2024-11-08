<?php

namespace App\Traits;

trait HasDataFileFunctions
{
	public function getDataFileName($isp, $list_id, $seg_id, $sub_seg_id)
	{
		return sprintf('%s_%s%s%s.txt', $isp, $list_id, $seg_id, $sub_seg_id);
	}

	public function getIsp($filename)
	{
		return explode('_', $filename)[0];
	}
}