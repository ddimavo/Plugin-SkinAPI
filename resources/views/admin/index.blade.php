@extends('admin.layouts.admin')

@section('title', trans('skin-api::admin.title'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <div>
                {{ trans('skin-api::admin.api.title') }} : <br>
                <div><code>GET {{ url('/api/skin-api/skins/{user_id}') }}</code> --> <img src="{{plugin_asset('skin-api', 'img/steve.png')}}" alt=""></div>
                <div><code>GET {{ url('/api/skin-api/avatars/combo/{user_id}') }}</code> (only from 64x64 skins) --> <img src="{{plugin_asset('skin-api', 'img/combo_steve.png')}}" alt=""></div>
                <div><code>GET {{ url('/api/skin-api/avatars/face/{user_id}') }}</code> (only from 64x64 skins) --> <img src="{{plugin_asset('skin-api', 'img/face_steve.png')}}" alt=""></div>
                <div>
                    <code>POST {{ url('/api/skin-api/skins/update') }}</code><br>
                    {{ trans('skin-api::admin.api.post_info') }} <br>
                    <code>{ "access_token" : "XXXX", "skin" : "IMAGE.PNG" }</code>
                </div>
                {{ trans('skin-api::admin.api.update_info') }} <code>{{ route('skin-api.home') }}</code>
            </div>

            <form method="POST">
                @csrf

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="widthInput">{{ trans('skin-api::admin.fields.width') }}</label>
                        <input type="text" class="form-control @error('width') is-invalid @enderror" id="widthInput" name="width" value="{{ old('width', $width) }}">
                        
                        @error('width')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="heightInput">{{ trans('skin-api::admin.fields.height') }}</label>
                        <input type="text" class="form-control @error('height') is-invalid @enderror" id="heightInput" name="height" value="{{ old('height', $height) }}">
                        
                        @error('height')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="scaleInput">{{ trans('skin-api::admin.fields.scale') }}</label>
                        <input type="text" class="form-control @error('scale') is-invalid @enderror" id="scaleInput" name="scale" value="{{ old('scale', $scale) }}">
                        
                        @error('scale')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="form-group col-md-12">
                        <label for="notFoundBehavior">{{ trans('skin-api::admin.fields.not_found_behavior') }}</label>
                        <select class="form-control @error('not_found_behavior') is-invalid @enderror" id="notFoundBehavior" name="not_found_behavior">
                            <option value="skin_api_default" {{ old('not_found_behavior', $not_found_behavior) === 'skin_api_default' ? 'selected' : '' }}>{{ trans('skin-api::admin.fields.not_found_options.skin_api_default') }}</option>
                            <option value="error_message" {{ old('not_found_behavior', $not_found_behavior) === 'error_message' ? 'selected' : '' }}>{{ trans('skin-api::admin.fields.not_found_options.error_message') }}</option>
                        </select>
                        
                        @error('not_found_behavior')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="form-group col-md-12">
                        <label for="navigationIcon">{{ trans('skin-api::admin.fields.navigation_icon') }}</label>
                        <input type="text" class="form-control @error('navigation_icon') is-invalid @enderror" id="navigationIcon" name="navigation_icon" value="{{ old('navigation_icon', $navigation_icon) }}">
                        <small class="form-text text-muted">{!! trans('skin-api::admin.fields.navigation_icon_help') !!}</small>

                        @error('navigation_icon')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
            </form>
        </div>
    </div>
@endsection
