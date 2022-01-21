@extends('layout.layout')
@push('extra-css')
    <link rel="stylesheet" type="text/css" href="{{asset('/css/profile.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/modifyProfile.css')}}">
@endpush
@section('content')
<div style="padding-top: 90px;">
    <section class="hero-area pt-4 pb-4">
        <div class="container mt-4">
            <div class="row">
                <div class="col-12 mt-4 pt-4 pb-4">
                    <h3 class="mt-4 mb-4">Modifica profilo</h3>
                </div>
                <form action="/modifica-profilo" method="post" enctype="multipart/form-data">
                    @csrf
{{--                    <input type="hidden" th:field="*{id}" />--}}
{{--                    <input type="hidden" th:field="*{version}"/>--}}
                    <div class="main-wrap">
                        <div class="left-column">
                            <img class="new-avatar" id="frame" src="#">
                            @if(Auth::user()->avatar !== '')
                                <img src="{{asset(Auth::user()->avatar)}}" alt="profile avatar" class="profile-avatar">
                            @endif
                            @unless(Auth::user()->avatar !== '')
                                <img src="https://avatars.dicebear.com/api/male/{{Auth::user()->firstname}}.svg" alt="profile avatar" class="profile-avatar">
                            @endunless
                            <label name="imgInput">
                                <input name="imgInput" id="avatar" type="file" accept="image/*">
                            </label>
                        </div>
                        <div class="right-column">
                            <label name="firstname" inline="text">
                                Nome
                                <input value="{{Auth::user()->firstname}}" name="firstname" type="text" required/>
                            </label>
                            <label name="lastname" inline="text">
                                Cognome
                                <input value="{{Auth::user()->lastname}}" name="lastname" type="text" required/>
                            </label>
                            <label name="username">
                                Username
                                <input value="{{Auth::user()->username}}" name="username" type="text" required/>
                            </label>
                            <label name="email">
                                Email
                                <input value="{{Auth::user()->email}}" name="email" type="email" required/>
                            </label>
                            @if(Auth::user()->role == 'utente')
                                <div class="preferred-genres">
                                    <span style="align-self: flex-start; font-weight: 500;">Generi preferiti</span>
                                    @foreach ($genres as $genrePreferred)
                                        <div>
                                            <input name="preferredGenres[]" value="{{$genrePreferred->id}}" {{Auth::user()->genre->contains('id', $genrePreferred->id) ? 'checked' : false}} type="checkbox"/>
                                            <label for="preferredGenres">{{$genrePreferred->name}}</label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="preferred-genres">
                                    <span style="align-self: flex-start;font-weight: 500;">Strumenti preferiti</span>
                                    @foreach ($instruments as $instrumentPreferred)
                                        <div>
                                            <input name="preferredInstruments[]" value="{{$instrumentPreferred->id}}" {{Auth::user()->instruments->contains('id', $instrumentPreferred->id) ? 'checked' : false}} type="checkbox"/>
                                            <label for="preferredInstruments">{{$instrumentPreferred->name}}</label>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            <div class="button btn">
                                <button class="button btn" type="submit">Invia</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script>
        document.getElementById('avatar').addEventListener('change', (e) => {
            let images = document.querySelector('.left-column').querySelectorAll('img')
            images.forEach((el,i) => {
                if(i === 0) {
                    el.style.display = 'block'
                    el.src = URL.createObjectURL(e.target.files[0]);
                } else {
                    el.style.display = 'none'
                }
            })
        })
    </script>
</div>
@endsection
