<div align="center">

<h1>🏠 Louer</h1>
<p><strong>Marketplace de aluguel de equipamentos e espaços</strong></p>

<p>
  <img src="https://img.shields.io/badge/status-concluído-brightgreen" alt="Status" />
  <img src="https://img.shields.io/badge/TCC-Técnico%20em%20Informática-blue" alt="TCC" />
</p>

<p>
  <a href="#sobre">Sobre</a> •
  <a href="#funcionalidades">Funcionalidades</a> •
  <a href="#fluxo-do-sistema">Fluxo</a> •
  <a href="#banco-de-dados">Banco de Dados</a> •
  <a href="#tecnologias">Tecnologias</a> •
  <a href="#equipe">Equipe</a>
</p>

</div>

---

## Sobre

O **Louer** é um marketplace web que conecta clientes e fornecedores para o aluguel de equipamentos e espaços. O projeto nasceu da necessidade de centralizar e simplificar um processo hoje feito de forma dispersa — como o agendamento manual de quadras públicas em Colatina (ES).

Desenvolvido como **Trabalho de Conclusão de Curso** do Técnico em Informática para a Internet integrado ao Ensino Médio, no **TECgirls / IFES Colatina**, 2025.

### Objetivo

Funcionar como um intermediário digital entre quem tem algo para alugar e quem precisa alugar — seja um vestido, um teclado musical ou uma quadra poliesportiva.

---

## Funcionalidades

### 👤 Cliente
- Cadastro, login, edição e exclusão de conta
- Busca e visualização de produtos
- Solicitação de reservas com seleção de período
- Acompanhamento de status da reserva em tempo real
- Realização de pagamento (PIX, cartão de crédito e débito)
- Emissão de comprovante de pagamento e de reserva
- Histórico completo de aluguéis
- Lista de produtos favoritos

### 🏪 Fornecedor
- Cadastro como fornecedor (requer 18+ anos)
- Cadastro de espaços e equipamentos com disponibilidade
- Aceitação ou recusa de solicitações de reserva
- Cancelamento de reservas
- Edição e exclusão de produtos

---

## Fluxo do Sistema

### Jornada de Reserva

```mermaid
flowchart TD
    A([Cliente acessa o produto]) --> B[Seleciona período disponível]
    B --> C[Confirma solicitação]
    C --> D[(Reserva criada\nStatus: Solicitada)]
    D --> E{Fornecedor avalia}
    E -->|Recusa| F[(Status: Recusada)]
    E -->|Aceita| G[(Status: Aprovada)]
    G --> H{Cliente decide}
    H -->|Cancela| I[(Status: Cancelada\nEstorno automático)]
    H -->|Paga| J[Escolhe forma de pagamento]
    J --> K[Efetua pagamento]
    K --> L[(Status: Confirmada)]
    L --> M[Emite comprovantes]
    M --> N[(Status: Finalizada\napós término)]

    style D fill:#f0c040,color:#000
    style F fill:#e05050,color:#fff
    style G fill:#4a90d9,color:#fff
    style I fill:#e05050,color:#fff
    style L fill:#4caf50,color:#fff
    style N fill:#888,color:#fff
```

### Cadastro de Fornecedor

```mermaid
flowchart LR
    A([Usuário logado]) --> B[Clica em\nQuero ser Fornecedor]
    B --> C{Tem 18 anos?}
    C -->|Não| D([Cadastro bloqueado])
    C -->|Sim| E[Informa dados pessoais\nNome, CPF/CNPJ, Telefone, Email]
    E --> F[Informa endereço\nCEP, Rua, Bairro, Número]
    F --> G([Conta de Fornecedor ativada])
```

---

## Diagrama de Classes

```mermaid
classDiagram
    class usuario {
        +INT id PK
        +VARCHAR(100) nome
        +LONGBLOB imagem
        +ENUM tipo
        +VARCHAR(14) cpf
        +VARCHAR(14) cnpj
        +VARCHAR(100) cidade
        +VARCHAR(20) telefone
        +VARCHAR(100) email
        +VARCHAR(255) senha
        +VARCHAR(9) cep
        +VARCHAR(100) bairro
        +VARCHAR(100) rua
        +VARCHAR(10) numero
        +VARCHAR(100) complemento
        +TINYINT conta_ativa
    }

    class produto {
        +INT id PK
        +INT id_usuario FK
        +VARCHAR(100) nome
        +TEXT descricao
        +ENUM tipo
        +DECIMAL(10,2) valor_dia
        +SET dias_disponiveis
        +TEXT politica_cancelamento
        +VARCHAR(100) cidade
        +VARCHAR(9) cep
        +VARCHAR(100) bairro
        +VARCHAR(100) rua
        +INT numero
        +VARCHAR(100) complemento
        +TINYINT ativo
    }

    class disponibilidades {
        +INT id PK
        +INT id_produto FK
        +DATE data_disponivel
    }

    class reserva {
        +INT id PK
        +INT id_usuario FK
        +INT id_produto FK
        +DATE data_reserva
        +DATE data_final
        +DATETIME data_solicitado
        +DECIMAL(10,2) valor_reserva
        +ENUM status
        +ENUM cancelado_por
        +TEXT motivo_cancelamento
        +DATE data_aceito_negado
    }

    class pagamento {
        +INT id PK
        +INT reserva_id FK
        +INT forma_pagamento_id FK
        +VARCHAR(100) nome_pagador
        +VARCHAR(14) cpf_pagador
        +DECIMAL(10,2) valor_pago
        +DECIMAL(10,2) valor_estornado
        +ENUM status_pagamento
        +DATETIME data_pagamento
        +DATETIME data_estorno
    }

    class formapagamento {
        +INT id PK
        +VARCHAR(50) forma
    }

    class imagem {
        +INT id PK
        +LONGBLOB dados
        +VARCHAR(50) tipo
        +INT produto_id FK
    }

    class tags {
        +INT id PK
        +VARCHAR(45) nome
    }

    class tags_has_produto {
        +INT tags_id FK
        +INT produto_id FK
    }

    class favoritos {
        +INT id_usuario FK
        +INT id_produto FK
    }

    usuario "1" --> "0..*" produto : id_usuario
    usuario "1" --> "0..*" reserva : id_usuario
    produto "1" --> "0..*" disponibilidades : id_produto
    produto "1" --> "0..*" reserva : id_produto
    produto "1" --> "0..*" imagem : produto_id
    produto "1" --> "0..*" tags_has_produto : produto_id
    tags "1" --> "0..*" tags_has_produto : tags_id
    reserva "1" --> "0..1" pagamento : reserva_id
    pagamento "0..*" --> "1" formapagamento : forma_pagamento_id
    usuario "1" --> "0..*" favoritos : id_usuario
    produto "1" --> "0..*" favoritos : id_produto
```

