@if(session('alert-section-success'))

<div class="alert alert-success" role="alert"  id="alert">
    {{ session('alert-section-success') }}

  </div>

<script type="text/javascript">
    setTimeout(function () {

        // Closing the alert
        $('#alert').alert('close');
    }, 5000);
</script>


@endif
