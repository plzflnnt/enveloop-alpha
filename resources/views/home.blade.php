@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                @if(session('flash_message'))
                    <div id="message-home" class="alert alert-info">{!! session('flash_message') !!}<a href="#"
                                                                                                                        class="close"
                                                                                                                        data-dismiss="alert"
                                                                                                                        aria-label="close">&times;</a>
                    </div>
                @endif
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                           role="tab" aria-controls="nav-home" aria-selected="true"><i class="fa fa-chart-pie"></i> Feed</a>

                        <a class="nav-item nav-link" id="nav-transactions-tab" data-toggle="tab" href="#nav-transactions"
                           role="tab" aria-controls="nav-transactions" aria-selected="false"><i class="fa fa-exchange-alt"></i> Transações</a>

                        <a class="nav-item nav-link" id="nav-saida-tab" data-toggle="tab" href="#nav-saida"
                           role="tab" aria-controls="nav-saida" aria-selected="false"><i class="fa fa-level-up-alt"></i> Saída</a>

                        <a class="nav-item nav-link" id="nav-entrada-tab" data-toggle="tab" href="#nav-entrada"
                           role="tab" aria-controls="nav-entrada" aria-selected="false"><i class="fa fa-level-down-alt"></i> Entrada</a>

                        <a class="nav-item nav-link" id="nav-stats-tab" data-toggle="tab" href="#nav-stats"
                           role="tab" aria-controls="nav-stats" aria-selected="false"><i class="fa fa-chart-line"></i> Estatísticas</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        @include('abas.feed')
                    </div>
                    <div class="tab-pane fade" id="nav-transactions" role="tabpanel" aria-labelledby="nav-transactions-tab">
                        @include('abas.transactions')
                    </div>
                    <div class="tab-pane fade" id="nav-saida" role="tabpanel" aria-labelledby="nav-saida-tab">
                        @include('abas.saida')
                    </div>
                    <div class="tab-pane fade" id="nav-entrada" role="tabpanel" aria-labelledby="nav-entrada-tab">
                        @include('abas.entrada')
                    </div>
                    <div class="tab-pane fade" id="nav-stats" role="tabpanel" aria-labelledby="nav-stats-tab">
                        @include('abas.stats')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
