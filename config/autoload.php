<?php

use Symfony\Component\ClassLoader\MapClassLoader;

$ds = DIRECTORY_SEPARATOR;
$root = dirname(__FILE__)."{$ds}..{$ds}";

$paths = array(
    'models' => $root."model{$ds}",
    'components' => $root."components{$ds}"
);
    
class SACClassLoader {
    
    private $caminhosLidos = array();
    private $classes = array();
    
    function __construct() {
        $this->classes['Config'] = dirname(__FILE__).DIRECTORY_SEPARATOR."config.php";
    }

    
    public function lerClasses($path){
        if(!in_array($path, $this->caminhosLidos)){
            $this->caminhosLidos[] = $path;
            
            $DI = new DirectoryIterator($path);

            foreach($DI as $arquivo){
                if(!$arquivo->isDot()){
                    if($arquivo->isFile()){
                        $this->classes[str_replace(".".$arquivo->getExtension(), "", $arquivo->getBasename())] = $arquivo->getRealPath();
                    }
                    else if($arquivo->isDir()){
                        $this->lerClasses($arquivo->getRealPath());
                    }    
                }
            }
        }
    }
    
    function getClasses() {
        return $this->classes;
    }
}
    
$SacCL = new SACClassLoader();

foreach($paths as $nome => $path){
    $SacCL->lerClasses($path);
}

$CL = new MapClassLoader($SacCL->getClasses());
$CL->register();

