<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
<!-- <script src="https:/opLeft/getbootstrap.com/docs/5.3/assets/js/color-modes.js"></script> -->

<script>
   
    const showToast = (type, message) => {
        let toastId, messageId;
        if (type === 'success') {
            toastId = 'successToast';
            messageId = 'successMessage';
        } else if (type === 'fail') {
            toastId = 'failToast';
            messageId = 'failMessage';
        }

        const msgElement = document.getElementById(messageId);
        if (msgElement) {
            msgElement.innerText = message;
            const toastElement = document.getElementById(toastId);
            const toast = new bootstrap.Toast(toastElement);
            toast.show();
        }
    };
</script>

</body>

</html>