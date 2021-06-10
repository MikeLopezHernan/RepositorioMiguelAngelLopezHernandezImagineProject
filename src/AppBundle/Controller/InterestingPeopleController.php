<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BackendBundle\Entity\User;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Persistence\ManagerRegistry;
use BackendBundle\Entity\InterestingPeople;

class InterestingPeopleController extends Controller {

    private $session;

    public function __construct(){
       $this->session = new Session();
    }
    
    public function followAction(Request $request){
        $user = $this->getUser(); //Usuario con el que estamos identificados en este momento //mi id
        $followed_id = $request->get('followed'); ///id del usuario al que voy a seguir
    
        $em =$this->getDoctrine()->getManager();
        
        $user_repo = $em->getRepository('BackendBundle:User'); //cargando el repositorio de la entidad usuario
        //Comprobamos si el usuario que vamos a seguir existe y sacamos sus registros
        $followed= $user_repo->find($followed_id);
        $following = new InterestingPeople();
        $following->setUser($user);
        $following->setFollowed($followed); //le pasamos el usuario seguido
        
        $em-> persist($following);
        $flush = $em->flush();
        
        if($flush == null){
            $status = "Ahora estás siguiendo a este usuario";
            
            //Llamamos al servicio alert_service de AlertService.php para crear una notificación
            $alert = $this->get('app.alert_service');
            $alert->set($followed,'follow',$user->getId());
        }else{
            $status = "No es posible seguir a este usuario";
        }
        
        return new Response($status);
    }

    public function unfollowAction(Request $request){
        $user = $this->getUser(); //Usuario con el que estamos identificados en este momento //mi id
        $followed_id = $request->get('followed'); ///id del usuario al que voy a seguir
    
        $em =$this->getDoctrine()->getManager();
        
        $follow_repo = $em->getRepository('BackendBundle:InterestingPeople'); //cargando el repositorio de la entidad usuario
        
        //Sacamos los registros followid y followed que se corresponden con el usuario y la persona a la que sigue ese usuario
        $followed =$follow_repo->findOneBy(array('user'=>$user,'followed'=>$followed_id));
        
        
        $em->remove($followed);
        //Con el flush borramos el objeto de la base de datos
        $flush = $em->flush();
        
        if($flush == null){
            $status = "Se ha dejado de seguir al usuario";
        }else{
            $status = "No es posible dejar de seguir al usuario";
        }
        
        return new Response($status);
    }
    public function siguiendoAction(Request $request, $usernick=null){
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
        $consulta = "SELECT i FROM BackendBundle:InterestingPeople i WHERE i.user = $user_id ORDER BY i.id DESC";
    
        $crearConsulta = $entityManager->createQuery($consulta);
        
        $paginator = $this->get('knp_paginator');
        $siguiendo = $paginator->paginate($crearConsulta,$request->query->getInt('page', 1), 4);
        return $this->render('AppBundle:InterestingPeople:siguiendo.html.twig',array('obtener_user'=>$user,'pagination'=>$siguiendo,'type'=>'siguiendo'));
    
  }
  public function seguidosAction(Request $request, $usernick=null){
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
        $consulta = "SELECT i FROM BackendBundle:InterestingPeople i WHERE i.followed = $user_id ORDER BY i.id DESC";
    
        $crearConsulta = $entityManager->createQuery($consulta);
        
        $paginator = $this->get('knp_paginator');
        $followed = $paginator->paginate($crearConsulta,$request->query->getInt('page', 1), 4);
        return $this->render('AppBundle:InterestingPeople:siguiendo.html.twig',array('obtener_user'=>$user,'pagination'=>$followed,'type'=>'followed'));
    
  }
}
