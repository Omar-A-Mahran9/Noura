@extends('partials.dashboard.master')
@push('styles')
    <link href="{{ asset('dashboard-assets/css/wizard' . (isArabic() ? '.rtl' : '') . '.css') }}" rel="stylesheet"
        type="text/css" />
    <style>
        .separator-dashed {
            border-color: #e4e6ef !important;
        }
    </style>
@endpush
@section('content')
    <!-- begin :: Subheader -->
    <div class="toolbar">

        <div class="container-fluid d-flex flex-stack">

            <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">

                <!-- begin :: Title -->
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1"><a
                        href="{{ route('dashboard.courses.index') }}"
                        class="text-muted text-hover-primary">{{ __('Courses') }}</a></h1>
                <!-- end   :: Title -->

                <!-- begin :: Separator -->
                <span class="h-20px border-gray-300 border-start mx-4"></span>
                <!-- end   :: Separator -->

                <!-- begin :: Breadcrumb -->
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <!-- begin :: Item -->
                    <li class="breadcrumb-item text-muted">
                        {{ __('Add new course') }}

                    </li>
                    <!-- end   :: Item -->
                </ul>
                <!-- end   :: Breadcrumb -->

            </div>

        </div>

    </div>
    <!-- end   :: Subheader -->

    <!-- begin :: Card -->
    <div class="card">

        <div class="card-body p-0">
            <!-- begin :: Wizard -->
            <div class="wizard wizard-4">

                <!-- begin :: Wizard Nav -->
                <div class="wizard-nav">
                    <div class="wizard-steps">
                        <!--begin::Wizard Step 1 Nav-->
                        <div class="wizard-step" data-wizard-type="step" data-wizard-state="current" data-index="0">
                            <div class="wizard-wrapper">
                                <div class="wizard-number">1</div>
                                <div class="wizard-label">
                                    <div class="wizard-title">{{ __('Basic information') }}</div>
                                    <div class="wizard-desc">{{ __('Add course basic information') }}</div>
                                </div>
                            </div>
                        </div>
                        <!--end::Wizard Step 1 Nav-->
                        <!--begin::Wizard Step 2 Nav-->
                        <div class="wizard-step" data-wizard-type="step" data-index="1">
                            <div class="wizard-wrapper">
                                <div class="wizard-number">2</div>
                                <div class="wizard-label">
                                    <div class="wizard-title">{{ __('Course content') }}</div>
                                    <div class="wizard-desc">{{ __('Add Course content') }}</div>
                                </div>
                            </div>
                        </div>
                        <!--end::Wizard Step 2 Nav-->
                        <!--begin::Wizard Step 3 Nav-->
                        <div class="wizard-step" data-wizard-type="step" data-index="2">
                            <div class="wizard-wrapper">
                                <div class="wizard-number">3</div>
                                <div class="wizard-label">
                                    <div class="wizard-title">{{ __('Section content') }}</div>
                                    <div class="wizard-desc">{{ __('Add Sections content') }}</div>
                                </div>
                            </div>
                        </div>
                        <!--end::Wizard Step 3 Nav-->
                        <!--begin::Wizard Step 4 Nav-->
                        <div class="wizard-step" data-wizard-type="step" data-index="3">
                            <div class="wizard-wrapper">
                                <div class="wizard-number">4</div>
                                <div class="wizard-label">
                                    <div class="wizard-title">{{ __('Features') }}</div>
                                    <div class="wizard-desc">{{ __('Add course features') }}</div>
                                </div>
                            </div>
                        </div>
                        <!--end::Wizard Step 4 Nav-->
                    </div>
                </div>
                <!-- end   :: Wizard Nav -->

                <!-- begin :: Wizard Body -->
                <div class="card card-custom card-shadowless rounded-top-0">

                    <div class="card-body p-0">

                        <div class="row justify-content-center pt-8">
                            <div class="col-xl-12">

                                <!-- begin :: Wizard Form -->
                                <form class="form mt-0 mt-lg-10" id="submitted-form">
                                    <!--begin::Form group-->

                                    <!-- begin :: Wizard Step 1 -->
                                    <div class="p-8 wizard-step" data-wizard-type="step-content">
                                        <!-- begin :: Row -->

                                        <div class="row mb-10">
                                            <div class="col-md-12 fv-row d-flex justify-content-evenly mb-15">

                                                <div class="d-flex flex-column">
                                                    <!-- begin :: Upload image component -->
                                                    <label class="text-center fw-bold mb-4">{{ __('Main image') }}</label>
                                                    <x-dashboard.upload-image-inp name="images" :image="null"
                                                        :directory="null" placeholder="default.jpg"
                                                        type="editable"></x-dashboard.upload-image-inp>
                                                    <p class="invalid-feedback" id="images"></p>
                                                    <!-- end   :: Upload image component -->
                                                </div>
                                            </div>

                                            <!-- begin :: Column -->
                                            <div class="col-md-4 fv-row">

                                                <label
                                                    class="fs-5 fw-bold mb-2">{{ __('Short description in arabic') }}</label>

                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="name_ar_inp"
                                                        name="name_ar" placeholder="example" />
                                                    <label
                                                        for="name_ar_inp">{{ __('Enter the short description in arabic') }}</label>
                                                </div>

                                                <p class="invalid-feedback" id="name_ar"></p>

                                            </div>
                                            <!-- end   :: Column -->

                                            <!-- begin :: Column -->
                                            <div class="col-md-4 fv-row">

                                                <label
                                                    class="fs-5 fw-bold mb-2">{{ __('Short description in english') }}</label>
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="name_en_inp"
                                                        name="name_en" placeholder="example" />
                                                    <label
                                                        for="name_en_inp">{{ __('Enter the short description in english') }}</label>
                                                </div>
                                                <p class="invalid-feedback" id="name_en"></p>


                                            </div>
                                            <!-- end   :: Column -->
                                            <!-- begin :: Column -->
                                            <div class="col-md-4 fv-row">

                                                <label class="fs-5 fw-bold mb-2">{{ __('Video url') }}</label>

                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="video_url_inp"
                                                        name="video_url" placeholder="example" />
                                                    <label for="video_url_inp">{{ __('Enter the video url') }}</label>
                                                </div>

                                                <p class="invalid-feedback" id="video_url"></p>

                                            </div>
                                            <!-- end   :: Column -->
                                        </div>
                                        <!-- end   :: Row -->

                                        <!-- begin :: Row -->
                                        <div class="row mb-10">
                                            <!-- begin :: Column -->
                                            <div class="col-md-3 fv-row">

                                                <label class="fs-5 fw-bold mb-2">{{ __('Price') }}</label>
                                                <div class="form-floating">
                                                    <input type="number" min="1" class="form-control"
                                                        id="price_inp" name="price" placeholder="example" />
                                                    <label for="price_inp">{{ __('Enter the price') }}</label>
                                                </div>
                                                <p class="invalid-feedback" id="price"></p>


                                            </div>
                                            <!-- end   :: Column -->

                                            <!-- begin :: Column -->
                                            <div class="col-md-3 fv-row">

                                                <div
                                                    class="form-check form-switch form-check-custom form-check-solid mb-2">
                                                    <label class="fs-5 fw-bold">{{ __('Discount price') }}</label>
                                                    <input class="form-check-input mx-2" style="height: 18px;width:36px;"
                                                        type="checkbox" name="have_discount"
                                                        id="discount-price-switch" />
                                                    <label class="form-check-label" for="discount-price-switch"></label>
                                                </div>

                                                <div class="form-floating">
                                                    <input type="number" min="1" class="form-control"
                                                        id="discount_price_inp" name="discount_price" disabled
                                                        placeholder="example" />
                                                    <label
                                                        for="discount_price_inp">{{ __('Enter the discount price') }}</label>
                                                </div>
                                                <p class="invalid-feedback" id="discount_price"></p>


                                            </div>
                                            <!-- end   :: Column -->
                                            <!-- begin :: Column -->
                                            <div class="col-md-3 fv-row">

                                                <label
                                                    class="fs-5 fw-bold mb-2">{{ __('discount duration days counts') }}</label>
                                                <div class="form-floating">
                                                    <input type="number" min="1" class="form-control"
                                                        id="discount_duration_days_counts_inp"
                                                        name="discount_duration_days_counts" placeholder="example"
                                                        disabled />
                                                    <label
                                                        for="discount_duration_days_counts_inp">{{ __('Enter the duration') }}</label>
                                                </div>
                                                <p class="invalid-feedback" id="discount_duration_days_counts"></p>


                                            </div>

                                            <!-- begin :: Column -->
                                            <div class="col-md-3 fv-row">

                                                <label class="fs-5 fw-bold mb-2">{{ __('assign to employees') }}</label>
                                                <div class="form-floating">
                                                    <select class="form-select" data-control="select2" name="assign_to"
                                                        id="employee-sp"
                                                        data-placeholder="{{ __('Choose the employee') }}"
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
                                        <!-- end   :: Row -->
                                        <!-- begin :: Row -->
                                        <div class="row mb-10 align-items-center">
                                            <div class="col-md-3 fv-row">
                                                <label class="fs-5 fw-bold mb-2"
                                                    for="from_inp">{{ __('Date from') }}</label>
                                                <input type='date' name="from" id="from_inp"
                                                    class="form-control form-control-solid   datepicker border-gray-300 border-1 filter-datatable-inp me-4"
                                                    placeholder="{{ __('Choose the date') }}" data-filter-index="6" />
                                                <p class="invalid-feedback" id="from"></p>
                                            </div>
                                            <div class="col-md-3 fv-row">
                                                <label for="to_inp"
                                                    class="fs-5 fw-bold mb-2">{{ __('Date to') }}</label>
                                                <input id="to_inp" type='date' name="to"
                                                    class="form-control form-control-solid   border-gray-300 border-1 filter-datatable-inp me-4"
                                                    placeholder="{{ __('Choose the date') }}" data-filter-index="6" />
                                                <p class="invalid-feedback" id="to"></p>
                                            </div>

                                            <!-- begin :: Column -->
                                            <div class="col-md-3 fv-row">

                                                <label class="fs-5 fw-bold mb-2">{{ __('Course statue') }}</label>
                                                <div class="form-floating">
                                                    <select class="form-select" data-control="select2" name="status"
                                                        id="status-sp" data-placeholder="{{ __('Course statue') }}"
                                                        data-dir="{{ isArabic() ? 'rtl' : 'ltr' }}">
                                                        <option value="" selected></option>
                                                        @foreach ($status as $statue)
                                                            <option value="{{ $statue['value'] }}">
                                                                {{ $statue['name'] }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <p class="invalid-feedback" id="status"></p>


                                            </div>
                                            <!-- end   :: Column -->
                                            <!-- end   :: Column -->
                                            <div class="col-md-3 fv-row pt-5 mt-4">
                                                <div class="form-check form-switch">
                                                    <label for="openCourseSwitch">{{ __('Open Course') }}</label>
                                                    <input class="form-check-input" type="checkbox" id="openCourseSwitch"
                                                        name="open" value="1">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row mb-10">
                                            <div class="col-md-6 fv-row">
                                                <label class="form-label">{{ __('more images') }}</label>
                                                <input multiple type="file" class="form-control" name="moreimages[]"
                                                    id="image_path_inp">
                                                <p class="invalid-feedback" id="moreimages"></p>
                                                <div id="image_preview"
                                                    style="margin-top: 10px; display: flex; gap: 10px; flex-wrap: wrap;">
                                                </div>
                                            </div>
                                            <div class="col-md-6 fv-row">

                                                <label class="fs-5 fw-bold mb-2">{{ __('Category') }}</label>
                                                <select class="form-select" data-control="select2" name="category_ids[]"
                                                    multiple id="category-sp"
                                                    data-placeholder="{{ __('Choose the category') }}"
                                                    data-dir="{{ isArabic() ? 'rtl' : 'ltr' }}">
                                                    @if (isset($categories))
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}"> {{ $category->name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <p class="invalid-feedback" id="category_ids"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end   :: Wizard Step 1 -->


                                    <!-- end   :: Wizard Step 1 -->

                                    <!-- begin :: Wizard Step 2 -->
                                    <div class="p-8 wizard-step d-none" data-wizard-type="step-content"
                                        data-wizard-state="current">


                                        <!-- Begin :: Input group -->
                                        <div class="fv-row row mb-5">

                                            <!-- Begin :: Col -->
                                            <div class="col-md-12">

                                                <h3 class="text-center font-bold">{{ __('Course Sections') }}
                                                </h3>
                                                <hr>
                                                <br>
                                                <!--begin::Repeater-->
                                                <div id="form_repeater">
                                                    <!--begin::Form group-->
                                                    <div class="form-group">
                                                        <div data-repeater-list="sections_list">

                                                            <div data-repeater-item>
                                                                <div class="form-group row mt-5 mb-10">
                                                                    <div class="col-md-2">
                                                                        <label
                                                                            class="form-label sections_list">{{ '1 - ' . __('Name in arabic') }}</label>
                                                                        <input type="text"
                                                                            class="form-control mb-2 mb-md-0"
                                                                            name="name_ar" value=""
                                                                            placeholder="{{ __('Enter status name in arabic') }}" />
                                                                        <p class="invalid-feedback"
                                                                            id="sections_list_0_name_ar"></p>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <label
                                                                            class="form-label">{{ __('Name in english') }}</label>
                                                                        <input type="text"
                                                                            class="form-control mb-2 mb-md-0"
                                                                            name="name_en" value=""
                                                                            placeholder="{{ __('Enter status name in english') }}" />
                                                                        <p class="invalid-feedback"
                                                                            id="sections_list_0_name_en"></p>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label
                                                                            class="form-label">{{ __('Description in arabic') }}</label>
                                                                        <textarea class="form-control mb-2 mb-md-0" name="description_ar"
                                                                            placeholder="{{ __('Enter description in arabic') }}" rows="2"></textarea>
                                                                        <p class="invalid-feedback"
                                                                            id="sections_list_0_description_ar"></p>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label
                                                                            class="form-label">{{ __('Description in english') }}</label>
                                                                        <textarea class="form-control mb-2 mb-md-0" name="description_en"
                                                                            placeholder="{{ __('Enter description in english') }}" rows="2"></textarea>
                                                                        <p class="invalid-feedback"
                                                                            id="sections_list_0_description_en"></p>
                                                                    </div>
                                                                    <div class="col-md-2 mt-3 text-center">
                                                                        <label
                                                                            class="mt-1 form-check form-check-sm form-check-custom form-check-solid">
                                                                            <span
                                                                                class="form-label fs-3">{{ __('active ?') }}</span>
                                                                            <input type="hidden" name="lock"
                                                                                value="0">
                                                                            <input class="form-check-input ms-3"
                                                                                type="checkbox" name="lock"
                                                                                value="1">
                                                                        </label>
                                                                    </div>

                                                                    <div class="col-md-3 ">
                                                                        <a href="javascript:" data-repeater-delete
                                                                            class="btn btn-light-danger mb-4 mt-md-4">
                                                                            <i
                                                                                class="la la-trash-o"></i>{{ __('Delete') }}
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--end::Form group-->

                                                    <!--begin::Form group-->
                                                    <div class="form-group mt-5">
                                                        <a href="javascript:" data-repeater-create
                                                            class="btn btn-light-primary">
                                                            <i class="la la-plus"></i>{{ __('Add') }}
                                                        </a>
                                                    </div>
                                                    <!--end::Form group-->
                                                </div>
                                                <!--end::Repeater-->

                                            </div>
                                            <!-- End   :: Col -->

                                        </div>
                                        <!-- End   :: Input group -->


                                    </div>
                                    <!-- end   :: Wizard Step 2 -->

                                    <!-- begin :: Wizard Step 3 -->
                                    <div class="p-8 wizard-step d-none" data-wizard-type="step-content">
                                        <!-- begin :: Row -->
                                        <div class="row mb-10 mt-5">

                                            <!-- begin :: Column -->
                                            <div class="col-md-6 fv-row">

                                                <label class="fs-5 fw-bold mb-2">{{ __('Description in arabic') }}</label>
                                                <textarea id="tinymce_description_ar" name="description_ar" class="tinymce"></textarea>
                                                <p class="text-danger invalid-feedback" id="description_ar"></p>


                                            </div>
                                            <!-- end   :: Column -->

                                            <!-- begin :: Column -->
                                            <div class="col-md-6 fv-row">

                                                <label
                                                    class="fs-5 fw-bold mb-2">{{ __('Description in english') }}</label>
                                                <textarea id="tinymce_description_en" name="description_en" class="tinymce"></textarea>
                                                <p class="text-danger error-element" id="description_en"></p>

                                            </div>
                                            <!-- end   :: Column -->

                                        </div>

                                    </div>
                                    <!-- end   :: Wizard Step 3 -->


                                    <!-- begin :: Wizard Step 4 -->
                                    <div class="p-8 wizard-step d-none" data-wizard-type="step-content">

                                        <!-- Begin :: Input group -->
                                        <div class="fv-row row mb-5">

                                            <!-- Begin :: Col -->
                                            <div class="col-md-12">

                                                <h3 class="text-center font-bold">{{ __('Outcomes') }}
                                                </h3>
                                                <hr>
                                                <br>
                                                <!--begin::Repeater-->
                                                <div id="form_outcome_repeater">
                                                    <!--begin::Form group-->
                                                    <div class="form-group">
                                                        <div data-repeater-list="outcome_list">

                                                            <div data-repeater-item>
                                                                <div class="form-group row mt-5">

                                                                    <div class="col-md-3">
                                                                        <label
                                                                            class="form-label">{{ __('Description in arabic') }}</label>
                                                                        <textarea class="form-control mb-2 mb-md-0" name="description_ar"
                                                                            placeholder="{{ __('Enter description in arabic') }}" rows="3"></textarea>
                                                                        <p class="invalid-feedback"
                                                                            id="outcome_list_0_description_ar"></p>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label
                                                                            class="form-label">{{ __('Description in english') }}</label>
                                                                        <textarea class="form-control mb-2 mb-md-0" name="description_en"
                                                                            placeholder="{{ __('Enter description in english') }}" rows="3"></textarea>
                                                                        <p class="invalid-feedback"
                                                                            id="outcome_list_0_description_en"></p>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <a href="javascript:" data-repeater-delete
                                                                            class="btn btn-light-danger mb-5 mt-md-15">
                                                                            <i
                                                                                class="la la-trash-o"></i>{{ __('Delete') }}
                                                                        </a>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--end::Form group-->

                                                    <!--begin::Form group-->
                                                    <div class="form-group mt-5">
                                                        <a href="javascript:" data-repeater-create
                                                            class="btn btn-light-primary">
                                                            <i class="la la-plus"></i>{{ __('Add') }}
                                                        </a>
                                                    </div>
                                                    <!--end::Form group-->
                                                </div>
                                                <!--end::Repeater-->

                                            </div>
                                            <!-- End   :: Col -->

                                        </div>
                                        <!-- End   :: Input group -->



                                    </div>
                                    <!-- end   :: Wizard Step 4 -->

                                    <!-- begin :: Wizard Actions -->
                                    <div class="d-flex justify-content-between border-top py-10 px-10">
                                        <div class="mr-2">
                                            <button type="button"
                                                class="btn btn-light-primary font-weight-bolder text-uppercase px-9 py-4 step-btn d-none"
                                                id="prev-btn" data-btn-type="prev">{{ __('Previous') }}</button>
                                        </div>
                                        <div>

                                            <button type="button"
                                                class="btn btn-primary font-weight-bolder text-uppercase px-9 py-4 step-btn"
                                                id="next-btn" data-btn-type="next">

                                                <span class="indicator-label">{{ __('Next') }}</span>

                                                <!-- begin :: Indicator -->
                                                <span class="indicator-progress">{{ __('Please wait ...') }}
                                                    <span
                                                        class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                </span>
                                                <!-- end   :: Indicator -->

                                            </button>

                                        </div>
                                    </div>
                                    <!-- end   :: Wizard Actions -->
                                </form>
                                <!-- end   :: Wizard Form -->

                            </div>
                        </div>

                    </div>

                </div>
                <!-- end   :: Wizard Body -->

            </div>
            <!-- end   :: Wizard -->
        </div>

    </div>
    <!-- end   :: Card -->
