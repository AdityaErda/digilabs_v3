<script type="text/javascript">
    $(function() {
        /* Isi Table */
        $('#table').DataTable({
            "scrollX": true,
            "ajax": {
                "url": "<?= base_url() ?>/master/rumus_multiple/getImportDetailParameter?import_kode=<?= $this->input->get('import_kode') ?>",
                "dataSrc": ""
            },
            "columns": [{
                    "data": "rumus_detail_urut"
                },
                {
                    "data": "detail_parameter_rumus"
                },
                {
                    "data": "rumus_detail_input"
                },
                {
                    "data": "rumus_jenis"
                },
            ]
        });
        /* Isi Table */
    });
</script>