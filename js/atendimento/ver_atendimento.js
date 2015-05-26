function VerAtendimento(id){
	/** Variaveis **/
	this.id = id;	
        
        this.tabEncaminhar = null;
	
	/** Metodos privados **/
	this._initialize = function(){
            this.tabEncaminhar = jQuery("#encaminhar-area");
	}
	
	/**
	 *
	 */
	this._bind = function(){
            this._setListenersEncaminhar();
	};
	
	this._sync = function(){
	
	};
	
	/** Implementacoes privadas **/	
	this._setListenersEncaminhar = function(){
            this.tabEncaminhar.find("li > a").click(function(){                
                jQuery("input[name=area_id]:hidden").val(jQuery(this).data("area_id"));
                jQuery("#form-encaminhar").submit();
            });
	};
	
	/** Metodos publicos **/
	this.render = function(){
            this._bind();
            this._sync();
	};
	
	/** Metodos executados ao instanciar **/
	this._initialize();
}