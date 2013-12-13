Ember.TEMPLATES["application"] = Ember.Handlebars.template(function anonymous(Handlebars,depth0,helpers,partials,data) {
this.compilerInfo = [2,'>= 1.0.0-rc.3'];
helpers = helpers || Ember.Handlebars.helpers; data = data || {};
  var buffer = '', hashTypes, escapeExpression=this.escapeExpression;


  hashTypes = {};
  data.buffer.push(escapeExpression(helpers._triageMustache.call(depth0, "outlet", {hash:{},contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data})));
  data.buffer.push("\n");
  return buffer;
  
});

Ember.TEMPLATES["map/form"] = Ember.Handlebars.template(function anonymous(Handlebars,depth0,helpers,partials,data) {
this.compilerInfo = [2,'>= 1.0.0-rc.3'];
helpers = helpers || Ember.Handlebars.helpers; data = data || {};
  var buffer = '', stack1, hashTypes, escapeExpression=this.escapeExpression, self=this;

function program1(depth0,data) {
  
  var buffer = '', stack1, hashTypes;
  data.buffer.push("\n  ");
  hashTypes = {};
  stack1 = helpers['if'].call(depth0, "App.message.isSuccess", {hash:{},inverse:self.noop,fn:self.program(2, program2, data),contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n");
  return buffer;
  }
function program2(depth0,data) {
  
  var buffer = '', hashTypes;
  data.buffer.push("\n    <div id=\"message-container\">\n      <div ");
  hashTypes = {'class': "STRING"};
  data.buffer.push(escapeExpression(helpers.bindAttr.call(depth0, {hash:{
    'class': (":alert App.message.isSuccess:alert-success App.message.isError:alert-error")
  },contexts:[],types:[],hashTypes:hashTypes,data:data})));
  data.buffer.push("><strong>");
  hashTypes = {};
  data.buffer.push(escapeExpression(helpers._triageMustache.call(depth0, "App.message.title", {hash:{},contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data})));
  data.buffer.push("</strong> ");
  hashTypes = {};
  data.buffer.push(escapeExpression(helpers._triageMustache.call(depth0, "App.message.text", {hash:{},contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data})));
  data.buffer.push("</div>\n    </div>\n  ");
  return buffer;
  }

  data.buffer.push("<div class=\"subhead-collapse\" id=\"ember-toolbar\">\n  <div class=\"subhead\">\n    <div class=\"container-fluid\">\n      <div id=\"container-collapse\" class=\"container-collapse\"></div>\n      <div class=\"row-fluid\">\n        <div class=\"span12\">\n          <div class=\"btn-toolbar\" id=\"toolbar\">\n            <div class=\"btn-group\" id=\"toolbar-apply\">\n              <button ");
  hashTypes = {'target': "STRING"};
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "save", {hash:{
    'target': ("view")
  },contexts:[depth0],types:["STRING"],hashTypes:hashTypes,data:data})));
  data.buffer.push(" class=\"btn btn-small btn-success\">\n              <i class=\"icon-apply icon-white\">\n              </i>\n              Save\n              </button>\n            </div>\n\n            <div class=\"btn-group\" id=\"toolbar-save\">\n              <button ");
  hashTypes = {'target': "STRING"};
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "saveAndClose", {hash:{
    'target': ("view")
  },contexts:[depth0],types:["STRING"],hashTypes:hashTypes,data:data})));
  data.buffer.push(" class=\"btn btn-small\">\n              <i class=\"icon-save \">\n              </i>\n              Save &amp; Close\n              </button>\n            </div>\n\n            <div class=\"btn-group\" id=\"toolbar-save-new\">\n              <button ");
  hashTypes = {'target': "STRING"};
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "saveAndNew", {hash:{
    'target': ("view")
  },contexts:[depth0],types:["STRING"],hashTypes:hashTypes,data:data})));
  data.buffer.push(" class=\"btn btn-small\">\n              <i class=\"icon-save-new \">\n              </i>\n              Save &amp; New\n              </button>\n            </div>\n\n            <div class=\"btn-group\" id=\"toolbar-cancel\">\n              <button ");
  hashTypes = {'target': "STRING"};
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "transitionToList", {hash:{
    'target': ("view")
  },contexts:[depth0],types:["STRING"],hashTypes:hashTypes,data:data})));
  data.buffer.push(" class=\"btn btn-small\">\n              <i class=\"icon-arrow-left \">\n              </i>\n              Back\n              </button>\n            </div>\n\n            <div class=\"btn-group divider\">\n            </div>\n\n            <div class=\"btn-group\" id=\"toolbar-help\">\n              <button class=\"btn btn-small\">\n              <i class=\"icon-question-sign\">\n              </i>\n              Help\n              </button>\n            </div>\n          </div>\n        </div>\n      </div>\n    </div>\n  </div>\n</div>\n\n");
  hashTypes = {};
  stack1 = helpers['if'].call(depth0, "App.message", {hash:{},inverse:self.noop,fn:self.program(1, program1, data),contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n\n<div class=\"row js-item-form\">\n  <div class=\"span9\">\n    <div class=\"form-horizontal well\">\n\n      <div class=\"control-group\">\n        <label class=\"control-label\" for=\"js-item-form-title\">Title</label>\n        <div class=\"controls\">\n          ");
  hashTypes = {'valueBinding': "STRING",'placeholder': "STRING"};
  data.buffer.push(escapeExpression(helpers.view.call(depth0, "Ember.TextField", {hash:{
    'valueBinding': ("content.title"),
    'placeholder': ("Enter title")
  },contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data})));
  data.buffer.push("\n        </div>\n      </div>\n\n    </div>\n  </div>\n\n  <div class=\"span3\">\n    <div class=\"form-horizontal sidebar well\">\n      <div class=\"control-group\">\n        <label class=\"control-label\" for=\"js-item-form-status\">Status</label>\n        <div class=\"controls\">\n          ");
  hashTypes = {'class': "STRING",'contentBinding': "STRING",'optionValuePath': "STRING",'optionLabelPath': "STRING",'valueBinding': "STRING"};
  data.buffer.push(escapeExpression(helpers.view.call(depth0, "Ember.Select", {hash:{
    'class': ("input-medium"),
    'contentBinding': ("view.selectValues.status"),
    'optionValuePath': ("content.value"),
    'optionLabelPath': ("content.label"),
    'valueBinding': ("controller.content.status")
  },contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data})));
  data.buffer.push("\n        </div>\n      </div>\n    </div>\n  </div>\n</div>\n");
  return buffer;
  
});

