(function() {
	var request, but = document.querySelector('button');

	but.addEventListener('click', function(ev) {

		navigator.id.getVerifiedEmail(function(assertion) {
			if (assertion) {
				verify(assertion);
			} else {
				alert('I still don\'t know you. Did you cancel?');
			}
		});

		function verify(assertion) {
			request = new XMLHttpRequest();
			var parameters = 'assert=' + assertion;
			request.open('POST', browserid_verify);
			request.setRequestHeader('If-Modified-Since',
					'Wed, 05 Apr 2006 00:00:00 GMT');
			request.setRequestHeader('Content-type',
					'application/x-www-form-urlencoded');
			request.setRequestHeader('Content-length', parameters.length);
			request.setRequestHeader('Connection', 'close');
			request.send(encodeURI(parameters));

			request.onreadystatechange = function() {
				if (request.readyState == 4) {
					if (request.status && (/200|304/).test(request.status)) {
						response = JSON.parse(request.responseText);
						if (response.status === 'okay') {
							self.location.href = "serendipity_admin.php"
						}
						else {if (response.status === 'errorhost' || response.status === 's9yunknown') {
							alert(response.message);
						}
						else {
							alert('Unknown error: ' . response.status);
						}
						}
					} else {
						alert('Sorry, I could not log you in.');
					}
				}
			};
		}

	}, false);
}());
