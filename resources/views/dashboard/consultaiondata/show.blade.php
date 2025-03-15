@extends('partials.dashboard.master')
@section('content')
    <!-- begin :: Subheader -->
    <div class="toolbar">

        <div class="container-fluid d-flex flex-stack">

            <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">

                <!-- begin :: Title -->
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1"><a
                        href="{{ route('dashboard.consultation_time.index') }}"
                        class="text-muted text-hover-primary">{{ __('Consultations') }}</a></h1>
                <!-- end   :: Title -->

                <!-- begin :: Separator -->
                <span class="h-20px border-gray-300 border-start mx-4"></span>
                <!-- end   :: Separator -->

                <!-- begin :: Breadcrumb -->
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <!-- begin :: Item -->
                    <li class="breadcrumb-item text-muted">
                        {{ __('Edit an consultation') }}
                    </li>
                    <!-- end   :: Item -->
                </ul>
                <!-- end   :: Breadcrumb -->

            </div>

        </div>

    </div>
    <!-- end   :: Subheader -->

    <div class="card">
        <!-- begin :: Card body -->
        <div class="card-body p-0">
            <!-- begin :: Form -->
            <form action="{{ route('dashboard.consultation_time.update', $consultaion->id) }}" class="form" method="post"
                id="submitted-form" data-redirection-url="{{ route('dashboard.consultation_time.index') }}">
                @csrf
                @method('PUT')
                <!-- begin :: Card header -->
                <div class="card-header d-flex align-items-center">
                    <h3 class="fw-bolder text-dark">{{ __('Edit an consultaion') . ' : ' . $consultaion->title }}</h3>
                </div>
                <!-- end   :: Card header -->
                <!-- begin :: Inputs wrapper -->
                <div class="inputs-wrapper">
                    <!-- begin :: Row -->
                    <div class="row mb-10">

                        <!-- begin :: Column -->
                        <div class="col-md-12 fv-row d-flex justify-content-evenly">

                            <div class="d-flex flex-column align-items-center">
                                <!-- begin :: Upload image component -->
                                <label class="text-center fw-bold mb-4">{{ __('Image') }}</label>
                                <div>
                                    <x-dashboard.upload-image-inp name="main_image" :image="$consultaion['main_image']"
                                        directory="Consultations" placeholder="default.jpg"
                                        type="show"></x-dashboard.upload-image-inp>
                                </div>
                                <p class="invalid-feedback" id="main_image"></p>
                                <!-- end   :: Upload image component -->
                            </div>


                        </div>
                        <!-- end   :: Column -->

                    </div>
                    <!-- end   :: Row -->

                    <div class="row mb-8">

                        <!-- begin :: Column -->
                        <div class="col-md-3 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('Title in arabic') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="title_ar_inp" name="title_ar"
                                    placeholder="example" value="{{ $consultaion->title_ar }}" readonly />
                                <label for="title_ar_inp">{{ __('Enter the book title') }}</label>
                            </div>
                            <p class="invalid-feedback" id="title_ar"></p>
                        </div>
                        <!-- begin :: Column -->
                        <div class="col-md-3 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('Title in english') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="title_en_inp" name="title_en"
                                    placeholder="example" value="{{ $consultaion->title_en }}" readonly />
                                <label for="title_en_inp">{{ __('Enter the book title') }}</label>
                            </div>
                            <p class="invalid-feedback" id="title_en"></p>


                        </div>
                        <div class="col-md-3 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('Price') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="price_inp" name="price"
                                    placeholder="example" value="{{ $consultaion->price }}" readonly />
                                <label for="price_inp">{{ __('Enter the book price') }}</label>
                            </div>
                            <p class="invalid-feedback" id="price"></p>


                        </div>

                        <div class="col-md-3 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('consultatio type') }}</label>
                            <select class="form-select" data-control="select2" name="consultaion_type_id"
                                id="consultatio-type-sp" data-placeholder="{{ __('consultatio type') }}"
                                data-dir="{{ isArabic() ? 'rtl' : 'ltr' }}" disabled>
                                <option value=""></option>
                                @if (isset($types))
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}"
                                            {{ $consultaion->consultaion_type_id == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <p class="invalid-feedback" id="consultaion_type_id"></p>
                        </div>



                    </div>


                    <!-- begin :: Row -->
                    <div class="row mb-10">

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('Description in arabic') }}</label>
                            <textarea class="form-control" rows="4" name="description_ar" id="meta_tag_description_ar_inp" readonly>{{ $consultaion->description_ar }}</textarea>
                            <p class="text-danger invalid-feedback" id="description_ar"></p>


                        </div>
                        <!-- end   :: Column -->

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('Description in english') }}</label>
                            <textarea class="form-control" rows="4" name="description_en" id="meta_tag_description_en_inp" readonly>{{ $consultaion->description_en }}</textarea>
                            <p class="text-danger invalid-feedback" id="description_en"></p>

                        </div>
                        <!-- end   :: Column -->

                    </div>

                    <!-- Begin :: Input group -->
                    <div class="fv-row row mb-5 mt-5">

                        <!-- Begin :: Col -->
                        <div class="col-md-12">

                            <h3 class="text-center font-bold">{{ __('consultation Date') }}
                            </h3>
                            <hr>
                            <br>
                            <div id="form_repeater">
                                <!--begin::Form group-->
                                <div class="form-group">
                                    <div data-repeater-list="time_list">
                                        @foreach ($consultaion->consultaionScheduals as $index => $schedule)
                                            <div data-repeater-item>
                                                <div class="form-group row mt-5 mb-10">
                                                    <!-- Date Field -->
                                                    <div class="col-md-4">
                                                        <label class="form-label">{{ __('Date') }}</label>
                                                        <input type="date" class="form-control mb-2 mb-md-0"
                                                            name="time_list[{{ $index }}][date]"
                                                            value="{{ $schedule->date }}" readonly />
                                                        <p class="invalid-feedback"
                                                            id="time_list_{{ $index }}_date"></p>
                                                    </div>

                                                    <!-- Time Field -->
                                                    <div class="col-md-4">
                                                        <label class="form-label">{{ __('Time') }}</label>
                                                        <input type="time" class="form-control mb-2 mb-md-0"
                                                            name="time_list[{{ $index }}][time]"
                                                            value="{{ $schedule->time }}" readonly />
                                                        <p class="invalid-feedback"
                                                            id="time_list_{{ $index }}_time"></p>
                                                    </div>

                                                    <!-- Available Toggle -->
                                                    <div class="col-md-2 mt-3 text-center pt-5">
                                                        <label
                                                            class="mt-1 form-check form-check-sm form-check-custom form-check-solid">
                                                            <span class="form-label fs-3">{{ __('available') }}</span>
                                                            <input type="hidden"
                                                                name="time_list[{{ $index }}][available]"
                                                                value="false" disabled>
                                                            <input class="form-check-input ms-3" type="checkbox"
                                                                name="time_list[{{ $index }}][available]"
                                                                value="true" {{ $schedule->available ? 'checked' : '' }}
                                                                disabled>
                                                        </label>
                                                        <p class="invalid-feedback"
                                                            id="time_list_{{ $index }}_available"></p>
                                                    </div>


                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                                <!--end::Form group-->


                            </div>
                            <!--end::Repeater-->

                        </div>
                        <!-- End   :: Col -->

                    </div>
                    <!-- End   :: Input group -->





                </div>
                <!-- end   :: Inputs wrapper -->

                <!-- begin :: Form footer -->
                <div class="form-footer">

                    <!-- begin :: Submit btn -->
                    <a href="{{ route('dashboard.consultaiondata.index') }}" class="btn btn-primary">
                        <span class="indicator-label">{{ __('Back') }}</span>
                    </a>
                    <!-- end   :: Submit btn -->

                </div>
                <!-- end   :: Form footer -->
            </form>
            <!-- end   :: Form -->
        </div>
        <!-- end   :: Card body -->
    </div>
@endsection

@push('scripts')
    <script>
        $("form").on("submit", function(e) {
            e.preventDefault(); // Prevent the form submission for testing
            console.log($(this).serializeArray()); // Check serialized data
        });
    </script>
    <script src="{{ asset('dashboard-assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
    <script src="{{ asset('js/dashboard/components/form_repeater.js') }}"></script>

    <script>
        const fileInput = document.getElementById('image_path_inp');
        const imagePreview = document.getElementById('image_preview');

        fileInput.addEventListener('change', function() {
            imagePreview.innerHTML = ''; // Clear previous previews
            const files = fileInput.files;
            if (files.length > 0) {
                Array.from(files).forEach(file => {
                    if (file.type.startsWith('image/')) { // Check if file is an image
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            // Create an image element
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.style.width = '100px';
                            img.style.height = '100px';
                            img.style.objectFit = 'cover'; // Maintain aspect ratio and fill the box
                            img.style.border = '1px solid #ddd';
                            img.style.borderRadius = '5px';

                            // Append the image to the preview container
                            imagePreview.appendChild(img);
                        };
                        reader.readAsDataURL(file); // Read the file as a data URL
                    }
                });
            }
        });
    </script>
@endpush
