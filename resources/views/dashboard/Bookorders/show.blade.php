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
                                            <span><i class="fa fa-store mx-2"></i></span> {{ __('Vendor') }}
                                        </div>
                                    </td>
                                    <td class="fw-bolder text-end">{{ $order->vendor->name ?? 'N/A' }}
                                        ({{ $order->vendor->phone ?? 'N/A' }})</td>
                                </tr>
                                {{-- <!-- Book -->
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <span><i class="fa fa-book mx-2"></i></span> {{ __('Book') }}
                                        </div>
                                    </td>
                                    <td class="fw-bolder text-end">{{ $order->book->title_ar ?? 'N/A' }} /
                                        {{ $order->book->title_en ?? 'N/A' }}</td>
                                </tr>
                                <!-- Course -->
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <span><i class="fa fa-graduation-cap mx-2"></i></span> {{ __('Course') }}
                                        </div>
                                    </td>
                                    <td class="fw-bolder text-end">{{ $order->course->name_ar ?? 'N/A' }} /
                                        {{ $order->course->name_en ?? 'N/A' }}</td>
                                </tr> --}}
                                <!-- Consultation -->
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <span><i class="fa fa-comments mx-2"></i></span> {{ __('Consultation') }}
                                        </div>
                                    </td>
                                    <td class="fw-bolder text-end">{{ $order->consultation->title ?? 'N/A' }}</td>
                                </tr>
                                <!-- Consultation Type -->
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <span><i class="fa fa-tag mx-2"></i></span> {{ __('Consultation Type') }}
                                        </div>
                                    </td>
                                    <td class="fw-bolder text-end">{{ $order->consultaionType->name ?? 'N/A' }} </td>
                                </tr>
                                <!-- Consultation Schedule -->
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <span><i class="fa fa-calendar-alt mx-2"></i></span>
                                            {{ __('Consultation Schedule') }}
                                        </div>
                                    </td>
                                    <td class="fw-bolder text-end">
                                        @if ($order->consultaionSchedual)
                                            <div class="d-block">
                                                <span class="d-block text-gray-700">
                                                    {{ \Carbon\Carbon::parse($order->consultaionSchedual->date)->translatedFormat('l, d M Y') }}
                                                </span>

                                                <span class="d-block   fw-bold">
                                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $order->consultaionSchedual->time)->format('h:i A') }}
                                                </span>
                                            </div>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
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

        <!--begin::Tab content-->
        <div class="tab-content">
            <!--begin::Tab pane-->
            <div class="tab-pane fade show active" id="kt_ecommerce_sales_order_summary" role="tab-panel">

                <div class="d-flex flex-column gap-7 gap-lg-10">
                    <!--begin::Product List-->
                    <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>{{ __('Answer Question Order') }} #{{ $order['id'] . ' ' }} </h2>
                            </div>
                            <div class="card-title">
                                <h2>{{ __('Order Type') . ' : ' }} {{ __(str_replace('_', ' ', $order['type'])) . ' ' }}
                                </h2>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card Body-->
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                                    <!-- Table Head -->
                                    <thead>
                                        <tr>
                                            <th class="fw-bold">{{__("Questions")}}</th>
                                            <th class="fw-bold">{{__("Answeres")}}</th>
                                        </tr>
                                    </thead>
                                    <!-- Table Body -->
                                    <tbody class="fw-bold text-gray-600">
                                        @if ($order->quiz && $order->quiz->questions->count())
                                            @foreach ($order->quiz->questions as $question)
                                                <tr>
                                                    <!-- Question Column -->
                                                    <td>{{ $question->name }}</td>

                                                    <!-- Answer Column -->
                                                    <td>
                                                        @php
                                                            $answers = $vendorAnswers->where('question_id', $question->id);
                                                        @endphp

                                                        @if ($question->type === 'text')
                                                            {{-- Display text answer --}}
                                                            @if ($answers->isNotEmpty())
                                                                <span class="text-info">{{ $answers->first()->text_answer }}</span>
                                                            @else
                                                                <span class="text-muted">No answer provided</span>
                                                            @endif

                                                        @elseif ($question->type === 'single' || $question->type === 'true_false')
                                                            {{-- Display single selected answer --}}
                                                            @php
                                                                $selectedAnswer = $answers->first();
                                                                $quizAnswer = $question->answers->where('id', $selectedAnswer->answer_id ?? null)->first();
                                                            @endphp
                                                            @if ($quizAnswer)
                                                                <span class="badge bg-success">{{ $quizAnswer->name }}</span>
                                                            @else
                                                                <span class="text-muted">No answer selected</span>
                                                            @endif

                                                        @elseif ($question->type === 'multiple')
                                                            {{-- Display multiple selected answers --}}
                                                            @php
                                                                $selectedAnswers = $question->answers->whereIn('id', $answers->pluck('answer_id'));
                                                            @endphp
                                                            @if ($selectedAnswers->isNotEmpty())
                                                                @foreach ($selectedAnswers as $answer)
                                                                    <span class="badge bg-primary">{{ $answer->name }}</span>
                                                                @endforeach
                                                            @else
                                                                <span class="text-muted">No answers selected</span>
                                                            @endif
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="2" class="text-muted text-center">No questions available for this order.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>


                            </div>
                        </div>
                        <!--end::Card Body-->
                    </div>
                    <!--end::Product List-->
                </div>



            </div>
            <!--end::Tab pane-->
            <!--begin::Tab pane-->
            <div class="tab-pane fade" id="kt_ecommerce_sales_order_history" role="tab-panel">
                <!--begin::Orders-->
                <div class="d-flex flex-column gap-7 gap-lg-10">
                    <!--begin::Order history-->
                    <div class="card card-flush py-4 flex-row-fluid">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>{{ __('Order History') }}</h2>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle text-center table-row-dashed fs-6 gy-5 mb-0">
                                    <!--begin::Table head-->
                                    <thead>
                                        <tr class="text-center text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                            <th class="min-w-70px">{{ __('Order Status') }}</th>
                                            <th class="min-w-175px">{{ __('Comment') }}</th>
                                            <th class="min-w-100px">{{ __('Employee') }}</th>
                                            <th class="min-w-100px">{{ __('Date') }}</th>
                                        </tr>
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fw-bold text-gray-600">

                                    </tbody>
                                    <!--end::Table head-->
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Order history-->
                </div>
                <!--end::Orders-->
            </div>
            <!--end::Tab pane-->
        </div>
        <!--end::Tab content-->
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
