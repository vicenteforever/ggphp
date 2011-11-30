Ext.define('dms.light', {
	xtype:'mylight',
	extend: 'Ext.Panel',
	config:{
		title:'灯光',
		iconCls:'home',
		layout:'fit',
		scroll:true,

		items:[{
			xtype:'toolbar',
			title:'灯光控制',
			docked:'top'
		}],
		html:'灯光面板',
	},

	load: function(){console.log(123);post('ajax/light', {},function(response){Ext.getCmp('light').setHtml(response.responseText)})}
});
