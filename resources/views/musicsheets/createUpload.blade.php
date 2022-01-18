@extends('layout.layout')
@push('extra-css')
    <link rel="stylesheet" type="text/css" href="{{asset('/css/create-upload.css')}}">
@endpush
@push('extra-js')
    <script src="{{asset('https://prod.flat-cdn.com/embed-js/v1.4.0/embed.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/create-upload.js')}}"></script>
@endpush

@section('content')
<div style="padding-top:90px">

    <section id="flat-wrap" class="flat-wrap">
        <div class="flat-inner-wrap">

            <div id="create" class="flat-part-left first-hidden mr-4">
                <h2>Crea nuovo spartito</h2>
                <form id="createForm" action="{{route('musicsheets.store')}}" method="post" enctype="multipart/form-data" style="width:100%">
                    <div class="sheet-info">
                        <label name="title" inline="text">
                            Titolo Spartito
                            <input name="title" id="sheet-title" type="text" />
                        </label>
                        <label name="author" inline="text">
                            Autore Spartito
                            <input name="author" id="sheet-author"  type="text" required/>
                        </label>

                        <div class="d-flex flex-column align-items-start mt-3">
                            <label name="song" class="mb-0">Brano</label>
                            <div class="btn-group btn-group-toggle songToggle" data-toggle="buttons">
                                <label class="btn btn-primary active" inline="text">
                                    Esistente
                                    <input type="radio" name="songType" id="option1" value="0" autocomplete="off" checked>
                                </label>
                                <label class="btn btn-primary" inline="text">
                                    Inedito
                                    <input type="radio" name="songType" id="option2" autocomplete="off" value="1">
                                </label>
                            </div>
                        </div>

                        <!-- New Song -->
                        <div class="flex-column align-items-start" id="newSongContainer" style="display: none;">
                            <label name="song" class="mb-0" style="width: 100%;" inline="text">
                                Titolo Brano
                                <input name="songTitle" type="text"/>
                            </label>

                            <label name="song" class="mb-0" style="width: 100%;" inline="text">
                                Autore Brano
                                <input name="songAuthor" type="text"/>
                            </label>

                        </div>
                        <!-- Existing song -->
                        <input id="chooseSong" name="song" type="text" placeholder="Scrivi il titolo o l\u0027autore del brano" />
                        <ul id="songList">
                            <!-- songs result from search -->
                        </ul>
                        <!--  -->

                        <div class="d-flex flex-column align-items-start w-100 mt-2">
                            <label name="song" class="mb-0" style="width: 100%;">Genere Brano</label>
                            <select class="form-select w-100" name="songGenre">
                                <option value="" selected>Seleziona il genere del brano</option>
                                @foreach ($genre as $genrePreferred)
                                    <option value="{{$genrePreferred->id}}">{{$genrePreferred->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- hidden fields-->
                        <input id="selectedSong" name="brano" type="hidden"/>
                        <input id="musicSheetContent" name="content" type="hidden"/>
                        <input id="songType" name="songType" type="hidden" />
                        <input id="visibility" name="visibility" type="hidden" />
                        <!-- -->

                        <div class="d-flex flex-column align-items-start mt-3">
                            <label name="visibility" class="mb-0" text="#{createupload.musicsheet.visibility}"></label>
                            <div class="btn-group btn-group-toggle visibilityToggle" data-toggle="buttons">
                                <label class="btn btn-primary active" inline="text">
                                    Privato
                                    <input type="radio" name="musicSheetVisibility" id="option1" value="0" autocomplete="off" checked>
                                </label>
                                <label class="btn btn-primary" inline="text">
                                    Privato
                                    <input type="radio" name="musicSheetVisibility" id="option2" autocomplete="off" value="1">
                                </label>
                            </div>
                        </div>

                        <div class="button wow fadeInUp submit mt-4" data-wow-delay=".7s"
                             style="visibility: visible; animation-delay: 0.7s; animation-name: fadeInUp; width: fit-content;">
                            <a class="btn">Crea</a>
                        </div>

                    </div>
                </form>
            </div>

            <div id="choose" class="flat-part-left">
                <h2 >Scegli cosa fare</h2>
                <div class="choose-alert">
                    <div>
                        <select id="select" class="slct">
                            <option value="crea" class="opt">Crea</option>
                            <option class="opt" value="carica">Carica</option>
                        </select>
                    </div>
                    <div id="instrumentForSheet" class="instruments-for-sheet wrapper">
                        <h6 style="margin-bottom: 20px" class="align-center" >Scegli gli strumenti con cui iniziare</h6>
                        <div class="inner-wrp">
                            @foreach ($instruments as $instrumentPreferred)
                                <div class="check">
                                    <input type="checkbox" name="{{$instrumentPreferred->name}}"/>
                                    <label for="{{$instrumentPreferred->name}}">{{$instrumentPreferred->name}}</label>
                                </div>
                            @endforeach
                        </div>
                        <div class="error-message mt-2 ml-5 mb-0" id="noInstrumentSelected" style="display: none;"
                             >Devi selezionare almeno uno strumento</div>
                    </div>
                    <div id="fileForSheet" class="instruments-for-sheet">
                        <input type="file" class="custom-file-input"  id="file-input" name="file">
                    </div>
                    <button id="confirmFirst" class="create-btn">Conferma</button>
                </div>
            </div>
            <div class="flat-part-right">
                <div id="embed-example"></div>
            </div>

        </div>
    </section>

</div>
@endsection
