<?php

namespace SupportKd\CyxS3Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SupportKdCyxS3Bundle:Default:index.html.twig');
    }
}
