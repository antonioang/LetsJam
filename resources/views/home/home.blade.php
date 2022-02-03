@extends('layout.layout')

@section('content')
    <!-- Start Hero Area -->
    <section class="hero-area">
        <!-- Single Slider -->
        <div class="hero-inner">
            <div class="container">
                <div class="row ">
                    <div class="col-lg-6 co-12">
                        <div class="home-slider">
                            <div class="hero-text">
                                <h1>Benvenuto nel portale dedicato ai musicisti</h1>
                                <p class="wow fadeInUp" data-wow-delay=".5s"> Componi, riarrangia, condividi! Tutte
                                    le risorse per dare sfogo alla tua vena creativa con un solo click!</p>
                                <div class="button wow fadeInUp mb-5" data-wow-delay=".7s">
                                    <a href="/aboutUs" class="btn">Per saperne di più</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ End Single Slider -->
    </section>

    <!-- What we do section-->
    <section class="services section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title align-left">
                        <span class="wow fadeInDown" data-wow-delay=".2s"

                              style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInDown;">Funzionalità principali</span>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s"
                            style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp;">Fai uscire
                            l'artista che è in te</h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s"
                           style="visibility: visible; animation-delay: 0.6s; animation-name: fadeInUp;">Tutto ciò
                            di cui hai bisogno per comporre e condividere nuovi brani</p>
                    </div>
                </div>
            </div>
            <div class="single-head">
                <img class="service-patern wow fadeInLeft" data-wow-delay=".5s" src="{{asset('img/service-patern.png')}}" alt="#" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInLeft;">
                <div class="row">
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="single-service wow fadeInUp" data-wow-delay=".2s"
                         style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                        <h3> Esplora, Componi, Condividi</h3>
                        <div class="icon">
                            <i class="lni lni-microscope"></i>
                        </div>
                        <p>Riscopri la passione per la musica come mai hai fatto prima</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="single-service wow fadeInUp" data-wow-delay=".4s"
                         style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp;">
                        <h3>Riscopri la passione per la musica come mai hai fatto prima</h3>
                        <div class="icon">
                            <i class="lni lni-blackboard"></i>
                        </div>
                        <p>Esplora tutti i nostri spartiti verificati da noi per garantirne l'originalità</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="single-service wow fadeInUp" data-wow-delay=".6s"
                         style="visibility: visible; animation-delay: 0.6s; animation-name: fadeInUp;">
                        <h3>Componi le tue melodie sul web</h3>
                        <div class="icon">
                            <i class="lni lni-ux"></i>
                        </div>
                        <p>Grazie al nostro editor puoi immergerti all'interno del pentagramma</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="single-service wow fadeInUp" data-wow-delay=".8s"
                         style="visibility: visible; animation-delay: 0.8s; animation-name: fadeInUp;">
                        <h3>Crea & Condividi</h3>
                        <div class="icon">
                            <i class="lni lni-graph"></i>
                        </div>
                        <p>Prendi spunto dagli spartiti pubblicati dalla nostra community o condividi le tue
                            migliori creazioni</p>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <!-- End What we do section-->

    <!-- Free Content Section -->
    <section class="section free-version-banner free-content-background">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 offset-lg-2 col-12">
                    <div class="section-title mb-60">
                        <span class="text-white wow fadeInDown" data-wow-delay=".2s"
                              style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInDown;">Gratuito</span>
                        <h2 class="text-white wow fadeInUp" data-wow-delay=".4s"
                            style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp;">Tutti i nostri
                            contenuti completamente gratuiti</h2>
                        <p class="text-white wow fadeInUp" data-wow-delay=".6s"
                           style="visibility: visible; animation-delay: 0.6s; animation-name: fadeInUp;">Crediamo che la
                            musica sia universale e che tutti possano comporre le proprie melodie</p>

                        <div class="button">
                            <a href="#" rel="nofollow" class="btn wow fadeInUp" data-wow-delay=".8s"
                               style="visibility: visible; animation-delay: 0.8s; animation-name: fadeInUp;">Inizia a
                                comporre adesso</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End Free Content Section -->

    <!-- Start MostPopular Section -->
    <section class="services section about-us">
        <div class="container">
            <div class="row">
                <div class="col-12 relative">
                    <div class="section-title align-left">
                        <span class="wow fadeInDown" data-wow-delay=".2s">Più Popolari</span>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">Scopri i nostri spartiti più popolari</h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">Crea le tue varianti delle canzoni scritte da te
                            nel nostro editor. Condividi e collabora con migliaia di altri artisti di ogni provenienza
                            uniti soltanto dalla musica.</p>
                    </div>

                    @foreach ($mostpopular as $musicSheet)
{{--                        <p>This is user {{ $musicsheet->id }}</p>--}}
{{--                            <div th:replace="fragments/musicSheetCard :: musicSheetCard(musicsheet = ${musicsheet})"></div>--}}
                        @include('fragments.musicSheetCard',$musicSheet)
                    @endforeach

                    <img class="service-patern wow fadeInRight overlay-image" data-wow-delay=".5s"
                         src="{{asset('img/service-patern.png')}}" alt="#"
                         style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInLeft;position: absolute;top: 287px;right: -25px;">
                    <img class="service-patern wow fadeInRight overlay-image" data-wow-delay=".5s"
                         src="{{asset('img/service-patern.png')}}" alt="#"
                         style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInLeft;position: absolute;bottom: -3px;left: -25px;">
                </div>
            </div>
        </div>
    </section>
    <!-- /End MostPopular Section -->

    <!-- Start random mushicSeet filtered by genre Section -->
        <section class="services section about-us">
            <div class="container">
                <div class="row">
                    <div class="col-12 relative">
                        <div class="section-title align-left">
                            <span class="wow fadeInDown" data-wow-delay=".2s" >Per genere</span>
                            <h2 class="wow fadeInUp" data-wow-delay=".4s" >Scopri i nostri spartiti per genere</h2>
                            <p class="wow fadeInUp" data-wow-delay=".6s">Esplora le canzoni e gli spartiti secondo i filtri che preferisci. Generi, popolarità e tanto altro a disposizione.</p>
                        </div>

                        @foreach($sheetsForGenres as $key => $sheet)
                            @if(!$sheet->isEmpty())
                                <h3 class="wow fadeInUp genreTitle mt-5 mb-3" data-wow-delay=".4s">{{$key}}</h3>
                                @foreach ($sheet as $musicSheet)
                                    @include('fragments.musicSheetCard',$musicSheet)
                                @endforeach
                            @endif
                        @endforeach

                        <img class="service-patern wow fadeInRight overlay-image" data-wow-delay=".5s" src="{{asset('img/service-patern.png')}}" alt="#"
                             style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInLeft;position: absolute;top: 287px;right: -25px;">
                        <img class="service-patern wow fadeInRight overlay-image" data-wow-delay=".5s" src="{{asset('img/service-patern.png')}}" alt="#"
                             style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInLeft;position: absolute;bottom: -3px;left: -25px;">
                    </div>
                </div>
            </div>
        </section>
        <!-- /End random mushicSeet filtered by genre Section -->

        <!-- Free Content Section -->
        <section class="section image-section"></section>
        <!--End Free Content Section -->

        <!--  People section -->
        <div class="latest-news-area section">
            <div class="container relative">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title">
                            <span class="wow fadeInDown" data-wow-delay=".2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInDown;">Let's Jam</span>
                            <h2 class="wow fadeInUp" data-wow-delay=".4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp;" >Let's Jam è un punto di svolta per i compositori di tutti i livelli</h2>
                            <p class="wow fadeInUp" data-wow-delay=".6s" style="visibility: visible; animation-delay: 0.6s; animation-name: fadeInUp;">Il posto perfetto per crescere come compositori e musicisti. Let\u0027s Jam vi offre tutti gli strumenti per ravvivare la tua passione per la musica</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-12">
                        <!-- Single News -->
                        <div class="single-news wow fadeInUp" data-wow-delay=".2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                            <div class="image">
                                <img class="thumb" src="{{asset('img/people-1.jpg')}}" alt="#">
                                <div class="meta-details">
                                    <span  style="text-transform: uppercase;"> Amatore </span>
                                </div>
                            </div>
                            <div class="content-body">
                                <h4 class="title">  Dai sfogo alla tua passione </h4>
                                <p> Sfrutta il nostro database di spartiti per dare sfogo alla tua passione per la musica. Lasciati ispirare dalla nostra community</p>
                            </div>
                        </div>
                        <!-- End Single News -->
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <!-- Single News -->
                        <div class="single-news wow fadeInUp" data-wow-delay=".4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp;">
                            <div class="image">
                                <img class="thumb" src="{{asset('img/people-2.jpg')}}"  alt="#">
                                <div class="meta-details">
                                    <span style="text-transform: uppercase;"> Compositore </span>
                                </div>
                            </div>
                            <div class="content-body">
                                <h4 class="title"> Metti il turbo alle tue composizioni </h4>
                                <p >Crea, condividi e interagisci con altri compositori appassionati proprio come te</p>
                            </div>
                        </div>
                        <!-- End Single News -->
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <!-- Single News -->
                        <div class="single-news wow fadeInUp" data-wow-delay=".6s" style="visibility: visible; animation-delay: 0.6s; animation-name: fadeInUp;">
                            <div class="image">
                                <img class="thumb" src="{{asset('img/people-3.jpg')}}"  alt="#">
                                <div class="meta-details">
                                    <span style="text-transform: uppercase;"> Professionista </span>
                                </div>
                            </div>
                            <div class="content-body">
                                <h4 class="title"> Tutti gli strumenti per operare nel settore</h4>
                                <p> Su Let's Jam puoi trovare tutti gli spartiti originali verificati da noi</p>
                            </div>
                        </div>
                        <!-- End Single News -->
                    </div>
                </div>
                <img class="service-patern wow fadeInRight overlay-image" data-wow-delay=".5s" src="{{asset('img/service-patern.png')}}" alt="#"
                     style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInLeft;position: absolute;bottom: 184px;left: -25px; z-index:-1;">
            </div>
        </div>
        <!-- End People section -->

        <section class="newsletter-area section">
            <div class="container">
                <div class="row ">
                    <div class="col-12">

                        <div class="mini-call-action wow fadeInRight text-center" data-wow-delay=".4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInRight; z-index: 2;">
                            <h4 > Ti abbiamo convinto adesso?</h4>
                            <p > Cosa aspetti iscriviti subito ed esplora la collezione di spartiti su Let's Jam</p>
                            <div class="button">
                                <a href="/login" class="btn"> Inizia Subito</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

@endsection
