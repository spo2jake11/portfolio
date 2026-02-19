<!-- Flash toasts (replaced with SweetAlert2 toasts) -->


<main class="form-signin container d-flex flex-row align-items-center justify-content-center p-4">
	<form action="<?= base_url('validate') ?>" method="post" id="loginForm" class="w-50" style="min-width: 0;">
		<input type="hidden" name="data" />
		<img
			class="mb-4"
			src="<?= base_url('assets/icons/grok.png') ?>"
			alt=""
			width="72"
			height="57" />

		<h1 class="h3 mb-3 fw-normal">Sign In</h1>

		<div class="form-floating my-2" id="emailDiv">
			<input
				type="email"
				class="form-control "
				id="floatingInput"
				name="email"
				placeholder="name@example.com" />
			<label for="floatingInput">Email address</label>
		</div>

		<div class="form-floating my-2" id="pwDiv">
			<input
				type="password"
				class="form-control"
				id="floatingPassword"
				name="password"
				placeholder="Password" />
			<label for="floatingPassword">Password</label>
		</div>

		<input
			class="btn btn-primary w-100 py-2 my-2"
			type="submit"
			id="btnLogin"
			value="Sign in" />

		<button class="btn btn-secondary w-100 py-2 my-2" type="button" id="btnReg">
			Register
		</button>

		<p class="mt-5 mb-3 text-body-secondary text-center">© 2026</p>
	</form>
	<aside class="w-75 mx-2 text-center">
		<h3 class="mb-3">Welcome to NightBoard</h3>
		<p>A simple message board for users to share their thoughts and ideas.</p>
		<p>Login or create an account to get started.</p>
	</aside>
</main>

<script>
	let switcher = true;

	document.getElementById("btnReg").addEventListener("click", function() {
		if (switcher) {
			register();
			switcher = false;
		} else if (!switcher) {
			cancel();
			switcher = true;
		}
	});

	function register() {
		btn_change = document.getElementById("btnLogin");
		btn_change.value = "Register";

		btn_reg = document.getElementById("btnReg");
		btn_reg.innerText = "Cancel";

		form_connect = document.getElementById("loginForm");
		form_connect.action = "register";

		form = document.getElementById("emailDiv");
		chk_pw = document.getElementById("pwDiv");

		form.appendChild(createDiv("name", "text", "Name"));
		chk_pw.appendChild(
			createDiv("check_password", "password", "Confirm Password"),
		);
	}

	function cancel() {
		btn_change = document.getElementById("btnLogin");
		btn_change.value = "Sign in";

		btn_reg = document.getElementById("btnReg");
		btn_reg.innerText = "Register";

		form_connect = document.getElementById("loginForm");
		form_connect.action = "<?= base_url('validate') ?>";

		form = document.getElementById("emailDiv");
		chk_pw = document.getElementById("pwDiv");

		form.removeChild(form.lastChild);
		chk_pw.removeChild(chk_pw.lastChild);
	}

	function createInput(name = "", type = "") {
		newInput = document.createElement("input");
		newInput.type = type;
		newInput.name = name;
		newInput.classList.add("form-control");
		newInput.placeholder = name.charAt(0).toUpperCase() + name.slice(1);
		return newInput;
	}

	function createLabel(name = "") {
		newLabel = document.createElement("label");
		newLabel.for = name;
		newLabel.innerText = name.charAt(0).toUpperCase() + name.slice(1);
		return newLabel;
	}

	function createDiv(name = "", type = "", label_name = "") {
		newDiv = document.createElement("div");
		newDiv.classList.add("form-floating", "my-2");

		newDiv.appendChild(createInput(name, type));
		newDiv.appendChild(createLabel(label_name));
		return newDiv;
	}
	// show toasts based on server-side flashdata (CodeIgniter)
	document.addEventListener('DOMContentLoaded', function() {
		<?php if ($this->session->flashdata('success')): ?>
				(function() {
					const msg = <?= json_encode($this->session->flashdata('success')) ?>;
					Swal.fire({
						toast: true,
						position: 'top',
						icon: 'success',
						title: msg,
						showConfirmButton: false,
						timer: 3000
					});
				})();
		<?php endif; ?>

		<?php if ($this->session->flashdata('error')): ?>
				(function() {
					const msg = <?= json_encode($this->session->flashdata('error')) ?>;
					Swal.fire({
						toast: true,
						position: 'top',
						icon: 'error',
						title: msg,
						showConfirmButton: false,
						timer: 4000
					});
				})();
		<?php endif; ?>

		<?php if ($this->session->flashdata('errors')): ?>
				(function() {
					const msgs = <?= json_encode($this->session->flashdata('errors')) ?>;
					const body = Array.isArray(msgs) ? msgs.join('\n') : msgs;
					Swal.fire({
						toast: true,
						position: 'top',
						icon: 'warning',
						title: body,
						showConfirmButton: false,
						timer: 4000
					});
				})();
		<?php endif; ?>
	});
</script>