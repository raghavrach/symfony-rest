<?php
namespace ApiBundle\Controller;

use CommonBundle\Controller\BaseController;

class IndexController extends BaseController
{
    /**
     * Default controller action
     *
     * @return message
     */
    public function indexAction()
    {
        return "It Works!";
    }
}