# LARAPI

# REQUISITOS
    - PHP 8.*
    - Node JS
    - Composer

# INSTALLATION
Obtenha o código do projeto fazendo um clone do projeto:
> git clone https://github.com/ernandesrs/pproj_larapi.git

Após isso, é preciso rodar os seguintes comandos para instalação de dependências PHP e Javascript:
> php artisan install
> npm install

Após executar os comandos acima, é preciso fazer algumas configurações opcionais e outras essenciais no arquivo de configuração da aplicação, veja a tabela abaixo:
| ENV NAME | DESCRIPTION | TYPE |
| --- | --- | --- |
| `APP_NAME` | Nome da aplicação | Optional |
| `DB_*` | Acesso ao banco de dados | Obrigatório |
| `MAIL_*` | Dados SMTP para envio de e-mail | Obrigatório |

Para facilitar o uso inicial da aplicação, um comando artisan foi criado para isso, veja abaixo mais detalhes.


Finally, run command and follow instructions:
> php artisan app:install

O comando acima irá rodar automaticamente os seguintes comandos do Laravel:
    - `php artisan key:generate`: Este comando irá gerar a chave privada da aplicação Laravel;
    - `php artisan storage:link`: Este comando irá criar um link simbólico para acesso storage da aplicação;
    - `php artisan migrate`: Este comando irá gerar o banco de dados e as tabelas;
    - `php artisan db:seed` Este comando irá preencher o banco de dados com dados fakes para testes;

Além de executar os comandos acima, o banco de dados será preenchido com 2 usuários principais: um super usuário e um administrador; além de criar 2 cargos básicos da aplicação: *super_user* e *admin_user*.
