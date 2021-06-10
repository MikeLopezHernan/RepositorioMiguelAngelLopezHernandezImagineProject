<?php

namespace BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user_repo = $entityManager->getRepository("BackendBundle:User");
        
        $user=$user_repo->find(1);
        //En vez de sacar un objeto solo, saca un array de objetos
       // $user=$user_repo->findAll();
        
        echo "Bienvenido".$user->getName()." ".$user->getSurname ();
        var_dump($user);
        die();
        return $this->render('BackendBundle:Default:index.html.twig');
    }
}
