@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <p class="text-left"><a href="{{ url("/") }}" class="btn btn-outline-primary">
                        <i class="fa fa-arrow-left"></i>&nbsp;Voltar</a>
                </p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="text-center">{{ $envelope->name }}</h2>
                <h4 class="text-center">
                    <span style="color: <?= ($balance <= 0) ? '#f2756a' : '#28a745' ?>">R$ {{ $balance }}</span>
                </h4>
                @include('envelope-parts.modal-envelope-actions')
            </div>
            <div class="col-12">
                @include('envelope-parts.transactions')
            </div>
            <div class="col-12">
                @if(count($feed) != 0)
                    @include('envelope-parts.stats')
                @endif
            </div>
        </div>
    </div>
@endsection
