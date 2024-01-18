/**
 * jQuery document ready function to initialize script when the DOM is fully loaded.
 */
(function( $ ) {
	'use strict';

	/**
	 * Document ready event.
	 */
	$(document).ready(function () {

		/**
		 * Form submit event for the settings form.
		 */
		$('#socialo_cricket_live_score_settings_form').on('submit', function (event) {
			// Prevent the default form submission
			event.preventDefault();

			// Create a new FormData object and append form data
			let formData = new FormData(this);
			formData.append('action', 'socialo_cricket_live_score_update_settings'); // The PHP action hook
			formData.append('_wpnonce', socialo_cricket_live_score_object.nonce); // Nonce value

			// Send AJAX request
			$.ajax({
				type: 'POST',
				url: socialo_cricket_live_score_object.ajax_url,
				data: formData,
				processData: false,
				contentType: false,
				success: function (response) {
					// Handle success
					socialoCricketLiveScore_ShowResponseMessage(response.data, 'bg-success');
				},
				error: function (error) {
					// Handle error
					socialoCricketLiveScore_ShowResponseMessage('An error occurred while processing your request', 'bg-danger');
				}
			});
		});

		/**
		 * Copy button click event.
		 */
		$('.socialo-cricket-live-score .copy-button').on('click', function() {
			let element = $(this);
			// Copy shortcode to clipboard
			socialoCricketLiveScore_copyToClipboard('.socialo-cricket-live-score .shortcode-input');
			// Update button text to 'Copied' for 2 seconds
			socialoCricketLiveScore_updateCopyButton('Copied', 2000, element);
		});

		/**
		 * Function to copy text to clipboard.
		 */
		function socialoCricketLiveScore_copyToClipboard(element) {
			let textToCopy = $(element).val();
			let tempInput = $('<input>');
			$('body').append(tempInput);
			tempInput.val(textToCopy).select();
			document.execCommand('copy');
			tempInput.remove();
		}

		/**
		 * Function to update copy button text and reset after a specified duration.
		 */
		function socialoCricketLiveScore_updateCopyButton(newText, duration = 0, element) {
			let copyButton = element;
			let originalText = copyButton.text();
			copyButton.text(newText);
			if (duration > 0) {
				setTimeout(function () {
					copyButton.text(originalText);
				}, duration);
			}
		}

		/**
		 * Function to show response message and hide it after 3 seconds.
		 */
		function socialoCricketLiveScore_ShowResponseMessage(message, className) {
			let responseElement = $('.socialo-cricket-live-score form .response-message');
			responseElement.text(message).removeClass('bg-success bg-danger').addClass(className).parent().removeClass('hide');

			// Hide the message after 3 seconds
			setTimeout(function () {
				responseElement.parent().addClass('hide');
			}, 3000);
		}
	});

})( jQuery );
