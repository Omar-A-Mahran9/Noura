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
                        href="{{ route('dashboard.courses.videos.index') }}"
                        class="text-muted text-hover-primary">{{ __('content') }}</a></h1>
                <!-- end   :: Title -->

                <!-- begin :: Separator -->
                <span class="h-20px border-gray-300 border-start mx-4"></span>
                <!-- end   :: Separator -->

                <!-- begin :: Breadcrumb -->
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <!-- begin :: Item -->
                    <li class="breadcrumb-item text-muted">
                        {{ __('Add new lecture') }}
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
            <form action="{{ route('dashboard.courses.videos.store') }}" class="form" method="post" id="submitted-form"
                data-redirection-url="{{ route('dashboard.courses.videos.create') }}">
                @csrf
                <!-- begin :: Card header -->
                <div class="card-header d-flex align-items-center">
                    <h3 class="fw-bolder text-dark">{{ __('Add new lecture') }}</h3>
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
                            <label class="fs-5 fw-bold mb-2">{{ __('Video Type') }}</label>
                            <select class="form-select" data-control="select2" name="type" id="video_type"
                                data-placeholder="{{ __('Choose video type') }}"
                                data-dir="{{ isArabic() ? 'rtl' : 'ltr' }}">
                                <option value="">

                                </option>
                                <option value="youtube">
                                    YouTube
                                </option>
                                <option value="vimeo">
                                    Vimeo
                                </option>
                            </select>
                            <p class="invalid-feedback" id="type">

                            </p>
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

                            <label class="form-label">{{ __('Video Path') }}</label>
                            <input type="text" class="form-control" name="video_path" value="" id="video_path_inp"
                                placeholder="{{ __('Add video material') }}">
                            <p class="invalid-feedback" id="video_path"></p>

                        </div>
                        <!-- End   :: Col -->

                    </div>





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

    <div class="card mt-2">
        <!-- begin :: Card Body -->
        <div class="card-body fs-6 py-15 px-10 py-lg-15 px-lg-15 text-gray-700">


            <!-- begin :: Datatable -->
            <table data-ordering="false" id="kt_datatable" class="table text-center table-row-dashed fs-6 gy-5">

                <thead>
                    <tr class="text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                        <th>#</th>
                        <th>{{ __('name') }}</th>
                        <th>{{ __('type') }}</th>
                        <th>{{ __('lecture') }}</th>

                        <th>{{ __('created date') }}</th>
                        <th class="min-w-100px">{{ __('actions') }}</th>
                    </tr>
                </thead>

                <tbody class="text-gray-600 fw-bold text-center">

                </tbody>
            </table>
            <!-- end   :: Datatable -->


        </div>
        <!-- end   :: Card Body -->
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('js/dashboard/forms/course/common.js') }}"></script>
    <script src="{{ asset('js/dashboard/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('js/dashboard/datatables/videos.js') }}"></script>
@endpush
