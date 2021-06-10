<?php
namespace AppBundle\Twig;
use Symfony\Bridge\Doctrine\RegistryInterface;
class FollowingExtension extends \Twig_Extension{
    protected $doctrine;
    //Para inyectar servicios
    public function __construct(RegistryInterface $doctrine){
        $this->doctrine=$doctrine;
    }
    
    public function getFilters(){
    
        return array(
            //Definimos un filtro de twig
            new \Twig_SimpleFilter('interestingPeople', array($this, 'followingFilter'))
        );
        
    }
    public function followingFilter($user,$followed){
        $following_repo = $this->doctrine->getRepository('BackendBundle:InterestingPeople');
        $user_following = $following_repo->findOneBy(array(
            "user"=> $user,
            "followed"=> $followed
        ));
        if(!empty($user_following) && is_object($user_following)){
            $result=true;
        }else{
            $result = false;
        }
        return $result;
    }
    
    public function getName(){
        return 'interestingPeople_extension';
    }
}