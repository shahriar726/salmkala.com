@if(session('alert-section-error'))

    <div class="alert alert-danger" role="alert"  id="alert">
        {{ session('alert-section-error') }}

    </div>

    <script type="text/javascript">
        setTimeout(function () {

            // Closing the alert
            $('#alert').alert('close');
        }, 5000);
    </script>


@endif
