@extends('layout.layout')
@push('extra-css')
    <link rel="stylesheet" type="text/css" href="{{asset('/css/musicSheetCard.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/musicSheets.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/song.css')}}">
@endpush
@push('extra-js')
    <script>
        /*<![CDATA[*/
        var musicSheetData = {{Js::from($musicsheetdata)}};
        var musicSheetTitle = {{Js::from($musicSheet->title)}};
        var loggedUser = {{ Js::from(Auth::user()) }};
        var isAuthor = loggedUser === {{Js::from($musicSheet->user())}};
    </script>
    <script type="text/javascript" src="{{'https://prod.flat-cdn.com/embed-js/v1.4.0/embed.min.js'}}"></script>
    <script type="text/javascript" src="{{asset('/js/musicsheet.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/manage-verifySheets.js')}}" ></script>
@endpush
@section('content')
    <div style="padding-top: 90px;">
        <!-- Start Hero Area -->
        <section class="hero-area pt-4 pb-4">
            <div class="container mt-4">
                <div class="d-flex pt-4 justify-content-between align-items-center">
                    <div class="left-container d-flex flex-column align-items-start">
                        <h2 class="song-title">{{$musicSheet->title}}</h2>
                        <h4 class="song-author mt-4">{{$musicSheet->author}}</h4>
                        <div class="d-flex align-items-center mt-4 song-info">
                            <div class="icon mr-2">
                                @include('fragments.icons.user')
                                <i></i>
                            </div>
                            <span class="label mr-2">{{$musicSheet->uploadedBy}}</span>
                            <p>{{$musicSheet->user->firstname}} {{$musicSheet->user->lastname}}</p>
                        </div>
                        <div class="d-flex align-items-center mt-4 song-info">
                            <div class="icon mr-2">
                                @include('fragments.icons.album')
                                <i></i>
                            </div>
                            <span class="label mr-2" inline="text">Brano:</span>
                            <a href="{{'/songs/'. $musicSheet->song->id}}">
                                <p>{{$musicSheet->song->title}} {{$musicSheet->song->author}}</p>
                            </a>
                        </div>
                        <div class="d-flex align-items-center mt-4 song-info">
                            <div class="icon mr-2">
                                @include('fragments.icons.upload')
                                <i></i>
                            </div>
                            <span class="label mr-2" >Data caricamento:</span>
{{--                            <p th:text="${#temporals.format(musicSheet.createDateTime, 'dd/MM/yyyy')}"></p>--}}
                            <p>inserisici data formattata</p>
                        </div>
                        {{$isLiked= $musicSheet->likes->contains(Auth::user()->name)}}
                        <div @class([
                            'mt-4' => true,
                             'd-flex' => true,
                              'align-items-center' => true,
                               'like' => true,
                                'liked' => $isLiked
                            ]) inline="text" style="gap: 5px;">
                            <div class="icon round mr-2">
                                @include('fragments.icons.like')
                                <i></i>
                            </div>
                            <span> {{$musicSheet->likes_count}} </span>
                            Mi piace
                        </div>
                        @if($musicSheet->verified)
                            <div class="verified-badge mt-4 d-flex align-items-center" inline="text">
                                @include('fragments.icons.verifyBadge')
                                Verificato
                            </div>
                        @endif
                        @if(Auth::user()->role == 'admin')
                            <div class="verify-btn verify-btn-detail-pg">
                                @if(!$musicSheet->verified)
                                    <div data-verify="{{$musicSheet->id}}" class="action-container">
                                        <span class="d-flex flex-row align-items-center justify-content-end" style="gap:20px">Verifica spartito</span>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="right-container d-flex flex-column align-items-end">
                        @if($musicSheet->song->imageUrl != null)
                            <img src="{{asset($musicSheet->song->imageUrl)}}" alt="song image cover" class="song-image">
                        @endif
                        @unless($musicSheet->song->imageUrl != null)
                            <img src="{{asset('/img/nocover.jpg')}}" alt="song image cover" class="song-image">
                        @endunless
                    </div>

                </div>

                <div class="row">
                    <div class="col-12 mt-4 pt-4 pb-4">
                        <div class="editor-container p-4">
                            <h3 class="mt-4 mb-3">Strumenti</h3>
                            <div class="instruments-container mb-4">
                                @foreach ($musicsheetdata->instrumentMapping as $key => $instrument)
                                    <div class="instrument" partId="{{$instrument}}">
                                        @include('fragments.icons.'.$key)
                                    </div>
                                @endforeach
                            </div>
                            <div id="embed" class="w-100"></div>
                            <h3 class="mt-4 mb-3" >Download</h3>
                            <div class="d-flex flex-row align-items-center justify-content-between mb-4 pl-5 pr-5" style="gap:10px">
                                <div class="button wow fadeInUp submit mt-4" data-wow-delay=".7s" id="downloadXml"
                                     style="visibility: visible; animation-delay: 0.7s; animation-name: fadeInUp; width: fit-content;">
                                    <a class="btn" >Scarica in musicxml</a>
                                </div>

                                <div class="button wow fadeInUp submit mt-4" data-wow-delay=".7s" id="downloadPdf"
                                     style="visibility: visible; animation-delay: 0.7s; animation-name: fadeInUp; width: fit-content;">
                                    <a class="btn" >Stampa</a>
                                </div>

                                <div class="button wow fadeInUp mt-4" id="downloadPng" data-wow-delay=".7s"
                                     style="visibility: visible; animation-delay: 0.7s; animation-name: fadeInUp; width: fit-content;">
                                    <a class="btn" >Scarica in png</a>
                                </div>
                            </div>

                            <h3 class="mt-5 mb-2">Commenti</h3>
                            <div class="comments-container d-flex flex-column mt-4 mb-3 w-100 p-5">
{{--                                commenti--}}
                                @foreach ($comments as $comment)
                                    <div commentId="{{$comment->id}}" class="comment d-flex align-items-center justify-content-start">
                                        @if($comment->user->avatar)
                                            <div class="user-image" style="background:url('{{$comment->user->avatar}}');">
                                                &nbsp;
                                            </div>
                                        @endif
                                        @unless($comment->user->avatar)
                                            <div class="user-image" style="background:url('https://avatars.dicebear.com/api/male/{{$comment->user->firstname}}.svg');">
                                                &nbsp;
                                            </div>
                                        @endunless
                                        <div class="d-flex flex-column align-items-start justify-content-start" style="flex:17;">
                                            <h6 class="user-name">{{$comment->user->firstname}}{{$comment->user->lastname}}</h6>
                                            <p class="comment-content">{{$comment->user->content}}</p>
                                            <div class="d-flex align-items-center justify-content-start comment-actions" style="gap:10px">
                                                <a href="" class="respond-button">Rispondi</a>
                                                @if($comment->replies > 0)
                                                    <a href="" class="showResponses-button" >[[#{common.showReplies}]]([[${comment.replies}]])</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="write-comment">
                                    @if(Auth::user()->avatar)
                                        <div class="user-image" style="background:url('{{Auth::user()->avatar}}');">
                                            &nbsp;
                                        </div>
                                    @endif
                                    @unless(Auth::user()->avatar)
                                        <div class="user-image" style="background:url('https://avatars.dicebear.com/api/male/{{Auth::user()->firstname}}.svg');">
                                            &nbsp;
                                        </div>
                                    @endunless
                                    <input type="text" placeholder="Scrivi il tuo commento" style="flex:17;">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </section>
        <a href="" class="rearrangeButton btn-hover">
            @include('fragments.icons.modify')
        </a>

        @if(Auth::user()->role == 'admin')
            <div id="confirm-verify-modal" class="modal-wrap">
                <span>Confermi di voler verificare lo spartito?</span>
                <div id="verify">
                    <button class="upUs btn btn-hover btn-block btn-dark btn-outline-light btn-close-white" type="submit">Conferma</button>
                </div>
            </div>
        @endif

    </div>
@endsection

