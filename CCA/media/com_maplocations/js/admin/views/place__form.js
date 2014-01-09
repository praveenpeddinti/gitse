/**
 * @package   com_maplocations
 * @copyright Copyright (C) 2013 joocode. All rights reserved.
 * @license   GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link      http://www.joocode.com
 */

(function() {
  'use strict';

  App.PlaceFormView = App.CommonView__FormView.extend({
    singularName: 'place',
    pluralName: 'places',
    model: App.Place,
    templateName: 'place/form',
    fieldsRequired: [
      {id: 'title', desc: 'A title'},
      {id: 'address', desc: 'An address'},
      {id: 'latitude', desc: 'An actual address'},
      {id: 'map_id', desc: 'A map'},
    ],
    files: [],

    selectValues: {
      maps: [],
      status: [
        Ember.Object.create({label: "Published", value: "1"}),
        Ember.Object.create({label: "Unpublished", value: "0"})
      ]
    },

    _generateMapsList: function _generateMapsList() {
      var that = this;

      var mapId = that.get('controller.content.map_id');
      that.set('controller.content.map_id', mapId);

      var mapsController = this.get('controller').controllerFor('maps');
      mapsController.findAll(function() {
        var content = mapsController.content;
        var i = 0;
        var maps = [];

        while (i < content.length) {
          maps.pushObject(Ember.Object.create({label: content[i].title, value: content[i].id}));

          if (mapId === content[i].id) {
            Em.run.later(function() {
              jQuery("#select__map").val(mapId);
            }, 400);
          }

          i++;
        }

        that.set('selectValues.maps', maps);

        if (!that.get('controller.content.map_id')) {
          if (maps.length === 1) {
            that.set('controller.content.map_id', maps[0]);
          }
        }

      });
    },

    didInsertElement: function() {
      var that = this;
      this._super();
      this._generateMapsList();
      this._initializeMap();
      this._setPageTitle('Add new place');
    },

    _initializeMap: function() {
      var that = this;
      var latitude = 51.528868434293244;
      var longitude = -0.10179429999993772;
      var place = this.get('controller.content');

      if (place && place.latitude && place.longitude) {
        latitude = place.latitude;
        longitude = place.longitude;
      }

      var location = new google.maps.LatLng(latitude, longitude);

      App.gmap = new GMaps({
        el: '#map',
        lat: latitude,
        lng: longitude,
        zoom: 10,
        zoomControl : true,
        zoomControlOpt: {
          style : 'SMALL',
          position: 'TOP_LEFT'
        },
        panControl : false,
        streetViewControl : false,
        mapTypeControl: false,
        overviewMapControl: false
      });

      var geocoder = new google.maps.Geocoder();

      var marker = new google.maps.Marker({
        map: App.gmap.map,
        draggable: true,
        position: location
      });

      jQuery('#address').autocomplete({
        //This bit uses the geocoder to fetch address values
        source: function(request, response) {
          geocoder.geocode( {'address': request.term }, function(results, status) {
              response(jQuery.map(results, function(item) {
                return {
                  label:  item.formatted_address,
                  value: item.formatted_address,
                  latitude: item.geometry.location.lat(),
                  longitude: item.geometry.location.lng()
                }
              }));
          })
        },

        //This bit is executed upon selection of an address
        select: function(event, ui) {
          place.set('latitude', ui.item.latitude);
          place.set('longitude', ui.item.longitude);
          place.set('latlng', ui.item.latitude+','+ui.item.longitude);

          var location = new google.maps.LatLng(ui.item.latitude, ui.item.longitude);
          marker.setPosition(location);
          App.gmap.map.setCenter(location);
        }
      });

      //Add listener to marker for reverse geocoding
      google.maps.event.addListener(marker, 'drag', function() {
        geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
            if (results[0]) {
              place.set('address', results[0].formatted_address);
              place.set('latitude', marker.getPosition().lat());
              place.set('longitude', marker.getPosition().lng());
              place.set('latlng', marker.getPosition().toUrlValue());
            }
          }
        });
      });

    }

  });

}());
