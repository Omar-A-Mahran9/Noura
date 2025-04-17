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
                        href="{{ route('dashboard.lives.index') }}"
                        class="text-muted text-hover-primary">{{ __('Lives') }}</a></h1>
                <!-- end   :: Title -->

                <!-- begin :: Separator -->
                <span class="h-20px border-gray-300 border-start mx-4"></span>
                <!-- end   :: Separator -->

                <!-- begin :: Breadcrumb -->
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <!-- begin :: Item -->
                    <li class="breadcrumb-item text-muted">
                        {{ __('Add new live') }}
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
            <form action="{{ route('dashboard.lives.store') }}" class="form" method="post" id="submitted-form"
                data-redirection-url="{{ route('dashboard.lives.index') }}">
                @csrf
                <!-- begin :: Card header -->
                <div class="card-header d-flex align-items-center">
                    <h3 class="fw-bolder text-dark">{{ __('Add new live') }}</h3>
                    <div class="form-check form-switch form-check-custom form-check-solid mb-2">
                        <label class="fs-5 fw-bold">{{ __('publish') }}</label>
                        <input class="form-check-input mx-2" style="height: 18px;width:36px;" type="checkbox" name="publish"
                            id="publish" />
                        <label class="form-check-label" for="publish"></label>
                    </div>
                </div>
                <!-- end   :: Card header -->

                <!-- begin :: Inputs wrapper -->
                <div class="inputs-wrapper">

                    <div class="row mb-10">

                        <!-- begin :: Column -->
                        <div class="col-md-12 fv-row d-flex justify-content-evenly">

                            <div class="d-flex flex-column align-items-center">
                                <!-- begin :: Upload image component -->
                                <label class="text-center fw-bold mb-4">{{ __('Image') }}</label>
                                <div>
                                    <x-dashboard.upload-image-inp name="main_image" :image="null" :directory="null"
                                        placeholder="default.jpg" type="editable"></x-dashboard.upload-image-inp>
                                </div>
                                <p class="invalid-feedback" id="main_image"></p>
                                <!-- end   :: Upload image component -->
                            </div>


                        </div>
                        <!-- end   :: Column -->

                    </div>

                    <div class="row mb-8">

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('Title in arabic') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="title_ar_inp" name="title_ar"
                                    placeholder="example" />
                                <label for="title_ar_inp">{{ __('Enter the lives title') }}</label>
                            </div>
                            <p class="invalid-feedback" id="title_ar"></p>
                        </div>
                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('Title in english') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="title_en_inp" name="title_en"
                                    placeholder="example" />
                                <label for="title_en_inp">{{ __('Enter the lives title') }}</label>
                            </div>
                            <p class="invalid-feedback" id="title_en"></p>


                        </div>

                    </div>
                    <!-- begin :: Column -->
                    <div class="row mb-8">

                        <div class="col-md-4 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('Price') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="price_inp" name="price"
                                    placeholder="example" />
                                <label for="price_inp">{{ __('Enter the lives price') }}</label>
                            </div>
                            <p class="invalid-feedback" id="price"></p>


                        </div>
                        <!-- begin :: Column -->
                        <div class="col-md-4 fv-row">

                            <div class="form-check form-switch form-check-custom form-check-solid mb-2">
                                <label class="fs-5 fw-bold">{{ __('Discount price') }}</label>
                                <input class="form-check-input mx-2" style="height: 18px;width:36px;" type="checkbox"
                                    name="have_discount" id="discount-price-switch" />
                                <label class="form-check-label" for="discount-price-switch"></label>
                            </div>

                            <div class="form-floating">
                                <input type="number" min="1" class="form-control" id="discount_price_inp"
                                    name="discount_price" disabled placeholder="example" />
                                <label for="discount_price_inp">{{ __('Enter the discount price') }}</label>
                            </div>
                            <p class="invalid-feedback" id="discount_price"></p>
                        </div>
                        <div class="col-md-4 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('assign to specilist') }}</label>
                            <div class="form-floating">
                                <select class="form-select" data-control="select2" name="assign_to" id="employee-sp"
                                    data-placeholder="{{ __('assign to specilist') }}"
                                    data-dir="{{ isArabic() ? 'rtl' : 'ltr' }}">
                                    <option value="" selected></option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">
                                            {{ $employee->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <p class="invalid-feedback" id="assign_to"></p>


                        </div>
                        <!-- end   :: Column -->


                    </div>
                    <!-- end   :: Column -->



                    <!-- begin :: Row -->
                    <div class="row mb-10">

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('Description in arabic') }}</label>
                            <textarea for="description_ar" class="form-control" rows="4" name="description_ar"></textarea>
                            <p class="text-danger invalid-feedback" id="description_ar"></p>


                        </div>
                        <!-- end   :: Column -->

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('Description in english') }}</label>
                            <textarea class="form-control" rows="4" name="description_en"></textarea>
                            <p class="text-danger invalid-feedback" id="description_en"></p>

                        </div>
                        <!-- end   :: Column -->

                    </div>


                    <div class="row mb-10">
                        <div class="col-md-3 fv-row">
                            <label class="fs-5 fw-bold mb-2" for="day_date">{{ __('Day Date') }}</label>
                            <input type="date" name="day_date"
                                class="form-control form-control-solid border-gray-300 border-1 filter-datatable-inp me-4"
                                placeholder="{{ __('Choose the date') }}" data-filter-index="6" />
                            <p class="invalid-feedback" id="day_date"></p>
                        </div>

                        <div class="col-md-3 fv-row">
                            <label class="fs-5 fw-bold mb-2" for="from_inp">{{ __('Start Time From') }}</label>
                            <input type="time" name="from" id="from_inp"
                                class="form-control form-control-solid border-gray-300 border-1 filter-datatable-inp me-4"
                                placeholder="{{ __('Choose the start time') }}" data-filter-index="6" />
                            <p class="invalid-feedback" id="from"></p>
                        </div>

                        <div class="col-md-3 fv-row">
                            <label class="fs-5 fw-bold mb-2" for="to_inp">{{ __('End Time To') }}</label>
                            <input type="time" name="to" id="to_inp"
                                class="form-control form-control-solid border-gray-300 border-1 filter-datatable-inp me-4"
                                placeholder="{{ __('Choose the end time') }}" data-filter-index="6" />
                            <p class="invalid-feedback" id="to"></p>
                        </div>

                        <!-- begin :: Column -->
                        <div class="col-md-3 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('Video url') }}</label>

                            <div class="form-floating">
                                <input type="text" class="form-control" id="video_url_inp" name="video_url"
                                    placeholder="example" />
                                <label for="video_url_inp">{{ __('Enter the video url') }}</label>
                            </div>

                            <p class="invalid-feedback" id="video_url"></p>

                        </div>
                        <!-- end   :: Column -->


                    </div>
                    <!-- End   :: Col -->

                </div>
                <!-- end   :: Inputs wrapper -->

                <!-- begin :: Form footer -->
                <div class="form-footer">

                    <!-- begin :: Submit btn -->
                    <button type="submit" class="btn btn-primary" id="submit-btn">

                        <span class="indicator-label">{{ __('Save') }}</span>

                        <!-- begin :: Indicator -->
                        <span class="indicator-progress">{{ __('Please wait ...') }}
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                        <!-- end   :: Indicator -->

                    </button>
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
        // Image preview on file selection
        // const fileInput = document.getElementById('image_path_inp');
        // const imagePreview = document.getElementById('image_preview');

        // fileInput.addEventListener('change', function() {
        //     imagePreview.innerHTML = '';
        //     const files = fileInput.files;
        //     if (files.length > 0) {
        //         Array.from(files).forEach(file => {
        //             if (file.type.startsWith('image/')) {
        //                 const reader = new FileReader();
        //                 reader.onload = function(e) {
        //                     const img = document.createElement('img');
        //                     img.src = e.target.result;
        //                     img.style.width = '100px';
        //                     img.style.height = '100px';
        //                     img.style.objectFit = 'cover';
        //                     img.style.border = '1px solid #ddd';
        //                     img.style.borderRadius = '5px';
        //                     img.style.marginRight = '8px';
        //                     imagePreview.appendChild(img);
        //                 };
        //                 reader.readAsDataURL(file);
        //             }
        //         });
        //     }
        // });

        // Discount input toggle and validation
        let priceInp = $("#price_inp");
        let discountInp = $("#discount_price_inp");

        $(document).ready(() => {
            // Enable/disable discount input based on switch
            $("#discount-price-switch").change(function() {
                discountInp.prop("disabled", !$(this).prop("checked"));
                if (!$(this).prop("checked")) {
                    discountInp.val('');
                }
            });

            // Validate discount price in real-time
            discountInp.on("input", function() {
                let discountValue = parseFloat($(this).val());
                let priceValue = parseFloat(priceInp.val());

                if (isNaN(discountValue) || isNaN(priceValue)) return;

                if (discountValue >= priceValue) {
                    $(this).val('');
                    warningAlert("{{ __('Discount price must be smaller than the price') }}");
                }
            });

            // Auto-disable discount if price is 0
            priceInp.on("input", function() {
                let priceValue = parseFloat($(this).val());
                if (priceValue === 0) {
                    $("#discount-price-switch").prop("checked", false).trigger("change");
                }
            });
        });
    </script>
@endpush
