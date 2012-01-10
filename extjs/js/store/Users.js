Ext.define('AM.store.Users', {
    extend: 'Ext.data.Store',
    model: 'AM.model.User',
    autoLoad: true,
	
    proxy:{
        type: 'ajax',
        url: 'js/data/users.json'
    }


});