/**
 * @package   com_maplocations
 * @copyright Copyright (C) 2013 joocode. All rights reserved.
 * @license   GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link      http://www.joocode.com
 */

(function() {
  'use strict';

  App.CommonView__FormView = App.CommonView.extend({
    photos: [],

    didInsertElement: function() {
      this._super();
      this._setupDescriptionEditor();
    },

    transitionToList: function() {
      App.Router.router.transitionTo(this.pluralName);
    },

    transitionToNew: function() {
      App.Router.router.transitionTo(this.pluralName + '.new');
    },

    save: function() {
      this._save();
    },

    saveAndClose: function() {
      if (this._save()) {
        this.transitionToList();
      }
    },

    saveAndNew: function() {
      if (this._save()) {

        this.set('controller.content', this.model.create({
          status: "1"
        }));

        jQuery('#js-item-form-description').setCode('');
        this.transitionToNew();
      }
    },

    _save: function() {
      var that = this;
      var item_id, i = 0;

      while (i < this.fieldsRequired.length) {
        /** validation **/
        if (typeof this.fieldsRequired[i] === 'object') {
          var field = this.get('controller.content.' + this.fieldsRequired[i].id);

          if (!field) {
            alert(this.fieldsRequired[i].desc + ' is required');
            return;
          }

        } else {
          var field = this.get('controller.content.' + this.fieldsRequired[i]);

          if (!field) {
            alert(this.fieldsRequired[i] + ' is required');
            return;
          }

        }

        i++;
      }

      /** editor special case **/
      if (jQuery('#js-item-form-description').length > 0) {
        this.set('controller.content.description', jQuery('#js-item-form-description').getCode());
      }
      this.get('controller.content').saveResource(function(item_id) {
        App.showSuccessMessage({
          title: 'Success!',
          text: 'Item saved'
        });
      });

      return true;
    },

    _setupDescriptionEditor: function _setupDescriptionEditor() {
      jQuery('#js-item-form-description').redactor({ minHeight: 200 }); //initialize editor
      if (this.get('controller.content.description')) {
        jQuery('#js-item-form-description').setCode(this.get('controller.content.description'));
      }
    }

  });
}());
