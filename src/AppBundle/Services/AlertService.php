<?php

namespace AppBundle\Services;

use BackendBundle\Entity\Alerts;

class AlertService {

    //manager de doctrine para trabajar con entidades y repositorios
    public $manager;

    //Constructor
    public function __construct($manager) {
        $this->manager = $manager;
    }

    //Crear notificación y guardar registro en la base de datos
    //$noti_type_id es el id del usuario que le ha dado synergy por ejemplo y en misscellaneous va el id del thougt al que el usuario le dio synergy
    public function set($user_id, $noti_type, $noti_type_id, $misscellaneous = null) {
        $em = $this->manager;

        $alert = new Alerts();
        $alert->setUser($user_id);
        $alert->setNotiType($noti_type);
        $alert->setNotiTypeId($noti_type_id);
        $alert->setIsReaded(0); // no leida
        $alert->setCreationDate(new \DateTime("now"));
        $alert->setMisscellaneous($misscellaneous);

        $em->persist($alert);
        $flush = $em->flush();

        if ($flush == null) {
            $status = true;
        } else {
            $status = false;
        }

        return $status;
    }

    public function leido($user) {
        $em = $this->manager;
        $alerts_repo = $em->getRepository('BackendBundle:Alerts');
        
        //Sacamos los registros en el que el campo usuario sea igual al usuario, para así
        //poder marcar las notificaciones del usuario como leídas
        $alerts = $alerts_repo->findBy(array('user'=>$user));
        
        //Bucle para recorrer las notificaciones devueltas en el paso anterior, pudiendo así marcarlas como leídas
        foreach($alerts as $alerts){
            $alerts->setIsReaded(1);
            $em->persist($alerts);
        }
        //Realizamos las modificaciones que se encuentran persistidas
        $em->flush();

        return true;
    }

}
