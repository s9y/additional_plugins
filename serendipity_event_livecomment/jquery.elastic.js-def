(function($){ 
     $.fn.extend({  
         elastic: function() { 
			var mimics = new Array('paddingTop','paddingRight','paddingBottom','paddingLeft','fontSize','lineHeight','fontFamily','width','fontWeight');	
			return this.each(function() { 
         			
				if(this.type == 'textarea') {
					
					var textarea = $(this);
					var lineheight = parseInt(textarea.css('lineHeight'),10) || parseInt(textarea.css('fontSize'),'10');
					var minheight = parseInt(textarea.css('height'),10) || lineheight*3;
					var maxheight = parseInt(textarea.css('max-height'),10) || 0;
					var goalheight = 0;
					var twin = null;
					var first = true;

					if(maxheight < 0) maxheight = 0;
					
					if (!twin)
					{
						twin = $('<div />').css({'position': 'absolute','display':'none'}).appendTo(textarea.parent());
						$.each(mimics, function(){
							twin.css(this.toString(),textarea.css(this.toString()));
						});
					};
					
					function update() {
						
						var content = textarea.val().replace(/<|>/g, ' ').replace(/\n/g, '<br />').replace(/&/g,"&amp;");
						if (twin.text() != content)
						{			
							twin.html(content + "&nbsp;");
							goalheight = (twin.height()+lineheight*2 > minheight)?twin.height()+lineheight*2:minheight;
							
							if(goalheight <= maxheight || maxheight == 0){
								textarea.css({overflow: 'hidden'});
								if(Math.abs(goalheight - textarea.height()) > lineheight){
									textarea.css({'height': goalheight+(lineheight*2) + 'px'});
								}
							} else {
								textarea.css({overflow: 'auto'});
								if(maxheight != textarea.height()){
									textarea.css({'height': maxheight + 'px'});
									if(first){
										temp = textarea.val();
										textarea.val('');
										setTimeout(function() {
											textarea.val(temp);
										}, 1);
										first = false;
									}
								}
							}		
							
						}
						
					}
					textarea.css({overflow: 'auto'}).bind('focus',function() { self.periodicalUpdater = window.setInterval(function() {update();}, 400); }).bind('blur', function() { clearInterval(self.periodicalUpdater); });
					update();
					
				}
            }); 
        } 
    }); 
})(jQuery);