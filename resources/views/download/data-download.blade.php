@extends('layouts.app')

@section('title', 'Data Download')

@section('content')
    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary">
                    <div class="card-title text-white">
                        {{ __('Data Download') }}
                    </div>
                </div>

                <div class="card-body pb-1">

                    @include('partials.messages')

                    <form method="POST" enctype="multipart/form-data" action="">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-6">Suppressions To Run On</div>
                            <div class="col-md-6">
                                <select name="identifier" class="form-control select2" required>
                                    <option value="" {{ old('identifier') == '' ? 'selected' : '' }}>--SELECT</option>
                                    @foreach ($identifiers as $identifier)
                                        <option value="{{ $identifier }}"
                                            {{ old('identifier') == $identifier ? 'selected' : '' }}>{{ $identifier }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('identifier')
                                    <div class="mt-1 text-12 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">Offer Suppression</div>
                            <div class="col-md-6">
                                <div class="d-flex">
                                    <div>
                                        <input type="checkbox" name="suppressions[offer]" value="1"
                                            {{ old('suppressions.offer') ? 'checked' : '' }}>
                                    </div>
                                    <div class="form-check">
                                        <input type="text" name="offer_id" class="form-control"
                                            value="{{ old('offer_id') }}">
                                        @error('offer_id')
                                            <div class="mt-1 text-12 text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        @foreach (collect(config('data-download.suppression-types'))->where('value', '!=', 'offer') as $type)
                            <div class="form-group row">
                                <div class="col-md-6">{{ $type['name'] }} Suppression</div>
                                <div class="col-md-6">
                                    <input type="checkbox" name="suppressions[{{ $type['value'] }}]"
                                        id="{{ $type['value'] }}" value="1"
                                        {{ old('suppressions.' . $type['value']) ? 'checked' : '' }}>
                                </div>
                            </div>
                        @endforeach
                        <div class="form-group row">
                            <div class="col-md-6 offset-md-6">
                                <button type="submit" class="btn btn-primary">Download</button>
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
                        {{ __('Data Downloads') }}
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Identifier</th>
                                <th>Suppressions</th>
                                <th>Status</th>
                                <th>Count</th>
                                <th>Suppressed</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dataDownloads as $dataDownload)
                                <tr>
                                    <td>{{ $dataDownload->id }}</td>
                                    <td>{{ $dataDownload->identifier }}</td>
                                    <td>{{ collect($dataDownload->suppressions)->keys()->join(', ') }}</td>
                                    <td>
                                        <a href="#"
                                            title="{{ $dataDownload->status == 'failed' ? $dataDownload->error : '' }}"
                                            class="badge {{ $dataDownload->status == 'failed' ? 'bg-danger' : ($dataDownload->status == 'completed' ? 'bg-success' : 'bg-warning') }}">
                                            {{ ucfirst($dataDownload->status) }}
                                        </a>
                                    </td>
                                    <td>{{ $dataDownload->data_count }}</td>
                                    <td>{{ $dataDownload->suppressed_count }}</td>
                                    <td></td>
                                    <td>
                                        @if ($dataDownload->hasMedia('downloads'))
                                            <a href="{{ route('download.data-download.file', $dataDownload->id) }}"
                                                target="_blank" class="ion ion-android-download text-success"></a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No Data Downloads</td>
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
    <link href="{{ asset('vendor/select2/css/select2.min.css') }}" rel="stylesheet" />
@endsection

@section('scripts')
    <script src="{{ asset('vendor/select2/js/select2.min.js') }}" defer></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endsection
