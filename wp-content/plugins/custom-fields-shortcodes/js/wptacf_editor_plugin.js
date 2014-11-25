// THIS IS NOT NEEDED?

var types_url;

(function() {

    
    tinymce.create('tinymce.plugins.wptacf', {
        
        init : function(ed, url){
            wptacf_url = url;
        },

        createControl : function(n, cm){
            switch(n) {
                case 'types':
                    var c = cm.createMenuButton('wptacf_button', {
                             title : button_title,
                             image : wptacf_url + '/../images/logo-20.png',
                             icons : false
                    });
                    
                    c.onRenderMenu.add(function(c, m) {
                        
                        c = icl_editor_add_menu(c, m, wp_editor_addon_wptacf);
                    });

                    // Return the new menu button instance
                    return c;
                    
                default:
                    return 0;
            }
        }

    });

    tinymce.PluginManager.add('wptacf', tinymce.plugins.wptacf);
    
})();
