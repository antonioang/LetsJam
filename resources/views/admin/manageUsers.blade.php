@extends('layout.layout')
@push('extra-css')
    <link rel="stylesheet" type="text/css" href="{{asset('/css/sidebar.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/musicSheetCard.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/musicSheets.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/manageUsers.css')}}">
@endpush
@push('extra-js')
    <script type="text/javascript" src="{{asset('/js/sidebar-submit-users.js')}}"></script>
@endpush
@section('content')
<div style="padding-top: 90px;">

    <!-- Start Hero Area -->
    <section class="hero-area">
        <div class="row">
            <div class="sidebar">
                <form action="/admin/manageUsers" method="POST" id="sidebar-form">
                    @csrf
                    <div id="newAdmins" class="option-container">
                        <div class="option-title-container">
                            <div class="option-icon userGreen">
                                @include('fragments.icons.user')
                            </div>
                            <h4 style="color: white;" > Promuovi utenti </h4>
                        </div>
                    </div>
                    <button class="upUs btn btn-hover btn-block btn-dark btn-outline-light btn-close-white" type="submit">Promuovi</button>
                </form>
                <form class="mt-5" action="/admin/deleteUsers" method="POST" id="sidebar-form1">
                    @csrf
                    <div id="deleteAdmins" class="option-container">
                        <div class="option-title-container">
                            <div class="option-icon userRed">
                                @include('fragments.icons.user')
                            </div>
                            <h4 style="color: white;" >Elimina utenti</h4>
                        </div>
                    </div>
                    <button class="upUs btn btn-hover btn-block btn-dark btn-outline-light btn-close-white" type="submit">Elimina</button>
                </form>
            </div>
            <div class="col pt-4 pb-4 pl-4 relative scores-view" style="min-height: calc(100vh - 600px);padding: 20px;overflow-y: scroll; overflow-x:hidden">
                <h1 class="mb-3">Gestisci gli utenti</h1>
                <div class="bodyUserWrap">
                    @foreach($users as $user)
                        @if($user->id !== Auth::user()->id)
                            <div class="userWrap">
                                @include('fragments.userCard', $user)
                            </div>
                        @endif
                    @endforeach
                </div>
                {{$users->links('pagination::bootstrap-4')}}
                <img class="service-patern wow fadeInRight overlay-image" data-wow-delay=".5s" src="{{asset('img/service-patern.png')}}" alt="#"
                     style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInLeft;position: absolute;top: 65px;right: -55px;">

            </div>
        </div>

    </section>

</div>
@endsection
