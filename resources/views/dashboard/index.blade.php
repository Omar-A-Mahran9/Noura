@extends('partials.dashboard.master')
@section('content')
    <div class="toolbar">
        <div class="container-fluid d-flex flex-stack">
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">{{ __('Dashboard') }}</h1>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <a href="/" target="_blank" class="btn btn-sm btn-primary">
                    <i class="bi bi-globe fs-6"></i> {{ __('website') }}
                </a>
            </div>
        </div>
    </div>

    @can('view_reports')
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="row g-5 g-xl-8">
                    <div class="col-xl-6">
                        <div class="card card-xl-stretch mb-xl-8">
                            <div class="card-body d-flex flex-column p-0">
                                <div class="d-flex flex-stack flex-grow-1 card-p">
                                    <div class="d-flex flex-column me-2">
                                        <a href="#"
                                            class="text-dark text-hover-primary fw-bolder fs-3">{{ __('All Orders') }}</a>
                                    </div>
                                </div>
                                <div class="card-rounded-bottom text-center p-4">
                                    <h3>{{ $totalOrders }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card card-xl-stretch mb-xl-8">
                            <div class="card-body d-flex flex-column p-0">
                                <div class="d-flex flex-stack flex-grow-1 card-p">
                                    <div class="d-flex flex-column me-2">
                                        <a href="#"
                                            class="text-dark text-hover-primary fw-bolder fs-3">{{ __('All Vendors') }}</a>
                                    </div>
                                </div>
                                <div class="card-rounded-bottom text-center p-4">
                                    <h3>{{ $totalVendors }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="row g-5 g-xl-8">
                    <div class="col-xl-6">
                        <div class="card card-xl-stretch mb-xl-8">
                            <div class="card-body d-flex flex-column p-0">
                                <div class="d-flex flex-stack flex-grow-1 card-p">
                                    <div class="d-flex flex-column me-2">
                                        <a href="#"
                                            class="text-dark text-hover-primary fw-bolder fs-3">{{ __('All books') }}</a>
                                    </div>
                                </div>
                                <div class="card-rounded-bottom text-center p-4">
                                    <h3>{{ $totalbooks }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card card-xl-stretch mb-xl-8">
                            <div class="card-body d-flex flex-column p-0">
                                <div class="d-flex flex-stack flex-grow-1 card-p">
                                    <div class="d-flex flex-column me-2">
                                        <a href="#"
                                            class="text-dark text-hover-primary fw-bolder fs-3">{{ __('All courses') }}</a>
                                    </div>
                                </div>
                                <div class="card-rounded-bottom text-center p-4">
                                    <h3>{{ $totalcourses }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>

        <div class="row g-5 g-xl-8 mt-5">
            <!-- Best Selling Books -->
            <div class="col-xl-4">
                <div class="card card-xl-stretch mb-xl-8">
                    <div class="card-body p-4 text-center">
                        <h4 class="fw-bolder">{{ __('Book Best Sellers') }}</h4>
                        <ul class="list-group">
                            @foreach ($bestSellingBooks as $book)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Book ID: {{ $book->book_id }}
                                    <span class="badge bg-primary rounded-pill">{{ $book->total_sold }} Sold</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Best Selling Courses -->
            <div class="col-xl-4">
                <div class="card card-xl-stretch mb-xl-8">
                    <div class="card-body p-4 text-center">
                        <h4 class="fw-bolder">{{ __('Courses Best Sellers') }}</h4>
                        <ul class="list-group">
                            @foreach ($bestSellingCourses as $course)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Course ID: {{ $course->course_id }}
                                    <span class="badge bg-success rounded-pill">{{ $course->total_sold }} Sold</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Best Selling Consultations -->
            <div class="col-xl-4">
                <div class="card card-xl-stretch mb-xl-8">
                    <div class="card-body p-4 text-center">
                        <h4 class="fw-bolder">{{ __('Consultation Best Sellers') }}</h4>
                        <ul class="list-group">
                            @foreach ($bestSellingConsultations as $consultation)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Consultation ID: {{ $consultation }}
                                    <span class="badge bg-warning rounded-pill">{{ $consultation->total_sold }} {{__('Sold')}}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endcan
@endsection
