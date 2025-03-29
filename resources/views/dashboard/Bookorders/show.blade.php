@extends('partials.dashboard.master')
@section('content')
    <!-- begin :: Subheader -->
    <div class="toolbar">

        <div class="container-fluid d-flex flex-stack">

            <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">

                <!-- begin :: Title -->
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1"><a href=""
                        class="text-muted text-hover-primary">{{ __('Orders') }}</a></h1>
                <!-- end   :: Title -->

                <!-- begin :: Separator -->
                <span class="h-20px border-gray-300 border-start mx-4"></span>
                <!-- end   :: Separator -->

                <!-- begin :: Breadcrumb -->
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <!-- begin :: Item -->
                    <li class="breadcrumb-item text-muted">
                        {{ __('Order data') }}
                    </li>
                    <!-- end   :: Item -->
                </ul>
                <!-- end   :: Breadcrumb -->

            </div>

        </div>

    </div>
    <!-- end   :: Subheader -->

    <!--begin::Order details page-->
    <div class="d-flex flex-column gap-7 gap-lg-10">
        <div class="d-flex flex-wrap flex-stack gap-5 gap-lg-10">
            <!--begin:::Tabs-->
            <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-lg-n2 me-auto">
                <!--begin:::Tab item-->
                <li class="nav-item">
                    <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                        href="#kt_ecommerce_sales_order_summary">{{ __('Order Summary') }}</a>
                </li>
                <!--end:::Tab item-->
                <!--begin:::Tab item-->
                {{-- <li class="nav-item">
                    <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                        href="#kt_ecommerce_sales_order_history">{{ __('Order History') }}</a>
                </li> --}}
                <!--end:::Tab item-->
            </ul>
            <!--end:::Tabs-->


            <div class="w-200px">
                <!--begin::Select2-->

                <!--end::Select2-->
            </div>


        </div>
        <!--begin::Order summary-->
        <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
            <!--begin::Order details-->
            <div class="card card-flush py-4 flex-row-fluid">
                <!--begin::Card header-->
                <div class="card-header">
                    <div class="card-title">
                        <h2>{{ __('Order Details') }} ( #{{ $order->id }} )</h2>
                    </div>
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-300px">
                            <tbody class="fw-bold text-gray-600">
                                <!-- Date -->
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <span><i class="fa fa-calendar mx-2"></i></span> {{ __('Date') }}
                                        </div>
                                    </td>
                                    <td class="fw-bolder text-end">{{ $order->created_at->format('Y-m-d') }}</td>
                                </tr>
                                <!-- Time -->
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <span><i class="fa fa-clock mx-2"></i></span> {{ __('Time') }}
                                        </div>
                                    </td>
                                    <td class="fw-bolder text-end">{{ $order->created_at->format('H:i A') }}</td>
                                </tr>
                                <!-- Vendor -->
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <span><i class="fa fa-book mx-2"></i></span> {{ __('Book') }}
                                        </div>
                                    </td>
                                    <td class="fw-bolder text-end">{{ $order->book->title ?? 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <span><i class="fa fa-store mx-2"></i></span> {{ __('Quantity') }}
                                        </div>
                                    </td>
                                    <td class="fw-bolder text-end">{{ $order->quantity?? 'N/A' }}
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <span><i class="fa fa-store mx-2"></i></span> {{ __('Type of book') }}
                                        </div>
                                    </td>
                                    <td class="fw-bolder text-end">{{ __($order->type_of_book)?? 'N/A' }}
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                        <!--end::Table-->
                    </div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Order details-->

            <!--begin::Customer details-->
            <div class="card card-flush py-4 flex-row-fluid">
                <!--begin::Card header-->
                <div class="card-header">
                    <div class="card-title">
                        <h2>{{ __('Customer Details') }}</h2>
                    </div>
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-300px">
                            <tbody class="fw-bold text-gray-600">
                                <!-- Customer Name -->
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <span><i class="fa fa-user mx-2"></i></span> {{ __('Customer') }}
                                        </div>
                                    </td>
                                    <td class="fw-bolder text-end">
                                        <a href="#" class="text-gray-600 text-hover-primary">
                                            {{ $order->vendor->name ?? 'N/A' }}
                                        </a>
                                    </td>
                                </tr>
                                <!-- Customer Phone -->
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <span><i class="fa fa-phone mx-2"></i></span> {{ __('Phone') }}
                                        </div>
                                    </td>
                                    <td class="fw-bolder text-end">{{ $order->vendor->phone ?? 'N/A' }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <!--end::Table-->
                    </div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Customer details-->
        </div>
        <!--end::Order summary-->


    </div>
    <!--end::Order details page-->
@endsection
@push('scripts')
    <script>
        $('#order-status-sp').change(function() {

            let newStatus = $(this).val();
            let comment = '';

            inputAlert().then((result) => {

                comment = result.value[0] || '';

                if (result.isConfirmed) {
                    $.ajax({
                        url: "/dashboard/change-status/" + "{{ $order['id'] }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method: 'POST',
                        data: {
                            status: newStatus,
                            comment
                        },
                        success: (response) => {
                            successAlert('{{ __('status has been changed successfully') }}')
                                .then(() => window.location.reload())
                        },
                        error: (error) => {
                            console.log(error)
                        },

                    });
                }

            });


        });
    </script>
@endpush
