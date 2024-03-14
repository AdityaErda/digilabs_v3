<script type="text/javascript">
	$(function () {
    /* Isi Table */	
      $('#table thead tr')
        .clone(true)
        .addClass('filters')
        .appendTo('#table thead');

      $('#table').DataTable({
        orderCellsTop: true,
        initComplete: function () {
            var api = this.api();
            // For each column
            api
                .columns()
                .eq(0)
                .each(function (colIdx) {
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
                        .on('keyup change', function (e) {
                            e.stopPropagation();
 
                            // Get the search value
                            $(this).attr('title', $(this).val());
                            var regexr = '({search})'; //$(this).parents('th').find('select').val();
 
                            var cursorPosition = this.selectionStart;
                            // Search the column for that value
                            api
                                .column(colIdx)
                                .search(
                                    this.value != ''
                                        ? regexr.replace('{search}', '(((' + this.value + ')))')
                                        : '',
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
        // "searching":false,
        "scrollX": true,
        "lengthMenu":[[5,10,25,50,-1],[5,10,25,50,"All"]],
        "dom": 'lBfrtip',
        "buttons": ["csv", "pdf", "excel","copy","print"],
        "ajax": {
            "url": "<?= base_url('material/history_card/getAset') ?>",
            "dataSrc": ""
          },
          "fnRowCallback": function( data, type, full, meta ) {
            $(data).attr('class', 'warna');;
          },
          "columns": [
            {render: function ( data, type, full, meta ) {
              return meta.row + meta.settings._iDisplayStart + 1;
            }},
            {"data" : "aset_nomor_utama"},
            {"render":function(data,type,full,meta){
              return (full.is_aset=='y') ? 'Aset' : 'Non Aset'
            }},
            {"data" : "aset_nama"},
            {"data" : "aset_detail_merk"},
            {"data" : "aset_nomor"},
            {"data" : "peminta_jasa_nama"},
            {"render": function ( data, type, full, meta ) {
              // var tambol = '';
              var tombol = '<center><a href="javascript:;" onclick="func_detail(this.id,this.name)" id="'+full.aset_detail_id+'" name="'+full.aset_nama+' - '+full.aset_nomor+'"  ><i class="fa fa-search"></i></a></center>';
              return tombol;
            }},
            
            
            
          ]
      });
    /* Isi Table */ 

    /* Isi Table Dowload */
    // $('#table_download thead tr')
    //     .clone(true)
    //     .addClass('filters')
    //     .appendTo('#table_download thead');

    //   $('#table_download').DataTable({
    //     orderCellsTop: true,
    //     initComplete: function () {
    //         var api = this.api();
 
    //         // For each column
    //         api
    //             .columns()
    //             .eq(0)
    //             .each(function (colIdx) {
    //                 // Set the header cell to contain the input element
    //                 var cell = $('.filters th').eq(
    //                     $(api.column(colIdx).header()).index()
    //                 );
    //                 var title = $(cell).text();
    //                 $(cell).html('<input type="text" class="form-control" placeholder="' + title + '" />');
 
    //                 // On every keypress in this input
    //                 $(
    //                     'input',
    //                     $('.filters th').eq($(api.column(colIdx).header()).index())
    //                 )
    //                     .off('keyup change')
    //                     .on('keyup change', function (e) {
    //                         e.stopPropagation();
 
    //                         // Get the search value
    //                         $(this).attr('title', $(this).val());
    //                         var regexr = '({search})'; //$(this).parents('th').find('select').val();
 
    //                         var cursorPosition = this.selectionStart;
    //                         // Search the column for that value
    //                         api
    //                             .column(colIdx)
    //                             .search(
    //                                 this.value != ''
    //                                     ? regexr.replace('{search}', '(((' + this.value + ')))')
    //                                     : '',
    //                                 this.value != '',
    //                                 this.value == ''
    //                             )
    //                             .draw();
 
    //                         $(this)
    //                             .focus()[0]
    //                             .setSelectionRange(cursorPosition, cursorPosition);
    //                     });
    //             });
    //     },
    //     "ajax": {
    //       "url": "<?= base_url() ?>/master/aset/getAsetDocument?aset_document_id=0",
    //       "dataSrc": ""
    //     },
    //     "columns": [
    //       {"data" : "aset_document_nama"},
    //       {"render": function ( data, type, full, meta ) {
    //         return '<center><a href="<?= base_url('document/') ?>'+full.aset_document_file+'" id="'+full.aset_document_id+'" title="Edit"><i class="fa fa-download"></i></a></center>';
    //         }
    //       },
    //     ]
    //   });
    /* Isi Table Dowload */ 

    /* Isi Table Detail */
    $('#table_detail thead tr')
        .clone(true)
        .addClass('filters_detail')
        .appendTo('#table_detail thead');

      $('#table_detail').DataTable({
        orderCellsTop: true,
        initComplete: function () {
            var api = this.api();
 
            // For each column
            api
                .columns()
                .eq(0)
                .each(function (colIdx) {
                    // Set the header cell to contain the input element
                    var cell = $('.filters_detail th').eq(
                        $(api.column(colIdx).header()).index()
                    );
                    var title = $(cell).text();
                    $(cell).html('<input type="text" class="form-control" placeholder="' + title + '" />');
 
                    // On every keypress in this input
                    $(
                        'input',
                        $('.filters_detail th').eq($(api.column(colIdx).header()).index())
                    )
                        .off('keyup change')
                        .on('keyup change', function (e) {
                            e.stopPropagation();
 
                            // Get the search value
                            $(this).attr('title', $(this).val());
                            var regexr = '({search})'; //$(this).parents('th').find('select').val();
 
                            var cursorPosition = this.selectionStart;
                            // Search the column for that value
                            api
                                .column(colIdx)
                                .search(
                                    this.value != ''
                                        ? regexr.replace('{search}', '(((' + this.value + ')))')
                                        : '',
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
        "lengthMenu":[[5,10,25,50,-1],[5,10,25,50,"All"]],
        "dom": 'lBfrtip',
        "buttons": ["csv", "pdf", "excel","copy","print"],
        "ajax": {
          "url": "<?= base_url() ?>/material/history_card/getAsetDetail?iaset_detail_id=0",
          "dataSrc": ""
        },
        "fnRowCallback": function( data, type, full, meta ) {
            $(data).attr('class', 'warna_detail');;
          },
        "columns": [
          {render: function ( data, type, full, meta ) {
              return meta.row + meta.settings._iDisplayStart + 1;
            }},
          {"data" : "aset_nomor"},
          {"data" : "tgl_penyerahan"},
          {"data" : "tgl_deadline"},
          {"data" : "tgl_selesai"},
          // {"data" : "tgl_movement"},
          {"render":function(data,type,full,meta){
            var pekerjaan = '';
            if(full.pekerjaan_id=='k'){
              pekerjaan = 'Kalibrasi';
            }else if(full.pekerjaan_id=='p'){
              pekerjaan = 'Perbaikan';
            }
            return pekerjaan;
          }},
          {"render":function(data,type,full,meta){
            var status = '';
            if(full.aset_perbaikan_status=='n'){
              status = 'Pengajuan';
            }else if(full.aset_perbaikan_status=='k'){
              status = 'Dikerjakan';
            }else if(full.aset_perbaikan_status=='p'){
              status = 'Pending';
            }else if(full.aset_perbaikan_status=='y'){
              status = 'Selesai';
            }
            return status;
          }},
          // {"data" : "user_nama_lengkap"},
          {"data" : "peminta_jasa_nama"},
          {"render":function(data,type,full,meta){
            return (full.is_jadwal=='y') ? 'Terjadwal' : 'Non Terjadwal'
          }}, 
          {"render":function(data,type,full,meta){
            return  '<center><a href="javascript:;" id="'+full.aset_perbaikan_id+'" onclick="func_edit(this.id)" data-target="#modal_detail" data-toggle="modal"><i class="fa fa-edit"></i></a></center>';
          }},
          {"render":function(data,type,full,meta){
            return  '<center><a href="javascript:;" id="'+full.aset_perbaikan_id+'" onclick="func_history_detail(this.id)" data-target="#modal_history_detail" data-toggle="modal"><i class="fa fa-search"></i></a></center>';
          }},
        ]
      });
    /* Isi Table Detail */
    $('#table_history_detail thead tr')
        .clone(true)
        .addClass('filters_history_detail')
        .appendTo('#table_history_detail thead');

    $('#table_history_detail').DataTable({
      orderCellsTop: true,
        initComplete: function () {
            var api = this.api();
 
            // For each column
            api
                .columns()
                .eq(0)
                .each(function (colIdx) {
                    // Set the header cell to contain the input element
                    var cell = $('.filters_history_detail th').eq(
                        $(api.column(colIdx).header()).index()
                    );
                    var title = $(cell).text();
                    $(cell).html('<input type="text" class="form-control" placeholder="' + title + '" />');
 
                    // On every keypress in this input
                    $(
                        'input',
                        $('.filters_history_detail th').eq($(api.column(colIdx).header()).index())
                    )
                        .off('keyup change')
                        .on('keyup change', function (e) {
                            e.stopPropagation();
 
                            // Get the search value
                            $(this).attr('title', $(this).val());
                            var regexr = '({search})'; //$(this).parents('th').find('select').val();
 
                            var cursorPosition = this.selectionStart;
                            // Search the column for that value
                            api
                                .column(colIdx)
                                .search(
                                    this.value != ''
                                        ? regexr.replace('{search}', '(((' + this.value + ')))')
                                        : '',
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
        // "scrollX": true,
        "lengthMenu":[[5,10,25,50,-1],[5,10,25,50,"All"]],
        // "order":[[1,"desc"],[2,"desc"]],
        "dom": 'lBfrtip',
        "buttons": ["csv", "pdf", "excel","copy","print"],
        "ajax": {
          "url": "<?= base_url() ?>/material/history_card/getAsetHistory?aset_perbaikan_id=0",
          "dataSrc": ""
        },
        "columns": [
          {render: function ( data, type, full, meta ) {
              return meta.row + meta.settings._iDisplayStart + 1;
            }},
          {"data" : "peminta_jasa_nama"},
          {"data" : "tgl_movement"},
          {"data" : "when_create"},
          {"data" : "who_create"},
        ]
      }).columns.adjust();
    // isi tabel history



    // isi tabel history

    /* Tanggal */
    // function fun_tanggal(){
    $("#tanggal").daterangepicker({
        showDropdowns: true,
        singleDatePicker: true,
        locale: {format: 'DD-MM-YYYY'}
      });
    // }

    
    /* Tanggal */

    /* Select2 */
      $('#peminta_jasa_id').select2({
        placeholder: 'Pilih',
        ajax: {
          delay: 250,
          url: '<?= base_url('material/request/getPemintaJasa') ?>',
          dataType: 'json',
          type: 'GET',
          data: function (params) {
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

  $('#modal').on('hidden.bs.modal', function (e) {
    fun_close();
  });

  function fun_tanggal(){
      var today = new Date();
      var hari  = today.getDate();
      var bulan = today.getMonth()+1;
      var tahun = today.getFullYear();
      var tanggal = hari +"-"+ bulan +"-"+tahun;
      $('#tanggal').val(tanggal);
    }

  /* Fun Detail */
  function func_detail (id,name) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if(!json.user_id){
        fun_notifLogout();
      }else{
      fun_loading();
      $('#judul_detail').html('Detail '+name);
      // $('#table').DataTable().ajax.reload(null,false);
      $('#div_detail').css('display', 'block');
      $('#table_detail').DataTable().ajax.url('<?= base_url('material/history_card/getAsetDetail?aset_detail_id=') ?>'+id).load();
      $('html, body').animate({
      scrollTop: $("#div_detail").offset().top
      }, 10);
      setTimeout(function() {$('.warna').removeAttr('style')}, 500);
      setTimeout(function() {$('#'+id).parents('tr').attr('style','color: red')}, 1000);
  }
    });
  }
    /* Fun Detail */
    
    // func history detail
    function func_history_detail(id){
      $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if(!json.user_id){
        fun_notifLogout();
      }else{
      fun_loading();
      // $('#table_detail').DataTable().ajax.reload(null,false);
      $('#table_history_detail').DataTable().ajax.url('<?=base_url('material/history_card/getAsetHistory?aset_perbaikan_id=')?>'+id).load();
      setTimeout(function() {$('.warna_detail').removeAttr('style')}, 500);
      setTimeout(function() {$('#'+id).parents('tr').attr('style','color: red')}, 1000);  
    }
      });
    }
  // func history detail

  // fun edit
  function func_edit(id){
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if(!json.user_id){
        fun_notifLogout();
      }else{
    fun_loading();
    fun_tanggal();
    $.getJSON('<?=base_url('material/history_card/getAsetMovement')?>',{aset_perbaikan_id:id},function(json){
      $.each(json, function(index, val) {
          $('#'+index).val(val);
        });
        $('#aset_perbaikan_id').val(json.aset_perbaikan_id);

        $('#peminta_jasa_id').append('<option selected value="'+json.peminta_id+'">'+json.peminta_jasa_nama+'</option>');
        $('#peminta_jasa_id').select2('data', {id:json.peminta_id, text:json.peminta_jasa_nama});
        $('#peminta_jasa_id').trigger('change');
    })
  }
    });
  }
  // fun edit

  // form detail
  $('#form_modal_detail').on('submit',function(e){
    e.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if(!json.user_id){
        fun_notifLogout();
      }else{
    if($('#aset_pekerjaan_id').val()!='') var url  = '<?=base_url('material/history_card/updateAsetMovement')?>'; else var url = '<?=base_url('material/history_card/insertAsetMovement')?>';
    
    var data = new FormData();
    data.append('aset_perbaikan_id',$('#aset_perbaikan_id').val());
    data.append('tanggal',$('#tanggal').val());
    data.append('peminta_jasa_id',$('#peminta_jasa_id').val());

    e.preventDefault();
    $.ajax({
      url : '<?=base_url('material/history_card/insertAsetMovement')?>',
      data: data,
      type: 'POST',
      processData: false,
      contentType:false,
      beforeSend:function(){
        $('#loading_form').show();
        $('#simpan').hide();  
      },
      complete:function(){
        $('#loading_form').hide();
        $('#simpan').show();  
      },
      success:function(){
        $('#close_detail').click();
        fun_loading();
      }
    })
  }
})
  })
  // form detail

   $('#modal_detail').on('hidden.bs.modal', function (e) {
    func_close_detail();
  });

  $('#modal_history_detail').on('hidden.bs.modal', function (e) {
    func_close_detail();
  });

  function fun_loading() {
    var simplebar = new Nanobar();
    simplebar.go(100);
  }

  

  function fun_close() {
    fun_loading();
      $('#form_modal_detail')[0].reset();
      $('#table').DataTable().ajax.reload(null,false);
    }
  function func_close_detail() {
    fun_loading();
      $('#form_modal_detail')[0].reset();
      $('#table_detail').DataTable().ajax.reload(null,false);    }
</script>