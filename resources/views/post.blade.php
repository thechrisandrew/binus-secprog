@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div>
                            {{ __('KoboPosts') }}
                        </div>
                        @guest
                        @else
                            {{-- check if user owned post --}}
                            @if ($post->user_id == Auth::user()->id)
                                <form method="POST" action="{{ route('post.delete', ['id' => $post->id]) }}">
                                    @csrf
                                    {{ method_field('DELETE') }}
                                    <button class="btn btn-danger" type="submit">{{ __('Delete') }}</button>
                                </form>
                            @endif
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
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <img class="rounded-circle" src="{{ $post->user->avatar() }}" alt="" width="48px"
                            height="48px">
                        {{ $post->user->username }}
                        <br>
                        {{ $post->message }}
                        <br>
                        {{ $post->created_at }}
                        <br><br>
                        @guest
                        @else
                            <hr>
                            <form action="/comment" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" name="comment"
                                        style="height: 100px"></textarea>
                                    <label for="floatingTextarea2">{{ __('Leave a comment') }}</label>
                                    <br>
                                    <button class="btn btn-primary" type="submit">{{ __('Submit') }}</button>
                                </div>
                            </form>
                        @endguest
                    </div>
                </div>

                <div class="card mt-4">
                    @foreach ($comments as $comment)
                        <div class="card-body">
                            <img class="rounded-circle" src="{{ $comment->user->avatar() }}" alt="" width="48px"
                                height="48px">
                            {{ $comment->user->username }}
                            <br>
                            {{ $comment->comment }}
                            <br>
                            {{ $comment->created_at }}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
