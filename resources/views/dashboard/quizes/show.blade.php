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
                        {{ __('Show an book') }}
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
            <form class="form">
                <!-- begin :: Card header -->
                <div class="card-header d-flex align-items-center">
                    <h3 class="fw-bolder text-dark">{{ __('Book') . ' : ' . $book->title }}</h3>
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
                                    <x-dashboard.upload-image-inp name="main_image" :image="$book['main_image']" directory="Books"
                                        placeholder="default.jpg" type="show"></x-dashboard.upload-image-inp>
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
                        <div class="col-md-4 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('Title in arabic') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="title_ar_inp" name="title_ar"
                                    placeholder="example" value="{{ $book->title_ar }}" readonly />
                                <label for="title_ar_inp">{{ __('Enter the Book title') }}</label>
                            </div>
                            <p class="invalid-feedback" id="title_ar"></p>
                        </div>
                        <!-- begin :: Column -->
                        <div class="col-md-4 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('Title in english') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="title_en_inp" name="title_en"
                                    placeholder="example" value="{{ $book->title_en }}" readonly />
                                <label for="title_en_inp">{{ __('Enter the Book title') }}</label>
                            </div>
                            <p class="invalid-feedback" id="title_en"></p>


                        </div>
                        <div class="col-md-4 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('Price') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="price_inp" name="price"
                                    placeholder="example" value="{{ $book->price }}" readonly />
                                <label for="price_inp">{{ __('Enter the book price') }}</label>
                            </div>
                            <p class="invalid-feedback" id="price"></p>


                        </div>


                    </div>


                    <!-- begin :: Row -->
                    <div class="row mb-10">

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('Description in arabic') }}</label>
                            <textarea class="form-control" rows="4" name="description_ar" id="meta_tag_description_ar_inp" disabled>{{ $book->description_ar }}</textarea>
                            <p class="text-danger invalid-feedback" id="description_ar"></p>


                        </div>
                        <!-- end   :: Column -->

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('Description in english') }}</label>
                            <textarea class="form-control" rows="4" name="description_en" id="meta_tag_description_en_inp" disabled>{{ $book->description_en }}</textarea>
                            <p class="text-danger invalid-feedback" id="description_en"></p>

                        </div>
                        <!-- end   :: Column -->

                    </div>


                </div>
                <!-- end   :: Inputs wrapper -->

                <!-- begin :: Form footer -->
                <div class="form-footer">

                    <!-- begin :: Submit btn -->
                    <a href="{{ route('dashboard.employees.index') }}" class="btn btn-primary">
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
