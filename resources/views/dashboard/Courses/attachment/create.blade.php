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
                        href="{{ route('dashboard.courses.attachment.index') }}"
                        class="text-muted text-hover-primary">{{ __('content') }}</a></h1>
                <!-- end   :: Title -->

                <!-- begin :: Separator -->
                <span class="h-20px border-gray-300 border-start mx-4"></span>
                <!-- end   :: Separator -->

                <!-- begin :: Breadcrumb -->
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <!-- begin :: Item -->
                    <li class="breadcrumb-item text-muted">
                        {{ __('Add new attachment') }}
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
            <form action="{{ route('dashboard.courses.attachment.store') }}" class="form" method="post"
                id="submitted-form" data-redirection-url="{{ route('dashboard.courses.index') }}">
                @csrf
                <!-- begin :: Card header -->
                <div class="card-header d-flex align-items-center">
                    <h3 class="fw-bolder text-dark">{{ __('Add new attachment') }}</h3>
                </div>
                <!-- end   :: Card header -->

                <!-- begin :: Inputs wrapper -->
                <div class="inputs-wrapper">

                    <!-- begin :: Row -->
                    <div class="row mb-10">

                        <!-- begin :: Column -->
                        <div class="col-md-4 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('Courses') }}</label>
                            <select class="form-select" data-control="select2" name="course_id" id="course_inp"
                                data-placeholder="{{ __('Choose the Course') }}"
                                data-dir="{{ isArabic() ? 'rtl' : 'ltr' }}">
                                <option value="" selected></option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}"> {{ $course->name }} </option>
                                @endforeach
                            </select>
                            <p class="invalid-feedback" id="course_id"></p>


                        </div>
                        <!-- end   :: Column -->


                        <div class="col-md-4 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('Sections') }}</label>
                            <select class="form-select" data-control="select2" name="section_id" id="section_inp"
                                data-placeholder="{{ __('Choose the section') }}"
                                data-dir="{{ isArabic() ? 'rtl' : 'ltr' }}">
                                <option value="" selected></option>
                            </select>
                            <p class="invalid-feedback" id="section_id"></p>

                        </div>

                        <div class="col-md-4 fv-row">
                            <label class="fs-5 fw-bold mb-2">{{ __('File Type') }}</label>
                            <select class="form-select" data-control="select2" name="type" id="file_type"
                                data-placeholder="{{ __('Choose file type') }}"
                                data-dir="{{ isArabic() ? 'rtl' : 'ltr' }}">
                                <option value="">
                                    {{ __('Choose file type') }}
                                </option>
                                <option value="pdf">
                                    {{ __('file') }}
                                </option>
                                <option value="image">
                                    {{ __('Image') }}
                                </option>

                            </select>
                            <p class="invalid-feedback" id="type"></p>
                        </div>



                    </div>
                    <!-- end   :: Row -->

                    <!-- begin :: Row -->
                    <div class="row mb-10">

                        <!-- begin :: Column -->
                        <div class="col-md-4 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('Name in arabic') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="name_ar_inp" name="name_ar"
                                    placeholder="example" />
                                <label for="name_ar_inp">{{ __('Enter the name in arabic') }}</label>
                            </div>
                            <p class="invalid-feedback" id="name_ar"></p>


                        </div>
                        <!-- end   :: Column -->

                        <!-- begin :: Column -->
                        <div class="col-md-4 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('Name in english') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="name_en_inp" name="name_en"
                                    placeholder="example" />
                                <label for="name_en_inp">{{ __('Enter the name in english') }}</label>
                            </div>
                            <p class="invalid-feedback" id="name_en"></p>


                        </div>
                        <!-- end   :: Column -->
                        <!-- Begin :: Col -->
                        <div class="col-md-4 fv-row">

                            <label class="form-label">{{ __('file') }}</label>
                            <input placeholder="example" type="file" class="form-control" name="file_path"
                                id="file_path_inp">

                            <p class="invalid-feedback" id="file_path"></p>

                        </div>
                        <!-- End   :: Col -->

                    </div>

                    <!-- begin :: Row -->
                    <div class="row mb-10">

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('Description in arabic') }}</label>
                            <textarea name="description_ar" class="form-select"></textarea>
                            <p class="text-danger invalid-feedback" id="description_ar"></p>


                        </div>
                        <!-- end   :: Column -->

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('Description in english') }}</label>
                            <textarea name="description_en" class="form-select"></textarea>
                            <p class="text-danger error-element" id="description_en"></p>

                        </div>
                        <!-- end   :: Column -->

                    </div>
                    <!-- begin :: Row -->





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
    <script src="{{ asset('js/dashboard/forms/course/common.js') }}"></script>
@endpush
