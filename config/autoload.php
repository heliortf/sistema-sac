<?php

use Symfony\Component\ClassLoader\MapClassLoader;

$classes = array();

$ds = DIRECTORY_SEPARATOR;
$root = dirname(__FILE__)."{$ds}..{$ds}";

$paths = array(
    'models' => $root."model{$ds}"
);
    
foreach($paths as $nome => $path){
    $DI = new DirectoryIterator($path);
    
    foreach($DI as $arquivo){
        if($arquivo->isFile() && !$arquivo->isDot()){
            $classes[str_replace(".".$arquivo->getExtension(), "", $arquivo->getBasename())] = $arquivo->getRealPath();
        }
    }
}

$CL = new MapClassLoader($classes);
$CL->register();

