@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                @if(session('flash_message'))
                    <div id="message-home" class="alert alert-info">
                        {!! session('flash_message') !!}
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    </div>
                @endif
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                @include('home-parts.feed')
            </div>
        </div>
    </div>
@endsection
