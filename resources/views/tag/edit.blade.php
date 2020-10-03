@extends('layouts.app')
@section('content')
 <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Edit Tag</div>
                    <div class="card-body">
                      <form method="post" action="/tag/{{$tag->id}}">
                      	@csrf
                        @method('PUT')
                      	<div class="form-group">
                      	<label for="name">Name</label>
                      	<input type="text" name="name" id="name" class="form-control {{ $errors->has('name') ? 'border-danger' : ''}}" value="{{ old('name') ??  $tag->name}}">
                        <small class="form-text text-danger">{!! $errors->first('name') !!}</small>
                        
                       </div>

                       <div class="form-group">
                         <label for="style">Style</label>
                         <input type="text" name="style" id="style" value="{{ old('style') ?? $tag->style }}" class="form-control {{ $errors->has('style') ? 'border-danger' : ''}}">
                         <small class="form-text text-danger">{!! $errors->first('style') !!}</small>

                       </div>
                        <input class="btn btn-primary mt-4" type="submit" value="Update Tag">
                      	
                      </form>
                      <a class="btn btn-primary float-right" href="/tag"><i class="fas fa-arrow-circle-up"></i> Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
