<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BackendBundle\Entity\User;
use BackendBundle\Entity\Thought;
use BackendBundle\Entity\Synergy;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;


class SynergyController extends Controller {
    public function synergyAction($id=null){
        //Extraer uusuario identificado
        $user = $this->getUser();
        //entity manager, pra trabajar con Doctrine y la base de datos
        $em = $this->getDoctrine()->getManager();
        
        //Buscar publicación por id
        $thought_repo = $em->getRepository('BackendBundle:Thought') ;
        $thought = $thought_repo->find($id);
        

        
        //Crear nuevo objeto synergy
        $synergy = new Synergy();
        //asignamos el usuario que le da a synergy 
        $synergy->setUser($user);
        // asignamos ese usuairo que le dio a synergy al thought
        $synergy->setThought($thought);
        
        
        //guardamos el objeto en doctrine persistido
        $em->persist($synergy);
        //volcado en la base de datos
        $flush = $em->flush();
        
        
        //comprobación de que el synergy es correcto
        
        if($flush == null){
            
            $status = '¡Thought añadido a Synergies!';
            //Llamamos al servicio alert_service de AlertService.php para crear una notificación
            $alert = $this->get('app.alert_service');
            $alert->set($thought->getUser(),'synergy',$user->getId(), $thought->getId() );
            
            
        }else{
            $status = 'Error a la hora de guardar el Synergy';
        }
        return new Response($status);
    }
    
    public function unsynergyAction($id = null){ //recibe el id del thought
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $synergy_repo = $em->getRepository('BackendBundle:Synergy');
        
       //Extraer si un thought tiene un synergy o no. Extrae el registro con el "usurio" e id
        $synergy=$synergy_repo->findOneBy(array(
            'user'=>$user,
            'thought'=>$id
        ));
        
        //Para eliminar el synergy del thought donde el usuario le dio synergy
        $em->remove($synergy);
        $flush=$em->flush();
        
        //comprobación de que el flush es correcto
        
        if($flush == null){
            $status = '¡Thought eliminado de Synergies!';
            
        }else{
            $status = 'Error a la hora de hacer unsynergy';
        }
        return new Response($status);
    }
    public function synergiesAction(Request $request, $usernick=null){
      //Para sacar a los usuarios que estamos siguiendo
        $entityManager = $this->getDoctrine()->getManager();
        
        if($usernick != null){
            $user_repo = $entityManager->getRepository("BackendBundle:User");
            $user = $user_repo->findOneBy(array("usernick"=>$usernick));
        }else{
            //Cargar perfil de usuario que se encuentra en sesión
            $user = $this->getUser();
        }
        
        if(empty($user) || !is_object($user)){
            return $this->redirect($this->generateUrl('home_thoughts'));
        }
        
        $user_id = $user->getId();
        $consulta = "SELECT i FROM BackendBundle:Synergy i WHERE i.user = $user_id ORDER BY i.id DESC";
    
        $crearConsulta = $entityManager->createQuery($consulta);
        
        $paginator = $this->get('knp_paginator');
        $synergies = $paginator->paginate($crearConsulta,$request->query->getInt('page', 1), 4);
        return $this->render('AppBundle:Synergy:synergies.html.twig',array('user'=>$user,'pagination'=>$synergies));
    
  }
  
  
}
