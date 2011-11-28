Ext.application({
	name: 'extjs',
	launch: function(){
		Ext.create('Ext.container.Viewport', {
			layout: 'fit',
			items:[{
				title: 'Hello Ext',
				html: 'Hello Ext Application',
			}]
		});
	}
});