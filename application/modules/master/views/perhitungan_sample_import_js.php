<script>
    $(function() {
        /* Isi Table */
        $('#table').DataTable({
            "scrollX": true,
            "ajax": {
                "url": "<?= base_url() ?>/master/perhitungan_sample/getImport?import_kode=<?= $this->input->get('import_kode') ?>",
                "dataSrc": ""
            },
            "columns": [{
                    "data": "jenis_nama"
                },
                {
                    "render": function(data, type, row, meta) {
                        return (row.is_adbk == 'y') ? '<span style="background-color:aqua" class="badge">' + row.rumus_nama + '</span>' : row.rumus_nama;
                    }
                },
                {
                    "data": "desimal_angka"
                },
                {
                    "data": "satuan_sample"
                },
                {
                    "render": function(data, type, full, meta) {
                        return (full.is_aktif == 'y') ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-danger">Tidak Aktif</span>';
                    }
                },
            ]
        });
        /* Isi Table */
    });
</script>