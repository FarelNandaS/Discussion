<div id="alert"
  class="fixed top-4 left-1/2 z-50 transform -translate-x-1/2 -translate-y-20 opacity-0 transition-all duration-500 ease-out w-[90%] max-w-md">
  <div id="alert-box" class="alert">
    <span id="alert-message"></span>
  </div>
</div>

<script>
  function showAlert(type, message) {
    const alertContainer = document.getElementById('alert');
    const alertBox = document.getElementById('alert-box');
    const alertMessage = document.getElementById('alert-message');

    // Reset semua kelas alert
    alertBox.className = 'alert'; // reset ke base

    // Tambah kelas sesuai tipe
    if (type === 'success') {
      alertBox.classList.add('alert-success');
    } else if (type === 'warning') {
      alertBox.classList.add('alert-warning');
    } else if (type === 'error') {
      alertBox.classList.add('alert-error');
    } else {
      alertBox.classList.add('alert-info'); // default
    }

    // Set pesan
    alertMessage.textContent = message;

    // Tampilkan dengan animasi slide turun
    alertContainer.classList.remove("opacity-0", "-translate-y-20");
    alertContainer.classList.add("opacity-100", "translate-y-0");

    // Auto hide setelah 3 detik
    setTimeout(() => {
      alertContainer.classList.remove("opacity-100", "translate-y-0");
      alertContainer.classList.add("opacity-0", "-translate-y-20");
    }, 3000);
  }
</script>