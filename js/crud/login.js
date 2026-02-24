(function() {
	'use strict';

	let switcher = true;

	function createInput(name, type) {
		var newInput = document.createElement('input');
		newInput.type = type;
		newInput.name = name;
		newInput.id = name;
		newInput.classList.add('form-control');
		newInput.placeholder = name.charAt(0).toUpperCase() + name.slice(1);
		return newInput;
	}

	function createLabel(forId, text) {
		var newLabel = document.createElement('label');
		newLabel.htmlFor = forId;
		newLabel.textContent = text;
		return newLabel;
	}

	function createDiv(name, type, labelText) {
		var newDiv = document.createElement('div');
		newDiv.classList.add('form-floating', 'my-2');
		newDiv.appendChild(createInput(name, type));
		newDiv.appendChild(createLabel(name, labelText));
		return newDiv;
	}

	function register() {
		var btnChange = document.getElementById('btnLogin');
		var btnReg = document.getElementById('btnReg');
		var formConnect = document.getElementById('loginForm');
		var form = document.getElementById('emailDiv');
		var chkPw = document.getElementById('pwDiv');

		if (btnChange) btnChange.value = 'Register';
		if (btnReg) btnReg.innerText = 'Cancel';
		if (formConnect) formConnect.action = typeof window.CRUD_REGISTER_URL !== 'undefined' ? window.CRUD_REGISTER_URL : 'register';
		if (form) form.appendChild(createDiv('name', 'text', 'Name'));
		if (chkPw) chkPw.appendChild(createDiv('check_password', 'password', 'Confirm Password'));
	}

	function cancel() {
		var btnChange = document.getElementById('btnLogin');
		var btnReg = document.getElementById('btnReg');
		var formConnect = document.getElementById('loginForm');
		var form = document.getElementById('emailDiv');
		var chkPw = document.getElementById('pwDiv');

		if (btnChange) btnChange.value = 'Sign in';
		if (btnReg) btnReg.innerText = 'Register';
		if (formConnect && window.CRUD_VALIDATE_URL) formConnect.action = window.CRUD_VALIDATE_URL;
		if (form && form.lastChild) form.removeChild(form.lastChild);
		if (chkPw && chkPw.lastChild) chkPw.removeChild(chkPw.lastChild);
	}

	var btnReg = document.getElementById('btnReg');
	if (btnReg) {
		btnReg.addEventListener('click', function() {
			if (switcher) {
				register();
				switcher = false;
			} else {
				cancel();
				switcher = true;
			}
		});
	}
})();
