<?php

namespace pronajem\libs;

class Component
{

    public function render(string $name, array $data = []): string
    {
        $componentPath = ROOT . "/app/views/Components/{$name}.php";

        if (!file_exists($componentPath)) {
            throw new \Exception("Component file not found: {$componentPath}", 404);
        }

        extract($data);

        ob_start();
        include $componentPath;
        return ob_get_clean();
    }


}