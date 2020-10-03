@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">Tag Detail view</div>

                <div class="card-body">
                    <p>Name-<b>{{$tag->name}}</b></p>
                    <p>Style-<b>{{$tag->style}} </b></p>
                </div>
            </div>
            <div class="mt-2">
                <a href="/tag" class="btn btn-primary btn-sm"><i class="fas fa-arrow-circle-up"></i>Back</a>
            </div>
        </div>
    </div>
</div>
@endsection