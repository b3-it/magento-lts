(function ( $, window, document ) {

    var instanceName = "solrSearch";

    /** **/
    /** Solr Search Plugin - Add this to a Form or Inputfield to create a Suggest Box **/
    /** **/

    $.fn.solrSearch = function(options) {

        var container = $j(this);

        if (!container.data(instanceName)) {                            // If Element has arbitrary data of InstanceName(Plugin)
            options = $.extend({}, $.fn.solrSearch.options, options);   // Create Optionhandler of existing Properties
            var instance = new solrSearch(container, options);          // Create new Instance of solrSearch prototype, at element with options
            container.data(instanceName, instance);                     // set arbitrary Instancename and Instance to the Element
            return instance;                                            // Return this Instance
        }

        return container.data(instanceName);                            // If already Existing, return the InstanceName
    };

    $.fn.isSolrSearchInstalled = function() {
        var container = $(this);
        return container.data(instanceName) != null;
    };

    $.fn.solrSearch.options = {

        'ajaxUrl'   : null,     // Url for the Ajax Request - If not set, abort
        'formID'    : null,     // ID of the used Form - If not set, no commit possible
        'suggestBox': null,     // The Id of your Suggestion Box - If not set, create default box
        'hideBox'   : true,     // Hide the Suggestion Box with focus lost - If not defined, included
        'keyNav'    : true,     // Key Navigation for Suggestions - If not set, included
        'keyNext'   : 40,       // Key for the next Item - If not set, arrow down
        'keyPrev'   : 38,       // Key for the preview Item - If not set, arrow up
    };

    var solrSearch = function(container, options) {
        this.options = options;
        this.container = container;
        this.suggestBox = null;

        this._init();
    };

    solrSearch.prototype = {
        '_init': function() {

            this._idHandler();

            if(!this._errorHandler()){
                console.log('Solr-Search: script init failed!');
                return;
            }

            var parentThis = this;

            this.container.on('input', function () {
                if(parentThis.container.val().length > 1){
                    parentThis._newSuggestion();
                }
                else{
                    parentThis.suggestBox.html('');
                }
            }).keydown(function (event) {
                if(parentThis.options.keyNav){
                    if(event.which === parentThis.options.keyNext && !parentThis.suggestBox.is(':empty')){
                        parentThis._keyNext();
                    }
                    if(event.which === parentThis.options.keyPrev && !parentThis.suggestBox.is(':empty')){
                        parentThis._keyPrev();
                    }
                }
            }).blur(function () {
                if(parentThis.options.hideBox){
                    parentThis.suggestBox.hide();
                }
            }).focus(function () {
                if(parentThis.options.hideBox) {
                    parentThis.suggestBox.show();
                }
            });

            this.suggestBox.on('mousedown', function (event) {
                event.preventDefault();
            });
        },

        '_idHandler': function () {
            if(this.options.formID !== null && this.options.formID.charAt(0) !== '#'){
                this.options.formID = '#' + this.options.formID;
            }

            if(this.options.suggestBox === null){
                this._createSuggestBox();
            }
            else if(this.options.suggestBox.charAt(0) !== '#'){
                this.options.suggestBox = '#' + this.options.suggestBox;
            }

            this.suggestBox = $j(this.options.suggestBox);
        },

        '_errorHandler': function () {
            if(this.options.ajaxUrl === null){
                console.log('Solr-Search: AjaxUrl not defined!');
                return false;
            }
            if(!this.suggestBox.length){
                console.log('Solr-Search: Suggestbox(ID) not found!');
                return false;
            }
            if(this.options.formID && !$j(this.options.formID).length){
                console.log('Solr-Search: Form(ID) not found!');
                return false;
            }
            return true;
        },

        '_createSuggestBox': function(){
            var id = this.container.attr('id') + '-suggest-box';
            this.container.parent().append('<section id=\"' + id + '\" class=\"solr-suggest-box\"></section>');
            this.options.suggestBox = '#' + id;
        },

        '_keyNext': function(){
            var element = this.suggestBox.children('a._active');
            if(!$j(element).length){
                this.container.val(this.suggestBox.children(':first').addClass('_active').attr("title")).focus();
            }
            else{
                if(!element.is(':last-child')){
                    element.removeClass('_active').next().addClass('_active');
                    this.container.val(element.next().attr("title"));
                }
                else{
                    element.removeClass('_active');
                    this.container.val(this.suggestBox.children(':first').addClass('_active').attr("title")).focus();
                }
            }
        },

        '_keyPrev': function(){
            var element = this.suggestBox.children('a._active');
            if(!element.length){
                this.container.val(this.suggestBox.children(':last').addClass('_active').attr("title")).focus();
            }
            else{
                if(!element.is(':first-child')){
                    element.removeClass('_active').prev().addClass('_active');
                    this.container.val(element.prev().attr("title"));
                }
                else{
                    element.removeClass('_active');
                    this.container.val(this.suggestBox.children(':last').addClass('_active').attr("title")).focus();
                }
            }
        },

        '_newSuggestion': function(){

            var parentThis = this;

            $j.ajax({
                'url': this.options.ajaxUrl,
                'method': 'POST',
                'data': {
                    'q': this.container.val()
                },
                'beforeSend': function () {
                }
            }).done(function (data) {
                parentThis.suggestBox.html('');
                var obj = $j.parseJSON(data);
                $j.each(obj, function (id, links) {
                    var newLink = $j('<a />', {
                        'href': 'javascript:void(0)',
                        'class': 'solr-suggest-item',
                        'tabIndex': 1000 + id,
                        'html': links,
                        'title': links,
                        'aria-label': links,
                    });
                    newLink.click(function () {
                        parentThis.container.val(links);
                        parentThis.suggestBox.hide();
                        $j(parentThis.options.formID).submit();
                    });
                    parentThis.suggestBox.append(newLink);
                });
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

    window.solrSearch = solrSearch;

})( jQuery, window, document );