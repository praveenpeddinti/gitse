/**
 * @package   com_maplocations
 * @copyright Copyright (C) 2013 joocode. All rights reserved.
 * @license   GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link      http://www.joocode.com
 */

(function() {
  'use strict';

  App.PlacesController = App.CommonController.extend({
    resourceType: App.Place,
    filter: {},

    filteringObserver: function() {
      this.findAll();
    }.observes(
      'this.filter.status',
      'this.filter.ordering',
      'this.filter.direction',
      'this.filter.limitstart',
      'this.filter.map_id'
    ),

    preprocess: function(item) {
      var that = this;
      var mapsController = this.controllerFor('maps');

      if (mapsController.content.length === 0) {
        mapsController.findAll();

        jQuery.when(App.DeferredHelper.arrayContainsElements('content', mapsController))
         .then(function() {
          item.set('mapName', mapsController.content.filterProperty('id', item.map_id).get('firstObject.title'));
        });
      } else {
        item.set('mapName', mapsController.content.filterProperty('id', item.map_id).get('firstObject.title'));
      }

      return item;
    }
  });

}());
