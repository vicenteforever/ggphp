Ext.define('dms.model.music', {
	extend: 'Ext.data.Model',
	fields: [
		{ name: 'file', type: 'string' },
		{ name: 'title', type: 'string'},
	]
});
Ext.define('dms.music', {
	xtype:'mymusic',
	extend: 'Ext.Panel',
	config:{
		title:'音乐',
		iconCls:'home',
		layout:'fit',
		items:[{
			xtype:'nestedlist',
			title:'我的音乐',
			store: new Ext.data.TreeStore({
				model:'dms.model.music',
				root:{},
				proxy:{
					type:'ajax',
					url:'ajax/music'
				}
			}),
			displayField:'title',
			listeners:{
				leafitemtap: function(list, index, item){
					var file = list.getStore().getAt(index).data.file;
					PlayMusic(file);
				}
			}
		}],
	}
});