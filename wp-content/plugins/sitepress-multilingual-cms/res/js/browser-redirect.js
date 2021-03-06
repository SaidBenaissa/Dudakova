/*globals wpml_browser_redirect_params, jQuery, ajaxurl */

/** @namespace wpml_browser_redirect_params.pageLanguage */
/** @namespace wpml_browser_redirect_params.expiration */
/** @namespace wpml_browser_redirect_params.languageUrls */
/** @namespace navigator.browserLanguage */

var WPMLBrowserRedirect = function () {
	"use strict";

	var self = this;

	self.getExpirationDate = function () {
		var date = new Date();
		var currentTime = date.getTime();
		date.setTime(currentTime + (wpml_browser_redirect_params.cookie.expiration * 60 * 60 * 1000));
		return date;
	};

	self.getRedirectUrl = function (browserLanguage) {
		var redirectUrl = false;
		var languageUrls = wpml_browser_redirect_params.languageUrls;
		var languageFirstPart = browserLanguage.substr(0, 2);
		var languageLastPart = browserLanguage.substr(3, 2);

		if (languageUrls[browserLanguage] === undefined) {
			if (languageUrls[languageFirstPart] !== undefined) {
				redirectUrl = languageUrls[languageFirstPart];
			} else if (languageUrls[languageLastPart] !== undefined) {
				redirectUrl = languageUrls[languageLastPart];
			}
		} else {
			redirectUrl = languageUrls[browserLanguage];
		}
		return redirectUrl;
	};

	self.init = function () {
		var redirectUrl;
		var browserLanguage;
		var pageLanguage;

		if (self.cookiesAreEnabled() && !self.cookieExists()) {
			pageLanguage = wpml_browser_redirect_params.pageLanguage;
			browserLanguage = self.getBrowserLanguage();

			self.setCookie(browserLanguage);

			if (pageLanguage !== browserLanguage) {
				redirectUrl = self.getRedirectUrl(browserLanguage);
				if (false !== redirectUrl) {
					window.location = redirectUrl;
				}
			}
		}
	};

	self.cookieExists = function () {
		var cookieParams = wpml_browser_redirect_params.cookie;
		var cookieName = cookieParams.name;
		return jQuery.cookie(cookieName);
	};

	self.setCookie = function (browserLanguage) {
		var cookieOptions;
		var cookieParams = wpml_browser_redirect_params.cookie;
		var cookieName = cookieParams.name;
		var path = '/';
		var domain = '';

		if (cookieParams.path) {
			path = cookieParams.path;
		}

		if (cookieParams.domain) {
			domain = cookieParams.domain;
		}

		cookieOptions = {
			expires: self.getExpirationDate(),
			path:    path,
			domain:  domain
		};
		jQuery.cookie(cookieName, browserLanguage, cookieOptions);
	};

	self.getBrowserLanguage = function () {
		var browserLanguage = wpml_browser_redirect_params.pageLanguage;

		if(navigator.language || navigator.userLanguage) {
			browserLanguage = navigator.language || navigator.userLanguage;
		} else if(navigator.browserLanguage || navigator.systemLanguage) {
			browserLanguage = navigator.browserLanguage || navigator.systemLanguage;
		} else {
			jQuery.ajax({
				async:   false,
				data:    {
					icl_ajx_action: 'get_browser_language'
				},
				success: function (ret) {
					browserLanguage = ret;
				}
			});
		}
		return browserLanguage;
	};

	self.cookiesAreEnabled = function () {
		var result = (undefined !== jQuery.cookie);
		if (result) {
			jQuery.cookie('wpml_browser_redirect_test', 1);
			result = '1' === jQuery.cookie('wpml_browser_redirect_test');
			jQuery.cookie('wpml_browser_redirect_test', 0);
		}
		return result;
	};
};

jQuery(document).ready(function () {
	"use strict";

	var wpmlBrowserRedirect = new WPMLBrowserRedirect();
	wpmlBrowserRedirect.init();

});