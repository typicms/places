@push('js')
    <script type="module" src="{{ asset('components/ckeditor4/ckeditor.js') }}"></script>
    <script type="module" src="{{ asset('components/ckeditor4/config-full.js') }}"></script>
    <script>
        window.addEventListener('DOMContentLoaded', (event) => {
            document.getElementById('geocode-button').addEventListener('click', () => {
                const addressInput = document.getElementById('address');
                const address = addressInput.value;
                if (address !== '') {
                    getLonLatFromAddress(address);
                } else {
                    document.getElementById('latitude').value = '';
                    document.getElementById('longitude').value = '';
                }

                async function getLonLatFromAddress(address) {
                    const url = `https://nominatim.openstreetmap.org/?format=json&addressdetails=1&q=${address}&limit=1`;
                    try {
                        const response = await fetch(url);
                        if (response.ok) {
                            const data = await response.json();
                            if (data.length > 0) {
                                const info = data[0];
                                document.getElementById('latitude').value = info.lat;
                                document.getElementById('longitude').value = info.lon;
                            }
                        } else {
                            throw new Error('Network response was not ok.');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                    }
                }
            });
        });
    </script>
@endpush

<x-core::header :$model :back-url="$model->indexUrl()" :back-label="__('Places')" :default-title="__('New place')" />

<div class="form-body">
    <x-core::form-errors />

    <div class="row">
        <div class="col-lg-8">
            <x-core::title-and-slug-fields />
            <div class="mb-3">
                <x-transbootform::checkbox :label="__('Published')" name="status" :unchecked-value="0" />
            </div>

            <div class="row gx-3">
                <div class="col-sm-6"><x-bootform::email :label="__('Email')" name="email" autocomplete="off" /></div>
                <div class="col-sm-6"><x-bootform::text :label="__('Website')" name="website" placeholder="https://" /></div>
            </div>

            <div class="row gx-3">
                <div class="col-sm-6"><x-bootform::text :label="__('Phone')" name="phone" autocomplete="off" /></div>
            </div>

            <x-bootform::textarea :label="__('Address')" name="address" rows="4" autocomplete="off" />

            <div class="row gx-3">
                <div class="col-md-5"><x-bootform::text :label="__('Latitude')" name="latitude" /></div>
                <div class="col-md-5"><x-bootform::text :label="__('Longitude')" name="longitude" /></div>
                <div class="col-md-2">
                    <div class="mb-3">
                        <label class="form-label" for="geocode-button">&nbsp;</label>
                        <p class="mb-0">
                            <button class="btn btn-secondary w-100" id="geocode-button" type="button">Chercher</button>
                        </p>
                    </div>
                </div>
            </div>

            <x-transbootform::textarea :label="__('Summary')" name="summary" rows="4" />
            <x-core::tiptap-editors :model="$model" name="body" :label="__('Body')" />
        </div>
        <div class="col-lg-4">
            <div class="right-column">
                <file-manager></file-manager>
                <file-field type="image" field="image_id" :init-file="{{ $model->image ?? 'null' }}"></file-field>
                <file-field type="image" field="og_image_id" :init-file="{{ $model->ogImage ?? 'null' }}" label="@lang('Social Share Image')" hint="1200 × 630 px"></file-field>
                <files-field :init-files="{{ $model->files }}"></files-field>
            </div>
        </div>
    </div>
</div>
