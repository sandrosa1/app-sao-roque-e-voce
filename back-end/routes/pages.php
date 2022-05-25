<?php

use \App\Http\Response;
use App\Controller\Pages;

//ROTAS DAS PAGINAS RACS //
//Rota de get pagina home
$objRouter->get('/',[
    'middlewares' => [
        'maintenance'
    ],
    function(){
        return new Response(200,Pages\Home::getHome());
    }
]);
//Rota de sobre (GET)
$objRouter->get('/sobre',[
    function(){
        return new Response(200,Pages\About::getAbout());
    }
]);
//Rota de produtos (GET)
$objRouter->get('/products',[
    function(){
        return new Response(200,Pages\Product::getProducts());
    }
]);
//Rota de casdatro (GET)
$objRouter->get('/cadastro',[
    function($request){
        return new Response(200,Pages\Cadastro::getCadastro($request));
    }
]);
//Rota de insert (POST)
$objRouter->post('/cadastro',[
    function($request){
        return new Response(200,Pages\Cadastro::insertRegistration($request));
    }
]);
//Rota de Contato (GET)
$objRouter->get('/contato',[
    function($request){
        return new Response(200,Pages\Contato::getContato($request));
    }
]);
//Rota de Contato (GET)
$objRouter->get('/api',[
    function($request){
        return new Response(200,Pages\Api::getApi($request));
    }
]);
//Rota de formulario Contato (POST)
$objRouter->post('/contato',[
    function($request){
        return new Response(200,Pages\Contato::postContato($request));
    }
]);





