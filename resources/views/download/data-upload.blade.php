@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary">
                    <div class="card-title text-white">
                        {{ __('Data Upload') }}
                    </div>
                </div>

                <div class="card-body">

                    @include('partials.messages')

                    <form method="POST" enctype="multipart/form-data" action="">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-6">Data File</div>
                            <div class="col-md-6">
                                <input type="file" name="data_file" accept=".txt" class="form-control" required>
                            </div>
                            @error('data_file')
                                <div class="mt-1 text-12 text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">ISP</div>
                            <div class="col-md-6">
                                <select name="isp" class="form-control select2" required>
                                    <option value="" {{ old('isp') == '' ? 'selected' : '' }}>--SELECT</option>
                                    @foreach (config('data-download.isps') as $isp)
                                        <option value="{{ $isp['value'] }}"
                                            {{ old('isp') == $isp['value'] ? 'selected' : '' }}>{{ $isp['name'] }}</option>
                                    @endforeach
                                </select>
                                @error('isp')
                                    <div class="mt-1 text-12 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">LIST ID</div>
                            <div class="col-md-6"><input type="text" name="list_id" class="form-control"
                                    value="{{ old('list_id') }}">
                                @error('list_id')
                                    <div class="mt-1 text-12 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">Sub Seg Id</div>
                            <div class="col-md-6"><input type="text" name="sub_seg_id" class="form-control"
                                    value="{{ old('sub_seg_id') }}">
                                @error('sub_seg_id')
                                    <div class="mt-1 text-12 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">Seg Id</div>
                            <div class="col-md-6"><input type="text" name="seg_id" class="form-control"
                                    value="{{ old('seg_id') }}">
                                @error('seg_id')
                                    <div class="mt-1 text-12 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Upload</button>
                                <button type="reset" class="btn btn-danger">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary">
                    <div class="card-title text-white">
                        {{ __('Data Uploads') }}
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>ISP</th>
                                <th>Data File</th>
                                <th>Status</th>
                                <th>Records Processed</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dataUploads as $dataUpload)
                                <tr>
                                    <td>{{ $dataUpload->id }}</td>
                                    <td>{{ $dataUpload->isp }}</td>
                                    <td>{{ $dataUpload->filename }}</td>
                                    <td>
                                        <a href="#"
                                            title="{{ $dataUpload->status == 'failed' ? $dataUpload->error : '' }}"
                                            class="badge {{ ($dataUpload->status == 'failed'
                                                    ? 'bg-danger'
                                                    : $dataUpload->status == 'completed')
                                                ? 'bg-success'
                                                : 'bg-warning' }}">
                                            {{ ucfirst($dataUpload->status) }}
                                        </a>
                                    </td>
                                    <td>{{ $dataUpload->count }}</td>
                                    <td>{{ $dataUpload->created_at->diffForHumans() }}</td>
                                    <td>
                                        @if ($dataUpload->status == 'failed')
                                            <a href="{{ route('download.data-upload.delete', $dataUpload->id) }}"
                                                class="btn btn-sm btn-danger">Delete</a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No Data Uploads</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endsection
