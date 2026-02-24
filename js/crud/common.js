(function() {
	'use strict';

	window.showToast = function(type, message) {
		var messageId = type === 'success' ? 'successMessage' : 'failMessage';
		var toastId = type === 'success' ? 'successToast' : 'failToast';
		var msgElement = document.getElementById(messageId);
		if (msgElement) {
			msgElement.innerText = message;
			var toastElement = document.getElementById(toastId);
			if (toastElement && typeof bootstrap !== 'undefined') {
				var toast = new bootstrap.Toast(toastElement);
				toast.show();
			}
		}
	};
})();
