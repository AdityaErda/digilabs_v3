<script type="text/javascript">
  $(function() {
    /* Isi Table */


    $('#table').DataTable({
      "scrollX": true,
      // "ordering":false,
      "lengthMenu": [
        [5, 10, 25, 50, -1],
        [5, 10, 25, 50, "All"]
        ],
      "dom": 'lBfrtip',
      "buttons": [
      {
        extend:'csv',
        exportOptions:{
          columns:[0,1,2,3,4,5,6],
        }
      }, 
      {
        extend:'pdfHtml5',
        exportOptions:{
          columns:[0,1,2,3,4,5,6],
        }
      },
      {
        extend:'excel',
        exportOptions:{
          columns:[0,1,2,3,4,5,6],
        }
      },
      {
        extend:'copy',
        exportOptions:{
          columns:[0,1,2,3,4,5,6],
        }
      },
      {
        extend:'print',
        exportOptions:{
          columns:[0,1,2,3,4,5,6],
        }
      },
      // 'colvis'
      ],
      "ajax": {
        "url": "<?= base_url('document/pengajuan/getDataPengajuan?transaksi_status=1') ?>",
        "dataSrc": ""
      },
      "columns": [{
        render: function(data, type, full, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
        }
      },
      {
        "data": "transaksi_judul_document"
      },
      {
        "data": "jenis_nama"
      },
      {
        "data": "transaksi_tgl_pengesahan"
      },
      {
        "data": "transaksi_nomor_document"
      },
      {
        "data": "transaksi_revisi"
      },
      {
        "data": "transaksi_terbitan"
      },
      {
        "data": "transaksi_filenya"
      },
      <?php $login_as     = $this->session->userdata();
      $login_role   = $this->db->query("SELECT role_id FROM global.global_role WHERE role_id = '5c52e905e81f137cc9357a0555a6948f81e84254' OR role_id = '1' OR role_id = '79d5b34a78b48d85eb1b65249fca73704dc49665'")->result_array();
      $login_role_x = $this->db->query("SELECT role_id FROM global.global_role WHERE role_id != '5c52e905e81f137cc9357a0555a6948f81e84254' AND role_id != '1' AND role_id != '79d5b34a78b48d85eb1b65249fca73704dc49665'")->result_array();
      ?>
      <?php foreach ($login_role as $value) : ?>
        <?php if ($login_as['role_id'] == $value['role_id']) : ?> {
          "render": function(data, type, full, meta) {
            var tambol = '';
            var tombol = '<div class="input-group-prepend" ><button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Action</button><div style="height:auto;max-height: 140px;overflow-x:hidden;" class="dropdown-menu"><a data-toggle="modal" data-target="#modal_download" class="dropdown-item" href="javascript:;" id="' + full.transaksi_id + '" title="Download" onclick="fun_download(this.id)">Download <i style="color:darkcyan" ></i></a><a class="dropdown-item" href="javascript:;" id="' + full.transaksi_file_pdf + '" title="Lihat" onclick="func_lihat(this.id)" data-toggle="modal" data-target="#modal1">Lihat <i style="color:deepskyblue" ></i></a><a class="dropdown-item" href="<?= base_url('document/daftar/cover?transaksi_id=') ?>' + full.transaksi_id + '" target="_BLANK" id="' + full.transaksi_id + '" title="Cover">Cover <i style="color:steelblue" ></i></a><a data-toggle="modal" data-target="#modal_perubahan" class="dropdown-item" href="javascript:;" id="' + full.transaksi_id + '" title="Perubahan" onclick="func_perubahan(this.id)">Perubahan <i style="color:lawngreen"  ></i></a><a class="dropdown-item" href="javascript:;" id="' + full.transaksi_id + '" title="Hapus" onclick="return func_hapus(this.id)">Hapus <i style="color:red"  ></i></a><a class="dropdown-item" href="javascript:;" name="' + full.transaksi_judul_document + '" id="' + full.transaksi_id + '" title="Detail" onclick="fun_detail(this.id,this.name)">Detail <i ></i></a><a class="dropdown-item" href="javascript:;" id="' + full.transaksi_id + '" title="history" onclick="func_history(this.id)" data-toggle="modal" data-target="#modal_history">History <i style="color:springgreen"></i></a></div></div>';
            return tombol;
          }
        },
      <?php endif; ?>
    <?php endforeach; ?>

    <?php foreach ($login_role_x as $value) : ?>
      <?php if ($login_as['role_id'] == $value['role_id']) : ?> {
        "render": function(data, type, full, meta) {
          var tambol = '';
          var tombol = '<div class="input-group-prepend" ><button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Action</button><div style="height:auto;max-height: 140px;overflow-x:hidden;" class="dropdown-menu"><a data-toggle="modal" data-target="#modal_download" class="dropdown-item" href="javascript:;" id="' + full.transaksi_id + '" title="Download" onclick="fun_download(this.id)">Download <i style="color:darkcyan" ></i></a><a class="dropdown-item" href="javascript:;" id="' + full.transaksi_file_pdf + '" title="Lihat" onclick="func_lihat(this.id)" data-toggle="modal" data-target="#modal1">Lihat <i style="color:deepskyblue" ></i></a></div></div>';
          return tombol;
        }
      },
    <?php endif; ?>
  <?php endforeach; ?>
  ]
});
    /* Isi Table */
    // perubahan diklik

    // perubahan diklik
    // table download
$('#table_download').DataTable({
  "lengthMenu": [
    [5, 10, 25, 50, -1],
    [5, 10, 25, 50, "All"]
    ],
  "dom": 'lBfrtip',
  "buttons": ["csv", "pdf", "excel", "copy", "print"],
  "ordering": false,
  "autoWidth": false,
  "ajax": {
    "url": "<?= base_url('document/daftar/getDataPengajuanDocument') ?>",
    "dataSrc": ""
  },
  "columns": [{
    "render": function(data, type, full, meta) {
      return '<center><a href="javascript:;" id="' + full.transaksi_id + '" name="' + full.transaksi_file_pdf + '"  title="Download PDF" style="color:blue"  onclick="func_historyDownload(this.id,this.name);">' + full.transaksi_file_pdf + '</a></center>';
    }
  },
  <?php $login_as = $this->session->userdata(); ?>
  <?php $role = $this->db->query("SELECT * FROM global.global_role WHERE role_id = '1' OR role_id = '5c52e905e81f137cc9357a0555a6948f81e84254'")->result_array(); ?>
  <?php foreach ($role as $value) { ?>
    <?php if ($value['role_id'] == $login_as['role_id']) { ?> {
      "render": function(data, type, full, meta) {
        return '<center><a href="javascript:;" id="' + full.transaksi_id + '" name="' + full.transaksi_file_word + '"  title="Download Word" style="color:blue" onclick="func_historyDownload(this.id,this.name);">' + full.transaksi_file_word + '</a></center>';
      }
    },
  <?php }
} ?>
]
});
    // table download


    /* Isi Table Detail */
$('#table1').DataTable({
  "scrollX": true,
      // "ordering":false,
  "lengthMenu": [
    [5, 10, 25, 50, -1],
    [5, 10, 25, 50, "All"]
    ],
  "dom": 'lBfrtip',
  "buttons": ["csv", "pdf", "excel", "copy", "print"],
  "ajax": {
    "url": "<?= base_url('document/daftar/getDataPengajuanDetailDocument') ?>",
    "dataSrc": ""
  },
  "columns": [{
    "data": "transaksi_detail_tgl_document_pengajuan"
  },
  {
    "data": "transaksi_detail_tgl_document_pengesahan"
  },
  {
    "data": "transaksi_judul_document"
  },
  {
    "data": "transaksi_detail_nomor_document"
  },
  {
    "data": "transaksi_detail_revisi"
  },
  {
    "data": "transaksi_detail_terbitan"
  },
  {
    "data": "transaksi_detail_keterangan_document"
  },
  {
    "data": "transaksi_detail_note_document"
  },
  {
    "data": "transaksi_filenya"
  },
  {
    "render": function(data, type, full, meta) {
            // var tambol = '';
            // var tombol = '<div class="input-group-prepend" ><button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Action</button><div style="height:auto;max-height: 135px;overflow-x: hidden;" class="dropdown-menu pre-scrollable" id="dropdown"><a class="dropdown-item" href="#" id="'+full.transaksi_id+'" name="'+full.transaksi_detail_file_pdf+'"  title="Download" onclick="func_historyDownload(this.id,this.name);(this.name)">Download PDF <i style="color:red"></i></a><a class="dropdown-item" href="#" id="'+full.transaksi_id+'" name="'+full.transaksi_detail_file_word+'"  title="Download" onclick="func_historyDownload(this.id,this.name);">Download Word <i style="color:blue"></i></a><a class="dropdown-item" href="#" id="'+full.transaksi_detail_id+'" title="history" onclick="func_historyDetail(this.id)" data-toggle="modal" data-target="#modal_history_detail" >History <i  style="color:springgreen"></i></a></div></div>';
      var tombol = '<div class="input-group-prepend" ><button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Action</button><div style="height:auto;max-height: 135px;overflow-x: hidden;" class="dropdown-menu pre-scrollable" id="dropdown"><a class="dropdown-item" href="#" id="' + full.transaksi_id + '" name="' + full.transaksi_detail_file_pdf + '"  title="Download" onclick="func_historyDownload(this.id,this.name);(this.name)">Download PDF <i style="color:red"></i></a><a class="dropdown-item" href="#" id="' + full.transaksi_id + '" name="' + full.transaksi_detail_file_word + '"  title="Download" onclick="func_historyDownload(this.id,this.name);">Download Word <i style="color:blue"></i></a></div></div>';
      return tombol;
    }
  },
  ]
});
    /* Isi Table Detail */

    // table history
$('#table_history').DataTable({
      // "scrollX": true,
  "lengthMenu": [
    [5, 10, 25, 50, -1],
    [5, 10, 25, 50, "All"]
    ],
  "dom": 'lBfrtip',
  "buttons": ["csv", "pdf", "excel", "copy", "print"],
  "autoWidth": false,
  "ordering": false,
  "ajax": {
    "url": "<?= base_url('document/daftar/getHistoryDownload') ?>",
    "dataSrc": ""
  },
  "columns": [{
    "data": "history_file_download"
  },
  {
    "data": "who_download"
  },
  {
    "data": "when_download"
  },
  ]
});
    // table history

    // table history
$('#table_history_detail').DataTable({
      // "scrollX": true,
  "ordering": false,
  "lengthMenu": [
    [5, 10, 25, 50, -1],
    [5, 10, 25, 50, "All"]
    ],
  "dom": 'lBfrtip',
  "buttons": ["csv", "pdf", "excel", "copy", "print"],
  "autoWidth": false,
  "ajax": {
    "url": "<?= base_url('document/daftar/getHistoryDownloadDetail') ?>",
    "dataSrc": ""
  },
  "columns": [{
    "data": "history_file_download"
  },
  {
    "data": "who_download"
  },
  {
    "data": "when_download"
  },
  ]
});
    // table history

    /* Tanggal */
$(".tanggal").daterangepicker({
  showDropdowns: true,
  singleDatePicker: true,
  locale: {
    format: 'DD-MM-YYYY'
  }
});
    /* Tanggal */

    /* Tanggal */
$("#tanggal").daterangepicker({
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

    // start jenis dokumen select2
$('#jenis_document').select2({
  placeholder: 'Pilih',
  ajax: {
    delay: 250,
    url: '<?= base_url('document/pengajuan/getJenisDocument') ?>',
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

$('.select2-selection').css('height', '37px');
$('.select2').css('width', '100%');
    // end jenis dokumen select2

    // start jenis dokumen select2
$('#seksi').select2({
  placeholder: 'Pilih',
  ajax: {
    delay: 250,
    url: '<?= base_url('document/pengajuan/getSeksi') ?>',
    dataType: 'json',
    type: 'GET',
    data: function(params) {
      var queryParameters = {
        seksi_nama: params.term
      }
      return queryParameters;
    }
  }
});

$('.select2-selection').css('height', '37px');
$('.select2').css('width', '100%');
    // end jenis dokumen select2
});

  // start hapus
function func_hapus(isi) {
  $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
    if (!json.user_id) {
      fun_notifLogout();
    } else {
      fun_loading();
      $.confirmModal('Yakin hapus dokumen ?', function(el) {
        $.post('<?= base_url('document/pengajuan/hapusPengajuan') ?>', {
          transaksi_id: isi
        }, function(data) {
          $('#close').click();
          toastr.success('Berhasil');
        })
      })
    }
  })
}
  // end hapus

function func_no_doc1(isi) {
  var transaksi_id = $('#transaksi_id').val();
  var data = $('#jenis_document').val();
  $.getJSON('<?= base_url('document/pengajuan/getNomorDocument') ?>', {
    transaksi_id: transaksi_id,
    jenis_id: data,
    seksi_id: isi
  }, function(result, json) {
    $('#nomor_document').val(result.kodefinal);
    $('#transaksi_urut_document').val(result.kodeurut);
  })
}

  // perubahan
function func_perubahan(id) {
  $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
    if (!json.user_id) {
      fun_notifLogout();
    } else {
      fun_loading();
      $('#simpan_perubahan').css('display', 'none');
      $('#edit_perubahan').css('display', 'block');
      $('#div_word_lama').css('display', 'block');
      $('#div_pdf_lama').css('display', 'block');

      $.getJSON('<?= base_url('document/pengajuan/getDataPengajuan') ?>', {
        transaksi_id: id
      }, function(json) {
          // console.log(json);
        $.each(json, function(index, val) {
          $('#' + index).val(val);
        });
        console.log(json.transaksi_nomor_document);
        $('#tanggal').val(json.transaksi_tgl_pengesahan);
        $('#judul_document').val(json.transaksi_judul_document);
        $('#revisi').val(json.transaksi_revisi);
        $('#terbitan').val(json.transaksi_terbitan);
        $('#file_word_lama').val(json.transaksi_file_word);
        $('#file_pdf_lama').val(json.transaksi_file_pdf);
        $('#keterangan').val(json.transaksi_keterangan_document);
        $('#nomor_document').val(json.transaksi_nomor_document);


        $('#jenis_document').append('<option selected value="' + json.jenis_id + '">' + json.jenis_nama + '</option>');
        $('#jenis_document').select2('data', {
          id: json.jenis_id,
          text: json.jenis_nama
        });
          // $('#jenis_document').trigger('change');

        $('#seksi').append('<option selected value="' + json.seksi_id + '">' + json.seksi_nama + '</option>');
        $('#seksi').select2('data', {
          id: json.seksi_id,
          text: json.seksi_nama
        });
          // $('#seksi').trigger('change');
      });
    }
  })
}
  // perubahan

  // start form modal klik simpan/edit
$("#form_modal_perubahan").on("submit", function(e) {
  e.preventDefault();
  $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
    if (!json.user_id) {
      fun_notifLogout();
    } else {
      let url = ($('#transaksi_id').val() != '') ?
      '<?= base_url('document/daftar/updatePerubahan') ?>' :
      '<?= base_url('document/daftar/insertPerubahan') ?>';

      var file_word = ($('#file_word').prop('files')[0]) ? ($('#file_word').prop('files')[0]) : ($('#file_word_lama').val());
      var file_pdf = ($('#file_pdf').prop('files')[0]) ? ($('#file_pdf').prop('files')[0]) : ($('#file_pdf_lama').val());

      if ($('#jenis_document').val() == null) {
        $('#jenis_alert').css('display', 'block');
      } else {
        $('#jenis_alert').css('display', 'none');
      }
      if ($('#seksi').val() == null) {
        $('#seksi_alert').css('display', 'block');
      } else {
        $('#seksi_alert').css('display', 'none');
      }
      if ($('#judul_document').val() == '') {
        $('#judul_alert').css('display', 'block');
      } else {
        $('#judul_alert').css('display', 'none');
      }
      if ($('#tanggal').val() == '') {
        $('#tanggal_alert').css('display', 'block');
      } else {
        $('#tanggal_alert').css('display', 'none');
      }
      if ($('#revisi').val() == '') {
        $('#revisi_alert').css('display', 'block');
      } else {
        $('#revisi_alert').css('display', 'none');
      }
      if ($('#terbitan').val() == '') {
        $('#terbitan_alert').css('display', 'block');
      } else {
        $('#terbitan_alert').css('display', 'none');
      }
      if ($('#keterangan').val() == '') {
        $('#keterangan_alert').css('display', 'block');
      } else {
        $('#keterangan_alert').css('display', 'none');
      }
      if ($('#nomor_document').val() == '') {
        $('#nomor_alert').css('display', 'block');
      } else {
        $('#nomor_alert').css('display', 'none');
      }

      if ((($('#jenis_document').val() != null) && ($('#seksi').val() != null) && ($('#judul_document').val() != '') && ($('#tanggal').val() != '') && ($('#revisi').val() != '') && ($('#terbitan').val() != '') && ($('#keterangan').val() != '') && ($('#nomor_document').val != ''))) {
          // alert('ok');

        var data = new FormData();
        data.append('transaksi_id', $('#transaksi_id').val());
        data.append('transaksi_urut_document', $('#transaksi_urut_document').val())
        data.append('seksi_id', $('#seksi').val());
        data.append('transaksi_keterangan_document', $('#keterangan').val());
          // data.append('company_code',$('#').val());
        data.append('transaksi_nomor_document', $('#nomor_document').val())
        data.append('jenis_id', $('#jenis_document').val());
        data.append('transaksi_tgl_pengajuan', $('#tanggal').val());
        data.append('transaksi_judul_document', $('#judul_document').val());
        data.append('transaksi_revisi', $('#revisi').val());
        data.append('transaksi_terbitan', $('#terbitan').val());
        data.append('transaksi_file_word', file_word);
        data.append('transaksi_file_pdf', file_pdf);
        e.preventDefault();
        $.ajax({
          url: url,
          data: data,
          type: 'POST',
          processData: false,
          contentType: false,
          beforeSend: function() {
            $('#loading_form').show();
            $('#edit_perubahan').hide();
            $('#simpan_perubahan').hide();
          },
          complete: function() {
            $('#loading_form').hide();
          },
          success: function(isi) {
            fun_loading();
            $('#close_perubahan').click();
            toastr.success('Berhasil');
          }
        });
      } else {
        e.preventDefault();
      }
    }
  })
});
  // end form modal klik simpan/edit


