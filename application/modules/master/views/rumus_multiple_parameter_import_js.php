<script type="text/javascript">
    $(function() {
        /* Isi Table */
        $('#table').DataTable({
            "scrollX": true,
            "ajax": {
                "url": "<?= base_url() ?>/master/rumus_multiple/getImportParameter?import_kode=<?= $this->input->get('import_kode') ?>",
                "dataSrc": ""
            },
            "columns": [{
                    "data": "parameter_rumus"
                },
                {
                    "data": "satuan_parameter"
                },
            ]
        });
        /* Isi Table */
    });
</script>