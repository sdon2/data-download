@extends('layouts.app')

@section('title', 'Data Download')

@section('content')
    <div class="row justify-content-center mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary">
                    <div class="card-title text-white">
                        {{ __('Data Download') }}
                    </div>
                </div>

                <div class="card-body pb-1 overflow-x-scroll">

                    @include('partials.messages')

                    <form method="POST" enctype="multipart/form-data" action="">
                        @csrf
                        <div class="d-flex justify-content-center pb-2">
                            <div class="m-1 d-flex flex-column">
                                <div>ISP</div>
                                <div>
                                    <select name="isp" class="select2" style="width:200px" required>
                                        <option value="{{ old('isp') == '' ? 'selected' : '' }}">--SELECT</option>
                                        @foreach (config('data-download.isps') as $isp)
                                            <option value="{{ $isp['short_code'] }}"
                                              {{ old('isp') == $isp['short_code'] ? 'selected' : '' }}>{{ $isp['name'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('isp')
                                        <div class="mt-1 text-12 text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="m-1 d-flex flex-column">
                                <div>List Id</div>
                                <div>
                                    <input type="text" name="list_id" value="{{ old('list_id') }}" style="width:125px">
                                    @error('list_id')
                                        <div class="mt-1 text-12 text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="m-1 d-flex flex-column">
                                <div>Sub Seg Id</div>
                                <div>
                                    <input type="text" name="sub_seg_id" value="{{ old('sub_seg_id') }}" style="width:125px">
                                    @error('sub_seg_id')
                                        <div class="mt-1 text-12 text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="m-1 d-flex flex-column">
                                <div>Seg Id</div>
                                <div>
                                    <input type="text" name="seg_id" value="{{ old('seg_id') }}" style="width:125px">
                                    @error('seg_id')
                                        <div class="mt-1 text-12 text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="m-1 d-flex flex-column">
                                <div>
                                    <label>
                                        <input type="checkbox" name="suppressions[offer]" value="1" {{ old('suppressions.offer') ? 'checked' : '' }} />
                                        Offer
                                    </label>
                                </div>
                                <div>
                                    <input type="text" name="offer_id" value="{{ old('offer_id') }}" style="width:100px">
                                    @error('offer_id')
                                        <div class="mt-1 text-12 text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="m-1 d-flex flex-row">
                                <button type="submit" class="btn btn-primary m-1">Download</button>
                                <button type="reset" class="btn btn-danger m-1">Reset</button>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center pb-2">
                            @foreach (collect(config('data-download.suppression-types'))->where('value', '!=', 'offer') as $type)
                            <div class="m-1">
                                <label style="width:100px">
                                    <input type="checkbox" name="suppressions[{{ $type['value'] }}]"
                                    id="{{ $type['value'] }}" value="1"
                                    {{ old('suppressions.' . $type['value']) ? 'checked' : '' }} />
                                    {{ $type['name'] }}
                                </label>
                            </div>
                            @endforeach
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
                                    <td>{{ $dataDownload->created_at->diffForHumans() }}</td>
                                    <td>
                                        @if ($dataDownload->hasMedia('downloads'))
                                            <a href="{{ route('download.data-download.file', $dataDownload->id) }}"
                                                target="_blank" class="ion ion-android-download text-success"></a>
                                        @endif
                                        @if ($dataDownload->status == 'failed')
                                            <a href="{{ route('download.data-download.delete', $dataDownload->id) }}"
                                                class="text-danger"><i class="ion ion-close-circled" title="Delete"></i></a>
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
