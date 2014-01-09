/**
 * @package   com_maplocations
 * @copyright Copyright (C) 2013 joocode. All rights reserved.
 * @license   GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link      http://www.joocode.com
 */

(function() {
  'use strict';

  App.Router.map(function() {
    this.route('places', { path: '/' });
    this.route('places');
    this.route('places.new', { path: "/places/new" });
    this.route('places.edit', { path: "/places/:place_id" });

    this.route('maps');
    this.route('maps.new', { path: "/maps/new" });
    this.route('maps.edit', { path: "/maps/:map_id" });

    this.route('settings');
  });

  App.PlacesEditRoute = Ember.Route.extend({
    model: function(params) {
      var that = this;
      return jQuery.getJSON('index.php?option=com_maplocations&view=place&id=' + params.place_id + '&format=json')
      .then(function(item) {
        item = that.controllerFor('places').preprocess(item);
        return App.Place.create(item);
      });
    }
  });

  App.MapsEditRoute = Ember.Route.extend({
    model: function(params) {
      var that = this;
      return jQuery.getJSON('index.php?option=com_maplocations&view=map&id=' + params.map_id + '&format=json')
      .then(function(item) {
        item = that.controllerFor('maps').preprocess(item);
        return App.Map.create(item);
      });
    }
  });

  App.Router.reopen({
    didTransition: function(infos) {
      jQuery('#toolbar-help button').popover('hide');
      this._super(infos);
    }
  })

}());
