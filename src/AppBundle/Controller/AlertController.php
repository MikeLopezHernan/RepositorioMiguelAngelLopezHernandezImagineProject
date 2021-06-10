<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AlertController extends Controller {

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $user_id = $user->getId();
        $consulta = "SELECT a FROM BackendBundle:Alerts a WHERE a.user = $user_id ORDER BY a.id DESC";
        $crearConsulta = $em->createQuery($consulta);

        $paginator = $this->get('knp_paginator');
        $alerts = $paginator->paginate($crearConsulta, $request->query->getInt('page', 1), 4);

        //Para marcar como leídas las notificaciones cuando entramos a la página "notificaciones"
        $alert = $this->get('app.alert_service');
        $alert->leido($user); //paso de usuario identificado
        
        
        return $this->render('AppBundle:Alerts:alerts_page.html.twig', array(
                    'user_id' => $user,
                    'pagination' => $alerts
        ));
        
    
    }

    public function countAlertsAction() {
        $em = $this->getDoctrine()->getManager();
        $alerts_repo = $em->getRepository("BackendBundle:Alerts");

        //Sacar las notificaciones que no se han leído por parte del usuario
        $alerts = $alerts_repo->findBy(array(
            'user' => $this->getUser(),
            'isReaded' => 0
        ));

        return new \Symfony\Component\HttpFoundation\Response(count($alerts));
    }

}
