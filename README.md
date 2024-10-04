# Desafios PHP - Vaga Júnior

Optei por realizar os desafios utilizando um mini projeto, aplicando o princípio da separação de responsabilidades:

- **Models**: Responsáveis pela definição dos dados.
- **Controllers**: Gerenciam as requisições e respostas.
- **Services**: Contêm as regras de negócio.
- **Repositories**: Abstraem o acesso ao banco de dados.
- **Validate**: Utilizado para sanitização dos dados, prevenção de erros e proteção contra ataques de injeção de SQL.

## Ferramentas e Bibliotecas

- **Composer**: Utilizado para gerenciar as dependências e bibliotecas, além de facilitar o autoload das classes.
- **.env**: Arquivo criado para armazenar as credenciais do banco de dados de forma segura.
- **Tabnine**: Ferramenta que auxiliou na documentação do projeto.
- **Pint**: Utilizado para formatação do código.

## Scripts

Incluí neste repositório os scripts para:
1. Criação do banco `giusoft`
2. Criação da tabela `products`.
3. Inserção dos dados.

## Rotas

- Para iniciar o servidor, execute o comando:
  ```bash
  php -S localhost:8000 -t public

### Exemplos das rotas API
```bash
- Listar produtos: GET http://localhost:8000/api/v1/products
- Buscar produto pelo nome: GET http://localhost:8000/api/v1/products/search?name=Teclado
- Paginação de produtos: GET http://127.0.0.1:8000/api/v1/products/paginate?lastProductId=11&limit=10
```
## Desafios

- Os desafios 1 e 3 estão separados em arquivos diferentes.

## Versão PHP

Este projeto foi desenvolvido utilizando a versão **8.2** do PHP.

