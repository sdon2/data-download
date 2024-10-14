@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header bg-primary">
            <span class="card-title text-white">{{ __('Welcome') }}</span>
        </div>
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            {{ __('Welcome to Laravel!') }}
        </div>
    </div>
@endsection
