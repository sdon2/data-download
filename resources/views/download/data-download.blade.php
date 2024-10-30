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
                                        <input type="checkbox" name="offer_suppression" id="offer_suppression"
                                            {{ old('offer_suppression') ? 'checked' : '' }}>
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
                        <div class="form-group row">
                            <div class="col-md-6">Opt Out Suppression</div>
                            <div class="col-md-6">
                                <input type="checkbox" name="optout_suppression" id="optout_suppression"
                                    {{ old('optout_suppression') ? 'checked' : '' }}>
                            </div>
                        </div>
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
                                <th>ISP</th>
                                <th>Data File</th>
                                <th>Status</th>
                                <th>Records Processed</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dataDownloads as $dataDownload)
                                //
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No Data Downloads</td>
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
