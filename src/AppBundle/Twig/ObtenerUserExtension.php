<?php
namespace AppBundle\Twig;
use Symfony\Bridge\Doctrine\RegistryInterface;
class ObtenerUserExtension extends \Twig_Extension{
    protected $doctrine;
    //Para inyectar servicios
    public function __construct(RegistryInterface $doctrine){
        $this->doctrine=$doctrine;
    }
    
    public function getFilters(){
    
        return array(
            //Definimos un filtro de twig
            new \Twig_SimpleFilter('obtener_user', array($this, 'obtenerUserFilter'))
        );
        
    }
    public function obtenerUserFilter($user_id){
        $user_repo = $this->doctrine->getRepository('BackendBundle:User');
        $user = $user_repo->findOneBy(array(
            "id"=> $user_id
        ));
        if(!empty($user) && is_object($user)){
            $result=$user;
        }else{
            $result = false;
        }
        return $result;
    }
    
    public function getName(){
        return 'obtener_user_extension';
    }
}