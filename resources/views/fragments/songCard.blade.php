<div onclick="goToSong({{$song->id}})">
    <div class="song-card mb-4 fadeInRight">
        @if($song->image_url)
            <img src="{{asset($song->image_url)}}" alt="song image cover" class="song-image">
        @endif
        <div class="song-info-container">
            @if($song->title)
                <h3>{{$song->title}}</h3>
            @endif
            @if($song->album_name)
                    <div class="d-flex align-items-center mt-1 song-info">
                        <div class="icon mr-2">
                            @include('fragments.icons.album')
                            <i></i>
                        </div>
                        <span class="label mr-2">Album: </span>
                        <p>{{$song->album_name}}</p>
                    </div>
            @endif
            @if($song->author)
                    <div class="d-flex align-items-center mt-1 song-info">
                        <div class="icon mr-2">
                            @include('fragments.icons.album-type')
                            <i></i>
                        </div>
                        <span class="label mr-2" >Autore:</span>
                        <p>{{$song->author}}</p>
                    </div>
            @endif
            @if($song->duration)
                    <div class="d-flex align-items-center mt-1 song-info">
                        <div class="icon mr-2">
                            @include('fragments.icons.duration')
                            <i></i>
                        </div>
                        <span class="label mr-2" >Durata:</span>
                        <p>{{$song->duration}}</p>
                    </div>
            @endif
        </div>
    </div>
</div>
