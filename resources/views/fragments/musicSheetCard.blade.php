
@push('extra-css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/musicSheetCard.css') }}">
@endpush

    <div>
        <div class="musicsheet-card fadeInUp mb-4" onclick="goToSheet({{$musicSheet->id}})">
            <div  class="d-flex flex-row align-items-center justify-content-between mb-2">
                <h3> {{$musicSheet->title}} </h3>
                <div style="display: flex">
                    @auth
                    @if(Auth::user()->role == 'admin')
                        <div class="d-flex align-items-center">
                            <div id="{{$musicSheet->id}}" class="verified-badge d-flex align-items-center"
{{--                                 th:classappend="${!musicsheet.verified ? 'not-verified-badge' : ''}"--}}
                            >
                                {{--                            <svg th:replace="fragments/icons :: verifyBadge"></svg>--}}

                                @include('fragments.verifyBadge')
                                Verificato
                            </div>
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
{{--                    <div class="avatar" th:if="${musicsheet.user.avatar}" style="'background:url('+${musicsheet.user.avatar}+');'">--}}
{{--                        &nbsp;--}}
{{--                    </div>--}}
{{--                    <div class="avatar" th:unless="${musicsheet.user.avatar}" style="'background:url(https://avatars.dicebear.com/api/male/'+${musicsheet.user.firstname}+'.svg);'">--}}
{{--                        &nbsp;--}}
{{--                    </div>--}}
                    <p class="mt-1"style="margin:0; text-transform: capitalize;">{{$musicSheet->user->firstname}}</p>
                </div>
                </div>
{{--                <div sec:authorize="!hasRole('AMMINISTRATORE')" class="d-flex flex-row align-items-center justify-content-end" style="gap:20px">--}}

{{--                    <div class="icon" th:each="instrument : ${musicsheet.instruments}">--}}
{{--                        <svg th:replace="fragments/icons :: __${instrument.name.toLowerCase()}__"></svg>--}}
{{--                        <i></i>--}}
{{--                    </div>--}}

{{--                </div>--}}
            </div>
        </div>
{{--        <div class="verify-btn" sec:authorize="hasRole('AMMINISTRATORE')">--}}
{{--            <div th:data-verify="${musicsheet.id}" th:if="${!musicsheet.verified}" class="action-container">--}}
{{--                <span th:text="#{admin.manageSheets.verify}" class="d-flex flex-row align-items-center justify-content-end" style="gap:20px"></span>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
