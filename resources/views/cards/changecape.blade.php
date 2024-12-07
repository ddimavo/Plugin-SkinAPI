@push('styles')
    <style>
        #capePreview {
            width: 250px;
            image-rendering: crisp-edges; /* Firefox */
            image-rendering: pixelated; /* Chrome and Safari */
        }
    </style>
@endpush

@push('footer-scripts')
    <script>
        const capeInput = document.getElementById('cape');
        const form = document.querySelector('form');
        const previewContainer = document.getElementById('previewContainer');
        const removeCapeButton = document.getElementById('removeCapeButton');

        if (removeCapeButton) {
            removeCapeButton.addEventListener('click', function() {
                // Create a form to submit the delete request
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('skin-api.capes.delete') }}';
                
                // Add CSRF token
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                // Add method spoofing for DELETE
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';
                form.appendChild(methodField);

                // Submit the form
                document.body.appendChild(form);
                form.submit();
            });
        }

        capeInput.addEventListener('change', function () {
            if (!capeInput.files || !capeInput.files[0]) {
                return;
            }

            const file = capeInput.files[0];

            if (file.name !== undefined && file.name !== '') {
                document.getElementById('capeLabel').innerText = file.name;
            }

            const reader = new FileReader();

            reader.onload = function (e) {
                // Remove existing content (either message or image)
                previewContainer.innerHTML = '';
                
                // Create and add new preview image
                const preview = document.createElement('img');
                preview.id = 'capePreview';
                preview.src = e.target.result;
                preview.alt = '{{ trans('skin-api::messages.cape.current') }}';
                preview.className = 'img-fluid mx-auto d-block';
                preview.setAttribute('data-cape-preview', '');
                preview.style.width = '250px';
                preview.style.imageRendering = 'pixelated';
                
                previewContainer.appendChild(preview);
            };

            reader.readAsDataURL(file);
        });

        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin'
                });

                const data = await response.json();
                
                if(response.ok) {
                    window.location.reload();
                } else {
                    throw new Error(data.message || 'An error occurred while uploading the cape');
                }
            } catch (error) {
                // Show error message
                const alert = document.createElement('div');
                alert.className = 'alert alert-danger';
                alert.textContent = error.message || 'An error occurred while uploading the cape';
                form.insertBefore(alert, form.firstChild);
                
                setTimeout(() => alert.remove(), 3000);
            }
        });
    </script>
@endpush

<form action="{{ route('skin-api.capes.upload') }}" method="POST" enctype="multipart/form-data" data-turbolinks="false">
    @csrf

    <div class="mb-3">
        <label for="cape">{{ trans('skin-api::messages.cape.current') }}</label>
        <div id="previewContainer" class="mt-3">
            @if(Storage::disk('public')->exists('capes/' . auth()->user()->id . '.png'))
                <img src="{{ route('skin-api.api.showCape', auth()->user()->name) }}?t={{ time() }}" alt="{{ trans('skin-api::messages.cape.current') }}" id="capePreview" class="img-fluid mx-auto d-block" data-cape-preview>
            @else
                <div id="noCapeMessage" class="alert alert-info text-center">{{ trans('skin-api::messages.cape.no_cape') }}</div>
            @endif
        </div>
    </div>

    <div class="mb-3">
        <div class="custom-file">
            <input type="file" class="form-control @error('cape') is-invalid @enderror" id="cape" name="cape" accept=".png" required>
            <label class="custom-file-label" for="cape" id="capeLabel" data-browse="{{ trans('messages.actions.browse') }}">
                {{ trans('messages.actions.choose-file') }}
            </label>

            @error('cape')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-upload"></i> {{ trans('skin-api::messages.cape.upload.submit') }}
        </button>

        @if(Storage::disk('public')->exists('capes/' . auth()->user()->id . '.png'))
            <button type="button" class="btn btn-danger" id="removeCapeButton">
                <i class="bi bi-trash"></i> {{ trans('skin-api::messages.cape.delete.submit') }}
            </button>
        @endif
    </div>
</form>

<!-- Remove Cape Modal -->
<div class="modal fade" id="removeCapeModal" tabindex="-1" role="dialog" aria-labelledby="removeCapeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="removeCapeModalLabel">{{ trans('skin-api::messages.cape.delete.title') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ trans('messages.confirm-action') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('messages.actions.cancel') }}</button>
                <form action="{{ route('skin-api.capes.delete') }}" method="POST" class="d-inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">{{ trans('skin-api::messages.cape.delete.submit') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
