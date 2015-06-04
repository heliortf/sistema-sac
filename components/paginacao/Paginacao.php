<?php

/**
 * Classe que representa os dados de paginacao
 *
 */
class Paginacao {
    /**
     *
     * @var string
     */
    private $rota;
    
    /**
     *
     * @var array 
     */
    private $parametros;
    
    /**
     * Estas variaveis são de valores inteiros
     * 
     * @var int
     */
    private $pagina, $qtdRegistros, $qtdPorPagina, $inicio, $fim, $qtdPaginas;    
    
    public function __construct($params=array()){
        foreach($params as $k => $v){
            if(property_exists($this, $k)){
                $this->$k = $v;
            }
        }
    }
    
    function getRota() {
        return $this->rota;
    }

    function getParametros($substituicao=array()) {
        return array_merge($this->parametros, $substituicao);
    }
    
    function getPagina() {
        return $this->pagina;
    }

    function getQtdRegistros() {
        return $this->qtdRegistros;
    }

    function getQtdPorPagina() {
        return $this->qtdPorPagina;
    }

    function getInicio() {
        return $this->inicio;
    }

    function getFim() {
        return $this->fim;
    }

    function getQtdPaginas() {
        return $this->qtdPaginas;
    }

    public function temAnterior(){
        return $this->getPagina() == 1 ? false : true;
    }
    
    public function temProximo(){
        return $this->getPagina() < $this->getQtdPaginas() ? true : false;
    }
    
    public function getProximaPagina(){
        return $this->getPagina() + 1;
    }
    
    public function getPaginaAnterior(){
        return $this->getPagina() - 1;
    }
}
