#!/bin/bash

GREEN='\033[0;32m'
RED='\033[0;31m'
NC='\033[0m'

command_exists() {
    command -v "$1" >/dev/null 2>&1
}

echo -e "${GREEN}Verificando PHP...${NC}"
if command_exists php; then
    PHP_VERSION=$(php -r "echo PHP_VERSION;")
    if [[ "$PHP_VERSION" > "8.2" ]]; then
        echo -e "${GREEN}PHP versão 8.2+ encontrado: $PHP_VERSION${NC}"
    else
        echo -e "${RED}PHP versão 8.2+ é necessária. Versão atual: $PHP_VERSION${NC}"
        exit 1
    fi
else
    echo -e "${RED}PHP não está instalado. Por favor, instale o PHP 8.2+ antes de continuar.${NC}"
    exit 1
fi

echo -e "${GREEN}Verificando Docker...${NC}"
if command_exists docker; then
    echo -e "${GREEN}Docker encontrado!${NC}"
else
    echo -e "${RED}Docker não está instalado. Por favor, instale o Docker antes de continuar.${NC}"
    exit 1
fi

echo -e "${GREEN}Verificando Docker Compose...${NC}"
if command_exists docker-compose; then
    echo -e "${GREEN}Docker Compose encontrado!${NC}"
else
    echo -e "${RED}Docker Compose não está instalado. Por favor, instale o Docker Compose antes de continuar.${NC}"
    exit 1
fi

echo -e "${GREEN}Verificando Composer...${NC}"
if command_exists composer; then
    echo -e "${GREEN}Composer encontrado!${NC}"
else
    echo -e "${RED}Composer não está instalado. Por favor, instale o Composer antes de continuar.${NC}"
    exit 1
fi

echo -e "${GREEN}Instalando as dependências do Composer...${NC}"
composer install

echo -e "${GREEN}Configurando o arquivo .env...${NC}"
if [ ! -f ".env" ]; then
    cp .env.example .env
    echo -e "${GREEN}Arquivo .env configurado!${NC}"
else
    echo -e "${GREEN}Arquivo .env já existe!${NC}"
fi

echo -e "${GREEN}Gerando a chave da aplicação...${NC}"
php artisan key:generate

echo -e "${GREEN}Subindo o Laravel Sail...${NC}"
./vendor/bin/sail up -d

echo -e "${GREEN}Rodando as migrações e seeders...${NC}"
./vendor/bin/sail artisan migrate --seed

echo -e "${GREEN}Setup completo! A API está configurada e rodando.${NC}"
