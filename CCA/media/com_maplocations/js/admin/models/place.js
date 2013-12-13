/**
 * @package   com_maplocations
 * @copyright Copyright (C) 2013 joocode. All rights reserved.
 * @license   GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link      http://www.joocode.com
 */

(function() {
  'use strict';

  App.Place = App.CommonModel.extend({
    resourceUrl: 'index.php?option=com_maplocations',
    resourceName: 'place',
    resourceNamePlural: 'places',
    resourceProperties: [
      'id',
      'title',
      'description',
      'status',
      'address',
      'latitude',
      'longitude',
      'params',
      'map_id'
    ]
  });

}());
