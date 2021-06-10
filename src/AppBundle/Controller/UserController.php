<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BackendBundle\Entity\User;
use AppBundle\Form\RegisterType;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\UserType;

class UserController extends Controller {
/*
    private $session;

    
  public function __construct(){
      $this->session = new Session();
    }
*/
    public function loginAction(Request $request) {
        if (is_object($this->getUser())) {
            return $this->redirect('home');
        }
        //Servicio de autenticación de symfony
        $autUtils = $this->get('security.authentication_utils');
        $error = $autUtils->getLastAuthenticationError();
        $ultimoUsuario = $autUtils->getLastUsername();

        return $this->render('AppBundle:User:login.html.twig', array(
                    'ultimoUsuario' => $ultimoUsuario,
                    'error' => $error));
    }

    public function registerAction(Request $request) {

        if (is_object($this->getUser())) {
            return $this->redirect('home');
        }
        $this->session = $request->getSession();

        $usuario = new User();
        $formulario = $this->createForm(RegisterType::class, $usuario);

        $formulario->handleRequest($request);

        if ($formulario->isSubmitted()) {
            if ($formulario->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                //$repositorio_usuario= $entityManager->getRepository("BackendBundle:User");
                //comprobación si el nick o email ya existe en la base de datos
                $consulta = $entityManager->createQuery('SELECT usuario FROM BackendBundle:User usuario WHERE usuario.maildir = :maildir OR usuario.usernick = :usernick')
                        ->setParameter('maildir', $formulario->get("maildir")->getData())
                        ->setParameter('usernick', $formulario->get("usernick")->getData());
                $resultados_consulta = $consulta->getResult(); //si devuelve algo o no

                if (count($resultados_consulta) == 0) {
                    $factory = $this->get("security.encoder_factory");
                    $encoder = $factory->getEncoder($usuario);

                    $password = $encoder->encodePassword($formulario->get("password")->getData(), $usuario->getSalt());

                    $usuario->setPassword($password);
                    $usuario->setRole("USER");
                    $usuario->setUserimage(null);
                    $usuario->setUserstatus(1);

                    $entityManager->persist($usuario);
                    //Pasamos objetos que se encuentran persistidos a la base de datos, persistir permite que se comportencomo objetos en symfony
                    $flush = $entityManager->flush();

                    //Comprobación de almacenamiento correcto
                    if ($flush == null) {
                        
                        $status = "Usuario registrado correctamente. ¡Bienvenid@ a Frontier!";
                        // mensaje flash
                        $this->addFlash('status', $status);
                        return $this->redirect("login");
                    } else {
                        $status = "Ha habido algún problema durante el registro, por favor, vuelve a intentarlo.";
                    }
                } else {
                    $status = "Ya existe un usuario en la plataforma con ese Nick o dirección de correo electrónico, pruebe con otras credenciales";
                }
            } else {
                $status = "No se ha podido registrar correctamente el usuario, por favor, revise la información";
            }
            //var_dump($status);
            //die();
            //mensaje flash
            $this->addFlash('error', $status);
        }


        return $this->render('AppBundle:User:register.html.twig', array("formulario" => $formulario->createView()));
    }

    public function comprobarNickAction(Request $request) {

        //Utilizar también para las palabras clave en la base de datos
        $usernick = $request->get("usernick");
        $entityManager = $this->getDoctrine()->getManager();

        $user_repo = $entityManager->getRepository("BackendBundle:User");
        $usuarioUtilizado = $user_repo->findOneBy(array("usernick" => $usernick));

        $resultado = "utilizado";
        if (count($usuarioUtilizado) >= 1 && is_object($usuarioUtilizado)) {
            $resultado = "utilizado";
        } else {
            $resultado = "Sin utilizar";
        }
        return new Response($resultado);
    }

    public function comprobarCorreoAction(Request $request) {

        //Utilizar también para las palabras clave en la base de datos
        $maildir = $request->get("maildir");
        $entityManager = $this->getDoctrine()->getManager();

        $user_repo = $entityManager->getRepository("BackendBundle:User");
        $correoUtilizado = $user_repo->findOneBy(array("maildir" => $maildir));

        $resultado = "utilizado";
        if (count($correoUtilizado) >= 1 && is_object($correoUtilizado)) {
            $resultado = "utilizado";
        } else {
            $resultado = "Sin utilizar";
        }
        return new Response($resultado);
    }

