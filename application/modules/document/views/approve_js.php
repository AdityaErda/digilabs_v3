<script type="text/javascript">
	$(function () {
    /* Isi Table */	
      $('#table').DataTable({
        "scrollX": true,
        // "ordering":false,
        "lengthMenu":[[5,10,25,50,-1],[5,10,25,50,"All"]],
        "dom": 'lBfrtip',
        "buttons": ["csv", "pdf", "excel","copy","print"],
        "ajax": {
            "url": "<?= base_url('document/approve/getDataPengajuanDetail') ?>",
            "dataSrc": ""
          },
          "columns": [
            {render: function ( data, type, full, meta ) {
              return meta.row + meta.settings._iDisplayStart + 1;
            }},
            {"data" : "transaksi_detail_tgl_document_pengajuan"},
            {"data" : "transaksi_detail_tgl_document_pengesahan"},
            {"data" : "transaksi_judul_document"},
            {"data" : "transaksi_detail_nomor_document"},
            {"data" : "transaksi_detail_keterangan_document"},
            // {"data" : "transaksi_file_pdf"},
            {"data" : "transaksi_filenya"},
            {"render": function ( data, type, full, meta ) {
              var status = '';
              var warna = '';
              if (full.transaksi_detail_tipe == '0') {
                status = 'Baru';
                warna = '#7FFF00';
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
                status = 'Tolak';
                warna = '#FF4500';
              }
              return '<span class="badge" style="background-color: '+warna+'">'+status+'</span>';
            }},
            // {"data" : "t"}
            {"render": function ( data, type, full, meta ) {
              return (full.transaksi_detail_file_pdf!=null) ? '<center><a href="javascript:;" id="'+full.transaksi_detail_file_pdf+'" title="Lihat" onclick="func_lihat(this.id)"><i style="color:red" class="fa fa-file-pdf" data-toggle="modal" data-target="#modal1"></i></a></center>':'';
              }
            },
            {"render": function ( data, type, full, meta ) {
              return (full.transaksi_detail_status_pengajuan=='0') ? '<center><a href="javascript:;" id="'+full.transaksi_detail_id+'" title="Edit" onclick="func_aprove(this.id)"><i style="color:	lawngreen" class="fa fa-share" data-toggle="modal" data-target="#modal"></i></a></center>':'';
              //  return '<center><a href="javascript:;" id="'+full.transaksi_detail_id+'" title="Edit" onclick="func_aprove(this.id)"><i style="color:	lawngreen" class="fa fa-share" data-toggle="modal" data-target="#modal"></i></a></center>';
              }
            },
          ]
      });
    /* Isi Table */ 

    /* Tanggal */
    
    /* Tanggal */

    

    /* Select2 */
      $('.select2').select2({
        placeholder: 'Pilih',
      });

      $('.select2-selection').css('height', '37px');
      $('.select2').css('width', '100%');
    /* Select2 */
	})

  // start tanggal
  function func_tanggal(){
      $("#tanggal").daterangepicker({
      showDropdowns: true,
      singleDatePicker: true,
      locale: {format: 'DD-MM-YYYY'}
      });
    }
  // end tanggal

