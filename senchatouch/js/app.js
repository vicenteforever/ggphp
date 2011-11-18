Ext.setup({ 

	tabletStartupScreen: 'tablet_startup.png', 
	icon: 'icon.png', 
	glossOnIcon: true, 

	onReady: function() { 

		var header = new Ext.Toolbar({});
		var slider = new Ext.Panel({
			dock:'bottom',
			items:[{
            xtype   : 'sliderfield',
            value   : 5,
            minValue: 0,
            maxValue: 10
            }]
		});
		var control = new Ext.Toolbar({
			dock:'bottom'
		});

		var sidebar = new Ext.Panel({ 
			flex:1,
			dock:'left',
			scroll:true,
			style:'border-right:1px solid #ccc', 
			html: "The.", 
			width: 200
		});

		var main = new Ext.Panel({ 
			flex: 1, 
			scroll: true,
			html: "SFF<br><br><br><br><br><br><br><br><br><br>2011/11/18SD"
		}); 

		rootPanel = new Ext.Panel({ 
			fullscreen:true, 
			layout: 'card', 
			items:[main],
			dockedItems:[header,control,slider, sidebar]
		});

	}
});