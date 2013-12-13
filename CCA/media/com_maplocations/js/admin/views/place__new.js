/**
 * @package   com_maplocations
 * @copyright Copyright (C) 2013 joocode. All rights reserved.
 * @license   GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link      http://www.joocode.com
 */

(function() {
  'use strict';

  App.PlacesNewView = App.PlaceFormView.extend({

    didInsertElement: function() {

      this.set('controller.content', App.Place.create({
        status: "1"
      }));

      this.set('contentBinding', this.get('controller.content'));
      this._super();
    },
  });

}());
