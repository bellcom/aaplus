; (function($, undefined) {
  var storage = sessionStorage,
      storageKey = 'aaplus_locations',

      /**
       * Get the current url.
       */
      getCurrentUrl = function() {
        return document.location.pathname;
      },

      /**
       * Get all stored locations, i.e. a map from path to element id.
       */
      getLocations = function() {
        var locations = {};
        var value = storage.getItem(storageKey);
        if (value) {
          try {
            locations = JSON.parse(value);
          } catch (ex) {}
        }
        if (!$.isPlainObject(locations)) {
          locations = {};
        }
        return locations;
      },

      /**
       * Get location for the current page or a specified url.
       */
      getLocation = function(url, keep) {
        if (!url) {
          url = getCurrentUrl();
        }
        var locations = getLocations();
        var id = locations[url];
        // if (!keep) {
        //  setLocation(null, url);
        // }
        return id;
      },

      /**
       * Stores the id for the current location or a specified location.
       */
      setLocation = function(id, url) {
        if (!url) {
          url = getCurrentUrl();
          setHash(id);
        }
        var locations = getLocations();
        if (id) {
          locations[url] = id;
        } else {
          delete locations[url];
        }
        storage.setItem(storageKey, JSON.stringify(locations));
      },

      /**
       * Scroll an element into view.
       */
      scrollIntoView = function(el, offset) {
        if (!offset) {
          offset = 0;
        }
        // @see http://stackoverflow.com/a/2906009
        var container = $('html');
        var header = $('.navbar-fixed-top');
        container.scrollTop($(el).offset().top - header.height() - offset);
      },

      /**
       * Set url fragment identifier (hash) and scroll any element matching the hash into view.
       */
      setHash = function(hash) {
        if (!hash) {
          return;
        }
        hash = '#' + hash.replace(/^#+/, '');
        document.location.hash = hash;

        var el = $('a[href="' + hash + '"]');
        if (el.length > 0 && el.tab) {
          el.tab('show');
          scrollIntoView(el.closest('ul'));
        } else {
          el = $(hash);
          if (el.is('tr, th, td')) {
            var fixedHeader = el.closest('table').prev('.floatThead-container');
            scrollIntoView(el, fixedHeader.length === 0 ? 0 : fixedHeader.height());
          } else {
            scrollIntoView(el);
          }
        }
      };

  $(document).ready(function() {
    $("textarea").autoGrow();

    $(".table-header-rotated").floatThead({
      position: 'fixed',
      top: 50
    });

    $('a.btn').on('click', function(event) {
      var id = this.id ? this.id : $(this).closest('[id]').attr('id');
      if (id) {
        setLocation(id);
      }
    });

    $('[data-toggle=tab][href^=#]').on('click', function(event) {
      var id = $(this).attr('href').replace(/^#/, '');
      if (id) {
        setLocation(id);
      }
    });

    // Get hash or any stored location and scroll element into view.
    var hash = location.hash ? location.hash : getLocation();
    if (hash) {
      setHash(hash);
    }
  });
}(jQuery));
