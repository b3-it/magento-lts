(function($, window, document){
	var instanceName = "touchSelect";
	
	/**
	 * Plugin bei jQuery registrieren
	 */
	$.fn.touchSelect = function(options) {
		var container = $(this);
		
		if (!container.data(instanceName)) {
			options = $.extend({}, $.fn.touchSelect.options, options);
			var instance = new touchSelect(container, options);
			container.data(instanceName, instance);
			return instance;
		}
		
		return container.data(instanceName);
    }
	
	/**
	 * Pruefen, ob das Plugin bereits existiert
	 */
	$.fn.isTouchSelectInstalled = function() {
	    var container = $(this);
	    return container.data(instanceName) != null;
	};
	
	/**
	 * Optionen setzen
	 */
	$.fn.touchSelect.options = {
        'elementID'    : null,           // ID des Elementes
        'elementTitle' : null,           // Info-Titel das Elementes
        'elementClass' : null,           // CSS-Klassen für die Darstellung des Buttons
        'elementAttr'  : 'data-code',    // In welchem Attribut befinden sich die Schalter-Beschriftungen 
        'elementData'  : 'value',        // In welchem Attribut befindet sich das Click-Ziel
        'elementInsert': '<div />',      // Struktur des einzufuegenden Elementes (als Child wird ein Link erzeugt)
        'elementParent': null,           // Wenn das neue Element nicht einzeln steht, muss hier der Parent rein
        'countOptions' : null,           // Interne Variable mit der Anzahl der Optionen
        'uiElement'    : null            // Elemente-ID von jQuery-UI
	};		

	var touchSelect = function(container, options) {
		/**
		 * Initialisierung aller Eigenschaften
		 */
		this.options = options;
		this.container = container;
		
        this._init();
	};        
    
	touchSelect.prototype = {
	    /**
         * Initial-Funktion
         */
        _init: function() {
        	this._checkDefaultIsComplete();
        	this._removeElementFromPage();
        	this._removeOnChange();
        	
        	if ( this.options.uiElement !== null ) {
        		this._moveRemoveElement(this.options.uiElement);
        	}
        	
        	if ( this.options.countOptions == 2 ) {
        		this._buildToggleButtons();
        	}
        },
        
        _openURL: function(url) {
        	window.location.href = url;
        },
        
        /**
         * Alle Default-Belegungen überpruefen und gegebenenfalls komplettieren
         */
        _checkDefaultIsComplete: function() {
        	if ( this.options.elementID == null ) {
        		this.options.elementID = $(this.container).attr('id');
        	}
        	if ( this.options.elementTitle == null ) {
        		this.options.elementTitle = $(this.container).attr('title');
        	}
        	if ( this.options.elementClass == null ) {
        		this.options.elementClass = 'button';
        	}
        	
        	if ( this.options.countOptions == null ) {
        		this.options.countOptions = $('#' + this.options.elementID + ' option').length;
        	}
        },
        
        /**
         * Wenn ein OnChange definiert ist, muss es entfernt werden
         */
        _removeOnChange: function() {
        	if ( $(this.container).attr('onchange') !== null ) {
        		$(this.container).removeAttr('onchange');
        	}
        },
        
        /**
         * Ursprungs-Element verbergen
         */
        _removeElementFromPage: function() {
        	if ( $(this.container).css('display') !== 'none' ) {
        		this._moveRemoveElement(this.options.elementID);
        	}
        },
        
        _moveRemoveElement: function(element) {
        	$('#' + element).css({
    			'display' : 'none',
    			'position': 'absolute',
    			'top'     : '-1000px',
    			'left'    : '-1000px'
    		});
        },

        /**
         * Wenn 2 Optionen vorhanden sind, dann einen Toggle-Schalter erzeugen
         */
        _buildToggleButtons: function() {
        	var elementText = $('#' + this.options.elementID + ' option:not(:selected)').attr(this.options.elementAttr);
        	var destinationURL = $('#' + this.options.elementID + ' option:not(:selected)').attr(this.options.elementData);
        	var elementNewID = 'touch-' + this.options.elementID;
        	
        	if ( this.options.elementParent == null ) {
        		var newElement = $(this.options.elementInsert, {
            		'id'       : elementNewID,
            		'title'    : this.options.elementTitle,
            		'class'    : this.options.elementClass,
            		'data-dest': destinationURL,
            		'text'     : elementText
            	});
        		
        		var neu = $(newElement).insertAfter(this.container);
        	}
        	else {
        		var parentElem = $(this.options.elementInsert, {
        			'id': 'parent-' + elementNewID
        		});
        		
        		var newElement = $('<a />', {
            		'href'     : 'javascript:void(0);',
            		'id'       : elementNewID,
            		'title'    : this.options.elementTitle,
            		'class'    : this.options.elementClass,
            		'data-dest': destinationURL,
            		'text'     : elementText
            	});
        		
        		$('#' + this.options.elementParent).append(parentElem);
        		var neu = $('#parent-' + elementNewID).append(newElement);
        	}
        	
        	neu.click(function(event){
        		event .preventDefault();
        		window.location.href = $('#' + elementNewID).attr('data-dest');
        		//this._openURL( $('#' + elementNewID).attr('data-dest') );
        	});
        }
	};
	
	window.touchSelect = touchSelect;

})(jQuery, window, document);