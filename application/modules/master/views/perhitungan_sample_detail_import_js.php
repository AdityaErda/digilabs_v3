<script type="text/javascript">
    $(function() {
        /* Isi Table */
        $('#table').DataTable({
            "scrollX": true,
            "ajax": {
                "url": "<?= base_url() ?>/master/perhitungan_sample/getImportDetail?import_kode=<?= $this->input->get('import_kode') ?>",
                "dataSrc": ""
            },
            "columns": [{
                    "data": "rumus_detail_urut"
                },
                {
                    "data": "rumus_detail_nama"
                },
                {
                    "data": "rumus_detail_input"
                },
                {
                    "data": "rumus_detail_template"
                },
                {
                    "data": "rumus_jenis"
                },
            ]
        });
        /* Isi Table */
    });
</script>