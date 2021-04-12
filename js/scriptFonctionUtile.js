
$(document).ready(function() {

    $('body').delegate('input.only_integer','keyup',function(){
		if(!$(this).val().match(/^\d+$/))	// numbers
			remove_last_input(this);
	});
        
	// input only integers
	$('body').delegate('input.only_integer_plus_neg','keyup',function(){
		if(!$(this).val().match(/^-?\d+$/))	// numbers
			remove_last_input(this);
	});
        
        // input only integers
	$('body').delegate('input.only_remise','keyup',function(){
		if(!$(this).val().match(/^\-?[0-9]*[\.,]?[0-9]{0,2}?[(U|%)]{0,1}$/))	// numbers
			remove_last_input(this);
	}); 
        
        // input only modele reglement
	$('body').delegate('input.only_modele_reglement','keyup',function(){
		if(!$(this).val().match(/^\-?[0-9]*[\.,]?[0-9]{0,2}?[(F|%)]{0,1}$/))	// numbers
			remove_last_input(this);
	});

    // input only floats
    $('body').delegate('input.only_float','keyup',function(){
        if(!$(this).val().match(/^\-?[0-9]*[\.,]?[0-9]{0,2}$/))	// numbers[.,]numbers
            remove_last_input(this);
    });
    // input only floats
    $('body').delegate('input.only_float_pos','keyup',function(){
        if(!$(this).val().match(/^[0-9]*[\.,]?[0-9]{0,2}$/))	// numbers[.,]numbers
            remove_last_input(this);
    });

	// input phone number
	$('body').delegate('input.only_phone_number','keyup',function(){
		if(!$(this).val().match(/^\+?[0-9]*$/))	// +numbers or space
			remove_last_input(this);
	});

	// input zip code
	$('body').delegate('input.only_zip_code','keyup',function(){
		if(!$(this).val().match(/^[0-9]{0,5}$/))	// 5 numbers maximum
			remove_last_input(this);
	});

	// input email
	$('body').delegate('input.only_email','keyup',function(){
		if(!$(this).val().match(/^[a-z0-9\-\.\_]*@?[a-z0-9\-\.]*\.?[0-9a-z]*$/i))	// a-z and 0-9
			remove_last_input(this);
	});

	// input alpha-num
	$('body').delegate('input.only_alpha_num','keyup',function(){
		if(!$(this).val().match(/^[0-9a-z]*$/i))	// a-z and 0-9
			remove_last_input(this);
	});

	// input alpha
	$('body').delegate('input.only_alpha','keyup',function(){
		if(!$(this).val().match(/^[a-z]*$/i))	// a-z
			remove_last_input(this);
	});

	// input hex
	$('body').delegate('input.only_hex','keyup',function(){
		if(!$(this).val().match(/^[0-9a-f]*$/i))	// 0-9 a-f
			remove_last_input(this);
	});

	// input oct
	$('body').delegate('input.only_oct','keyup',function(){
		if(!$(this).val().match(/^[0-7]*$/i))	// 0-7
			remove_last_input(this);
	});

	// input chemical element
	$('body').delegate('input.only_from_list','keyup',function(){
		var available_values = $(this).attr('list').split(','); // get le valid values from the 'list' attribut
		var val = $(this).val();
		if (val) { // something to analyse
			var valid_input = false;
			for (var elm in available_values) {
				if (val == available_values[elm].substr(0,val.length)) {
					valid_input = true; break;
				}
			}

			if (!valid_input)
				remove_last_input(this);
		}
	});

$.widget( "custom.combobox", {
      _create: function() {
          
        this.wrapper = $( "<span>" )
            .addClass( "custom-combobox" )
            .css("width", "100%")
            .insertAfter( this.element );
 
        this.element.hide();
        this._createAutocomplete();
        this._createShowAllButton();
      },
 
      _createAutocomplete: function() {
        var selected = this.element.children( ":selected" ),
          value = selected.val() ? selected.text() : "";
 
        this.input = $( "<input>" )
          .appendTo( this.wrapper )
          .val( value )
          .attr( "title", "" )
          .addClass( "form-control" )
          .autocomplete({
            delay: 0,
            minLength: 0,
            source: $.proxy( this, "_source" )
          })
          .tooltip({
            tooltipClass: "ui-state-highlight"
          });
 
        this._on( this.input, {
          autocompleteselect: function( event, ui ) {
            ui.item.option.selected = true;
                        this._trigger( "select", event, {
              item: ui.item.option
            });
          },
 
          autocompletechange: "_removeIfInvalid"
        });
      },
 
      _createShowAllButton: function() {
        var input = this.input,
          wasOpen = false;
 
        $( "<a>" )
          .attr( "tabIndex", -1 )
          .attr( "title", "Show All Items" )
          .tooltip()
          .appendTo( this.wrapper )
          .button({
            icons: {
              primary: "ui-icon-triangle-1-s"
            },
            text: false
          })
          .removeClass( "ui-corner-all" )
          .addClass( "custom-combobox-toggle ui-corner-right" )
          .mousedown(function() {
            wasOpen = input.autocomplete( "widget" ).is( ":visible" );
          })
          .click(function() {
            input.focus();
 
            // Close if already visible
            if ( wasOpen ) {
              return;
            }
 
            // Pass empty string as value to search for, displaying all results
            input.autocomplete( "search", "" );
          });
      },
 
      _source: function( request, response ) {
        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
        response( this.element.children( "option" ).map(function() {
          var text = $( this ).text();
          if ( this.value && ( !request.term || matcher.test(text) ) )
            return {
              label: text,
              value: text,
              option: this
            };
        }) );
      },
 
      _removeIfInvalid: function( event, ui ) {
 
        // Selected an item, nothing to do
        if ( ui.item ) {
          return;
        }
 
        // Search for a match (case-insensitive)
        var value = this.input.val(),
          valueLowerCase = value.toLowerCase(),
          valid = false;
        this.element.children( "option" ).each(function() {
          if ( $( this ).text().toLowerCase() === valueLowerCase ) {
            this.selected = valid = true;
            return false;
          }
        });
 
        // Found a match, nothing to do
        if ( valid ) {
          return;
        }
 
        // Remove invalid value
        this.input
          .val( "" )
          .attr( "title", value + " didn't match any item" )
          .tooltip( "open" );
        this.element.val( "" );
        this._delay(function() {
          this.input.tooltip( "close" ).attr( "title", "" );
        }, 2500 );
        this.input.autocomplete( "instance" ).term = "";
      },
 
      _destroy: function() {
        this.wrapper.remove();
        this.element.show();
      }
    });
    

}); // end of document.ready


function remove_last_input(elm) {
	var val = $(elm).val();
	var cursorPos = elm.selectionStart;
	$(elm).val(	val.substr(0,cursorPos-1) +			// before cursor - 1
				val.substr(cursorPos,val.length)	// after  cursor
	)
	elm.selectionStart = cursorPos-1;				// replace the cursor at the right place
	elm.selectionEnd   = cursorPos-1;
}