<p align="center"><img src="http://www.contagem.mg.gov.br/novoportal/wp-content/themes/pmc/images/logo-prefeitura-contagem.png"></p>

## Sobre

SisSAS, Sistema da Superintendência de Assitência a Saúde, foi desenvolvido para fazer a gestão das equipes e profissionais de saúde da SMS (Secretaria Municipal de Saúde) de Contagem-MG.

O SisSAS foi constuído com a framework [Laravel](https://laravel.com/), na versão 5.7 e usa como front-end [Bootstrap 4.3](https://getbootstrap.com/).

Faz uso também das seguintes bibliotecas:

- [laravel-fpdf](https://github.com/codedge/laravel-fpdf)
- [typeahead](https://github.com/corejavascript/typeahead.js)
- [bootstrap-datepicker](https://github.com/uxsolutions/bootstrap-datepicker)
- [ImputMask](https://github.com/RobinHerbots/Inputmask.git)

## Requisitos

Os requisitos para executar esse sistema podem ser encontrado na [documentação oficial do laravel](https://laravel.com/docs/5.7):

- PHP >= 7.1.3
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- BCMath PHP Extension

## Instalação

Executar a migração das tabelas com o comando seed:

php artisan migrate --seed

Serão criados 4 usuários de acesso ao sistema, cada um com um perfíl de acesso diferente.

Login: adm@mail.com senha:123456, acesso total.
Login: gerente@mail.com senha:123456, acesso restrito.
Login: operador@mail.com senha:123456, acesso restrito, não pode excluir registros.
Login: leitor@mail.com senha: 123456, somente consulta.

## Funcionalidades

- Profisisonais de Saúde
- Controle de Licenças Médicas, Afastamentos e Férias dos Profissionais
- Cadastro das capacitações (cursos) dos profissionais de saúde
- Distritos
- Unidades e os profissionais que fazem parte da unidade
- Equipes
- Controle da quantidade de vagas/cargo de cada equipe
- Gestão das equipes
- Histórico dos profissionais

## Prefeitura Municipal de Contagem

[www.contagem.mg.gov.br](http://www.contagem.mg.gov.br/novoportal/)

## Contribuições

Caso queira contribuir com melhorias para esse sistema basta enviar um e-mail para erivelton.silva@contagem.mg.gov.br.

## Licenças

O sistema de protocolos é código aberto licenciado sob a [licença MIT](https://opensource.org/licenses/MIT).

## Notas de desenvolvimento

- Profissionais: filtrar por equipe (unidade e distrito?), apresentando somente os profissionais anexados a essas equipes, a utilidade é ter controle mais geral de onde está o funcionário dentro do sistema, o problema é que o funcionário pode estar em n posições dentro das equipes e unidades, não existe uma ligação 1-1 para esse caso
- Profissionais->Férias, Profissionais->Licenças finalizar a tela adicionando os respectivos filtros por data inicial e data final
- Adicionar ao histórico a unidade/equipe que o profissional entrou ou saiu, e permitir fazer um filtro
- Adicionar ao historico quando a carga horária do profissional for alterada


mais complicado:

- Os relatórios csv dessa versão estão abrindo com vários problemas no microlixo excel, mas abrem sem erro no openoffice. Alterar saída para xml e tentar a sorte com esse excel
- Atualizar o sistema para versão 7 do laravel, muito tempo, mas precisarei disso cedo ou tarde


Solicitações reunião 21/05/202

- Controle do cadastro de funcionários, bloquear repetição de cadastro através do excel. colocar cpf como campo único

- Ao enviar para a lixeira o cadastro do funionário deve-se ter a opção de se escolher um motivo: aposentadoria, falecimento, exoneração ou outro e especifique o motivo. Usarei o campo de notas do histórico para guardar essa informação ok, colocado campo aberto pra escrever o motivo que quiser, não coloquei outra tabela para isso

- Histórico dos profissionais:
- guardar a unidade ou equipe que o funcionário foi anexado [1]
- guardar a unidade ou equipe que o funcionário foi removido [2]
- [1] e [2] definem o processo de transferência, quando um funcionário é movimentado dentro das equipes ou unidades, esse processo deve ser de fácil consulta no sistema através de relatórios
- Guardar no histórico quando a carga horária for alterada ok
- Guardar no histórico quando o cargo for alterada ok
- Guardar no histórico quando o vínculo horária for alterada ok
- Guardar no histórico quando o profissional for cadastrado (acho que já tem) ok
- Melhorar os filtros da tela de consulta dos profissionais e relatórios de saída

