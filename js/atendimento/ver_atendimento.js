function VerAtendimento(id){
	/** Variaveis **/
	this.id = id;
	this.btnEncaminhar = null;
	
	/** M�todos privados **/
	this._initialize = function(){
		this.btnEncaminhar = jQuery("button[name=btn_encaminhar]");
	}
	
	/**
	 *
	 */
	this._bind = function(){
		this._setListenersBtnEncaminhar();
	}
	
	this._sync = function(){
	
	}
	
	/** Implementa��es privadas **/	
	this._setListenersBtnEncaminhar = function(){
		this.btnEncaminhar.click(function(){
			console.log("Clicou!");
		});
	}
	
	/** M�todos publicos **/
	this.render = function(){
		this._bind();
		this._sync();
	}
	
	/** M�todos executados ao instanciar **/
	this._initialize();
}