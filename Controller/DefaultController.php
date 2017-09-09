<?php

namespace Creavo\NotifyTaskBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction() {



        return $this->render('CreavoNotifyTaskBundle:Default:index.html.twig');
    }
}
