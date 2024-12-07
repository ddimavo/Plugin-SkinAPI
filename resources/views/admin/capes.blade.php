@extends('admin.layouts.admin')

@section('title', trans('skin-api::admin.capes.title'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="mb-3">
                <h5>API Information</h5>
                <div class="card bg-dark text-white">
                    <div class="card-body">
                        <div class="mb-2">
                            <div>Using User ID:</div>
                            <code>GET {{ url('/api/skin-api/capes/{user_id}') }}</code>
                        </div>

                        <div class="mb-2">
                            <div>Using Username:</div>
                            <code>GET {{ url('/api/skin-api/capes/name/{username}') }}</code>
                        </div>

                        <div class="mt-3">
                            You can use either:
                            <ul>
                                <li>Replace {user_id} with the user's ID number</li>
                                <li>Replace {username} with the user's username</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('skin-api.admin.capes.update') }}" method="POST">
                @csrf

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="widthInput">{{ trans('skin-api::admin.fields.width') }}</label>
                        <input type="text" class="form-control @error('width') is-invalid @enderror" id="widthInput" name="width" value="{{ old('width', $width) }}">

                        @error('width')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="heightInput">{{ trans('skin-api::admin.fields.height') }}</label>
                        <input type="text" class="form-control @error('height') is-invalid @enderror" id="heightInput" name="height" value="{{ old('height', $height) }}">

                        @error('height')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="showNavButton" name="show_nav_button" value="1" {{ old('show_nav_button', $show_nav_button) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="showNavButton">Show Cape button in navigation</label>
                    </div>

                    @error('show_nav_button')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="showInProfile" name="show_in_profile" value="1" {{ old('show_in_profile', $show_in_profile) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="showInProfile">Show Cape in Profile</label>
                    </div>

                    @error('show_in_profile')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="navIconInput">Navigation Icon</label>
                    <input type="text" class="form-control @error('nav_icon') is-invalid @enderror" id="navIconInput" name="nav_icon" value="{{ old('nav_icon', $nav_icon) }}">
                    <small class="form-text text-muted">Enter a Bootstrap icon class (e.g., bi bi-person-circle). You can find icons at <a href="https://icons.getbootstrap.com/" target="_blank">Bootstrap Icons</a><br>Leave empty to hide the navigation icon</small>

                    @error('nav_icon')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="notFoundBehavior">When User Not Found</label>
                    <select class="custom-select @error('not_found_behavior') is-invalid @enderror" id="notFoundBehavior" name="not_found_behavior">
                        <option value="default_skin" {{ old('not_found_behavior', $not_found_behavior ?? 'default_skin') === 'default_skin' ? 'selected' : '' }}>Use Default Cape</option>
                        <option value="error_message" {{ old('not_found_behavior', $not_found_behavior ?? 'default_skin') === 'error_message' ? 'selected' : '' }}>Show Error Message</option>
                    </select>

                    @error('not_found_behavior')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
            </form>

            <hr>

            <h5 class="mt-4">Default Cape</h5>
            <form action="{{ route('skin-api.admin.capes.default') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="defaultCapeInput">Upload Default Cape</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input @error('default_cape') is-invalid @enderror" id="defaultCapeInput" name="default_cape" accept=".png">
                        <label class="custom-file-label" for="defaultCapeInput" data-browse="Browse">Choose file...</label>

                        @error('default_cape')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <small class="form-text text-muted">Upload a PNG file with dimensions {{ $width }}x{{ $height }} pixels</small>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-upload"></i> Upload Default Cape
                </button>

                @if(file_exists(plugin_path('skin-api').'/assets/img/cape.png'))
                    <div class="mt-3">
                        <p>Current default cape:</p>
                        <img src="{{ plugin_asset('skin-api', 'img/cape.png') }}" alt="Default Cape" class="img-fluid" style="max-width: 200px;">
                        
                        <form action="{{ route('skin-api.admin.capes.default.remove') }}" method="POST" class="d-inline mt-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash"></i> Remove Default Cape
                            </button>
                        </form>
                    </div>
                @endif
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Update file input label when file is selected
        document.getElementById('defaultCapeInput').addEventListener('change', function(e) {
            var fileName = e.target.files[0]?.name || 'Choose file...';
            var label = e.target.nextElementSibling;
            label.textContent = fileName;
        });
    </script>
@endpush
