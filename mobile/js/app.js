Ext.define('Movie', {
	extend: 'Ext.data.Model',
	fields: [
		{ name: 'id', type: 'string' },
		{ name: 'aliasname', type: 'string' },
		{ name: 'subkind', type: 'string' },
		{ name: 'region', type: 'string' },
		{ name: 'language', type: 'string' },
		{ name: 'year', type: 'string' },
		{ name: 'recommend', type: 'string' },
		{ name: 'rank', type: 'string' },
		{ name: 'dir', type: 'string' },
	]
});

var moviestore = Ext.create('Ext.data.Store', {
	model: 'Movie',
	proxy: {
		type: 'ajax',
		url : 'ajax/movielist',
		reader: 'json'
	},
	autoLoad: true
});


Ext.application({

	name:'Sencha',

	launch:function(){

		Ext.create('dms.Detail', {
			id:'detail',
			listeners:{
				hideanimationstart:function(){
					this.parentList.deselectAll();
				}
			}
		});

		Ext.create('Ext.Panel', {
			id:'test',
			html:'hello world',
		});


		var home = Ext.create('Ext.Panel', {
			title:'首页',
			iconCls:'home',
			items:[{
				xtype:'toolbar',
				title:'首页',
				docked:'top',
			}, {
				xtype:'panel',
					html:'aaaaaa',
					iconCls:'home',
					title:'test'
			}],
			scroll:true
		});
		var movie = Ext.create('Ext.Panel', {
			title:'电影',
			iconCls:'home',
			layout:'fit',
			items:[{
				xtype:'toolbar',
				title:'私人影院',
				docked:'top',
				items:[{
					handler:function(){
						var list = Ext.getCmp('movielist');
						list.getStore().load();
						list.refresh();
					},
					text:'刷新',
				},]
			}, {
				id:'movielist',
				xtype:'list',
				title:'movie list',
				itemTpl:'<div style="float:left"><h1>{aliasname} {recommend}</h1><p>{year} {region} {language } {subkind} {memo}</p></div><div align=right style="border:1px solid red;width:50px;height:50px;float:right" onclick="alert(123)"></div>',
				store:moviestore,
				listeners:{
					itemtap:function(list, idx, item, e){
						var detail = Ext.getCmp('detail')
						detail.parentList = list;
						detail.setWidth(document.width/2);
						detail.load(list.getStore(idx).getAt(idx).data.id);
						detail.show();
					}
				},
			}],
		});
		var video = Ext.create('Ext.Panel', {
			title:'视频',
			iconCls:'home',
			items:[{
				xtype:'toolbar',
				title:'视频欣赏',
				docked:'top',
			}, {
				xtype:'panel',
				html:'homepage',
			}],
			scroll:true
		});
		var music = Ext.create('Ext.Panel', {
			title:'音乐',
			iconCls:'home',
			items:[{
				xtype:'toolbar',
				title:'音乐欣赏',
				docked:'top'
			}, {
				xtype:'panel',
				html:'homepage',
			}],
			scroll:true
		});
		var smarthome = Ext.create('Ext.Panel', {
			title:'智能',
			iconCls:'home',
			items:[{
				xtype:'toolbar',
				title:'智能控制',
				docked:'top',
			}, {
				xtype:'panel',
				html:'homepage',
			}],
			scroll:true
		});


		var tab = Ext.create("Ext.TabPanel", {
			fullscreen:true,
			tabBarPosition:'bottom',
			items:[movie, video, music, smarthome],
		});

	}

});