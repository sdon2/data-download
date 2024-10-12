<?php

namespace App\Http\Controllers\Download;

use App\Http\Controllers\Controller;
use App\Http\Requests\Requests\Download\DataUploadRequest;
use Illuminate\Http\Request;

class DataUploadController extends Controller
{
    public function index(Request $request)
    {
        return view('download.data-upload');
    }

    public function upload(DataUploadRequest $request)
    {
        dd($request->validated());
    }
}
