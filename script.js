// jQuery noConflict wrapper:
(function($) {
 // $() will work here
 
 // James Padolsey jQuery filter
 $.expr[':'].regex = function(elem, index, match) {
    var matchParams = match[3].split(','),
        validLabels = /^(data|css):/,
        attr = {
            method: matchParams[0].match(validLabels) ? 
                        matchParams[0].split(':')[0] : 'attr',
            property: matchParams.shift().replace(validLabels,'')
        },
        regexFlags = 'ig',
        regex = new RegExp(matchParams.join('').replace(/^s+|s+$/g,''), regexFlags);
    return regex.test(jQuery(elem)[attr.method](attr.property));
} // End  James Padolsey jQuery filter
 
	 $(document).ready( function(){
	 /* do something */
	 
$.each( jel_spn_params, function( key, value ) {
	//console.log(value.plugin_name);
    //sum += value;
	/*$.each( value, function( key, value ) {
		a = key + " = " + value;
	});*/
	//console.log( key ); 
	var plugin = value;
	var plugin_name_in_href = $(":regex(href," + plugin.plugin_name + ")");		
	//console.log( jel_spn_params[key].title ); 
		$.each( plugin_name_in_href, function( key, value ) {
				//console.log( p ); 
				$(this).attr('title','');
				$( this ).tooltip({
					  content: plugin.title
				});
		});		
});
		
	






//var elementTitle = $('#test').prop('title');
		//$( ".jel" ).tooltip( "option", "content", "Blah title!" );
		//alert(elementTitle);
		//$( document ).tooltip();
	});//end document.ready
})(jQuery);