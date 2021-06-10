<?php
namespace AppBundle\Twig;
use Symfony\Bridge\Doctrine\RegistryInterface;
class UserStatsExtension extends \Twig_Extension{
    protected $doctrine;
    //Para inyectar servicios
    public function __construct(RegistryInterface $doctrine){
        $this->doctrine=$doctrine;
    }
    
    public function getFilters(){
    
        return array(
            //Definimos un filtro de twig
            new \Twig_SimpleFilter('user_stats', array($this, 'userStatsFilter'))
        );
        
    }
    public function userStatsFilter($user){
        $synergy_repo = $this->doctrine->getRepository('BackendBundle:Synergy');
        $following_repo = $this->doctrine->getRepository('BackendBundle:InterestingPeople');
        $thought_repo = $this->doctrine->getRepository('BackendBundle:Thought');

        //Exrtraer usuarios que seguimos
        $user_following = $following_repo->findBy(array(
            'user'=>$user
        ));
        //Extraer usuarios que nos siguen
        $user_followers = $following_repo->findBy(array(
            'followed'=>$user
        ));
        //Extraer publicaciones del usuario
        $user_thoughts = $thought_repo->findBy(array(
            'user'=>$user
        ));
        //Extraer synergies
        $user_synergies = $synergy_repo->findBy(array(
            'user'=>$user
        ));
        
        $result=array(
            'following'=>count($user_following),
            'followers' =>count($user_followers),
            'thoughts'=>count($user_thoughts),
            'synergies'=>count($user_synergies)

        );
        return $result;
    }  
    
    public function getName(){
        return 'user_stats_extension';
    }
}