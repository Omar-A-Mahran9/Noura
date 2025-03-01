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
                        href="{{ route('dashboard.vendors.index') }}"
                        class="text-muted text-hover-primary">{{ __('Vendors') }}</a></h1>
                <!-- end   :: Title -->

                <!-- begin :: Separator -->
                <span class="h-20px border-gray-300 border-start mx-4"></span>
                <!-- end   :: Separator -->

                <!-- begin :: Breadcrumb -->
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <!-- begin :: Item -->
                    <li class="breadcrumb-item text-muted">
                        {{ __('Edit a vendor') }}
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
            <form action="{{ route('dashboard.vendors.update', $vendor->id) }}" class="form" method="post"
                id="submitted-form" data-redirection-url="{{ route('dashboard.vendors.index') }}">
                @csrf
                @method('PUT')
                <!-- begin :: Card header -->
                <div class="card-header d-flex align-items-center">
                    <h3 class="fw-bolder text-dark">{{ __('Edit vendor') . ' : ' . $vendor->name }}</h3>
                </div>
                <!-- end   :: Card header -->

                <!-- begin :: Inputs wrapper -->
                <div class="inputs-wrapper">

                    <!-- begin :: Row -->
                    <div class="row mb-10">
                        <!-- begin :: Column -->
                        <div class="col-md-12 fv-row d-flex justify-content-center">
                            <div class="d-flex flex-column">
                                <!-- begin :: Upload image component -->
                                <label class="text-center fw-bold mb-4">{{ __('Image') }}</label>
                                <x-dashboard.upload-image-inp name="image" :image="$vendor->image" directory="Vendors"
                                    placeholder="default.jpg" type="editable"></x-dashboard.upload-image-inp>
                                <p class="invalid-feedback" id="image"></p>
                                <!-- end   :: Upload image component -->
                            </div>
                        </div>
                        <!-- end   :: Column -->
                    </div>
                    <!-- end   :: Row -->

                    <!-- begin :: Row -->
                    <div class="row mb-8">

                        <!-- begin :: Column -->
                        <div class="col-md-4 fv-row">
                            <label class="fs-5 fw-bold mb-2">{{ __('Name') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="name_inp" name="name"
                                    value="{{ $vendor->name }}" placeholder="example" />
                                <label for="name_inp">{{ __('Enter the name') }}</label>
                            </div>
                            <p class="invalid-feedback" id="name"></p>
                        </div>
                        <!-- end   :: Column -->

                        <!-- begin :: Column -->
                        <div class="col-md-4 fv-row">
                            <label class="fs-5 fw-bold mb-2">{{ __('Phone') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="phone_inp" name="phone"
                                    value="{{ $vendor->phone }}" placeholder="example" />
                                <label for="phone_inp">{{ __('Enter the phone') }}</label>
                            </div>
                            <p class="invalid-feedback" id="phone"></p>
                        </div>
                        <!-- end   :: Column -->
  <!-- begin :: Column -->
  <div class="col-md-4 fv-row">
    <label class="fs-5 fw-bold mb-2">{{ __('Status') }}</label>
    <select class="form-select" name="status" id="status-sp"
        data-placeholder="{{ __('Choose the status') }}"
        data-dir="{{ isArabic() ? 'rtl' : 'ltr' }}">
        <option value=""></option>
        @foreach (App\Enums\VendorStatus::values() as $key => $value)
            <option value="{{ $key }}" {{ $vendor->status == $key ? 'selected' : '' }}>
                {{ __(ucfirst($value)) }}</option>
        @endforeach
    </select>
    <p class="invalid-feedback" id="status"></p>
</div>
<!-- end   :: Column -->


                    </div>
                    <!-- end   :: Row -->
 

                    <!-- begin :: Row -->
                    <div class="row mb-8"
                        style="{{ $vendor->status != App\Enums\VendorStatus::rejected->value ? 'display: none;' : '' }}"
                        id="rejection_container">

                        <!-- begin :: Column -->
                        <div class="col-12 fv-row">
                            <label class="fs-5 fw-bold mb-2">{{ __('Rejection reason') }}</label>
                            <div class="form-floating">
                                <textarea rows="5" class="form-control" id="rejection_reason_inp" name="rejection_reason" placeholder="example"></textarea>
                                <label for="rejection_reason_inp">{{ __('Enter the rejection reason') }}</label>
                            </div>
                            <p class="invalid-feedback" id="rejection_reason"></p>
                        </div>
                        <!-- end   :: Column -->

                    </div>
                    <!-- end   :: Row -->



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
        $(document).ready(function() {
            let typeSp = $("#type-sp");
            typeSp.change(function(e) {
                e.preventDefault();
                if ($(this).val() == 'individual') {
                    $("#commercial_container").fadeOut();
                    $("#commercial_registration_no_inp").val('');
                    $("#identity_container").fadeIn();
                } else {
                    $("#identity_container").fadeOut();
                    $("#identity_no_inp").val('');
                    $("#commercial_container").fadeIn();
                }
            });

            let statusSp = $("#status-sp");
            statusSp.change(function(e) {
                e.preventDefault();
                if ($(this).val() == "{{ App\Enums\VendorStatus::rejected->value }}")
                    $("#rejection_container").fadeIn();
                else {
                    $("#rejection_container").fadeOut();
                    $("#rejection_reason_inp").val('')
                }
            });

            typeSp.val("{{ $vendor->type }}").change();
            statusSp.val("{{ $vendor->status }}").change();
        });
    </script>
@endpush
