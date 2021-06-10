<?php
namespace AppBundle\Twig;
use Symfony\Bridge\Doctrine\RegistryInterface;
class CounterLikesExtension extends \Twig_Extension{
    protected $doctrine;
    //Para inyectar servicios
    public function __construct(RegistryInterface $doctrine){
        $this->doctrine=$doctrine;
    }
    
    public function getFilters(){
    
        return array(
            //Definimos un filtro de twig
            new \Twig_SimpleFilter('counterlikes', array($this, 'contadorLikes'))
        );
        
    }
 
    public function getName(){
        return 'counterlikes_extension';
    }
    
    public function contadorLikes($id){
       $synergy_repo = $this->doctrine->getRepository('BackendBundle:Synergy');

       $contadorLikes = $synergy_repo->findBy(array(
           'thought'=>$id
       ));

       $result=array(
           'likes_count'=>count($contadorLikes)
       );
       return $result;
   }     

}