    public function editUserAction(Request $request) {


        $user = $this->getUser();
        $user_image = $user->getUserimage();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $query = $em->createQuery('SELECT usuario FROM BackendBundle:User usuario WHERE usuario.maildir =:maildir OR usuario.usernick = :usernick')
                        ->setParameter('maildir', $form->get("maildir")->getData())
                        ->setParameter('usernick', $form->get("usernick")->getData());
                $user_isset = $query->getResult();
                
               
                
                if (count($user_isset) == 0||($user->getMaildir() == $user_isset[0]->getMaildir() &&
                        $user->getUsernick() == $user_isset[0]->getUsernick())) {
                    //subir fichero
                    $file = $form["userimage"]->getData();
                    if (!empty($file) && $file != null) {
                        $ext = $file->guessExtension();
                        if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif') {
                            $file_name = $user->getId() . time() . '.' . $ext;
                            $file->move("uploads/users", $file_name);
                            $user->setUserimage($file_name);
                        }
                    } else {
                        $user->setUserimage($user_image);
                    }
                    $em->persist($user);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status2 = "Sus datos han sido modificados correctamente";
                        $this->addFlash('status2', $status2);
                        return $this->redirect("user-config");
                    } else {
                        $status2 = "Sus datos no han sido actualizados";
                    }
                } else {
                    $status2 = "Nick o Email ya existente";
                }
            } else {
                $status2 = "Sus datos no han sido actualizados";
            }
            //$this->session->getFlashBag()->add("status", $status);
            $this->addFlash('error2', $status2);
        }
        return $this->render('AppBundle:User:user_config.html.twig', array(
                    "form" => $form->createView()
        ));
    }

    public function usersAction(Request $request) {

        $em = $this->getDoctrine()->getManager();

        $dql = "SELECT usuario FROM BackendBundle:User usuario ORDER BY usuario.id DESC";
        $query = $em->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($query, $request->query->getInt('page', 1), 4);

        return $this->render('AppBundle:User:users.html.twig',array('pagination'=>$pagination));
    
        
    }
    
    public function searchAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        
        $search =trim($request->query->get("search",null));
        if($search == null){
            return $this->redirect('home');
        }
        
        //Funcion explode para cortar strings
        $searched=explode(" ", $search);
        
        //Consulta nombre y apellidos
        if(count($searched)>1){
            $parameters = (array(
                'search' => "%$searched[0]%",
                'searchap' => "%$searched[1]%",
            ));
            $dql = "SELECT usuario FROM BackendBundle:User usuario WHERE usuario.name LIKE :search AND usuario.surname LIKE :searchap ORDER BY usuario.id ASC";
            $query = $em->createQuery($dql)->setParameters($parameters);
        }
        
        
        //consulta para nombre, apellidos y nick por separado
        if(count($searched)==1){
             $parameters = (array(
                'search' => "%$searched[0]%"
            ));
            $dql = "SELECT usuario FROM BackendBundle:User usuario WHERE usuario.name LIKE :search OR usuario.surname LIKE :search OR usuario.usernick LIKE :search ORDER BY usuario.id ASC";
            $query = $em->createQuery($dql)->setParameters($parameters);
        }
        

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($query, $request->query->getInt('page', 1), 4);

        return $this->render('AppBundle:User:users.html.twig',array('pagination'=>$pagination));
    
        
    }
    public function perfilAction(Request $request,$usernick = null ){
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
        $consulta = "SELECT t FROM BackendBundle:Thought t WHERE t.user = $user_id ORDER BY t.id DESC";
    
        $crearConsulta = $entityManager->createQuery($consulta);
        
        $paginator = $this->get('knp_paginator');
        $thoughts = $paginator->paginate($crearConsulta,$request->query->getInt('page', 1), 4);
        return $this->render('AppBundle:User:profile.html.twig',array('user'=>$user,'pagination'=>$thoughts));
    }
}
