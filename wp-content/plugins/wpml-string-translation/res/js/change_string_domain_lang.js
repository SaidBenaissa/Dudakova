var WPML_String_Translation = WPML_String_Translation || {};

WPML_String_Translation.ChangeDomainLanguage = function () {
	var self         = this;
	var private_data = {};

	var init = function () {
		jQuery(document).ready(function() {

			private_data.summary_div   = jQuery('#wpml-change-domain-language-dialog').find('.js-summary')
			private_data.lang_select   = jQuery(private_data.summary_div).find('select');
			private_data.apply_button  = jQuery('#wpml-change-domain-language-dialog-apply-button');
			private_data.table_body    = private_data.summary_div.find('table').find('tbody');
			private_data.domain_select = jQuery('#wpml-domain-select');

			setup_dialog();
			
			jQuery('#wpml-language-of-domains-link').on('click', show_dialog);
			private_data.domain_select.on('change', show_summary);
			
			private_data.apply_button.prop('disabled', true).addClass('button-primary');
			
			jQuery(private_data.summary_div).find('.js-all-check').on('click', check_all_click);

			private_data.lang_select.on('change', change_language);
			
			jQuery(private_data.summary_div).find('.js-default').on('click', enable_apply_button);
			
			
		});
	}
	
	var setup_dialog = function () {
		private_data.change_lang_dialog = jQuery('#wpml-change-domain-language-dialog');
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
						id:    'wpml-change-domain-language-dialog-apply-button',
						text:  private_data.change_lang_dialog.data('button-text'),
						click: apply_changes
					}
				],
				close:         function () {
					//window.location.reload(true);
				}
			}
		);
		
		private_data.apply_button = jQuery('#wpml-change-domain-language-dialog-apply-button');
		private_data.spinner = private_data.change_lang_dialog.find('.wpml_tt_spinner');
		enable_apply_button();
		
	}
	
	var show_dialog = function () {
		private_data.change_lang_dialog.dialog('open');
	}
	
	var show_summary = function () {
		var domain = jQuery(this).val();
		if (domain) {
			build_table(jQuery(this).find('option:selected').data('langs'));

			var domain_lang = jQuery(this).find('option:selected').data('domain_lang');
			private_data.lang_select.val(domain_lang);

			private_data.summary_div.show();
			
		} else {
			private_data.summary_div.hide();
		}
	}
	
	var build_table = function (data) {
		jQuery(private_data.summary_div).find('.js-lang').off('click');

		private_data.table_body.empty();
		
		for( var i = 0; i < data.length; i++ ) {
			tr = ''
			if (i % 2) {
				tr += '<tr class="alternate">'
			} else {
				tr += '<tr>';
			}
			tr += '<td>';
			tr += '<input class="js-lang" type="checkbox" value="' + data[i].language + '" />';
			tr += '</td>';
			tr += '<td>';
			tr += data[i].display_name;
			tr += '</td>';
			tr += '<td class="num">';
			tr += data[i].count;
			tr += '</td>';
			tr += '</tr>';
			private_data.table_body.append(tr);
		}
		
		jQuery(private_data.summary_div).find('.js-lang').on('click', lang_click);
		
	}
	
	var apply_changes = function () {
		
		private_data.apply_button.prop('disabled', true);
		private_data.spinner.show();

		var langs = Array();
		private_data.summary_div.find('.js-lang:checked').each( function () {
			langs.push(jQuery(this).val());
		})
		
		var data = {
			action:          'wpml_change_string_lang_of_domain',
			wpnonce:         jQuery('#wpml_change_string_domain_language_nonce').val(),
			domain:          private_data.domain_select.val(),
			langs:      	 langs,
			use_default:     private_data.summary_div.find('.js-default:checked').length > 0,
			language:        private_data.lang_select.val()
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
	}
	
	var check_all_click = function () {
		var selected = jQuery(this).prop('checked');
		jQuery(private_data.summary_div).find('.js-lang').prop('checked', selected);
		enable_apply_button();
	}
	
	var lang_click = function () {
		var all_langs_checked = jQuery(private_data.summary_div).find('.js-lang').length ==
									jQuery(private_data.summary_div).find('.js-lang:checked').length;
		jQuery(private_data.summary_div).find('.js-all-check').prop('checked', all_langs_checked);
		enable_apply_button();
	}
	
	var change_language = function () {
		enable_apply_button();
	}
	
	var enable_apply_button = function () {
		var lang = private_data.lang_select.val();
		if (lang && private_data.summary_div.find('input[type=checkbox]:checked').length) {
			private_data.apply_button.prop('disabled', false);
		} else {
			private_data.apply_button.prop('disabled', true);
		}
		
	}
	
	init();
	
};

WPML_String_Translation.change_domain_language = new WPML_String_Translation.ChangeDomainLanguage();