Ember.TEMPLATES["maps/index"] = Ember.Handlebars.template(function anonymous(Handlebars,depth0,helpers,partials,data) {
this.compilerInfo = [2,'>= 1.0.0-rc.3'];
helpers = helpers || Ember.Handlebars.helpers; data = data || {};
  var buffer = '', stack1, stack2, hashTypes, options, escapeExpression=this.escapeExpression, helperMissing=helpers.helperMissing, self=this;

function program1(depth0,data) {
  
  
  data.buffer.push("Maps");
  }

function program3(depth0,data) {
  
  
  data.buffer.push("Places");
  }

function program5(depth0,data) {
  
  
  data.buffer.push("Settings");
  }

function program7(depth0,data) {
  
  var buffer = '', stack1, hashTypes;
  data.buffer.push("\n                  ");
  hashTypes = {'itemBinding': "STRING",'tagName': "STRING",'classNames': "STRING"};
  stack1 = helpers.view.call(depth0, "App.MapsView__SingleItemView", {hash:{
    'itemBinding': ("item"),
    'tagName': ("tr"),
    'classNames': ("row0")
  },inverse:self.noop,fn:self.program(8, program8, data),contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n                ");
  return buffer;
  }
function program8(depth0,data) {
  
  var buffer = '', stack1, hashTypes, options;
  data.buffer.push("\n                    <td class=\"order nowrap center hidden-phone\">\n                      ");
  hashTypes = {};
  data.buffer.push(escapeExpression(helpers._triageMustache.call(depth0, "item.id", {hash:{},contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data})));
  data.buffer.push("\n                    </td>\n                    <td>\n                      ");
  hashTypes = {'checkedBinding': "STRING"};
  data.buffer.push(escapeExpression(helpers.view.call(depth0, "Ember.Checkbox", {hash:{
    'checkedBinding': ("item.isSelected")
  },contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data})));
  data.buffer.push("\n                    </td>\n                    <td class=\"center\">\n                      <div class=\"btn-group\">\n                        <a class=\"btn btn-micro active\">\n                          ");
  hashTypes = {};
  options = {hash:{},contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data};
  data.buffer.push(escapeExpression(((stack1 = helpers.printStatusIcon),stack1 ? stack1.call(depth0, "item.status", options) : helperMissing.call(depth0, "printStatusIcon", "item.status", options))));
  data.buffer.push("\n                        </a>\n                      </div>\n                    </td>\n                    <td>\n                      ");
  hashTypes = {};
  data.buffer.push(escapeExpression(helpers._triageMustache.call(depth0, "item.title", {hash:{},contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data})));
  data.buffer.push("\n                    </td>\n                  ");
  return buffer;
  }

function program10(depth0,data) {
  
  var buffer = '', stack1, hashTypes;
  data.buffer.push("\n                  ");
  hashTypes = {};
  stack1 = helpers['if'].call(depth0, "view.controller.isLoading", {hash:{},inverse:self.program(13, program13, data),fn:self.program(11, program11, data),contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n                ");
  return buffer;
  }
function program11(depth0,data) {
  
  
  data.buffer.push("\n                    <tr><td></td><td></td><td colspan=\"3\"><br>Loading..<br><br></td><td></td><td></td></tr>\n                  ");
  }

function program13(depth0,data) {
  
  
  data.buffer.push("\n                    <tr><td></td><td></td><td colspan=\"3\"><br>No maps found<br><br></td><td></td><td></td></tr>\n                  ");
  }

  data.buffer.push("<div class=\"subhead-collapse\" id=\"ember-toolbar\">\n  <div class=\"subhead\">\n    <div class=\"container-fluid\">\n      <div id=\"container-collapse\" class=\"container-collapse\"></div>\n      <div class=\"row-fluid\">\n        <div class=\"span12\">\n          <div class=\"btn-toolbar\" id=\"toolbar\">\n\n            <div class=\"btn-group\" id=\"toolbar-new\">\n              <button ");
  hashTypes = {'target': "STRING"};
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "transitionToNew", {hash:{
    'target': ("view")
  },contexts:[depth0],types:["STRING"],hashTypes:hashTypes,data:data})));
  data.buffer.push(" class=\"btn btn-small btn-success\">\n                <i class=\"icon-new icon-white\"></i> New\n              </button>\n            </div>\n\n            <div class=\"btn-group\" id=\"toolbar-publish\">\n              <button ");
  hashTypes = {'target': "STRING"};
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "publishItems", {hash:{
    'target': ("view")
  },contexts:[depth0],types:["STRING"],hashTypes:hashTypes,data:data})));
  data.buffer.push(" class=\"btn btn-small\">\n                <i class=\"icon-publish\"></i> Publish\n              </button>\n            </div>\n\n            <div class=\"btn-group\" id=\"toolbar-unpublish\">\n              <button ");
  hashTypes = {'target': "STRING"};
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "unpublishItems", {hash:{
    'target': ("view")
  },contexts:[depth0],types:["STRING"],hashTypes:hashTypes,data:data})));
  data.buffer.push(" class=\"btn btn-small\">\n                <i class=\"icon-unpublish\"></i> Unpublish\n              </button>\n            </div>\n\n            <div class=\"btn-group\" id=\"toolbar-trash\">\n              <button ");
  hashTypes = {'target': "STRING"};
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "deleteItems", {hash:{
    'target': ("view")
  },contexts:[depth0],types:["STRING"],hashTypes:hashTypes,data:data})));
  data.buffer.push(" class=\"btn btn-small\">\n                <i class=\"icon-trash\"></i> Trash\n              </button>\n            </div>\n\n            <div class=\"btn-group\" id=\"toolbar-help\">\n              <button class=\"btn btn-small\">\n                <i class=\"icon-question-sign\"></i> Help\n              </button>\n            </div>\n\n          </div>\n        </div>\n      </div>\n    </div>\n  </div>\n</div>\n\n<div class=\" container-main\">\n  <section id=\"content\">\n    <!-- Begin Content -->\n    <div class=\"row-fluid\">\n      <div class=\"span12\">\n        <form action=\"/joomla3/administrator/index.php?option=com_maplocations&amp;view=products\" method=\"post\" name=\"adminForm\" id=\"adminForm\">\n          <div id=\"j-sidebar-container\" class=\"span2\">\n            <div id=\"sidebar\">\n              <div class=\"sidebar-nav\">\n                <ul id=\"submenu\" class=\"nav nav-list\">\n                  <li class=\"active\">\n                    ");
  hashTypes = {};
  options = {hash:{},inverse:self.noop,fn:self.program(1, program1, data),contexts:[depth0],types:["STRING"],hashTypes:hashTypes,data:data};
  stack2 = ((stack1 = helpers.linkTo),stack1 ? stack1.call(depth0, "maps", options) : helperMissing.call(depth0, "linkTo", "maps", options));
  if(stack2 || stack2 === 0) { data.buffer.push(stack2); }
  data.buffer.push("\n                  </li>\n                  <li>\n                    ");
  hashTypes = {};
  options = {hash:{},inverse:self.noop,fn:self.program(3, program3, data),contexts:[depth0],types:["STRING"],hashTypes:hashTypes,data:data};
  stack2 = ((stack1 = helpers.linkTo),stack1 ? stack1.call(depth0, "places", options) : helperMissing.call(depth0, "linkTo", "places", options));
  if(stack2 || stack2 === 0) { data.buffer.push(stack2); }
  data.buffer.push("\n                  </li>\n                  <li>\n                    ");
  hashTypes = {};
  options = {hash:{},inverse:self.noop,fn:self.program(5, program5, data),contexts:[depth0],types:["STRING"],hashTypes:hashTypes,data:data};
  stack2 = ((stack1 = helpers.linkTo),stack1 ? stack1.call(depth0, "settings", options) : helperMissing.call(depth0, "linkTo", "settings", options));
  if(stack2 || stack2 === 0) { data.buffer.push(stack2); }
  data.buffer.push("\n                  </li>\n                </ul>\n              </div>\n            </div>\n          </div>\n          <div id=\"j-main-container\" class=\"span10\">\n            <div id=\"filter-bar\" class=\"btn-toolbar\">\n              <div class=\"filter-search btn-group pull-left\">\n                <input type=\"text\" id=\"js-filter_search\" placeholder=\"Search by title\">\n              </div>\n              <div class=\"btn-group pull-left\">\n                <button class=\"btn\" ");
  hashTypes = {'target': "STRING"};
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "filterSearch", {hash:{
    'target': ("view")
  },contexts:[depth0],types:["STRING"],hashTypes:hashTypes,data:data})));
  data.buffer.push("><i class=\"icon-search\"></i></button>\n                <button class=\"btn\" ");
  hashTypes = {'target': "STRING"};
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "clearSearch", {hash:{
    'target': ("view")
  },contexts:[depth0],types:["STRING"],hashTypes:hashTypes,data:data})));
  data.buffer.push("><i class=\"icon-remove\"></i></button>\n              </div>\n            </div>\n            <div class=\"clearfix\"> </div>\n            <table class=\"table table-striped\" id=\"weblinkList\">\n              <thead>\n              <tr>\n                <th width=\"1%\" class=\"nowrap center hidden-phone\">\n                  <a><i class=\"icon-menu-2\"></i></a>\n                </th>\n                <th width=\"1%\">\n                  <input type=\"checkbox\" ");
  hashTypes = {'target': "STRING"};
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "checkAllItems", {hash:{
    'target': ("view")
  },contexts:[depth0],types:["STRING"],hashTypes:hashTypes,data:data})));
  data.buffer.push(">\n                </th>\n                <th width=\"1%\" class=\"center\">\n                  <a ");
  hashTypes = {'target': "STRING"};
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "filterByStatus", {hash:{
    'target': ("view")
  },contexts:[depth0],types:["STRING"],hashTypes:hashTypes,data:data})));
  data.buffer.push(">Status</a>\n                </th>\n                <th>\n                  <a ");
  hashTypes = {'target': "STRING"};
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "filterByTitle", {hash:{
    'target': ("view")
  },contexts:[depth0],types:["STRING"],hashTypes:hashTypes,data:data})));
  data.buffer.push(">\n                    Title\n                    <i class=\"icon-arrow-up-3\"></i>\n                  </a>\n                </th>\n              </tr>\n              </thead>\n              <tfoot>\n              <tr>\n                <td colspan=\"10\">\n                  <div class=\"pagination pagination-toolbar\">\n                    <input type=\"hidden\" name=\"limitstart\" value=\"0\">\n                  </div> </td>\n              </tr>\n              </tfoot>\n              <tbody>\n                ");
  hashTypes = {};
  stack2 = helpers.each.call(depth0, "item", "in", "view.controller", {hash:{},inverse:self.program(10, program10, data),fn:self.program(7, program7, data),contexts:[depth0,depth0,depth0],types:["ID","ID","ID"],hashTypes:hashTypes,data:data});
  if(stack2 || stack2 === 0) { data.buffer.push(stack2); }
  data.buffer.push("\n\n              </tbody>\n            </table>\n          </div>\n        </form>\n      </div>\n    </div>\n  </section>\n</div>\n");
  return buffer;
  
});

