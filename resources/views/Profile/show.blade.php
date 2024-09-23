<x-app-layout>
    @if ($errors->any())
        <div class="bg-green-100 border-t-4 border-green-500 rounded-b text-green-900 px-4 py-3 shadow-md my-3" role="alert">
            <div class="flex">
                <div>
                    <p class="text-sm">{{ $errors->first() }}</p>
                </div>
            </div>
        </div>
    @endif
    <div>
        <div style="display: inline-block; margin-top: 5%; margin-left: 20%; margin-right: 5%">
            <img src="{{$profile->Image}}">
        </div>
        <div style="display: inline-block; vertical-align: top; margin-top: 5.5%" id="app" class="app">
            <div style="display:flex; justify-content: space-between; align-items: baseline">
                <h1 style="font-size: 50px; margin-bottom: 5px">{{ $profile->user->name }}</h1>
            </div>
            <div>
            @if(Auth()->User() == $profile->user)
                <a href="{{$profile->user->id}}/edit">Edit Profile</a><br>
            @endif
            </div>
            <div style="display: flex; margin-bottom: 1.5%">
                <div style="padding-right: 4px"><strong>{{$profile->user->Notes->count()}}</strong> Notes</div>
                <div style="padding-right: 4px"><strong>23k</strong> followers</div>
                <div style="padding-right: 4px"><strong>212</strong> following</div>
            </div>
            <div>{{ $profile->description}}</div>
        </div>
    </div>
    <div style="text-align: center">
        @foreach($profile->user->Notes as $image)
            <div style="display: inline-block; padding: 1%;">
                <a href="/p/{{$image->id}}">
                    <img src="/storage/{{$image->URL}}">
                </a>
            </div>         
        @endforeach
    </div>
</x-app-layout>