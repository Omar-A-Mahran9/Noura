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
                        href="{{ route('dashboard.employees.index') }}"
                        class="text-muted text-hover-primary">{{ __('Employees') }}</a></h1>
                <!-- end   :: Title -->

                <!-- begin :: Separator -->
                <span class="h-20px border-gray-300 border-start mx-4"></span>
                <!-- end   :: Separator -->

                <!-- begin :: Breadcrumb -->
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <!-- begin :: Item -->
                    <li class="breadcrumb-item text-muted">
                        {{ __('Employee data') }}
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
                    <h3 class="fw-bolder text-dark">{{ __('Employee') . ' : ' . $employee->name }}</h3>
                </div>
                <!-- end   :: Card header -->

                <!-- begin :: Inputs wrapper -->
                <div class="inputs-wrapper">


                    <!-- begin :: Row -->
                    <div class="row mb-8">

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('Name') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="name_inp" name="name"
                                    value="{{ $employee->name }}" readonly />
                                <label for="name_inp">{{ __('Enter the name') }}</label>
                            </div>
                            <p class="invalid-feedback" id="name"></p>


                        </div>
                        <!-- end   :: Column -->

                        <!-- begin :: Column -->
                        {{-- <div class="col-md-6 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('Phone') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="phone_inp" name="phone"
                                    value="{{ $employee['phone'] }}" readonly />
                                <label for="phone_inp">{{ __('Enter the phone') }}</label>
                            </div>
                            <p class="invalid-feedback" id="phone"></p>


                        </div> --}}

                        <div class="col-md-6 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('Phone') }}</label>
                            {{-- <div class="form-floating">
                                <input type="text" class="form-control" id="phone_inp" name="phone"
                                    placeholder="example" />
                                <label for="phone_inp">{{ __('Enter the phone') }}</label>


                            </div>   --}}
                            <div class="input-group   mb-5">

                                <input type="tel" name="phone" id="phone_inp" value="{{ $employee['phone'] }}"
                                    class="form-control form-control-lg  " readonly
                                    placeholder="{{ __('Enter the phone') }}" />
                                <span class="input-group-text">+966</span>
                            </div>
                            <p class="invalid-feedback" id="phone"></p>


                        </div>
                        <!-- end   :: Column -->

                    </div>
                    <!-- end   :: Row -->

                    <!-- begin :: Row -->
                    <div class="row mb-8">

                        <!-- begin :: Column -->
                        <div class="col-md-4 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('Email') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="email_inp" name="email"
                                    value="{{ $employee['email'] }}" readonly />
                                <label for="email_inp">{{ __('Enter the email') }}</label>
                            </div>
                            <p class="invalid-feedback" id="email"></p>


                        </div>
                        <!-- end   :: Column -->

                        <!-- begin :: Column -->
                        <div class="col-md-4 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('Roles') }}</label>
                            <div class="form-floating">
                                <select class="form-select py-1" data-control="select2" name="roles[]" multiple
                                    id="roles-sp" data-placeholder="{{ __('Choose the roles') }}"
                                    data-dir="{{ isArabic() ? 'rtl' : 'ltr' }}" disabled>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}"
                                            {{ $employee->roles->pluck('id')->contains($role->id) ? 'selected' : '' }}>
                                            {{ $role->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <p class="invalid-feedback" id="roles"></p>

                        </div>
                        <!-- end   :: Column -->

                        <div class="col-md-4 fv-row">
                            <label class="fs-5 fw-bold mb-2">{{ __('User Type') }}</label>
                            <select class="form-select" name="type" id="type" data-control="select2" disabled
                                data-placeholder="{{ __('User Type') }}" data-dir="{{ isArabic() ? 'rtl' : 'ltr' }}">
                                @foreach ($userTypes as $index => $type)
                                    <option value="{{ $type }}"
                                        {{ old('type', $employee->type) == $type ? 'selected' : '' }}>
                                        {{ __($type) }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="invalid-feedback" id="type"></p>
                        </div>


                    </div>
                    <!-- end   :: Row -->



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