Ember.TEMPLATES["place/form"] = Ember.Handlebars.template(function anonymous(Handlebars,depth0,helpers,partials,data) {
this.compilerInfo = [2,'>= 1.0.0-rc.3'];
helpers = helpers || Ember.Handlebars.helpers; data = data || {};
  var buffer = '', stack1, hashTypes, escapeExpression=this.escapeExpression, self=this;

function program1(depth0,data) {
  
  var buffer = '', stack1, hashTypes;
  data.buffer.push("\n  ");
  hashTypes = {};
  stack1 = helpers['if'].call(depth0, "App.message.isSuccess", {hash:{},inverse:self.noop,fn:self.program(2, program2, data),contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n");
  return buffer;
  }
function program2(depth0,data) {
  
  var buffer = '', hashTypes;
  data.buffer.push("\n    <div id=\"message-container\">\n      <div ");
  hashTypes = {'class': "STRING"};
  data.buffer.push(escapeExpression(helpers.bindAttr.call(depth0, {hash:{
    'class': (":alert App.message.isSuccess:alert-success App.message.isError:alert-error")
  },contexts:[],types:[],hashTypes:hashTypes,data:data})));
  data.buffer.push("><strong>");
  hashTypes = {};
  data.buffer.push(escapeExpression(helpers._triageMustache.call(depth0, "App.message.title", {hash:{},contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data})));
  data.buffer.push("</strong> ");
  hashTypes = {};
  data.buffer.push(escapeExpression(helpers._triageMustache.call(depth0, "App.message.text", {hash:{},contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data})));
  data.buffer.push("</div>\n    </div>\n  ");
  return buffer;
  }

function program4(depth0,data) {
  
  
  data.buffer.push("\n            <br />No maps available. <a href=\"#/maps/new\">Add one now!</a>\n          ");
  }

  data.buffer.push("<div class=\"subhead-collapse\" id=\"ember-toolbar\">\n  <div class=\"subhead\">\n    <div class=\"container-fluid\">\n      <div id=\"container-collapse\" class=\"container-collapse\"></div>\n      <div class=\"row-fluid\">\n        <div class=\"span12\">\n          <div class=\"btn-toolbar\" id=\"toolbar\">\n            <div class=\"btn-group\" id=\"toolbar-apply\">\n              <button ");
  hashTypes = {'target': "STRING"};
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "save", {hash:{
    'target': ("view")
  },contexts:[depth0],types:["STRING"],hashTypes:hashTypes,data:data})));
  data.buffer.push(" class=\"btn btn-small btn-success\">\n              <i class=\"icon-apply icon-white\">\n              </i>\n              Save\n              </button>\n            </div>\n\n            <div class=\"btn-group\" id=\"toolbar-save\">\n              <button ");
  hashTypes = {'target': "STRING"};
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "saveAndClose", {hash:{
    'target': ("view")
  },contexts:[depth0],types:["STRING"],hashTypes:hashTypes,data:data})));
  data.buffer.push(" class=\"btn btn-small\">\n              <i class=\"icon-save \">\n              </i>\n              Save &amp; Close\n              </button>\n            </div>\n\n            <div class=\"btn-group\" id=\"toolbar-save-new\">\n              <button ");
  hashTypes = {'target': "STRING"};
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "saveAndNew", {hash:{
    'target': ("view")
  },contexts:[depth0],types:["STRING"],hashTypes:hashTypes,data:data})));
  data.buffer.push(" class=\"btn btn-small\">\n              <i class=\"icon-save-new \">\n              </i>\n              Save &amp; New\n              </button>\n            </div>\n\n            <div class=\"btn-group\" id=\"toolbar-cancel\">\n              <button ");
  hashTypes = {'target': "STRING"};
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "transitionToList", {hash:{
    'target': ("view")
  },contexts:[depth0],types:["STRING"],hashTypes:hashTypes,data:data})));
  data.buffer.push(" class=\"btn btn-small\">\n              <i class=\"icon-arrow-left \">\n              </i>\n              Back\n              </button>\n            </div>\n\n            <div class=\"btn-group divider\">\n            </div>\n\n            <div class=\"btn-group\" id=\"toolbar-help\">\n              <button class=\"btn btn-small\">\n              <i class=\"icon-question-sign\">\n              </i>\n              Help\n              </button>\n            </div>\n          </div>\n        </div>\n      </div>\n    </div>\n  </div>\n</div>\n\n");
  hashTypes = {};
  stack1 = helpers['if'].call(depth0, "App.message", {hash:{},inverse:self.noop,fn:self.program(1, program1, data),contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n\n<div class=\"row js-item-form\">\n  <div class=\"span9\">\n    <div class=\"form-horizontal well\">\n      <div class=\"control-group\">\n        <label class=\"control-label\" for=\"js-item-form-title\">Title</label>\n        <div class=\"controls\">\n          ");
  hashTypes = {'valueBinding': "STRING",'placeholder': "STRING"};
  data.buffer.push(escapeExpression(helpers.view.call(depth0, "Ember.TextField", {hash:{
    'valueBinding': ("content.title"),
    'placeholder': ("Enter title")
  },contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data})));
  data.buffer.push("\n        </div>\n      </div>\n\n      <div class=\"control-group\">\n        <label class=\"control-label\" for=\"js-item-form-title\">Address</label>\n        <div class=\"controls\">\n          ");
  hashTypes = {'valueBinding': "STRING",'placeholder': "STRING",'id': "STRING"};
  data.buffer.push(escapeExpression(helpers.view.call(depth0, "Ember.TextField", {hash:{
    'valueBinding': ("content.address"),
    'placeholder': ("Enter address"),
    'id': ("address")
  },contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data})));
  data.buffer.push("\n        </div>\n      </div>\n\n      <div class=\"control-group\">\n        <label class=\"control-label\" for=\"js-item-form-title\">Map</label>\n        <div class=\"controls\">\n          <div id=\"map\" style=\"width: 100%; height: 200px\"></div>\n        </div>\n      </div>\n\n      <div class=\"control-group\">\n        <label class=\"control-label\" for=\"js-item-form-description\">Description</label>\n        <div class=\"controls\">\n          ");
  hashTypes = {'id': "STRING"};
  data.buffer.push(escapeExpression(helpers.view.call(depth0, "Ember.TextArea", {hash:{
    'id': ("js-item-form-description")
  },contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data})));
  data.buffer.push("\n        </div>\n      </div>\n    </div>\n  </div>\n\n  <div class=\"span3\">\n    <div class=\"form-horizontal sidebar well\">\n      <div class=\"control-group\">\n        <label class=\"control-label\" for=\"js-item-form-status\">Status</label>\n        <div class=\"controls\">\n          ");
  hashTypes = {'class': "STRING",'contentBinding': "STRING",'optionValuePath': "STRING",'optionLabelPath': "STRING",'valueBinding': "STRING"};
  data.buffer.push(escapeExpression(helpers.view.call(depth0, "Ember.Select", {hash:{
    'class': ("input-medium"),
    'contentBinding': ("view.selectValues.status"),
    'optionValuePath': ("content.value"),
    'optionLabelPath': ("content.label"),
    'valueBinding': ("controller.content.status")
  },contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data})));
  data.buffer.push("\n        </div>\n      </div>\n    </div>\n\n    <div class=\"form-horizontal sidebar well\">\n      <div class=\"control-group\">\n        <label class=\"control-label\" for=\"js-item-form-category\">Map</label>\n        <div class=\"controls\">\n          ");
  hashTypes = {'class': "STRING",'id': "STRING",'contentBinding': "STRING",'optionValuePath': "STRING",'optionLabelPath': "STRING",'prompt': "STRING",'selectionBinding': "STRING"};
  data.buffer.push(escapeExpression(helpers.view.call(depth0, "Ember.Select", {hash:{
    'class': ("input-medium"),
    'id': ("select__map"),
    'contentBinding': ("view.selectValues.maps"),
    'optionValuePath': ("content.value"),
    'optionLabelPath': ("content.label"),
    'prompt': ("Select a map"),
    'selectionBinding': ("controller.content.map_id")
  },contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data})));
  data.buffer.push("\n\n          ");
  hashTypes = {};
  stack1 = helpers.unless.call(depth0, "view.selectValues.maps.length", {hash:{},inverse:self.noop,fn:self.program(4, program4, data),contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n        </div>\n      </div>\n    </div>\n  </div>\n</div>\n");
  return buffer;
  
});

Ember.TEMPLATES["places/index"] = Ember.Handlebars.template(function anonymous(Handlebars,depth0,helpers,partials,data) {
this.compilerInfo = [2,'>= 1.0.0-rc.3'];
helpers = helpers || Ember.Handlebars.helpers; data = data || {};
  var buffer = '', stack1, stack2, hashTypes, options, escapeExpression=this.escapeExpression, helperMissing=helpers.helperMissing, self=this;

function program1(depth0,data) {
  
  
  data.buffer.push("Maps");
  }

function program3(depth0,data) {
  
  
  data.buffer.push("Places");
  }

function program5(depth0,data) {
  
  
  data.buffer.push("Settings");
  }

function program7(depth0,data) {
  
  var buffer = '', stack1, hashTypes;
  data.buffer.push("\n                  ");
  hashTypes = {'itemBinding': "STRING",'tagName': "STRING",'classNames': "STRING"};
  stack1 = helpers.view.call(depth0, "App.PlacesView__SingleItemView", {hash:{
    'itemBinding': ("item"),
    'tagName': ("tr"),
    'classNames': ("row0")
  },inverse:self.noop,fn:self.program(8, program8, data),contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n                ");
  return buffer;
  }
function program8(depth0,data) {
  
  var buffer = '', stack1, hashTypes, options;
  data.buffer.push("\n                    <td class=\"order nowrap center hidden-phone\">\n                      ");
  hashTypes = {};
  data.buffer.push(escapeExpression(helpers._triageMustache.call(depth0, "item.id", {hash:{},contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data})));
  data.buffer.push("\n                    </td>\n                    <td>\n                      ");
  hashTypes = {'checkedBinding': "STRING"};
  data.buffer.push(escapeExpression(helpers.view.call(depth0, "Ember.Checkbox", {hash:{
    'checkedBinding': ("item.isSelected")
  },contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data})));
  data.buffer.push("\n                    </td>\n                    <td class=\"center\">\n                      <div class=\"btn-group\">\n                        <a class=\"btn btn-micro active\">\n                          ");
  hashTypes = {};
  options = {hash:{},contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data};
  data.buffer.push(escapeExpression(((stack1 = helpers.printStatusIcon),stack1 ? stack1.call(depth0, "item.status", options) : helperMissing.call(depth0, "printStatusIcon", "item.status", options))));
  data.buffer.push("\n                        </a>\n                      </div>\n                    </td>\n                    <td>\n                      ");
  hashTypes = {};
  data.buffer.push(escapeExpression(helpers._triageMustache.call(depth0, "item.title", {hash:{},contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data})));
  data.buffer.push("\n                    </td>\n                    <td>\n                      ");
  hashTypes = {};
  data.buffer.push(escapeExpression(helpers._triageMustache.call(depth0, "item.address", {hash:{},contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data})));
  data.buffer.push("\n                    </td>\n                    <td>\n                      ");
  hashTypes = {};
  data.buffer.push(escapeExpression(helpers._triageMustache.call(depth0, "item.mapName", {hash:{},contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data})));
  data.buffer.push("\n                    </td>\n                  ");
  return buffer;
  }

function program10(depth0,data) {
  
  var buffer = '', stack1, hashTypes;
  data.buffer.push("\n                  ");
  hashTypes = {};
  stack1 = helpers['if'].call(depth0, "view.controller.isLoading", {hash:{},inverse:self.program(13, program13, data),fn:self.program(11, program11, data),contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n                ");
  return buffer;
  }
function program11(depth0,data) {
  
  
  data.buffer.push("\n                    <tr><td></td><td></td><td colspan=\"3\"><br>Loading..<br><br></td><td></td><td></td></tr>\n                  ");
  }

function program13(depth0,data) {
  
  
  data.buffer.push("\n                    <tr><td></td><td></td><td colspan=\"3\"><br>No places found<br><br></td><td></td><td></td></tr>\n                  ");
  }

  data.buffer.push("<div class=\"subhead-collapse\" id=\"ember-toolbar\">\n  <div class=\"subhead\">\n    <div class=\"container-fluid\">\n      <div id=\"container-collapse\" class=\"container-collapse\"></div>\n      <div class=\"row-fluid\">\n        <div class=\"span12\">\n          <div class=\"btn-toolbar\" id=\"toolbar\">\n\n            <div class=\"btn-group\" id=\"toolbar-new\">\n              <button ");
  hashTypes = {'target': "STRING"};
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "transitionToNew", {hash:{
    'target': ("view")
  },contexts:[depth0],types:["STRING"],hashTypes:hashTypes,data:data})));
  data.buffer.push(" class=\"btn btn-small btn-success\">\n                <i class=\"icon-new icon-white\"></i> New\n              </button>\n            </div>\n\n            <div class=\"btn-group\" id=\"toolbar-publish\">\n              <button ");
  hashTypes = {'target': "STRING"};
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "publishItems", {hash:{
    'target': ("view")
  },contexts:[depth0],types:["STRING"],hashTypes:hashTypes,data:data})));
  data.buffer.push(" class=\"btn btn-small\">\n                <i class=\"icon-publish\"></i> Publish\n              </button>\n            </div>\n\n            <div class=\"btn-group\" id=\"toolbar-unpublish\">\n              <button ");
  hashTypes = {'target': "STRING"};
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "unpublishItems", {hash:{
    'target': ("view")
  },contexts:[depth0],types:["STRING"],hashTypes:hashTypes,data:data})));
  data.buffer.push(" class=\"btn btn-small\">\n                <i class=\"icon-unpublish\"></i> Unpublish\n              </button>\n            </div>\n\n            <div class=\"btn-group\" id=\"toolbar-trash\">\n              <button ");
  hashTypes = {'target': "STRING"};
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "deleteItems", {hash:{
    'target': ("view")
  },contexts:[depth0],types:["STRING"],hashTypes:hashTypes,data:data})));
  data.buffer.push(" class=\"btn btn-small\">\n                <i class=\"icon-trash\"></i> Trash\n              </button>\n            </div>\n\n            <div class=\"btn-group\" id=\"toolbar-help\">\n              <button class=\"btn btn-small\">\n                <i class=\"icon-question-sign\"></i> Help\n              </button>\n            </div>\n\n          </div>\n        </div>\n      </div>\n    </div>\n  </div>\n</div>\n\n<div class=\" container-main\">\n  <section id=\"content\">\n    <!-- Begin Content -->\n    <div class=\"row-fluid\">\n      <div class=\"span12\">\n        <form action=\"/joomla3/administrator/index.php?option=com_maplocations&amp;view=products\" method=\"post\" name=\"adminForm\" id=\"adminForm\">\n          <div id=\"j-sidebar-container\" class=\"span2\">\n            <div id=\"sidebar\">\n              <div class=\"sidebar-nav\">\n                <ul id=\"submenu\" class=\"nav nav-list\">\n                  <li>\n                    ");
  hashTypes = {};
  options = {hash:{},inverse:self.noop,fn:self.program(1, program1, data),contexts:[depth0],types:["STRING"],hashTypes:hashTypes,data:data};
  stack2 = ((stack1 = helpers.linkTo),stack1 ? stack1.call(depth0, "maps", options) : helperMissing.call(depth0, "linkTo", "maps", options));
  if(stack2 || stack2 === 0) { data.buffer.push(stack2); }
  data.buffer.push("\n                  </li>\n                  <li class=\"active\">\n                    ");
  hashTypes = {};
  options = {hash:{},inverse:self.noop,fn:self.program(3, program3, data),contexts:[depth0],types:["STRING"],hashTypes:hashTypes,data:data};
  stack2 = ((stack1 = helpers.linkTo),stack1 ? stack1.call(depth0, "places", options) : helperMissing.call(depth0, "linkTo", "places", options));
  if(stack2 || stack2 === 0) { data.buffer.push(stack2); }
  data.buffer.push("\n                  </li>\n                  <li>\n                    ");
  hashTypes = {};
  options = {hash:{},inverse:self.noop,fn:self.program(5, program5, data),contexts:[depth0],types:["STRING"],hashTypes:hashTypes,data:data};
  stack2 = ((stack1 = helpers.linkTo),stack1 ? stack1.call(depth0, "settings", options) : helperMissing.call(depth0, "linkTo", "settings", options));
  if(stack2 || stack2 === 0) { data.buffer.push(stack2); }
  data.buffer.push("\n                  </li>\n                </ul>\n\n                <hr>\n\n                <div class=\"filter-select hidden-phone\">\n                  <h4 class=\"page-header\">Filter:</h4>\n\n                  ");
  hashTypes = {'class': "STRING",'contentBinding': "STRING",'optionValuePath': "STRING",'optionLabelPath': "STRING",'prompt': "STRING",'valueBinding': "STRING"};
  data.buffer.push(escapeExpression(helpers.view.call(depth0, "Ember.Select", {hash:{
    'class': ("span12"),
    'contentBinding': ("view.selectValues.status"),
    'optionValuePath': ("content.value"),
    'optionLabelPath': ("content.label"),
    'prompt': ("- Select Status -"),
    'valueBinding': ("view.controller.filter.status")
  },contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data})));
  data.buffer.push("\n\n                  <hr class=\"hr-condensed\">\n\n                  ");
  hashTypes = {'class': "STRING",'contentBinding': "STRING",'optionValuePath': "STRING",'optionLabelPath': "STRING",'prompt': "STRING",'id': "STRING",'valueBinding': "STRING"};
  data.buffer.push(escapeExpression(helpers.view.call(depth0, "Ember.Select", {hash:{
    'class': ("span12"),
    'contentBinding': ("view.selectValues.maps"),
    'optionValuePath': ("content.value"),
    'optionLabelPath': ("content.label"),
    'prompt': ("- Select Map -"),
    'id': ("select__map"),
    'valueBinding': ("view.controller.filter.map_id")
  },contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data})));
  data.buffer.push("\n                  <hr class=\"hr-condensed\">\n                </div>\n\n              </div>\n            </div>\n          </div>\n          <div id=\"j-main-container\" class=\"span10\">\n            <div id=\"filter-bar\" class=\"btn-toolbar\">\n              <div class=\"filter-search btn-group pull-left\">\n                <input type=\"text\" id=\"js-filter_search\" placeholder=\"Search by title\">\n              </div>\n              <div class=\"btn-group pull-left\">\n                <button class=\"btn\" ");
  hashTypes = {'target': "STRING"};
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "filterSearch", {hash:{
    'target': ("view")
  },contexts:[depth0],types:["STRING"],hashTypes:hashTypes,data:data})));
  data.buffer.push("><i class=\"icon-search\"></i></button>\n                <button class=\"btn\" ");
  hashTypes = {'target': "STRING"};
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "clearSearch", {hash:{
    'target': ("view")
  },contexts:[depth0],types:["STRING"],hashTypes:hashTypes,data:data})));
  data.buffer.push("><i class=\"icon-remove\"></i></button>\n              </div>\n            </div>\n            <div class=\"clearfix\"> </div>\n            <table class=\"table table-striped\" id=\"weblinkList\">\n              <thead>\n              <tr>\n                <th width=\"1%\" class=\"nowrap center hidden-phone\">\n                  <a><i class=\"icon-menu-2\"></i></a>\n                </th>\n                <th width=\"1%\">\n                  <input type=\"checkbox\" ");
  hashTypes = {'target': "STRING"};
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "checkAllItems", {hash:{
    'target': ("view")
  },contexts:[depth0],types:["STRING"],hashTypes:hashTypes,data:data})));
  data.buffer.push(">\n                </th>\n                <th width=\"1%\" class=\"center\">\n                  <a ");
  hashTypes = {'target': "STRING"};
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "filterByStatus", {hash:{
    'target': ("view")
  },contexts:[depth0],types:["STRING"],hashTypes:hashTypes,data:data})));
  data.buffer.push(">Status</a>\n                </th>\n                <th>\n                  <a ");
  hashTypes = {'target': "STRING"};
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "filterByTitle", {hash:{
    'target': ("view")
  },contexts:[depth0],types:["STRING"],hashTypes:hashTypes,data:data})));
  data.buffer.push(">\n                    Title\n                    <i class=\"icon-arrow-up-3\"></i>\n                  </a>\n                </th>\n                <th>\n                  <a ");
  hashTypes = {'target': "STRING"};
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "filterByAddress", {hash:{
    'target': ("view")
  },contexts:[depth0],types:["STRING"],hashTypes:hashTypes,data:data})));
  data.buffer.push(">\n                    Address\n                    <i class=\"icon-arrow-up-3\"></i>\n                  </a>\n                </th>\n                <th>\n                  <a ");
  hashTypes = {'target': "STRING"};
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "filterByMap", {hash:{
    'target': ("view")
  },contexts:[depth0],types:["STRING"],hashTypes:hashTypes,data:data})));
  data.buffer.push(">\n                    Map\n                    <i class=\"icon-arrow-up-3\"></i>\n                  </a>\n                </th>\n              </tr>\n              </thead>\n              <tfoot>\n              <tr>\n                <td colspan=\"10\">\n                  <div class=\"pagination pagination-toolbar\">\n                    <input type=\"hidden\" name=\"limitstart\" value=\"0\">\n                  </div> </td>\n              </tr>\n              </tfoot>\n              <tbody>\n                ");
  hashTypes = {};
  stack2 = helpers.each.call(depth0, "item", "in", "view.controller", {hash:{},inverse:self.program(10, program10, data),fn:self.program(7, program7, data),contexts:[depth0,depth0,depth0],types:["ID","ID","ID"],hashTypes:hashTypes,data:data});
  if(stack2 || stack2 === 0) { data.buffer.push(stack2); }
  data.buffer.push("\n\n              </tbody>\n            </table>\n          </div>\n        </form>\n      </div>\n    </div>\n  </section>\n</div>\n");
  return buffer;
  
});

