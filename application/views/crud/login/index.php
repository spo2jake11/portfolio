<!-- Flash toasts (replaced with SweetAlert2 toasts) -->


<main class="form-signin container d-flex flex-row align-items-center justify-content-center p-4">
	<form action="<?= base_url('validate') ?>" method="post" id="loginForm" class="w-50 login-form-flex">
		<input type="hidden" name="data" />

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
		<h3 class="mb-3">Welcome to <img
				class="mb-4 img-fluid login-welcome-img"
				src="<?= base_url('/assets/icons/night.png') ?>"
				alt="" />
		</h3>
		<p>A simple message board for users to share their thoughts and ideas.</p>
		<p>Login or create an account to get started.</p>
	</aside>
</main>

<script>
	window.CRUD_VALIDATE_URL = <?= json_encode(base_url('validate')) ?>;
</script>
<script src="<?= base_url('js/crud/login.js') ?>"></script>
<script>
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