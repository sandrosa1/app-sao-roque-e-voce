<?php

use \App\Http\Response;
use \App\Controller\Api;


$objRouter->post('/api/v1/login/',[
    'middlewares' => [
        'api',
    ],
    function($request){

        return new Response(200,Api\Login::existUser($request),'application/json');
    }
]);


