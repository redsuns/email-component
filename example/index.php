<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use Redsuns\EmailComponent\BasicEmailComponent;

$config = require dirname(__DIR__) . '/email-config.php';
$content = 'Teste';

$email = new BasicEmailComponent($config);

$email->setFrom(array('name' => 'Andre', 'email' => 'email@redsuns.com.br'))
        ->setTo(array('name' => 'Andre', 'email' => 'email@redsuns.com.br'))
        ->setSubject('Teste')
        ->setContent($content)
        ->send();
