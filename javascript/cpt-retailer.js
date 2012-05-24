jQuery(document).ready(function(){
	// Cache Elements
	var map = jQuery('.retailer-map');
	var street = jQuery('#retailer-street');
	var streetNumber = jQuery('#retailer-streetnumber');
	var zip = jQuery('#retailer-zip');
	var city = jQuery('#retailer-city');
	var country = jQuery('#retailer-country');

	// Update map
	jQuery('#retailer-address input').blur(function(){
		mapSrc = 'http://maps.google.de/maps?q=' +  jQuery.trim( street.val() + '+' + streetNumber.val() + '+' + zip.val() + '+' + city.val() + '+' + country.val() + '&output=embed' ) ;

		if ( map.attr('src') != mapSrc ) {

			if ( '' == mapSrc || 'http://maps.google.de/maps?q=++++&output=embed' == mapSrc )
				mapSrc = 'http://maps.google.de/maps?q=Fritz-Walter-Straße+1+67663+Kaiserslautern+Fritz-Walter-Stadion&output=embed';

			map.attr('src', mapSrc );

		}
	});

});
