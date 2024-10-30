<?php

namespace App\Http\Controllers\Download;

use App\Http\Controllers\Controller;
use App\Http\Requests\Download\DataDownloadRequest;
use App\Jobs\Download\DownloadJob;
use App\Models\Data;
use App\Models\Download;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DataDownloadController extends Controller
{
    public function index(Request $request)
    {
        $identifiers = Data::query()->distinct()->get(['identifier'])->pluck('identifier');
        $dataDownloads = Download::query()->latest()->paginate(10);
        return view('download.data-download', ['dataDownloads' => $dataDownloads, 'identifiers' => $identifiers]);
    }

    public function download(DataDownloadRequest $request)
    {
        try {

            $input = $request->validated();

            $isp = collect(config('data-download.isps'))->firstWhere('value', $input['isp']);

            $isp = $isp['short_code'];

            $data_file_name = sprintf('%s_%s%s%s.txt', $isp, $input['list_id'], $input['sub_seg_id'], $input['seg_id']);

            $upload = Download::create([
                'isp' => $isp,
                'filename' => $data_file_name,
            ]);

            dispatch(new DownloadJob($upload));

            return back()->with('success', 'Data uploaded successfully');

        } catch (Exception $e) {
            throw ValidationException::withMessages([
                'data_file' => [$e->getMessage()],
            ]);
        }
    }

    public function delete(Download $dataDownload)
    {
        try {

            if ($dataDownload->status != 'failed') {
                throw new Exception(sprintf("Data with status <b>'%s'</b> cannot be deleted", $dataDownload->status));
            }

            $dataDownload->delete();

            return back()->with('success', 'Data deleted successfully');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
