# ponderada_aws
# Relatório da Atividade: Sistema de Cadastro Web com MariaDB e PHP

## Descrição do Projeto

Este projeto consiste em um sistema web de cadastro de estudantes, integrado a um banco de dados MariaDB. Desenvolvido em PHP, o sistema permite a criação e listagem de registros de estudantes, contendo informações como nome, idade, e-mail e status de atividade.

## Tabela Criada

Foi criada a tabela `ESTUDANTES` no banco de dados com os seguintes campos:

- `ID`: Identificador único do estudante (inteiro, auto-incremento).
- `NOME`: Nome do estudante (string de até 45 caracteres).
- `IDADE`: Idade do estudante (inteiro).
- `EMAIL`: Endereço de e-mail do estudante (string de até 90 caracteres).
- `ATIVO`: Status de atividade do estudante (booleano).

## Desafios Enfrentados

Durante o desenvolvimento e deploy do sistema, alguns desafios foram encontrados:

1. **Permissões do Arquivo `.pem`**: Ao tentar acessar a instância EC2 da AWS via SSH, houve problemas relacionados às permissões do arquivo de chave privada `.pem`. A solução envolveu ajustar as permissões do arquivo para garantir que apenas o usuário correto tivesse acesso, utilizando o comando:

```bash
chmod 400 caminho/para/sua-chave.pem
```
   
2.  **Fazer o código em si**: Manjo nada de PHP, então adaptar o código default que tava no tutorial pra compreender 4 colunas com 3 tipos de dados diferentes foi meio difícil. o código pode ser encontrado [aqui](./SamplePage.php).