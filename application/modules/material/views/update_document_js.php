<script type="text/javascript">
  $(function() {
    // tanggal range
    // $('#tanggal_cari').daterangepicker({
    //   locale:
    //           {format:'DD-MM-YYYY'},
    // })
    // tanggal range
    /* Isi Table */
    $('#table thead tr')
      .clone(true)
      .addClass('filters')
      .appendTo('#table thead');

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
            $(cell).html('<input type="text" class="form-control" placeholder="' + title + '" />');

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

      "lengthMenu": [
        [5, 10, 25, 50, -1],
        [5, 10, 25, 50, "All"]
      ],
      // "order": [[ 0, "desc" ]],
      "dom": 'lBfrtip',
      "buttons": ["csv", "pdf", "excel", "copy", "print"],
      "scrollX": true,
      "ajax": {
        // "url": "<?= base_url('material/update_document/getDocument?tanggal_cari=') ?>"+$('#tanggal_cari').val(),
        "url": "<?= base_url('material/update_document/getDocument') ?>",
        "dataSrc": ""
      },
      "columns": [{
          render: function(data, type, full, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          "data": "transaksi_waktu"
        },
        {
          "data": "item_nama"
        },
        {
          "data": "list_batch_kode_final"
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:;" id="' + full.list_batch_id + '" title="Detail" onclick="fun_detail(this.id)"><i class="fa fa-search"></i></a></center>';
          }
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:;" id="' + full.list_batch_id + '" title="Proses" onclick="fun_tambah(this.id)"><i style="color:lime" class="fa fa-share" data-toggle="modal" data-target="#modal"></i></a></center>';
          }
        },
      ]
    });
    /* Isi Table */
    /* Isi Table */
    $('#table1 thead tr')
      .clone(true)
      .addClass('filters1')
      .appendTo('#table1 thead');

    $('#table1').DataTable({
      orderCellsTop: true,
      initComplete: function() {
        var api = this.api();

        // For each column
        api
          .columns()
          .eq(0)
          .each(function(colIdx) {
            // Set the header cell to contain the input element
            var cell = $('.filters1 th').eq(
              $(api.column(colIdx).header()).index()
            );
            var title = $(cell).text();
            $(cell).html('<input type="text" class="form-control" placeholder="' + title + '" />');

            // On every keypress in this input
            $(
                'input',
                $('.filters1 th').eq($(api.column(colIdx).header()).index())
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
      "lengthMenu": [
        [5, 10, 25, 50, -1],
        [5, 10, 25, 50, "All"]
      ],
      "dom": 'lBfrtip',
      "buttons": [{
          extend: "csv",
          title: "Detail Update Document"
        }, {
          extend: "pdf",
          title: "Detail Update Document"
        }, {
          extend: "excel",
          title: "Detail Update Document"
        },
        "copy",
        {
          extend: "print",
          title: "Detail Update Document"
        }
      ],
      "scrollX": true,
      "ajax": {
        "url": "<?= base_url('material/update_document/getDocumentDetail') ?>",
        "dataSrc": ""
      },
      "columns": [{
          render: function(data, type, full, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          "data": "batch_file_tgl_terbit"
        },
        {
          "data": "batch_file_tgl_expired"
        },
        {
          "data": "batch_file_judul"
        },
        {
          "data": "batch_file_isi"
        },
        {
          "render": function(data, type, full, meta) {
            if (full.batch_file_isi != null) {
              return '<center><a href="<?= base_url('./upload/') ?>' + full.batch_file_isi + '" target="_blank" id="' + full.batch_file_id + '" title="Edit"><i class="fa fa-download"></i></a></center>';
            } else {
              return '';
            }
          }
        },
      ]
    });
    /* Isi Table */

    $('.datetimepicker').datetimepicker({
      format: 'YYYY-MM-DD'
    })


    /* Tanggal */
    $(".tanggal").daterangepicker({
      showDropdowns: true,
      singleDatePicker: true,
      locale: {
        format: 'DD-MM-YYYY'
      }
    });
    /* Tanggal */

    /* Select2 */
    $('.select2').select2({
      placeholder: 'Pilih',
    });

    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');
    /* Select2 */

    $('#cari').click();
  });

  // filter
  $("#filter").on("submit", function(e) {
    e.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $('#table').DataTable().ajax.url('<?= base_url('material/update_document/getDocument?') ?>' + $('#filter').serialize()).load();
      }
    });
  });
  // filter

  function fun_tambah(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        console.log(id);
        $.getJSON('<?= base_url('material/update_document/getDocument') ?>', {
          list_batch_id: id
        }, function(json) {
          console.log(json);
          $('#list_batch_id').val(json.list_batch_id)
        });

        setTimeout(function() {
          $('#dg').edatagrid({
            url: '<?= base_url() ?>material/update_document/getEasyuiDocument?list_batch_id=' + id,
            saveUrl: '<?= base_url() ?>material/update_document/insertEasyuiDocument',
            updateUrl: '<?= base_url() ?>material/update_document/editEasyuiDocument',

            onEndEdit: function(index, row) {
              var e = $(this).datagrid('getEditor', {
                index: index,
                field: 'batch_file_isi'
              });
              var files = $(e.target).filebox('files');
              if (files.length) {
                row.savedFileName = e.target.filebox('getText');
              }
            },

            columns: [
              [{
                  field: 'batch_file_tgl_terbit',
                  title: 'Tgl Terbit',
                  width: '25%',
                  editor: {
                    type: 'datebox',
                    options: {
                      // formatter:formatDate
                    }
                  }
                  // options:'formatDate',
                  // formatter:'formatDate',


                },
                {
                  field: 'batch_file_tgl_expired',
                  title: 'Tgl Expired',
                  width: '25%',
                  editor: {
                    type: 'datebox',
                    options: {
                      // formatter:formatDate
                    }
                  } // options:'formatDate',
                  // formatter:'formatDate',

                },
                {
                  field: 'batch_file_judul',
                  title: 'Judul',
                  width: '25%',
                  editor: {
                    type: 'text',
                    options: {
                      // formatter:formatDate
                    }
                  } // options:'formatDate',
                  // formatter:'formatDate',

                },
                {
                  field: 'batch_file_isi',
                  title: 'File',
                  width: '25%',
                  formatter: (value, row) => row.fileName || value,
                  editor: {
                    type: 'filebox',
                    options: {
                      buttonText: '...',
                      onChange: function() {
                        var self = $(this);
                        var files = self.filebox('files')
                        var formData = new FormData();

                        self.filebox('setText', 'Menyimpan...');

                        formData.append('aset_id', $('#aset_id').val());

                        for (var i = 0; i < files.length; i++) {
                          var file = files[i];
                          formData.append('file', file, file.name);
                        }

                        $.ajax({
                          url: '<?= base_url('material/update_document/insertEasyuiDocumentFile') ?>',
                          type: 'post',
                          data: formData,
                          contentType: false,
                          processData: false,
                          success: function(data) {
                            self.filebox('setText', data);
                          }
                        })
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

  function fun_detail(isi) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $('#div_detail').css('display', 'block');
        $('#table1').DataTable().ajax.url('<?= base_url() ?>material/update_document/getDocumentDetail?list_batch_id=' + isi).load();
        $('html, body').animate({
          scrollTop: $("#div_detail").offset().top
        }, 10);
      }
    });
  }



  // EASY UI

  // tambah  
  function fun_tambah_document() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        var id = $('#list_batch_id').val();
        console.log(id);
        $('#dg').edatagrid('addRow', {
          index: 0,
          row: {
            list_batch_id: id
          }

        });
      }
    });
  }
  // tambah

  // simpan 
  function fun_simpan_document() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $('#dg').edatagrid('saveRow');
        setTimeout(() => {
          $('#dg').datagrid('reload')
        }, 1000);
      }
    });
  }
  // simpan

  // hapus
  function fun_hapus_document() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        var row = $('#dg').datagrid('getSelected');
        $.post('<?= base_url() ?>material/update_document/deleteEasyuiDocument', {
          batch_file_id: row.batch_file_id
        }, function(data, textStatus, xhr) {
          $('#dg').datagrid('reload');
        });
      }
    });
  }
  // hapus

  // function formatDate(val,row){		
  // 		return formattedDate(val);	
  // 	 }

  // 	function formattedDate(date) {
  // 		var d = new Date(date || Date.now()),
  // 			month = '' + (d.getMonth() + 1),
  // 			day = '' + d.getDate(),
  // 			year = d.getFullYear();

  // 		if (month.length < 2) month = '0' + month;
  // 		if (day.length < 2) day = '0' + day;

  // 		return [day, month, year].join('/');
  // 	}

  // reload dg
  function fun_reload_document() {
    setTimeout(() => {
      $('#dg').datagrid('reload')
    }, 1000);
  }

  // reload dg


  // EASY UI

  // function fun_download(isi){
  // var id = isi;
  // $.getJSON('update_document/downloadDocumentDetail', {batch_file_id : id }, function(data, textStatus, xhr) {
  // $('#dg').datagrid('reload');
  // });
  // }

  $('#simpan').on('click', function() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        // setTimeout(()=>{
        // $('#loading_form').show();
        $('#edit').hide();
        $('#simpan').hide();
        // },2000);
        $('#close').click();
        toastr.success('Berhasil');
      }
    })
  })

  /* Fun Close */
  function fun_close() {
    $('#simpan').css('display', 'block');
    $('#edit').css('display', 'none');
    $('#loading_form').hide();
    $('#list_batch_id').empty();
    $('#form_modal')[0].reset();
    $('#table').DataTable().ajax.reload(null, false);
  }
  /* Fun Close */

  $('#modal').on('hidden.bs.modal', function(e) {
    fun_close();
  });
</script>