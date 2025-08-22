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

A estrutura do River Framework foi pensada para ser intuitiva e escalável, seguindo um padrão similar ao **Model-View-Controller (MVC)** e utilizando um **Front Controller** (`index.php`) como ponto de entrada único para todas as requisições.
