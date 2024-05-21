@extends('layouts.web')

@section('title', config('setting')['software_name'].' - Cassino Online | Jogos de Slot e Apostas em Futebol')

@section('seo')
    <link rel="canonical" href="{{ url()->current() }}" />
    <meta name="description" content="Bem-vindo à {{ config('setting')['software_name'] }} - o melhor cassino online com uma ampla seleção de jogos de slot, apostas em jogos de futebol e uma experiência de aposta fácil e divertida. Jogue Fortune Tiger, Fortune OX e muito mais!">
    <meta name="keywords" content="{{ config('setting')['software_name'] }}, cassino online, jogos de slot, apostas em futebol, Fortune Tiger, Fortune OX">

    <meta property="og:locale" content="pt_BR" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{ config('setting')['software_name'] }} - Apostas Online | Jogos de Slot e Apostas em Futebol" />
    <meta property="og:description" content="Bem-vindo à {{ config('setting')['software_name'] }} - o melhor cassino online com uma ampla seleção de jogos de slot, apostas em jogos de futebol e uma experiência de aposta fácil e divertida. Jogue Fortune Tiger, Fortune OX e muito mais!" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:site_name" content="{{ config('setting')['software_name'] }} - Apostas Online | Jogos de Slot e Apostas em Futebol" />
    <meta property="og:image" content="{{ asset('/assets/images/banner-1.png') }}" />
    <meta property="og:image:secure_url" content="{{ asset('/assets/images/banner-1.png') }}" />
    <meta property="og:image:width" content="1024" />
    <meta property="og:image:height" content="571" />

    <meta name="twitter:title" content="{{ config('setting')['software_name'] }} - Apostas Online | Jogos de Slot e Apostas em Futebol">
    <meta name="twitter:description" content="Bem-vindo à {{ config('setting')['software_name'] }} - o melhor cassino online com uma ampla seleção de jogos de slot, apostas em jogos de futebol e uma experiência de aposta fácil e divertida. Jogue Fortune Tiger, Fortune OX e muito mais!">
    <meta name="twitter:image" content="{{ asset('/assets/images/banner-1.png') }}"> <!-- Substitua pelo link da imagem que deseja exibir -->
    <meta name="twitter:url" content="{{ url('/') }}"> <!-- Substitua pelo link da sua página -->
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/splide-core.min.css') }}">
@endpush

@section('content')
    <div class=" @if(\Helper::getCustomLayout()['expanded_layout']) container-fluid @else container @endif">
        <section id="image-carousel" class="splide" aria-label="">
            <div class="splide__track">
                <div class="splide-banner">
                    Ganhe 10 rodadas grátis <span style="margin-left: 10px"><i class="fa-solid fa-fire"></i></span>
                </div>
                <ul class="splide__list">
                    @foreach(\App\Models\Banner::where('type', 'carousel')->get() as $banner)
                        <li class="splide__slide">
                            <a href="{{ $banner->link }}">
                                <img src="{{ asset('storage/'.$banner->image) }}" alt="">
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>

        <!-- Search -->
        <form action="{{ url('/') }}" method="GET">
            <div class="input-group input-search-group">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Digite o que você procura..." aria-label="Pesquisar" aria-describedby="basic-addon2">
                <span class="input-group-text" id="basic-addon2"><i class="fa-duotone fa-magnifying-glass"></i> </span>
            </div>
        </form>



        <br>


        <div class="mt-5">
            @include('includes.title', ['link' => url('como-funciona'), 'title' => 'F.A.Q', 'icon' => 'fa-light fa-circle-info', 'labelLink' => 'Saiba mais'])
        </div>

        @include('web.home.sections.faq')
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/splide.min.js') }}"></script>
    <script>
        document.addEventListener( 'DOMContentLoaded', function () {
            var elemento = document.getElementById('splide-soccer');

            if (elemento) {
                new Splide( '#splide-soccer', {
                    type   : 'loop',
                    drag   : 'free',
                    focus  : 'center',
                    autoplay: 'play',
                    perPage: 3,
                    arrows: false,
                    pagination: false,
                    breakpoints: {
                        640: {
                            perPage: 1,
                        },
                    },
                    autoScroll: {
                        speed: 1,
                    },
                }).mount();
            }

            new Splide( '#image-carousel', {
                arrows: false,
                pagination: false,
                type    : 'loop',
                autoplay: 'play',
            }).mount();
        } );
    </script>
@endpush
