<script>
    $(function() {
        

        $(".tanggal").daterangepicker({
            showDropdowns: true,
            singleDatePicker: true,
            timePicker: true,
            timePicker24Hour: true,
            timePickerSeconds: true,
            locale: {
                format: 'DD-MM-YYYY'
            },
        });

    })
</script>