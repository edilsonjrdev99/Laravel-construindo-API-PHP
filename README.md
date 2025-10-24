# API Laravel 11

Este é um projeto de API REST desenvolvido com Laravel 11 e MySQL 8, containerizado com Docker.

## Requisitos

Antes de começar, certifique-se de ter instalado em sua máquina:

- **Docker** (versão 20.10 ou superior)
- **Docker Compose** (versão 1.29 ou superior)
- **Git** (para clonar o repositório)

### Verificar instalação

```bash
docker --version
docker-compose --version
```

## Estrutura do Projeto

```
api-laravel/
├── src/                    # Código fonte do Laravel
├── data/                   # Dados do MySQL (não utilizado - volume Docker)
├── .env                    # Variáveis de ambiente do Docker
├── docker-compose.yml      # Configuração dos containers
├── Dockerfile             # Imagem customizada do PHP
└── README.md              # Este arquivo
```

## Configuração Inicial

### 1. Clone o repositório (se aplicável)

```bash
git clone url-do-gitlab
cd api-laravel
```

### 2. Verificar arquivo .env

O arquivo `.env` na raiz do projeto contém as credenciais do banco de dados:

```env
MYSQL_DATABASE=laravel
MYSQL_USER=laravel
MYSQL_PASSWORD=secret
MYSQL_ROOT_PASSWORD=rootsecret
```

### 3. Verificar arquivo src/.env

O Laravel possui seu próprio arquivo `.env` dentro da pasta `src/` com as configurações de conexão:

```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=secret
```

**Importante**: O `DB_HOST` deve ser `db` (nome do serviço no docker-compose), não `localhost` ou `127.0.0.1`.

## Como Rodar o Projeto

### 1. Iniciar os containers

```bash
docker-compose up -d
```

Este comando irá:
- Baixar as imagens do Docker (primeira vez)
- Criar e iniciar os containers
- Criar o volume do MySQL
- Expor as portas 8000 (Laravel) e 3306 (MySQL)

### 2. Aguardar inicialização do MySQL

Aguarde cerca de 20-30 segundos para o MySQL inicializar completamente. Você pode verificar o status com:

```bash
docker ps
```

O container `mysql_db` deve mostrar status `healthy`.

### 3. Executar as migrations (primeira vez)

```bash
docker exec laravel_app php artisan migrate
```

### 4. Acessar a aplicação

- **API Laravel**: http://localhost:8000
- **MySQL**: localhost:3306

## Comandos Úteis

### Gerenciar containers

```bash
# Iniciar containers
docker-compose up -d

# Parar containers
docker-compose down

# Ver status dos containers
docker ps

# Ver logs do Laravel
docker logs laravel_app

# Ver logs do MySQL
docker logs mysql_db

# Seguir logs em tempo real
docker logs -f laravel_app
```

### Executar comandos Laravel

```bash
# Artisan commands
docker exec laravel_app php artisan migrate
docker exec laravel_app php artisan db:seed
docker exec laravel_app php artisan route:list
docker exec laravel_app php artisan make:controller NomeController

# Composer
docker exec laravel_app composer install
docker exec laravel_app composer require nome/pacote

# Acessar bash do container
docker exec -it laravel_app bash
```

### Executar comandos MySQL

```bash
# Conectar ao MySQL
docker exec -it mysql_db mysql -uroot -prootsecret

# Verificar bancos de dados
docker exec mysql_db mysql -uroot -prootsecret -e "SHOW DATABASES;"

# Fazer backup do banco
docker exec mysql_db mysqldump -uroot -prootsecret laravel > backup.sql

# Restaurar backup
docker exec -i mysql_db mysql -uroot -prootsecret laravel < backup.sql
```

## Conectar com HeidiSQL ou outro cliente MySQL

Use as seguintes configurações:

**Opção 1 - Usuário root:**
- **Tipo de rede**: MySQL (TCP/IP)
- **Hostname**: 127.0.0.1
- **Porta**: 3306
- **Usuário**: root
- **Senha**: rootsecret
- **Database**: laravel

**Opção 2 - Usuário comum:**
- **Tipo de rede**: MySQL (TCP/IP)
- **Hostname**: 127.0.0.1
- **Porta**: 3306
- **Usuário**: laravel
- **Senha**: secret
- **Database**: laravel

## Solução de Problemas

### MySQL não inicia ou fica reiniciando

```bash
# Parar containers
docker-compose down

# Remover volume do MySQL (ATENÇÃO: apaga dados do banco!)
docker volume rm api-laravel_mysql_data

# Iniciar novamente
docker-compose up -d
```

### Laravel não conecta ao banco

1. Verifique se o MySQL está healthy:
   ```bash
   docker ps
   ```

2. Verifique as configurações do `src/.env`:
   - `DB_HOST` deve ser `db`
   - Credenciais devem estar corretas

3. Teste a conexão:
   ```bash
   docker exec laravel_app php artisan migrate:status
   ```

### Problemas de permissão (WSL2)

Este projeto usa volumes nomeados do Docker para evitar problemas de permissão com WSL2. Se encontrar problemas:

```bash
docker-compose down
docker volume prune -f
docker-compose up -d
```

### Limpar tudo e recomeçar

```bash
# Parar e remover containers
docker-compose down

# Remover volumes
docker volume rm api-laravel_mysql_data

# Remover dados locais (se existir)
rm -rf data/*

# Reconstruir e iniciar
docker-compose up -d --build
```

## Tecnologias Utilizadas

- **Laravel 11** - Framework PHP
- **PHP 8.2** - Linguagem de programação
- **MySQL 8** - Banco de dados
- **Docker** - Containerização
- **Composer** - Gerenciador de dependências PHP

## Portas Utilizadas

- **8000** - Laravel (API)
- **3306** - MySQL

Certifique-se de que essas portas estão disponíveis em sua máquina.

## Desenvolvimento

### Instalar novas dependências

```bash
docker exec laravel_app composer require vendor/package
```

### Criar migrations

```bash
docker exec laravel_app php artisan make:migration create_nome_table
docker exec laravel_app php artisan migrate
```

### Criar controllers

```bash
docker exec laravel_app php artisan make:controller NomeController --api
```

### Criar models

```bash
docker exec laravel_app php artisan make:model Nome -m
```

## Observações

- O código fonte do Laravel está na pasta `src/`
- Os dados do MySQL são persistidos em um volume Docker nomeado
- O container Laravel usa `php artisan serve` para desenvolvimento
- Em produção, considere usar Nginx ou Apache

## Suporte

Para problemas ou dúvidas, verifique:
- Logs dos containers: `docker logs [container_name]`
- Status dos containers: `docker ps -a`
- Documentação do Laravel: https://laravel.com/docs/11.x
