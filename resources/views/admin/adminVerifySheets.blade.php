@extends('layout.layout')
@push('extra-css')
    <link rel="stylesheet" type="text/css" href="{{asset('/css/sidebar.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/musicSheetCard.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/musicSheets.css')}}">
@endpush
@push('extra-js')
    <script type="text/javascript" src="{{asset('/js/sidebar-submit.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/manage-verifySheets.js')}}"></script>
@endpush

@section('content')

<div style="padding-top: 90px;">

    <!-- Start Hero Area -->
    <section class="hero-area">
        <div class="row">
            <div class="sidebar">
                <form action="/admin/verifyMusicsheet" method="POST" id="sidebar-form">
                    @csrf
                    <div class="search mb-5">
                        @include('fragments.icons.search')
                        <input type="text" name="textSearch" placeholder="Cerca">
                    </div>


                    <div class="option-container">
                        <div class="option-title-container">
                            <div class="option-icon">
                                @include('fragments.icons.album-type')
                            </div>
                            <h4 style="color: white;">Genere</h4>
                        </div>

                        <div class="sub-option-container">
                            @foreach ($genres as $genre)
                                <div class="checkbox-option">
                                    <input type="checkbox" class="form-check-input" {{in_array($genre->id,$checkedGenres) ? 'checked' : false}} name="genre[]" value="{{$genre->id}}">
                                    <p style="text-transform: capitalize;">{{$genre->name}}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="option-container">
                        <div class="option-title-container">
                            <div class="option-icon">
                                @include('fragments.icons.genres')
                            </div>
                            <h4 style="color: white;">Strumenti</h4>
                        </div>

                        <div class="sub-option-container">
                            @foreach ($instruments as $instrument)
                                <div class="checkbox-option">
                                    <input type="checkbox" class="form-check-input" {{in_array($instrument->id,$checkedInstruments) ? 'checked' : false}} name="instrument[]" value="{{$instrument->id}}">
                                    <p style="text-transform: capitalize;">{{$instrument->name}}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="option-container">
                        <div class="option-title-container">
                            <div class="option-icon">
                                @include('fragments.icons.sort')
                            </div>
                            <h4 style="color: white;"> Ordina per</h4>
                            <div class="option-icon sort-direction">
                                @if($sortDirection == 'ASC')
                                    @include('fragments.icons.sort-asc')
                                    <input type="text" name="sortDirection" value="ASC" hidden>
                                @endif
                                @if($sortDirection == 'DESC')
                                    @include('fragments.icons.sort-desc')
                                    <input  type="text" name="sortDirection" value="DESC" hidden>
                                @endif
                            </div>
                        </div>

                        <div class="sub-option-container">
                            <div class="radio-option">
                                <input type="radio" name="order" class="form-check-input" {{$sortOrderr == 'title' ? 'checked' : false}} value="title">
                                <p>Titolo</p>
                            </div>
                            <div class="radio-option">
                                <input type="radio" name="order" class="form-check-input" {{$sortOrderr == 'songName' ? 'checked' : false}} value="songName">
                                <p>Nome brano</p>
                            </div>
                            <div class="radio-option">
                                <input type="radio" name="order" {{$sortOrderr == 'created_at' ? 'checked' : false}} class="form-check-input"
                                       value="created_at">
                                <p>Data di creazione</p>
                            </div>
                            <div class="radio-option">
                                <input type="radio" name="order" {{$sortOrderr == 'likes' ? 'checked' : false}} class="form-check-input" value="likes">
                                <p>Mi piace</p>
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
                                <input type="checkbox" name="verified" class="form-check-input">
                                <p>Verificato</p>
                            </div>
                            <div class="checkbox-option">
                                <input type="checkbox" name="rearranged" class="form-check-input">
                                <p>Riarrangiato</p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col pt-4 pb-4 pl-4 relative scores-view" style="padding: 20px;overflow-y: scroll; overflow-x:hidden">
                <h1 class="mb-3" >Gestisci gli spartiti</h1>
                @foreach ($musicSheets as $musicSheet)
                    @include('fragments.musicSheetCard', $musicSheet)
                @endforeach
                <img class="service-patern wow fadeInRight overlay-image" data-wow-delay=".5s"
                     src="{{asset('/img/service-patern.png')}}" alt="#"
                     style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInLeft;position: absolute;top: 65px;right: -55px;">

                {{$musicSheets->links('pagination::bootstrap-4')}}
            </div>
        </div>

    </section>
    <div id="confirm-verify-modal" class="modal-wrap">
        <span>Confermi di voler verificare lo spartito?</span>
        <div id="verify">
            <button class="upUs btn btn-hover btn-block btn-dark btn-outline-light btn-close-white" type="submit">Conferma</button>
        </div>
    </div>
</div>
@endsection
