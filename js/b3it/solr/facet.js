(function ($, window, document) {

  var instanceName = "solrFacet";

  /** **/
  /** Solr Facet Plugin **/
  /** **/

  $.fn.solrFacet = function (options) {

    var container = $j(this);

    if (!container.data(instanceName)) {                            // If Element has arbitrary data of InstanceName(Plugin)
      options = $.extend({}, $.fn.solrFacet.options, options);   // Create Optionhandler of existing Properties
      var instance = new solrFacet(container, options);          // Create new Instance of solrFacet prototype, at element with options
      container.data(instanceName, instance);                     // set arbitrary Instancename and Instance to the Element
      return instance;                                            // Return this Instance
    }

    return container.data(instanceName);                            // If already Existing, return the InstanceName
  };

  $.fn.isSolrFacetInstalled = function () {
    var container = $(this);
    return container.data(instanceName) != null;
  };

  $.fn.solrFacet.options = {

    'ajaxUrl': null,     // Url for the Ajax Request - If not set, abort
    'resultId': null      // Id for the Result list - if not set, abort
  };

  var solrFacet = function (container, options) {
    this.options = options;
    this.container = container;
    this.resultContainer = null;

    this.filter = [];
    this.paging = {};

    this._init();
  };

  solrFacet.prototype = {
    '_init': function () {

      this._idHandler();

      if (!this._errorHandler()) {
        console.log('Solr-Facet: script init failed!');
        return;
      }

      this.resultContainer = $j(this.options.resultId);
      var parentThis = this;
      this._order();
      this._limiter();
      this._pager();

      // Change on Form, because it gets all changes
      $j(this.container).change(function () {
        parentThis.filter.length = 0;
        delete parentThis.paging.pager;
        delete parentThis.paging.current;
        $j('input:checkbox:checked', this).each(function () {
          let obj = {};
          obj['field'] = this.name;
          obj['value'] = ($j(this).val());
          parentThis.filter.push(obj);
        });
        $j('input:radio:checked', this).each(function () {
          let obj = {};
          obj['field'] = this.name;
          obj['value'] = ($j(this).val());
          parentThis.filter.push(obj);
        });
        parentThis._newResult();
      });
    },

    '_idHandler': function () {
      if (this.options.resultId !== null && this.options.resultId.charAt(0) !== '#') {
        this.options.resultId = '#' + this.options.resultId;
      }
    },

    '_errorHandler': function () {
      if (this.options.ajaxUrl === null) {
        console.log('Solr-Facet: AjaxUrl not defined!');
        return false;
      }
      if (!this.options.resultId || !$j(this.options.resultId).length) {
        console.log('Solr-Facet: Result Id not found!');
        return false;
      }
      return true;
    },

    '_order': function () {
      // Limiter
      let parentThis = this;
      $j('.toolbar .sort-by select', this.resultContainer).change(function () {
        delete parentThis.paging.pager;
        delete parentThis.paging.current;
        parentThis.paging['order'] = $j(this).val();
        parentThis._newResult();
      });
      $j('.toolbar a.sort-by-switcher--asc', this.resultContainer).on('click', function () {
        delete parentThis.paging.pager;
        delete parentThis.paging.current;
        parentThis.paging['direction'] = 'desc';
        parentThis._newResult();
      });
      $j('.toolbar a.sort-by-switcher--desc', this.resultContainer).on('click', function () {
        delete parentThis.paging.pager;
        delete parentThis.paging.current;
        parentThis.paging['direction'] = 'asc';
        parentThis._newResult();
      });
    },

    '_limiter': function () {
      // Limiter
      let parentThis = this;
      $j('.toolbar .limiter select', this.resultContainer).change(function () {
        delete parentThis.paging.pager;
        delete parentThis.paging.current;
        parentThis.paging['limiter'] = $j(this).val();
        parentThis._newResult();
      });
    },

    '_pager': function () {
      // Paging
      let parentThis = this;
      $j('.toolbar .pages li a', this.resultContainer).on('click', function () {
        parentThis.paging['pager'] = $j(this).parent().val();
        parentThis.paging['current'] = $j(this).parent().parent().find('li.current').val();
        parentThis._newResult();
      })
    },

    '_newResult': function () {

      var parentThis = this;

      $j.ajax({
        'url': this.options.ajaxUrl,
        'method': 'POST',
        'data': {
          'f': parentThis.filter,
          'p': parentThis.paging
        },
        'beforeSend': function () {
          // disable input
          $j('fieldset', parentThis.container).attr('disabled', true);
          $j('.toolbar .limiter select', parentThis.resultContainer).attr('disabled', true);
          $j('.toolbar .sort-by select', parentThis.resultContainer).attr('disabled', true);
          $j('.toolbar a.sort-by-switcher', parentThis.resultContainer).removeAttr('href').off('click');
          $j('.toolbar .pages li a', parentThis.resultContainer).removeAttr('href').off('click');
        }
      }).done(function (data) {
        // add results
        parentThis.resultContainer.html(data);
        parentThis._order();
        parentThis._limiter();
        parentThis._pager();
        $j('fieldset', parentThis.container).attr('disabled', false);
        $j( document ).trigger( "solrResultDoneAfter");
      }).fail(function (jqXHR, exception) {
        if (jqXHR.status === 0) {
          console.log('Not connect.n Verify Network.');
        } else if (jqXHR.status === 404) {
          console.log('Requested page not found. [404]');
        } else if (jqXHR.status === 500) {
          console.log('Internal Server Error [500].');
        } else if (exception === 'parsererror') {
          console.log('Requested JSON parse failed.');
        } else if (exception === 'timeout') {
          console.log('Time out error.');
        } else if (exception === 'abort') {
          console.log('Ajax request aborted.');
        } else {
          console.log('Uncaught Error.n' + jqXHR.responseText);
        }
      });
    }
  };

  window.solrFacet = solrFacet;

})(jQuery, window, document);
