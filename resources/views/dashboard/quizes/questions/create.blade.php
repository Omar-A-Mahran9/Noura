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
                        class="text-muted text-hover-primary">{{ __('question') }}</a></h1>
                <!-- end   :: Title -->

                <!-- begin :: Separator -->
                <span class="h-20px border-gray-300 border-start mx-4"></span>
                <!-- end   :: Separator -->



            </div>

        </div>

    </div>
    <!-- end   :: Subheader -->

    <div class="card">
        <!-- begin :: Card body -->
        <div class="card-body p-0">
            <!-- begin :: Form -->
            <form action="{{ route('dashboard.quizzes.questions.store') }}" class="form" method="post"
                id="submitted-form" data-redirection-url="{{ route('dashboard.quizzes.index') }}">
                @csrf
                <input type="hidden" name="type" value="{{ $type }}">
                <!-- begin :: Card header -->
                <div class="card-header d-flex  justify-content-between align-items-center">
                    <div>
                        <h3 class="fw-bolder text-dark">{{ __('Add new question') }}</h3>

                    </div>
                    <div class="pe-5 ">
                        <div class="form-check form-switch">
                            <label for="is_main_inp">{{ __('Question Is main') }}</label>
                            <input class="form-check-input" type="checkbox" id="is_main_inp" name="is_main" value="1">
                        </div>
                    </div>
                </div>
                <!-- end   :: Card header -->
                <!-- begin :: Inputs wrapper -->
                <div class="inputs-wrapper">

                    <!-- begin :: Row -->
                    <div class="row mb-10">

                        <!-- begin :: Column -->
                        <div class="col-md-4 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('quizzes') }}</label>
                            <select class="form-select" data-control="select2" name="quiz_id" id="quiz_id_inp"
                                data-placeholder="{{ __('Choose the quiz') }}" data-dir="{{ isArabic() ? 'rtl' : 'ltr' }}">
                                <option value="" selected></option>
                                @foreach ($quizzes as $quiz)
                                    <option value="{{ $quiz->id }}"> {{ $quiz->name }} </option>
                                @endforeach
                            </select>
                            <p class="invalid-feedback" id="quiz_id"></p>


                        </div>


                    </div>
                    <!-- end   :: Row -->

                    <!-- begin :: Row -->
                    <div class="row mb-10">

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('Question in arabic') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="name_ar_inp" name="name_ar"
                                    placeholder="example" />
                                <label for="name_ar_inp">{{ __('Enter the Question') }}</label>
                            </div>
                            <p class="invalid-feedback" id="name_ar"></p>
                        </div>
                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('Question in english') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="name_en_inp" name="name_en"
                                    placeholder="example" />
                                <label for="name_en_inp">{{ __('Enter the Question') }}</label>
                            </div>
                            <p class="invalid-feedback" id="name_en"></p>


                        </div>


                    </div>

                </div>
                <!-- end   :: Inputs wrapper -->
                <!-- Begin :: Input group -->
                <div class="row mx-8">
                    <hr>

                    <!--end::Form group-->
                    <!--begin::Repeater-->
                    @if ($type === 'text')
                        <!-- begin :: Column -->
                        {{-- <div class="col-md-6 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('Answer in arabic') }}</label>
                            <textarea class="form-control" rows="4" name="description_ar" id="meta_tag_description_ar_inp"></textarea>
                            <p class="text-danger invalid-feedback" id="description_ar"></p>


                        </div> --}}
                        <!-- end   :: Column -->

                        <!-- begin :: Column -->
                        {{-- <div class="col-md-6 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('Answer in english') }}</label>
                            <textarea class="form-control" rows="4" name="description_en" id="meta_tag_description_en_inp"></textarea>
                            <p class="text-danger invalid-feedback" id="description_en"></p>

                        </div> --}}
                        <!-- end   :: Column -->
                    @else
                        <!-- Begin :: Col -->
                        <div class="col-md-12 mt-3">
                            <div id="answer_repeater">
                                <div class="d-flex justify-content-between">
                                    <h3 class="text-center font-bold">{{ __('Answers') }}</h3>
                                    <!--begin::Form group-->

                                    <div class="form-group">
                                        <a href="javascript:" data-repeater-create class="btn btn-light-primary">
                                            <i class="la la-plus"></i>{{ __('Add new Choose') }}
                                        </a>
                                    </div>
                                </div>
                                <!--begin::Form group-->
                                <div class="form-group">
                                    <div data-repeater-list="answer_list">

                                        <div data-repeater-item>
                                            <div class="form-group row mt-5 mb-10 align-items-center">
                                                <div class="col-md-3">
                                                    <label
                                                        class="form-label sections_list">{{ __('Answer in arabic') }}</label>
                                                    <input type="text" class="form-control mb-2 mb-md-0" name="name_ar"
                                                        value=""
                                                        placeholder="{{ __('Enter answer in arabic') }}" />
                                                    <p class="invalid-feedback" id="sections_list_0_name_ar"></p>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">{{ __('Answer in english') }}</label>
                                                    <input type="text" class="form-control mb-2 mb-md-0"
                                                        name="name_en" value=""
                                                        placeholder="{{ __('Enter answer in english') }}" />
                                                    <p class="invalid-feedback" id="sections_list_0_name_en"></p>
                                                </div>

                                                {{-- @if ($type == 'multiple')
                                                    <div class="col-md-2 mt-5 text-center">
                                                        <label
                                                            class="mt-1 form-check form-check-sm form-check-custom form-check-solid">
                                                            <span
                                                                class="form-label fs-3">{{ __('correct answer') }}</span>
                                                            <input type="hidden" name="lock" value="0">
                                                            <input class="form-check-input ms-3" type="checkbox"
                                                                name="lock" value="1">
                                                        </label>
                                                    </div>
                                                @endif

                                                @if ($type == 'single')
                                                    <div class="col-md-2 mt-5 text-center">
                                                        <label
                                                            class="mt-1 form-check form-check-sm form-check-custom form-check-solid">
                                                            <span
                                                                class="form-label fs-3">{{ __('correct answer') }}</span>
                                                            <input type="radio" name="correct_answer" value="1"
                                                                class="form-check-input ms-3">
                                                        </label>
                                                    </div>
                                                @endif --}}



                                                <div class="col-md-3 ">
                                                    <a href="javascript:" data-repeater-delete
                                                        class="btn btn-light-danger mt-5 mt-md-5">
                                                        <i class="la la-trash-o"></i>{{ __('Delete') }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Form group-->


                            </div>
                            <!--end::Repeater-->
                        </div>
                        <!-- End   :: Col -->
                    @endif




                </div>
                <!-- End   :: Input group -->


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
        var type = @json($type);
    </script>
    <script src="{{ asset('js/dashboard/forms/course/common.js') }}"></script>
    <script src="{{ asset('dashboard-assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
    <script src="{{ asset('js/dashboard/components/form_repeater.js') }}"></script>
@endpush
