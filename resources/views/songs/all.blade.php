@extends('layout.layout')
@push('extra-css')
    <link rel="stylesheet" type="text/css" href="{{asset('/css/sidebar.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/songCard.css')}}">
@endpush
@push('extra-js')
    <script type="text/javascript" src="{{asset('/js/sidebar-submit.js')}}"></script>
@endpush
@section('content')
<div style="padding-top: 90px;">

    <!-- Start Hero Area -->
    <section class="hero-area">
        <div class="row">
            <div class="sidebar">
                <form th:action="@{/songs/}" th:object="${formData}" method="post" id="sidebar-form">
                    <div class="search mb-5">
                        @include('fragments.icons.search')
                        <input type="text" placeholder="Cerca">
                    </div>


                    <div class="option-container">
                        <div class="option-title-container">
                            <div class="option-icon">
                                @include('fragments.icons.genres')
                            </div>
                            <h4 style="color: white;">Genere</h4>
                        </div>

                        <div class="sub-option-container">
                            @foreach ($genres as $genre)
                                <div class="checkbox-option">
                                    <input type="checkbox" class="form-check-input" value="{{$genre->name}}">
                                    <p style="text-transform: capitalize;">{{$genre->name}}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="option-container">
                        <div class="option-title-container">
                            <div class="option-icon">
                                @include('fragments.icons.sort')
                            </div>
                            <h4 style="color: white;">Ordina per</h4>
                            <div class="option-icon sort-direction">
{{--                                <div th:if="${formData.sortDirection == 'ASC'}" th:remove="tag">--}}
                                    @include('fragments.icons.sort-asc')
{{--                                </div>--}}
{{--                                <div th:if="${formData.sortDirection == 'DESC'}" th:remove="tag">--}}
{{--                                    <svg th:replace="fragments/icons :: sort-desc"></svg>--}}
{{--                                </div>--}}
{{--                                <input th:if="${formData.sortDirection == 'ASC'}" type="text" name="sortDirection" value="ASC" hidden>--}}
{{--                                <input th:if="${formData.sortDirection == 'DESC'}" type="text" name="sortDirection" value="DESC" hidden>--}}
                            </div>
                        </div>

                        <div class="sub-option-container">
                            <div class="radio-option">
            {{--                                <input type="radio" class="form-check-input" th:field="*{sortBy}" value="title">--}}
                                <input type="radio" class="form-check-input" value="title">
                                <p>Titolo</p>
                            </div>
                            <div class="radio-option">
            {{--                                <input type="radio" class="form-check-input" th:field="*{sortBy}" value="song.title">--}}
                                <input type="radio" class="form-check-input"  value="song.title">
                                <p>Nome brano</p>
                            </div>
                            <div class="radio-option">
            {{--                                <input type="radio" class="form-check-input" th:field="*{sortBy}"--}}
                                <input type="radio" class="form-check-input"
                                       value="createDateTime">
                                <p>Data di creazione</p>
                            </div>
                            <div class="radio-option">
                                <input type="radio" class="form-check-input" value="duration">
                                <p>Durata</p>
                            </div>
                        </div>
                    </div>

                    <div class="option-container">
                        <div class="option-title-container">
                            <div class="option-icon">
                                @include('fragments.icons.album-type')
                            </div>
                            <h4 style="color: white;">Tipo di Album</h4>
                        </div>

                        <div class="sub-option-container">
                            <div class="radio-option">
                                <input type="radio" class="form-check-input" th:field="*{albumType}" value="ALBUM">
                                <p>Album</p>
                            </div>
                            <div class="radio-option">
                                <input type="radio" class="form-check-input" th:field="*{albumType}" value="SINGLE">
                                <p>Single</p>
                            </div>
                            <div class="radio-option">
                                <input type="radio" class="form-check-input" th:field="*{albumType}" value="COLLECTION">
                                <p>Collection</p>
                            </div>
                        </div>
                    </div>

                    <div class="option-container">
                        <div class="option-title-container">
                            <div class="option-icon">
                                @include('fragments.icons.filter')
                            </div>
                            <h4 style="color: white;">Filtri</h4>
                        </div>

                        <div class="sub-option-container">
                            <div class="checkbox-option">
{{--                                <input type="checkbox" class="form-check-input" th:field="*{explicit}">--}}
                                <input type="checkbox" class="form-check-input">
                                <p>Contiene contenuti espliciti</p>
                            </div>
                        </div>

                        <div class="sub-option-container">
                            <div class="checkbox-option">
{{--                                <input type="checkbox" class="form-check-input" th:field="*{lyrics}">--}}
                                <input type="checkbox" class="form-check-input">
                                <p>Testo disponibile</p>
                            </div>
                        </div>
                    </div>
{{--                    <input type="hidden" th:field="*{pageNumber}">--}}
                </form>
            </div>
            <div class="col pt-4 pb-4 pl-4 relative" style="padding: 20px;overflow-y: scroll; overflow-x:hidden">
                <h1 class="mb-3"> Tutti i nostri brani</h1>
                @foreach ($songs as $song)
                    @include('fragments.songCard', $song)
                @endforeach
                <img class="service-patern wow fadeInRight overlay-image" data-wow-delay=".5s" src="{{asset('/img/service-patern.png')}}" alt="#"
                     style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInLeft;position: absolute;top: 65px;right: -55px;">


                {{$songs->links('pagination::bootstrap-4')}}
            </div>
        </div>

    </section>

</div>
@endsection
