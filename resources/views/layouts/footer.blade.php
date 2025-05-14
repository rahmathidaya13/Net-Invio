<script src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(".loader-wrapper").fadeOut(500, function() {
        $(this).remove()
    });

    window.setTimeout(() => {
        $(".alert").fadeTo(500, 0).slideUp(500, () => {
            $(this).remove();
        })
    }, 5000);
</script>
</body>

</html>
