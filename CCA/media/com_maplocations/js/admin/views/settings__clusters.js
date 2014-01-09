/**
 * @package   com_maplocations
 * @copyright Copyright (C) 2013 joocode. All rights reserved.
 * @license   GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link      http://www.joocode.com
 */

(function() {
  'use strict';

  App.SettingsView__ClustersView = App.CommonView.extend({
    templateName: "settings/clusters",

    selectValues: {
      yesOrNo: [
        Ember.Object.create({label: 'Yes', value: '1'}),
        Ember.Object.create({label: 'No', value: '0'})
      ],
      clusterSize: [
        Ember.Object.create({label: '40', value: '40'}),
        Ember.Object.create({label: '50', value: '50'}),
        Ember.Object.create({label: '60', value: '60'}),
        Ember.Object.create({label: '70', value: '70'}),
        Ember.Object.create({label: '80', value: '80'})
      ]
    }
  });

}());
