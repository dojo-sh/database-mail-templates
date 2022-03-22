<?php


namespace DojoSh\DatabaseMailTemplates;

use Illuminate\View\Component;
use Illuminate\Container\Container;
use Illuminate\Contracts\View\Factory as ViewFactory;



class TemplateMailableRenderer
{
    public function render($mailable, $field, $data = [], $deleteCachedView = false)
    {
        $component = new class($mailable->{$field}) extends Component
        {
            protected $template;

            public function __construct($template)
            {
                $this->template = $template;
            }

            public function render()
            {
                return $this->template;
            }
        };

        $view = Container::getInstance()
            ->make(ViewFactory::class)
            ->make($component->resolveView(), $data);

        return tap($view->render(), function () use ($view, $deleteCachedView) {
            if ($deleteCachedView) {
                unlink($view->getPath());
            }
        });
    }
}
