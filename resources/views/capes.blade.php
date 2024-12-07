@extends('layouts.app')

@section('title', trans('skin-api::messages.cape.title'))

@section('content')
    <div class="container content">
        <div class="card shadow-sm">
            <div class="card-header">
                <h2 class="card-header-title">{{ trans('skin-api::messages.cape.management') }}</h2>
            </div>
            <div class="card-body">
                @if($hasCape)
                    <div class="text-center mb-4 cape-preview">
                        <h4>{{ trans('skin-api::messages.cape.current') }}</h4>
                        <img src="{{ $capeUrl }}" 
                             alt="Current cape" 
                             class="img-fluid"
                             width="384"
                             height="192"
                             style="image-rendering: pixelated; background-color: #f8f9fa; padding: 10px; border: 1px solid #dee2e6;">
                    </div>
                @endif

                <form action="{{ route('skin-api.capes.upload') }}" 
                      method="POST" 
                      enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label" for="capeInput">
                            {{ trans('skin-api::messages.cape.upload.title') }}
                        </label>
                        <div class="custom-file">
                            <input type="file" 
                                   class="custom-file-input @error('cape') is-invalid @enderror" 
                                   id="capeInput" 
                                   name="cape" 
                                   accept="image/png">
                            <label class="custom-file-label" for="capeInput" data-browse="{{ trans('skin-api::messages.actions.browse') }}">
                                {{ trans('skin-api::messages.actions.no-file') }}
                            </label>
                            
                            @error('cape')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            
                            <div class="form-text">
                                {{ trans('skin-api::messages.cape.upload.requirements', ['width' => setting('skin.cape_width', 64), 'height' => setting('skin.cape_height', 32)]) }}
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-upload"></i> {{ trans('skin-api::messages.cape.upload.submit') }}
                    </button>
                </form>

                @if($hasCape)
                    <hr>
                    <form action="{{ route('skin-api.capes.delete') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash"></i> {{ trans('skin-api::messages.cape.delete.submit') }}
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('capeInput').addEventListener('change', function(e) {
            var fileName = e.target.files[0] ? e.target.files[0].name : '{{ trans('skin-api::messages.actions.no-file') }}';
            var label = e.target.nextElementSibling;
            label.textContent = fileName;
        });
    </script>
@endpush
