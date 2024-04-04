@extends('layouts.app')

@section('title', __('About'))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">SisSAS 2.0.0 Abril-2024</div>

                <div class="card-body">
                    <p>Sistema de Gestão de Equipes e Profissionais de Saúde</p>
                    <p>Analista Responsável: Erivelton da Silva <a href="mailto:erivelton.silva@contagem.mg.gov.br">erivelton.silva@contagem.mg.gov.br</a></p>
                    <p>Código fonte do software está disponível no repertório do <a href="https://github.com/erisilva/sissas.git">{{ __('GitHub') }}</a>.</p>
                </div>    
            </div>    
        </div>
    </div>
</div>
@endsection
