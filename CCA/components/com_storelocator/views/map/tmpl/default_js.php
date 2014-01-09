<?php 	// no direct access
		defined('_JEXEC') or die('Restricted access'); 
		header("Content-type: application/x-javascript");
?>
	// Define Language Strings
    var NO_RESULTS			= "<?php echo JText::_( 'NO_RESULTS' ); ?>";
    var SEARCH_RESULTS_FOR 	= "<?php echo JText::_( 'SEARCH_RESULTS_FOR' ); ?>";
    var MI 					= "<?php echo JText::_( 'MI' ); ?>";
    var KM 					= "<?php echo JText::_( 'KM' ); ?>";
    var PHONE 				= "<?php echo JText::_( 'PHONE' ); ?>";
    var WEBSITE 			= "<?php echo JText::_( 'WEBSITE' ); ?>";
    var GET_DIRECTIONS 		= "<?php echo JText::_( 'GET_DIRECTIONS' ); ?>";
    var FROM_ADDRESS 		= "<?php echo JText::_( 'FROM_ADDRESS' ); ?>";
    var GO 					= "<?php echo JText::_( 'GO' ); ?>";
    var DIR_EXAMPLE 		= "<?php echo JText::_( 'DIR_EXAMPLE' ); ?>";
    var VISIT_SITE 			= "<?php echo JText::_( 'VISIT_SITE' ); ?>";
    var CATEGORY 			= "<?php echo JText::_( 'CATEGORY' ); ?>";
    var TAGS 				= "<?php echo JText::_( 'TAGS' ); ?>";
    var DID_YOU_MEAN 		= "<?php echo JText::_( 'DID_YOU_MEAN' ); ?>";
    var LIMITED_RESULTS 	= "<?php echo str_replace( '%s', substr($this->params->get('search_limit_period', '-1 Day'), 1), JText::_( 'LIMITED_RESULTS' )); ?>";
    
    //Define Boolean Parameters
    var show_all_onload = <?php echo $this->params->get( 'show_all_onload', '1' )?>;
    var map_auto_zoom = <?php echo $this->params->get( 'map_auto_zoom', '1' )?'true':'false'?>;  
    var map_directions  = <?php echo $this->params->get( 'map_directions', '1' )?'true':'false'?>;
    var google_suggest  = <?php echo $this->params->get( 'google_suggest', '1' )?'true':'false'?>; 
    
    
    
    // Define Additional Parameters
    var map_center_lat = <?php echo $this->params->get( 'map_center_lat', 40  )?>;
    var map_center_lon = <?php echo $this->params->get( 'map_center_lon', -100 )?>;
    var map_default_zoom_level = <?php echo $this->params->get( 'map_default_zoom_level', 3 )?>;
    var catsearch_enabled  = <?php echo $this->params->get( 'catsearch_enabled', 1 )?'true':'false'?>;
    var featsearch_enabled  = <?php echo $this->params->get( 'featsearch_enabled', 1 )?'true':'false'?>;
    var tagsearch_enabled  = <?php echo (int)$this->params->get( 'tag_mode', 2 )>0?'true':'false'?>;
    var map_units = <?php echo $this->params->get( 'map_units', 1 )?>;
    var isModSearch = <?php echo (bool)JRequest::getVar('mod_storelocator_search', 0, 'get','BOOLEAN')?'true':'false'?>;
    var base_country = "<?php echo $this->params->get( 'base_country', '' )?>";
    var fix_jquery  =  (('undefined' != typeof jQuery) && <?php echo $this->params->get( 'fix_jquery', 0 )?'true':'false'?>);
    var hide_list_onload  = <?php echo $this->params->get( 'hide_list_onload', 0 )?'true':'false'?>;
    var list_enabled  = <?php echo $this->params->get( 'list_enabled', 1 )?'true':'false'?>;
    var map_width  = <?php echo $this->params->get( 'map_width', 300 )?>;
    
    
    
    var menuitemid = "<?php echo $this->menuitemid;?>";
    
    var sl_settings = <?php print_r( json_encode($this->params->toArray() )); ?>
    
    var map;
    var markers = [];
    var infoWindow;
    var map_unit_text;
	var clusters;
	
	function load() {         
         
        map_unit_text = map_units ? MI : KM;
        infoWindow = new google.maps.InfoWindow();
       
        var myOptions = {
          zoom: map_default_zoom_level,
          center: new google.maps.LatLng(map_center_lat, map_center_lon),
          mapTypeId: google.maps.MapTypeId.<?php echo $this->params->get( 'map_view_state', 'ROADMAP' )?>,          
          mapTypeControlOptions: {
          	mapTypeIds: [  
            	google.maps.MapTypeId.ROADMAP,
                google.maps.MapTypeId.SATELLITE,
                google.maps.MapTypeId.HYBRID<?php echo $this->params->get( 'map_include_terrain', '0' )?', google.maps.MapTypeId.TERRAIN':''?>
            ],
            style: google.maps.MapTypeControlStyle.DEFAULT, //TODO Param
            position: google.maps.ControlPosition.TOP_RIGHT //TODO Param
          },
          scrollwheel: <?php echo $this->params->get( 'map_zoom_wheel', '1' )?'true':'false'?>
        }
       
        map = new google.maps.Map(document.getElementById("map"), myOptions);
                                      
        if (sl_settings.map_cluster_method == 'MarkerCluster')
        	clusters = new MarkerClusterer(map, [], {gridSize: 50, maxZoom: 15});
        
        if (sl_settings.map_cluster_method == 'Spiderfier')
        {
        	clusters = new OverlappingMarkerSpiderfier(map, {markersWontMove: true, markersWontHide: true});
         	
            clusters.addListener('spiderfy', function(dots) {
                for(var i = 0; i < dots.length; i ++) {
                  dots[i].setIcon('http://chart.googleapis.com/chart?chst=d_map_xpin_letter&chld=pin|+|ffee22|000000|ffff00');
                }
                infoWindow.close();
             });
             clusters.addListener('unspiderfy', function(dots) {
                for(var i = 0; i < dots.length; i ++) {
                  dots[i].setIcon(markers[i].icon_orig);
                }
             });   
        }
                                  
        if(isModSearch)
            searchLocations();
            
        if(!isModSearch && show_all_onload > 0) 
        	loadAllLocations();

    }
	

   
   function loadAllLocations() {
     if(fix_jquery)
            jQuery.noConflict();
            
   	 $('sl_map_spinner').style.display = 'inline';
     
     var catid = -1;
     var tagid = -1;
     var featstate = (show_all_onload==2)?1:0;
     
	 if (catsearch_enabled)
     {
         if (<?php echo $this->params->get( 'cat_mode', '1' ); ?>==1)
         	catid = $('catid').value;
         else {
            var cats  = $('locate_form').getElements("input[name='catid']").filter(function(e) { if(e.checked) return e; });
            var catstr = new Array();
            
            for (var i = 0; i < cats.length; i++)
            	catstr.push( cats[i].value )
                
            if (catstr.length > 0)             
            	catid = catstr.join('_');   
            else 
            	catid = 999999; 
         }
     }
     
     if (tagsearch_enabled)
     {
         if (<?php echo $this->params->get( 'tag_mode', '2' ); ?> == 1)
         	tagid = $('tagid').value;
         else {
            var tags  = $('locate_form').getElements("input[name='tagid']").filter(function(e) { if(e.checked) return e; });
            var tagstr = new Array();
            
            for (var i = 0; i < tags.length; i++)
            	tagstr.push( tags[i].value )
                
            if (tagstr.length > 0)             
            	tagid = tagstr.join('_');   
         }
     }
        
     if (featsearch_enabled && show_all_onload < 2)
     	featstate = $('featstate').value;
        
	 var searchUrl = '<?php echo JURI::root( true ); ?>/index.php?option=com_storelocator&format=feed&searchall=1&Itemid=' + menuitemid + '&catid=' + catid + '&tagid=' + tagid + '&featstate=' + featstate;
     
     <?php echo (StorelocatorHelper::isVersionGT15())?'searchViaRequest(searchUrl)':'searchViaAxax(searchUrl)'; ?>;
     
     if(fix_jquery)
        	$ = jQuery;
   }
   
   
  function searchLocations() 
  {
   	 if(fix_jquery)
            jQuery.noConflict();
     
     var address = $('addressInput').value;
     
     if (sl_settings.name_search == 1)
     	var name_search = $('name_search').value;
     else
     	var name_search = '';
     
     $('sl_map_spinner').style.display = 'inline';
	 $('sl_locate_results').innerHTML = SEARCH_RESULTS_FOR + " " + address;
     
     if (address.replace(/\s/g,"") == "" && (sl_settings.name_search == 0 || name_search.replace(/\s/g,"") == "" ) ) 
     {
     	clearLocations();
        if (show_all_onload > 0)
        	loadAllLocations();
            
        return;
     }
     
     
     if(hide_list_onload == true && list_enabled == true)
     {
     	$('sl_sidebar').style.display = '';
        $('map').style.width = (map_width - parseInt($('sl_sidebar').getStyle('width')) - parseInt($('sl_sidebar').getStyle('marginRight')) - 1) + 'px';
     }
     
     var geocoder = new google.maps.Geocoder();
     geocoder.geocode({address: address}, function(results, status) {
     	if(fix_jquery)
            jQuery.noConflict();
            
        if (status == google.maps.GeocoderStatus.OK) 
        {
            if (google_suggest && results.length > 1) { 
                var suggest = "<div class=\"sl_suggest\"><span>" + DID_YOU_MEAN + "</span><ul>";
                
                for (var i=0; i< results.length; i++) {
                    var p = results[i].geometry.location;
                    suggest += "<li><a href=\"javascript:searchLocationsNearbyLatLng(" + p.lat() + "," + p.lng() + ",'" + results[i].formatted_address + "','" + name_search + "')\">" + results[i].formatted_address + "</a></li>";
                }
                
                suggest += "</ul></div>";
                $('sl_sidebar').innerHTML = suggest;
                $('sl_map_spinner').style.display = 'none';
            } else {
                // ===== If there was a single marker =====           
                searchLocationsNear(results[0].geometry.location, name_search);
            }
        } else { //implement errors
         if (sl_settings.name_search == 1)
            searchLocationsByName(name_search);
         else
            clearLocations();
        }});
     
     if(fix_jquery)
        	$ = jQuery;
   }
   
   
   function searchLocationsNearbyLatLng(lat,lng, query, name_search)
   {
   	  var point = new google.maps.LatLng(lat, lng)
      
      $('addressInput').value = query;
      
      return searchLocationsNear(point, name_search);
   }
   
   

   function searchLocationsNear(center, name_search) 
   {
		if(fix_jquery)
            jQuery.noConflict();
            
        clearLocations(true);
        
   		var catid = -1;
        var tagid = -1;
        var featstate = (featsearch_enabled)?$('featstate').value:0;
        var radius = $('radiusSelect').value;

        if (catsearch_enabled)
        {
            if (sl_settings.cat_mode==1)
            {
            	catid = $('catid').value;
            }
            else 
            {
            	var cats  = $('locate_form').getElements("input[name='catid']").filter(function(e) { if(e.checked) return e; });
            	var catstr = new Array();
            
            	for (var i = 0; i < cats.length; i++)
            		catstr.push(cats[i].value)
            
            	if (catstr.length > 0)             
            		catid = catstr.join('_');   
            	else 
            		catid = 1000000;     
            }
        }
        
        if (tagsearch_enabled)
        {
         if (<?php echo $this->params->get( 'tag_mode', '2' ); ?> == 1)
            tagid = $('tagid').value;
         else {
            var tags  = $('locate_form').getElements("input[name='tagid']").filter(function(e) { if(e.checked) return e; });
            var tagstr = new Array();
            
            for (var i = 0; i < tags.length; i++)
                tagstr.push( tags[i].value )
                
            if (tagstr.length > 0)             
                tagid = tagstr.join('_');   
         }
        }
        
        var searchUrl = '<?php echo JURI::root( true ); ?>/index.php?option=com_storelocator&format=feed&searchall=0&Itemid=' + menuitemid + 
     				 '&lat=' + center.lat() + '&lng=' + center.lng() + '&radius=' + radius + '&catid=' + catid + '&tagid=' + tagid + '&featstate=' + featstate + '&name_search=' + encodeURIComponent(name_search);

        <?php echo (StorelocatorHelper::isVersionGT15())?'searchViaRequest(searchUrl)':'searchViaAxax(searchUrl)'; ?>;
        
        if(fix_jquery)
        	$ = jQuery;

   }
   
   
    function searchLocationsByName(name_search) 
    {
     	if(fix_jquery)
            jQuery.noConflict();
        
        clearLocations();
        
   		var catid = -1;
        var tagid = -1;
        var featstate = (featsearch_enabled)?$('featstate').value:0;
        var radius = $('radiusSelect').value;

        if (catsearch_enabled)
        {
            if (sl_settings.cat_mode==1)
            {
            	catid = $('catid').value;
            }
            else 
            {
            	var cats  = $('locate_form').getElements("input[name='catid']").filter(function(e) { if(e.checked) return e; });
            	var catstr = new Array();
            
            	for (var i = 0; i < cats.length; i++)
            		catstr.push(cats[i].value)
            
            	if (catstr.length > 0)             
            		catid = catstr.join('_');   
            	else 
            		catid = 1000000;     
            }
        }
        
        if (tagsearch_enabled)
        {
         if (<?php echo $this->params->get( 'tag_mode', '2' ); ?> == 1)
            tagid = $('tagid').value;
         else {
            var tags  = $('locate_form').getElements("input[name='tagid']").filter(function(e) { if(e.checked) return e; });
            var tagstr = new Array();
            
            for (var i = 0; i < tags.length; i++)
                tagstr.push( tags[i].value )
                
            if (tagstr.length > 0)             
                tagid = tagstr.join('_');   
         }
        }
        
       var searchUrl = '<?php echo JURI::root( true ); ?>/index.php?option=com_storelocator&format=feed&searchall=0&Itemid=' + menuitemid + 
     				 '&name_search=' + encodeURIComponent(name_search) + '&radius=' + radius + '&catid=' + catid + '&tagid=' + tagid + '&featstate=' + featstate;
                     
		<?php echo (StorelocatorHelper::isVersionGT15())?'searchViaRequest(searchUrl)':'searchViaAxax(searchUrl)'; ?>;
        
      if(fix_jquery)
        	$ = jQuery;
  	}
   
   
   
   function searchViaAxax(searchUrl)
   {
   		// Mootools v1.11
         var a = new Ajax(searchUrl,{
               method:'get',
               onComplete:function(data){
               		if(fix_jquery)
            			jQuery.noConflict();
               		
                    clearLocations();
                    
                    var xml = parseXml(data);
                    var markerNodes = xml.documentElement.getElementsByTagName("marker");
                    var bounds = new google.maps.LatLngBounds();
                    
                    var limited = xml.documentElement.getElementsByTagName("limited")[0].firstChild.nodeValue;
                	if(limited==1)
                		$('sl_sidebar').innerHTML = LIMITED_RESULTS;
                    
                    if (markerNodes.length == 0)
                        return;
                    
                    $('sl_sidebar').innerHTML = '';
                    
                    for (var i = 0; i < markerNodes.length; i++) {
                    
                        var latlng = new google.maps.LatLng(
                          parseFloat(getNodeText(markerNodes[i], 'lat')),
                          parseFloat(getNodeText(markerNodes[i], 'lng')));
                        
                        createMapMarker(latlng, markerNodes[i]);
                        createSidebarEntry(markerNodes[i], i);
        
                        bounds.extend(latlng);
                        
                    }
                    
                    if(map_auto_zoom)
                    {
                        map.setOptions( { maxZoom: sl_settings.map_max_search_zoom } );
                        map.fitBounds(bounds);
                        map.setOptions( { maxZoom: null} );
                    }
                            
                    $('sl_map_spinner').style.display = 'none';
                    
                    if(fix_jquery)
        				$ = jQuery;
               }
          }).request();
          // End 1.11 
   }
   
   
   function searchViaRequest(searchUrl)
   {
   		// Mootools v1.3
        var myRequest = new Request({
        	url: searchUrl,
        	method: 'get',
        	onRequest: function(){
        		// Future Use
        	},
        	onSuccess: function(data){
        		if(fix_jquery)
            		jQuery.noConflict();
            
            	clearLocations();
                    
                var xml = parseXml(data);
                var markerNodes = xml.documentElement.getElementsByTagName("marker");
                var bounds = new google.maps.LatLngBounds();
                
                var limited = xml.documentElement.getElementsByTagName("limited")[0].firstChild.nodeValue;
                if(limited==1)
                	$('sl_sidebar').innerHTML = LIMITED_RESULTS;

                
                if (markerNodes.length == 0)
                    return;
                
                $('sl_sidebar').innerHTML = '';
                
                for (var i = 0; i < markerNodes.length; i++) {
                
                    var latlng = new google.maps.LatLng(
                      parseFloat(getNodeText(markerNodes[i], 'lat')),
                      parseFloat(getNodeText(markerNodes[i], 'lng')));
                    
                    createMapMarker(latlng, markerNodes[i]);
                    createSidebarEntry(markerNodes[i], i);
    
                    bounds.extend(latlng);
                    
                }
                
                if(map_auto_zoom)
                {
                    map.setOptions( { maxZoom: sl_settings.map_max_search_zoom } );
                    map.fitBounds(bounds);
                    map.setOptions( { maxZoom: null} );
                }
                    
                $('sl_map_spinner').style.display = 'none';
                
                if(fix_jquery)
        			$ = jQuery;
        	},
        	onFailure: function(){
        		clearLocations();
        	}
        }).send();
   }
   
   function createMapMarker(latlng, node) 
   {	  	   
	  var mkIcon = getNodeText(node, 'markertype');

      var marker = new google.maps.Marker({
        map: map,
        position: latlng,
        icon: mkIcon,
        icon_orig: mkIcon
      });

      var html = '';
	  
      if (getNodeText(node, 'featured', 'bubble') == 'true')
        	html += '<img class="featureicon" src="<?php echo JURI::root( true ); ?>/components/com_storelocator/assets/featured.png" width="16" height="16" align="absmiddle" /></a>';
            
	  html += '<span class="marker_name">' + getNodeText(node, 'name') + '</span>';
      
      
      var distance = parseFloat(getNodeText(node, 'distance'));
      if ( distance > 0 )
      	html += ' <span class="distance">(' + distance.toFixed(1) + ' ' + map_unit_text + ')</span>';
      
      
            
	 if (getNodeText(node, 'address', 'bubble') != '') 
	  	html += '<br />' + getNodeText(node, 'address', 'bubble');
        
      if (getNodeText(node, 'fulladdress', 'bubble') != '') 
	  	html += '<br />' + getNodeText(node, 'fulladdress', 'bubble');
        
       
      if (getNodeText(node, 'phone', 'bubble') != '') 
	  	html += '<br />' + getNodeText(node, 'phone', 'bubble');
        
      if (getNodeText(node, 'category', 'bubble') != '') 
	  	html += '<br />' + CATEGORY + ': ' + getNodeText(node, 'category', 'bubble').replace(',',', ');
        
      if (getNodeText(node, 'tags', 'bubble') != '') 
	  	html += '<br />' + TAGS + ': ' + getNodeText(node, 'tags', 'bubble').replace(',',', ');
      
      if (getNodeText(node, 'custom1', 'bubble') != '') 
	  	html += '<br /><strong>' + sl_settings.cust1_label + ':</strong> ' + getNodeText(node, 'custom1', 'bubble');
        
      if (getNodeText(node, 'custom2', 'bubble') != '') 
	  	html += '<br /><strong>' + sl_settings.cust2_label + ':</strong> ' + getNodeText(node, 'custom2', 'bubble');
        
      if (getNodeText(node, 'custom3', 'bubble') != '') 
	  	html += '<br /><strong>' + sl_settings.cust3_label + ':</strong> ' + getNodeText(node, 'custom3', 'bubble');
      
      if (getNodeText(node, 'custom4', 'bubble') != '') 
	  	html += '<br /><strong>'+ sl_settings.cust4_label + ':</strong> '  + getNodeText(node, 'custom4', 'bubble');
        
      if (getNodeText(node, 'custom5', 'bubble') != '') 
	  	html += '<br /><strong>' + sl_settings.cust5_label + ':</strong> ' + getNodeText(node, 'custom5', 'bubble');
        
      if (getNodeText(node, 'url', 'bubble') != '') 
	  	html += '<br /><a href="' + getNodeText(node, 'url') + '" target="' + sl_settings.field_bubble_url_target + '">' + VISIT_SITE + ' >></a>';

        
      if (getNodeText(node, 'facebook', 'bubble') != '' || getNodeText(node, 'twitter', 'bubble') != '' || getNodeText(node, 'email', 'bubble') != '') 
      {
	  	html += '<br />';
        
        if (getNodeText(node, 'facebook', 'bubble') != '')
        	html += '<a href="' + getNodeText(node, 'facebook', 'bubble') + '" target="_blank" class="networkicon"><img src="<?php echo JURI::root( true ); ?>/components/com_storelocator/assets/facebook_16.png" width="16" height="16" align="absmiddle" /></a>';
           
        if (getNodeText(node, 'twitter', 'bubble') != '')
        	html += '<a href="http://twitter.com/' + getNodeText(node, 'twitter', 'bubble') + '" target="_blank" class="networkicon"><img src="<?php echo JURI::root( true ); ?>/components/com_storelocator/assets/twitter_16.png" width="16" height="16" align="absmiddle" /></a>';
        
        if (getNodeText(node, 'email', 'bubble') != '')
        	html += '<a href="mailto:' + getNodeText(node, 'email', 'bubble') + '" target="_blank" class="networkicon"><img src="<?php echo JURI::root( true ); ?>/components/com_storelocator/assets/email_16.png" width="16" height="16" align="absmiddle" /></a>';
             
      }
	  
	  if ( map_directions )
		html += '<br /><br /><div id="dir">' +
			'<strong>'+GET_DIRECTIONS+'</strong><br />' +
			'<form id="dirfrm" action="http://maps.google.com/maps" method="get" target="_blank">' +
			'<span class="dirsmall">'+FROM_ADDRESS+':</span><br /><input type="text" name="saddr" />' +
			'<input type="submit" value="'+GO+'" />' +
			'<br /><span class="dirsmall">'+DIR_EXAMPLE+'</span>' + 
			'<input type="hidden" name="daddr" value="' +  getNodeText(node, 'address') + '" /></form>' +
			'</div>';
            
            
            
        if (sl_settings.map_cluster_method == 'MarkerCluster')
        {
            google.maps.event.addListener(marker, 'click', function() {
                infoWindow.setContent(html);
                infoWindow.open(map, marker);
            });  
            
            clusters.addMarker(marker);
        
        } 
        else if (sl_settings.map_cluster_method == 'Spiderfier')
        {
        
        	marker.desc = html;
            clusters.addListener('click', function(marker) {
            	infoWindow.setContent(marker.desc);
            	infoWindow.open(map, marker);
            });
            clusters.addMarker(marker);
        } 
        else 
        {
            google.maps.event.addListener(marker, 'click', function() {
            	infoWindow.setContent(html);
          		infoWindow.open(map, marker);
            });     
        }
	
    	markers.push(marker);
	  
    }
	   
   function createSidebarEntry(node, num) {
      
      var entry = $(document.createElement('div'));
      var distance = parseFloat(getNodeText(node, 'distance'));
	        
      html = '';
      
      if (getNodeText(node, 'featured', 'sidebar') == 'true')
        	html += '<img class="featureicon" src="<?php echo JURI::root( true ); ?>/components/com_storelocator/assets/featured.png" width="16" height="16" align="absmiddle" /></a>';
        
       html += '<span class="location_name">' + getNodeText(node, 'name') + '</span>';
      
      if (distance>0)
      	html += ' <span class="distance">(' + distance.toFixed(1) + ' ' + map_unit_text + ')</span>';
        
      if (getNodeText(node, 'address', 'sidebar') != '') 
	  	html += '<br />' + getNodeText(node, 'address', 'sidebar');
        
      if (getNodeText(node, 'fulladdress', 'sidebar') != '') 
	  	html += '<br />' + getNodeText(node, 'fulladdress', 'sidebar');
       
      if (getNodeText(node, 'phone', 'sidebar') != '') 
	  	html += '<br />' + getNodeText(node, 'phone', 'sidebar');
        
      if (getNodeText(node, 'category', 'sidebar') != '') 
	  	html += '<br />' + CATEGORY + ': ' + getNodeText(node, 'category', 'sidebar').replace(',',', ');
        
      if (getNodeText(node, 'tags', 'sidebar') != '') 
	  	html += '<br />' + TAGS + ': ' + getNodeText(node, 'tags', 'sidebar').replace(',',', ');
        
      
      if (getNodeText(node, 'custom1', 'sidebar') != '') 
	  	html += '<br />' + sl_settings.cust1_label + ': ' + getNodeText(node, 'custom1', 'sidebar');
        
      if (getNodeText(node, 'custom2', 'sidebar') != '') 
	  	html += '<br />' + sl_settings.cust2_label + ': ' + getNodeText(node, 'custom2', 'sidebar');
        
      if (getNodeText(node, 'custom3', 'sidebar') != '') 
	  	html += '<br />' + sl_settings.cust3_label + ': ' + getNodeText(node, 'custom3', 'sidebar');
      
      if (getNodeText(node, 'custom4', 'sidebar') != '') 
	  	html += '<br />'+ sl_settings.cust4_label + ': '  + getNodeText(node, 'custom4', 'sidebar');
        
      if (getNodeText(node, 'custom5', 'sidebar') != '') 
	  	html += '<br />' + sl_settings.cust5_label + ': ' + getNodeText(node, 'custom5', 'sidebar');
        
      
        
      if (getNodeText(node, 'url', 'sidebar') != '') 
	  	html += '<br /><a href="' + getNodeText(node, 'url') + '" target="' + sl_settings.field_sidebar_url_target + '">' + VISIT_SITE + ' >></a>';
        
      if (getNodeText(node, 'facebook', 'sidebar') != '' || getNodeText(node, 'twitter', 'sidebar') != '' || getNodeText(node, 'email', 'sidebar') != '') 
      {
	  	html += '<br />';
        
        if (getNodeText(node, 'facebook', 'sidebar') != '')
        	html += '<a href="' + getNodeText(node, 'facebook', 'sidebar') + '" target="_blank" class="networkicon"><img src="<?php echo JURI::root( true ); ?>/components/com_storelocator/assets/facebook_16.png" width="16" height="16" align="absmiddle" /></a>';
           
        if (getNodeText(node, 'twitter', 'sidebar') != '')
        	html += '<a href="http://twitter.com/' + getNodeText(node, 'twitter', 'sidebar') + '" target="_blank" class="networkicon"><img src="<?php echo JURI::root( true ); ?>/components/com_storelocator/assets/twitter_16.png" width="16" height="16" align="absmiddle" /></a>';
        
        if (getNodeText(node, 'email', 'sidebar') != '')
        	html += '<a href="mailto:' + getNodeText(node, 'email', 'sidebar') + '" target="_blank" class="networkicon"><img src="<?php echo JURI::root( true ); ?>/components/com_storelocator/assets/email_16.png" width="16" height="16" align="absmiddle" /></a>';
             
      }
        	 
      entry.innerHTML = html;
      
      entry.addEvent('click', function() {
        google.maps.event.trigger(markers[num], 'click');
        
        if (sl_settings.map_cluster_method == 'Spiderfier')
        	google.maps.event.trigger(markers[num], 'click');
      });

      
      $('sl_sidebar').appendChild(entry);
    }
	
    
	window.addEvent('domready', function() 
	{
		load();

	});
    
    
    function getNodeText(node, field, location)
    {
    	var child = node.getElementsByTagName(field)[0].firstChild;
        var paramkey = 'field_' + location + '_' + field;
        
        if (location && sl_settings[paramkey] && sl_settings[paramkey] == '0')
        	return '';
                
        if (child != undefined)
        	 return child.nodeValue.trim();
        else
        	return '';

   }
    
    function parseXml(str) {
      if (window.ActiveXObject) {
        var doc = new ActiveXObject('Microsoft.XMLDOM');
        doc.loadXML(str);
        return doc;
      } else if (window.DOMParser) {
        return (new DOMParser).parseFromString(str, 'text/xml');
      }
    }
    
   function clearLocations(clear_sidebar) 
   {
        infoWindow.close();
        for (var i = 0; i < markers.length; i++) {
        	markers[i].setMap(null);
        }
        markers.length = 0;
        
        if (sl_settings.map_cluster_method == 'Spiderfier' || sl_settings.map_cluster_method == 'MarkerCluster')
        {
        	clusters.clearMarkers();	
        }	
        
        if (clear_sidebar==true)
        	$('sl_sidebar').innerHTML = '';
        else
        	$('sl_sidebar').innerHTML = NO_RESULTS;
		$('sl_map_spinner').style.display = 'none';
   }
   
   String.prototype.trim = function() {
      return this.replace(/^\s+|\s+$/g, "");
   };


 
<?php exit; // Prevent furthur output