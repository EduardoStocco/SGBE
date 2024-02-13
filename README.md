Documentação de Instalação do Projeto de Gestão de Biblioteca
Introdução
Este documento fornece instruções detalhadas para a instalação e configuração do sistema de gestão de biblioteca desenvolvido com Laravel, utilizando Laravel Breeze + TailwindCSS para o frontend e PostgreSQL como sistema de gerenciamento de banco de dados (SGBD).

Requisitos
PHP >= 7.3
Composer
PostgreSQL
Node.js e NPM
Instalação
1. Clonar o Repositório
Clone o repositório do GitHub para o seu ambiente local usando:

bash
Copy code
git clone <URL_DO_REPOSITORIO>
cd <DIRETORIO_DO_PROJETO>
2. Instalar Dependências do Composer
Execute o seguinte comando para instalar as dependências do PHP:

bash
Copy code
composer install
3. Configuração do Ambiente
Copie o arquivo .env.example para .env no diretório raiz do projeto:

bash
Copy code
cp .env.example .env
Abra o arquivo .env e configure as variáveis de ambiente para conectar ao seu banco de dados PostgreSQL:

makefile
Copy code
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=nome_do_seu_banco
DB_USERNAME=usuario_do_banco
DB_PASSWORD=senha_do_banco
4. Gerar Chave do Aplicativo
Gere a chave do aplicativo Laravel com:

bash
Copy code
php artisan key:generate
5. Criar Banco de Dados
Crie um banco de dados no PostgreSQL que corresponda ao nome fornecido em DB_DATABASE no seu arquivo .env.

6. Executar Migrações
Execute as migrações para criar as tabelas no banco de dados:

bash
Copy code
php artisan migrate
7. Instalar Dependências do NPM
Instale as dependências do frontend e compile os assets:

bash
Copy code
npm install
npm run dev
8. Iniciar o Servidor de Desenvolvimento
Inicie o servidor de desenvolvimento do Laravel:

bash
Copy code
php artisan serve
Acesse o sistema pelo navegador utilizando o endereço fornecido pelo comando, geralmente http://127.0.0.1:8000.
