<script type="text/javascript">
  $(function() {
    fun_loading();
    fun_umur('<?= date('Y') ?>');

    /* Tanggal */
    $(".tanggal").daterangepicker({
      showDropdowns: true,
      singleDatePicker: true,
      locale: {
        format: 'DD-MM-YYYY'
      }
    });
    /* Tanggal */

    /* Isi Table */
    $('#table thead tr').clone(true).addClass('filters').appendTo('#table thead');
    $('#table').DataTable({
      orderCellsTop: true,
      initComplete: function() {
        $('.dataTables_scrollHead').on('scroll', function() {
          $('.dataTables_scrollBody').scrollLeft($(this).scrollLeft());
        });
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
      "dom": 'lBfrtip',
      "buttons": ["csv", "pdf", "excel", "copy", "print"],
      "pageLength": 5,
      "ajax": {
        "url": "<?= base_url('master/aset/getAset') ?>",
        "dataSrc": ""
      },
      "columns": [{
          render: function(data, type, full, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          "data": "aset_nomor_utama"
        },
        {
          render: function(data, type, full, meta) {
            return (full.is_aset == 'y') ? 'Aset' : 'Non Aset';
          }
        },
        {
          render: function(data, type, full, meta) {
            return full.aset_tahun_perolehan.split("-").reverse().join("-");
          }
        },
        {
          "data": "aset_nama"
        },
        {
          "data": "aset_nilai_perolehan",
          render: $.fn.dataTable.render.number('.', ',', 2, 'Rp. ')
        },
        {
          "data": "aset_penyusutan_thn_lalu",
          render: $.fn.dataTable.render.number('.', ',', 2, 'Rp. ')
        },
        {
          "data": "aset_penyusutan_thn_ini",
          render: $.fn.dataTable.render.number('.', ',', 2, 'Rp. ')
        },
        {
          "data": "aset_total_penyusutan",
          render: $.fn.dataTable.render.number('.', ',', 2, 'Rp. ')
        },
        {
          "data": "aset_nilai_buku",
          render: $.fn.dataTable.render.number('.', ',', 2, 'Rp. ')
        },
        {
          "data": "aset_jumlah"
        },
        {
          "render": function(data, type, full, meta) {
            var tombol = '<div class="input-group-prepend"><button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Action</button><div style="height:auto;max-height: 140px;overflow-x:hidden;" class="dropdown-menu"><a class="dropdown-item" href="#" id="' + full.aset_foto + '" onclick="fun_foto(this.id)" data-toggle="modal" data-target="#modal_foto">Lihat foto</a><a class="dropdown-item" href="#" id="' + full.aset_id + '" onclick="fun_download(this.id)" data-toggle="modal" data-target="#modal_download">Download</a><a class="dropdown-item" href="#" id="' + full.aset_id + '" onclick="fun_detail(this.id)">Detail</a><a class="dropdown-item" href="#" id="' + full.aset_id + '" onclick="fun_edit(this.id)" data-toggle="modal" data-target="#modal">Edit</a><a class="dropdown-item" href="#" id="' + full.aset_id + '" onclick="fun_delete(this.id)">Hapus</a></div></div>';
            return tombol;
          }
        },
      ]
    });
    /* Isi Table */

    /* Isi Table Dowload */
    $('#table_download').DataTable({
      "ajax": {
        "url": "<?= base_url() ?>/master/aset/getAsetDocument?aset_document_id=0",
        "dataSrc": ""
      },
      "columns": [{
          "data": "aset_document_nama"
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="<?= base_url('document/') ?>' + full.aset_document_file + '" id="' + full.aset_document_id + '" title="Edit"><i class="fa fa-download"></i></a></center>';
          }
        },
      ]
    });
    /* Isi Table Dowload */

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
        "url": "<?= base_url() ?>/master/aset/getAsetDetail?iaset_detail_id=0",
        "dataSrc": ""
      },
      "columns": [{
          "data": "aset_detail_merk"
        },
        {
          "data": "aset_nomor"
        },
        {
          "data": "peminta_jasa_nama"
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:;" id="' + full.aset_detail_id + '" title="Edit" onclick="fun_edit_detail(this.id)"><i class="fa fa-edit" data-toggle="modal" data-target="#modal_detail" style="color: orange"></i></a></center>';
          }
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:;" id="' + full.aset_detail_id + '" title="Edit" onclick="fun_delete_detail(this.id)"><i class="fa fa-trash" style="color: red"></i></a></center>';
          }
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="<?= base_url('master/aset/printQrcode/?aset_detail_id=') ?>' + full.aset_detail_id + '" id="' + full.aset_id + '" target="_BLANK" title="Edit" "><i class="fa fa-barcode" style="color: black;"></i></a></center>';
          }
        }
      ]
    });
    /* Isi Table Detail */

    /* Select2 */
    $('#peminta_jasa_id').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('master/aset/getPemintaJasa') ?>',
        dataType: 'json',
        type: 'GET',
        data: function(params) {
          var queryParameters = {
            peminta_jasa_nama: params.term
          }

          return queryParameters;
        }
      }
    });

    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');
    /* Select2 */
  });

  /* Fun Tambah */
  function fun_tambah() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        var id = Date.now();
        $('#aset_id').val(id)

        setTimeout(function() {
          $('#dg_document').edatagrid({
            url: '<?= base_url('master/aset/getAsetDocument?aset_id=') ?>' + id,
            saveUrl: '<?= base_url('master/aset/insertAsetDocument') ?>',
            updateUrl: '<?= base_url('master/aset/updateAsetDocument') ?>',
            onEndEdit: function(index, row) {
              var e = $(this).datagrid('getEditor', {
                index: index,
                field: 'aset_document_file'
              });
              var files = $(e.target).filebox('files');
              if (files.length) {
                row.savedFileName = e.target.filebox('getText');
              }
            },
            rowStyler: function(index, row) {
              return 'background-color:gainsboro;';
            },
            columns: [
              [{
                  field: 'aset_document_nama',
                  title: 'Nama',
                  width: '50%',
                  editor: 'textbox',
                },
                {
                  field: 'aset_document_file',
                  title: 'File',
                  width: '50%',
                  formatter: (value, row) => row.fileName || value,
                  editor: {
                    type: 'filebox',
                    options: {
                      buttonText: '...',
                      accept: 'application/pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,image/jpeg,image/png,image/gif,image/bmp',
                      onChange: function(newValue, oldValue) {
                        var self = $(this);
                        var files = self.filebox('files')
                        var formData = new FormData();

                        const validExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'jpeg', 'png', 'gif', 'bmp'];
                        const fileExtension = newValue.split('.').pop().toLowerCase();

                        if (validExtensions.indexOf(fileExtension) === -1) {
                          $.messager.alert('Error', 'Format Tidak Didukung');
                          self.filebox('setText', '');
                        } else {
                          self.filebox('setText', 'Menyimpan...');
                          formData.append('aset_id', $('#aset_id').val());
                          for (var i = 0; i < files.length; i++) {
                            var file = files[i];
                            formData.append('file', file, file.name);
                          }
                          $.ajax({
                            url: '<?= base_url('master/aset/insertAsetDocumentFile') ?>',
                            type: 'post',
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function(data) {
                              self.filebox('setText', data);
                            }
                          })
                        }
                      }
                    },
                  },
                },
              ],
            ],
          });
        }, 500);
      }
    });
  }
  /* Fun Tambah */

  /* Fun Umur */
  function fun_umur(tahun) {
    var tahun = tahun.split('-');
    var umur = (<?= date('Y') ?> - tahun[2]);
    $('#aset_umur').val(umur)

    fun_nilai_buku($('#aset_nilai_perolehan').val(), $('#aset_residu').val(), umur, $('#aset_umur_ekonomis').val());
  }
  /* Fun Umur */

  /* Fun Nilai Buku */
  function fun_nilai_buku(perolehan, residu, umur, umur_ekonomis) {
    var penyusutan_lalu = ((perolehan * 1) - (residu * 1)) / (umur_ekonomis * 1) * ((umur * 1) - 1);
    var penyusutan_ini = ((perolehan * 1) - (residu * 1)) / (umur_ekonomis * 1);
    var total_penyusutan = ((perolehan * 1) - (residu * 1)) / (umur_ekonomis * 1) * (umur * 1);
    var nilai_buku = (perolehan * 1) - (total_penyusutan * 1);
    if (nilai_buku <= 0) nilai_buku = 0;

    $('#aset_penyusutan_thn_lalu').val(penyusutan_lalu);
    $('#aset_penyusutan_thn_ini').val(penyusutan_ini);
    $('#aset_total_penyusutan').val(total_penyusutan);
    $('#aset_nilai_buku').val(nilai_buku);
  }
  /* Fun Nilai Buku */

  /* Fun Foto */
  function fun_foto(isi) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $('#foto').attr("src", '<?= base_url('document/') ?>' + isi);
      }
    });
  }
  /* Fun Foto */

  /* Fun Download */
  function fun_download(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $('#table_download').DataTable().ajax.url('<?= base_url('master/aset/getAsetDocument?aset_id=') ?>' + id).load();
      }
    });
  }
  /* Fun Download */

  /* View Update */
  function fun_edit(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        setTimeout(function() {
          $('#dg_document').edatagrid({
            url: '<?= base_url('master/aset/getAsetDocument?aset_id=') ?>' + id,
            saveUrl: '<?= base_url('master/aset/insertAsetDocument') ?>',
            updateUrl: '<?= base_url('master/aset/updateAsetDocument') ?>',
            onEndEdit: function(index, row) {
              var e = $(this).datagrid('getEditor', {
                index: index,
                field: 'aset_document_file'
              });
              var files = $(e.target).filebox('files');
              if (files.length) {
                row.savedFileName = e.target.filebox('getText');
              }
            },
            rowStyler: function(index, row) {
              return 'background-color:gainsboro;';
            },
            columns: [
              [{
                  field: 'aset_document_nama',
                  title: 'Nama',
                  width: '50%',
                  editor: 'textbox',
                },
                {
                  field: 'aset_document_file',
                  title: 'File',
                  width: '50%',
                  formatter: (value, row) => row.fileName || value,
                  editor: {
                    type: 'filebox',
                    options: {
                      buttonText: '...',
                      accept: 'application/pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,image/jpeg,image/png,image/gif,image/bmp',
                      onChange: function(newValue, oldValue) {
                        var self = $(this);
                        var files = self.filebox('files')
                        var formData = new FormData();

                        const validExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'jpeg', 'png', 'gif', 'bmp'];
                        const fileExtension = newValue.split('.').pop().toLowerCase();

                        if (validExtensions.indexOf(fileExtension) === -1) {
                          $.messager.alert('Error', 'Format Tidak Didukung');
                          self.filebox('setText', '');
                        } else {
                          self.filebox('setText', 'Menyimpan...');
                          formData.append('aset_id', $('#aset_id').val());
                          for (var i = 0; i < files.length; i++) {
                            var file = files[i];
                            formData.append('file', file, file.name);
                          }
                          $.ajax({
                            url: '<?= base_url('master/aset/insertAsetDocumentFile') ?>',
                            type: 'post',
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function(data) {
                              self.filebox('setText', data);
                            }
                          })
                        }
                      }
                    },
                  },
                },
              ],
            ],
          });
        }, 500);
        $('#simpan').css('display', 'none');
        $('#edit').css('display', 'block');
        $('#foto_sebelumnya').css('display', 'block');

        $.getJSON('<?= base_url('master/aset/getAset') ?>', {
          aset_id: id
        }, function(json) {
          $('#aset_id').val(json.aset_id);
          $('#temp_aset_id').val(json.aset_id);
          $('#aset_nomor_utama').val(json.aset_nomor_utama);
          $('#aset_nama').val(json.aset_nama);
          $('#aset_umur').val(json.aset_umur);
          $('#aset_umur_ekonomis').val(json.aset_umur_ekonomis);
          $('#aset_residu').val(json.aset_residu);
          $('#aset_tahun_perolehan').val(json.aset_tahun_perolehan);
          $('#aset_nilai_perolehan').val(json.aset_nilai_perolehan);
          $('#aset_penyusutan_thn_lalu').val(json.aset_penyusutan_thn_lalu);
          $('#aset_penyusutan_thn_ini').val(json.aset_penyusutan_thn_ini);
          $('#aset_total_penyusutan').val(json.aset_total_penyusutan);
          $('#aset_nilai_buku').val(json.aset_nilai_buku);
          $('#aset_foto_sebelumnya').attr("src", '<?= base_url('document/') ?>' + json.aset_foto);

          if (json.is_aset == 'y') $('#is_aset').prop('checked', true);
          else $('#is_aset').prop('checked', false);
          $('#is_aset').val('y');
        });
      }
    });
  }
  /* View Update */

  /* Proses */
  $("#form_modal").on("submit", function(e) {
    e.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        var total = 0;

        if ($('#temp_aset_id').val() != '') var url = '<?= base_url('master/aset/updateAset') ?>';
        else var url = '<?= base_url('master/aset/insertAset') ?>';

        if ($('#aset_nomor_utama').val() == '') {
          $('#aset_nomor_utama_alert').css('display', 'block');
          total + 1;
        } else {
          $('#aset_nomor_utama_alert').css('display', 'none');
        }

        if ($('#aset_nama').val() == '') {
          $('#aset_nama_alert').css('display', 'block');
          total + 1;
        } else {
          $('#aset_nama_alert').css('display', 'none');
        }

        if ($('#aset_umur_ekonomis').val() == '') {
          $('#aset_umur_ekonomis_alert').css('display', 'block');
          total + 1;
        } else {
          $('#aset_umur_ekonomis_alert').css('display', 'none');
        }

        if ($('#aset_nilai_perolehan').val() == '') {
          $('#aset_nilai_perolehan_alert').css('display', 'block');
          total + 1;
        } else {
          $('#aset_nilai_perolehan_alert').css('display', 'none');
        }

        if ($('#aset_residu').val() == '') {
          $('#aset_residu_alert').css('display', 'block');
          total + 1;
        } else {
          $('#aset_residu_alert').css('display', 'none');
        }

        if (total == 0) {
          var aset_foto = $('#aset_foto').prop('files')[0];
          var data = new FormData();

          if ($('#is_aset').is(":checked") == true) var is_aset = 'y';
          else var is_aset = 'n';

          data.append('aset_foto', aset_foto);
          data.append('aset_id', $('#aset_id').val());
          data.append('aset_nomor_utama', $('#aset_nomor_utama').val());
          data.append('aset_nama', $('#aset_nama').val());
          data.append('aset_umur', $('#aset_umur').val());
          data.append('aset_umur_ekonomis', $('#aset_umur_ekonomis').val());
          data.append('aset_residu', $('#aset_residu').val());
          data.append('aset_tahun_perolehan', $('#aset_tahun_perolehan').val());
          data.append('aset_nilai_perolehan', $('#aset_nilai_perolehan').val());
          data.append('aset_penyusutan_thn_lalu', $('#aset_penyusutan_thn_lalu').val());
          data.append('aset_penyusutan_thn_ini', $('#aset_penyusutan_thn_ini').val());
          data.append('aset_total_penyusutan', $('#aset_total_penyusutan').val());
          data.append('aset_nilai_buku', $('#aset_nilai_buku').val());
          data.append('is_aset', is_aset);

          e.preventDefault();
          $.ajax({
            url: url,
            data: data,
            type: 'POST',
            processData: false,
            contentType: false,
            success: function(isi) {
              if (isi == 0) {
                toastr.warning('Ekstensi File Dilarang');
              } else {
                $('#close').click();
                toastr.success('Berhasil');
              }
            }
          });
        }
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
          $.get('<?= base_url('master/aset/deleteAset') ?>', {
            aset_id: id
          }, function(data) {
            $('#close').click();
            toastr.success('Berhasil');
          });
        });
      }
    });
  }
  /* Fun Delete */

  /* Fun Reset */
  function fun_reset(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $.confirmModal('Apakah anda yakin akan reset data?', function(el) {
          $.get('<?= base_url('master/aset/resetAset') ?>', function(data) {
            $('#close').click();
            toastr.success('Berhasil');
          });
        });
      }
    });
  }
  /* Fun Reset */

  /* EASYUI */
  /* Fun Tambah */
  function fun_tambah_document() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        var id = $('#aset_id').val();
        $('#dg_document').edatagrid('addRow', {
          index: 0,
          row: {
            aset_id: id
          }
        });
      }
    });
  }
  /* Fun Tambah */

  /* Fun Simpan */
  function fun_simpan_document() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $('#dg_document').edatagrid('saveRow');
        setTimeout(() => {
          $('#dg_document').datagrid('reload')
        }, 500);
      }
    });
  }
  /* Fun Simpan */

  /* Fun Hapus */
  function fun_hapus_document() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        var row = $('#dg_document').datagrid('getSelected');
        $.post('<?= base_url('/master/aset/deleteAsetDocument') ?>', {
          aset_document_id: row.aset_document_id
        }, function(data, textStatus, xhr) {
          $('#dg_document').datagrid('reload');
        });
      }
    });
  }
  /* Fun Hapus */
  /* EASYUI */

  /* Fun Close */
  function fun_close() {
    $('#simpan').css('display', 'block');
    $('#edit').css('display', 'none');
    $('#foto_sebelumnya').css('display', 'none');
    $('#form_modal')[0].reset();
    $('#table').DataTable().ajax.reload();
    fun_loading();
  }
  /* Fun Close */

  $('#modal').on('hidden.bs.modal', function(e) {
    fun_close();
  });

  /* Fun Detail */
  function fun_detail(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $('#div_detail').css('display', 'block');
        $('#table_detail').DataTable().ajax.url('<?= base_url('master/aset/getAsetDetail?aset_id=') ?>' + id).load();
        $('#id_aset').val(id);
        $('html, body').animate({
          scrollTop: $("#div_detail").offset().top
        }, 10);
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
        $('#temp_aset_id_detail').val($('#id_aset').val());
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
        $.getJSON('<?= base_url('master/aset/getAsetDetail') ?>', {
          aset_detail_id: id
        }, function(json) {
          $.each(json, function(index, val) {
            $('#' + index).val(val);
          });
          $('#temp_aset_id_detail').val(json.aset_id);

          $('#peminta_jasa_id').append('<option selected value="' + json.peminta_jasa_id + '">' + json.peminta_jasa_nama + '</option>');
          $('#peminta_jasa_id').select2('data', {
            id: json.peminta_jasa_id,
            text: json.peminta_jasa_nama
          });
          $('#peminta_jasa_id').trigger('change')
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
        if ($('#aset_detail_id').val() != '') var url = '<?= base_url('master/aset/updateAsetDetail') ?>';
        else var url = '<?= base_url('master/aset/insertAsetDetail') ?>';

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
    })
  });
  /* Proses Detail */

  /* Fun Delete Detail */
  function fun_delete_detail(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $.confirmModal('Apakah anda yakin akan menghapusnya?', function(el) {
          $.get('<?= base_url('master/aset/deleteAsetDetail') ?>', {
            aset_detail_id: id
          }, function(data) {
            $('#close_detail').click();
            toastr.success('Berhasil');
          });
        });
      }
    })
  }
  /* Fun Delete Detail */

  /* Fun Close Detail */
  function fun_close_detail() {
    $('#simpan_detail').css('display', 'block');
    $('#edit_detail').css('display', 'none');
    $("#peminta_jasa_id").empty();
    $('#form_modal_detail')[0].reset();
    $('#table_detail').DataTable().ajax.reload();
    $('#table').DataTable().ajax.reload();
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