Ember.TEMPLATES["settings"] = Ember.Handlebars.template(function anonymous(Handlebars,depth0,helpers,partials,data) {
this.compilerInfo = [2,'>= 1.0.0-rc.3'];
helpers = helpers || Ember.Handlebars.helpers; data = data || {};
  var buffer = '', stack1, stack2, hashTypes, options, escapeExpression=this.escapeExpression, self=this, helperMissing=helpers.helperMissing;

function program1(depth0,data) {
  
  var buffer = '', stack1, hashTypes;
  data.buffer.push("\n  ");
  hashTypes = {};
  stack1 = helpers['if'].call(depth0, "App.message.isSuccess", {hash:{},inverse:self.noop,fn:self.program(2, program2, data),contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n");
  return buffer;
  }
function program2(depth0,data) {
  
  var buffer = '', hashTypes;
  data.buffer.push("\n    <div id=\"message-container\">\n      <div ");
  hashTypes = {'class': "STRING"};
  data.buffer.push(escapeExpression(helpers.bindAttr.call(depth0, {hash:{
    'class': (":alert App.message.isSuccess:alert-success App.message.isError:alert-error")
  },contexts:[],types:[],hashTypes:hashTypes,data:data})));
  data.buffer.push("><strong>");
  hashTypes = {};
  data.buffer.push(escapeExpression(helpers._triageMustache.call(depth0, "App.message.title", {hash:{},contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data})));
  data.buffer.push("</strong> ");
  hashTypes = {};
  data.buffer.push(escapeExpression(helpers._triageMustache.call(depth0, "App.message.text", {hash:{},contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data})));
  data.buffer.push("</div>\n    </div>\n  ");
  return buffer;
  }

function program4(depth0,data) {
  
  
  data.buffer.push("Maps");
  }

function program6(depth0,data) {
  
  
  data.buffer.push("Places");
  }

function program8(depth0,data) {
  
  
  data.buffer.push("Settings");
  }

  data.buffer.push("<div class=\"subhead-collapse\" id=\"ember-toolbar\">\n  <div class=\"subhead\">\n    <div class=\"container-fluid\">\n      <div id=\"container-collapse\" class=\"container-collapse\"></div>\n      <div class=\"row-fluid\">\n        <div class=\"span12\">\n          <div class=\"btn-toolbar\" id=\"toolbar\">\n            <div class=\"btn-group\" id=\"toolbar-apply\">\n              <button ");
  hashTypes = {'target': "STRING"};
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "save", {hash:{
    'target': ("view")
  },contexts:[depth0],types:["STRING"],hashTypes:hashTypes,data:data})));
  data.buffer.push(" class=\"btn btn-small btn-success\">\n              <i class=\"icon-apply icon-white\">\n              </i>\n              Save\n              </button>\n            </div>\n\n            <div class=\"btn-group\" id=\"toolbar-cancel\">\n              <button ");
  hashTypes = {'target': "STRING"};
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "rollbackChanges", {hash:{
    'target': ("view")
  },contexts:[depth0],types:["STRING"],hashTypes:hashTypes,data:data})));
  data.buffer.push(" class=\"btn btn-small\">\n              <i class=\"icon-arrow-left \">\n              </i>\n              Discard unsaved settings\n              </button>\n            </div>\n\n            <div class=\"btn-group divider\">\n            </div>\n\n            <div class=\"btn-group\" id=\"toolbar-help\">\n              <button class=\"btn btn-small\">\n              <i class=\"icon-question-sign\">\n              </i>\n              Help\n              </button>\n            </div>\n          </div>\n        </div>\n      </div>\n    </div>\n  </div>\n</div>\n\n");
  hashTypes = {};
  stack1 = helpers['if'].call(depth0, "App.message", {hash:{},inverse:self.noop,fn:self.program(1, program1, data),contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n\n<div class=\"container-main\">\n  <section id=\"content\">\n    <!-- Begin Content -->\n    <div class=\"row-fluid\">\n      <div class=\"span12\">\n        <form action=\"/joomla3/administrator/index.php?option=com_maplocations&amp;view=products\" method=\"post\" name=\"adminForm\" id=\"adminForm\">\n          <div id=\"j-sidebar-container\" class=\"span2\">\n            <div id=\"sidebar\">\n              <div class=\"sidebar-nav\">\n                <ul id=\"submenu\" class=\"nav nav-list\">\n                  <li>\n                    ");
  hashTypes = {};
  options = {hash:{},inverse:self.noop,fn:self.program(4, program4, data),contexts:[depth0],types:["STRING"],hashTypes:hashTypes,data:data};
  stack2 = ((stack1 = helpers.linkTo),stack1 ? stack1.call(depth0, "maps", options) : helperMissing.call(depth0, "linkTo", "maps", options));
  if(stack2 || stack2 === 0) { data.buffer.push(stack2); }
  data.buffer.push("\n                  </li>\n                  <li>\n                    ");
  hashTypes = {};
  options = {hash:{},inverse:self.noop,fn:self.program(6, program6, data),contexts:[depth0],types:["STRING"],hashTypes:hashTypes,data:data};
  stack2 = ((stack1 = helpers.linkTo),stack1 ? stack1.call(depth0, "places", options) : helperMissing.call(depth0, "linkTo", "places", options));
  if(stack2 || stack2 === 0) { data.buffer.push(stack2); }
  data.buffer.push("\n                  </li>\n                  <li class=\"active\">\n                    ");
  hashTypes = {};
  options = {hash:{},inverse:self.noop,fn:self.program(8, program8, data),contexts:[depth0],types:["STRING"],hashTypes:hashTypes,data:data};
  stack2 = ((stack1 = helpers.linkTo),stack1 ? stack1.call(depth0, "settings", options) : helperMissing.call(depth0, "linkTo", "settings", options));
  if(stack2 || stack2 === 0) { data.buffer.push(stack2); }
  data.buffer.push("\n                  </li>\n                </ul>\n                <hr>\n              </div>\n            </div>\n          </div>\n          <div id=\"j-main-container\" class=\"span10\">\n            <div class=\"span10\">\n              <ul class=\"nav nav-tabs\" id=\"configTabs\">\n                <li class=\"active\"><a href=\"#general\" data-toggle=\"tab\">General</a></li>\n                <li><a href=\"#controls\" data-toggle=\"tab\">Controls</a></li>\n                <li><a href=\"#zoom\" data-toggle=\"tab\">Zoom</a></li>\n                <li><a href=\"#clusters\" data-toggle=\"tab\">Clusters</a></li>\n              </ul>\n              <div class=\"tab-content\">\n                <div class=\"tab-pane well active\" id=\"general\">\n                  ");
  hashTypes = {};
  data.buffer.push(escapeExpression(helpers.view.call(depth0, "App.SettingsView__GeneralView", {hash:{},contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data})));
  data.buffer.push("\n                </div>\n                <div class=\"tab-pane well\" id=\"controls\">\n                  ");
  hashTypes = {};
  data.buffer.push(escapeExpression(helpers.view.call(depth0, "App.SettingsView__ControlsView", {hash:{},contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data})));
  data.buffer.push("\n                </div>\n                <div class=\"tab-pane well\" id=\"zoom\">\n                  ");
  hashTypes = {};
  data.buffer.push(escapeExpression(helpers.view.call(depth0, "App.SettingsView__ZoomView", {hash:{},contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data})));
  data.buffer.push("\n                </div>\n                <div class=\"tab-pane well\" id=\"clusters\">\n                  ");
  hashTypes = {};
  data.buffer.push(escapeExpression(helpers.view.call(depth0, "App.SettingsView__ClustersView", {hash:{},contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data})));
  data.buffer.push("\n                </div>\n              </div>\n            </div>\n\n          </div>\n        </form>\n      </div>\n    </div>\n  </section>\n</div>\n");
  return buffer;
  
});

