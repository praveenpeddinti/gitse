/**
 * @package   com_maplocations
 * @copyright Copyright (C) 2013 joocode. All rights reserved.
 * @license   GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link      http://www.joocode.com
 */

(function() {
  'use strict';

  App.MapFormView = App.CommonView__FormView.extend({
    singularName: 'map',
    pluralName: 'maps',
    model: App.Map,
    templateName: 'map/form',
    fieldsRequired: ['title'],
    files: [],

    selectValues: {
      maps: [],
      status: [
        Ember.Object.create({label: "Published", value: "1"}),
        Ember.Object.create({label: "Unpublished", value: "0"})
      ]
    },

    didInsertElement: function() {
      var that = this;
      this._super();
      this._setPageTitle('Add new map');
    }

  });

}());
