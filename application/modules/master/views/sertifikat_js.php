<!-- <script src="https://unpkg.com/mathjs/lib/browser/math.js"></script> -->
<script type="text/javascript">
    $(function() {
        fun_loading();

        /* Isi Table */
        $('#table thead tr').clone(true).addClass('filters').appendTo('#table thead');
        $('#table').DataTable({
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
                "url": "<?= base_url() ?>/master/sertifikat/getTemplateSertifikat",
                "dataSrc": ""
            },
            "columns": [{
                    render: function(data, type, full, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    "data": "jenis_nama"
                },
                {
                    "data": "template_logsheet_nama"
                },
                {
                    "render": function(data, type, full, meta) {
                        return full.when_create + ' - ' + full.who_create;
                    }
                },
                {
                    "render": function(data, type, full, meta) {
                        var tombol = '<div class="input-group-prepend"><button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Action</button><div class="dropdown-menu" style="height:auto;max-height: 100px;overflow-x:hidden;"><a class="dropdown-item" href="#" id="' + full.sertifikat_id + '" onclick="fun_detail(this.id)">Detail</a><a class="dropdown-item" href="#" id="' + full.sertifikat_id + '" onclick="fun_edit(this.id)" data-toggle="modal" data-target="#modal">Edit</a><a class="dropdown-item" href="#" id="' + full.sertifikat_id + '" onclick="fun_delete(this.id)">Hapus</a></div></div>';
                        return tombol;
                    }
                },
            ]
        });
        /* Isi Table */

        /* Isi Table Detail */
        $('#table_detail thead tr').clone(true).addClass('filters_detail').appendTo('#table_detail thead');
        $('#table_detail').DataTable({
            orderCellsTop: true,
            initComplete: function() {
                var api = this.api();

                // For each column
                api
                    .columns()
                    .eq(0)
                    .each(function(colIdx) {
                        // Set the header cell to contain the input element
                        var cell = $('.filters_detail th').eq(
                            $(api.column(colIdx).header()).index()
                        );
                        var title = $(cell).text();
                        $(cell).html('<input type="text" class="form-control" style="width:100%" placeholder="' + title + '" />');

                        // On every keypress in this input
                        $(
                                'input',
                                $('.filters_detail th').eq($(api.column(colIdx).header()).index())
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
            "ajax": {
                "url": "<?= base_url() ?>/master/sertifikat/getDetailSertifikat?sertifikat_template_detail_id=0",
                "dataSrc": ""
            },
            "columns": [{
                    "data": "sertifikat_template_detail_urut"
                },
                {
                    "data": "template_sertifikat_header_nama"
                },
                {
                    "render": function(data, type, full, meta) {
                        return '<center><a href="javascript:;" id="' + full.sertifikat_template_detail_id + '" title="Edit" onclick="fun_edit_detail(this.id)"><i class="fa fa-edit" data-toggle="modal" data-target="#modal_detail" style="color: orange"></i></a></center>';
                    }
                },
                {
                    "render": function(data, type, full, meta) {
                        return '<center><a href="javascript:;" id="' + full.sertifikat_template_detail_id + '" title="Hapus" onclick="fun_delete_detail(this.id)"><i class="fa fa-trash" style="color: red"></i></a></center>';
                    }
                },
            ]
        });
        /* Isi Table Detail */

        /* Select2 */
        $('#sertifikat_nama').select2({
            placeholder: 'Pilih Nama Sample',
            ajax: {
                delay: 250,
                url: '<?= base_url('master/perhitungan_sample/getJenisSample') ?>',
                dataType: 'json',
                type: 'GET',
                data: function(params) {
                    var queryParameters = {
                        jenis_nama: params.term
                    }

                    return queryParameters;
                }
            }
        });

        $('#id_template_logsheet').select2({
            placeholder: 'Pilih Nama Log Sheet',
            ajax: {
                delay: 250,
                url: '<?= base_url('master/sertifikat/getLogSheet') ?>',
                dataType: 'json',
                type: 'GET',
                data: function(params) {
                    var queryParameters = {
                        template_logsheet_nama: params.term
                    }

                    return queryParameters;
                }
            }
        });

        $('#id_template_sertifikat_header').select2({
            placeholder: 'Pilih',
            ajax: {
                delay: 250,
                url: '<?= base_url('master/sertifikat/getHeaderTabelSertifikat') ?>',
                dataType: 'json',
                type: 'GET',
                data: function(params) {
                    var queryParameters = {
                        template_sertifikat_header_nama: params.term
                    }

                    return queryParameters;
                }
            }
        });

        $('.select2-selection').css('height', '37px');
        $('.select2').css('width', '100%');
        /* Select2 */
    });

    /* Proses */
    $("#form_modal").on("submit", function(e) {
        e.preventDefault();
        $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
            if (!json.user_id) {
                fun_notifLogout();
            } else {
                if ($('#sertifikat_id').val() != '') var url = '<?= base_url('master/sertifikat/updateTemplateSertifikat') ?>';
                else var url = '<?= base_url('master/sertifikat/insertTemplateSertifikat') ?>';

                e.preventDefault();
                $.ajax({
                    url: url,
                    data: $('#form_modal').serialize(),
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

    /* View Update */
    function fun_edit(id) {
        $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
            if (!json.user_id) {
                fun_notifLogout();
            } else {
                $('#simpan').css('display', 'none');
                $('#edit').css('display', 'block');
                $.getJSON('<?= base_url('master/sertifikat/getTemplateSertifikat') ?>', {
                    sertifikat_id: id
                }, function(json) {
                    $.each(json, function(index, val) {
                        $('#' + index).val(val);

                        $('#sertifikat_nama').append('<option selected value="' + json.jenis_id + '">' + json.jenis_nama + '</option>');
                        $('#sertifikat_nama').select2('data', {
                            id: json.jenis_id,
                            text: json.jenis_nama
                        });

                        $('#id_template_logsheet').append('<option selected value="' + json.template_logsheet_id + '">' + json.template_logsheet_nama + '</option>');
                        $('#id_template_logsheet').select2('data', {
                            id: json.template_logsheet_id,
                            text: json.template_logsheet_nama
                        });

                    });
                });
            }
        });
    }
    /* View Update */

    /* Fun Delete */
    function fun_delete(id) {
        $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
            if (!json.user_id) {
                fun_notifLogout();
            } else {
                $.confirmModal('Apakah anda yakin akan menghapusnya?', function(el) {
                    $.get('<?= base_url('master/sertifikat/deleteTemplateSertifikat') ?>', {
                        sertifikat_id: id
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
        $('#form_modal')[0].reset();
        $('#table').DataTable().ajax.reload();
        $("#sertifikat_nama").empty();
        $('#id_template_logsheet').empty();
        fun_loading();
    }
    /* Fun Close */

    /* Fun Detail */
    function fun_detail(id) {
        $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
            if (!json.user_id) {
                fun_notifLogout();
            } else {
                $('#div_detail').css('display', 'block');
                $('#table_detail').DataTable().ajax.url('<?= base_url('master/sertifikat/getDetailSertifikat?id_template_sertifikat=') ?>' + id).load();
                $('#id_sertifikat_detail').val(id);
                $('html, body').animate({
                    scrollTop: $("#div_detail").offset().top
                }, 10);

                fun_sertifikat(id);
            }
        });
    }
    /* Fun Detail */

    /* Fun Tambah Detail */
    function fun_tambah_detail() {
        $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
            if (!json.user_id) {
                fun_notifLogout();
            } else {
                $('#temp_sertifikat_id').val($('#id_sertifikat_detail').val());
            }
        });
    }
    /* Fun Tambah Detail */

    /* View Update Detail */
    function fun_edit_detail(id) {
        $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
            if (!json.user_id) {
                fun_notifLogout();
            } else {
                $('#simpan_detail').css('display', 'none');
                $('#edit_detail').css('display', 'block');
                $.getJSON('<?= base_url('master/sertifikat/getDetailSertifikat') ?>', {
                    sertifikat_template_detail_id: id
                }, function(json) {
                    $.each(json, function(index, val) {
                        $('#' + index).val(val);
                    });

                    $('#id_template_sertifikat_header').append('<option selected value="' + json.template_sertifikat_header_id + '">' + json.template_sertifikat_header_nama + '</option>');
                    $('#id_template_sertifikat_header').select2('data', {
                        id: json.template_sertifikat_header_id,
                        text: json.template_sertifikat_header_nama
                    });

                    $('#temp_sertifikat_id').val(json.id_template_sertifikat);
                });
            }
        });
    }
    /* View Update Detail */

    /* Proses Detail */
    $("#form_modal_detail").on("submit", function(e) {
        e.preventDefault();
        $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
            if (!json.user_id) {
                fun_notifLogout();
            } else {
                if ($('#sertifikat_template_detail_id').val() != '') var url = '<?= base_url('master/sertifikat/updateTemplateSertifikatDetail') ?>';
                else var url = '<?= base_url('master/sertifikat/insertTemplateSertifikatDetail') ?>';

                e.preventDefault();
                $.ajax({
                    url: url,
                    data: $('#form_modal_detail').serialize(),
                    type: 'POST',
                    dataType: 'html',
                    success: function(isi) {
                        $('#close_detail').click();
                        toastr.success('Berhasil');
                    }
                });
            }
        });
    });
    /* Proses Detail */

    /* Fun Delete Detail */
    function fun_delete_detail(id) {
        $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
            if (!json.user_id) {
                fun_notifLogout();
            } else {
                $.confirmModal('Apakah anda yakin akan menghapusnya?', function(el) {
                    $.get('<?= base_url('master/sertifikat/deleteTemplateSertifikatDetail') ?>', {
                        sertifikat_template_detail_id: id
                    }, function(data) {
                        $('#close_detail').click();
                        toastr.success('Berhasil');
                    });
                });
            }
        });
    }
    /* Fun Delete Detail */

    /* Fun Close Detail */
    function fun_close_detail() {
        $('#simpan_detail').css('display', 'block');
        $('#edit_detail').css('display', 'none');
        $("#id_template_sertifikat_header").empty();
        $('#form_modal_detail')[0].reset();
        $('#table_detail').DataTable().ajax.reload();
        fun_loading();
    }
    /* Fun Close Detail */

    $('#modal_detail').on('hidden.bs.modal', function(e) {
        fun_close_detail();
    });


    function fun_loading() {
        var simplebar = new Nanobar();
        simplebar.go(100);
    }
</script>