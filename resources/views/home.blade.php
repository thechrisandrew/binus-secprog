@include('utils.string')
@extends('layouts.app')

@section('content')
    <div class="container">

        @guest
        @else
            <div class="row justify-content-center">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            What's on your mind?
                        </div>
                        <div class="card-body">
                            <form method="POST" action={{ route('post.add') }}>
                                @csrf
                                <textarea class="form-control @error('message') is-invalid @enderror" placeholder="Leave a message here!" id="messageBox"
                                    style="height: 80px" name="message"></textarea>
                                @error('message')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div class="d-flex justify-content-end mb-2" id="messageBoxCounter">0/1024</div>
                                <div class="d-flex justify-content-end" style="gap: 0.5rem">
                                    <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endguest

        <div class="mt-3">
            @foreach ($posts->chunk(3) as $chunk)
                <div class="row gx-3">
                    @foreach ($chunk as $post)
                        <div class="col-lg-4 p-2">
                            <div class="card">
                                <div class="card-body p-4">
                                    <div class="d-flex flex-row align-items-center">
                                        <img class="rounded-circle" src="{{ $post->user->avatar() }}" alt=""
                                            width="36px" height="36px">
                                        <div class="p-2">
                                            <span>{{ $post->user->username }}</span>
                                        </div>
                                    </div>
                                    {{-- date --}}
                                    <div class="card-subtitle my-1 text-muted">
                                        <span>{{ $post->created_at->diffForHumans() }}</span>
                                    </div>

                                    <p class="mt-3" style="min-height:100px;">
                                        {{ cutString($post->message) }}
                                    </p>

                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('post', $post->id) }}" class="card-link">{{ __('Read More') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>

        <div class="mt-3">
            {{ $posts->links() }}
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('messageBox').onkeyup = function() {
            document.getElementById('messageBoxCounter').innerText = `${this.value.length}/1024`;

            // disable button if > 1024
            if (this.value.length > 1024) {
                document.querySelector('button[type="submit"]').disabled = true;
            } else {
                document.querySelector('button[type="submit"]').disabled = false;
            }
        };
    </script>
@endsection
