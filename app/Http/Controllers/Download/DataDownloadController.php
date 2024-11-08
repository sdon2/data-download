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
use App\Traits\HasDataFileFunctions;

class DataDownloadController extends Controller
{
    use HasDataFileFunctions;

    public function index(Request $request)
    {
        $dataDownloads = Download::query()->latest()->paginate(10);
        return view('download.data-download', ['dataDownloads' => $dataDownloads]);
    }

    public function download(DataDownloadRequest $request)
    {
        $identifier = explode('.txt', $this->getDataFileName($request->isp, $request->list_id, $request->sub_seg_id, $request->seg_id))[0];

        try {

            $data = $request->validated();

            $data = [
                'identifier' => $identifier,
                'suppressions' => $data['suppressions'],
                'offer_id' => $data['offer_id'],
            ];

            $download = Download::create($data);

            dispatch(new DownloadJob($download));

            return back()->with('success', 'Data dowload added successfully');

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

    public function downloadFile(Download $dataDownload)
    {
        try {
            $file = $dataDownload->getFirstMedia('downloads');
            return response()->download($file->getPath(), $file->file_name);
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
