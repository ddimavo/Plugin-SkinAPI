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
                const label = document.getElementById('capeLabel');
                // Remove any existing content
                label.innerHTML = '';
                // Create a span for the filename
                const filenameSpan = document.createElement('span');
                filenameSpan.textContent = file.name;
                filenameSpan.className = 'file-name';
                label.appendChild(filenameSpan);
            }

            const reader = new FileReader();

            reader.onload = function (e) {
                // Remove existing preview elements
                while (previewContainer.firstChild) {
                    previewContainer.removeChild(previewContainer.firstChild);
                }

                // Create and add new preview image
                const preview = document.createElement('img');
                preview.src = e.target.result;
                preview.alt = '{{ trans('skin-api::messages.cape.current') }}';
                preview.id = 'capePreview';
                preview.className = 'img-fluid mx-auto d-block';
                preview.dataset.capePreview = '';
                previewContainer.appendChild(preview);
            };

            reader.readAsDataURL(file);
        });

        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            try {
                const formData = new FormData(form);
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const result = await response.json();

                if (!response.ok) {
                    throw new Error(result.message || 'An error occurred');
                }

                // Show success message
                const alert = document.createElement('div');
                alert.className = 'alert alert-success';
                alert.textContent = result.message;
                form.insertBefore(alert, form.firstChild);
                
                setTimeout(() => alert.remove(), 3000);

                // Reload the page after successful upload
                setTimeout(() => window.location.reload(), 1000);
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
            <input type="file" class="custom-file-input @error('cape') is-invalid @enderror" id="cape" name="cape" accept=".png" required>
            <label class="custom-file-label text-truncate" for="cape" id="capeLabel">
                {{ trans('skin-api::messages.actions.no-file') }}
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
