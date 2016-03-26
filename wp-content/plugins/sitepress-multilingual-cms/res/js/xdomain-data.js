jQuery(document).ready(function () {
    jQuery('#lang_sel a, #lang_sel_footer a, .menu-item-language a').on('click', function (event) {

        event.preventDefault();

        var original_url = jQuery(this).attr('href');
        // Filter out xdomain_data if already in the url
        original_url = original_url.replace(/&xdomain_data(\=[^&]*)?(?=&|$)|xdomain_data(\=[^&]*)?(&|$)/, '');
        original_url = original_url.replace(/\?$/, '');

        jQuery.ajax({
            url: icl_vars.ajax_url,
            type: 'post',
            dataType: 'json',
            async: false,
            data: {action: 'switching_language', from_language: icl_vars.current_language},
            success: function (ret) {

                if (ret.xdomain_data) {

                    if(ret.method == 'post') {

                        // POST
                        var form    = jQuery('<form method="post" action="' + original_url +'" >');
                        var xdomain = jQuery('<input type="hidden" name="xdomain_data" value="' + ret.xdomain_data + '">');

                        form.append(xdomain);
                        jQuery('body').append(form);

                        form.submit();
                        return false;

                    } else {
                        // GET
                        var url_split = original_url.split('#');
                        var hash = '';
                        if (url_split.length > 1) {
                            hash = '#' + url_split[1];
                        }
                        var url = url_split[0];
                        var args_glue = url.indexOf('?') !== -1 ? '&' : '?';
                        url = original_url + args_glue + 'xdomain_data=' + ret.xdomain_data + hash;
                    }

                } else {
                    url = original_url;
                }

                location.href = url;
                return false;

            },
            error: function () {
                location.href = original_url;
                return false;
            }
        });

        return false;


    });
});