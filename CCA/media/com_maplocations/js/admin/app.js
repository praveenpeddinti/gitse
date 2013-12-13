/**
 * @package   com_maplocations
 * @copyright Copyright (C) 2013 joocode. All rights reserved.
 * @license   GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link      http://www.joocode.com
 */

var App = Ember.Application.create({
  rootElement: '#ember',
  LOG_TRANSITIONS: true,
  LOG_VIEW_LOOKUPS: true,
  LOG_ACTIVE_GENERATION: true,
});

if (!Object.keys) {
  Object.constructor.prototype.keys = function(o) {
    var aKeys = [];
    for (var i in o) {
      if (o.hasOwnProperty(i)) {
        aKeys.push(i);
      }
    }
    return aKeys;
  };
}

App.reopen({

  ready: function ready() {
    this.loadSettings();

    setInterval(function() { //prevent timeout
      jQuery.get('index.php');
    }, 4000);
    jQuery('body>.subhead-collapse').remove();
  },

  showSuccessMessage: function(message) {
    App.set('message', {
      isSuccess: true,
      title: message.title,
      text: message.text
    });

    setTimeout(function() {
      jQuery('#message-container').slideUp('slow');
    }, 2000);

    setTimeout(function() {
      App.set('message', null);
    }, 3000);
  },

  showErrorMessage: function(message) {
    App.set('message', {
      isError: true,
      title: message.title,
      text: message.text
    });

    setTimeout(function() {
      jQuery('#message-container').slideUp('slow');
    }, 2000);

    setTimeout(function() {
      App.set('message', null);
    }, 3000);
  },

  loadSettings: function() {
    jQuery.getJSON('index.php?option=com_maplocations&view=settings&format=json')
    .success(function(response) {

      function isEmpty(obj) {
        return Object.keys(obj).length === 0;
      }

      var i = 0, item;

      if (isEmpty(response) || response == "" || response == undefined || !response || response.map_type) {
        App.restoreFactorySettings();
      } else {
        App.set('settings', JSON.parse(response.settings));
      }

    });
  },

  restoreFactorySettings: function() {
    var that = this;

    var settings = {
      general: {
        width: 800,
        height: 600,
        mapType: 'HYBRID',
        visualRefresh: '1'
      },
      controls: {
        pan: '1',
        zoom: '1',
        mapType: '1',
        scale: '1',
        streetView: '1',
        overviewMap: '1'
      },
      zoom: {
        auto: '1',
        level: '8',
        maxZoom: '8'
      },
      clusters: {
        enable: '0',
        size: '60'
      }
    };

    jQuery.ajax({
      url: 'index.php?option=com_maplocations&task=settings.save',
      data: {
        settings: JSON.stringify(settings)
      }
    })
    .success(function() {
      that.loadSettings();
    })
  },

  saveSettings: function() {
    var settings = App.get('settings');
    var i = 0;

    jQuery.ajax({
      url: 'index.php?option=com_maplocations&task=settings.save',
      data: {
        settings: JSON.stringify(settings)
      }
    })
    .success(function() {
      console.log('success');
    })
    .error(function() {
      console.log('error');
    })
  }

});
