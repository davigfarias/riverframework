# River Framework

[![PHP Version](https://img.shields.io/badge/php-%3E=8.0-blue.svg)](https://php.net)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

Um micro-framework PHP leve e moderno, projetado para ser um ponto de partida sólido para o desenvolvimento de aplicações web robustas e escaláveis. O River Framework foi criado como um projeto de portfólio para demonstrar a aplicação de boas práticas de desenvolvimento, arquitetura de software e o uso de componentes consagrados no ecossistema PHP.

## 🎯 Objetivos do Projeto

O principal objetivo do River Framework é fornecer uma estrutura base que resolva problemas comuns do desenvolvimento web, permitindo que o desenvolvedor foque na lógica de negócio da aplicação. O projeto foi desenhado para:

* **Simplificar a configuração de ambientes** com o uso de variáveis de ambiente.
* **Oferecer um sistema de rotas flexível** e de fácil manutenção.
* **Implementar Injeção de Dependência** para promover um código desacoplado e testável.
* **Estruturar o projeto de forma organizada**, seguindo a recomendação PSR-4 para autoload.
* **Servir como uma peça de portfólio robusta**, evidenciando competências em arquitetura de software e desenvolvimento PHP moderno.

## ✨ Funcionalidades Principais

O River Framework vem com um conjunto de funcionalidades essenciais para o desenvolvimento de qualquer aplicação web:

* **Roteamento:** Utiliza o componente `coffeecode/router` para criar rotas amigáveis e gerenciar requisições HTTP de forma eficiente, direcionando-as para os controllers apropriados.
* **Injeção de Dependência (DI):** Integrado com `php-di/php-di`, o framework gerencia automaticamente as dependências entre as classes, facilitando a manutenção e a extensibilidade do código.
* **Gerenciamento de Ambiente:** Com o `vlucas/phpdotenv`, a configuração do ambiente (desenvolvimento, produção, etc.) é feita de forma segura e isolada, sem expor dados sensíveis no código.
* **Template Engine:** Renderiza views com o `twig/twig`, um dos mais poderosos e seguros motores de template para PHP, permitindo a separação clara entre a lógica e a apresentação.
* **Abstração de Banco de Dados:** Integrado com `doctrine/dbal`, oferece uma camada de abstração de banco de dados (DBAL) que permite interagir com diferentes SGBDs de forma consistente.

## 🏛️ Arquitetura

O projeto segue uma arquitetura MVC (Model-View-Controller), que promove a separação de responsabilidades e organiza o código de forma clara e sustentável.

## 💻 Tecnologias e Boas Práticas

Este projeto foi construído utilizando tecnologias modernas e seguindo as melhores práticas do mercado:

* **Linguagem:** PHP 8+
* **Gerenciador de Dependências:** Composer
* **Padrões:** PSR-4 (Autoload)
* **Componentes Principais:**
    * **Roteamento:** `coffeecode/router`
    * **Injeção de Dependência:** `php-di/php-di`
    * **Templates:** `twig/twig`
    * **Variáveis de Ambiente:** `vlucas/phpdotenv`
    * **Banco de Dados (DBAL):** `doctrine/dbal`
    * **Geração de Dados Falsos:** `fakerphp/faker`

## 🚀 Instalação e Execução

Para executar o River Framework em seu ambiente local, siga os passos abaixo:

1.  **Clonar o Repositório:**
    Primeiro, você precisa clonar o repositório do projeto para a sua máquina local usando o comando `git clone` seguido da URL do repositório. Depois, navegue para o diretório do projeto.

2.  **Instalar as Dependências:**
    Certifique-se de ter o Composer instalado. No diretório do projeto, execute o comando `composer install` para baixar e instalar todas as dependências necessárias.

3.  **Configurar o Ambiente:**
    Crie um arquivo chamado `.env` na raiz do projeto. Você pode copiar um arquivo de exemplo se houver. Neste arquivo, defina as variáveis de ambiente, como a `APPLICATION_URL`, que deve conter a URL base da sua aplicação local.

4.  **Configurar o Servidor Local:**
    Configure seu servidor web, como Apache ou Nginx, para que a raiz do documento aponte para o diretório público do projeto, onde o arquivo `index.php` está localizado. É importante garantir que as reescritas de URL (`mod_rewrite` ou equivalente) estejam ativadas para que as rotas funcionem corretamente.

## 🛠️ Exemplos de Uso

A utilização do framework é simples e direta. Para definir uma rota, você pode editar o arquivo `index.php`, especificando o caminho da URL, o método HTTP (como GET ou POST) e o controller responsável por responder àquela requisição. Dentro de um controller, você pode processar a lógica necessária e usar o motor de templates Twig para renderizar uma view e enviá-la como resposta ao navegador.

## 🔮 Melhorias Futuras

Este projeto está em constante evolução. Alguns dos próximos passos planejados são:

* [ ] Implementar uma camada de **Modelo** completa, com ORM para facilitar a interação com o banco de dados.
* [ ] Desenvolver um sistema de **autenticação e autorização** de usuários.
* [ ] Criar um **sistema de logging** para registrar eventos e erros da aplicação.
* [ ] Adicionar um sistema de **cadastro de usuários** e histórico de registros.
* [ ] Construir mais **componentes reutilizáveis** para funcionalidades comuns (ex: upload de arquivos, envio de e-mails).
