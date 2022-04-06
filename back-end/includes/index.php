<?php

require __DIR__.'/includes/app.php';

use \App\Http\Router;

// Inicia o Router
$objRouter = new Router(URL);

// Inclui rotas das páginas
include __DIR__ . '/routes/pages.php';

// Inclui rotas do painel clientes APP
include __DIR__ . '/routes/srv.php';

// Inclui rotas do painel dos colaboradores racs
include __DIR__ . '/routes/racs.php';

// Imprime o response da rota
$objRouter->run()->sendResponse();
