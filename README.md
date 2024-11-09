## Requisitos

* Git
* Docker
* Docker Compose

## Imagem utilizada Docker

* PHP 8.3
* Composer 2.8
* Node.js 20

## Como usar o GitHub

Baixar os arquivos do Git

```
git clone --branch main https://github.com/saviorenato/tcc.git .
```

## Como rodar o projeto baixado

Duplicar o arquivo ".env.example" e renomear para ".env".<br>
Para a funcionalidade recuperar senha funcionar, necessário alterar as credenciais do servidor de envio de e-mail no arquivo .env.<br>

Iniciar o Container Docker

```
docker compose up -d
```

Acessar o Container do APP

```
docker exec -it app bash
```

Instalar as dependências do PHP

```
composer install
```

Instalar as dependências do Node.js

```
npm install
```

Gerar a chave

```
php artisan key:generate
```

Executar as migration

```
php artisan migrate --seed
```

Executar as bibliotecas Node.js

```
npm run build
```

Acessar o Projeto na URL

```
http://localhost
```

### Serão criados as seguintes tabelas

* permissions – Está tabela armazenará as permissões.
* role_has_permissions – Está tabela armazenará as permissões por hierarquia.
* roles – Está tabela armazenará as hierarquias de acesso.
* rules – Está tabela armazenará as regras de cobrança de imposto.
* taxes – Está tabela armazenará os impostos a serem pagos.
* tickers – Está tabela armazenará as tickers da bolsa de valores.
* transactions – Está tabela armazenará as transações.

Criar seed de transações

```
php artisan make:seeder TransactionSeeder
```
