<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style media="screen">
            @page {
                margin: 0cm 0cm;
            }

            body {
                margin-top: 2cm;
                margin-left: 1cm;
                margin-right: 1cm;
                margin-bottom: 2cm;
            }

            header {
                position: fixed;
                top: 0cm;
                left: 0cm;
                right: 0cm;
                height: 2cm;
                background-color: rgb(179, 179, 179);
                color: white;
                text-align: center;
                line-height: 1.5cm;
                font-family: Helvetica, Arial, sans-serif;
            }

            /** Define the footer rules **/
            footer {
                position: fixed; 
                bottom: 0cm; 
                left: 0cm; 
                right: 0cm;
                height: 2cm;
                background-color: rgb(179, 179, 179);
                color: white;
                text-align: center;
                line-height: 1.5cm;
            }

            footer .page-number:after { content: counter(page); }

            .bordered td {
                border-color: #959594;
                border-style: solid;
                border-width: 1px;
            }

            table {
                border-collapse: collapse;
            }
    </style>
</head>
    <body>
        <header>
            Profissionais
        </header>

        <footer>
          <span>{{ date('d/m/Y H:i:s') }} - </span><span class="page-number">Página </span>         
        </footer>

        <main>
            @foreach($dataset as $row)
            <table  class="bordered" width="100%">

              <tbody>
                

                <tr>
                    <td colspan="6">
                        <label for="situacao"><strong>Nome</strong></label>
                        <div id="situacao">{{ $row->nome }}</div>
                    </td>
                    <td colspan="2">
                        <label for="situacao"><strong>Matrícula</strong></label>
                        <div id="matricula">{{ $row->matricula }}</div>
                    </td>
                    <td colspan="2">
                        <label for="origem"><strong>CPF</strong></label>
                        <div id="origem">{{ $row->cpf }}</div>
                    </td>
                    <td colspan="2">
                        <label for="origem"><strong>CNS</strong></label>
                        <div id="origem">{{ $row->cns }}</div>
                    </td>
                </tr>

                <tr>
                    <td colspan="6">
                        <label for="email"><strong>E-mail</strong></label>
                        <div id="email">{{ $row->email }}</div>
                    </td>
                    <td colspan="3">
                        <label for="tel"><strong>TEL</strong></label>
                        <div id="tel">{{ $row->tel }}</div>
                    </td>
                    <td colspan="3">
                        <label for="tel"><strong>CEL</strong></label>
                        <div id="tel">{{ $row->tel }}</div>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <label for="cep"><strong>CEP</strong></label>
                        <div id="cep">{{ $row->cep }}</div>
                    </td>
                    <td colspan="5">
                        <label for="logradouro"><strong>Logradouro</strong></label>
                        <div id="logradouro">{{ $row->logradouro }}</div>
                    </td>
                    <td colspan="2">
                        <label for="numero"><strong>Nº</strong></label>
                        <div id="numero">{{ $row->numero }}</div>
                    </td>
                    <td colspan="3">
                        <label for="complemento"><strong>Complem.</strong></label>
                        <div id="complemento">{{ $row->complemento }}</div>
                    </td>
                </tr>

                <tr>
                    <td colspan="5">
                        <label for="bairro"><strong>Bairro</strong></label>
                        <div id="bairro">{{ $row->bairro }}</div>
                    </td>
                    <td colspan="5">
                        <label for="cidade"><strong>Cidade</strong></label>
                        <div id="cidade">{{ $row->cidade }}</div>
                    </td>
                    <td colspan="2">
                        <label for="uf"><strong>UF</strong></label>
                        <div id="uf">{{ $row->uf }}</div>
                    </td>
                </tr>

                <tr>
                    <td colspan="5">
                        <label for="cargo"><strong>Cargo</strong></label>
                        <div id="cargo">{{ $row->cargo->nome }}</div>
                    </td>
                    <td colspan="3">
                        <label for="vinculo"><strong>Vínculo</strong></label>
                        <div id="vinculo">{{ $row->vinculo->nome }}</div>
                    </td>
                    <td colspan="4">
                        <label for="vinculotipo"><strong>Tipo</strong></label>
                        <div id="vinculotipo">{{ $row->vinculotipo->nome }}</div>
                    </td>
                </tr>

                <tr>
                    <td colspan="3">
                        <label for="cargahoraria"><strong>Carga Horária</strong></label>
                        <div id="cargahoraria">{{ $row->cargahoraria->nome }}</div>
                    </td>
                    <td colspan="6">
                        <label for="flexibilizacao"><strong>Flexibilização</strong></label>
                        <div id="flexibilizacao">{{ $row->flexibilizacao }}</div>
                    </td>                    
                    <td colspan="3" style = "text-align: center;">
                        <label for="admissao"><strong>Admissão</strong></label>
                        <div id="admissao">{{ date('d/m/Y', strtotime($row->admissao)) }}</div>
                    </td>
                </tr>

                <tr>
                    <td colspan="4">
                        <label for="registroClasse"><strong>Registro de Classe</strong></label>
                        <div id="registroClasse">{{ $row->registroClasse }}</div>
                    </td>
                    <td colspan="4">
                        <label for="orgaoemissor"><strong>Orgão Emissor</strong></label>
                        <div id="orgaoemissor">{{ $row->orgaoemissor->nome }}</div>
                    </td>
                    <td colspan="4">
                        <label for="ufOrgaoEmissor"><strong>UF/SSP</strong></label>
                        <div id="ufOrgaoEmissor">{{ $row->ufOrgaoEmissor }}</div>
                    </td>
                </tr>

                <tr>
                    <td colspan="12">
                        <label for="observacao"><strong>Observação</strong></label>
                        <div id="observacao">{{ $row->observacao }}</div>
                    </td>
                </tr>
                
              </tbody>
            </table>
            <br>
            @endforeach
        </main>
    </body>
</html>