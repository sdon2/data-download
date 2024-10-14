@extends('layouts.app')

@section('title', 'Supression Upload')

@section('content')
    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary">
                    <div class="card-title text-white">
                        {{ __('Suppression Upload') }}
                    </div>
                </div>

                <div class="card-body pb-1">

                    @include('partials.messages')

                    <form method="POST" enctype="multipart/form-data" action="">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-6">Suppression File</div>
                            <div class="col-md-6">
                                <input type="file" name="suppression_file" accept=".txt" class="form-control" required>
                            </div>
                            @error('suppression_file')
                                <div class="mt-1 text-12 text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">Suppression Type</div>
                            <div class="col-md-6">
                                <select name="type" class="form-control select2" required>
                                    <option value="" {{ old('type') == '' ? 'selected' : '' }}>--SELECT</option>
                                    @foreach (config('data-download.suppression-types') as $type)
                                        <option value="{{ $type['value'] }}"
                                            {{ old('type') == $type['value'] ? 'selected' : '' }}>{{ $type['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('type')
                                    <div class="mt-1 text-12 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6 offset-md-6">
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
                        {{ __('Suppression Uploads') }}
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Type</th>
                                <th>Suppression File</th>
                                <th>Status</th>
                                <th>Records Processed</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($suppressionUploads as $suppressionUpload)
                                <tr>
                                    <td>{{ $suppressionUpload->id }}</td>
                                    <td>{{ $suppressionUpload->type }}</td>
                                    <td>{{ $suppressionUpload->filename }}</td>
                                    <td>
                                        <a href="#"
                                            title="{{ $suppressionUpload->status == 'failed' ? $suppressionUpload->error : '' }}"
                                            class="badge {{ ($suppressionUpload->status == 'failed'
                                                    ? 'bg-danger'
                                                    : $suppressionUpload->status == 'completed')
                                                ? 'bg-success'
                                                : 'bg-warning' }}">
                                            {{ ucfirst($suppressionUpload->status) }}
                                        </a>
                                    </td>
                                    <td>{{ $suppressionUpload->count }}</td>
                                    <td>{{ $suppressionUpload->created_at->diffForHumans() }}</td>
                                    <td>
                                        <a href="{{ route('download.suppression-upload.delete', $suppressionUpload->id) }}"
                                            class="text-danger"><i class="ion ion-close-circled" title="Delete"></i></a>
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
