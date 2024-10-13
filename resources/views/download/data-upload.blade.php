@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Data Upload') }}</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" enctype="multipart/form-data" action="">
                        @csrf;
                        <div class="form-group row">
                            <div class="col-md-6">File</div>
                            <div class="col-md-6"><input type="file" name="data_file"></div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">ISP</div>
                            <div class="col-md-6">
                                <input type="text" name="isp">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">LIST ID</div>
                            <div class="col-md-6"><input type="text" name="list_id"></div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">Sub Seg Id</div>
                            <div class="col-md-6"><input type="text" name="sub_seg_id"></div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">Seg Id</div>
                            <div class="col-md-6"><input type="text" name="seg_id"></div>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection
