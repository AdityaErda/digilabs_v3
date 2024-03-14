<script>
    $(function() {
        /* Isi Table */
        $('#table').DataTable({
            "scrollX": true,
            "ajax": {
                "url": "<?= base_url() ?>/master/rumus_multiple/getImport?import_kode=<?= $this->input->get('import_kode') ?>",
                "dataSrc": ""
            },
            "columns": [{
                    "data": "jenis_nama"
                },
                {
                    "data": "metode"
                },
            ]
        });
        /* Isi Table */
    });
</script>