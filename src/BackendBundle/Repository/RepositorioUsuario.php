<?php
namespace BackendBundle\Repository;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RepositorioUsuario
 *
 * @author miked
 */
class RepositorioUsuario extends \Doctrine\ORM\EntityRepository {
    //Para sacar los usuarios que sigue el usuario. Para la lista de whisper
    public function getFollowingUsers($user){
        $em = $this->getEntityManager();
        $InterestingPeople_repo = $em->getRepository(("BackendBundle:InterestingPeople"));
        
        $siguiendo = $InterestingPeople_repo->findBy(array(
            'user'=>$user
        ));
        
        //Array con id de usuarios que seguimos para usarlos en la subconsulta
        $arraySiguiendo = array();
        
        foreach($siguiendo as $seguidos){
            $arraySiguiendo[] = $seguidos->getFollowed();
        }
        
        $repositorio = $em->getRepository('BackendBundle:User');
        
        
        $usuarios = $repositorio->createQueryBuilder('usuario')->where("usuario.id != :user AND usuario.id IN (:siguiendo)")
                ->setParameter('user',$user->getId())
                ->setParameter('siguiendo', $arraySiguiendo)
                ->orderBy('usuario.usernick','ASC');
        
        return $usuarios;
    }
}
