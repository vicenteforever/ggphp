Ext.define('Movie', {
	extend: 'Ext.data.Model',
	fields: [
		{ name: 'title', type: 'string' },
		{ name: 'url', type: 'string' },
	]
});

var moviestore = Ext.create('Ext.data.Store', {
	model: 'Movie',
	proxy: {
		type: 'ajax',
		url : 'ajax/movie',
		reader: 'json'
	},
	autoLoad: true
});


Ext.application({

	name:'Sencha',

	launch:function(){
		this.home = Ext.create('Ext.Panel', {
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
		this.movie = Ext.create('Ext.Panel', {
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
				itemTpl:'{title}<br>{url}',
				store:moviestore,
				listener:{itemtap:function(){console.log(123)}},
			}],
			scroll:true
		});
		this.video = Ext.create('Ext.Panel', {
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
		this.music = Ext.create('Ext.Panel', {
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
		this.smarthome = Ext.create('Ext.Panel', {
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
		this.tab = Ext.create("Ext.TabPanel", {
			fullscreen:true,
			tabBarPosition:'bottom',
			items:[this.movie, this.video, this.music, this.smarthome,],
		});

	}

});