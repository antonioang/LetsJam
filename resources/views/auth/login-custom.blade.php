<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="{{asset('img/favicon.png')}}"/>

    <link href="https://fonts.googleapis.com/css2?family=Spartan:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{asset('/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('/css/animate.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('/css/tiny-slider.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('/css/glightbox.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('/css/main.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('/css/login.css')}}"/>
    <title>login</title>

    <script type="text/javascript" src="{{asset('/js/login.js')}}" ></script>
</head>

<body>

@if($errors->any())
    <div class="error-message"> Credenziali di accesso non valide, riprova </div>
@endif

{{--<div th:if="${param.logout}" class="warning-message" th:text="#{login.loggedout}"></div>--}}

<div class="form-container">
    <h2 class="mb-4"> Benvenuto </h2>
    <div class="logo-container mb-4">
        <img src="{{asset('/img/logow.png')}}" alt="letsjam logo">
    </div>
    <form action="{{ route('login') }}" method="post"  style="width: 90%;">
        @csrf
        <div class="input-container mb-3">
            <label class="mb-1"> Email </label>
            <input type="email" name="email" placeholder="Inserisci un indirizzo email"/>
        </div>

        <div class="input-container mb-3">
            <label class="mb-1"> Password </label>
            <input type="password" name="password" placeholder="Inserisci la password"/>
        </div>
        <div class="input-container mb-3 align-items-center">
            <div class="button wow fadeInUp" data-wow-delay=".7s" style="visibility: visible; animation-delay: 0.7s; animation-name: fadeInUp;">
                <button type="submit" class="btn"> Accedi</button>
            </div>
        </div>
    </form>
    <a href="/register" class="mt-2" style="font-size: 16px;"> Registrati</a>
</div>

</body>
</html>