function fun_detail(isi, name) {
  $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
    if (!json.user_id) {
      fun_notifLogout();
    } else {
      fun_loading();
        // alert(name);
      $('#detail_nama').val(name);
      $('#table').DataTable().ajax.reload(null, false);
      $('#div_detail').css('display', 'block');
      $('#table1').DataTable().ajax.url('<?= base_url() ?>document/daftar/getDataPengajuanDetailDocument?transaksi_id=' + isi).load();
      $('html, body').animate({
        scrollTop: $("#div_detail").offset().top
      }, 10);
      setTimeout(function() {
        $('#' + isi).parents('tr').attr('style', 'color: red')
      }, 500);
    }
  });
}

  // download
function fun_download(id) {
  $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
    if (!json.user_id) {
      fun_notifLogout();
    } else {
      fun_loading();
      $('#table_download').DataTable().ajax.url('<?= base_url('document/daftar/getDataPengajuanDocument?transaksi_id=') ?>' + id).load();
    }
  });
}
  // download

function func_history(id) {
  $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
    if (!json.user_id) {
      fun_notifLogout();
    } else {
      fun_loading();
      $('#table_history').DataTable().ajax.url('<?= base_url('document/daftar/getHistoryDownload?transaksi_id=') ?>' + id).load();
    }
  });
}

