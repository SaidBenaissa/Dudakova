var WPML_String_Translation = WPML_String_Translation || {};

WPML_String_Translation.ChangeLanguage = function () {
	var self         = this;
	var private_data = {};

	var init = function () {
		jQuery(document).ready(function() {
			jQuery('#icl_st_change_lang_selected').on('click', show_dialog);
			
			setup_dialog();
			
			private_data.language_select = jQuery('#wpml-change-language-dialog').find('select');
			private_data.language_select.on('change', language_changed);
			private_data.summary_text = jQuery('#wpml-change-language-dialog').find('.js-summary');
		});
	};
	
	var setup_dialog = function () {
		private_data.change_lang_dialog = jQuery('#wpml-change-language-dialog');
		private_data.change_lang_dialog.dialog(
			{
				autoOpen:      false,
				resizable:     false,
				modal:         true,
				width:         'auto',
				closeText:     private_data.change_lang_dialog.data('cancel-text'),
				closeOnEscape: true,
				buttons:       [
					{
						id:    'wpml-change-language-dialog-apply-button',
						text:  private_data.change_lang_dialog.data('button-text'),
						click: apply_changes
					}
				],
				close:         function () {
					//window.location.reload(true);
				}
			}
		);
		
		private_data.apply_button = jQuery('#wpml-change-language-dialog-apply-button');
		private_data.apply_button.prop('disabled', true).addClass('button-primary');
		private_data.spinner = private_data.change_lang_dialog.find('.wpml_tt_spinner');
		
	};
	
	var show_dialog = function () {
		var langs = get_languages_of_selected_strings();
		
		if (langs.length == 1) {
			private_data.language_select.val(langs[0]);
		}
		
		var summary = private_data.summary_text.data('text');
		
		var lang_text = '';
		for ( var i = 0; i < langs.length; i ++) {
			if (lang_text !== '') {
				lang_text += ', ';
			}
			lang_text += get_language_name(langs[i]);
		}
		summary = summary.replace('%LANG%', lang_text);
		private_data.summary_text.text(summary);
		
		private_data.change_lang_dialog.dialog('open');
	};
	
	var language_changed = function () {
		var lang = private_data.language_select.val();
		if (lang) {
			private_data.apply_button.prop('disabled', false);
		} else {
			private_data.apply_button.prop('disabled', true);
		}
	};
	
	var get_languages_of_selected_strings = function () {
		var langs = Array();
		
		var checkboxes = jQuery('#icl_string_translations').find('.icl_st_row_cb:checked');
		for ( var i = 0; i < checkboxes.length; i++ ) {
			var lang = jQuery(checkboxes[i]).data('language');
			if (langs.indexOf(lang) < 0) {
				langs.push(lang);
			}
		}
		
		return langs;
		
	};
	
	var apply_changes = function () {

		private_data.apply_button.prop('disabled', true);
		private_data.spinner.show();

		var strings = Array();
		var checkboxes = jQuery('#icl_string_translations').find('.icl_st_row_cb:checked');
		for (var i = 0; i < checkboxes.length; i++) {
			strings.push(jQuery(checkboxes[i]).val());
		}
		
		var data = {
			action:          'wpml_change_string_lang',
			wpnonce:         jQuery('#wpml_change_string_language_nonce').val(),
			strings:         strings,
			language:        private_data.language_select.val()
		};

		jQuery.ajax(
			{
				url:     ajaxurl,
				type:    'post',
				data:    data,
				dataType: 'json',
				success: function (response) {
					if ( response.success ) {
						window.location.reload(true);
					}
					if ( response.error ) {
						private_data.spinner.hide();
						alert(response.error);
						private_data.apply_button.prop('disabled', false);
					}
				}
			}
		);

	};
	
	var get_language_name = function ( code ) {
		if (code === '') {
			code = 'en';
		}
		var options = private_data.language_select.find('option');
		
		for (var i = 0; i < options.length; i++) {
			if (jQuery(options[i]).val() == code) {
				return jQuery(options[i]).text();
			}
		}
		
		// not found so just return the code.
		return code;
	};
	
	init();
	
};

WPML_String_Translation.change_language = new WPML_String_Translation.ChangeLanguage();

