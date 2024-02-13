<h1>Documentação de Instalação do Projeto de Gestão de Biblioteca</h1>

**Este documento fornece instruções detalhadas para a instalação e configuração do sistema de gestão de biblioteca desenvolvido com Laravel, utilizando Laravel Breeze + TailwindCSS para o frontend e PostgreSQL como sistema de gerenciamento de banco de dados (SGBD).**

Requisitos<br>
PHP >= 7.3<br>
Composer<br>
PostgreSQL<br>
Node.js e NPM

<h2>Instalação</h2>

**Clonar o Repositório**<br>
Clone o repositório do GitHub para o seu ambiente local usando:

        git clone https://github.com/EduardoStocco/SGBE
        cd <DIRETORIO_DO_PROJETO>

**Instalar Dependências do Composer**<br>
Execute o seguinte comando para instalar as dependências do PHP:

        composer install

**Configuração do Ambiente**<br>
Copie o arquivo .env.example para .env no diretório raiz do projeto:

        cp .env.example .env

Abra o arquivo .env e configure as variáveis de ambiente para conectar ao seu banco de dados PostgreSQL:

        DB_CONNECTION=pgsql
        DB_HOST=127.0.0.1
        DB_PORT=5432
        DB_DATABASE=nome_do_seu_banco
        DB_USERNAME=usuario_do_banco
        DB_PASSWORD=senha_do_banco

**Gerar Chave do Aplicativo**<br>
Gere a chave do aplicativo Laravel com:

        php artisan key:generate
   
**Criar Banco de Dados**<br>
Crie um banco de dados no PostgreSQL que corresponda ao nome fornecido em DB_DATABASE no seu arquivo .env.

**Executar Migrações**<br>
Execute as migrações para criar as tabelas no banco de dados:

        php artisan migrate
   
**Instalar Dependências do NPM**<br>
Instale as dependências do frontend e compile os assets:

        npm install
        npm run dev

**Iniciar o Servidor de Desenvolvimento**<br>
Inicie o servidor de desenvolvimento do Laravel:

        php artisan serve
   
Acesse o sistema pelo navegador utilizando o endereço fornecido pelo comando, geralmente **http://127.0.0.1:8000**.
