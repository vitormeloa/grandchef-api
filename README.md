# GrandChef API

## Sumário

- [Descrição](#descrição)
- [Escopo](#escopo)
- [Requisitos](#requisitos)
- [Guia de Instalação](#guia-de-instalação)
- [Documentação dos Endpoints](#documentação-dos-endpoints)
    - [Autenticação](#autenticação)
    - [Categorias](#categorias)
        - [Listar todas as categorias](#listar-todas-as-categorias)
        - [Buscar por uma categoria](#buscar-por-uma-categoria)
        - [Criar uma categoria](#criar-uma-categoria)
        - [Atualizar uma categoria](#atualizar-uma-categoria)
        - [Excluir uma categoria](#excluir-uma-categoria)
    - [Produtos](#produtos)
        - [Listar todos os produtos](#listar-todos-os-produtos)
        - [Buscar por um produto](#buscar-por-um-produto)
        - [Criar um produto](#criar-um-produto)
        - [Atualizar um produto](#atualizar-um-produto)
        - [Excluir um produto](#excluir-um-produto)
    - [Pedidos](#pedidos)
        - [Listar todos os pedidos](#listar-todos-os-pedidos)
        - [Buscar por um pedido](#buscar-por-um-pedido)
        - [Criar um pedido](#criar-um-pedido)
        - [Atualizar um pedido](#atualizar-um-pedido)
        - [Excluir um pedido](#excluir-um-pedido)
- [Testes](#testes)

---

## Descrição

A **GrandChef API** é uma API desenvolvida em Laravel para gerenciar categorias, produtos e pedidos em um sistema de delivery de alimentos. A API oferece funcionalidades para manipulação de **Categorias**, **Produtos** e **Pedidos**, permitindo operações como criação, leitura, atualização e exclusão (CRUD) de cada entidade.

---

## Escopo

O projeto visa atender a uma aplicação de gerenciamento de um sistema de delivery de alimentos, onde:
- **Categorias** são utilizadas para organizar os produtos.
- **Produtos** são cadastrados e vinculados às categorias.
- **Pedidos** permitem que os clientes solicitem produtos, calculando automaticamente o preço total do pedido.

As principais funcionalidades incluem:
- Listar, criar, atualizar e excluir **Categorias** e **Produtos**.
- Criar e gerenciar **Pedidos**, com cálculo automático do preço total baseado na quantidade de produtos.
- API otimizada para performance, com verificações para validação de dados das requisições.

---

## Requisitos

- PHP 8.2+
- Composer 2.1+
- Docker e Docker Compose (utilizado para o ambiente de desenvolvimento com Laravel Sail)
---

## Guia de Instalação

### Configuração Automática

 1. Clonar o Repositório:

```bash
git clone https://github.com/vitormeloa/grandchef-api.git
cd grandchef-api
```

2. Garantir permissões para a execução do script:
```bash
chmod +x setup.sh
```

3. Rodar o script de setup:

```bash
./setup.sh
```

### Configuração Manual

 1. Clonar o Repositório

```bash
git clone https://github.com/vitormeloa/grandchef-api.git
cd grandchef-api
```

 2. Instalar as Dependências

```bash
composer install
```

 3. Copiar o arquivo `.env.example` para `.env`

```bash
cp .env.example .env
```

 4. Gerar a chave da aplicação

```bash
php artisan key:generate
```

 5. Instalar o Laravel Sail

```bash
php artisan sail:install
```

 6. Iniciar o ambiente Docker

```bash
./vendor/bin/sail up -d
```

 7. Rodar as migrações e seeders

```bash
./vendor/bin/sail artisan migrate:fresh --seed
```

## Documentação dos Endpoints

### Autenticação

> **Nota**: Esta API é pública e, atualmente, não possui autenticação implementada. Todos os endpoints podem ser acessados sem necessidade de autenticação.

---

### Categorias

#### **Listar todas as categorias**
- **Endpoint**: `GET /api/categories`
- **Descrição**: Retorna todas as categorias cadastradas.
- **Exemplo de Resposta**:
  ```json
  {
    "status": "success",
    "message": "Categorias listadas com sucesso",
    "data": [
        {
            "id": 1,
            "name": "Bebidas",
            "created_at": "2024-09-18T17:10:40.000000Z",
            "updated_at": "2024-09-18T17:11:21.000000Z"
        },
        {
            "id": 2,
            "name": "Churrasco",
            "created_at": "2024-09-18T19:20:19.000000Z",
            "updated_at": "2024-09-18T19:20:19.000000Z"
        }
    ]
  }
  ```
  
#### **Buscar por uma categoria**
- **Endpoint**: `GET /api/categories/{id}`
- **Descrição**: Retorna uma categoria específica.
  - **Exemplo de Resposta**:
      ```json
      {
          "status": "success",
          "message": "Categoria encontrada com sucesso",
          "data": {
              "id": 2,
              "name": "Churrasco",
              "created_at": "2024-09-18T19:20:19.000000Z",
              "updated_at": "2024-09-18T19:20:19.000000Z"
          }
      }
      ```
  
#### **Criar uma categoria**
- **Endpoint**: `POST /api/categories`
- **Descrição**: Cria uma nova categoria.
- **Parâmetros**:
  - `name` (string): Nome da categoria.
  - **Exemplo de Requisição**:
    ```json
    {
      "name": "Bebidas"
    }
    ```
    - **Exemplo de Resposta**:
        ```json
        {
            "status": "success",
            "message": "Categoria criada com sucesso",
            "data": {
                "id": 1,
                "name": "Bebidas",
                "created_at": "2024-09-18T19:00:00.000000Z",
                "updated_at": "2024-09-18T19:00:00.000000Z"
            }
        }
        ```

#### **Atualizar uma categoria**
- **Endpoint**: `PUT /api/categories/{id}`
- **Descrição**: Atualiza uma categoria existente.
- **Parâmetros**:
  - `name` (string): Nome da categoria.
  - **Exemplo de Requisição**:
    ```json
    {
      "name": "Bebidas"
    }
    ```
    - **Exemplo de Resposta**:
        ```json
        {
            "status": "success",
            "message": "Categoria atualizada com sucesso",
            "data": {
                "id": 1,
                "name": "Bebidas",
                "created_at": "2024-09-18T19:00:00.000000Z",
                "updated_at": "2024-09-18T19:00:00.000000Z"
            }
        }
        ```

#### **Excluir uma categoria**
- **Endpoint**: `DELETE /api/categories/{id}`
- **Descrição**: Exclui uma categoria existente.
- **Exemplo de Resposta**:
  > 204 No Content
---

### Produtos

#### **Listar todos os produtos**
- **Endpoint**: `GET /api/products`
- **Descrição**: Retorna todos os produtos cadastrados.
  - **Exemplo de Resposta**:
    ```json
    {
      "status": "success",
      "message": "Produtos listados com sucesso", 
      "data": {
          "current_page": 1,
          "data": [
              {
                  "id": 2,
                  "category_id": 1,
                  "name": "Água",
                  "price": "3.50",
                  "created_at": "2024-09-18T17:14:07.000000Z",
                  "updated_at": "2024-09-18T17:14:07.000000Z",
                  "category": {
                      "id": 1,
                      "name": "Bebidas",
                      "created_at": "2024-09-18T17:10:40.000000Z",
                      "updated_at": "2024-09-18T17:11:21.000000Z"
                  }
              }
          ],
          "first_page_url": "http://localhost/api/products?page=1",
          "from": 1,
          "last_page": 1,
          "last_page_url": "http://localhost/api/products?page=1",
          "links": [
              {
                  "url": null,
                  "label": "&laquo; Previous",
                  "active": false
              },
              {
                  "url": "http://localhost/api/products?page=1",
                  "label": "1",
                  "active": true
              },
              {
                  "url": null,
                  "label": "Next &raquo;",
                  "active": false
              }
          ],
          "next_page_url": null,
          "path": "http://localhost/api/products",
          "per_page": 10,
          "prev_page_url": null,
          "to": 1,
          "total": 1
      } 
    }
    ```

#### **Buscar por um produto**
- **Endpoint**: `GET /api/products/{id}`
- **Descrição**: Retorna um produto específico.
  - **Exemplo de Resposta**:
      ```json
      {
          "status": "success",
          "message": "Produto encontrado com sucesso",
          "data": {
              "id": 1,
              "name": "Coca-Cola",
              "category_id": 1,
              "price": 5.00,
              "created_at": "2024-09-18T19:00:00.000000Z",
              "updated_at": "2024-09-18T19:00:00.000000Z"
          }
      }
      ```

#### **Criar um produto**
- **Endpoint**: `POST /api/products`
- **Descrição**: Cria um novo produto.
- **Parâmetros**:
  - `name` (string): Nome do produto.
  - `category_id` (int): ID da categoria do produto.
  - `price` (float): Preço do produto.
  - **Exemplo de Requisição**:
    ```json
    {
      "name": "Coca-Cola",
      "category_id": 1,
      "price": 5.00
    }
    ```
    - **Exemplo de Resposta**:
        ```json
        {
            "status": "success",
            "message": "Produto criado com sucesso",
            "data": {
                "id": 1,
                "name": "Coca-Cola",
                "category_id": 1,
                "price": 5,
                "created_at": "2024-09-18T19:00:00.000000Z",
                "updated_at": "2024-09-18T19:00:00.000000Z"
            }
        }
        ```

#### **Atualizar um produto**
- **Endpoint**: `PUT /api/products/{id}`
- **Descrição**: Atualiza um produto existente.
- **Parâmetros**:
  - `name` (string): Nome do produto.
  - `category_id` (int): ID da categoria do produto.
  - `price` (float): Preço do produto.
  - **Exemplo de Requisição**:
    ```json
    {
      "name": "Coca-Cola",
      "category_id": 1,
      "price": 5.50
    }
    ```
    - **Exemplo de Resposta**:
        ```json
        {
            "status": "success",
            "message": "Produto atualizado com sucesso",
            "data": {
                "id": 1,
                "name": "Coca-Cola",
                "category_id": 1,
                "price": 5.5,
                "created_at": "2024-09-18T19:00:00.000000Z",
                "updated_at": "2024-09-18T19:00:00.000000Z"
            }
        }
        ```

#### **Excluir um produto**
- **Endpoint**: `DELETE /api/products/{id}`
- **Descrição**: Exclui um produto existente.
- **Exemplo de Resposta**:
  > 204 No Content
---

### Pedidos

#### **Listar todos os pedidos**
- **Endpoint**: `GET /api/orders`
- **Descrição**: Retorna todos os pedidos cadastrados.
  - **Exemplo de Resposta**:
    ```json
    {
      "status": "success",
      "message": "Pedidos listados com sucesso",
      "data": {
          "current_page": 1,
          "data": [
                {
                  "id": 1,
                  "total": 10.00,
                  "created_at": "2024-09-18T19:00:00.000000Z",
                  "updated_at": "2024-09-18T19:00:00.000000Z"
                }
              ],
              "first_page_url": "http://localhost/api/orders?page=1",
              "from": 1,
              "last_page": 1,
              "last_page_url": "http://localhost/api/orders?page=1",
              "links": [
                {
                  "url": null,
                  "label": "&laquo; Previous",
                  "active": false
                },
                {
                  "url": "http://localhost/api/orders?page=1",
                  "label": "1",
                  "active": true
                },
                {
                  "url": null,
                  "label": "Next &raquo;",
                  "active": false
                }
              ],
              "next_page_url": null,
              "path": "http://localhost/api/orders",
              "per_page": 10,
              "prev_page_url": null,
              "to": 1,
              "total": 1
          }
    }
    ```
  
#### **Buscar por um pedido**
- **Endpoint**: `GET /api/orders/{id}`
- **Descrição**: Retorna um pedido específico.
  - **Exemplo de Resposta**:
      ```json
      {
          "status": "success",
          "message": "Pedido encontrado com sucesso",
          "data": {
              "id": 1,
              "status": "open",
              "total_price": 10.00,
              "created_at": "2024-09-18T19:00:00.000000Z",
              "updated_at": "2024-09-18T19:00:00.000000Z",
              "products": [
                  {
                      "id": 2,
                      "category_id": 1,
                      "name": "Água",
                      "price": "3.50",
                      "created_at": "2024-09-18T17:14:07.000000Z",
                      "updated_at": "2024-09-18T17:14:07.000000Z",
                      "pivot": {
                          "order_id": 2,
                          "product_id": 2,
                          "price": "3.50",
                          "quantity": 2,
                          "created_at": "2024-09-18T17:54:16.000000Z",
                          "updated_at": "2024-09-18T17:54:16.000000Z"
                      }
                  }
              ]
          }
      }
      ```

#### **Criar um pedido**
- **Endpoint**: `POST /api/orders`
- **Descrição**: Cria um novo pedido.
- **Parâmetros**:
  - `products` (array): Array de objetos contendo o ID do produto e a quantidade.
  - **Exemplo de Requisição**:
    ```json
    {
      "products": [
        {
          "product_id": 1,
          "quantity": 2
        }
      ]
    }
    ```
    - **Exemplo de Resposta**:
        ```json
        {
            "status": "success",
            "message": "Pedido criado com sucesso",
            "data": {
                "id": 1,
                "total_price": 11,
                "products": [
                    {
                        "id": 3,
                        "category_id": 1,
                        "name": "Coca-Cola",
                        "price": "5.50",
                        "created_at": "2024-09-19T03:16:20.000000Z",
                        "updated_at": "2024-09-19T03:17:30.000000Z",
                        "pivot": {
                            "order_id": 3,
                            "product_id": 3,
                            "price": "5.50",
                            "quantity": 2,
                            "created_at": "2024-09-19T03:26:01.000000Z",
                            "updated_at": "2024-09-19T03:26:01.000000Z"
                        }
                    }
                ],
                "created_at": "2024-09-18T19:00:00.000000Z",
                "updated_at": "2024-09-18T19:00:00.000000Z"
            }
        }
        ```
  
#### **Atualizar um pedido**
- **Endpoint**: `PUT /api/orders/{id}`
- **Descrição**: Atualiza um pedido existente.
- **Parâmetros**:
  - `products` (array): Array de objetos contendo o ID do produto e a quantidade.
  - **Exemplo de Requisição**:
    ```json
    {
      "products": [
        {
          "product_id": 1,
          "quantity": 2
        }
      ]
    }
    ```
    - **Exemplo de Resposta**:
        ```json
        {
            "status": "success",
            "message": "Pedido atualizado com sucesso",
            "data": {
                "id": 1,
                "status": "approved",
                "total_price": 11,
                "created_at": "2024-09-18T19:00:00.000000Z",
                "updated_at": "2024-09-18T19:00:00.000000Z",
                "pivot": {
                  "order_id": 3,
                  "product_id": 3,
                  "price": "5.50",
                  "quantity": 5,
                  "created_at": "2024-09-19T03:29:20.000000Z",
                  "updated_at": "2024-09-19T03:29:20.000000Z"
                }
            }
        }
        ```
  
#### **Excluir um pedido**
- **Endpoint**: `DELETE /api/orders/{id}`
- **Descrição**: Exclui um pedido existente.
- **Exemplo de Resposta**:
  > 204 No Content
---

## Testes

A API foi testada com o framework [Pest](https://pestphp.com/), garantindo cobertura para as principais funcionalidades.

Para rodar os testes, execute o comando:

```bash
./vendor/bin/sail pest
```
