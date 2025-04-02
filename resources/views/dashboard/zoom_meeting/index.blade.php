@extends('partials.dashboard.master')
@push('styles')
    <link href="{{ asset('dashboard-assets/css/datatables' . (isDarkMode() ? '.dark' : '') . '.bundle.css') }}"
        rel="stylesheet" type="text/css" />
@endpush
@section('content')
    <div class="container">
        <h3>Zoom Meeting</h3>
        <iframe src="{{ request()->get('url') }}" width="100%" height="600px" allow="camera; microphone; fullscreen"></iframe>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('js/dashboard/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('js/dashboard/datatables/book.js') }}"></script>
    <script>
        let currentUserId = {{ auth()->id() }};
    </script>
@endpush
