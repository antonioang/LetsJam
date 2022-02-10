
@push('extra-css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/musicSheetCard.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/musicSheets.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/song.css')}}">
@endpush
@push('extra-js')
    <script>
        function goToSheet(id) {
            window.location.href = `/musicsheets/${id}`;
        }
    </script>
@endpush

    <div>
        <div class="musicsheet-card fadeInUp mb-4" onclick="goToSheet({{$musicSheet->id}})">
            <div  class="d-flex flex-row align-items-center justify-content-between mb-2">
                <h3> {{$musicSheet->title}} </h3>
                <div style="display: flex">
                    @auth
                    @if(Auth::user()->role == 'admin')
                        <div class="d-flex align-items-center">
                            @if($musicSheet->verified)
                                <div id="{{$musicSheet->id}}" class="verified-badge d-flex mt-4 align-items-center" inline="text">
                                    @include('fragments.icons.verifyBadge')
                                    Verificato
                                </div>
                            @endif
                            @unless($musicSheet->verified)
                                <div id="{{$musicSheet->id}}" class="verified-badge disabled d-flex align-items-center" inline="text">
                                    @include('fragments.icons.verifyBadge')
                                    Verificato
                                </div>
                            @endunless
                        </div>
                    @endif
                    @endauth
                    <div class="d-flex flex-row align-items-center justify-content-between interaction-container" style="gap: 10px;">
                        <div class="action-container">
                            @include('fragments.icons.like')
                            <span>{{$musicSheet->likes_count}}</span>
                            <i></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-row align-items-center justify-content-between">
                <div class="d-flex flex-column align-items-start justify-content-between">

                @if($musicSheet->song != null)
                <p style="margin:0"><span>Brano: </span> {{$musicSheet->song->author}}  -  {{$musicSheet->song->title}}</p>
                @endif
                @unless($musicSheet->song != null)
                <p><span>Brano: </span>Inedito</p>
                @endunless
                @if($musicSheet->song != null && $musicSheet->song->genre != null)
                <p><span>Genere: </span>{{$musicSheet->song->genre->name}}</p>
                @endif
                @unless($musicSheet->song != null && $musicSheet->song->genre != null)
                    <p><span>Genere: </span> Non definito{{$musicSheet->song}}</p>
                @endunless
                <div class="d-flex align-items-center justify-content-between mt-2" style="gap:10px;">
                    @auth
                        @if($musicSheet->user->avatar)
                            <div class="avatar" style="background:url({{asset($musicSheet->user->avatar)}});">
                                &nbsp;
                            </div>
                        @endif
                        @unless($musicSheet->user->avatar)
                            <div class="avatar" style="background:url(https://avatars.dicebear.com/api/male/{{$musicSheet->user->firstname}}.svg);">
                                &nbsp;
                            </div>
                        @endunless
                    @endauth
                    <p class="mt-1"style="margin:0; text-transform: capitalize;">{{$musicSheet->user->firstname}}</p>
                </div>
                </div>
                @auth
                    @if(Auth::user()->role !== 'admin')
                        <div class="d-flex flex-row align-items-center justify-content-end" style="gap:20px">
                            @foreach($musicSheet->instruments as $instrument)
                                <div class="icon">
                                    @include('fragments.icons.'.$instrument->name)
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endauth
            </div>
        </div>
        @auth
            @if(Auth::user()->role == 'admin' && !Request::is('home'))
                <div class="verify-btn">
                    @if(!$musicSheet->verified)
                        <div data-verify="{{$musicSheet->id}}" class="action-container">
                            <span class="d-flex flex-row align-items-center justify-content-end" style="gap:20px">Verifica spartito</span>
                        </div>
                    @endif
                </div>
            @endif
        @endauth

    </div>
