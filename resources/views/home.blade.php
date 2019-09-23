@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                @include('home-parts.messages')
                @include('home-parts.bubbles')
                @include('home-parts.feed')
                @include('home-parts.stats')

                @if(count($envelopes) == 0)
                    <div class="col-12">
                        <p><strong>Bem-vindo ao Enveloop!</strong> Para começar clique em investir (ao lado do Saldo) e insira o seu
                            saldo atual somado de todas as suas economias, após isso é hora de criar um envelope.</p>
                        <p>Se você não sabe o que é o método dos envelopes <a href="" target="_blank">clique aqui</a> e assista um curto
                            vídeo explicativo.</p>
                        <p>Cada envelope serve como uma poupança onde você pode dividir deu dinheiro por tipo de gasto e organizar suas
                            finanças evitando que você use o dinheiro do seguro do carro com as saídas no fim de semana por exemplo.</p>
                        <p>Tendo um maior controle visual sobre suas finanças, você junta dinheiro pra comprar aquele celular bacana no
                            fim do ano sem faltar dinheiro para as coisas essenciais</p>
                    </div>
                    &nbsp;
                    <hr>
                    &nbsp;
                @endif

            </div>
        </div>
    </div>
@endsection
