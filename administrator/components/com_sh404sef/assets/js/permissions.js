/**
 * sh404SEF - SEO extension for Joomla!
 *
 * @author      Yannick Gaultier
 * @copyright   (c) Yannick Gaultier - Weeblr llc - 2018
 * @package     sh404SEF
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     4.14.0.3812
 * @date        2018-05-16
 */

/**
 * Function to send Permissions via Ajax to Com-Config Application Controller
 */
function shSendPermissions(event) {
    // set the icon while storing the values
    var icon = document.getElementById('icon_' + this.id);
    icon.removeAttribute('class');
    icon.setAttribute('style', 'background: url(../media/system/images/modal/spinner.gif); display: inline-block; width: 16px; height: 16px');

    var id = this.id.replace('jform_rules_', '');
    var lastUnderscoreIndex = id.lastIndexOf('_');

    var permission_data = {
        comp: 'com_sh404sef',
        action: id.substring(0, lastUnderscoreIndex),
        rule: id.substring(lastUnderscoreIndex + 1),
        value: this.value,
        title: 'com_sh404sef'
    };

    // Remove js messages, if they exist.
    Joomla.removeMessages();

    // doing ajax request
    jQuery.ajax({
        method: "POST",
        url: document.getElementById('permissions-sliders').getAttribute('data-ajaxuri'),
        data: permission_data,
        datatype: 'json'
    })
        .fail(function (jqXHR, textStatus, error) {
            // Remove the spinning icon.
            icon.removeAttribute('style');

            Joomla.renderMessages(Joomla.ajaxErrorsMessages(jqXHR, textStatus, error));

            window.scrollTo(0, 0);

            icon.setAttribute('class', 'icon-cancel');
        })
        .done(function (response) {
            // Remove the spinning icon.
            icon.removeAttribute('style');

            if (response.data) {
                // Check if everything is OK
                if (response.data.result == true) {
                    icon.setAttribute('class', 'icon-save');

                    jQuery(event.target).parents().next("td").find("span")
                        .removeClass()
                        .addClass(response['data']['class'])
                        .html(response.data.text);
                }
            }

            // Render messages, if any. There are only message in case of errors.
            if (typeof response.messages == 'object' && response.messages !== null) {
                Joomla.renderMessages(response.messages);

                if (response.data && response.data.result == true) {
                    icon.setAttribute('class', 'icon-save');
                }
                else {
                    icon.setAttribute('class', 'icon-cancel');
                }

                window.scrollTo(0, 0);
            }
        });
}
