<?php
//Caminho alterado
require __DIR__ .'/../vendor/autoload.php';

use \App\Utils\View;
use \SandroAmancio\DotEnv\Environment;
use \SandroAmancio\DatabaseManager\Database;
use \App\Http\Middleware\Queue as MiddlewareQueue;

//Carrega variaveis de ambiente
Environment::load(__DIR__ .'/../');

//Variaveis do banco de dados
Database::config(
    getenv('DB_HOST'),
    getenv('DB_NAME'),   
    getenv('DB_USER'), 
    getenv('DB_PASS'), 
    getenv('DB_PORT'), 
);

//Variaves do servidor de email
define('EMAIL_HOST',getenv('EMAIL_HOST'));
define('EMAIL_USER',getenv('EMAIL_USER'));   
define('EMAIL_PASS',getenv('EMAIL_PASS')); 
define('EMAIL_SECURE',getenv('EMAIL_SECURE')); 
define('EMAIL_PORT',getenv('EMAIL_PORT')); 
define('EMAIL_CHARSET',getenv('EMAIL_CHARSET')); 
define('EMAIL_FORM_EMAIL',getenv('EMAIL_FORM_EMAIL')); 
define('EMAIL_FROM_NAME',getenv('EMAIL_FROM_NAME'));

//variavel mapbox token
define('TOKEN_MAPBOX',getenv('TOKEN_MAPBOX'));

//Defini uma url (Será provisoria)
define('URL', getenv('URL'));

define('SITEKEY', getenv('SITEKEY'));

//Define o dominio
define("DOMAIN",$_SERVER["HTTP_HOST"]);

//Envia os parametros para view
View::init([
    'URL' => URL,
    'DOMAIN' => DOMAIN,
    'SITEKEY' => SITEKEY
]);

//Define o mapeamento de middlewares
MiddlewareQueue::setMap([
    'maintenance'           => \App\Http\Middleware\Maintenance::class,
    'required-srv-logout'   => \App\Http\Middleware\RequireSrvLogoutCustomer::class,
    'required-srv-login'    => \App\Http\Middleware\RequireSrvLoginCustomer::class,
    'required-racs-logout'  => \App\Http\Middleware\RequireLogoutRACS::class,
    'required-racs-login'   => \App\Http\Middleware\RequireLoginRACS::class,
    'user-basic-auth'       => \App\Http\Middleware\UserBasicAuth::class,
    'api'                   => \App\Http\Middleware\Api::class,
]);

//Define o mapeamento de middlewares padrões (Executa em todas as rotas)
MiddlewareQueue::setDefault([
    'maintenance'  
]);