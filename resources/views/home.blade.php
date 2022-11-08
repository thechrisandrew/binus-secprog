@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">{{ __('Dashboard') }}
                        @guest
                        @else
                            <button class="btn btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">{{ __('Make a post') }}</button>
                        @endguest
                    </div>
                    <form method="POST" action="/add-post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">{{ __('Create a post') }}
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-floating">
                                            <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"
                                                name="message"></textarea>
                                            <label for="floatingTextarea2">{{ __('Share your thoughts') }}</label>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                        <button type="submit" class="btn btn-primary">{{ __('Post') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="card-body d-flex justify-content-center justify-content-lg-start flex-wrap">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @foreach ($posts as $post)
                            <div class="card" style="width: 18rem; margin: 1rem">
                                <div class="card-body">
                                    <img class="rounded-circle" src="{{ $post->user->avatar() }}" alt=""
                                        width="48px" height="48px">
                                    <h5 class="card-title">{{ $post->user->username }}</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">{{ $post->created_at }}</h6>
                                    <p class="card-text">{{ $post->message }}</p>
                                    <a href="{{ route('post', $post->id) }}" class="card-link">Check Post</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endsection
