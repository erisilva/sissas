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
                font-family: Helvetica, Arial, sans-serif;
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

            .bloco-p {
                background-color: #ccc;
                text-align: center;
                color: #fff;
            }
    </style>
</head>
    <body>
        <header>
            Gestão de Equipes e Vagas
        </header>

        <footer>
          <span>{{ date('d/m/Y H:i:s') }} - </span><span class="page-number">Página </span>         
        </footer>

        <main>
            @foreach($dataset as $row)


            <p></p>
            <table  class="bordered" width="100%">

              <tbody>
                
                <tr>
                    <td colspan="8">
                        <label for="descricao"><strong>Descricao</strong></label>
                        <div id="descricao">{{ $row->descricao }}</div>
                    </td>
                    <td colspan="4">
                        <label for="numero"><strong>Número</strong></label>
                        <div id="numero">{{ $row->numero }}</div>
                    </td>
                </tr>

                <tr>
                    <td colspan="3">
                        <label for="cnes"><strong>CNES</strong></label>
                        <div id="cnes">{{ $row->cnes }}</div>
                    </td>
                    <td colspan="3">
                        <label for="ine"><strong>INE</strong></label>
                        <div id="ine">{{ $row->ine }}</div>
                    </td>
                    <td colspan="3">
                        <label for="minima"><strong>Mínima</strong></label>
                        <div id="minima">{{ ($row->minima == 's') ? 'Sim' : 'Não' }}</div>
                    </td>
                    <td colspan="3">
                        <label for="ine"><strong>Tipo</strong></label>
                        <div id="ine">{{ $row->equipeTipo->nome }}</div>
                    </td>
                </tr>

                <tr>
                    <td colspan="8">
                        <label for="unidade_descricao"><strong>Unidade</strong></label>
                        <div id="unidade_descricao">{{ $row->unidade->nome }}</div>
                    </td>
                    <td colspan="4">
                        <label for="distrito_descricao"><strong>Distrito</strong></label>
                        <div id="distrito_descricao">{{ $row->unidade->distrito->nome}}</div>
                    </td>
                </tr>



              </tbody>
            </table>


            <p class="bloco-p">
                Vagas
            </p>
            <table  class="bordered" width="100%">
                <tbody>
                    @foreach($row->equipeProfissionals as $vaga)

                

                        <tr>
                            <td colspan="4">
                                <label for="cargo"><strong>Cargo</strong></label>
                                <div id="cargo">{{ $vaga->cargo->nome }}</div>
                            </td>
                            <td colspan="8">
                                <label for="cargo"><strong>Cargo</strong></label>
                                <div id="cargo">{{ $vaga->cargo->cbo }}</div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4">
                                <label for="profissional"><strong>Profissional</strong></label>
                                <div id="profissional">{{ isset($vaga->profissional_id) ? $vaga->profissional->nome : 'Não Vínculado' }}</div>
                            </td>
                            <td colspan="8">
                                <label for="profissional"><strong>Profissional</strong></label>
                                <div id="profissional">{{ isset($vaga->profissional_id) ? $vaga->profissional->matricula : 'Não Vínculado' }}</div>
                            </td>
                        </tr>
                     
                    @endforeach
                </tbody>
                
            </table>

            @endforeach
        </main>
    </body>
</html>