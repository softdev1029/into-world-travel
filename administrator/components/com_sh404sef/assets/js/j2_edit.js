/**
 * sh404SEF - SEO extension for Joomla!
 *
 * @author      Yannick Gaultier
 * @copyright   (c) Yannick Gaultier - Weeblr llc - 2018
 * @package     sh404SEF
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     4.14.0.3812
 * @date		2018-05-16
 */

function shAjaxHandler(task, options, closewindow) {

	var form = document.id('adminForm');
	form.task.value = task;

	// Create a progress indicator
	var update = document.id("sh-message-box").empty();
	update.set("html", "<div class='sh-ajax-loading'>&nbsp;</div>");
	document.id("sh-error-box").empty();

	// Set the options of the form"s Request handler.
	var onSuccessFn = function(response, responseXML) {
		//alert(response);
		var root, status, message;
		try {
			root = responseXML.documentElement;
			status = root.getElementsByTagName("status").item(0).firstChild.nodeValue;
			message = root.getElementsByTagName("message").item(0).firstChild.nodeValue;
		} catch (err) {
			status = 'failure';
			message = "<div id='error-box-content'><ul><li>Sorry, something went wrong on the server while performing this action. Please retry or cancel</li>" +
			"<li>" + response + "</li>"
					"</ul></div>";
		}

		// remove progress indicator
		var update = document.id("sh-message-box").empty();

		// insert results
		if (status == "success") {
			update.set("html", message);
			if (closewindow) {
				setTimeout("window.parent.SqueezeBox.close()", 1500);
			} else {
				setTimeout("document.id('sh-message-box').empty()", 3000);
			}
		} else if (status == 'redirect') {
			setTimeout("parent.window.location='" + message + "';", 100);
			window.parent.shReloadModal = false;
			window.parent.SqueezeBox.close();
		} else {
			document.id('sh-error-box').set("html", message);
			setTimeout("document.id('sh-error-box').empty();", 5000);
		}

	};

	// Send the form.
	form.set( 'send', {url: 'index.php', method: 'post', onSuccess: onSuccessFn});
	form.send();
}

Joomla.submitbutton = function(pressbutton) {
	if (pressbutton == "cancel") {
		window.parent.shReloadModal = false;
		window.parent.SqueezeBox.close();
	}
	if (pressbutton == "back") {
		window.parent.shReloadModal = true;
		window.parent.SqueezeBox.close();
	}
};
