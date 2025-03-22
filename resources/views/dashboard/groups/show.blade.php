@extends('partials.dashboard.master')
@section('content')
    <!-- begin :: Subheader -->
    <div class="toolbar">

        <div class="container-fluid d-flex flex-stack">

            <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">

                <!-- begin :: Title -->
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">
                    <a href="{{ route('dashboard.group_chat.index') }}"
                        class="text-muted text-hover-primary">{{ __('Groups') }}</a>
                </h1>
                <!-- end   :: Title -->

                <!-- begin :: Separator -->
                <span class="h-20px border-gray-300 border-start mx-4"></span>
                <!-- end   :: Separator -->

                <!-- begin :: Breadcrumb -->
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <!-- begin :: Item -->
                    <li class="breadcrumb-item text-muted">
                        {{ __('Groups list') }}
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

            <form action="{{ route('dashboard.group_chat.update', ['group_chat' => $group->id]) }}" class="form"
                method="post" id="submitted-form" data-redirection-url="{{ route('dashboard.group_chat.index') }}">
                @csrf
                @method('PUT')
                <!-- begin :: Card header -->
                <div class="card-header d-flex align-items-center">
                    <h3 class="fw-bolder text-dark">{{ __('Edit group') }}</h3>
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
                                    <x-dashboard.upload-image-inp name="image" :image="$group['image']" directory="groups"
                                        placeholder="default.jpg" type="show"></x-dashboard.upload-image-inp>
                                </div>
                                <p class="invalid-feedback" id="image"></p>
                                <!-- end   :: Upload image component -->
                            </div>
                        </div>
                        <!-- end   :: Column -->
                    </div>
                    <!-- end   :: Row -->

                    <!-- begin :: Row -->
                    <div class="row mb-10">
                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">
                            <label class="fs-5 fw-bold mb-2">{{ __('Name in arabic') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="name_ar_inp" name="name_ar"
                                    value="{{ $group->name_ar }}" placeholder="example" disabled />
                                <label for="name_ar_inp">{{ __('Enter the name in arabic') }}</label>
                            </div>
                            <p class="invalid-feedback" id="name_ar"></p>
                        </div>
                        <!-- end   :: Column -->

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">
                            <label class="fs-5 fw-bold mb-2">{{ __('Name in english') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="name_en_inp" name="name_en"
                                    value="{{ $group->name_en }}" placeholder="example" disabled />
                                <label for="name_en_inp">{{ __('Enter the name in english') }}</label>
                            </div>
                            <p class="invalid-feedback" id="name_en"></p>
                        </div>
                    </div>
                    <!-- end   :: Row -->

                    <!-- begin :: Row -->
                    <div class="row mb-10">
                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">
                            <label class="fs-5 fw-bold mb-2">{{ __('Description in arabic') }}</label>
                            <textarea class="form-control" rows="4" name="description_ar" id="meta_tag_description_ar_inp" readonly>{{ $group->description_ar }}</textarea>
                            <p class="text-danger invalid-feedback" id="description_ar"></p>
                        </div>
                        <!-- end   :: Column -->

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">
                            <label class="fs-5 fw-bold mb-2">{{ __('Description in english') }}</label>
                            <textarea class="form-control" rows="4" name="description_en" id="meta_tag_description_en_inp" readonly>{{ $group->description_en }}</textarea>
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
    <div class="row g-3 mt-4">
        <!-- Group Vendors -->
        <div class="col-md-4">
            <div class="card ">
                <div class="card-header">
                    <h3 class="fw-bolder text-dark">{{ __('Group Vendors') }}</h3>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach ($group->vendors as $vendor)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <img src="{{ getImagePathFromDirectory($vendor->image, 'ProfileImages') }}"
                                        alt="{{ $vendor->name }}" class="rounded-circle me-2" width="40"
                                        height="40">
                                    <span>{{ $vendor->name }}</span>
                                </div>
                                <a href="{{ route('dashboard.vendors.show', $vendor->id) }}"
                                    class="btn btn-sm btn-primary">
                                    {{ __('View') }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>

        <!-- Group Messages -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="fw-bolder text-dark">{{ __('Group Messages') }}</h3>
                </div>
                <div class="card-body">
                    @if ($group->messages->isNotEmpty())
                        @foreach ($group->messages as $message)
                            <div class="chat-message border-bottom py-3 d-flex align-items-start justify-content-between">
                                <!-- Message Left (Image & Content) -->
                                <div class="d-flex align-items-start">
                                    <!-- Vendor Image -->
                                    <img src="{{ getImagePathFromDirectory($message->vendor->image, 'ProfileImages') }}"
                                        alt="{{ $message->vendor->name }}" class="rounded-circle me-3" width="40"
                                        height="40">

                                    <!-- Message Content -->
                                    <div>
                                        <strong class="d-block text-secondary">{{ $message->vendor->name }}</strong>
                                        <p class="mb-1">{{ $message->message }}</p>
                                        @if ($message->file)
                                            <a href="{{ asset($message->file) }}" target="_blank" class="text-primary">
                                                📎 View Attachment
                                            </a>
                                        @endif
                                    </div>
                                </div>

                                <form action="{{ route('dashboard.destroymessage', $message->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this message?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> <!-- FontAwesome Trash Icon -->
                                    </button>
                                </form>

                            </div>
                        @endforeach
                    @else
                        <p class="text-muted">{{ __('No messages yet.') }}</p>
                    @endif
                </div>
            </div>
        </div>


    </div>







@endsection
