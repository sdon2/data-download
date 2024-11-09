<?php

namespace App\Http\Controllers\Download;

use App\Http\Controllers\Controller;
use App\Http\Requests\Download\SuppressionUploadRequest;
use App\Jobs\Download\SuppressionUploadJob;
use App\Models\SuppressionUpload;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

class SuppressionUploadController extends Controller
{
    public function index(Request $request)
    {
        $suppressionUploads = auth()->user()->suppression_uploads()->latest()->paginate(10);
        return view('download.suppression-upload', ['suppressionUploads' => $suppressionUploads]);
    }

    public function upload(SuppressionUploadRequest $request)
    {
        try {

            $input = $request->validated();

            $suppression_file_name = sprintf('%s_%s.txt', $input['type'], Carbon::now()->format('Y-m-d.H.i.s'));

            $upload = SuppressionUpload::create([
                'user_id' => auth()->id(),
                'type' => $input['type'],
                'offer_id' => $input['offer_id'],
                'filename' => $suppression_file_name,
            ]);

            $upload->addMediaFromRequest('suppression_file')
                ->usingFileName($suppression_file_name)
                ->toMediaCollection('suppression-uploads');

            dispatch(new SuppressionUploadJob($upload));

            return back()->with('success', 'Suppression uploaded successfully');

        } catch (Exception $e) {
            throw ValidationException::withMessages([
                'suppression_file' => [$e->getMessage()],
            ]);
        }
    }

    public function delete(SuppressionUpload $suppressionUpload)
    {
        try {

            if ($suppressionUpload->status != 'failed') {
                throw new Exception(sprintf("Suppression with status <b>'%s'</b> cannot be deleted", $suppressionUpload->status));
            }

            $suppressionUpload->delete();

            return back()->with('success', 'Suppression deleted successfully');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
