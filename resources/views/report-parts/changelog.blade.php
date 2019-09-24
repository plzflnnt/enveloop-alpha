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
                <h4 class="text-center">Enveloop Changelog</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <ul>
                    <li>0.2.3</li>
                    <ul>
                        <li>Criação de novos relarórios gráficos que substituem a tabela de progressão do saldo e os resultados do mês</li>
                        <li>Melhorias no desempenho simplificação das funcões de geração de gráficos</li>
                    </ul>
                    <li>0.2.2</li>
                    <ul>
                        <li>Criação de mensagens quando saldo estiver negativo</li>
                        <li>Melhorias na interface de mensagens</li>
                    </ul>
                    <li>0.2.1</li>
                    <ul>
                        <li>Correção na parte de relatório que somava o mês atual com o ano anterior</li>
                        <li>Correções pontuais de layout e textos</li>
                    </ul>
                    <li>0.2.0</li>
                    <ul>
                        <li>Reformulação do layout com a home simplificada e detalhes dos envelopes em páginas internas e relatórios contextuais para cada envelope</li>
                    </ul>
                    <li>0.1.3</li>
                    <ul>
                        <li>Adicionada aba de estatísticas</li>
                    </ul>
                    <li>0.1.2</li>
                    <ul>
                        <li>Melhorias na interface</li>
                    </ul>
                    <li>0.1.1</li>
                    <ul>
                        <li>Criado o relatório do ultimo mês</li>
                    </ul>
                    <li>0.1.0</li>
                    <ul>
                        <li>Criado feed de gastos para substituir as tabelas de envelopes</li>
                        <li>Melhoria na performance do código</li>
                        <li>Melhorias na interface</li>
                    </ul>
                    <li>0.0.1 alpha</li>
                    <ul>
                        <li>Enveloop - app de finanças baseado no método dos envelopes com relatórios que auxiliam na gestão de finanças pessoais</li>
                    </ul>
                </ul>
            </div>
        </div>
    </div>
@endsection
