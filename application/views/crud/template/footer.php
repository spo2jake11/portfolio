<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
<script src="<?= base_url('js/crud/common.js') ?>"></script>
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
	});
</script>

</body>

</html>