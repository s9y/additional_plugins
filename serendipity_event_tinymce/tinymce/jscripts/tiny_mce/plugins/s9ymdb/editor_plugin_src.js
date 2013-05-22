/**
 * $Id$
 * TinyMCE S9Y MediaDB Plugin
 * 
 * @author Richard Hillmann
 * @copyright Copyright © 2012, project0.de, All rights reserved.
 */
(function(){
	tinymce.PluginManager.requireLangPack('s9ymdb'); 
	tinymce.create('tinymce.plugins.s9ymdbPlugin', { 
		init: function(ed, url){	
			//add the button
			ed.addButton('s9ymdb', {
					title: ed.getLang('s9ymdb.desc'),
					cmd : 'mces9ymdb',
					image: url +  '/images/s9ymdb.gif'
					}
			);
			
			//define the command
			ed.addCommand('mces9ymdb', function() { 
                                ed.windowManager.open({ 
                                        file : serenditpityBaseUrl + '/serendipity_admin_image_selector.php?serendipity[textarea]=' + ed.id, 
                                        width : 800, 
                                        height : 600, 
                                        inline : 0 
                                }, { 
                                        plugin_url : url // Plugin absolute URL 
                                }); 
                        }); 



		},
		createControl : function(n, cm) { 
                        return null; 
                },
		getInfo : function() { 
                        return { 
                                longname : 'TinyMCE S9Y MediaDB Plugin', 
                                author : 'Richard Hillmann', 
                                authorurl : 'http://project0.de', 
                                infourl : '', 
                                version : "1.12" 
                        }; 
                } 

	});
	tinymce.PluginManager.add('s9ymdb', tinymce.plugins.s9ymdbPlugin); 
})();


