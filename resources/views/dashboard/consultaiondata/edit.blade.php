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
                        class="text-muted text-hover-primary">{{ __('books') }}</a></h1>
                <!-- end   :: Title -->

                <!-- begin :: Separator -->
                <span class="h-20px border-gray-300 border-start mx-4"></span>
                <!-- end   :: Separator -->

                <!-- begin :: Breadcrumb -->
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <!-- begin :: Item -->
                    <li class="breadcrumb-item text-muted">
                        {{ __('Edit an book') }}
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
            <form action="{{ route('dashboard.books.update', $book->id) }}" class="form" method="post"
                id="submitted-form" data-redirection-url="{{ route('dashboard.books.index') }}">
                @csrf
                @method('PUT')
                <!-- begin :: Card header -->
                <div class="card-header d-flex align-items-center">
                    <h3 class="fw-bolder text-dark">{{ __('Edit an book') . ' : ' . $book->title }}</h3>
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
                                    <x-dashboard.upload-image-inp name="main_image" :image="$book['main_image']" directory="books"
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
                                    placeholder="example" value="{{ $book->title_ar }}" />
                                <label for="title_ar_inp">{{ __('Enter the book title') }}</label>
                            </div>
                            <p class="invalid-feedback" id="title_ar"></p>
                        </div>
                        <!-- begin :: Column -->
                        <div class="col-md-4 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('Title in english') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="title_en_inp" name="title_en"
                                    placeholder="example" value="{{ $book->title_en }}" />
                                <label for="title_en_inp">{{ __('Enter the book title') }}</label>
                            </div>
                            <p class="invalid-feedback" id="title_en"></p>


                        </div>
                        <div class="col-md-4 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('Price') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="price_inp" name="price"
                                    placeholder="example" value="{{ $book->price }}" />
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
                            <textarea class="form-control" rows="4" name="description_ar" id="meta_tag_description_ar_inp">{{ $book->description_ar }}</textarea>
                            <p class="text-danger invalid-feedback" id="description_ar"></p>


                        </div>
                        <!-- end   :: Column -->

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('Description in english') }}</label>
                            <textarea class="form-control" rows="4" name="description_en" id="meta_tag_description_en_inp">{{ $book->description_en }}</textarea>
                            <p class="text-danger invalid-feedback" id="description_en"></p>

                        </div>
                        <!-- end   :: Column -->

                    </div>
                    <div class="row mb-10">
                        <!-- PDF File -->
                        <div class="col-md-4 fv-row">
                            <label class="form-label">{{ __('PDF File') }}</label>
                            <input type="file" class="form-control" name="pdf_path" id="pdf_path_inp">
                            <p class="invalid-feedback" id="pdf_path"></p>

                            <!-- PDF Preview -->
                            @if ($book->pdf_path)
                                <div class="mt-2">

                                    <a href="{{ getImagePathFromDirectory($book->pdf_path, 'Books/pdf') }}" target="_blank"
                                        class="btn btn-sm btn-primary">
                                        {{ __('View PDF') }}
                                    </a>
                                </div>
                            @endif
                        </div>

                        <!-- Stock -->
                        <div class="col-md-4 fv-row">
                            <label class="fs-5 fw-bold mb-2">{{ __('Stock') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="stock_inp" name="stock"
                                    value="{{ $book->stock ?? '' }}" placeholder="example">
                                <label for="stock_inp">{{ __('Enter the stock') }}</label>
                            </div>
                            <p class="invalid-feedback" id="stock"></p>
                        </div>

                        <!-- More Images -->
                        <div class="col-md-4 fv-row">
                            <label class="form-label">{{ __('More Images') }}</label>
                            <input multiple type="file" class="form-control" name="images[]" id="image_path_inp">
                            <p class="invalid-feedback" id="images"></p>
                            <div class="d-flex">
                                <div style="margin-top: 10px; display: flex; gap: 10px; flex-wrap: wrap;">
                                    @foreach ($book->bookImages as $image)
                                        <div style="position: relative; display: inline-block;">
                                            <img src="{{ getImagePathFromDirectory($image->image, 'Books/images') }}"
                                                style="width: 100px; height: 100px; object-fit: cover; border-radius: 10px;">
                                            <a class="delete-image-btn" data-image-id="{{ $image->id }}"
                                                style="position: absolute; top: 5px; right: 5px; border: none; background: transparent; padding: 0; cursor: pointer;">
                                                <i class="fas fa-times" style="color: red; font-size: 20px;"></i>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>

                                <div id="image_preview"
                                    style="margin-top: 10px; display: flex; gap: 10px; flex-wrap: wrap;">
                                </div>
                            </div>

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
    <script>
        $(document).ready(function() {
            $('.delete-image-btn').click(function(e) {
                e.preventDefault(); // Prevent the form submission

                // Get the image ID from the data attribute
                var imageId = $(this).data('image-id');

                // Confirm before deletion
                if (confirm('Do you want to remove this image?')) {
                    // Send an AJAX request
                    $.ajax({
                        url: '/dashboard/bookImages/' + imageId, // URL to the route
                        type: 'POST', // HTTP method
                        data: {
                            _token: '{{ csrf_token() }}', // CSRF Token for security
                        },
                        success: function(response) {
                            // On success, remove the image from the UI
                            $('#image_' + imageId).fadeOut(30, function() {
                                $(this).remove();
                            });
                            window.location.reload();
                        },
                        error: function(xhr, status, error) {
                            alert('An error occurred while deleting the image.');
                        }
                    });
                }
            });
        });
    </script>
@endpush