Ember.TEMPLATES["settings/clusters"] = Ember.Handlebars.template(function anonymous(Handlebars,depth0,helpers,partials,data) {
this.compilerInfo = [2,'>= 1.0.0-rc.3'];
helpers = helpers || Ember.Handlebars.helpers; data = data || {};
  var buffer = '', hashTypes, escapeExpression=this.escapeExpression;


  data.buffer.push("<div class=\"well row\">\n  <div class=\"span6\">\n\n    <div class=\"control-group\">\n      <div class=\"control-label\">\n        <label\n          id=\"jform_info_block_position-lbl\"\n          for=\"jform_info_block_position\"\n          class=\"hasTooltip\"\n          title=\"Clusters group places when they are too near each other, with an icon that indicates how many there are in that area\">\n          Enable clusters <span class=\"icon-question-sign\"></span>\n        </label>\n      </div>\n      <div class=\"controls\">\n        ");
  hashTypes = {'contentBinding': "STRING",'optionValuePath': "STRING",'optionLabelPath': "STRING",'valueBinding': "STRING"};
  data.buffer.push(escapeExpression(helpers.view.call(depth0, "Ember.Select", {hash:{
    'contentBinding': ("view.selectValues.yesOrNo"),
    'optionValuePath': ("content.value"),
    'optionLabelPath': ("content.label"),
    'valueBinding': ("App.settings.clusters.enable")
  },contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data})));
  data.buffer.push("\n      </div>\n    </div>\n\n    <div class=\"control-group\">\n      <div class=\"control-label\">\n        <label\n          id=\"jform_info_block_position-lbl\"\n          for=\"jform_info_block_position\"\n          class=\"hasTooltip\"\n          title=\"The larger the size, the more places will be included in the cluster\">\n          Cluster grid size <span class=\"icon-question-sign\"></span>. See <a href=\"http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/examples/advanced_example.html\">this link</a> as a reference\n        </label>\n      </div>\n      <div class=\"controls\">\n        ");
  hashTypes = {'contentBinding': "STRING",'optionValuePath': "STRING",'optionLabelPath': "STRING",'valueBinding': "STRING"};
  data.buffer.push(escapeExpression(helpers.view.call(depth0, "Ember.Select", {hash:{
    'contentBinding': ("view.selectValues.clusterSize"),
    'optionValuePath': ("content.value"),
    'optionLabelPath': ("content.label"),
    'valueBinding': ("App.settings.clusters.size")
  },contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data})));
  data.buffer.push("\n      </div>\n    </div>\n\n  </div>\n</div>\n\n\n");
  return buffer;
  
});

