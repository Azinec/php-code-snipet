<?php

namespace AppBundle\View;

use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandler;
use Symfony\Component\HttpFoundation\Request;

class JsonViewHandler
{
    const CODE = 'code';
    const MESSAGE = 'message';
    const DATA = 'data';

    /**
     * @param ViewHandler $handler
     * @param View        $view
     * @param Request     $request
     * @param $format
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(ViewHandler $handler, View $view, Request $request, $format)
    {
        $view->setData([
            self::CODE => $view->getStatusCode(),
            self::DATA => $view->getData(),
        ]);

        return $handler->createResponse($view, $request, $format);
    }
}
