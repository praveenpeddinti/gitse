
<script>
window.addEventListener('load', function(){
  var mapOptions = {
    //center: new google.maps.LatLng(-34.397, 150.644),
    zoom: 8,
    scrollwheel: false,
    mapTypeId: google.maps.MapTypeId.<?php echo $settings->general->mapType ?>,
    panControl: <?php echo $settings->controls->pan ?>,
    zoomControl: <?php echo $settings->controls->zoom ?>,
    mapTypeControl: <?php echo $settings->controls->mapType ?>,
    scaleControl: <?php echo $settings->controls->scale ?>,
    streetViewControl: <?php echo $settings->controls->streetView ?>,
    overviewMapControl: <?php echo $settings->controls->overviewMap ?>
  };

  var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);

  <?php $count = 0 ?>

  var markers = [];
  var latlngbounds = new google.maps.LatLngBounds();
  var infowindow = new google.maps.InfoWindow();

  <?php
  $customMarker = false;
  if (file_exists(JPATH_ROOT.'/images/custom_marker.png')) $customMarker = true;
  ?>

  // Enable the visual refresh
  <?php if ($settings->general->visualRefresh == '1') : ?>
    google.maps.visualRefresh = true;
  <?php endif ?>

  <?php $i = 0 ?>
  <?php foreach ($places as $place) : ?>
    <?php if ($place->status == '1' && $place->latitude) : ?>
      var latLng<?php echo $place->id?> = new google.maps.LatLng(<?php echo $place->latitude?>, <?php echo $place->longitude?>);

      var marker<?php echo $place->id?> = new google.maps.Marker({
        position: latLng<?php echo $place->id?>,
        value: <?php echo $place->id?>,
        title: "<?php echo addslashes($place->title)?>",
        draggable: false,
        map: map,
        animation: google.maps.Animation.DROP
      });

      <?php if ($customMarker) : ?>
        marker<?=$place->id?>.setIcon('http://<?=$_SERVER['HTTP_HOST'].JURI::root(1)?>/images/custom_marker.png');
      <?php endif ?>

      latlngbounds.extend(latLng<?php echo $place->id?>);
      markers.push(marker<?php echo $place->id?>);
      latlngbounds.extend(latLng<?php echo $place->id?>);

      //var contentString<?php echo $place->id?> = '<div id="content"><a href="'+marker<?php echo $place->id?>.url+'">'+marker<?php echo $place->id?>.title+'</a></div>';
      var contentString<?php echo $place->id?> = '<div><strong>'+marker<?php echo $place->id?>.title+'</strong><p><?php echo addslashes(nl2br(str_replace("\r\n","<br />",$place->description)))?></p></div>';

      google.maps.event.addListener(marker<?php echo $place->id?>, 'click', function() {
        //console.log(marker<?php echo $place->id?>);
        map.panTo(latLng<?php echo $place->id?>);
        if (infowindow) infowindow.close();
        infowindow.setContent(contentString<?php echo $place->id?>);
        infowindow.open(map, marker<?php echo $place->id?>);
      });
    <?php endif ?>
  <?php endforeach ?>

  <?php if ($settings->clusters->enable != '1') : ?>
      var clusterOptions = {
        maxZoom: -1
      }
  <?php else : ?>
      var clusterOptions = {
        gridSize: <?php echo $settings->clusters->size ?>,
        maxZoom: <?php echo $settings->zoom->level ?>
      }
  <?php endif ?>

  var markerCluster = new MarkerClusterer(map, markers, clusterOptions);

  google.maps.event.addListener(map, 'zoom_changed', function() {
    if (infowindow) infowindow.close();
  });

  map.setCenter(latlngbounds.getCenter());
  <?php if ($settings->zoom->auto == '0') : ?>
    map.setZoom(<?php echo $settings->zoom->level ?>);
  <?php else : ?>
    <?php if (count($places) == 1 && $settings->zoom->maxZoom) : ?>
      map.setZoom(<?php echo $settings->zoom->maxZoom ?>);
    <?php else : ?>
      map.fitBounds(latlngbounds);
    <?php endif ?>
  <?php endif ?>

}, false);
</script>

<div class="maplocations">
  <?php if (count($places)) : ?>
    <?php $itemid = ''; ?>
    <div id="map_canvas" style="width: <?php echo $settings->general->width ?>px; height: <?php echo $settings->general->height ?>px"></div>
  <?php endif; ?>
</div>
