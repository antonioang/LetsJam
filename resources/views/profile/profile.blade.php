@extends('layout.layout')
@push('extra-css')
    <link rel="stylesheet" type="text/css" href="{{asset('/css/song.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/musicSheetCard.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/profile.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/chat.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{asset('https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css')}}">
@endpush
@push('extra-js')
    <script type="text/javascript" src="{{asset('/js/chat.js')}}"></script>
@endpush

@section('content')
    <div style="padding-top: 90px;">
        <section style="min-height: calc(100vh - 600px);" class="hero-area pt-4 pb-4">
            <div class="container mt-4">
                <div class="row">
                    <div class="col-3 pt-5 text-center">
                        @if(Auth::user()->avatar !== '')
                            <img src="{{asset(Auth::user()->avatar)}}" alt="profile avatar" class="profile-avatar">
                        @endif
                        @unless(Auth::user()->avatar !== '')
                            <img src="https://avatars.dicebear.com/api/male/{{Auth::user()->firstname}}.svg"
                                 alt="profile avatar" class="profile-avatar">
                        @endunless
                        <a class="navbar-brand" href="/modifica-profilo">
                            @include('fragments.icons.modifyProfile')
                        </a>
                    </div>
                    <div class="col-3 pt-4 profile-generics">
                        <div class="mt-4">
                            <h3 class="profile-name">{{Auth::user()->firstname}}</h3>
                            <h3 class="profile-name mt-4"> {{Auth::user()->lastname}}</h3>
                        </div>
                        <div>
                            <h6 class="profile-descr">username:</h6>
                            <h5 class="">{{Auth::user()->username}}</h5>
                            <h6 class="profile-descr mt-2">email:</h6>
                            <h5 class="">{{Auth::user()->email}}</h5>
                        </div>
                    </div>
                    @if(Auth::user()->role == 'utente')
                        <div class="col-6 pt-4 profile-preferred">
                            <div>
                                <div class="d-flex align-items-center">
                                    <div class="icon mr-2">
                                        @include('fragments.icons.genres')
                                        <i></i>
                                    </div>
                                    <h3 class="">Generi preferiti:</h3>
                                </div>
                                @foreach (Auth::user()->genre as $genrePreferred)
                                    <span class="pref-genre">{{$genrePreferred->name}}</span>
                                @endforeach
                            </div>
                            <div>
                                <div class="d-flex align-items-center">
                                    <div class="icon mr-2">
                                        @include('fragments.icons.violin')
                                        <i></i>
                                    </div>
                                    <h3 class="">Strumenti preferiti:</h3>
                                </div>
                                <div class="d-flex aling-items-center justify-content-start w-100 mt-3 pl-4"
                                     style="gap: 15px;">
                                    @foreach (Auth::user()->instruments as $instrumentPreferred)
                                        <div class="icon round" style="width: 60px; height: 60px;">
                                            @include('fragments.icons.'.$instrumentPreferred->name)
                                            <i></i>
                                        </div>
                                    @endforeach

                                </div>

                            </div>
                        </div>
                    @endif
                </div>
                @if(Auth::user()->role == 'utente')
                    <div class="row">
                        <div class="col-12 mt-4 pt-4 pb-4">
                            <h3 class="mt-4 mb-4">I tuoi spartiti</h3>
                        </div>

                        <!-- Start mine Section -->
                        <section class="services about-us">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12 relative">
                                        @foreach($sheets as $musicSheet)
                                            <div>
                                                @include('fragments.musicSheetCard',$musicSheet)
                                            </div>
                                            <img class="service-patern wow fadeInRight overlay-image"
                                                 data-wow-delay=".5s" src="{{asset('img/service-patern.png')}}" alt="#"
                                                 style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInLeft;position: absolute;top: 287px;right: -25px;">
                                            <img class="service-patern wow fadeInRight overlay-image"
                                                 data-wow-delay=".5s" src="{{asset('img/service-patern.png')}}" alt="#"
                                                 style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInLeft;position: absolute;bottom: -3px;left: -25px;">
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!-- /End mine Section -->
                    </div>
                @endif
            </div>
        </section>
    </div>
@endsection
