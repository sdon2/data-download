<?php

namespace App\Http\Controllers\Download;

use App\Http\Controllers\Controller;
use App\Http\Requests\Download\DataDownloadRequest;
use App\Jobs\Download\DataDownloadJob;
use App\Models\Data;
use App\Models\DataDownload;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Traits\HasDataFileFunctions;

class DataDownloadController extends Controller
{
    use HasDataFileFunctions;

    public function index(Request $request)
    {
        $dataDownloads = auth()->user()->data_downloads()->latest()->paginate(10);
        return view('download.data-download', ['dataDownloads' => $dataDownloads]);
    }

    public function download(DataDownloadRequest $request)
    {
        $identifier = explode('.txt', $this->getDataFileName($request->isp, $request->list_id, $request->sub_seg_id, $request->seg_id))[0];

        try {

            $data = $request->validated();

            $data = [
                'user_id' => auth()->id(),
                'identifier' => $identifier,
                'suppressions' => $data['suppressions'],
                'offer_id' => $data['offer_id'],
            ];

            $download = DataDownload::create($data);

            dispatch(new DataDownloadJob($download));

            return back()->with('success', 'Data dowload added successfully');

        } catch (Exception $e) {
            throw ValidationException::withMessages([
                'data_file' => [$e->getMessage()],
            ]);
        }
    }

    public function delete(DataDownload $dataDownload)
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

    public function downloadFile(DataDownload $dataDownload)
    {
        try {
            $file = $dataDownload->getFirstMedia('downloads');
            return response()->download($file->getPath(), $file->file_name);
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
