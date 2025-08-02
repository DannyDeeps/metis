<?php namespace Metis\Framework\ViewEngines;

use \Twig\Environment;

class TwigEngine extends AbstractViewEngine
{
    public function __construct(
        private Environment $twig,
        private array $data= []
    ) {}

    public function addViewData(string|array $data, mixed $value= null)
    {
        if (is_string($data)) {
            if (empty($value)) {
                throw new \Exception("Attempt to assign 'null' as '$data'");
            }

            $this->data[$data]= $value;

            return $this;
        }

        foreach ($data as $key => $value) {
            $this->data[$key]= $value;
        }

        return $this;
    }

    public function renderView(string $template)
    {
        echo $this->twig->display($template, $this->data);
        exit;
    }

    public function fetchView(string $template)
    {
        return $this->twig->render($template, $this->data);
    }
}