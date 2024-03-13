<script type="text/javascript">
	$(function () {
    /* Isi Table */	
      $('#table').DataTable({
        "scrollX": true,
        "lengthMenu":[[5,10,25,50,-1],[5,10,25,50,"All"]],
        "dom": 'lBfrtip',
        "buttons": ["csv", "pdf", "excel","copy","print"],
        // "autoWidth":false,
        // "ordering":false,
        "ajax": {
            "url": "<?= base_url('document/pengajuan/getDataPengajuan?transaksi_status=1') ?>",
            "dataSrc": ""
          },
          "columns": [
            {"data" : "transaksi_judul_document"},
            {"data" : "jenis_nama"},
            {"data" : "transaksi_tgl_pengesahan"},
            {"data" : "transaksi_nomor_document"},
            {"render": function ( data, type, full, meta ) {
              var status = '';
              var warna = '';
              if (full.transaksi_tipe == '0') {
                status = 'Baru';
                warna = '#7FFF00';
              } else if (full.transaksi_tipe == '1') {
                status = 'Perubahan';
                warna = '#00FFFF';
              }
              return '<span class="badge" style="background-color: '+warna+'">'+status+'</span>';
            }},
            {"data" : "transaksi_revisi"},
            {"data" : "transaksi_terbitan"},
            {"data" : "transaksi_filenya"},
            
            {"render": function ( data, type, full, meta ) {
              return '<center><a href="javascript:;" id="'+full.transaksi_id+'" title="Detail" onclick="fun_detail(this.id)"><i class="fa fa-search" data-toggle="modal" data-target="#modal_aksi_detail"></i></a></center>';
              }
            },
           
          ]
      });
    /* Isi Table */ 

    /* Isi Table Detail */ 
      $('#table1').DataTable({
        "scrollX": true,
        // "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
        // "ordering":false,
        // "autoWidth":false,
        "lengthMenu":[[5,10,25,50,-1],[5,10,25,50,"All"]],
        "dom": 'lBfrtip',
        "buttons": ["csv", "pdf", "excel","copy","print"],
        "ajax": {
            "url": "<?= base_url('document/kaji_ulang/getDataPengajuanDetailDocument') ?>",
            "dataSrc": ""
          },
          "columns": [
            {"data" : "transaksi_detail_tgl_document_pengajuan"},
            {"data" : "transaksi_detail_tgl_document_pengesahan"},
            {"data" : "transaksi_judul_document"},
            {"data" : "transaksi_detail_nomor_document"},
            {"data" : "transaksi_detail_revisi"},
            {"data" : "transaksi_detail_terbitan"},
            {"data" : "transaksi_detail_note_document"},
            {"data" : "transaksi_filenya"},
            {"render": function ( data, type, full, meta ) {
              var status = '';
              var warna = '';
              if (full.transaksi_detail_tipe == '0') {
                status = 'Baru';
                warna = '#00FA9A';
              } else if (full.transaksi_detail_tipe == '1') {
                status = 'Perubahan';
                warna = '#00FFFF';
              }
              return '<span class="badge" style="background-color: '+warna+'">'+status+'</span>';
            }},
            {"render": function ( data, type, full, meta ) {
              var status = '';
              var warna = '';
              if (full.transaksi_detail_status_pengajuan == '0') {
                status = 'Pengajuan';
                warna = '#FFD700';
              } else if (full.transaksi_detail_status_pengajuan == '1') {
                status = 'Approved';
                warna = '#87CEFA';
              } else if (full.transaksi_detail_status_pengajuan == '2') {
                status = 'Ditolak';
                warna = '#FF4500';
              }
              return '<span class="badge" style="background-color: '+warna+'">'+status+'</span>';
            }},
            
          ]
      });
    })
    /* Isi Table Detail */

    function cekBulanKajian(){
      var d = new Date();
      var n = d.getMonth()+1;
      if(n===12){
        toastr.info('Document Dalam Masa Kaji Ulang !!');
      }
    }

    window.onload = cekBulanKajian()
    


  
  function fun_detail(isi) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if(!json.user_id){
        fun_notifLogout();
      }else{
    $('#table').DataTable().ajax.reload(null,false);
    $('#div_detail').css('display', 'block');
    $('#table1').DataTable().ajax.url('<?=base_url()?>document/kaji_ulang/getDataPengajuanDetailDocument?transaksi_id='+isi).load();
    $('html, body').animate({
        scrollTop: $("#div_detail").offset().top
    }, 10);
    setTimeout(function() {$('#'+isi).parents('tr').attr('style','color: red')}, 500);
  }
    });
  }


  function fun_close() {
      $('#simpan').css('display', 'block');
      $('#edit').css('display', 'none');
      $('#div_word_lama').css('display', 'none');
      $('#div_pdf_lama').css('display','none');
      $('#div_detail').hide()
      $('#table').DataTable().ajax.reload(null,false);
      $('#jenis_document').empty();
      $('#seksi').empty();
      $('#transaksi_id').empty();
      $('#form_modal')[0].reset();
      fun_loading();
    }
  /* Fun Close */

  $('#modal').on('hidden.bs.modal', function (e) {
    fun_close();
  });
  
   /* Fun Loading */
   function fun_loading() {
      var simplebar = new Nanobar();
      simplebar.go(100);
    }
  /* Fun Loading */
</script>