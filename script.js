$(document).ready(function(e){
	$("#urls").val("dfuyh");
	/*START CSS*/
	$("#mapme_op_short").css("width","400px");
	$("#mapme_op_short").css("height","150px");
	/*END CSS*/
	$("#mapme_height_v").val(600);
	$("#mapme_width_v").val(100);
	$("#mapme_map_id").click(function(){$("#mapme_map_id").attr("placeholder"," ");});
	$("#mapme_create_short").click(function(){
		var url	=	$("#mapme_map_id").val();
		if(url)
		{
			var str = $("#mapme_map_id").val();
			var test	=	str.search("/");
			if(test && test>0)
			{
				var res = str.split("mapme.com/");
				if(res[1])
				{
					var map_id	=	res[1];
					var height_unit	=	$("#units_mapme_h").val();
					var width_unit	=	$("#units_mapme_w").val();
					var height	=	$("#mapme_height_v").val();
					var width	=	$("#mapme_width_v").val();
					if(height && width && !isNaN(width) && !isNaN(height) && map_id)
					{
						var shortcode	=	"[mapme id='"+map_id+"' height='"+height+""+height_unit+"' width='"+width+""+width_unit+"']";	
						$("#mapme_op_short").val(shortcode);	
						return false;
					}
				}
				else
				{
					alert("Please Enter a Valid Url.");
					$("#mapme_map_id").focus();
				}
			}
			else
			{
				var map_id	=	$("#mapme_map_id").val();
				var height_unit	=	$("#units_mapme_h").val();
				var width_unit	=	$("#units_mapme_w").val();
				var height	=	$("#mapme_height_v").val();
				var width	=	$("#mapme_width_v").val();
				if(height && width && !isNaN(width) && !isNaN(height) && map_id)
				{
					var shortcode	=	"[mapme id='"+map_id+"' height='"+height+""+height_unit+"' width='"+width+""+width_unit+"']";	
					$("#mapme_op_short").val(shortcode);	
					return false;
				}
			}
		}
		else
		{
			$("#mapme_map_id").focus();
			return false;
		}
		return false;
	});
	$("#copytoclip").click(function() {
		$("#mapme_op_short").select();
		return false;
	});
	return false;
});
