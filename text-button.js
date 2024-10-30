(function() {
    tinymce.PluginManager.add('gavickpro_tc_button', function( editor, url ) {
        editor.addButton( 'gavickpro_tc_button', {
            icon: 'icon gavickpro-own-icon',
			id:'faisal',
            onclick: function() {
				editor.windowManager.open( {
				title: 'Mapme Shortcode',
				body: [
				{
					type:'textbox',
					name:'map_id',
					label:'Map URL',
					id:'urls', 
					
				},
				{
					type: 'listbox', 
					name: 'unit_height', 
					label: 'Height Unit', 
					'values': [
						{text: 'Pixels', value: 'px'},
						{text: 'Percents', value: '%'}
					]
				},
				{
					type:'textbox',
					name:'height',
					label:'Height',
					value:'600'
				},
				{
					type: 'listbox', 
					name: 'unit_weight', 
					label: 'Width Unit', 
					'values': [
						{text: 'Percents', value: '%'},
						{text: 'Pixels', value: 'px'}
					]
				},
				{
					type:'textbox',
					name:'width',
					label:'Width',
					value:'100'
				}
				],
				onsubmit: function( e ) {
					var str 	=	e.data.map_id;
					var test	=	str.search("/");
					if(test && test>0)
					{
						var res = str.split("mapme.com/");
						if(res[1])
						{
							var id_map	=	res[1];
							editor.insertContent("[mapme id='"+id_map+"' height='"+e.data.height+""+e.data.unit_height+"' width='"+e.data.width+""+e.data.unit_weight+"']");
						}
						else
						{
							alert("Please Enter a Valid Url.");
						}
					}
					else
					{
						var id_map	=	e.data.map_id;
						editor.insertContent("[mapme id='"+id_map+"' height='"+e.data.height+""+e.data.unit_height+"' width='"+e.data.width+""+e.data.unit_weight+"']");
					}
				}
			});
           
		   	$("#urls").attr("placeholder","e.g. http://mapme.com/my-map");
		
		   
		   }
        });
    });
})();
