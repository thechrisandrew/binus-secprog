@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @guest
                            <h5 class="card-title">{{ __('You are not logged in!') }}</h5>
                            <p class="card-text text-muted">{{ __('Please login to post something.') }}</p>
                        @else
                            <h5 class="card-title">{{ __('You are logged in as:') }} {{ Auth::user()->username }}</h5>
                            <p class="card-text text-muted">{{ __("What's on your mind?") }}</p>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
