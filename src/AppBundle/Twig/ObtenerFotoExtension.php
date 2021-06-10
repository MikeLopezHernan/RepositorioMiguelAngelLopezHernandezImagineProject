<?php
namespace AppBundle\Twig;
use Symfony\Bridge\Doctrine\RegistryInterface;
class ObtenerFotoExtension extends \Twig_Extension{
    protected $doctrine;
    //Para inyectar servicios
    public function __construct(RegistryInterface $doctrine){
        $this->doctrine=$doctrine;
    }
    
    public function getFilters(){
    
        return array(
            //Definimos un filtro de twig
            new \Twig_SimpleFilter('obtener_foto', array($this, 'obtenerFotoFilter'))
        );
        
    }
    public function obtenerFotoFilter($thought_id){
        
        $thought_repo = $this->doctrine->getRepository('BackendBundle:Thought');

        $thought = $thought_repo->findOneBy(array(
            "id"=> $thought_id
        ));
        if(!empty($thought) && is_object($thought)){
            $result=$thought;
        }else{
            $result = false;
        }
        return $result;
    }
    
    public function getName(){
        return 'obtener_foto_extension';
    }
}