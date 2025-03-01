<head>
    <base href="">
    <title dir="{{ isArabic() ? '.rtl' : '' }}">{{ settings()->get('website_name_'.getLocale()) . ' - ' . __('Dashboard') }}</title>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
    <link rel="shortcut icon" type="image/gif" sizes="16x16" href="{{ settings()->get('favicon') ? getImagePathFromDirectory( settings()->get('favicon') , "Settings") : asset('favicon.png') }}" />

    <!--begin::Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @if ( isArabic() )
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @else
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;900&display=swap" rel="stylesheet">
    @endif

    <!--end::Fonts-->

    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="{{  asset('dashboard-assets/plugins/global/plugins' . ( isDarkMode()  ? '.dark' : '' ) . '.bundle' . ( isArabic() ? '.rtl' : '' ) . '.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{  asset('dashboard-assets/css/style' . ( isDarkMode()  ? '.dark' : '' )  . '.bundle' . ( isArabic() ? '.rtl' : '' ) . '.css')}}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->

    @stack('styles')

    <style>

        #loading-div {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url('{{ asset('loader.gif') }}') center no-repeat #fff;
        }


    </style>

</head>
