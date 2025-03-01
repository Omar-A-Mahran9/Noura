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
                        href="{{ route('dashboard.books.index') }}"
                        class="text-muted text-hover-primary">{{ __('Books') }}</a></h1>
                <!-- end   :: Title -->

                <!-- begin :: Separator -->
                <span class="h-20px border-gray-300 border-start mx-4"></span>
                <!-- end   :: Separator -->

                <!-- begin :: Breadcrumb -->
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <!-- begin :: Item -->
                    <li class="breadcrumb-item text-muted">
                        {{ __('Add new book') }}
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
            <form action="{{ route('dashboard.books.store') }}" class="form" method="post" id="submitted-form"
                data-redirection-url="{{ route('dashboard.books.index') }}">
                @csrf
                <!-- begin :: Card header -->
                <div class="card-header d-flex align-items-center">
                    <h3 class="fw-bolder text-dark">{{ __('Add new book') }}</h3>
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
                    <!-- end   :: Row -->
                    <div class="row mb-10">
                        <div class="col-md-4 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('Courses') }}</label>
                            <select class="form-select" data-control="select2" name="courses_ids[]" multiple
                                id="category-sp" data-placeholder="{{ __('Choose the course') }}"
                                data-dir="{{ isArabic() ? 'rtl' : 'ltr' }}">
                                @if (isset($courses))
                                    @foreach ($courses as $corses)
                                        <option value="{{ $course->id }}"> {{ $course->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <p class="invalid-feedback" id="courses_ids"></p>
                        </div>
                    </div>
                    <!-- begin :: Row -->
                    <div class="row mb-8">

                        <!-- begin :: Column -->
                        <div class="col-md-3 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('Title in arabic') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="title_ar_inp" name="title_ar"
                                    placeholder="example" />
                                <label for="title_ar_inp">{{ __('Enter the book title') }}</label>
                            </div>
                            <p class="invalid-feedback" id="title_ar"></p>
                        </div>
                        <!-- begin :: Column -->
                        <div class="col-md-3 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('Title in english') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="title_en_inp" name="title_en"
                                    placeholder="example" />
                                <label for="title_en_inp">{{ __('Enter the book title') }}</label>
                            </div>
                            <p class="invalid-feedback" id="title_en"></p>


                        </div>

                        <div class="col-md-3 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('Price') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="price_inp" name="price"
                                    placeholder="example" />
                                <label for="price_inp">{{ __('Enter the book price') }}</label>
                            </div>
                            <p class="invalid-feedback" id="price"></p>


                        </div>
                        <!-- begin :: Column -->
                        <div class="col-md-3 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('assign to author') }}</label>
                            <div class="form-floating">
                                <select class="form-select" data-control="select2" name="assign_to" id="employee-sp"
                                    data-placeholder="{{ __('assign to author') }}"
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

                    <!-- begin :: Row -->
                    <div class="row mb-10">

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('Description in arabic') }}</label>
                            <textarea class="form-control" rows="4" name="description_ar" id="meta_tag_description_ar_inp"></textarea>
                            <p class="text-danger invalid-feedback" id="description_ar"></p>


                        </div>
                        <!-- end   :: Column -->

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('Description in english') }}</label>
                            <textarea class="form-control" rows="4" name="description_en" id="meta_tag_description_en_inp"></textarea>
                            <p class="text-danger invalid-feedback" id="description_en"></p>

                        </div>
                        <!-- end   :: Column -->

                    </div>


                    <div class="row mb-10">

                        <div class="col-md-4 fv-row">

                            <label class="form-label">{{ __('book') }}</label>
                            <input placeholder="example" type="file" class="form-control" name="pdf_path"
                                id="pdf_path_inp">

                            <p class="invalid-feedback" id="pdf_path"></p>

                        </div>
                        <div class="col-md-4 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('stock') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="stock_inp" name="stock"
                                    placeholder="example" />
                                <label for="stock_inp">{{ __('Enter the stock') }}</label>
                            </div>
                            <p class="invalid-feedback" id="stock"></p>


                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="form-label">{{ __('more images') }}</label>
                            <input multiple type="file" class="form-control" name="images[]" id="image_path_inp">
                            <p class="invalid-feedback" id="images"></p>
                            <div id="image_preview" style="margin-top: 10px; display: flex; gap: 10px; flex-wrap: wrap;">
                            </div>
                        </div>

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