function func_historyDetail(id) {
  $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
    if (!json.user_id) {
      fun_notifLogout();
    } else {
      fun_loading();
      $('#table_history_detail').DataTable().ajax.url('<?= base_url('document/daftar/getHistoryDownloadDetail?transaksi_detail_id=') ?>' + id).load();
    }
  });
}

function func_historyDownload(id, name) {
  $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
    if (!json.user_id) {
      fun_notifLogout();
    } else {
      fun_loading();
        // console.log(id);
      func_downloadFile(name)
        // var id = id;
        // var name = name;
      var data = new FormData();
      var today = new Date();
      var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
      var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
      var dateTime = date + ' ' + time;
      data.append('transaksi_id', id);
      data.append('history_file_download', name);
      data.append('when_download', dateTime);

      $.ajax({
        url: '<?= base_url('document/daftar/historyDownload'); ?>',
        data: data,
        dataType: 'HTML',
        type: 'post',
        processData: false,
        contentType: false,
        success: function(isi) {}
      })
    }
  });
}

function func_historyDownloadDetail(id, name) {
  $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
    if (!json.user_id) {
      fun_notifLogout();
    } else {
      fun_loading();
      func_downloadFile(name);
      console.log(name)
      var id = id;
      var name = name;
      var data = new FormData();
      var today = new Date();
      var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
      var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
      var dateTime = date + ' ' + time;
      data.append('transaksi_detail_id', id);
      data.append('history_file_download', name);
      data.append('when_download', dateTime);


      $.ajax({
        url: '<?= base_url('document/daftar/historyDownload'); ?>',
        data: data,
        dataType: 'HTML',
        type: 'post',
        processData: false,
        contentType: false,
        success: function(isi) {

        }
      })
    }
  });
}


