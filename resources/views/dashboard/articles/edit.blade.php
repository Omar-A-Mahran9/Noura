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
                        href="{{ route('dashboard.articles.index') }}"
                        class="text-muted text-hover-primary">{{ __('articles') }}</a></h1>
                <!-- end   :: Title -->

                <!-- begin :: Separator -->
                <span class="h-20px border-gray-300 border-start mx-4"></span>
                <!-- end   :: Separator -->

                <!-- begin :: Breadcrumb -->
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <!-- begin :: Item -->
                    <li class="breadcrumb-item text-muted">
                        {{ __('Edit an article') }}
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
            <form action="{{ route('dashboard.articles.update', $article->id) }}" class="form" method="post"
                id="submitted-form" data-redirection-url="{{ route('dashboard.articles.index') }}">
                @csrf
                @method('PUT')
                <!-- begin :: Card header -->
                <div class="card-header d-flex align-items-center">
                    <h3 class="fw-bolder text-dark">{{ __('Edit an article') . ' : ' . $article->title }}</h3>

                    <div class="form-check form-switch form-check-custom form-check-solid mb-2">
                        <label class="fs-5 fw-bold">{{ __('publish') }}</label>
                        <!-- Set the checkbox state based on the 'publish' field -->
                        <input class="form-check-input mx-2" style="height: 18px;width:36px;" type="checkbox" name="publish"
                            id="publish" value="1" {{ $article->publish ? 'checked' : '' }} />
                        <label class="form-check-label" for="publish"></label>
                    </div>
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
                                    <x-dashboard.upload-image-inp name="main_image" :image="$article['main_image']" directory="articles"
                                        placeholder="default.jpg" type="editable"></x-dashboard.upload-image-inp>
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
                                    placeholder="example" value="{{ $article->title_ar }}" />
                                <label for="title_ar_inp">{{ __('Enter the article title') }}</label>
                            </div>
                            <p class="invalid-feedback" id="title_ar"></p>
                        </div>
                        <!-- begin :: Column -->
                        <div class="col-md-4 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('Title in english') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="title_en_inp" name="title_en"
                                    placeholder="example" value="{{ $article->title_en }}" />
                                <label for="title_en_inp">{{ __('Enter the article title') }}</label>
                            </div>
                            <p class="invalid-feedback" id="title_en"></p>





                        </div>

                        <div class="col-md-4 fv-row">
                            <label class="fs-5 fw-bold mb-2">{{ __('Category') }}</label>
                            <select class="form-select" data-control="select2" name="category_id[]" multiple
                                id="category-sp" data-placeholder="{{ __('Choose the category') }}"
                                data-dir="{{ isArabic() ? 'rtl' : 'ltr' }}">
                                @foreach ($categories as $category)
                                    <option @if (in_array($category->id, $selectedCategoriesIds)) selected @endif
                                        value="{{ $category['id'] }}">
                                        {{ $category['name'] }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="invalid-feedback" id="category_id"></p>
                        </div>
                    </div>

                    <!-- begin :: Row -->
                    <div class="row mb-10">

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('Description in arabic') }}</label>
                            {{-- <textarea class="form-control" rows="4" name="description_ar" id="meta_tag_description_ar_inp">{{ $article->description_ar }}</textarea> --}}

                            <textarea id="tinymce_description_ar" name="description_ar" class="tinymce">{{ $article->description_ar ?? 'Default Description' }}</textarea>

                            <p class="text-danger invalid-feedback" id="description_ar"></p>


                        </div>
                        <!-- end   :: Column -->

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('Description in english') }}</label>
                            {{-- <textarea class="form-control" rows="4" name="description_en" id="meta_tag_description_en_inp">{{ $article->description_en }}</textarea> --}}
                            <textarea id="tinymce_description_en" name="description_en" class="tinymce">{{ $article->description_en }}</textarea>

                            <p class="text-danger invalid-feedback" id="description_en"></p>

                        </div>
                        <!-- end   :: Column -->

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
    <script src="{{ asset('dashboard-assets/plugins/custom/tinymce/tinymce.bundle.js') }}"></script>

    <script>
        $(document).ready(() => {

            initTinyMc(true);


        })
    </script>
@endpush