Ember.TEMPLATES["settings/controls"] = Ember.Handlebars.template(function anonymous(Handlebars,depth0,helpers,partials,data) {
this.compilerInfo = [2,'>= 1.0.0-rc.3'];
helpers = helpers || Ember.Handlebars.helpers; data = data || {};
  var buffer = '', hashTypes, escapeExpression=this.escapeExpression;


  data.buffer.push("<div class=\"well row\">\n  <div class=\"span6\">\n\n    <div class=\"control-group\">\n      <div class=\"control-label\">\n        <label\n          id=\"jform_info_block_position-lbl\"\n          for=\"jform_info_block_position\"\n          class=\"hasTooltip\"\n          title=\"\">\n          Pan\n        </label>\n      </div>\n      <div class=\"controls\">\n        ");
  hashTypes = {'contentBinding': "STRING",'optionValuePath': "STRING",'optionLabelPath': "STRING",'valueBinding': "STRING"};
  data.buffer.push(escapeExpression(helpers.view.call(depth0, "Ember.Select", {hash:{
    'contentBinding': ("view.selectValues.yesOrNo"),
    'optionValuePath': ("content.value"),
    'optionLabelPath': ("content.label"),
    'valueBinding': ("App.settings.controls.pan")
  },contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data})));
  data.buffer.push("\n      </div>\n    </div>\n\n    <div class=\"control-group\">\n      <div class=\"control-label\">\n        <label\n          id=\"jform_info_block_position-lbl\"\n          for=\"jform_info_block_position\"\n          class=\"hasTooltip\"\n          title=\"\">\n          Zoom\n        </label>\n      </div>\n      <div class=\"controls\">\n        ");
  hashTypes = {'contentBinding': "STRING",'optionValuePath': "STRING",'optionLabelPath': "STRING",'valueBinding': "STRING"};
  data.buffer.push(escapeExpression(helpers.view.call(depth0, "Ember.Select", {hash:{
    'contentBinding': ("view.selectValues.yesOrNo"),
    'optionValuePath': ("content.value"),
    'optionLabelPath': ("content.label"),
    'valueBinding': ("App.settings.controls.zoom")
  },contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data})));
  data.buffer.push("\n      </div>\n    </div>\n\n    <div class=\"control-group\">\n      <div class=\"control-label\">\n        <label\n          id=\"jform_info_block_position-lbl\"\n          for=\"jform_info_block_position\"\n          class=\"hasTooltip\"\n          title=\"\">\n          Map type\n        </label>\n      </div>\n      <div class=\"controls\">\n        ");
  hashTypes = {'contentBinding': "STRING",'optionValuePath': "STRING",'optionLabelPath': "STRING",'valueBinding': "STRING"};
  data.buffer.push(escapeExpression(helpers.view.call(depth0, "Ember.Select", {hash:{
    'contentBinding': ("view.selectValues.yesOrNo"),
    'optionValuePath': ("content.value"),
    'optionLabelPath': ("content.label"),
    'valueBinding': ("App.settings.controls.mapType")
  },contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data})));
  data.buffer.push("\n      </div>\n    </div>\n\n    <div class=\"control-group\">\n      <div class=\"control-label\">\n        <label\n          id=\"jform_info_block_position-lbl\"\n          for=\"jform_info_block_position\"\n          class=\"hasTooltip\"\n          title=\"\">\n          Scale\n        </label>\n      </div>\n      <div class=\"controls\">\n        ");
  hashTypes = {'contentBinding': "STRING",'optionValuePath': "STRING",'optionLabelPath': "STRING",'valueBinding': "STRING"};
  data.buffer.push(escapeExpression(helpers.view.call(depth0, "Ember.Select", {hash:{
    'contentBinding': ("view.selectValues.yesOrNo"),
    'optionValuePath': ("content.value"),
    'optionLabelPath': ("content.label"),
    'valueBinding': ("App.settings.controls.scale")
  },contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data})));
  data.buffer.push("\n      </div>\n    </div>\n\n    <div class=\"control-group\">\n      <div class=\"control-label\">\n        <label\n          id=\"jform_info_block_position-lbl\"\n          for=\"jform_info_block_position\"\n          class=\"hasTooltip\"\n          title=\"\">\n          Street view\n        </label>\n      </div>\n      <div class=\"controls\">\n        ");
  hashTypes = {'contentBinding': "STRING",'optionValuePath': "STRING",'optionLabelPath': "STRING",'valueBinding': "STRING"};
  data.buffer.push(escapeExpression(helpers.view.call(depth0, "Ember.Select", {hash:{
    'contentBinding': ("view.selectValues.yesOrNo"),
    'optionValuePath': ("content.value"),
    'optionLabelPath': ("content.label"),
    'valueBinding': ("App.settings.controls.streetView")
  },contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data})));
  data.buffer.push("\n      </div>\n    </div>\n\n    <div class=\"control-group\">\n      <div class=\"control-label\">\n        <label\n          id=\"jform_info_block_position-lbl\"\n          for=\"jform_info_block_position\"\n          class=\"hasTooltip\"\n          title=\"\">\n          Overview map\n        </label>\n      </div>\n      <div class=\"controls\">\n        ");
  hashTypes = {'contentBinding': "STRING",'optionValuePath': "STRING",'optionLabelPath': "STRING",'valueBinding': "STRING"};
  data.buffer.push(escapeExpression(helpers.view.call(depth0, "Ember.Select", {hash:{
    'contentBinding': ("view.selectValues.yesOrNo"),
    'optionValuePath': ("content.value"),
    'optionLabelPath': ("content.label"),
    'valueBinding': ("App.settings.controls.overviewMap")
  },contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data})));
  data.buffer.push("\n      </div>\n    </div>\n\n\n  </div>\n</div>\n\n\n");
  return buffer;
  
});

