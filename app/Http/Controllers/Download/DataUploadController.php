<?php

namespace App\Http\Controllers\Download;

use App\Http\Controllers\Controller;
use App\Http\Requests\Download\DataUploadRequest;
use App\Jobs\Download\DataUploadJob;
use App\Models\DataUpload;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DataUploadController extends Controller
{
    public function index(Request $request)
    {
        $dataUploads = DataUpload::query()->latest()->paginate(10);
        return view('download.data-upload', ['dataUploads' => $dataUploads]);
    }

    public function upload(DataUploadRequest $request)
    {
        try {

            $input = $request->validated();

            $isp = collect(config('data-download.isps'))->firstWhere('value', $input['isp']);

            $isp = $isp['short_code'];

            $data_file_name = sprintf('%s_%s%s%s.txt', $isp, $input['list_id'], $input['sub_seg_id'], $input['seg_id']);

            $upload = DataUpload::create([
                'isp' => $isp,
                'filename' => $data_file_name,
            ]);

            $upload->addMediaFromRequest('data_file')
                ->usingFileName($data_file_name)
                ->toMediaCollection('data-uploads');

            dispatch(new DataUploadJob($upload));

            return back()->with('success', 'Data uploaded successfully');

        } catch (Exception $e) {
            throw ValidationException::withMessages([
                'data_file' => [$e->getMessage()],
            ]);
        }
    }

    public function delete(DataUpload $dataUpload)
    {
        try {

            if ($dataUpload->status != 'failed') {
                throw new Exception('Data cannot be deleted');
            }

            $dataUpload->delete();

            return back()->with('success', 'Data deleted successfully');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
