<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BackendBundle\Entity\User;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;
use BackendBundle\Entity\Whisper;
use AppBundle\Form\WhisperType;
class WhisperController extends Controller {

    private $session;

    
  public function __construct(){
      $this->session = new Session();
    }
     public function enviadosAction(Request $request){
        $whisper = $this->obtenerWhispers($request,"enviado");
        return $this->render('AppBundle:Whisper:enviados.html.twig', array(
          'pagination' =>$whisper  
        ));
    }
    public function obtenerWhispers($request,$type=null){
        $em=$this->getDoctrine()->getManager();
        $user=$this->getUser();
        $userid=$user->getId();
        if($type=="enviado"){
            //Extraer whisper en los cuales seamos el emisor
            $consultaDql = "SELECT w FROM BackendBundle:Whisper w WHERE w.sender = $userid ORDER BY w.id DESC";
        }else{
            //En el caso de que seamos receptores
            $consultaDql = "SELECT w FROM BackendBundle:Whisper w WHERE w.receiver = $userid ORDER BY w.id DESC";

        }
        $consulta =$em->createQuery($consultaDql);
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($consulta, $request->query->getInt('page', 1),4);
        return $pagination;
    }
    public function indexAction(Request $request){
        
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        
        $whisper = new Whisper();
        //Para crear el formulario
        $formulario =$this->createForm(WhisperType::class,$whisper,array('empty_data'=>$user));
        //Juntamos los datos del formulario con el objeto de la entidad
        $formulario->handleRequest($request);
        if($formulario->isSubmitted()){
            if($formulario->isValid()){
                //subir imagen
                $image = $formulario['image']->getData();
                if (!empty($image) && $image != null) {
                    $ex = $image->guessExtension();
                    if ($ex == 'jpg' || $ex == 'JPG' || $ex == 'jpeg' || $ex == 'JPEG' || $ex == 'png' || $ex == 'PNG' || $ex == 'gif') {
                        $nombreImagen = $user->getId() . time() . "." . $ex;
                        $image->move("uploads/whispers/images", $nombreImagen);
                        $whisper->setImage($nombreImagen);
                    } else {
                        $whisper->setImage(null);
                        $status = 'Imagen adjunta no válida';
                         $this->addFlash('status', $status);
                         return $this->redirectToRoute('whisper');
                        
                    }
                } else {
                    $whisper->setImage(null);
                }

                //subir documento

                $documento = $formulario['attachment']->getData();
                if (!empty($documento) && $documento != null) {
                    $ex = $documento->guessExtension();
                    if ($ex == 'pdf') {
                        $nombreFichero = $user->getId() . time() . "." . $ex;
                        $documento->move("uploads/whispers/documents", $nombreFichero);
                        $whisper->setAttachment($nombreFichero);
                    } else {
                        $whisper->setAttachment(null);
                         $status = 'Archivo adjunto no válido';
                         $this->addFlash('status', $status);
                         return $this->redirectToRoute('whisper');
                    }
                } else {
                    $whisper->setAttachment(null);
                }

                $whisper->setSender($user);
                $whisper->setCreationDate(new \DateTime("now"));
                $whisper->setReaded(0);
                $nick =$whisper->getReceiver();
                $nick= $nick->getUsernick();
                
                $em->persist($whisper);
                $flush = $em->flush();
                
                if($flush==null){
                    $status="Whisper enviado a ".$nick;
                }else{
                    $status ="Mensaje no enviado";
                }
                $this->session->getFlashBag()->add("status",$status);
                return $this->redirectToRoute("whisper");
                

            }else{
                $status = "No ha sido posible enviar el whisper";
            }
        }
        $whisper = $this->obtenerWhispers($request);
        //Para marcar las notificaciones leidas cuando se cargan los mensajes privados y se pasan a la vista llamamos al metodo leido que está más abajo.
        $this->leido($user,$em);
        return $this->render('AppBundle:Whisper:whisper.html.twig',array(
            "formulario"=>$formulario->createView(),
            'pagination'=>$whisper
        ));
    }
   public function noLeidoAction(){
       $em=$this->getDoctrine()->getManager();
       $user =$this->getUser();
        
       //Sacar los whisper que no se han leído por parte del usuario

       $whisper_repo = $em->getRepository('BackendBundle:Whisper');
       $contadorNoLeidos = count($whisper_repo->findBy(array(
           'receiver'=>$user,
           'readed'=>0
       )));
       return new Response($contadorNoLeidos);
   }
    public function leido($user,$em) {
        $whisper_repo = $em->getRepository('BackendBundle:Whisper');
        //Sacamos los whispers en los cuales seamos el receiver y tengan readed a 0
        $whisper = $whisper_repo->findBy(array(
            'receiver'=>$user,
            'readed'=>0
        ));
        
        //Recorremos los whisper anteriores y establecemos a 1 el valor de readed
        foreach($whisper as $wh){
           $wh->setReaded(1);
           $em->persist($wh);
        }
        //Realizamos las modificaciones que se encuentran persistidas
        $em->flush();

        return true;
    }
}