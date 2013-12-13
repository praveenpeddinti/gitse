/**
 * @package   com_maplocations
 * @copyright Copyright (C) 2013 joocode. All rights reserved.
 * @license   GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link      http://www.joocode.com
 */

(function() {
  'use strict';

  App.SettingsView__ZoomView = App.CommonView.extend({
    templateName: "settings/zoom",

    selectValues: {
      yesOrNo: [
        Ember.Object.create({label: 'Yes', value: '1'}),
        Ember.Object.create({label: 'No', value: '0'})
      ],
      zoomLevel: [
        Ember.Object.create({label: '1', value: '1'}),
        Ember.Object.create({label: '2', value: '2'}),
        Ember.Object.create({label: '3', value: '3'}),
        Ember.Object.create({label: '4', value: '4'}),
        Ember.Object.create({label: '5', value: '5'}),
        Ember.Object.create({label: '6', value: '6'}),
        Ember.Object.create({label: '7', value: '7'}),
        Ember.Object.create({label: '8', value: '8'}),
        Ember.Object.create({label: '9', value: '9'}),
        Ember.Object.create({label: '10', value: '10'}),
        Ember.Object.create({label: '11', value: '11'}),
        Ember.Object.create({label: '12', value: '12'}),
        Ember.Object.create({label: '13', value: '13'}),
        Ember.Object.create({label: '14', value: '14'}),
        Ember.Object.create({label: '15', value: '15'}),
        Ember.Object.create({label: '16', value: '16'}),
        Ember.Object.create({label: '17', value: '17'}),
        Ember.Object.create({label: '18', value: '18'}),
        Ember.Object.create({label: '19', value: '19'}),
        Ember.Object.create({label: '20', value: '20'}),
        Ember.Object.create({label: '21', value: '21'})
      ]
    }
  });

}());
