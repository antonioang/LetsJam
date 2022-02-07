

<div>
    <div class="user-card fadeInUp mb-4">
        <div class="d-flex flex-row align-items-center justify-content-between mb-2">
            <h3>{{$user->firstname}} {{$user->lastname}}</h3>
            <div id="deleteUser" data-user="{{$user->id}}" data-username="{{$user->firstname}}  {{$user->lastname}}" class="icon">
                <p>Elimina</p>
                @include('fragments.icons.trash')
                <i></i>
            </div>
        </div>
        <div class="d-flex flex-row align-items-center justify-content-between">
            <div class="d-flex align-items-center justify-content-between mt-2" style="gap:10px;">
                <div class="avatar">
                    &nbsp;
                </div>
                <p class="mt-1"style="margin:0; text-transform: capitalize;">{{$user->username}}</p>
            </div>
            <div class="d-flex align-items-center justify-content-between mt-2" style="gap:10px;">
                <p  class="mt-1" style="margin:0;">ruolo attuale</p>
                <p class="mt-1"style="margin:0; text-transform: capitalize;">{{$user->role}}</p>
            </div>
            <div class="d-flex flex-row align-items-center justify-content-end" style="gap:20px">
                <div id="promoteUser" data-user="{{$user->id}}" data-username="{{$user->firstname}}  {{$user->lastname}}" class="icon">
                    <p>Promuovi</p>
                    @include('fragments.icons.promote')
                    <i></i>
                </div>
            </div>
        </div>

    </div>
</div>
