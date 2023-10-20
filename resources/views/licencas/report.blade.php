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
            Licenças
        </header>

        <footer>
          <span>{{ date('d/m/Y H:i:s') }} - </span><span class="page-number">Página </span>         
        </footer>

        <main>
            @foreach($dataset as $row)
            <table  class="bordered" width="100%">
              <tbody>
                

                <tr>
                    <td colspan="8">
                        <label for="profissional"><strong>Nome</strong></label>
                        <div id="profissional">{{ $row->profissional->nome }}</div>
                    </td>
                    <td colspan="4">
                        <label for="matricula"><strong>Matrícula</strong></label>
                        <div id="matricula">{{ $row->profissional->matricula }}</div>
                    </td>
                    

                </tr>
                    
                <tr>
                    <td colspan="12">
                        <label for="cargo"><strong>Cargo</strong></label>
                        <div id="cargo">{{ $row->profissional->cargo->nome }}</div>
                    </td>
                </tr>

                <tr>
                    <td colspan="12">
                        <label for="feriastipo"><strong>Tipo de Licenca</strong></label>
                        <div id="feriastipo">{{ $row->licencatipo->nome }}</div>
                    </td>
                </tr>

                <tr>
                    <td colspan="6">
                        <label for="inicio"><strong>Data Inicial</strong></label>
                        <div id="inicio">{{ $row->inicio->format('d/m/Y') }}</div>
                    </td>
                    <td colspan="6">
                        <label for="fim"><strong>Data Final</strong></label>
                        <div id="fim">{{ $row->fim->format('d/m/Y') }}</div>
                    </td>
                    
                </tr>

                <tr>
                    <td colspan="12">
                        <label for="observacao"><strong>Observações</strong></label>
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