Ext.define('dms.smarthome', {
	xtype:'mysmarthome',
	extend: 'Ext.Panel',
	config:{
		title:'智能',
		iconCls:'home',
		layout:'fit',
		scroll:true,

		items:[{
			xtype:'toolbar',
			title:'智能控制',
			docked:'top',
		},{
			xtype:'panel',
			docked:'bottom',
			layout:{pack:'center'},
			html:'<div style="width:100%;" align=center ><div onclick="PlayerGoto(Math.round(event.offsetX/this.clientWidth*100));" style="position:relative;width:80%;height:50px;border:1px solid #666;background-color:#ccc;overflow:hidden"><div id="slider" style="position:absolute;left:-50%;width:100%;height:100%;background-color:#666"></div><div style="position:absolute;left:0px;width:100%;height:100%;"><table width=100% height=100%><tr><td align=center valign=middle><div id="slidertext"></div></td></tr></table></div></div></div>',
		},{
			xtype:'container',
			docked:'bottom',
			layout:{type:'hbox', pack:'center'},
			defaults:{xtype:'button',margin:10},
			items:[
				{text:'播放', listeners:{tap:function(){SendPlayerCommand(887)}}},
				{text:'暂停', listeners:{tap:function(){SendPlayerCommand(888)}}},
				{text:'停止', listeners:{tap:stopPlayer}},
				{text:'上一音轨', listeners:{tap:function(){SendPlayerCommand(952)}}},
				{text:'下一音轨', listeners:{tap:function(){SendPlayerCommand(951)}}},
				{text:'播放下一个', listeners:{tap:function(){SendCommand('playnext')}}},
			],
		},{
			xtype:'container',
			docked:'bottom',
			layout:{type:'hbox', pack:'center'},
			defaults:{xtype:'button',margin:10},
			items:[
				{text:'音量小', listeners:{tap:function(){SendEvent('clever=onkyo:!1SLI00')}}},
				{text:'音量中', listeners:{tap:function(){SendEvent('clever=onkyo:!1SLI01')}}},
				{text:'音量大', listeners:{tap:function(){SendEvent('clever=onkyo:!1SLI02')}}},
				{text:'静音', listeners:{tap:function(){SendPlayerCommand(909)}}},
				{text:'声场THX:MOVIE', listeners:{tap:function(){SendEvent('clever=AVMVIE')}}},
				{text:'声场THX:MUSIC', listeners:{tap:function(){SendEvent('clever=AVMUSIC')}}},
			],
		},{
			xtype:'container',
			docked:'bottom',
			layout:{type:'hbox', pack:'center'},
			defaults:{xtype:'button',margin:10},
			items:[
				{text:'影院模式', listeners:{tap:function(){SendEvent('clever=CJ1')}}},
				{text:'入场模式', listeners:{tap:function(){SendEvent('clever=CJ2')}}},
				{text:'会客模式', listeners:{tap:function(){SendEvent('clever=CJ3')}}},
				{text:'讲解模式', listeners:{tap:function(){SendEvent('clever=CJ4')}}},
				{text:'全开模式', listeners:{tap:function(){SendEvent('clever=CJ5')}}},
				{text:'全关模式', listeners:{tap:function(){SendEvent('clever=CJ6')}}},
			],
		}],

	}
});
