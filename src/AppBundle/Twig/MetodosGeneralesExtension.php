<?php
namespace AppBundle\Twig;
use Symfony\Bridge\Doctrine\RegistryInterface;
class MetodosGeneralesExtension extends \Twig_Extension{
    protected $doctrine;
    //Para inyectar servicios
    public function __construct(RegistryInterface $doctrine){
        $this->doctrine=$doctrine;
    }
    
    public function getFilters(){
    
        return array(
            //Definimos un filtro de twig
            new \Twig_SimpleFilter('metodosgenerales', array($this, 'convertTextURL'))
        );
        
    }
 
    public function getName(){
        return 'metodosgenerales_extension';
    }
    
    public function convertTextURL($cadena){
        
        $pattern = '@(http(s)?://)?(([a-zA-Z])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@';
        return $output = preg_replace($pattern, '<a href="http$2://$3">$0</a>', $cadena);
   }     

}