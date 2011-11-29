Ext.define('AM.view.user.List', {
	extend: 'Ext.grid.Panel',
	alias: 'widget.userlist',

	title: 'All Users',
	store: 'Users',
	tbar:{
		xtype:'toolbar',
		items:[
			{text:'sdfds',iconCls: 'user'},
			{text:'sdfds'},
			{text:'sdfds'},
			{text:'sdfds'},
			{text:'sdfds'}
		]
	},
	initComponent: function(){
		this.columns = [
			{header:'Name', dataIndex:'name', flex:1},
			{header:'Email', dataIndex:'email', flex:1}
		];
		
		this.callParent(arguments);
	}


});