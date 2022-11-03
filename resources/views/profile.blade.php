@extends('layouts.app')

@section('content')
    {{-- UPLOAD IMAGE MODAL --}}
    <div class="modal fade" id="uploadImageModal" tabindex="-1" aria-labelledby="uploadImageModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Upload Image') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('profile.changeavatar') }}">
                    @csrf
                    <div class="modal-body">

                        <div class="row mb-3">
                            <label for="avatar"
                                class="col-form-label">{{ __('Avatar image must be less than 2MB') }}</label>

                            <div>
                                <input id="filepond" type="file" name="avatar">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-5">
                    <div class="card-body row">
                        <div class="col-12 col-md-auto">
                            <div class="mx-auto" style="width: 140px;">
                                <div class="d-flex justify-content-center align-items-center rounded"
                                    style="height: 140px;">
                                    <img class="rounded-circle" src="{{ Auth::user()->avatar() }}" alt=""
                                        height="100%">
                                </div>
                            </div>
                        </div>
                        <div class="col d-flex flex-column justify-content-center text-center text-md-start">
                            <div>
                                <h4 class="mb-1">John Smith</h4>
                                <p class="mb-1">{{ '@' . Auth::user()->username }}</p>
                                <p class="mb-0">Joined At: {{ Auth::user()->created_at->format('d-M-Y') }}</p>
                            </div>

                            <div class="mt-3 mb-3 mb-md-0">
                                <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                    data-bs-target="#uploadImageModal">
                                    <span>Change Avatar</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-5">
                    <div class="card-header">{{ __('Edit Profile') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('profile') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="username" class=" col-form-label">{{ __('Username') }}</label>

                                <div class="">
                                    <input id="username" type="text"
                                        class="form-control @error('username') is-invalid @enderror" name="username"
                                        value="{{ old('username') ? old('username') : Auth::user()->username }}"
                                        autocomplete="username" autofocus>

                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email" class="col-form-label">{{ __('Email Address') }}</label>

                                <div class="">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') ? old('email') : Auth::user()->email }}"
                                        autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Save Changes') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">{{ __('Change Password') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('home') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="password" class="col-form-label">{{ __('Current Password') }}</label>

                                <div class="">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required>

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="current-password" class="col-form-label">{{ __('New Password') }}</label>

                                <div class="">
                                    <input id="current-password" type="password"
                                        class="form-control @error('current-password') is-invalid @enderror"
                                        name="current-password" required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-4">
                                <label for="password-confirm" class="col-form-label">{{ __('Confirm Password') }}</label>

                                <div class="">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Change Password') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        // Get a reference to the file input element
        const inputElement = document.querySelector('input[id="filepond"]');

        FilePond.registerPlugin(FilePondPluginFileValidateSize);
        // Create a FilePond instance
        const options = {
            maxFileSize: '2048KB',
        }
        const pond = FilePond.create(inputElement, options);
        FilePond.setOptions({
            server: {
                url: '/upload',
                process: {
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    onerror: (response) => {
                        serverResponse = JSON.parse(response);
                    }
                }
            },
            labelFileProcessingError: () => {
                return serverResponse.avatar || "Internal Server Error";
            }
        })
    </script>
@endsection
