Ext.regController("dms", {

    list: function() {
		this.listview = this.render({xtype:'htmlpage',url:'test.html'},Ext.getBody()).down('.loansList');
			console.log('ok');
    }


});