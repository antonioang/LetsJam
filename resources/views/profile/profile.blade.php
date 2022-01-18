@extends('layout.layout')
@push('extra-css')
    <link rel="stylesheet" type="text/css" href="{{asset('/css/song.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/musicSheetCard.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/profile.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/chat.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css')}}">
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
                        <img src="https://avatars.dicebear.com/api/male/{{Auth::user()->firstname}}.svg" alt="profile avatar" class="profile-avatar">
                    @endunless
                    <a class="navbar-brand" href="/modifica-profilo">
                        @include('fragments.icons.modifyProfile')
                    </a>
                </div>
                <div class="col-3 pt-4 profile-generics">
                    <div class="mt-4">
                        <h3 class="profile-name">{{Auth::user()->firstname}}</h3>
                        <h3  class="profile-name mt-4"> {{Auth::user()->lastname}}</h3>
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
                                <h3  class="">Strumenti preferiti:</h3>
                            </div>
                            <div class="d-flex aling-items-center justify-content-start w-100 mt-3 pl-4" style="gap: 15px;">
                                @foreach (Auth::user()->instruments as $instrumentPreferred)
                                    <div class="icon round" style="width: 60px; height: 60px;">
{{--                                        @include('fragments.icons.'.$instrumentPreferred)--}}
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
                                    @foreach(Auth::user()->musicsheet as $musicSheet)
                                        <div>
                                            @include('fragments.musicSheetCard',$musicSheet)
                                        </div>
                                        <img class="service-patern wow fadeInRight overlay-image" data-wow-delay=".5s" src="{{asset('img/service-patern.png')}}" alt="#"
                                             style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInLeft;position: absolute;top: 287px;right: -25px;">
                                        <img class="service-patern wow fadeInRight overlay-image" data-wow-delay=".5s" src="{{asset('img/service-patern.png')}}" alt="#"
                                             style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInLeft;position: absolute;bottom: -3px;left: -25px;">
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- /End mine Section -->
                </div>
            @endif
{{--            <div th:if="${profilo.getRole().toString().equals('UTENTE')}" class="row">--}}
{{--                <div class="col-12 mt-4 pt-4 pb-4">--}}
{{--                    <h3 class="mt-4 mb-4" th:text="#{profile.messagesCentre}">Centro messaggi</h3>--}}
{{--                </div>--}}
{{--                <div class="container">--}}

{{--                    <!-- Content wrapper start -->--}}
{{--                    <div class="content-wrapper">--}}

{{--                        <!-- Row start -->--}}
{{--                        <div class="row gutters">--}}

{{--                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">--}}

{{--                                <div class="card m-0 mr-3 ml-3 message-center">--}}

{{--                                    <input id="current-conversation" type="hidden">--}}
{{--                                    <!-- Row start -->--}}
{{--                                    <div class="row no-gutters">--}}
{{--                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-3 col-3">--}}
{{--                                            <div class="users-container" id="users-container">--}}
{{--                                                <div class="chat-search-box">--}}
{{--                                                    <div class="input-group">--}}
{{--                                                        <select id="select" class="form-select" th:aria-label="#{profile.addNewConversation}">--}}
{{--                                                            <option selected th:text="#{profile.addNewConversation}"></option>--}}
{{--                                                            <div th:each="user : ${notYetTalkingUsers}"  th:remove="tag">--}}
{{--                                                                <option th:value="${user.username}" th:text="${user.username}" style="text-transform: capitalize;"></option>--}}
{{--                                                            </div>--}}
{{--                                                        </select>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                                <!--<ul class="users">--}}
{{--                                                    <li class="person" data-chat="person1">--}}
{{--                                                        <div class="user">--}}
{{--                                                            <img src="https://www.bootdey.com/img/Content/avatar/avatar3.png" alt="Retail Admin">--}}
{{--                                                            <span class="status busy"></span>--}}
{{--                                                        </div>--}}
{{--                                                        <p class="name-time">--}}
{{--                                                            <span class="name"></span>--}}
{{--                                                        </p>--}}
{{--                                                    </li>--}}
{{--                                                </ul>-->--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-9 col-9">--}}
{{--                                            <div class="selected-user">--}}
{{--                                                <!--<span>To: <span class="name">Emily Russell</span></span>-->--}}
{{--                                            </div>--}}
{{--                                            <div class="chat-container">--}}
{{--                                                <ul class="chat-box chatContainerScroll">--}}
{{--                                                    <!-- <li class="chat-left">--}}
{{--                                                         <div class="chat-avatar">--}}
{{--                                                             <img src="https://www.bootdey.com/img/Content/avatar/avatar3.png" alt="Retail Admin">--}}
{{--                                                             <div class="chat-name">Russell</div>--}}
{{--                                                         </div>--}}
{{--                                                         <div class="chat-text">Hello, I'm Russell.--}}
{{--                                                             <br>How can I help you today?</div>--}}
{{--                                                         <div class="chat-hour">08:55 <span class="fa fa-check-circle"></span></div>--}}
{{--                                                     </li>-->--}}
{{--                                                    <!--<li class="chat-right">--}}
{{--                                                        <div class="chat-hour">08:56 <span class="fa fa-check-circle"></span></div>--}}
{{--                                                        <div class="chat-text">Hi, Russell--}}
{{--                                                            <br> I need more information about Developer Plan.</div>--}}
{{--                                                        <div class="chat-avatar">--}}
{{--                                                            <img src="https://www.bootdey.com/img/Content/avatar/avatar3.png" alt="Retail Admin">--}}
{{--                                                            <div class="chat-name">Sam</div>--}}
{{--                                                        </div>--}}
{{--                                                    </li>-->--}}
{{--                                                </ul>--}}
{{--                                                <div class="form-group mt-3 mb-0">--}}
{{--                                                    <textarea id="text-area" class="form-control" rows="3" placeholder="Type your message here..."></textarea>--}}
{{--                                                    <div class="button wow fadeInUp mt-4" data-wow-delay=".7s" id="send-button"--}}
{{--                                                         style="visibility: visible; animation-delay: 0.7s; animation-name: fadeInUp; width: fit-content;">--}}
{{--                                                        <a class="btn" th:text="#{profile.button}"></a>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <!-- Row end -->--}}
{{--                                </div>--}}

{{--                            </div>--}}

{{--                        </div>--}}
{{--                        <!-- Row end -->--}}

{{--                    </div>--}}
{{--                    <!-- Content wrapper end -->--}}

{{--                </div>--}}
{{--            </div>--}}
        </div>
    </section>
</div>
@endsection