@endsection
@push('styles')
    <style>
        #active-line {
            width: 100%;
            height: 2px;
            background-color: gray;
            border: none;
            display: none;
        }

        #active-line.active {
            background-color: black;
            height: 3px;
            display: block;

            /* Adjust thickness when active */
        }
    </style>
@endpush
@push('scripts')
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

    <script src="{{ asset('dashboard-assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
    <script src="{{ asset('js/dashboard/components/form_repeater.js') }}"></script>

    <script src="{{ asset('dashboard-assets/plugins/custom/tinymce/tinymce.bundle.js') }}"></script>

    <script>
        $(document).ready(() => {

            initTinyMc();


        })
    </script>
    <script src="{{ asset('js/dashboard/forms/courses/create.js') }}"></script>
    <script src="{{ asset('js/dashboard/components/wizard.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Event listener for the "Next" button
            $('#next-btn').on('click', function(e) {



            });
        });


        $(document).ready(function() {
            // Cache DOM elements
            const videosMaterial = $('#videos_material');
            const attachmentMaterial = $('#attachment_material');
            const hrElement = $('#active-line');

            // Function to check visibility of sections and toggle HR
            function checkSectionsVisibility() {
                if (videosMaterial.is(':visible') || attachmentMaterial.is(':visible')) {
                    hrElement.addClass('active'); // Add active class to HR
                } else {
                    hrElement.removeClass('active'); // Remove active class from HR
                }
            }

            // Event listeners for checkboxes
            $('#show-videos-material').on('change', function() {
                if ($(this).is(':checked')) {
                    videosMaterial.find('input, select').val('').trigger('change');
                    videosMaterial.removeClass('d-none'); // Show videos_material
                } else {
                    videosMaterial.addClass('d-none'); // Hide videos_material
                }
                checkSectionsVisibility(); // Check visibility after toggle

            });

            $('#show-attachment-material').on('change', function() {
                if ($(this).is(':checked')) {
                    attachmentMaterial.find('input, select').val('').trigger('change');

                    attachmentMaterial.removeClass('d-none'); // Show attachment_material
                } else {
                    attachmentMaterial.addClass('d-none'); // Hide attachment_material
                }
                checkSectionsVisibility(); // Check visibility after toggle

            });
        });
    </script>
@endpush
