;(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD. Register as an anonymous module.
        define([], factory);
    } else if (typeof module === 'object' && module.exports) {
        // Node. Does not work with strict CommonJS, but
        // only CommonJS-like environments that support module.exports,
        // like Node.
        module.exports = factory();
    } else {
        // Browser globals (root is window)
        root['Waterfall'] = factory();
  }
}(this, function (){
    'use strict';
    var Waterfall = function(opts) {
      this.deleteEmptyColumns()

      // define property
      var minBoxWidth;
      Object.defineProperty(this, 'minBoxWidth', {
        get: function() { return minBoxWidth; },
        set: function(value) {
          if(value < 100) value = 100;
          if(value > 1000) value = 1000;

          minBoxWidth = value;
        }
      });

      this.opts = opts;
      this.columnsNum = 3;

      // compose once in constructor
      this.compose();

      // handle the image or something which might change size after loaded
      var images = this.container.querySelectorAll('img'), that = this;
      var clr;
      for (var i = 0; i < images.length; i++) {
        var img = images[i];
        img.onload = function() {
          if(clr) clearTimeout(clr);

          clr = setTimeout(function() {
            that.compose(true);
          }, 500);
        }
      }

      window.addEventListener('resize', function() {
        that.compose();
      });
    };

    // compute the number of columns under current setting
    Waterfall.prototype.computeNumberOfColumns = function() {
      var num = Math.floor(this.container.clientWidth / this.minBoxWidth);
      if(num<3){num=3;}
      num = num || 1; // at least one column

      this.columnsNum = num;
      return num;
    };

    Waterfall.prototype.getColumnsNum = function(){
      return this.columnsNum;
    };

    Waterfall.prototype.updateBoxes = function() {
      this.boxes = document.getElementsByClassName('wf-box');
    };

    // init enough columns and set the width
    Waterfall.prototype.initColumns = function(num) {
      if(num > 0) {
        // create column div
        this.columns = [];
        var width = (100 / num) + '%';
        while(num--) {
          var column = document.createElement('div');
          column.className = 'wf-column';
          column.style.width = width;
          this.columns.push(column);
          this.container.appendChild(column);
        }
      }
    };

    Waterfall.prototype.deleteEmptyColumns = function() {
      //console.log('deleting empty columns')
      var columns = document.getElementsByClassName('wf-column')
      for(var i=0;i<columns.length;i++){
        if(columns[i].innerHTML===''){
          //console.log('deleting empty column')
          columns[i].remove()
        }

      }
    };

    // get the index of shortest column
    Waterfall.prototype.getMinHeightIndex = function() {
      if(this.columns && this.columns.length > 0) {
        var min = this.columns[0].clientHeight, index = 0;
        for (var i = 1; i < this.columns.length; i++) {
          var columnElem = this.columns[i];
          if(columnElem.clientHeight < min) {
            min = columnElem.clientHeight;
            index = i;
          }
        }
        return index;
      }
      else return -1;
    };

    // get the index of highset column
    Waterfall.prototype.getHighestIndex = function() {
      if(this.columns && this.columns.length > 0) {
        var max = this.columns[0].clientHeight, index = 0;
        for (var i = 1; i < this.columns.length; i++) {
          var columnElem = this.columns[i];
          if(columnElem.clientHeight > max) {
              max = columnElem.clientHeight;
              index = i;
          }
        }
        return index;
      }
      else return -1;
    };

    // compose core
    Waterfall.prototype.compose = function(force) {
      this.deleteEmptyColumns()

      var opts = this.opts || {};
      var containerSelector = opts.containerSelector || '.wf-container';
      var boxSelector = opts.boxSelector || '.wf-box';

      // init properties
      this.minBoxWidth = opts.minBoxWidth || 250;
      this.columns = [];
      this.container = document.querySelector(containerSelector);
      this.boxes = this.container ?
          Array.prototype.slice.call(this.container.querySelectorAll(boxSelector)) : [];

      var num = this.computeNumberOfColumns();
      var cols = this.columns.length;

      if(force || num != cols) {
        // remove old column
        for (var i = 0; i < this.columns.length; i++) {
          var columnElem = this.columns[i];
          this.container.removeChild(columnElem);
        }

        // init new column
        this.initColumns(num);

        // compose
        for (var i = 0, l = this.boxes.length; i < l; i++) {
          var box = this.boxes[i];
          this.addBox(box);
        }
      }
      this.deleteEmptyColumns()
    };

    // add a new box to grid
    Waterfall.prototype.addBox = function(elem) {
        // push if new box
      if(this.boxes.indexOf(elem) < 0) this.boxes.push(elem);

      var columnIndex = this.getMinHeightIndex();
      if(columnIndex > -1) {
        var column = this.columns[columnIndex];
        column.appendChild(elem);
      }
    };

    return Waterfall;
}));
