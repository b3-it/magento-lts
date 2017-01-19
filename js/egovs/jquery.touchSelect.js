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
        'elementID'    : null,           // ID fuer des Elementes
        'elementTitle' : null,           // Info-Titel fuer das Elementes
        'elementClass' : null,           // CSS-Klassen für die Darstellung des Elements
        'elementAttr'  : 'data-code',    // In welchem Attribut befinden sich die Schalter-Beschriftungen 
        'elementData'  : 'value',        // In welchem Attribut befindet sich das Click-Ziel
        'elementInsert': '<div />',      // Struktur des einzufuegenden Elementes (als Child wird ein Link erzeugt)
        'elementParent': null,           // Wenn das neue Element nicht einzeln steht, muss hier der Parent rein
        'countOptions' : null,           // Interne Variable mit der Anzahl der Optionen
        'flagsUse'     : false,          // Soll fuer die Anzeige ein Bild oder der Schriftzug verwendet werden
        'flagsSubPath' : '',             // Wo sind die Bilder mit den Flaggen zu finden (Relativ zum Media-Pfad)
        'flagsType'    : '',             // Welche Datei-Endung haben die Flaggen
        'uiElement'    : null,           // Elemente-ID von jQuery-UI
        'uiFindElement': false           // Wird der Wert TRUE, wird automatisch das zugehörige UI-Element gesucht
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
        '_init': function() {
        	this._checkDefaultIsComplete();
        	this._removeElementFromPage();
        	this._removeOnChange();
        	
        	if ( this.options.uiElement !== null ) {
        		this._moveRemoveElement(this.options.uiElement);
        	}
        	
        	if ( this.options.countOptions == 2 ) {
        		this._buildToggleButtons();
        	}
        	else {
        		this._buildMultiToggleButtons();
        	}
        },
        
        /**
         * URL öffnen
         */
        '_openURL': function(url) {
        	window.location.href = url;
        },
        
        /**
         * Alle Default-Belegungen überpruefen und gegebenenfalls komplettieren
         */
        '_checkDefaultIsComplete': function() {
        	if ( this.options.elementID == null ) {
        		this.options.elementID = $(this.container).attr('id');
        	}
        	if ( this.options.elementTitle == null ) {
        		this.options.elementTitle = $(this.container).attr('title');
        	}
        	if ( this.options.elementClass == null ) {
        		this.options.elementClass = 'button';
        	}
        	
        	if ( this.options.uiFindElement == true ) {
        		this.options.uiElement = this.options.elementID + '-button';
        	}
        	
        	if ( this.options.countOptions == null ) {
        		this.options.countOptions = $('#' + this.options.elementID + ' option').length;
        	}
        },
        
        /**
         * Wenn ein OnChange definiert ist, muss es entfernt werden
         */
        '_removeOnChange': function() {
        	if ( $(this.container).attr('onchange') !== null ) {
        		$(this.container).removeAttr('onchange');
        	}
        },
        
        /**
         * Ursprungs-Element verbergen
         */
        '_removeElementFromPage': function() {
        	if ( $(this.container).css('display') !== 'none' ) {
        		this._moveRemoveElement(this.options.elementID);
        	}
        },
        
        /**
         * ein auf der Seite vorhandenes Element aus der Anzeige entfernen;
         * Das per JS erledigen, damit ein Fallback für normale Funktion vorhanden ist
         */
        '_moveRemoveElement': function(element) {
        	$('#' + element).css({
    			'display' : 'none',
    			'position': 'absolute',
    			'top'     : '-1000px',
    			'left'    : '-1000px'
    		});
        },

        /**
         * Wenn GENAU 2 Optionen vorhanden sind, dann einen Toggle-Schalter erzeugen
         */
        '_buildToggleButtons': function() {
        	var elementText = $('#' + this.options.elementID + ' option:not(:selected)').attr(this.options.elementAttr);
        	var destinationURL = $('#' + this.options.elementID + ' option:not(:selected)').attr(this.options.elementData);
        	var elementNewID = 'touch-' + this.options.elementID;
        	
        	// Falls die Flagge angezeigt werden soll, hier das noetige Element erzeugen
        	if ( this.options.flagsUse == true ) {
        	    var image = $('<img />', {
        	    	'src'  : baseUrl + 'media/' + this.options.flagsSubPath + '/' +
		                     elementText.toLowerCase() + '.' + this.options.flagsType,
        	    	'title': elementText,
        	    	'alt'  : elementText
        	    });
        	    elementText = '';
        	}
        	
        	if ( this.options.elementParent == null ) {
        		// Einzelnes Element einfügen
        		var newElement = $(this.options.elementInsert, {
            		'id'       : elementNewID,
            		'title'    : this.options.elementTitle,
            		'class'    : this.options.elementClass,
            		'data-dest': destinationURL,
            		'text'     : elementText
            	});
        		
        		var neu = $(newElement).insertAfter(this.container).css('cursor', 'pointer');
        	}
        	else {
        		// Sub-Element einfügen (Listen, Container, ...)
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

        		$('#' + this.options.elementParent).append(parentElem).css('cursor', 'pointer');
        		var neu = $('#parent-' + elementNewID).append(newElement).css('cursor', 'pointer');
        	}

    		// Falls die Flagge angezeigt werden soll, so muss das Element eingefügt werden
        	if ( this.options.flagsUse == true ) {
    			$('#' + elementNewID).append(image);
    		}

        	// Click-Event erzeugen, damit es bei allen Elementen funktioniert
        	neu.click(function(event){
        		// Falls das Element ein eigenes Klick-Event hat, so muss das beendet werden
        		event.preventDefault();
        		touchSelect.prototype._openURL( $('#' + elementNewID).attr('data-dest') );
        	});
        },
        
        /**
         * Wenn MEHR als 2 Optionen vorhanden sind, muss ein Drop-Down erzeugt werden
         */
        '_buildMultiToggleButtons': function() {
        	//alert('buildMultiToggleButtons :: Work in Progress...');
        }
	};
	
	window.touchSelect = touchSelect;

})(jQuery, window, document);