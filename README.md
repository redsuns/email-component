#Redsuns Email Component

Um componente para facilitar o disparo de emails em PHP.


###Como funciona
Esta biblioteca abstrai de forma clara e objetiva a utilização do PHPMailer. Setando as corretas configurações básicas para que o desenvolvedor preocupe-se apenas em "plugar" e usar.


###Requerimentos

 - PHP >5

###Instalação
Sugere-se e recomenda-se somente através do Composer: `"redsuns/email-component": "dev-master"`.

###Configurações
Se necessário alguma configuração adicional pode ser enviado um array ao instanciar a classe `Redsuns\EmailComponent\BasicEmailComponent` com as possíveis definições:

```php
<?php 
// email-config.php

return array(
    'is_smtp' => true,
    'smtp_host' => 'host',
    'smtp_port' => 587,
    'smtp_auth' => true,
    'smtp_username' => 'username',
    'smtp_password' => 'pass',
    'smtp_secure' => 'tls',
    'charset' => 'utf-8', // se não presente o default será utf-8
    'is_html' => true // se não presente o default será true
);

```

###Utilização

```php
<?php 
namespace Seu\Namespace;

use Redsuns\EmailComponent\BasicEmailComponent;

// Pode ser criado o array na própria variável
$config = require dirname(__DIR__) . '/email-config.php';
$content = 'Teste';
$from = array('name' => 'Andre', 'email' => 'email@redsuns.com.br');
$to = array('name' => 'Andre', 'email' => 'email@redsuns.com.br');

$email = new BasicEmailComponent($config);

$email->setFrom($from)
        ->setTo($to)
        ->setSubject('Teste')
        ->setContent($content)
        ->send();
```

####Enviando para mais de um destinatário

```php
<?php 
namespace Seu\Namespace;

use Redsuns\EmailComponent\BasicEmailComponent;

// Pode ser criado o array na própria variável
$config = require dirname(__DIR__) . '/email-config.php';
$content = 'Teste';
$from = array('name' => 'Andre', 'email' => 'email@redsuns.com.br');
$destinatario1 = array('name' => 'Destinatario 1', 'email' => 'email@redsuns.com.br');
$destinatario2 = array('name' => 'Destinatario 2', 'email' => 'email@redsuns.com.br');

$email = new BasicEmailComponent($config);

$email->setFrom($from)
        ->setTo($destinatario1)
        ->setTo($destinatario2)
        ->setSubject('Teste')
        ->setContent($content)
        ->send();
```

###Qual a vantagem? O PHPMailer já não faz isso?

Sim, o PHPMailer já faz isso, com a diferença que você tem de lembrar de configurar toda vez que o utiliza. Com este componente você preocupa-se de configurar apenas uma vez e utilizá-lo de forma rápida sempre que precisar. Por seguir as recomendações da [FIG](http://www.php-fig.org/) pode facilmente ser utilizado em qualquer Framework ou CMS. A ideia é que você crie um arquivo de configurações se precisar e registre o componente como um serviço, ou mesmo forneça o mesmo por injeção de dependência. Desta forma toda vez que se fizer necessário enviar e-mails o componente já estará configurado e pronto para utilizar.


###Contribuições

Basta clonar o repositório, criar um branch que descreva a melhoria/correção e dar um Pull Request.


###Report de erros
Utilize as issues do [github](https://github.com/redsuns/email-component/issues)