Ember.TEMPLATES["settings/general"] = Ember.Handlebars.template(function anonymous(Handlebars,depth0,helpers,partials,data) {
this.compilerInfo = [2,'>= 1.0.0-rc.3'];
helpers = helpers || Ember.Handlebars.helpers; data = data || {};
  var buffer = '', hashTypes, escapeExpression=this.escapeExpression;


  data.buffer.push("<div class=\"well row\">\n  <div class=\"span6\">\n    <div class=\"control-group\">\n      <div class=\"control-label\">\n        <label id=\"jform_opensearch_name-lbl\" for=\"jform_opensearch_name\" class=\"hasTooltip\" title=\"\">Width of the map, in pixels</label>\n      </div>\n      <div class=\"controls\">\n        ");
  hashTypes = {'valueBinding': "STRING",'placeholder': "STRING"};
  data.buffer.push(escapeExpression(helpers.view.call(depth0, "Ember.TextField", {hash:{
    'valueBinding': ("App.settings.general.width"),
    'placeholder': ("500")
  },contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data})));
  data.buffer.push("\n      </div>\n    </div>\n\n    <div class=\"control-group\">\n      <div class=\"control-label\">\n        <label id=\"jform_opensearch_name-lbl\" for=\"jform_opensearch_name\" class=\"hasTooltip\" title=\"\">Height of the map, in pixels</label>\n      </div>\n      <div class=\"controls\">\n        ");
  hashTypes = {'valueBinding': "STRING",'placeholder': "STRING"};
  data.buffer.push(escapeExpression(helpers.view.call(depth0, "Ember.TextField", {hash:{
    'valueBinding': ("App.settings.general.height"),
    'placeholder': ("400")
  },contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data})));
  data.buffer.push("\n      </div>\n    </div>\n\n    <div class=\"control-group\">\n      <div class=\"control-label\">\n        <label\n          id=\"jform_info_block_position-lbl\"\n          for=\"jform_info_block_position\"\n          class=\"hasTooltip\"\n          title=\"\">\n          Map Type\n        </label>\n      </div>\n      <div class=\"controls\">\n        ");
  hashTypes = {'contentBinding': "STRING",'optionValuePath': "STRING",'optionLabelPath': "STRING",'valueBinding': "STRING"};
  data.buffer.push(escapeExpression(helpers.view.call(depth0, "Ember.Select", {hash:{
    'contentBinding': ("view.selectValues.mapTypes"),
    'optionValuePath': ("content.value"),
    'optionLabelPath': ("content.label"),
    'valueBinding': ("App.settings.general.mapType")
  },contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data})));
  data.buffer.push("\n      </div>\n    </div>\n\n    <div class=\"control-group\">\n      <div class=\"control-label\">\n        <label\n          id=\"jform_info_block_position-lbl\"\n          for=\"jform_info_block_position\"\n          class=\"hasTooltip\"\n          title=\"\">\n          Enable the new Google Maps layout\n        </label>\n      </div>\n      <div class=\"controls\">\n        ");
  hashTypes = {'contentBinding': "STRING",'optionValuePath': "STRING",'optionLabelPath': "STRING",'valueBinding': "STRING"};
  data.buffer.push(escapeExpression(helpers.view.call(depth0, "Ember.Select", {hash:{
    'contentBinding': ("view.selectValues.yesOrNo"),
    'optionValuePath': ("content.value"),
    'optionLabelPath': ("content.label"),
    'valueBinding': ("App.settings.general.visualRefresh")
  },contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data})));
  data.buffer.push("\n      </div>\n    </div>\n\n  </div>\n</div>\n");
  return buffer;
  
});

