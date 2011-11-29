Ext.define('AM.store.Users', {
	extend: 'Ext.data.Store',
	model: 'AM.model.User',
	autoLoad: true,
	
	proxy:{
		type: 'ajax',
		api:{
			read:'/ggphp/extjs/user/list',
			update:'js/data/updateUsers.json'
		},
		reader:{
			type:'json',
			root:'users',
			successProperty:'success'
		}
	}


});