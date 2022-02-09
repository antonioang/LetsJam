<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:th="https://www.thymeleaf.org"
      xmlns:sec="https://www.thymeleaf.org/thymeleaf-extras-springsecurity3">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="{{asset('img/favicon.png')}}"/>

    <link href="https://fonts.googleapis.com/css2?family=Spartan:wght@100;200;300;400;500;600;700;800;900&display=swap"
          rel="stylesheet">

    <title>Registrazione Let\'s Jam</title>

    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('css/LineIcons.2.0.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('css/animate.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('css/tiny-slider.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('css/glightbox.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('css/main.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('css/login.css')}}"/>

    <script type="text/javascript" src="{{asset('js/login.js')}}"></script>

</head>
<body>

{{--<div th:if="${error == 'email'}" class="error-message" th:text="#{register.email.error}"></div>--}}
{{--<div th:if="${error == 'password'}" class="error-message" th:text="#{register.password.error}"></div>--}}

<div class="form-container flex-row" style="width:900px;">
    <div class="d-flex flex-column align-items-center justify-content-between pb-4" style="flex:5; height: 100%;">
        <h2 class="mb-4 text-center">Registrati</h2>
        <div class="logo-container mb-4">
            <img src="{{asset('/img/logow.png')}}" alt="letsjam logo">
        </div>
        <a href="/login" class="mt-2" style="font-size: 16px;">Login</a>
    </div>

    <form action="{{ route('register') }}" method="post" style="width: 90%;flex:7;">
        @csrf
        <div class="input-container mb-3">
            <label class="mb-1">Firstname</label>
            <input type="text" name="firstname" placeholder="Inserisci firstname"/>
        </div>

        <div class="input-container mb-3">
            <label class="mb-1">Lastname</label>
            <input type="text" name="lastname" placeholder="Inserisci lastname"/>
        </div>

        <div class="input-container mb-3">
            <label class="mb-1">Username</label>
            <input type="text" name="username" placeholder="Inserisci username"/>
        </div>

        <div class="input-container mb-3">
            <label class="mb-1"> Email </label>
            <input type="text" name="email" placeholder="Inserisci la tua email"/>
        </div>

        <div class="input-container mb-3">
            <label class="mb-1"> Password </label>
            <input type="password" name="password" placeholder="Iserisci la password"/>
        </div>
        <div class="input-container mb-3 align-items-center">
            <div class="button wow fadeInUp" data-wow-delay=".7s"
                 style="visibility: visible; animation-delay: 0.7s; animation-name: fadeInUp;">
                <a class="btn">Registrati</a>
            </div>
        </div>
    </form>

</div>
</body>
</html>