---

## Banco de Dados

O banco utilizado é **MySQL**, com o schema `louerbd`. Abaixo estão todas as tabelas com suas colunas principais:

| Tabela | Colunas principais | Descrição |
|---|---|---|
| `usuario` | `id`, `nome`, `tipo` (Cliente/Fornecedor/Gerente), `cpf`, `cnpj`, `email`, `senha`, `cidade`, `cep`, `conta_ativa` | Todos os usuários do sistema |
| `produto` | `id`, `id_usuario`, `nome`, `descricao`, `tipo` (Espaco/Equipamento), `valor_dia`, `dias_disponiveis`, `politica_cancelamento`, `ativo` | Espaços e equipamentos anunciados |
| `disponibilidades` | `id`, `id_produto`, `data_disponivel` | Datas disponíveis para cada produto |
| `reserva` | `id`, `id_usuario`, `id_produto`, `data_reserva`, `data_final`, `valor_reserva`, `status`, `cancelado_por`, `motivo_cancelamento`, `data_aceito_negado` | Solicitações e reservas realizadas |
| `pagamento` | `id`, `reserva_id`, `forma_pagamento_id`, `nome_pagador`, `cpf_pagador`, `valor_pago`, `valor_estornado`, `status_pagamento`, `data_pagamento`, `data_estorno` | Registros de pagamentos e estornos |
| `formapagamento` | `id`, `forma` | PIX, Cartão de Crédito, Cartão de Débito |
| `imagem` | `id`, `dados`, `tipo`, `produto_id` | Imagens vinculadas aos produtos |
| `tags` | `id`, `nome` | Categorias: Quadra, Musical, Esporte, Roupa, etc. |
| `tags_has_produto` | `tags_id`, `produto_id` | Relação N:N entre tags e produtos |
| `favoritos` | `id_usuario`, `id_produto` | Produtos favoritados por usuários |

Os scripts completos de criação e população estão em [`banco-de-dados/`](./banco-de-dados/).

---

## Regras de Negócio

- Acesso ao sistema somente via **login e senha**
- Apenas fornecedores podem cadastrar produtos
- Reservas recusadas ou canceladas **não são excluídas**, apenas marcadas com o status correspondente
- O **estorno é automático** caso o fornecedor cancele uma reserva confirmada
- O valor só é repassado ao fornecedor **após o término do aluguel**
- Apenas **datas livres** ficam disponíveis para seleção durante a solicitação
- Para se tornar fornecedor é necessário ter **18 anos ou mais**

---

## Status das Reservas

```
Solicitada → Aprovada → Confirmada → Finalizada
     │            │
     ↓            ↓
  Recusada     Cancelada
```

---

## Tecnologias

> As tecnologias utilizadas no desenvolvimento podem ser verificadas no repositório de código.

- **Frontend:** Web (acessível via navegador)
- **Banco de Dados:** MySQL
- **Infraestrutura:** Terraform — [repositório louertf](https://github.com/kikiscar/louertf)

---

## Repositórios

| Repositório | Link |
|---|---|
| 💻 Código-fonte | [github.com/holzdm/louer](https://github.com/holzdm/louer) |
| ☁️ Infraestrutura (Terraform) | [github.com/kikiscar/louertf](https://github.com/kikiscar/louertf) |

---

## Equipe

Desenvolvido com 💙 pela equipe **TECgirls** — Turma do Técnico em Informática para a Internet, IFES Colatina, 2025.

| Nome | GitHub |
|---|---|
| Carolina Faria Cassaro | — |
| Kiara Piontkovsky Scardini | [@kikiscar](https://github.com/kikiscar) |
| Vítor Holz De Martin | [@holzdm](https://github.com/holzdm) |

---

<div align="center">
  <sub>© 2025 Louer — Alugue espaços e itens de forma simples.</sub>
</div>
