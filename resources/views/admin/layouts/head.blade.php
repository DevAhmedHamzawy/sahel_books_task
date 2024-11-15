<!-- Title -->
<title> East - @yield('title') </title>
<!-- Favicon -->
<link rel="icon" href="{{URL::asset('assets/img/brand/favicon.png')}}" type="image/x-icon"/>
<!-- Icons css -->
<link href="{{URL::asset('assets/css/icons.css')}}" rel="stylesheet">
<!--  Custom Scroll bar-->
<link href="{{URL::asset('assets/plugins/mscrollbar/jquery.mCustomScrollbar.css')}}" rel="stylesheet"/>
<!--  Right-sidemenu css -->
<link href="{{URL::asset('assets/plugins/sidebar/sidebar.css')}}" rel="stylesheet">
@yield('css')
<!-- Maps css -->
<link href="{{URL::asset('assets/plugins/jqvmap/jqvmap.min.css')}}" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900;1000&display=swap" rel="stylesheet">

@switch($locale)
    @case('en')
        <!-- Sidemenu css -->
        <link rel="stylesheet" href="{{URL::asset('assets/css/sidemenu.css')}}">
        <!-- style css -->
        <link href="{{URL::asset('assets/css/style.css')}}" rel="stylesheet">
        <link href="{{URL::asset('assets/css/style-dark.css')}}" rel="stylesheet">
        <!---Skinmodes css-->
        <link href="{{URL::asset('assets/css/skin-modes.css')}}" rel="stylesheet" />
    @break
    @case('ar')
        <!-- Sidemenu css -->
        <link rel="stylesheet" href="{{URL::asset('assets/css-rtl/sidemenu.css')}}">
        <!--- Style css -->
        <link href="{{URL::asset('assets/css-rtl/style.css')}}" rel="stylesheet">
        <!--- Dark-mode css -->
        <link href="{{URL::asset('assets/css-rtl/style-dark.css')}}" rel="stylesheet">
        <!---Skinmodes css-->
        <link href="{{URL::asset('assets/css-rtl/skin-modes.css')}}" rel="stylesheet">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        <style>
             body{
                    font-family: 'Cairo', sans-serif !important;
             }
        </style>

    @break
@endswitch


<style>
    .form-control:disabled{
                background-color: #f1f1f1 !important;
                border: 1px solid #f1f1f1 !important;
    }

    .main-body, .main-dashboard {
        overflow-y: scroll !important;
    }
</style>
