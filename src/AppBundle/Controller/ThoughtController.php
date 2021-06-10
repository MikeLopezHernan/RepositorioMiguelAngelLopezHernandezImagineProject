<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\ThoughtType;
use BackendBundle\Entity\Thought;
use BackendBundle\Entity\Banword;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;


class ThoughtController extends Controller {
    
   
   
    public function indexAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $thought = new Thought();
        
        $form = $this->createForm(ThoughtType::class, $thought);
        $id=$thought->getId();
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                
                
                 $videoYouTube = $form['videoyt']->getData();
                
                
                //Coger el id del video de youtube si existe para después enviarlo al Thought
                if (!empty($videoYouTube) && $videoYouTube != null) {
                    $url = $videoYouTube;
                    parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
                    if (isset($my_array_of_vars['v'])) {
                        $thought->setVideoyt($my_array_of_vars['v']);
                    }
                  
                    
                }
               
                
                
                
                
                
                //subir imagen
                $image = $form['image']->getData();
                if (!empty($image) && $image != null) {
                    $ex = $image->guessExtension();
                    if ($ex == 'jpg' || $ex == 'JPG' || $ex == 'jpeg' || $ex == 'JPEG' || $ex == 'png' || $ex == 'PNG' || $ex == 'gif' || $ex == 'mp4') {
                        $nombreImagen = $user->getId() . time() . "." . $ex;
                        $image->move("uploads/thoughts/images", $nombreImagen);
                        $thought->setImage($nombreImagen);
                    } else {
                        $thought->setImage(null);
                        $status = 'Imagen adjunta no válida';
                         $this->addFlash('status', $status);
                         return $this->redirect('home');
                        
                    }
                } else {
                    $thought->setImage(null);
                }

                //subir documento

                $documento = $form['attachment']->getData();
                if (!empty($documento) && $documento != null) {
                    $ex = $documento->guessExtension();
                    if ($ex == 'pdf' || $ex == 'rar' || $ex == 'zip' || $ex == 'doc' || $ex == 'docx' || $ex == 'mp4' || $ex == 'jpg' || $ex == 'JPG' || $ex == 'jpeg' || $ex == 'JPEG' || $ex == 'png' || $ex == 'PNG' || $ex == 'gif') {
                        $nombreFichero = $user->getId() . time() . "." . $ex;
                        $documento->move("uploads/thoughts/documents", $nombreFichero);
                        $thought->setAttachment($nombreFichero);
                    } else {
                        $thought->setAttachment(null);
                         $status = 'Archivo adjunto no válido';
                         $this->addFlash('status', $status);
                         return $this->redirect('home');
                    }
                } else {
                    $thought->setAttachment(null);
                }

                $thought->setUser($user);
                $thought->setCreationDate(new \DateTime("now"));

                $em->persist($thought);
                $flush = $em->flush();
                if ($flush == null) {
                    $status = 'Publicación creada correctamente';
                } else {
                    $status = 'Error al crear la publicación';
                }
            } else {
                $status = "Imposible crear publicación, has introducido una imagen o archivo no válido";
               
            }
            $this->addFlash('status', $status);
            return $this->redirect('home');

        }
        $publicaciones = $this->getThoughts($request);
        
        return $this->render('AppBundle:Thought:home.html.twig', array(
                    'form' => $form->createView(),
                    'pagination'=>$publicaciones
        ));
    }
    public function getThoughts($request){
        
        $em = $this->getDoctrine()->getManager();
        
        $user = $this->getUser();
        $thoughts_repo = $em->getRepository('BackendBundle:Thought');
        $following_repository = $em->getRepository('BackendBundle:InterestingPeople');
        
        $siguiendo = $following_repository->findBy(array('user'=>$user));
        
       
        
        /*Array de todos los usuarios a los que se sigue*/
        $siguiendo_array = array();
        foreach($siguiendo as $follow){
            $siguiendo_array[] = $follow->getFollowed();
        }
        $query=$thoughts_repo->createQueryBuilder('p')
                ->where('p.user =(:user_id) OR p.user in (:siguiendo)')
                ->setParameter('user_id',$user->getId())
                ->setParameter('siguiendo',$siguiendo_array)
                ->orderBy('p.id', 'DESC')
                ->getQuery();
        
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($query, $request->query->getInt('page', 1),4);
        return $pagination;
        
    }
    public function borrarThoughtAction(Request $request, $id =null){
        $em =$this->getDoctrine()->getManager();
        $user = $this->getUser();
        $thought_repo = $em->getRepository('BackendBundle:Thought');
        $thought = $thought_repo->find($id);

        $alert_repo = $em->getRepository('BackendBundle:Alerts');
        
       //Extraer si un thought tiene un synergy o no. Extrae el registro con el "usurio" e id
        $alert=$alert_repo->findOneBy(array(
            'misscellaneous'=>$id
        ));
        if($alert!=null){
        $em->remove($alert);
        $flush=$em->flush();
        }
        
        if($user->getId() == $thought->getUser()->getId()){
        $em->remove($thought);
        $flush=$em->flush();
        
         if ($flush == null) {
                    $status = '¡Thought borrado, ya nadie podrá verlo!';
                } else {
                    $status = 'Error al borrar el Thought';
                }
        }else{
            $status = 'Error al borrar el Thought';
        }
        return new Response($status);
    }
     public function comentarioAction(Request $request) {
        
    }
}
