# Inicio do trabalho local

- Clone o repositório na sua maquina. <br>
git clone https://github.com/chsguitar1/fed-produto-pet-app

- Rode o comando para instalar as dependecias do Node <br>
npm install

- Rode o comando para instalar as dependecias do Composer <br>
composer install

- Copie o conteudo do .env.example e cole no .env, após gere a chave do artisan <br>
cp .env.example .env <br> php artisan key:generate

- Rode os dois serviços: <br>
npm run dev <br> php artisan serve

> Obs: um em cada terminal.

- Para finalizar rode as migrations em um terceiro terminal: <br>
php artisan migrate

> Obs: Como estaremos utilizando SQLite por enquanto, veja se ao rodar as migrations um aquivo aparece no caminho: <br> ./database/database.sqlite

- Acesse no navegador para conferir o projeto em produção <br>
localhost:8000/

## Requisitos: 

- Node instalado no PC
- Instalados: Laravel, Composer e PHP
    - doc: https://laravel.com/framework/docs


## Tarefas:

Criação das Migrations:
- Migration De Produtos
- Migration de Categoria
- Migration de Lote
- Migration de Marca

Criação de Models: 
- Model De Produtos
- Model de Categoria
- Model de Lote
- Model de Marca
> Depende Das migrations

Criação de controller:
- Controller de cadastro de produtos:
    - Recebe todos os dados de cadastro do produto
    - identifica quais atributos colocar em cada tabela (model)
    - Envia para o Repository fazer a operação no Banco
> Depende das models

Criação de Views: 
- Forms De cadastro de produtos
- Listagem de Produtos
> Depende do Controllers

## Comando essenciais:

- Criar Migration: 
> php artisan make:migration create_nomeDaTabela_table --create=nomeDaTabela

- Executar migration:
> php artisan migrate

- Criar model: 
> php artisan make:model NomeDoModel

- Criar o controller (vazio)
> php artisan make:controller NomeDoController

- Criar o controller com metódos CRUD
> php artisan make:controller NomeDoController --resource

- Criação da View:<br>
    - No Linux/macOS: <br>
    > touch resources/views/nome-da-view.blade.php <br>
    - No Windows (PowerShell): <br>
    > New-Item resources/views/nome-da-view.blade.php


