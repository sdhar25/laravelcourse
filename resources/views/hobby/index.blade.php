@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
          @isset($filter)
                <div class="card-header">Filtered Hobbies by <span style="font-size: 130;" class="badge badge-{{ $filter->style}}">{{ $filter->name}}</span>
                 <span class="float-right"><a href="/hobby">back to hobby</a></span>
                </div>
         @else
                <div class="card-header">All Hobbies</div>
         @endisset
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($hobbies as $hobby)
                         <li class="list-group-item">
                        <a title="Show Details" href="/hobby/{{ $hobby->id }}">
                            @if(file_exists('img/hobbies/'.$hobby->id.'_thumb.jpg'))
                                <img src="/img/hobbies/{{$hobby->id}}_thumb.jpg" alt="hobbythumb">
                            @endif
                                        {{ $hobby->name }}
                                    </a> 
                        @auth 
                        <a class="btn btn-sm btn-light ml-2" onclick="return confirm('Do you Wanna Edit?')" href="/hobby/{{$hobby->id}}/edit"><i class="fas fa-edit"></i>Edit hobby</a> 
                        @endauth

                        <span> {{$hobby->created_at}} </span>
                       <span class="mx-2">Posted by: <a href="/user/{{ $hobby->user->id }}">{{ $hobby->user->name }} ({{ $hobby->user->hobbies->count() }} Hobbies)</a>
                                    
                            @if(file_exists('img/users/'.$hobby->user->id.'_thumb.jpg'))<a href="/user/{{ $hobby->user->id }}">
                                        <img class="rounded" src="/img/users/{{$hobby->user->id}}_thumb.jpg"></a>
                                        @endif
                                    
                                    </span>
                        
                        @auth
                        <form class="float-right" style="display: inline;" action="/hobby/{{$hobby->id}}" method="post">
                            @csrf
                            @method('DELETE')
                            <input type="submit" onclick="return confirm('Are You Sure?')" value="Delete" class="btn btn-sm btn-danger">
                        </form> 
                        @endauth
                        <span class="float-right mx-2"> {{ $hobby->created_at->diffForHumans() }}</span>
                         <br>
                        @foreach($hobby->tags as $tag)
                        <a href="/hobby/tag/{{$tag->id}}"><span class="badge badge-{{ $tag->style }}">{{ $tag->name }}</span></a>
                         @endforeach

                                    

                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="mt-3">
                {{ $hobbies->links() }}                
            </div>
            @auth
            <div class="mt-2">
                <a href="/hobby/create" class="btn btn-success btn-sm"><i class="fas fa-plus-circle"></i>Create</a>
            </div>
            @endauth
        </div>
    </div>
</div>
@endsection
