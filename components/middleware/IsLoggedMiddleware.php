<?php

/**
 * Description of IsLoggedMiddleware
 *
 * @author PONTOFRIO
 */
class IsLoggedMiddleware extends \Slim\Middleware {
    
    public function call() {
        $this->app->hook('slim.before.dispatch', array($this, 'validarLogin'));        
        $this->next->call();
    }
    
    /**
     * Realiza a verificação se é necessário estar logado ou não
     */
    public function validarLogin(){
        $route = $this->app->router->getCurrentRoute()->getPattern();
        
        if($route == '/'){
            return true;
        }
        
        $patternsPermitidos = array(            
            '/login/',            
            '/logout/',
            '/autenticar/'
        );
        
        $permitido = false;
        foreach($patternsPermitidos as $pattern){
            if(preg_match($pattern, $route) == 1 ){
                $permitido = true;
                break;
            }
        }
        
        if($permitido == false){
            $Usuario = WebUser::getInstance();
            
            if($Usuario->isLogado() == false){
                if($this->app->router->getCurrentRoute()->getName() != 'login_empresa'){
                    $this->app->redirectTo('logout');
                }
            }
        }
    }
}