/**
 * @package   com_maplocations
 * @copyright Copyright (C) 2013 joocode. All rights reserved.
 * @license   GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link      http://www.joocode.com
 */

(function() {
  'use strict';

  App.PlacesView = App.CommonView__IndexView.extend({
    templateName: "places/index",
    name: 'places',

    selectValues: {
      maps: [],
      status: [
        Ember.Object.create({label: "Published", value: "1"}),
        Ember.Object.create({label: "Unpublished", value: "0"})
      ],
    },

    didInsertElement: function() {
      var that = this;
      this._super();
      this._generateMapsList();
    },

    _generateMapsList: function _generateMapsList() {
      var that = this;

      var mapId = that.get('controller.filter.map_id');

      var mapsController = this.get('controller').controllerFor('maps');
      mapsController.findAll();

      jQuery.when(App.DeferredHelper.arrayContainsElements('content', mapsController))
       .then(function() {

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
      });
    }

  });
}());
