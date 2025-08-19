<div id="alert" class="fixed top-4 z-50 left-1/2 transform -translate-x-1/2 -translate-y-full transition-all duration-500 ease-out">
  <h1  class="{{
    $type == 'success' ? 'bg-green-500' :
    ($type == 'warning' ? 'bg-orange-500' :
    ($type == 'error' ? 'bg-red-600' : ''))
}} text-ccblack p-4 rounded">{{ $message }}</h1>
</div>
<script>
    const alert = document.getElementById('alert');

    if (alert) {
        setTimeout(() => {
            alert.classList.remove('-translate-y-full');
            alert.classList.add('translate-y-4');
        }, 100)
        
        setTimeout(() => {
            alert.classList.remove('translate-y-4');
            alert.classList.add('-translate-y-full');
            setTimeout(() => {
                alert.style.display = 'none';
            }, 500)
        }, 3000);
    }
</script>
