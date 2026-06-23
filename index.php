<?php

require_once __DIR__ . '/app/Core/Router.php';

$router = new Router();

require_once __DIR__ . '/routes/web.php';

$router->run();