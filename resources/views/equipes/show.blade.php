@extends('layouts.app')

@section('title', 'Equipes e Vagas')

@section('content')
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('equipes.index') }}">
                        Equipes e Vagas
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ __('Show') }}
                </li>
            </ol>
        </nav>
    </div>

    <div class="container">
        <form>
            <div class="row g-3">


                <div class="col-md-8">
                    <label for="descricao" class="form-label">Descrição</label>
                    <input type="text" class="form-control" name="descricao" id="descricao"
                        value="{{ $equipe->descricao }}" readonly>
                </div>
                <div class="col-md-4">
                    <label for="numero" class="form-label">Número</label>
                    <input type="text" class="form-control" name="numero" id="numero" value="{{ $equipe->numero }}"
                        readonly>
                </div>

                <div class="col-md-3">
                    <label for="cnes" class="form-label">CNES</label>
                    <input type="text" class="form-control" name="cnes" id="cnes" value="{{ $equipe->cnes }}"
                        readonly>
                </div>
                <div class="col-md-3">
                    <label for="ine" class="form-label">INE</label>
                    <input type="text" class="form-control" name="ine" id="ine" value="{{ $equipe->ine }}"
                        readonly>
                </div>
                <div class="col-md-3">
                    <label for="minima" class="form-label">Mínima</label>
                    <input type="text" class="form-control" name="minima" id="minima" value="{{ $equipe->minima }}"
                        readonly>
                </div>
                <div class="col-md-3">
                    <label for="tipo" class="form-label">Tipo</label>
                    <input type="text" class="form-control" name="tipo" id="tipo"
                        value="{{ $equipe->equipeTipo->nome }}" readonly>
                </div>

                <div class="col-md-8">
                    <label for="unidade" class="form-label">Unidade</label>
                    <input type="text" class="form-control" name="unidade" id="unidade"
                        value="{{ $equipe->unidade->nome }}" readonly>
                </div>
                <div class="col-md-4">
                    <label for="distrito" class="form-label">Distrito</label>
                    <input type="text" class="form-control" name="distrito" id="distrito"
                        value="{{ $equipe->unidade->distrito->nome }}" readonly>
                </div>


                <div class="col-md-4">
                    <label for="total_de_vagas" class="form-label">Total de Vagas</label>
                    <input type="text" class="form-control" name="total_de_vagas" id="total_de_vagas"
                        value="{{ $equipe->total_vagas }}" readonly>
                </div>
                <div class="col-md-4">
                    <label for="total_de_vagas_preenchidas" class="form-label">Total de Vagas Prenchidas</label>
                    <input type="text" class="form-control" name="total_de_vagas_preenchidas"
                        id="total_de_vagas_preenchidas" value="{{ $equipe->vagas_preenchidas }}" readonly>
                </div>
                <div class="col-md-4">
                    <label for="total_de_vagas_livres" class="form-label">Total de Vagas Livres</label>
                    <input type="text" class="form-control" name="numero" id="total_de_vagas_livres"
                        value="{{ $equipe->vagas_disponiveis }}" readonly>
                </div>



            </div>
        </form>
    </div>

    <br>

    @if (count($equipeprofissionais))
        <div class="container py-2">
            <p class="text-center bg-primary text-white">
                <strong>Cargos e Vagas</strong>
            </p>
        </div>

        <div class="container">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Cargo</th>
                            <th scope="col">CBO</th>
                            <th scope="col">Profissional</th>
                            <th scope="col">Matrícula</th>
                            <th scope="col">CPF</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($equipeprofissionais as $equipeprofissional)
                            <tr>
                                <td><strong>{{ $equipeprofissional->cargo->nome }}</strong></td>
                                <td>{{ $equipeprofissional->cargo->cbo }}</td>
                                <td>
                                    @if (isset($equipeprofissional->profissional->id))
                                        <span>
                                            <a class="btn btn-sm btn-success" role="button" data-bs-toggle="modal"
                                                data-bs-target="#ProfissionalModal"
                                                data-profissional-id="{{ $equipeprofissional->profissional->id }}">
                                                <x-icon icon='people' />
                                            </a>
                                            {{ $equipeprofissional->profissional->nome }}
                                        </span>
                                    @else
                                        <span class="badge text-bg-info">Vaga Livre</span>
                                    @endif
                                </td>
                                <td>
                                    {{ isset($equipeprofissional->profissional->matricula) ? $equipeprofissional->profissional->matricula : '-' }}
                                </td>
                                <td>
                                    {{ isset($equipeprofissional->profissional->cpf) ? $equipeprofissional->profissional->cpf : '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="alert alert-info" role="alert">
            Essa Unidade não Possui Vagas Preenchidas!
        </div>
    @endif


    <div class="container">




    </div>



    @can('equipe.delete')
        <x-btn-trash />
    @endcan

    <x-btn-back route="equipes.index" />

    @can('equipe.delete')
        <x-modal-trash class="modal-sm">
            <form method="post" action="{{ route('equipes.destroy', $equipe->id) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <x-icon icon='trash' /> {{ __('Delete this record?') }}
                </button>
            </form>
        </x-modal-trash>
    @endcan

    <!-- Profissional Modal -->
    <div class="modal fade modal-xl" id="ProfissionalModal" tabindex="-1" aria-labelledby="Profissional"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel"><x-icon icon='people' /> Profissional</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nome" class="form-label">Nome</label>
                                <input type="text" class="form-control" name="modal_nome" id="modal_nome"
                                    value="" readonly disabled>
                            </div>
                            <div class="col-md-2">
                                <label for="matricula" class="form-label">Matricula</label>
                                <input type="text" class="form-control" name="modal_matricula" id="modal_matricula"
                                    value="" readonly disabled>
                            </div>
                            <div class="col-md-2">
                                <label for="cpf" class="form-label">CPF</label>
                                <input type="text" class="form-control" name="modal_cpf" id="modal_cpf"
                                    value="" readonly disabled>
                            </div>
                            <div class="col-md-2">
                                <label for="cns" class="form-label">CNS</label>
                                <input type="text" class="form-control" name="modal_cns" id="modal_cns"
                                    value="" readonly disabled>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="text" class="form-control" name="modal_email" id="modal_email"
                                    value="" readonly disabled>
                            </div>
                            <div class="col-md-3">
                                <label for="tel" class="form-label">TEL</label>
                                <input type="text" class="form-control" name="modal_tel" id="modal_tel"
                                    value="" readonly disabled>
                            </div>
                            <div class="col-md-3">
                                <label for="cel" class="form-label">CEL</label>
                                <input type="text" class="form-control" name="modal_cel" id="modal_cel"
                                    value="" readonly disabled>
                            </div>
                            <div class="col-md-2">
                                <label for="cep" class="form-label">CEP</label>
                                <input type="text" class="form-control" name="modal_cep" id="modal_cep"
                                    value="" readonly disabled>
                            </div>
                            <div class="col-md-5">
                                <label for="logradouro" class="form-label">Logradouro</label>
                                <input type="text" class="form-control" name="modal_logradouro" id="modal_logradouro"
                                    value="" readonly disabled>
                            </div>
                            <div class="col-md-2">
                                <label for="numero" class="form-label">Nº</label>
                                <input type="text" class="form-control" name="modal_numero" id="modal_numero"
                                    value="" readonly disabled>
                            </div>
                            <div class="col-md-3">
                                <label for="complemento" class="form-label">Complemento</label>
                                <input type="text" class="form-control" name="modal_complemento"
                                    id="modal_complemento" value="" readonly disabled>
                            </div>
                            <div class="col-md-5">
                                <label for="bairro" class="form-label">Bairro</label>
                                <input type="text" class="form-control" name="modal_bairro" id="modal_bairro"
                                    value="" readonly disabled>
                            </div>
                            <div class="col-md-5">
                                <label for="cidade" class="form-label">Cidade</label>
                                <input type="text" class="form-control" name="modal_cidade" id="modal_cidade"
                                    value="" readonly disabled>
                            </div>
                            <div class="col-md-2">
                                <label for="uf" class="form-label">UF</label>
                                <input type="text" class="form-control" name="modal_uf" id="modal_uf"
                                    value="" readonly disabled>
                            </div>
                            <div class="col-md-5">
                                <label for="cargo" class="form-label">Cargo</label>
                                <input type="text" class="form-control" name="modal_cargo" id="modal_cargo"
                                    value="" readonly disabled>
                            </div>
                            <div class="col-md-3">
                                <label for="vinculo" class="form-label">Vinculo</label>
                                <input type="text" class="form-control" name="modal_vinculo" id="modal_vinculo"
                                    value="" readonly disabled>
                            </div>
                            <div class="col-md-4">
                                <label for="vinculotipo" class="form-label">Tipo de Vínculo</label>
                                <input type="text" class="form-control" name="modal_vinculotipo"
                                    id="modal_vinculotipo" value="" readonly disabled>
                            </div>
                            <div class="col-md-3">
                                <label for="cargahoraria" class="form-label">Carga Horária</label>
                                <input type="text" class="form-control" name="modal_cargahoraria"
                                    id="modal_cargahoraria" value="" readonly disabled>
                            </div>
                            <div class="col-md-6">
                                <label for="flexibilizacao" class="form-label">Flexibilização</label>
                                <input type="text" class="form-control" name="modal_flexibilizacao"
                                    id="modal_flexibilizacao" value="" readonly disabled>
                            </div>
                            <div class="col-md-3">
                                <label for="admissao" class="form-label">Admissão</label>
                                <input type="text" class="form-control" name="modal_admissao" id="modal_admissao"
                                    value="" readonly disabled>
                            </div>
                            <div class="col-md-4">
                                <label for="registroClasse" class="form-label">Registro de Classe</label>
                                <input type="text" class="form-control" name="modal_registroClasse"
                                    id="modal_registroClasse" value="" readonly disabled>
                            </div>
                            <div class="col-md-4">
                                <label for="orgao_emissor" class="form-label">Orgão Emissor</label>
                                <input type="text" class="form-control" name="modal_orgao_emissor"
                                    id="modal_orgao_emissor" value="" readonly disabled>
                            </div>
                            <div class="col-md-4">
                                <label for="ufOrgaoEmissor" class="form-label">UF/SSP</label>
                                <input type="text" class="form-control" name="modal_ufOrgaoEmissor"
                                    id="modal_ufOrgaoEmissor" value="" readonly disabled>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <x-icon icon='x' /> Fechar
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script-footer')
    <script src="{{ asset('js/jquery-3.6.4.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#ProfissionalModal').on('show.bs.modal', function(e) {
                var profissionalid = $(e.relatedTarget).data('profissional-id');

                $.ajax({
                    dataType: "json",
                    url: "{{ url('/') }}" + "/profissionals/export/json/" + profissionalid,
                    type: "GET",
                    success: function(json) {
                        $("#modal_nome").val(json['nome']);
                        $("#modal_cpf").val(json['cpf']);
                        $("#modal_cns").val(json['cns']);
                        $("#modal_matricula").val(json['matricula']);
                        $("#modal_email").val(json['email']);
                        $("#modal_tel").val(json['tel']);
                        $("#modal_cel").val(json['cel']);
                        $("#modal_cep").val(json['cep']);
                        $("#modal_logradouro").val(json['logradouro']);
                        $("#modal_numero").val(json['numero']);
                        $("#modal_complemento").val(json['complemento']);
                        $("#modal_bairro").val(json['bairro']);
                        $("#modal_cidade").val(json['cidade']);
                        $("#modal_uf").val(json['uf']);
                        $("#modal_cargo").val(json['cargo']['nome']);
                        $("#modal_vinculo").val(json['vinculo']['nome']);
                        $("#modal_vinculotipo").val(json['vinculotipo']['nome']);
                        $("#modal_cargahoraria").val(json['cargahoraria']['nome']);
                        $("#modal_flexibilizacao").val(json['flexibilizacao']);
                        var admissaoDate = moment(json['admissao']).format('DD/MM/YYYY');
                        $("#modal_admissao").val(admissaoDate);
                        $("#modal_registroClasse").val(json['registroClasse']);
                        $("#modal_orgao_emissor").val(json['orgaoemissor']['nome']);
                        $("#modal_ufOrgaoEmissor").val(json['ufOrgaoEmissor']);

                    }
                });

            });

        });
    </script>

@endsection
