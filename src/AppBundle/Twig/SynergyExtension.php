<?php
namespace AppBundle\Twig;
use Symfony\Bridge\Doctrine\RegistryInterface;
class SynergyExtension extends \Twig_Extension{
    protected $doctrine;
    //Para inyectar servicios
    public function __construct(RegistryInterface $doctrine){
        $this->doctrine=$doctrine;
    }
    
    public function getFilters(){
    
        return array(
            //Definimos un filtro de twig
            new \Twig_SimpleFilter('synerged', array($this, 'synergedFilter'))
        );
        
    }
    public function synergedFilter($user,$thought){
        $synergy_repo = $this->doctrine->getRepository('BackendBundle:Synergy');
        $thought_synerged = $synergy_repo->findOneBy(array(
            "user"=> $user,
            "thought"=> $thought
        ));
        if(!empty($thought_synerged) && is_object($thought_synerged)){
            $result=true;
        }else{
            $result = false;
        }
        return $result;
    }
    
    public function getName(){
        return 'synergy_extension';
    }
}


