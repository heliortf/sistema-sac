function VerAtendimento(id){
	/** Variaveis **/
	this.id = id;
	this.btnEncaminhar = null;
	
	/** Métodos privados **/
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
	
	/** Implementações privadas **/	
	this._setListenersBtnEncaminhar = function(){
		this.btnEncaminhar.click(function(){
			console.log("Clicou!");
		});
	}
	
	/** Métodos publicos **/
	this.render = function(){
		this._bind();
		this._sync();
	}
	
	/** Métodos executados ao instanciar **/
	this._initialize();
}