/**
 * Qlue QTip - Content Plugin
 *
 * @author Aaron Harding 
 * @package Qlue QTip
 * @license GNU/GPL
 *
 * This plugin will convert a basic syntax of {qlueTip title=[tooltip]}Tool Tip Text{/qluetip} into a valid QTip.
 * The user can add extra parameters to the syntax to match their needs. For further information visit http://www.Qlue.co.uk.
 */

// Create the QlueTip class
var QlueTip = new Class({
  
  // Implement a few needed classes
  Implements: [Events, Options],
            
  // Create our defaults object, this will contain our default values
  options: {
    transition: Fx.Transitions.linear,
    Class: 'default',
    position: 'cursor',
    width: 300,
    duration: 150,
    sticky: false,
    link: 'cancel'
  },
  
  // Constructor function
  initialize: function( element, contain, options ){
    
    // Lets set our options
    this.setOptions(options);
    
    // Get our tooltip item
    this.element = document.id(element);
    
    // Get our tooltip container
    this.contain = document.id(contain);
    
    // Set the tooltip to closed by default
    this.open = false;
    
    // Build our tooltip
    this.build();
    
    // Add events to our tooltip items
    this.addEvents();
    
    // Apply Fx class to our tooltip
    this.fx = new Fx.Morph(this.tooltip, this.options);
  },
  
  build: function() {
    
    // Find our tooltip inside of our element and inject into the document body
    this.tooltip = new Element('div', {'class': 'qluetip'}).inject(document.body);
    
    // Set the styles for our tooltip
    this.tooltip.setStyles({
            'visibility': 'hidden',
            'opacity': 0,
            'overflow': 'hidden',
            'position': 'absolute',
            'top': 0,
            'left': 0,
            'z-index': 999,
            'width': this.options.width +'px'});
    
    // Create a div for applying a custom class
    var container = new Element('div', {'class': this.options.Class}).inject(this.tooltip);
    
    // Create top part of our tooltip
    var topLeft   = new Element( 'div', {'class': 'QTip-tl'}).inject(container);
    var topRight  = new Element( 'div', {'class': 'QTip-tr'}).inject(topLeft);
    var top       = new Element( 'div', {'class': 'QTip-t'}).inject(topRight);
    
    // Create the middle of our tooltip (content)
    var left   = new Element( 'div', {'class': 'QTip-l'}).inject(container);
    var right  = new Element( 'div', {'class': 'QTip-r'}).inject(left);
    
    // Inject the tooltip content into the tooltip
    this.contain.setStyle('display', 'block').inject(right);
    
    // Create the bottom part of our tooltip
    var bottomLeft   = new Element( 'div', {'class': 'QTip-bl'}).inject(container);
    var bottomRight  = new Element( 'div', {'class': 'QTip-br'}).inject(bottomLeft);
    var bottom       = new Element( 'div', {'class': 'QTip-b'}).inject(bottomRight);
    
    // Now Create the tip for our tooltip
    var tip = new Element( 'div', {'class': 'QTip-arrow'}).inject(bottom);
    
    // If the option is set to sticky create our close button
    if(this.options.sticky){
      this.close = new Element( 'div', {'class': 'QTip-close'}).injectInside(topLeft);
    }
    
    return this;    
  },
  
  addEvents: function() {
    
    // Add event to our tooltip text (toggle)
    this.element.addEvent('mouseenter', this.show.bindWithEvent(this, this.element));
    
    // Add click event to close button if set to sticky, else close when mouse leaves toggle
    this.options.sticky ? this.close.addEvent( 'click', this.hide.bindWithEvent(this, this.element)) : this.element.addEvent('mouseleave', this.hide.bindWithEvent(this, this.element));
    
    return this;
  },
  
  show: function(event) {
    
    // Update the position of our tooltip
    this.position(event);
    
    // Fade the tooltip in if it is not open
    if(!this.open){ 
       // Fade the tooltip in
       this.fx.start({'opacity': 1, 'visibility': 'visible'});
       // Set the tooltip open to true after fade in
       this.open = true;
    }   
  },
  
  hide: function(event) {
    //if our item is open
    if(this.open){
       // Fade the tooltip out
       this.fx.start({'opacity': 0, 'visibility': 'hidden'});
       // Set the tooltip open to false after fade out
       this.open =false;
    }
  },
  
  position: function(event) {
    
    // Create coordinates object, window object, window scroll size object, tip object and prop object
    var coordinates = {'top': 0, 'left': 0};
    var qluetip     = {'x': this.tooltip.offsetWidth, 'y': this.tooltip.offsetHeight};
    
    // Get the event
    var event = new Event(event);
    
    // If option position has been set to cursor, get coordinates of the cursor
    if(this.options.position == 'cursor'){      
      // Get cursor top and left position
      coordinates.top  = (event.page.y - qluetip.y);
      
      // + 23, is the width of the arrow image for the tooltip
      coordinates.left = (event.page.x - (qluetip.x/2)) + 12;

    } else {
      
      // Get the coordinates of our tooltip title text (toggle)
      var object  = this.element.getCoordinates();
      
      // Update our coordinates
      coordinates.top  = object.top - qluetip.y;
      
      // + 23, is the width of the arrow image for the tooltip
      coordinates.left = (object.left - (qluetip.x/2) + (object.width/2)) + 12;
    }
    
    // Set the top and left position for our tooltip
    this.tooltip.setStyles({'top': coordinates.top+'px', 'left': coordinates.left+'px'});
  }
            
});

// Detect if jquery exists and add no conflict
if(typeof jQuery != 'undefined'){
  jQuery.noConflict();
}