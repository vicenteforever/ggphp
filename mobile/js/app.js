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

		var tab = Ext.create("Ext.TabPanel", {
			fullscreen:true,
			tabBarPosition:'bottom',
			items:[
				{xtype:'mymovie', id:'movie'},
				{xtype:'myvideo', id:'video'},
				{xtype:'mymusic', id:'music'},
				{xtype:'mysmarthome', id:'smarthome'},
				{xtype:'mylight', id:'light'},
				{xtype:'mybookmark', id:'bookmark'}
			],

			listeners:{
				activeitemchange:function(tab,value,oldValue,e){
					window.clearInterval(this.timer);
					if(value.id=='smarthome'){
						this.timer = window.setInterval(updateProgress, 1000);
					}
					if(value.id=='light'){
						Ext.getCmp('light').load();
					}
					if(value.id=='bookmark'){
						Ext.getCmp('bookmark').load();
					}
				}
			}

		});//var tab

	}//launch function

});//application


function PlayMovie(id) {
	var url='/dmc2/ajax_movie_play.php';
	post(url, {id:id}, function(data){
		//window.setTimeout("GetPlayerInfo()", 1000);
	});
}
function PlayVideo(filename){
	var command = 'playvideo:' + filename;
	post("/dmc2/ajax_remote_mobile.php", {command:command}, function(data){
		//window.setTimeout("GetPlayerInfo()", 1000);
	});
}
function PlayMusic(filename){
	var command = 'playmusic:' + filename;
	post("/dmc2/ajax_remote_mobile.php", {command:command}, function(data){
		//window.setTimeout("GetPlayerInfo()", 1000);
	});
}

function SendPlayerCommand(param){
	var url = "/dmc2/command.php";
	post(url, {param:param}, function(data){
		//window.setTimeout("GetPlayerInfo()", 1000);
	});
	
}
function SendCommand(command){
	var url = "/dmc2/ajax_remote.php";
	post(url, {command:command}, function(data){
		//window.setTimeout("GetPlayerInfo()", 1000);
	});
}

function SendEvent(event){
	var url = "/dmc2/ajax_event.php";
	post(url, {cmd:event}, function(data){
		//window.setTimeout("GetPlayerInfo()", 1000);
	});
}

function updateProgress(){
	Ext.Ajax.request({
		url: '/dmc2/ajax_player_info.php',
		success: function(response){
			if(response.responseText!='') eval(response.responseText);
		}
	});
}

function PlayerGoto(p){
	var t1 = parsetime(totalTime);
	if(p>=0 && p <=100 && t1>10){
		var t2 = secondsToTS(Math.round(p*t1/100));
		post("/dmc2/ajax_player_position.php", {param:t2}, function(xml){});
	}
}

var totalTime;
var currentTime;
var currentTitle;
function OnStatus(param1, param2, param3, param4, param5, param6, param7, param8, param9) {
	totalTime = param6;
	var p = parseInt(parsetime(param4)/parsetime(param6)*100);
	var p = (p-100) + '%';
	Ext.get('slider').setStyle({left:p});
	var t = param2 + param1 + '<br>' + param4 + '/' + param6;
	Ext.get('slidertext').setHTML(t);
	currentTime = param4;
	currentTitle = param1;
}

//time convert to seconds
function parsetime(t){
	var tt = t.split(':');
	if (tt.length==3){
		return parseInt(tt[0], 10)*3600 + parseInt(tt[1], 10)*60 + parseInt(tt[2], 10);
	}
	else{
		return 0;
	}
}
//seconds to time
function secondsToTS(a){
	var a1 = Math.floor(a/3600);
	a -= a1*3600;
	var a2 = Math.floor(a/60);
	a -= a2*60
	var a3 = a;
	return a1 + ":" + a2 + ":" + a3;
}

function post(url, param, callback){
	Ext.Ajax.request({
		method:'POST',
		url: url,
		params: param,
		success: callback
	});
}

function light(obj){
	var status = obj.className.slice(-1);
	if(status=='1')
		status = '0';
	else
		status = '1';
	var newClassName = obj.className.slice(0, -1) + status;
	obj.className = newClassName;
	//SendEvent('clever=' + obj.id + status);
}

function bookmarkplay(file, time){
	getPlayerInfo(function(response){
		eval(response.responseText);
		if( match = response.responseText.match(/'([^']*)'\)/)){
			if(match[1]==file){
				post("/dmc2/ajax_player_position.php", {param:time}, function(xml){});
				return;
			}
		}
		console.log('playvideo' + file);
		PlayVideo(file);
		window.setTimeout(function(){
			console.log('goto' + time);
			post("/dmc2/ajax_player_position.php", {param:time}, function(xml){});
		}, 5000);
	});
	
}

function bookmarkadd(){
	getPlayerInfo(function(response){
		var match = response.responseText.match(/'([^']*)'\)/);
		if(match) {
			eval(response.responseText);
			post("ajax/bookmarksave", {title:currentTitle,file:match[1],time:currentTime}, function(response){Ext.getCmp('bookmark').load();});
		}
	});
}

function bookmarkdelete(id, obj){
	post('ajax/bookmarkdelete', {id:id}, function(response){
		Ext.removeNode(Ext.get(obj).findParent(".bookmark"));
	});
}

function getPlayerInfo(callback){
	Ext.Ajax.request({
		url: '/dmc2/ajax_player_info.php',
		success: callback
	});
}

function stopPlayer(){
	getPlayerInfo(function(response){
		var match = response.responseText.match(/'([^']*)'\)/);
		if(match) {
			eval(response.responseText);
			Ext.Msg.confirm('影片关闭提示', '你想保存当前播放进度吗？', function(button){
				//保存书签
				post("ajax/bookmarksave", {title:currentTitle,file:match[1],time:currentTime}, function(response){Ext.getCmp('bookmark').load();});
				//关闭播放器
				SendEvent('clever=playerclose');
			});
		}
	});
}
