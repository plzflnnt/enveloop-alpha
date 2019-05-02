@extends('layouts.app')

@section('content')
    <div class="container">
        <p class="text-left"><a href="{{ url("/") }}" class="btn btn-outline-primary"><i class="fa fa-arrow-left"></i>&nbsp;Voltar</a></p>
        <div class="row justify-content-center">
            <div class="col-12">
                @include('report-parts.chart')
            </div>
        </div>
    </div>
@endsection
