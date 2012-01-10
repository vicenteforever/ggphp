Ext.define('AM.store.MainMenus', {
    extend: 'Ext.data.TreeStore',
    model: 'AM.model.MainMenu',

    root: {
        expanded: true
    },
    proxy: {
        type: 'ajax',
        url: 'js/data/mainmenu.json'
    }

});

