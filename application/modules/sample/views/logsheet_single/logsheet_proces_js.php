<script type="text/javascript">
  $(function() {
    $(".tanggal").daterangepicker({
      showDropdowns: true,
      singleDatePicker: true,
      locale: {
        format: 'DD-MM-YYYY'
      },
    });

    /* Select2 */
    $('#logsheet_pengolah_sample_list').select2();

    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');
    /* Select2 */

    fun_rumus('<?= $_GET['template_logsheet_id'] ?>');

    $.getJSON('<?= base_url('sample/inbox/cekLogsheet') ?>', {
      logsheet_id: '<?= $this->input->get('logsheet_id') ?>'
    }, function(json) {
      if (json != null) {
        $('#logsheet_tgl_sampling').val(json.logsheet_tgl_sampling_indo);
        $('#logsheet_tgl_terima').val(json.logsheet_tgl_terima_indo);
        $('#logsheet_tgl_uji').val(json.logsheet_tgl_uji_indo);
        $('#logsheet_asal_sample').val(json.logsheet_asal_sample);
        $('#log_jenis_nama').val(json.logsheet_jenis);
        $('#log_deskripsi').val(json.logsheet_deskripsi);
        $('#logsheet_pengolah_sample_list').val(json.logsheet_pengolah_sample).trigger('change');
        $.getJSON('<?= base_url() ?>/master/template_logsheet/getDetailLogsheet', {
          id_logsheet_template: '<?= $this->input->get('template_logsheet_id') ?>'
        }, function(data) {
          $.each(data, function(index, val) {
            // setTimeout(function() {
            $.getJSON('<?= base_url('sample/inbox/cekLogsheetDetail') ?>', {
              logsheet_id: '<?= $this->input->get('logsheet_id') ?>',
              rumus_id: val.rumus_id
            }, function(isi) {
              var urut = 0;
              $.each(isi, function(i, v) {
                urut++;
                if (urut == 1) {
                  setTimeout(function() {
                    $.getJSON('<?= base_url('sample/inbox/cekLogsheetDetailDetail') ?>', {
                      id_logsheet_detail: v.logsheet_detail_id
                    }, function(isi_detail) {
                      $.each(isi_detail, function(i_detail, v_detail) {
                        $('#rumus_detail_isi' + v_detail.rumus_detail_id).val(v_detail.rumus_detail_isi);
                      });
                    });

                    $('#hasil_' + val.rumus_id).val(v.rumus_hasil);
                    $('#rumus_detail_hasil_' + val.rumus_id).val(v.rumus_hasil);
                    $('#rumus_satuan_' + val.rumus_id).val(v.rumus_satuan);
                    $('#rumus_metoda_' + val.rumus_id).val(v.rumus_metoda);
                  }, 5000);
                } else {
                  add_simplo_logsheet(val.rumus_id, v.rumus_satuan, v.rumus_metoda, urut);
                  setTimeout(function() {
                    $.getJSON('<?= base_url('sample/inbox/cekLogsheetDetailDetail') ?>', {
                      id_logsheet_detail: v.logsheet_detail_id
                    }, function(isi_detail) {
                      $.each(isi_detail, function(i_detail, v_detail) {
                        $('#rumus_detail_isi' + v_detail.rumus_detail_id + '_' + v.logsheet_detail_urut).val(v_detail.rumus_detail_isi);
                      });
                    });
                    $('#hasil_' + val.rumus_id + '_' + v.logsheet_detail_urut).val(v.rumus_hasil);
                    $('#rumus_detail_hasil_' + val.rumus_id + '_' + v.logsheet_detail_urut).val(v.rumus_hasil);
                    $('#rumus_satuan_' + val.rumus_id + '_' + v.logsheet_detail_urut).val(v.rumus_satuan);
                    $('#rumus_metoda_' + val.rumus_id + '_' + v.logsheet_detail_urut).val(v.rumus_metoda);
                    $('#rata_' + val.rumus_id + '_' + v.logsheet_detail_urut).val(v.rumus_avg);
                    $('#nilai_adbk_' + val.rumus_id + '_' + v.logsheet_detail_urut).val(v.rumus_adbk);
                  }, 5000);
                }
              });
            });
            // }, 2500);
          });
        });
      }
    });
  });

  /* Ganti Pengambil Sample */
  $('#logsheet_pengolah_sample_list').on('change', function() {
    var pengolah = $(this).val();

    if (pengolah == '9999') {
      $('.logsheet_pengolah_sample_input').show();
      $('.logsheet_pengolah_sample_input_cancel').css('display', 'block');
      $('.logsheet_pengolah_sample_input').prop("disabled", false);
      $('.logsheet_pengolah_sample_list').prop("disabled", true);
    } else {
      $('.logsheet_pengolah_sample_input').hide();
      $('.logsheet_pengolah_sample_input_cancel').hide();
      $('.logsheet_pengolah_sample_input').prop("disabled", true);
      $('.logsheet_pengolah_sample_list').prop("disabled", false);
    }
  });
  /* Ganti Pengambil Sample */

  /* Cancel Pengambil Sample Lain-lain */
  function pengolah_input_cancel(id) {
    $('.logsheet_pengolah_sample_input').hide();
    $('.logsheet_pengolah_sample_input_cancel').hide();
    $('.logsheet_pengolah_sample_input').prop("disabled", true);
    $('.logsheet_pengolah_sample_list').prop("disabled", false);
    $('#logsheet_pengolah_sample_list').val(id).trigger('change');
  }
  /* Cancel Pengambil Sample Lain-lain */

  /* Fun Rumus */
  function fun_rumus(id) {
    var html = "";
    $.getJSON('<?= base_url() ?>/master/template_logsheet/getDetailLogsheet', {
      id_logsheet_template: id
    }, function(json) {
      html += '<div class="row">';
      $.each(json, function(index, val) {
        var metoda = (val.metode != null) ? val.metode : '';
        html += '<div class="card-header col-12">';
        html += '<h3 class="card-title">' + val.rumus_nama + ' = <b id="list_' + val.rumus_id + '"></b></h3>';
        html += '<button type="button" id="adbk_' + val.rumus_id + '" name="adbk[]" class="btn btn-info btn-custom float-right" style="display:none" onclick="fun_adbk(`' + val.rumus_id + '`)">ADBK</button>';
        html += '</div>';
        html += '<div class="card-body col-12 row">';
        html += '<div class="col-6">';
        html += '<div class="form-group row col-12">';
        html += '<label class="col-md-4">Metoda</label>';
        html += '<div class="input-group col-md-8">';
        html += '<input type="text" class="form-control" id="rumus_metoda_' + val.rumus_id + '" name="rumus_metoda" readonly>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '<div class="col-6">';
        html += '<div class="form-group row col-12">';
        html += '<label class="col-md-4">Satuan</label>';
        html += '<div class="input-group col-md-8">';
        html += '<input type="text" class="form-control" name="rumus_satuan" id="rumus_satuan_' + val.rumus_id + '" readonly>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '<table id="' + val.rumus_id + '" class="table table-bordered datatables" width="100%">';
        html += '<thead id="header_' + val.rumus_id + '"></thead>';
        html += '<tbody id="body_' + val.rumus_id + '"></tbody>';
        html += '<tfoot id="footer_' + val.rumus_id + '"></tfoot>'
        html += '</table>';
        html += '</div>';
        fun_detail_rumus(val.rumus_id, val.satuan_sample, metoda);
        fun_list_rumus(val.rumus_id);
      });
      html += '</div>';

      $('#div_rumus').html(html);
    });
  }
  /* Fun Rumus */

  /* Fun Detail Rumus */
  function fun_detail_rumus(id, satuan, metoda) {
    var header = "";
    var body = "";
    var footer = "";
    var footer_adbk = "";
    var logsheet_detail_id = Date.now();

    $.getJSON('<?= base_url() ?>/master/perhitungan_sample/getDetailRumusSampleTemplate', {
      id_rumus: id
    }, function(json) {
      header += '<tr>';
      header += '<th>No</th>';
      body += '<tr class="tr" id="tr_' + id + '">';
      body += '<td>1</td>'

      footer += '<tr class="tr_foot_' + id + '" id="tr_foot_' + id + '" style="display:none">'
      footer_adbk += '<tr class="tr_foot_adbk_' + id + '" id="tr_foot_adbk_' + id + '" style="display:none">'

      $.each(json, function(index, val) {
        header += '<th>' + val.rumus_detail_nama + '</th>';
        body += '<td>';
        body += '<input type="text" id="rumus_detail_isi' + val.rumus_detail_id + '" name="rumus_detail_isi[]" class="form-control" readonly>';
        body += '</td>';
      });
      
      header += '<th>Hasil</th>';
      header += '</tr>';

      body += '<td>';
      body += '<input type="text" class="form-control hasil_' + id + '" id="hasil_' + id + '" name="hasil_' + id + '[1]" readonly readonly>';
      body += '</td>';
      body += '</tr>';

      footer += '<td colspan="' + (json.length + 1) + '"><p>Rata-rata </p></td><td><input class="form-control" type="text" id="rata_' + id + '" name="rata_rata[]" readonly style="display:none"></td>';
      footer += '</tr>';

      footer_adbk += '<td colspan="' + (json.length + 1) + '"><p>Rata-rata </p></td><td><input class="form-control" placeholder="klik untuk nilai adbk" type="text" id="nilai_adbk_' + id + '" name="nilai_adbk[]" onclick="fun_nilai_adbk(`' + id + '`)" readonly style="display:none"></td>';
      footer_adbk += '</tr>';

      $('#header_' + id).html(header);
      $('#body_' + id).append(body);
      $('#footer_' + id).append(footer);
      $('#footer_' + id).append(footer_adbk);
    });
  }
  /* Fun Detail Rumus */

  /* Fun List Rumus */
  function fun_list_rumus(id) {
    var html = "";
    $.getJSON('<?= base_url() ?>/master/perhitungan_sample/getListRumus', {
      id_rumus: id
    }, function(json) {
      $.each(json, function(index, val) {
        html += val.rumus;
      });

      $('#list_' + id).html(html);
    });
  }
  /* Fun List Rumus */

  /* Tambah Baris Rumus (jika ada data) */
  function add_simplo_logsheet(id, satuan, metoda, urut) {
    var header = "";
    var body = "";
    var footer = "";
    var footer_adbk = "";
    var jumlah = urut;
    var logsheet_detail_id_detail = Date.now() * jumlah;

    $.getJSON('<?= base_url() ?>/master/perhitungan_sample/getDetailRumusSampleTemplate', {
      id_rumus: id
    }, function(json) {
      header += '<tr>';
      header += '<th>No</th>';

      body += '<tr class="tr" id="tr_' + id + '">';
      body += '<td>';
      body += jumlah;
      body += '</td>';

      footer += '<tr class="tr_foot_' + id + '" id="tr_foot_' + id + '_' + jumlah + '">';
      footer_adbk += '<tr class="tr_foot_adbk_' + id + '" id="tr_foot_adbk_' + id + '_' + jumlah + '">';

      $.each(json, function(index, val) {
        header += '<th>' + val.rumus_detail_nama + '</th>';
        body += '<td>';
        body += '<input type="text" id="rumus_detail_isi' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_isi[]" class="form-control" readonly>';
        body += '</td>';
      });

      header += '<th>Hasil</th>';
      header += '</tr>';

      body += '<td>';
      body += '<input type="text" class="form-control hasil_' + id + '" id="hasil_' + id + '_' + jumlah + '" name="hasil_' + id + '[' + jumlah + ']" readonly>';
      body += '</td>';
      body += '</tr>';

      footer += '<td colspan="' + (json.length + 1) + '"><p>Rata-rata </p></td><td><input class="form-control" type="text" id="rata_' + id + '_' + jumlah + '" name="rata_rata[]" readonly></td>';
      footer += '</tr>';

      footer_adbk += '<td  style="display:none" colspan="' + (json.length + 1) + '"><p>Nilai ADBK </p></td><td style="display:none"><input style="display:none" class="form-control" placeholder="klik untuk nilai_adbk" type="text" id="nilai_adbk_' + id + '_' + jumlah + '" name="nilai_adbk[]" onclick="fun_nilai_adbk(`' + id + '`)" readonly></td>';
      footer_adbk += '</tr>';

      $('#header_' + id).html(header);
      $('#body_' + id).append(body);
      $('.tr_foot_' + id).hide();
      $('#footer_' + id).append(footer);
      $('#footer_' + id).append(footer_adbk);

      $.getJSON('<?= base_url() ?>/master/perhitungan_sample/getPerhitunganSample', {
        rumus_id: id
      }, function(json) {
        if (json.is_adbk == 'y') {
          $('.tr_foot_adbk_' + id).hide();
          $('#footer_' + id).append(footer_adbk);
        }
      });
    });
  }
  /* Tambah Baris Rumus (jika ada data) */

  /* Fun ADBK */
  function fun_nilai_adbk(id) {
    var jumlah = $('tbody #tr_' + id).length;
    var rata = $('#rata_' + id).val();
    var rata_pembanding = $('#rata_33e69e61484d80e34599b5d16c2a0e1255fce468').val();

    var nilai_adbk = rata / (parseFloat('1') - rata_pembanding / parseFloat('100'));

    $('#nilai_adbk_' + id + '_' + jumlah).val(nilai_adbk);
    $('#nilai_adbk_' + id).val(nilai_adbk);
  }
  /* Fun ADBK */

  /* Draft */
  $('#draft').on('click', function() {
    var data = new FormData($('#form_logsheet')[0]);
    url = '<?= base_url('sample/inbox/insertDraftLogSheet') ?>';
    $.ajax({
      type: "POST",
      url: url,
      data: data,
      dataType: 'HTML',
      processData: false,
      contentType: false,
      cache: false,
      success: function(response) {
        location.href = '<?= base_url('sample/inbox/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>';
      }
    });
  })
  /* Draft */

  /* Reupload */
  $('#reupload').on('click', function() {
    Swal.fire({
      title: "Upload Ulang?",
      text: "Apakah Anda Yakin Akan Mereset Data Logsheet dan Mengupload Ulang Excel",
      type: "question",
      showCancelButton: true,
      confirmButtonColor: "#34c38f",
      cancelButtonColor: "#f46a6a",
      confirmButtonText: "Iya",
      cancelButtonText: "Tidak",
    }).then(function(result) {
      if (result.value) {
        var data = new FormData();
        data.append('transaksi_id', $('#transaksi_id').val());
        data.append('transaksi_detail_id', $('#transaksi_detail_id').val());
        data.append('transaksi_detail_id_temp', $('#transaksi_detail_id_temp').val());
        data.append('transaksi_non_rutin_id', $('#transaksi_non_rutin_id').val());
        data.append('transaksi_tipe', $('#transaksi_tipe').val());
        data.append('transaksi_reset_logsheet_alasan', 'Upload Ulang Excel');

        var url = '<?= base_url() ?>sample/inbox/insertReset';

        $.ajax({
          type: "POST",
          url: url,
          data: data,
          dataType: "HTML",
          contentType: false,
          processData: false,
          Cache: false,
          success: function(response) {
            location.href = '<?= base_url('sample/inbox/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>'
          }
        });
      }
    });
  })
  /* Reupload */

  /* Upload */
  $('#simpan').on('click', function() {
    Swal.fire({
      title: "Olah Data?",
      text: "Apakah Anda Yakin Akan Mengolah Data",
      type: "question",
      showCancelButton: true,
      confirmButtonColor: "#34c38f",
      cancelButtonColor: "#f46a6a",
      confirmButtonText: "Iya",
      cancelButtonText: "Tidak",
    }).then(function(result) {
      if (result.value) {
        var data = new FormData();
        data.append('transaksi_id', $('#transaksi_id').val());
        data.append('transaksi_detail_id', $('#transaksi_detail_id').val());
        data.append('transaksi_detail_id_temp', $('#transaksi_detail_id_temp').val());
        data.append('transaksi_non_rutin_id', $('#transaksi_non_rutin_id').val());
        data.append('transaksi_tipe', $('#transaksi_tipe').val());
        data.append('template_logsheet_id', $('#template_logsheet_id').val());
        data.append('logsheet_id', $('#logsheet_id').val());
        data.append('header_menu', '<?= $this->input->get('header_menu') ?>');
        data.append('menu_id', '<?= $this->input->get('menu_id') ?>');
        data.append('logsheet_tgl_sampling', $('#logsheet_tgl_sampling').val());
        data.append('logsheet_tgl_terima', $('#logsheet_tgl_terima').val());
        data.append('logsheet_tgl_uji', $('#logsheet_tgl_uji').val());
        data.append('logsheet_asal_sample', $('#logsheet_asal_sample').val());
        data.append('logsheet_pengolah_sample', $('#logsheet_pengolah_sample_list').val());
        data.append('logsheet_deskripsi', $('#log_deskripsi').val());

        var url = '<?= base_url('sample/inbox/insertOlahLogSheet') ?>';

        $.ajax({
          type: "POST",
          url: url,
          data: data,
          dataType: "HTML",
          contentType: false,
          processData: false,
          Cache: false,
          success: function(response) {
            location.href = response;
          }
        });
      }
    });
  })
  /* Upload */
</script>