var Usuario = {
    /**
     * 
     * @param {object} params
     *              - string login
     *              - int id
     *              - function callback
     *              
     * @returns {void}
     */
    validarLogin: function(params){
        params['id'] = (typeof params['id'] == 'undefined' ? 'no-id' : params['id']);
        jQuery.get("admin/usuarios/existe-login/"+params['login']+"/"+params['id'], function(resposta){
            var o = $.parseJSON(resposta);            
            if(typeof params['callback'] == 'function'){
                params['callback'](o['existe']);
            }
        });
    }
};