Ember.TEMPLATES["settings/markers"] = Ember.Handlebars.template(function anonymous(Handlebars,depth0,helpers,partials,data) {
this.compilerInfo = [2,'>= 1.0.0-rc.3'];
helpers = helpers || Ember.Handlebars.helpers; data = data || {};
  var buffer = '';


  return buffer;
  
});

Ember.TEMPLATES["settings/zoom"] = Ember.Handlebars.template(function anonymous(Handlebars,depth0,helpers,partials,data) {
this.compilerInfo = [2,'>= 1.0.0-rc.3'];
helpers = helpers || Ember.Handlebars.helpers; data = data || {};
  var buffer = '', hashTypes, escapeExpression=this.escapeExpression;


  data.buffer.push("<div class=\"well row\">\n  <div class=\"span6\">\n\n    <div class=\"control-group\">\n      <div class=\"control-label\">\n        <label\n          id=\"jform_info_block_position-lbl\"\n          for=\"jform_info_block_position\"\n          class=\"hasTooltip\"\n          title=\"\">\n          Automatic zoom\n        </label>\n      </div>\n      <div class=\"controls\">\n        ");
  hashTypes = {'contentBinding': "STRING",'optionValuePath': "STRING",'optionLabelPath': "STRING",'valueBinding': "STRING"};
  data.buffer.push(escapeExpression(helpers.view.call(depth0, "Ember.Select", {hash:{
    'contentBinding': ("view.selectValues.yesOrNo"),
    'optionValuePath': ("content.value"),
    'optionLabelPath': ("content.label"),
    'valueBinding': ("App.settings.zoom.auto")
  },contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data})));
  data.buffer.push("\n      </div>\n    </div>\n\n    <div class=\"control-group\">\n      <div class=\"control-label\">\n        <label\n          id=\"jform_info_block_position-lbl\"\n          for=\"jform_info_block_position\"\n          class=\"hasTooltip\"\n          title=\"\">\n          Fixed zoom level (used if automatic zoom is off). The map is auto centered based on existing points it will show\n        </label>\n      </div>\n      <div class=\"controls\">\n        ");
  hashTypes = {'contentBinding': "STRING",'optionValuePath': "STRING",'optionLabelPath': "STRING",'valueBinding': "STRING"};
  data.buffer.push(escapeExpression(helpers.view.call(depth0, "Ember.Select", {hash:{
    'contentBinding': ("view.selectValues.zoomLevel"),
    'optionValuePath': ("content.value"),
    'optionLabelPath': ("content.label"),
    'valueBinding': ("App.settings.zoom.level")
  },contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data})));
  data.buffer.push("\n      </div>\n    </div>\n\n    <div class=\"control-group\">\n      <div class=\"control-label\">\n        <label\n          id=\"jform_info_block_position-lbl\"\n          for=\"jform_info_block_position\"\n          class=\"hasTooltip\"\n          title=\"\">\n          Maximum zoom level when a single place is on the map. This value avoids zooming too much\n        </label>\n      </div>\n      <div class=\"controls\">\n        ");
  hashTypes = {'contentBinding': "STRING",'optionValuePath': "STRING",'optionLabelPath': "STRING",'valueBinding': "STRING"};
  data.buffer.push(escapeExpression(helpers.view.call(depth0, "Ember.Select", {hash:{
    'contentBinding': ("view.selectValues.zoomLevel"),
    'optionValuePath': ("content.value"),
    'optionLabelPath': ("content.label"),
    'valueBinding': ("App.settings.zoom.maxZoom")
  },contexts:[depth0],types:["ID"],hashTypes:hashTypes,data:data})));
  data.buffer.push("\n      </div>\n    </div>\n\nmaxZoom\n  </div>\n</div>\n");
  return buffer;
  
});