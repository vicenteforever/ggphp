Ext.define('dms.Detail', {
	extend: 'Ext.Panel',
	xtype: 'detail',

	requires: [
		// 'Kiva.view.detail.Map'
	],

	config: {
		style:'background-color#fff,overflow:hidden',
		modal: true,
		centered : false,
		hideOnMaskTap : true,

		ui: 'detail',

		// we always want the sheet to be 400px wide and to be as tall as the device allows
		width: 0,
		top: 10,
		bottom: 10,
		right: 0,

		loan: null,

		layout: {
			type: 'vbox',
			align: 'fit'
		},

		items: [
			{
				xtype: 'carousel',
				flex: 1,
				items: [
					{ items:[{}], id:'detail1', xtype: 'panel',html:'aaa',scroll:true},
				]
			},
			{
				xtype: 'button',
				text: '播放影片',
				listeners:{
					tap:function(){
						var id = Ext.getCmp('detail').movieid;
						console.log(id);
						Ext.Ajax.request({
							url: '/dmc2/ajax_movie_play.php',
							params: {id: id},
							success:function(response){
								console.log(response);
							}
						});
					}
				}
			}
		]
	},

	animationDuration: 300,

	show: function(animation) {
		this.callParent();

		Ext.Animator.run([{
			element  : this.element,
			xclass   : 'Ext.fx.animation.SlideIn',
			//direction: Ext.os.deviceType == "Phone" ? "up" : "left",
			direction: "left",
			duration : this.animationDuration
		}, {
			element : 'ext-mask-1',
			xclass  : 'Ext.fx.animation.FadeIn',
			duration: this.animationDuration
		}]);
	},

	load: function(id){
		this.movieid=id;
		Ext.Ajax.request({
			url: 'ajax/movieinfo',
			params: {id: id},
			success: function(response){
				var data = Ext.decode(response.responseText);
				Ext.getCmp('detail1').setHtml(data.intro);
			}
		});
	},

	hide: function(animation) {
		var me = this,
			mask = Ext.getCmp('ext-mask-1');

		//we fire this event so the controller can deselect all items immediately.
		this.fireEvent('hideanimationstart', this);

		//show the mask element so we can animation it out (it is already shown at this point)
		mask.show();

		Ext.Animator.run([{
			element  : me.element,
			xclass   : 'Ext.fx.animation.SlideOut',
			duration : this.animationDuration,
			preserveEndState: false,
			//direction: Ext.os.deviceType == "Phone" ? "down" : "right",
			direction: "right",
			onEnd: function() {
				me.setHidden(true);
				mask.setHidden(true);
			}
		}, {
			element : 'ext-mask-1',
			xclass  : 'Ext.fx.animation.FadeOut',
			duration: this.animationDuration
		}]);
	},

	initialize: function() {
		this.on({
			scope: this,
			hiddenchange: this.onHiddenChange
		});
	},

	onHiddenChange: function(me, hidden) {
		if (!hidden) {
			var carousel = this.down('carousel');
			carousel.setActiveItem(0);
		}
	},

});
