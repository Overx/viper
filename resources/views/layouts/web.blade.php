
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title')</title>

        <!-- SEO -->
        @yield('seo')

        <meta name="robots" content="index, follow">
        <meta name="author" content="VictorSalatiel" />
        <meta name="email" content="contato@vinenzo.com.br" />
        <meta name="website" content="https://vinenzo.com.br" />
        <meta name="Version" content="v1.0.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- favicon -->
        <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
        <link rel="shortcut icon" href="{{  asset('assets/images/favicon.png')}}" type="image/x-icon">

        <!-- Bootstrap -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

        <!-- iziModal -->
        <link href="{{ asset('assets/css/iziModal.min.css') }}" rel="stylesheet" type="text/css" />

        <link href="{{ asset('assets/css/iziToast.min.css') }}" rel="stylesheet" type="text/css" />

        <!-- Fontawesome -->
        <link href="{{ asset('assets/css/fontawesome.min.css') }}" rel="stylesheet" type="text/css" />

        <!-- Google font-->
        <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;1,100;1,200;1,300;1,400;1,500&family=Catamaran:wght@100;200;300;400;500;600;700;800;900&family=Montserrat:wght@100;200;300;400;500&family=Roboto+Condensed:wght@300&display=swap" rel="stylesheet">

        <style>
            [data-bs-theme=dark] {
                color-scheme: dark;
                --bs-body-color: #dee2e6;
                --bs-body-color-rgb: 222,226,230;
                --bs-body-bg: #212529;
                --bs-body-bg-rgb: 33,37,41;
                --bs-emphasis-color: #fff;
                --bs-emphasis-color-rgb: 255,255,255;
                --bs-secondary-color: rgba(222, 226, 230, 0.75);
                --bs-secondary-color-rgb: 222,226,230;
                --bs-secondary-bg: #343a40;
                --bs-secondary-bg-rgb: 52,58,64;
                --bs-tertiary-color: rgba(222, 226, 230, 0.5);
                --bs-tertiary-color-rgb: 222,226,230;
                --bs-tertiary-bg: #2b3035;
                --bs-tertiary-bg-rgb: 43,48,53;
                --bs-dropdown-link-active-bg: {{ \Helper::getCustomLayout()['primary_color'] }};
                --bs-primary-text-emphasis: {{ \Helper::getCustomLayout()['primary_color'] }};
                --bs-secondary-text-emphasis: #a7acb1;
                --bs-success-text-emphasis: #75b798;
                --bs-info-text-emphasis: #6edff6;
                --bs-warning-text-emphasis: #ffda6a;
                --bs-danger-text-emphasis: #ea868f;
                --bs-light-text-emphasis: #f8f9fa;
                --bs-dark-text-emphasis: #dee2e6;
                --bs-primary-bg-subtle: #031633;
                --bs-secondary-bg-subtle: #161719;
                --bs-success-bg-subtle: #051b11;
                --bs-info-bg-subtle: #032830;
                --bs-warning-bg-subtle: #332701;
                --bs-danger-bg-subtle: #2c0b0e;
                --bs-light-bg-subtle: #343a40;
                --bs-dark-bg-subtle: #1a1d20;
                --bs-primary-border-subtle: #084298;
                --bs-secondary-border-subtle: #41464b;
                --bs-success-border-subtle: #0f5132;
                --bs-info-border-subtle: #087990;
                --bs-warning-border-subtle: #997404;
                --bs-danger-border-subtle: #842029;
                --bs-light-border-subtle: #495057;
                --bs-dark-border-subtle: #343a40;
                --bs-heading-color: inherit;
                --bs-link-color: {{ \Helper::getCustomLayout()['primary_color'] }};
                --bs-link-hover-color: {{ \Helper::getCustomLayout()['primary_color'] }};
                --bs-link-color-rgb: 110,168,254;
                --bs-link-hover-color-rgb: 139,185,254;
                --bs-code-color: #e685b5;
                --bs-highlight-color: #dee2e6;
                --bs-highlight-bg: #664d03;
                --bs-border-color: #27292d;
                --bs-border-color-translucent: rgba(91, 89, 89, 0.15);
                --bs-form-valid-color: #75b798;
                --bs-form-valid-border-color: #75b798;
                --bs-form-invalid-color: #ea868f;
                --bs-form-invalid-border-color: #ea868f;
            }

            :root {

                --bs-body-bg: #0D131C;
                --cor-principal: {{ \Helper::getCustomLayout()['primary_color'] }};
                --cor-de-fundo: #0d131c;
                --cor-de-fundo-detalhe: #0d131c;
                --cor-texto-geral: #ffffff;
                --cor-titulo-lateral: {{ \Helper::getCustomLayout()['primary_color'] }};
                --cor-botao: {{ \Helper::getCustomLayout()['primary_color'] }};
                --cor-botao-texto: #ffffff;
                --cor-botao-secundario: #1A1C20;
                --cor-botao-secundario-texto: #ffffff;
                --cor-menu: #c9c9c9;
                --cor-menu-hover: #ffffff;
                --cor-background-tarja: #5624d0;
                --cor-texto-tarja: #ffffff;
                --cor-nome-time-odds: {{ \Helper::getCustomLayout()['primary_color'] }};
                --cor-nome-time-odds-hover:{{ \Helper::getCustomLayout()['primary_color'] }};
                --cor-nome-time-odds-background: {{ \Helper::getCustomLayout()['primary_color'] }};
                --cor-placar: {{ \Helper::getCustomLayout()['primary_color'] }};
                --cor-liga: {{ \Helper::getCustomLayout()['primary_color'] }};
                --cor-fundo-esportes: #fff;
                --cor-texto-esportes: #000000;
                --cor-titulo-rodape: #fff;
                --cor-links-rodape: #8697a2;
                --cor-background-modo-mini: #9195a3;
                --bs-primary: {{ \Helper::getCustomLayout()['primary_color'] }};
                --bs-primary-rgb: {{ \Helper::getCustomLayout()['primary_color'] }};
                --title-color: #ffffff;
                --text-color: #98A7B5;
                --sub-text-color: #656E78;
                --placeholder-color: #4D565E;
                --background-color: #24262B;
                --standard-color: #1C1E22;
                --shadow-color: #111415;
                --page-shadow: linear-gradient(to right, #111415, rgba(17, 20, 21, 0));
                --autofill-color: #f5f6f7;
                --yellow-color: #FFBF39;
                --border-radius: .25rem;

            }
        </style>
        <!-- Main Css -->
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css" id="theme-opt" />

        <style>
            body {
                background-color: {{ \Helper::getCustomLayout()['background_color'] }};
            }
            .page__navbar {
                border-right: 1px solid {{ \Helper::getCustomLayout()['primary_border_color'] }} !important;
            }
            .page__content__navbar {
                border-bottom: 1px solid {{ \Helper::getCustomLayout()['primary_border_color'] }} !important;
            }
            .active-sidebar {
                border-right: 3px solid {{ \Helper::getCustomLayout()['primary_color'] }}  !important;
            }
            .page__content__navbar__dir__btn {
                 border-radius: 20px;
                padding: 10px 25px;
                z-index: 5;
            }
            .btn-success {
                --bs-btn-color: #fff;
                --bs-btn-bg: {{ \Helper::getCustomLayout()['primary_color'] }};
                --bs-btn-border-color: {{ \Helper::getCustomLayout()['primary_color'] }};
                --bs-btn-hover-color: #fff;
                --bs-btn-hover-bg: {{ \Helper::getCustomLayout()['primary_color'] }};
                --bs-btn-hover-border-color: {{ \Helper::getCustomLayout()['primary_color'] }};
                --bs-btn-focus-shadow-rgb: 60,153,110;
                --bs-btn-active-color: #fff;
                --bs-btn-active-bg: {{ \Helper::getCustomLayout()['primary_color'] }}26;
                --bs-btn-active-border-color: {{ \Helper::getCustomLayout()['primary_color'] }}26;
                --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
                --bs-btn-disabled-color: #fff;
                --bs-btn-disabled-bg: {{ \Helper::getCustomLayout()['primary_color'] }}45;
                --bs-btn-disabled-border-color: {{ \Helper::getCustomLayout()['primary_color'] }}35;
            }
            .input-group-text {
                background-color: {{ \Helper::getCustomLayout()['primary_color'] }};
            }
            .btn-primary-theme {
                background: conic-gradient(from 1turn,{{ \Helper::getCustomLayout()['primary_color'] }},{{ \Helper::getCustomLayout()['primary_color'] }}26);
                border-radius: 5px;
                padding: 12px 32px;
            }
            .table-dark {
                --bs-table-border-color: {{ \Helper::getCustomLayout()['primary_color'] }};
            }
            .btn-outline-success {
                --bs-btn-color: {{ \Helper::getCustomLayout()['primary_color'] }};
                --bs-btn-border-color: {{ \Helper::getCustomLayout()['primary_color'] }};
                --bs-btn-hover-color: #fff;
                --bs-btn-hover-bg: {{ \Helper::getCustomLayout()['primary_color'] }}36;
                --bs-btn-hover-border-color: {{ \Helper::getCustomLayout()['primary_color'] }}36;
                --bs-btn-focus-shadow-rgb: 25,135,84;
                --bs-btn-active-color: #fff;
                --bs-btn-active-bg: {{ \Helper::getCustomLayout()['primary_color'] }}45;
                --bs-btn-active-border-color: {{ \Helper::getCustomLayout()['primary_color'] }}45;
                --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
                --bs-btn-disabled-color: {{ \Helper::getCustomLayout()['primary_color'] }}26;
                --bs-btn-disabled-bg: transparent;
                --bs-btn-disabled-border-color: {{ \Helper::getCustomLayout()['primary_color'] }}26;
                --bs-gradient: none;
            }
            .ui-button.s-conic2 {
                background-color:  {{ \Helper::getCustomLayout()['primary_color'] }}23;
                background-image: conic-gradient(from 1turn,{{ \Helper::getCustomLayout()['primary_color'] }},{{ \Helper::getCustomLayout()['primary_color'] }}36);
            }
            .input-search-group input {
                background-color: {{ \Helper::getCustomLayout()['secondary_color'] }} !important;
                border: 1px solid {{ \Helper::getCustomLayout()['secondary_color'] }};
            }
            .input-search-group .input-group-text {
                background-color: {{ \Helper::getCustomLayout()['secondary_color'] }};
                border: 1px solid  {{ \Helper::getCustomLayout()['secondary_color'] }};
            }
            .card {
                --bs-card-border-color: {{ \Helper::getCustomLayout()['secondary_color'] }};
                --bs-card-cap-color: {{ \Helper::getCustomLayout()['secondary_color'] }}26;
                --bs-card-color: {{ \Helper::getCustomLayout()['primary_text'] }};
                --bs-card-bg: {{ \Helper::getCustomLayout()['secondary_color'] }};
                background-color: {{ \Helper::getCustomLayout()['secondary_color'] }};
            }
            .card-header {
                color: {{ \Helper::getCustomLayout()['primary_text'] }};
            }
            .navbar_list .navbar_list_links a {
                color: {{ \Helper::getCustomLayout()['primary_text'] }};
            }
            .nav-link {
                color: {{ \Helper::getCustomLayout()['primary_text'] }};
            }
            .form-control {
                background-color: {{ \Helper::getCustomLayout()['background_color'] }}26 !important;
                border: 1px solid {{ \Helper::getCustomLayout()['background_color'] }};
            }
            .profile-avatar {
                background-color: {{ \Helper::getCustomLayout()['primary_color'] }};
            }
            .dropdown-menu {
                --bs-dropdown-bg: {{ \Helper::getCustomLayout()['primary_color'] }};
            }
            .accordion-button {
                background-color: {{ \Helper::getCustomLayout()['secondary_color'] }};
            }
            a, a:hover {
                color: {{ \Helper::getCustomLayout()['primary_text'] }};
            }
            .footer {
                background-color: {{ \Helper::getCustomLayout()['footer_color'] }};
                border-top: 1px solid {{ \Helper::getCustomLayout()['footer_color'] }};
                padding: 20px 40px;
            }
        </style>
        @stack('styles')

        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-9Q3ENV2D1L"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-9Q3ENV2D1L');
        </script>
    </head>

    <body>
        <main class="page">
            @include('includes.navbar_top')
            @include('includes.navbar_left')

            <div class="page__content">
                @yield('content')
            </div>

            @include('includes.footer')
        </main>

        <!-- javascript -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/iziModal.min.js') }}"></script>
        <script src="{{ asset('assets/js/iziToast.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script src="{{ asset('assets/js/custom.js') }}"></script>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>

        @stack('scripts')
        <x-flash></x-flash>
    </body>
</html>
