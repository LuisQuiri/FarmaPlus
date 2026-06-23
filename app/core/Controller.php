<?php

class Controller
{
    protected function view($view, $data = [])
    {
        extract($data);

        $viewPath = __DIR__ . '/../Views/' . $view . '.php';

        if (!file_exists($viewPath)) {
            die("La vista no existe: " . $view);
        }

        ob_start();
        require_once $viewPath;
        $content = ob_get_clean();

        require_once __DIR__ . '/../Views/layouts/main.php';
    }
}