// function func_tanggal(){
//       $(".tanggal").daterangepicker({
//       showDropdowns: true,
//       singleDatePicker: true,
//       locale: {format: 'DD-MM-YYYY'}
//     });
//     }
  // klik aprove
  function func_aprove(id){
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if(!json.user_id){
        fun_notifLogout();
      }else{
    func_tanggal();
    // $('#simpan').css('display', 'none');
      // $('#edit').css('display', 'block');
      $('#div_word_lama').css('display', 'block');
      $('#div_pdf_lama').css('display','block');
      
      $.getJSON('<?= base_url('document/approve/getDataPengajuanDetail') ?>', {transaksi_detail_id: id}, function(json) {

        console.log(json);
        $.each(json, function(index, val) {
          $('#'+index).val(val);
        });

        // $('#tanggal').val(json.transaksi_waktu);
        // $('#waktu').val(json.transaksi_jam);

        // $('')
        // $('#tanggal').val(json.transaksi_detail_tgl_pengesahan);
        $('#judul_document').val(json.transaksi_judul_document);
        $('#revisi').val(json.transaksi_detail_revisi);
        $('#terbitan').val(json.transaksi_detail_terbitan);
        $('#file_lama').val(json.transaksi_file);
        $('#file_pdf_lama').val(json.transaksi_detail_file_pdf);
        $('#file_word_lama').val(json.transaksi_detail_file_word);
        $('#keterangan').val(json.transaksi_keterangan_document);
        $('#nomor_document').val(json.transaksi_nomor_document);


        
        $('#jenis_document').append('<option selected value="'+json.jenis_id+'">'+json.jenis_nama+'</option>');
        $('#jenis_document').select2('data', {id:json.jenis_id, text:json.jenis_nama});
        $('#jenis_document').trigger('change');

        $('#seksi').append('<option selected value="'+json.seksi_id+'">'+json.seksi_nama+'</option>');
        $('#seksi').select2('data', {id:json.seksi_id, text:json.seksi_nama});
        $('#seksi').trigger('change');

      });
  }
  });
  }
  // klik aprove

  $('#tolak').on('click',function(e){
    e.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if(!json.user_id){
        fun_notifLogout();
      }else{
    let url = ($('#transaksi_id').val() != '')  ? "<?= base_url('document/approve/tolakPengajuan') ?>" : '';

    if($('#jenis_document').val()==null){
        $('#jenis_alert').show()
      }else{
        $('#jenis_alert').hide();
      }
      if($('#seksi').val()==null){
        $('#seksi_alert').show()
      }else{
        $('#seksi_alert').hide();
      }
      if($('#judul_document').val()==''){
        $('#judul_alert').show()
      }else{
        $('#judul_alert').hide();
      }
      if($('#tanggal').val()==''){
        $('#tanggal_alert').show()
      }else{
        $('#tanggal_alert').hide();
      }
      if($('#revisi').val()==''){
        $('#revisi_alert').show()
      }else{
        $('#revisi_alert').hide();
      }
      if($('#terbitan').val()==''){
        $('#terbitan_alert').show()
      }else{
        $('#terbitan_alert').hide();
      }
      if($('#file_word_lama').val()!=''){
      $('#word_alert').hide();
      }else if($('#file_word').val()==''){
        $('#word_alert').css('display','block')
      }else{
        $('#word_alert').hide();
      }
      if($('#file_pdf_lama').val()!=''){
        $('#pdf_alert').hide();
      }else if($('#file_pdf').val()==''){
        $('#pdf_alert').show()
      }else{
        $('#pdf_alert').hide();
      }
      if($('#nomor_document').val()==''){
        $('#nomor_alert').show()
      }else{
        $('#nomor_alert').hide();
      }
     
       
      if ( (($('#jenis_document').val()!=null)&&($('#seksi').val()!=null)&& ($('#judul_document').val()!='')&& ($('#tanggal').val()!='')&& ($('#revisi').val()!='')&& ($('#terbitan').val()!='')&& ($('#file_word').val()!=''||$('#file_word_lama').val()!='')&& ($('#file_pdf').val()!=''||$('#file_pdf_lama').val()!='')&& ($('#nomor_document').val!=''))) {

      var data = new FormData();
      data.append('transaksi_detail_id',$('#transaksi_detail_id').val());
      data.append('transaksi_id',$('#transaksi_id').val());
      data.append('seksi_id',$('#seksi').val()); 
      data.append('transaksi_keterangan_document',$('#keterangan').val());
      // data.append('company_code',$('#').val());
      data.append('transaksi_nomor_document',$('#nomor_document').val())
      data.append('jenis_id',$('#jenis_document').val());
      data.append('transaksi_tgl_pengesahan',$('#tanggal').val());
      data.append('transaksi_judul_document',$('#judul_document').val());
      data.append('transaksi_revisi',$('#revisi').val());
      data.append('transaksi_terbitan',$('#terbitan').val());
      data.append('transaksi_note_document',$('#note').val());
      e.preventDefault();
      $.ajax({
        url:url,
        data:data,
        type:'POST',
        processData: false,
        contentType: false,
        beforeSend:function(){
          $('#loading_form').show();
          $('#tolak').hide();
          $('#aprove').hide();
        },
        complete:function(){ 
          $('#loading').hide();
        },
        success:function(isi) {
          $('#close').click();
          toastr.success('Berhasil');
        }
      });
      }else{
        e.preventDefault();
      }
    }
  });
    });


    $('#aprove').on('click',function(e){
      e.preventDefault();
      $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if(!json.user_id){
        fun_notifLogout();
      }else{
    let url = ($('#transaksi_id').val() != '')  ?
     "<?= base_url('document/approve/aprovePengajuan') ?>" :
     '';
     if($('#jenis_document').val()==null){
        $('#jenis_alert').show()
      }else{
        $('#jenis_alert').hide();
      }
      if($('#seksi').val()==null){
        $('#seksi_alert').show()
      }else{
        $('#seksi_alert').hide();
      }
      if($('#judul_document').val()==''){
        $('#judul_alert').show()
      }else{
        $('#judul_alert').hide();
      }
      if($('#tanggal').val()==''){
        $('#tanggal_alert').show()
      }else{
        $('#tanggal_alert').hide();
      }
      if($('#revisi').val()==''){
        $('#revisi_alert').show()
      }else{
        $('#revisi_alert').hide();
      }
      if($('#terbitan').val()==''){
        $('#terbitan_alert').show()
      }else{
        $('#terbitan_alert').hide();
      }
     
      if($('#file_word_lama').val()!=''){
      $('#word_alert').hide();
      }else if($('#file_word').val()==''){
        $('#word_alert').css('display','block')
      }else{
        $('#word_alert').hide();
      }
      if($('#file_pdf_lama').val()!=''){
        $('#pdf_alert').hide();
      }else if($('#file_pdf').val()==''){
        $('#pdf_alert').show()
      }else{
        $('#pdf_alert').hide();
      }
      if($('#nomor_document').val()==''){
        $('#nomor_alert').show()
      }else{
        $('#nomor_alert').hide();
      }
     
      
      if ( (($('#jenis_document').val()!=null)&&($('#seksi').val()!=null)&& ($('#judul_document').val()!='')&& ($('#tanggal').val()!='')&& ($('#revisi').val()!='')&& ($('#terbitan').val()!='')&&($('#file_word').val()!=''||$('#file_word_lama').val()!='')&& ($('#file_pdf').val()!=''||$('#file_pdf_lama').val()!='')&& ($('#nomor_document').val!=''))) {

      var data = new FormData();
      data.append('transaksi_detail_id',$('#transaksi_detail_id').val());
      data.append('transaksi_id',$('#transaksi_id').val());
      data.append('seksi_id',$('#seksi').val()); 
      data.append('transaksi_keterangan_document',$('#keterangan').val());
      data.append('transaksi_nomor_document',$('#nomor_document').val())
      data.append('jenis_id',$('#jenis_document').val());
      data.append('transaksi_tgl_pengesahan',$('#tanggal').val());
      data.append('transaksi_judul_document',$('#judul_document').val());
      data.append('transaksi_revisi',$('#revisi').val());
      data.append('transaksi_terbitan',$('#terbitan').val());
      data.append('transaksi_note_document',$('#note').val());
      data.append('transaksi_file_word',$('#file_word_lama').val());
      data.append('transaksi_file_pdf',$('#file_pdf_lama').val());
      e.preventDefault();
      $.ajax({
        url:url,
        data:data,
        type:'POST',
        processData: false,
        contentType: false,
        beforeSend:function(){
          $('#loading_form').show();
          $('#tolak').hide();
          $('#aprove').hide();
        },
        complete:function(){
          $('loading_form').hide();
        },
        success:function(isi) {
          $('#close').click();
          toastr.success('Berhasil');
        }
      });
      }else{
        e.preventDefault()
      }
    }
  });
    });

    function func_lihat(data){
      $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if(!json.user_id){
        fun_notifLogout();
      }else{
      fun_loading();
      $('#document').remove();
      // if(data!=''){
      // $('#div_document').append('<iframe src="https://docs.google.com/viewer?url=<?= base_url('upload/') ?>'+data+'&embedded=true" frameborder="0" id="document" width="100%"></iframe>');
      $('#div_document').append('<embed src="<?= base_url('upload/') ?>'+data+'#toolbar=0" frameborder="0" id="document" width="100%"></embed>');
      // }else{
        // alert('tes');
      // }
    }
  });
    }

    function fun_close() {
      fun_loading();
      $('#simpan').css('display', 'block');
      $('#edit').css('display', 'none');
      $('#tolak').show();
      $('#aprove').show();
      $('#loading_form').css('display', 'none');
      $('#div_word_lama').css('display', 'none');
      $('#div_pdf_lama').css('display','none');
      $('#jenis_document').empty();
      $('#seksi').empty();
      $('#transaksi_id').empty();
      $('#form_modal')[0].reset();
      $('#table').DataTable().ajax.reload(null,false);
    }
  /* Fun Close */

  $('#modal').on('hidden.bs.modal', function (e) {
    fun_close();
  });
  $('#modal1').on('hidden.bs.modal', function (e) {
    fun_close();
  });

  function cekBulanKajian(){
      var d = new Date();
      var n = d.getMonth()+1;
      if(n===12){
        toastr.info('Document Dalam Masa Kaji Ulang !!');
      }
    }

    window.onload = cekBulanKajian();
    
     /* Fun Loading */
   function fun_loading() {
      var simplebar = new Nanobar();
      simplebar.go(100);
    }
  /* Fun Loading */
  $(document).keypress(
    function(event){
      if (event.which == '13') {
      event.preventDefault();
      }
  });
</script>