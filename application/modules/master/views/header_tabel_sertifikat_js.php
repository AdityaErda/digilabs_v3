<script type="text/javascript">
    $(function() {
        fun_loading();

        /* Isi Table */
        $('#table_header thead tr').clone(true).addClass('filters').appendTo('#table_header thead');
        $('#table_header').DataTable({
            orderCellsTop: true,
            initComplete: function() {
                var api = this.api();

                // For each column
                api
                    .columns()
                    .eq(0)
                    .each(function(colIdx) {
                        // Set the header cell to contain the input element
                        var cell = $('.filters th').eq(
                            $(api.column(colIdx).header()).index()
                        );
                        var title = $(cell).text();
                        $(cell).html('<input type="text" class="form-control" style="width:100%" placeholder="' + title + '" />');

                        // On every keypress in this input
                        $(
                                'input',
                                $('.filters th').eq($(api.column(colIdx).header()).index())
                            )
                            .off('keyup change')
                            .on('keyup change', function(e) {
                                e.stopPropagation();

                                // Get the search value
                                $(this).attr('title', $(this).val());
                                var regexr = '({search})'; //$(this).parents('th').find('select').val();

                                var cursorPosition = this.selectionStart;
                                // Search the column for that value
                                api
                                    .column(colIdx)
                                    .search(
                                        this.value != '' ?
                                        regexr.replace('{search}', '(((' + this.value + ')))') :
                                        '',
                                        this.value != '',
                                        this.value == ''
                                    )
                                    .draw();

                                $(this)
                                    .focus()[0]
                                    .setSelectionRange(cursorPosition, cursorPosition);
                            });
                    });
            },
            "scrollX": true,
            "lengthMenu": [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, "All"]
            ],
            // "dom": 'lBfrtip',
            // "buttons": ["csv", "pdf", "excel", "copy", "print"],
            "ajax": {
                "url": "<?= base_url() ?>/master/header_tabel_sertifikat/getHeaderTabelSertifikat",
                "dataSrc": ""
            },
            "columns": [{
                    render: function(data, type, full, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    "data": "template_sertifikat_header_nama"
                },
                {
                    "render": function(data, type, full, meta) {
                        return full.when_create + ' - ' + full.who_create;
                    }
                },
                {
                    "render": function(data, type, full, meta) {
                        return '<center><a href="javascript:;" id="' + full.template_sertifikat_header_id + '" title="Edit" onclick="fun_edit(this.id)"><i class="fa fa-edit" data-toggle="modal" data-target="#modal" style="color: orange"></i></a></center>';
                    }
                },
                {
                    "render": function(data, type, full, meta) {
                        return '<center><a href="javascript:;" id="' + full.template_sertifikat_header_id + '" title="Hapus" onclick="fun_delete(this.id)"><i class="fa fa-trash" style="color: red"></i></a></center>';
                    }
                },
            ]
        });
        /* Isi Table */

        /* Select2 */
        $('.select2-selection').css('height', '37px');
        $('.select2').css('width', '100%');
        /* Select2 */
    });

    /* View Update */
    function fun_edit(id) {
        $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
            if (!json.user_id) {
                fun_notifLogout();
            } else {
                $('#simpan').css('display', 'none');
                $('#edit').css('display', 'block');
                $.getJSON('<?= base_url('master/header_tabel_sertifikat/getHeaderTabelSertifikat') ?>', {
                    template_sertifikat_header_id: id
                }, function(json) {
                    $.each(json, function(index, val) {
                        $('#' + index).val(val);
                    });

                });
            }
        });
    }
    /* View Update */

    /* Proses */
    $("#form_modal_header").on("submit", function(e) {
        e.preventDefault();
        $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
            if (!json.user_id) {
                fun_notifLogout();
            } else {
                if ($('#template_sertifikat_header_id').val() != '') var url = '<?= base_url('master/header_tabel_sertifikat/updateHeaderTabelSertifikat') ?>';
                else var url = '<?= base_url('master/header_tabel_sertifikat/insertHeaderTabelSertifikat') ?>';

                e.preventDefault();
                $.ajax({
                    url: url,
                    data: $('#form_modal_header').serialize(),
                    type: 'POST',
                    dataType: 'html',
                    success: function(isi) {
                        $('#close').click();
                        toastr.success('Berhasil');
                    }
                });
            }
        });
    });
    /* Proses */

    /* Fun Delete */
    function fun_delete(id) {
        $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
            if (!json.user_id) {
                fun_notifLogout();
            } else {
                $.confirmModal('Apakah anda yakin akan menghapusnya?', function(el) {
                    $.get('<?= base_url('master/header_tabel_sertifikat/deleteHeaderTabelSertifikat') ?>', {
                        template_sertifikat_header_id: id
                    }, function(data) {
                        $('#close').click();
                        toastr.success('Berhasil');
                    });
                });
            }
        });
    }
    /* Fun Delete */

    /* Fun Close */
    function fun_close() {
        $('#simpan').css('display', 'block');
        $('#edit').css('display', 'none');
        $('#form_modal_header')[0].reset();
        $('#table_header').DataTable().ajax.reload();
        $("#sample_nama").empty();
        fun_loading();
    }
    /* Fun Close */

    function fun_loading() {
        var simplebar = new Nanobar();
        simplebar.go(100);
    }
</script>