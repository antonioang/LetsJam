@extends('layout.layout')
@push('extra-css')
    <link rel="stylesheet" type="text/css" href="{{asset('/css/create-upload.css')}}">
@endpush
@push('extra-js')
    <script >
        var musicSheetData = {{Js::from($musicsheetdata)}};
        var musicSheet = {{Js::from($musicsheet)}};
    </script>
    <script type="text/javascript" src="{{asset('/js/rearrangeMusicSheet.js')}}" ></script>
    <script src="{{asset('https://prod.flat-cdn.com/embed-js/v1.4.0/embed.min.js')}}"></script>
@endpush
@section('content')
<body>
<div style="padding-top:90px">
    <section id="flat-wrap" class="flat-wrap">
        <div class="flat-inner-wrap">
            <div id="create" class="flat-part-left mr-4">
                <h2>Riarrangia lo spartito</h2>
                <form id="createForm" action="{{route('modify')}}" method="post" enctype="multipart/form-data" style="width:100%">
                    @csrf
                    <div class="sheet-info">
                        <label name="title">
                            Titolo spartito
                            <input name="title" value="{{$musicsheet->title}}" id="sheet-title" type="text"/>
                        </label>
                        <label name="author">
                            Autore spartito
                            <input name="author" id="sheet-author" value="{{$musicsheet->author}}" type="text" required/>
                        </label>

                        <div class="button wow fadeInUp submit mt-4" data-wow-delay=".7s"
                             style="visibility: visible; animation-delay: 0.7s; animation-name: fadeInUp; width: fit-content; display:none">
                            <a id="check-instrument" class="btn"> Conferma</a>
                        </div>

                        <div class="d-flex flex-column align-items-start mt-3">
                            <label  class="mb-0">Visibilità</label>
                            <div class="btn-group btn-group-toggle visibilityToggle" data-toggle="buttons">
                                <label class="btn btn-primary active">
                                    Privato
                                    <input type="radio" name="musicSheetVisibility" id="option1" value="0" autocomplete="off" checked>
                                </label>
                                <label class="btn btn-primary">
                                    Pubblico
                                    <input type="radio" name="musicSheetVisibility" id="option2" autocomplete="off"  value="1">
                                </label>
                            </div>
                        </div>

                        <input id="musicSheetContent" name="content" type="hidden">
                        <input id="visibility" name="visibility" type="hidden" />
                        <input value="{{$musicsheet->id}}" name="id" type="hidden" />

                        <div id="rearrange-submit" class="button wow fadeInUp submit mt-4" data-wow-delay=".7s"
                             style="visibility: visible; animation-delay: 0.7s; animation-name: fadeInUp; width: fit-content;">
                            <a class="btn">Riarrangia</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="flat-part-right">
                <div id="embed-example"></div>
            </div>
        </div>
    </section>
</div>

@endsection
