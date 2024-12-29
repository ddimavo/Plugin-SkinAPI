@extends('admin.layouts.admin')

@section('title', trans('skin-api::admin.capes.title'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="mb-3">
                <h5>{{ trans('skin-api::admin.api.title') }}</h5>
                <div class="card bg-dark text-white">
                    <div class="card-body">
                        <div class="mb-2">
                            <div>{{ trans('skin-api::admin.api.using_id') }}:</div>
                            <code>GET {{ url('/api/skin-api/capes/{user_id}') }}</code>
                        </div>

                        <div class="mb-2">
                            <div>{{ trans('skin-api::admin.api.using_username') }}:</div>
                            <code>GET {{ url('/api/skin-api/capes/{username}') }}</code>
                        </div>

                        <div class="mt-3">
                            {{ trans('skin-api::admin.api.usage_info') }}
                            <ul>
                                <li>{{ trans('skin-api::admin.api.replace_id') }}</li>
                                <li>{{ trans('skin-api::admin.api.replace_username') }}</li>
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
                        <label class="custom-control-label" for="showNavButton">{{ trans('skin-api::admin.capes.show_nav_button') }}</label>
                    </div>

                    @error('show_nav_button')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="showInProfile" name="show_in_profile" value="1" {{ old('show_in_profile', $show_in_profile) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="showInProfile">{{ trans('skin-api::admin.capes.show_in_profile') }}</label>
                    </div>

                    @error('show_in_profile')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="navIconInput">{{ trans('skin-api::admin.capes.nav_icon') }}</label>
                    <input type="text" class="form-control @error('nav_icon') is-invalid @enderror" id="navIconInput" name="nav_icon" value="{{ old('nav_icon', $nav_icon) }}">
                    <small class="form-text text-muted">{!! trans('skin-api::admin.capes.nav_icon_info') !!}</small>

                    @error('nav_icon')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="notFoundBehavior">{{ trans('skin-api::admin.capes.not_found_behavior') }}</label>
                    <select class="custom-select @error('not_found_behavior') is-invalid @enderror" id="notFoundBehavior" name="not_found_behavior">
                        <option value="skin_api_default" {{ old('not_found_behavior', $not_found_behavior ?? 'skin_api_default') === 'skin_api_default' ? 'selected' : '' }}>{{ trans('skin-api::admin.capes.not_found_default') }}</option>
                        <option value="error_message" {{ old('not_found_behavior', $not_found_behavior ?? 'skin_api_default') === 'error_message' ? 'selected' : '' }}>{{ trans('skin-api::admin.capes.not_found_error') }}</option>
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

            <h5>{{ trans('skin-api::admin.capes.current_default') }}</h5>
            @if(file_exists(plugin_path('skin-api').'/assets/img/cape.png'))
                <img src="{{ plugin_asset('skin-api', 'img/cape.png') }}" alt="Default Cape" class="img-fluid mb-3" style="max-width: 200px;">
            @else
                <p>{{ trans('skin-api::admin.capes.no_default') }}</p>
            @endif

            <form action="{{ route('skin-api.admin.capes.default') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="defaultCapeInput">{{ trans('skin-api::admin.capes.upload_default') }}</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input @error('default_cape') is-invalid @enderror" id="defaultCapeInput" name="default_cape" accept=".png">
                        <label class="custom-file-label" for="defaultCapeInput" data-browse="Browse">{{ trans('skin-api::admin.capes.upload_info') }}</label>

                        @error('default_cape')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <small class="form-text text-muted">{!! trans('skin-api::admin.capes.upload_info') !!}</small>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-upload"></i> {{ trans('messages.actions.upload') }}
                </button>

                @if(file_exists(plugin_path('skin-api').'/assets/img/cape.png'))
                    <div class="mt-3">
                        <form action="{{ route('skin-api.admin.capes.default.remove') }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash"></i> {{ trans('skin-api::admin.capes.remove_default') }}
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
        document.getElementById('defaultCapeInput').addEventListener('change', function(e) {
            var fileName = e.target.files[0].name;
            var label = document.querySelector('.custom-file-label');
            label.textContent = fileName;
        });
    </script>
@endpush
