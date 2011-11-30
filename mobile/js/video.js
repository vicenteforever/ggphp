Ext.define('dms.model.video', {
	extend: 'Ext.data.Model',
	fields: [
		{ name: 'file', type: 'string' },
		{ name: 'title', type: 'string'},
	]
});
Ext.define('dms.video', {
	xtype:'myvideo',
	extend: 'Ext.Panel',
	config:{
		title:'视频',
		iconCls:'home',
		layout:'fit',
		items:[{
			xtype:'nestedlist',
			title:'我的视频',
			store: new Ext.data.TreeStore({
				model:'dms.model.video',
				root:{},
				proxy:{
					type:'ajax',
					url:'ajax/video'
				}
			}),
			displayField:'title',
			listeners:{
				leafitemtap: function(list, index, item){
					var file = list.getStore().getAt(index).data.file;
					PlayVideo(file);
				}
			}
		}],
	}
});