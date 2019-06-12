// / Created by  https://codepen.io/cilestin/#
// / Found at  https://codepen.io/cilestin/pen/ogQQBP  on  6/11/2019
// / Modified by  https://github.com/zelon88  on  6/11/2019
// / https://www.HonestRepair.net

// / Create a div container with the class="dragContainer" attribute set.
// / Then set the draggable=true attribute on all child divs for them to become swappable.

// ----------
// / Requires JQuery!
// ----------

var DragManager = {
  dragContainers: [],
  currentContainer: null,
  
  add: function(dragContainer) {
    this.dragContainers.push(dragContainer);
  },
  
  handleEvent: function(event) {
    if (event.type == 'dragstart') {
      var containers = this.dragContainers.filter(function(container) {
        return container.contains(event.target);
      });
      
      if (containers.length > 0) {
      	this.currentContainer = containers[0];
        this.currentContainer.activate();
      }
    }
    
    if (this.currentContainer !== null) {
      this.currentContainer.handleEvent(event);
      if (event.type == 'dragend') {
        this.currentContainer.deactivate();
        this.currentContainer = null;
      }
    }
  }
};

window.addEventListener('dragstart', DragManager);
window.addEventListener('dragend', DragManager);

function DragContainer(container, type) {
  this.element = container;
  this.type = type || 'swap';
  this.items = $('> div', this.element);
  this.draggingItem = null;
  
  DragManager.add(this);
}

DragContainer.prototype.contains = function(target) {
  return $(this.element).find(target).length;
}

DragContainer.prototype.handleEvent = function(event) {
  // NOTE: We've bound `this` to the DragContainer object, not
  // the element the event was fired on.
  var $t = $(event.target);
  
  if (event.type == 'dragstart') {
    this.draggingItem = event.target;
    event.dataTransfer.setData('text/html', this.draggingItem.innerHTML);
  }
  
  if (event.type == 'dragover' && this.draggingItem != event.target) {
    $t.addClass('js-active');
    // Preventing the default action _enables_ drop. Because JS APIs.
    if (event.preventDefault) {
      event.preventDefault();
    }
    event.dataTransfer.dropEffect = 'move';
  }
  
  if (event.type == 'dragleave') {
    $t.removeClass('js-active');
  }
  
  if (event.type == 'drop' && this.draggingItem != null) {
    if (this.type == 'swap') {
      this.draggingItem.innerHTML = event.target.innerHTML;
      event.target.innerHTML = event.dataTransfer.getData('text/html');
    } else if (this.type == 'reorder') {
      console.log('reorder');
      console.log(this.items.index(event.target));
    }
  }
  
  if (event.type == 'dragend' || event.type == 'drop') {
    this.items.removeClass('js-active');
    this.draggingItem = null;
  }
}

DragContainer.prototype.activate = function() {
  for (var i = 0, j=this.items.length; i < j; i++) {
    // Make sure `this` is always a DragContainer instead of the element the
    // event was activated on.
    this.items[i].addEventListener('dragenter', this.handleEvent.bind(this));
    this.items[i].addEventListener('dragover', this.handleEvent.bind(this));
    this.items[i].addEventListener('dragleave', this.handleEvent.bind(this));
    this.items[i].addEventListener('drop', this.handleEvent.bind(this));
  }
}

DragContainer.prototype.deactivate = function() {
  this.draggingItem = null;
  for (var i = 0, j=this.items.length; i < j; i++) {
    //this.items[i].removeEventListener('dragenter', this.handleEvent);
    //this.items[i].removeEventListener('dragover', this.handleEvent);
    //this.items[i].removeEventListener('dragleave', this.handleEvent);
    //this.items[i].removeEventListener('drop', this.handleEvent);
  }
}

var dragContainers = document.getElementsByClassName('dragContainer');

for(var i =0, j=dragContainers.length; i < j; i++) {
  new DragContainer(dragContainers[i], (i % 2 == 0) ? 'swap' : 'reorder');
}