@session('message')
    <script>
        Swal.fire({
            icon: "success",
            title: "{{ session('mensaje') }}",
            showConfirmButton: false,
            timer: 1500
        });
    </script>
@endsession