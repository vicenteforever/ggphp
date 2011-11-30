Ext.define('AM.store.Users', {
	extend: 'Ext.data.Store',
	model: 'AM.model.User',
	autoLoad: true,
	
	proxy:{
		type: 'ajax',
		url: 'user/list',
		reader:{
			type:'json',
			root:'users',
			successProperty:'success'
		}
	}


});