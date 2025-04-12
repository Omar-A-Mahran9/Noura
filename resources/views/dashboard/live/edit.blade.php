@extends('partials.dashboard.master')

@section('content')
    <!-- begin :: Subheader -->
    <div class="toolbar">
        <div class="container-fluid d-flex flex-stack">
            <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">
                    <a href="{{ route('dashboard.lives.index') }}"
                        class="text-muted text-hover-primary">{{ __('lives') }}</a>
                </h1>
                <span class="h-20px border-gray-300 border-start mx-4"></span>
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <li class="breadcrumb-item text-muted">{{ __('Edit live') }}</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- end :: Subheader -->

    <div class="card">
        <div class="card-body p-0">
            <form action="{{ route('dashboard.lives.update', $live->id) }}" method="post" class="form"
                id="submitted-form"
                data-redirection-url="{{ route('dashboard.lives.index') }}">
                @csrf
                @method('PUT')

                <div class="card-header d-flex align-items-center">
                    <h3 class="fw-bolder text-dark">{{ __('Edit live') }}</h3>
                    <div class="form-check form-switch form-check-custom form-check-solid mb-2">
                        <label class="fs-5 fw-bold">{{ __('publish') }}</label>
                        <input class="form-check-input mx-2" style="height: 18px;width:36px;" type="checkbox" name="publish"
                            id="publish" {{ $live->publish ? 'checked' : '' }} />
                        <label class="form-check-label" for="publish"></label>
                    </div>
                </div>

                <div class="inputs-wrapper">
                    <div class="row mb-10">
                        <div class="col-md-12 d-flex justify-content-evenly">
                            <div class="d-flex flex-column align-items-center">
                                <label class="text-center fw-bold mb-4">{{ __('Image') }}</label>
                                <x-dashboard.upload-image-inp name="main_image" :image="$live->main_image" directory="Lives"
                                    placeholder="default.jpg" type="editable"></x-dashboard.upload-image-inp>
                                <p class="invalid-feedback" id="main_image"></p>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-8">
                        <div class="col-md-3 fv-row">
                            <label class="fs-5 fw-bold mb-2">{{ __('Title in arabic') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" name="title_ar" value="{{ $live->title_ar }}" />
                                <label>{{ __('Enter the lives title') }}</label>
                            </div>
                            <p class="invalid-feedback" id="title_ar"></p>
                        </div>

                        <div class="col-md-3 fv-row">
                            <label class="fs-5 fw-bold mb-2">{{ __('Title in english') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" name="title_en" value="{{ $live->title_en }}" />
                                <label>{{ __('Enter the lives title') }}</label>
                            </div>
                            <p class="invalid-feedback" id="title_en"></p>
                        </div>

                        <div class="col-md-3 fv-row">
                            <label class="fs-5 fw-bold mb-2">{{ __('Price') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" name="price" value="{{ $live->price }}" />
                                <label>{{ __('Enter the lives price') }}</label>
                            </div>
                            <p class="invalid-feedback" id="price"></p>
                        </div>

                        <div class="col-md-3 fv-row">
                            <label class="fs-5 fw-bold mb-2">{{ __('Assign to specialist') }}</label>
                            <div class="form-floating">
                                <select class="form-select" data-control="select2" name="assign_to"
                                    data-placeholder="{{ __('Assign to specialist') }}"
                                    data-dir="{{ isArabic() ? 'rtl' : 'ltr' }}">
                                    <option value=""></option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}"
                                            {{ $live->assign_to == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <p class="invalid-feedback" id="assign_to"></p>
                        </div>
                    </div>

                    <div class="row mb-10">
                        <div class="col-md-6 fv-row">
                            <label class="fs-5 fw-bold mb-2">{{ __('Description in arabic') }}</label>
                            <textarea class="form-control" name="description_ar" rows="4">{{ $live->description_ar }}</textarea>
                            <p class="invalid-feedback" id="description_ar"></p>
                        </div>

                        <div class="col-md-6 fv-row">
                            <label class="fs-5 fw-bold mb-2">{{ __('Description in english') }}</label>
                            <textarea class="form-control" name="description_en" rows="4">{{ $live->description_en }}</textarea>
                            <p class="invalid-feedback" id="description_en"></p>
                        </div>
                    </div>

                    <div class="row mb-10">
                        <div class="col-md-3 fv-row">
                            <label class="fs-5 fw-bold mb-2">{{ __('Day Date') }}</label>
                            <input type="date" name="day_date" class="form-control"
                                value="{{ $live->day_date }}">
                            <p class="invalid-feedback" id="day_date"></p>
                        </div>

                        <div class="col-md-3 fv-row">
                            <label class="fs-5 fw-bold mb-2">{{ __('Start Time From') }}</label>
                            <input type="time" name="from" class="form-control" value="{{ $live->from }}">
                            <p class="invalid-feedback" id="from"></p>
                        </div>

                        <div class="col-md-3 fv-row">
                            <label class="fs-5 fw-bold mb-2">{{ __('End Time To') }}</label>
                            <input type="time" name="to" class="form-control" value="{{ $live->to }}">
                            <p class="invalid-feedback" id="to"></p>
                        </div>

                        <div class="col-md-3 fv-row">
                            <label class="fs-5 fw-bold mb-2">{{ __('Video URL') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" name="video_url"
                                    value="{{ $live->video_url }}" />
                                <label>{{ __('Enter the video url') }}</label>
                            </div>
                            <p class="invalid-feedback" id="video_url"></p>
                        </div>
                    </div>
                </div>

                <div class="form-footer">
                    <button type="submit" class="btn btn-primary" id="submit-btn">
                        <span class="indicator-label">{{ __('Save') }}</span>
                        <span class="indicator-progress">{{ __('Please wait ...') }}
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
