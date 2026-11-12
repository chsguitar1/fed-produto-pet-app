# Factories e seeders do banco de dados

Este documento descreve os dados de exemplo do catálogo de produtos para pets, como
gerá-los e como as factories mantêm válidas as relações entre as tabelas.

## Entidades cobertas

As factories e os seeders da aplicação cobrem as tabelas com dados de domínio:

| Tabela | Model | Factory | Seeder | Dados gerados pelo seeder |
| --- | --- | --- | --- | --- |
| `users` | `User` | `UserFactory` (já existente) | `UserSeeder` | 20 usuários fictícios |
| `marcas` | `Marca` | `MarcaFactory` | `MarcaSeeder` | 6 marcas e fabricantes de pet shop |
| `categorias` | `Categoria` | `CategoriaFactory` | `CategoriaSeeder` | 5 categorias de produtos com controle de estoque |
| `lotes` | `Lote` | `LoteFactory` | `LoteSeeder` | 12 números de lote |
| `produtos` | `Produto` | `ProdutoFactory` | `ProdutoSeeder` | 14 produtos ligados à marca e categoria correspondentes |

`DatabaseSeeder` é o ponto de entrada e chama os seeders na ordem necessária: usuários,
marcas, categorias, lotes e, por fim, produtos. Os produtos usam modelos já criados para
referenciar marca, categoria e lote. Assim, os registros gerados respeitam as chaves
estrangeiras definidas nas migrations.

## Catálogo e relações

Os nomes dos produtos, suas categorias, marcas e preços ficam juntos em
`ProdutoFactory::CATALOG`. Tanto a factory quanto `ProdutoSeeder` usam essa lista: a
factory escolhe um item completo aleatoriamente, enquanto o seeder cadastra os 14 itens
do catálogo e associa cada produto à marca e à categoria indicadas nele.

Exemplos dessa correspondência:

| Produto | Categoria | Marca |
| --- | --- | --- |
| Ração seca para cães adultos sabor frango e arroz 10 kg | Rações | NutriPet |
| Areia higiênica para gatos 4 kg | Higiene | PetBrilho |
| Bola de borracha resistente para cães | Brinquedos | BrincaPet |
| Guia de nylon para cães 1,5 m | Acessórios | PataForte |

As marcas e categorias disponíveis nas factories são listas controladas, não palavras
aleatórias do Faker. A factory de produto varia a quantidade em estoque entre 1 e 60,
mantendo o preço de custo e o de venda do item escolhido. O seeder usa as quantidades e os
preços definidos no catálogo para cada um dos 14 produtos.

## O que cada factory preenche

- `UserFactory` gera nome, e-mail, senha com hash, token de lembrança e e-mail verificado.
  O estado `unverified()` cria um usuário sem verificação de e-mail.
- `MarcaFactory` escolhe entre marcas e fabricantes fictícios com nomes próprios de pet shop.
- `CategoriaFactory` escolhe entre Rações, Petiscos, Higiene, Brinquedos e Acessórios;
  essas categorias são cadastradas com controle de estoque habilitado.
- `LoteFactory` gera identificadores no formato `LOTE-2026-0001`. O seeder cria a sequência
  `LOTE-2026-0001` a `LOTE-2026-0012` e distribui os lotes entre os produtos.
- `ProdutoFactory` escolhe itens de um catálogo fixo com nomes legíveis, preços plausíveis,
  quantidade positiva e relações coerentes com a marca e categoria do produto. Por exemplo,
  uma ração é associada à categoria Rações, não a Brinquedos. O preço de venda é maior que
  o preço de custo. Como `lote_id` é opcional no schema, o estado `withoutLote()` permite
  criar produto sem lote.

O catálogo usado como base inclui rações, petiscos, itens de higiene, brinquedos e acessórios
para cães e gatos. Os nomes de marcas são fictícios e servem apenas para desenvolvimento e
testes.

Os models `Marca`, `Categoria`, `Lote` e `Produto` declaram os atributos preenchíveis e as
relações Eloquent correspondentes. `Produto` pertence a uma marca, categoria e lote; o lote
pode estar ausente. As demais entidades expõem a relação de produtos. Os nomes das tabelas
foram declarados explicitamente para corresponder ao schema em português.


## Como executar

Para criar as tabelas pendentes e inserir os dados de exemplo:

```bash
php artisan migrate --seed
```

Para recriar o banco local do zero e executar todos os seeders:

```bash
php artisan migrate:fresh --seed
```

`migrate:fresh` apaga todas as tabelas e os dados existentes antes de migrar novamente.
Use-o apenas em ambiente local ou de testes. Os seeders apresentados são dados de
desenvolvimento e não devem ser executados em produção. `db:seed` acrescenta os novos
registros sem apagar dados aleatórios inseridos por versões anteriores. Para limpar esses
registros e reiniciar os dados de exemplo, use `migrate:fresh --seed` somente em um banco
local descartável; esse comando apaga todas as tabelas e os dados existentes.

Também é possível usar as factories diretamente no código ou em testes:

```php
Produto::factory()->create();
Produto::factory()->withoutLote()->create();
User::factory()->unverified()->create();
```

Os usuários gerados pela factory padrão têm a senha `password` (armazenada com hash);
essa credencial é exclusivamente para desenvolvimento e testes.