function func_downloadFile(name) {
  $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
    if (!json.user_id) {
      fun_notifLogout();
    } else {
      fun_loading();
      console.log(name);
      window.open('<?= base_url('upload/') ?>' + name);
    }
  });
}



function func_lihat(data) {
  $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
    if (!json.user_id) {
      fun_notifLogout();
    } else {
      fun_loading();
      $('#document').remove();
        // 2
        // $('#div_document').append('<iframe src="https://docs.google.com/viewer?url=<?= base_url('upload/') ?>'+data+'&embedded=true" frameborder="0" id="document" width="100%"></iframe>');
      $('#div_document').append('<embed src="<?= base_url('upload/') ?>' + data + '#toolbar=0" frameborder="0" id="document" width="100%"></embed>');
    }
  });
}
  // lihat document

function fun_close() {
  $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
    if (!json.user_id) {
      fun_notifLogout();
    } else {
      fun_loading();
      $('#simpan').css('display', 'block');
      $('#edit').hide();
      $('#div_word_lama').hide();
      $('#div_pdf_lama').hide();
      $('#jenis_alert').hide();
      $('#seksi_alert').hide();
      $('#judul_alert').hide();
      $('#tanggal_alert').hide();
      $('#revisi_alert').hide();
      $('#terbitan_alert').hide();
      $('#keterangan_alert').hide();
      $('#word_alert').hide();
      $('#pdf_alert').hide();
      $('#nomor_alert').hide();
      $('#div_detail').hide();
      $('#jenis_document').empty();
      $('#seksi').empty();
      $('#transaksi_id').empty();
      $('#form_modal')[0].reset();
      $('#form_modal_perubahan')[0].reset();
      $('#table').DataTable().ajax.reload(null, false);
    }
  });
}
  /* Fun Close */

$('#modal').on('hidden.bs.modal', function(e) {
  fun_close();
});
$('#modal_perubahan').on('hidden.bs.modal', function(e) {
  fun_close();
});
$('#modal_download').on('hidden.bs.modal', function(e) {
  fun_close();
});
$('#modal1').on('hidden.bs.modal', function(e) {
  fun_close();
});
$('#modal_history').on('hidden.bs.modal', function(e) {
  fun_close();
});
$('#modal_history_detail').on('hidden.bs.modal', function(e) {
  fun_close();
});

  // $('#dropdown').on('')



function cekBulanKajian() {
  var d = new Date();
  var n = d.getMonth() + 1;
  if (n === 12) {
    toastr.info('Document Dalam Masa Kaji Ulang !!');
  }
}

window.onload = cekBulanKajian()



  /* Fun Loading */
function fun_loading() {
  var simplebar = new Nanobar();
  simplebar.go(100);
}
  /* Fun Loading */
</script>