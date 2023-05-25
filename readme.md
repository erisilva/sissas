# sissas - Aplicativo Web para Gerenciamento de Equipes de Saúde

Em desenvolvimento

## Visão Geral

Bem-vindo à página do GitHub para o meu aplicativo web desenvolvido (em desenvolvimento) em Laravel 10 e Bootstrap 5.2! Este projeto é dedicado ao gerenciamento de equipes de saúde com profissionais da área. As equipes estão organizadas por unidades e distritos, e o aplicativo oferece recursos abrangentes para melhorar o controle e a eficiência.

## Recursos

- Rastreamento de Transferências: O aplicativo permite rastrear as transferências de profissionais entre as equipes, fornecendo um registro completo das movimentações.
- Controle de Férias e Licenças: Com esse recurso, é possível acompanhar as férias e licenças médicas dos profissionais de saúde, garantindo uma gestão eficiente.
- Controle de Vagas: O aplicativo controla o número e as vagas disponíveis em cada equipe, permitindo ao administrador equilibrar as equipes de saúde de forma eficaz.
- Organização por Unidades e Distritos: As equipes são arranjadas em unidades e distritos, proporcionando uma estrutura clara e organizada.
- Integração do Laravel 10 e Bootstrap 5.2: O aplicativo aproveita as capacidades do Laravel 10 e a estilização moderna do Bootstrap 5.2 para oferecer uma experiência de usuário atraente e responsiva.

## Frameworks e Bibliotecas

- [Laravel 10.x](https://laravel.com/docs/10.x)
- [Bootstrap 5.2](https://getbootstrap.com/docs/5.2/getting-started/introduction/)

## Prerequisites

The requirements to run this system can be found at the link: [documentação oficial do laravel](https://laravel.com/docs/10.x):

- Laravel 10.x requires a minimum PHP version of 8.1
- Enable extension=gd extension in php.ini (for captcha)
- Enable extension=zip extension in php.ini (for captcha)

## Dependencies

- [Captcha for Laravel](https://github.com/mewebstudio/captcha), Note: Enable extension=gd extension in php.ini
- [Laravel DomPdf](https://github.com/barryvdh/laravel-dompdf)
- [laravel excel export lib](https://laravel-excel.com/)
- [bootstrap-datepicker](https://github.com/uxsolutions/bootstrap-datepicker)
- [Inputmask](https://github.com/RobinHerbots/Inputmask)

## Installation

### Clone the repository

```
git clone https://github.com/erisilva/acl80.git
```

Use composer to install project dependencies:

```
composer update
```

### Create the database

This configuration shown below uses MySQL as the database. This configuration is for a development environment, therefore not recommended for production.

```
CREATE DATABASE database_name_here CHARACTER SET utf8 COLLATE utf8_general_ci;
```

### Configure the environment

Create the settings .env file:

```
php -r "copy('.env.example', '.env');"
```

Edit the .env file in the root folder of the project with the database configuration data. More info in [documentação oficial do laravel](https://laravel.com/docs/10.x/configuration#environment-configuration):
    
```
DB_CONNECTION=mysql
DB_HOST=
DB_PORT=
DB_DATABASE=database_name_here
DB_USERNAME=your_username_here
DB_PASSWORD=yout_password_here
```

### Generate the application key

```
php artisan key:generate
```
### Configure the storage if necessary

```
php artisan storage:link
```

### Migration

Executar a migração das tabelas com o comando seed:

```
php artisan migrate --seed
```


## Usage

To run the system, use the command:

```
php artisan serve
```
Access the application in your web browser by visiting http://localhost:8000 or the appropriate URL provided by the php artisan serve command.

### Users

Login: adm@mail.com 
Login: gerente@mail.com 
Login: operador@mail.com
Login: leitor@mail.com

Note: The password for all users is 123456. By default, the migration generates users with names in Brazilian Portuguese.

## Contact

- E-mail: erivelton.silva@proton.me
- Discord: gixeph#0658

## Contribuições

Se você deseja contribuir para este projeto, fique à vontade para enviar suas sugestões, relatar problemas e enviar solicitações de pull. Para isso, faça um fork do repositório, faça suas alterações e envie uma solicitação de pull descrevendo suas modificações.

## Future Enhancements

Aqui estão algumas áreas potenciais para o desenvolvimento e aprimoramento deste aplicativo web no futuro:

- Implementação de recursos avançados de relatórios e estatísticas para auxiliar na tomada de decisões gerenciais.
- Adição de recursos de notificação para informar sobre transferências de profissionais, férias, etc.
- Aprimoramento da interface do usuário com recursos de arrastar e soltar para facilitar o gerenciamento de equipes e vagas.
- Integração com outros sistemas e APIs relacionados à área da saúde para otimizar a gestão e os processos.

## Licenças

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details, except for the libraries used.

## Acknowledgments

- [Laravel](https://laravel.com/)
- [Bootswatch](https://bootswatch.com/)
