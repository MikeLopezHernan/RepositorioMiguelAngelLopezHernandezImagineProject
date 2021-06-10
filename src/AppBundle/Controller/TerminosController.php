<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TerminosController extends Controller
{
    
    public function indexAction(Request $request)
    {
    return $this->render('AppBundle:TerminosDeUso:terminos.html.twig');
    }
    public function pag2Action(Request $request)
    {
    return $this->render('AppBundle:TerminosDeUso:terminospag2.html.twig');
    }
}
