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

    <div class="card">
        <!-- begin :: Card body -->
        <div class="card-body p-0">

            <form action="{{ route('dashboard.books_notes.store') }}" class="form" method="post" id="submitted-form"
                data-redirection-url="{{ route('dashboard.books_notes.index') }}">
                @csrf
                <!-- begin :: Card header -->
                <div class="card-header d-flex align-items-center">
                    <h3 class="fw-bolder text-dark mb-0">{{ __('Add new book note') }}</h3>

                    <div class="form-check form-switch ms-auto pe-5">
                        <input class="form-check-input " type="checkbox" id="toggle_type" name="type_toggle">
                        <label class="form-check-label ms-2" for="toggle_type">
                            {{ __('Switch to Q&A') }}
                        </label>
                    </div>
                </div>
                <!-- end   :: Card header -->

                <!-- end   :: Card header -->

                <!-- begin :: Inputs wrapper -->
                <div class="inputs-wrapper">


                    <!-- begin :: Row -->
                    <div class="row mb-8">

                        <div class="row mb-4">
                            <div class="col-md-4 fv-row">
                                <label class="fs-5 fw-bold mb-2">{{ __('page number') }}</label>
                                <div class="form-floating">
                                    <input type="number" class="form-control" name="page" id="page_inp"
                                        placeholder="e.g. 12">
                                    <label for="page_inp">{{ __('Enter the page nunmber') }}</label>
                                </div>
                                <p class="invalid-feedback" id="page"></p>
                            </div>

                            <div class="col-md-4 fv-row">
                                <label class="fs-5 fw-bold mb-2">{{ __('Book') }}</label>
                                <select name="book_id" class="form-select" data-control="select2">
                                    <option value="">{{ __('Select book') }}</option>
                                    @foreach ($books as $book)
                                        <option value="{{ $book->id }}">{{ $book->title_en }}</option>
                                    @endforeach
                                </select>
                                <p class="invalid-feedback" id="book_id"></p>
                            </div>

                            <div class="col-md-4 fv-row">
                                <label class="fs-5 fw-bold mb-2">{{ __('Vendor') }}</label>
                                <select name="vendor_id" class="form-select" data-control="select2">
                                    <option value="">{{ __('Select vendor') }}</option>
                                    @foreach ($vendors as $vendor)
                                        <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                    @endforeach
                                </select>
                                <p class="invalid-feedback" id="vendor_id"></p>
                            </div>

                        </div>


                        <div class="row mb-4">


                            <div class="col-md-6 fv-row">
                                <label class="fs-5 fw-bold mb-2">{{ __('text part') }}</label>
                                <textarea name="text" id="text_inp" rows="3" class="form-control" placeholder="{{ __('Enter the text') }}"></textarea>
                                <p class="invalid-feedback" id="text"></p>
                            </div>

                            <div class="col-md-6 fv-row" id="note_section">
                                <label class="fs-5 fw-bold mb-2">{{ __('Note') }}</label>
                                <textarea name="note" id="note_inp" rows="3" class="form-control" placeholder="{{ __('Enter the note') }}"></textarea>
                                <p class="invalid-feedback" id="note"></p>
                            </div>


                        </div>

                        <div class="row mb-4 d-none" id="qa_section">
                            <div class="col-md-6 fv-row">
                                <label class="fs-5 fw-bold mb-2">{{ __('Question') }}</label>
                                <textarea name="question" id="question_inp" rows="3" class="form-control"
                                    placeholder="{{ __('Enter the question') }}"></textarea>
                                <p class="invalid-feedback" id="question"></p>
                            </div>

                            <div class="col-md-6 fv-row">
                                <label class="fs-5 fw-bold mb-2">{{ __('Answer') }}</label>
                                <textarea name="answer" id="answer_inp" rows="3" class="form-control"
                                    placeholder="{{ __('Enter the answer') }}"></textarea>
                                <p class="invalid-feedback" id="answer"></p>
                            </div>
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
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.getElementById('toggle_type');
            const noteSection = document.getElementById('note_section');
            const qaSection = document.getElementById('qa_section');

            toggle.addEventListener('change', function() {
                if (this.checked) {
                    noteSection.classList.add('d-none');
                    qaSection.classList.remove('d-none');
                } else {
                    noteSection.classList.remove('d-none');
                    qaSection.classList.add('d-none');
                }
            });
        });
    </script>
@endpush
