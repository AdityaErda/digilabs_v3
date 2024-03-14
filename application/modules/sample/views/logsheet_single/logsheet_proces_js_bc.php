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
        // html += '<br/><p style="color:red;">* Klik Kolom Hasil Untuk Menghitung</p>';
        html += '<button type="button" id="adbk_' + val.rumus_id + '" name="adbk[]" class="btn btn-info btn-custom float-right" style="display:none" onclick="fun_adbk(`' + val.rumus_id + '`)">ADBK</button>';
        html += '</div>';
        html += '<div class="form-group col-12 row">';
        html += '<input type="text" name="rumus_id[]" id="rumus_id_' + id + '" value="' + val.rumus_id + '" style="display:none">';
        html += '<input type="text" name="rumus_nama[]" id="rumus_nama_' + id + '" value="' + val.rumus_nama + '" style="display:none">';
        html += '<table id="' + val.rumus_id + '" class="table table-bordered table-striped datatables" width="100%">';
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
      body += '<td>';
      body += '<input type="text" name="logsheet_detail_urut[]" id="logsheet_detail_urut_' + id + '" value="1" style="display:none">1';
      body += '<input type="text" value="1" name="logsheet_detail_urut_baris[]" id="logsheet_detail_urut_baris_' + id + '" style="display:none"><input type="text" id="logsheet_rumus_id_' + id + '" value="' + id + '" name="logsheet_rumus_id[]" style="display:none">';
      body += '<input type="text" name="logsheet_detail_id[]" style="display:none" id="logsheet_detail_id_' + id + '" value="' + (logsheet_detail_id) + '">';
      body += '</td>';

      footer += '<tr class="tr_foot_' + id + '" id="tr_foot_' + id + '" style="display:none">'
      footer_adbk += '<tr class="tr_foot_adbk_' + id + '" id="tr_foot_adbk_' + id + '" style="display:none">'

      $.each(json, function(index, val) {
        header += '<th>' + val.rumus_detail_nama + '</th>';

        // if (val.rumus_detail_input != null) {
        //   body += '<td>';
        //   body += '<input type="text" style="display:none" name="logsheet_rumus_id_detail[]" id="logsheet_rumus_id_detail_' + id + '" value="' + id + '">';
        //   body += '<input type="text" name="logsheet_detail_id_detail[]" style="display:none" id="logsheet_detail_id_detail_' + id + '" value="' + (logsheet_detail_id) + '">';
        //   body += '<input type="text" style="display:none" id="logsheet_detail_detail_id_' + val.rumus_detail_id + '" name="logsheet_detail_detail_id[]" value="' + (new Date().getMilliseconds() * 3600) + '_' + val.rumus_detail_urut + '">';
        //   body += '<input type="text" id="rumus_detail_id_' + val.rumus_detail_id + '" name="rumus_detail_id[]" value="' + val.rumus_detail_id + '" class="form-control" style="display:none">';
        //   body += '<input type="text" id="rumus_detail_nama_' + val.rumus_detail_id + '" name="rumus_detail_nama[]" value="' + val.rumus_detail_nama + '" class="form-control" style="display:none">';
        //   body += '<input type="text" id="rumus_detail_isi_' + val.rumus_detail_id + '" name="rumus_detail_isi[]" class="form-control" value="' + val.rumus_detail_input + '" readonly>';
        //   body += '<input type="text" id="rumus_detail_urut_' + val.rumus_detail_id + '" name="rumus_detail_urut[]" value="' + val.rumus_detail_urut + '" style="display:none">';
        //   body += '<input type="text" id="rumus_detail_template_' + val.rumus_detail_id + '" name="rumus_detail_template[]" value="' + val.rumus_detail_template + '" style="display:none">';
        //   body += '<input type="text" id="rumus_detail_jenis_' + val.rumus_detail_id + '" name="rumus_detail_jenis[]" value="' + val.rumus_jenis + '" style="display:none">';
        //   body += '</td>';
        // } else {
        body += '<td>';
        body += '<input type="text" style="display:none" name="logsheet_rumus_id_detail[]" id="logsheet_rumus_id_detail_' + id + '" value="' + id + '" readonly>';
        body += '<input type="text" name="logsheet_detail_id_detail[]" style="display:none" id="logsheet_detail_id_detail_' + id + '" value="' + (logsheet_detail_id) + '">';
        body += '<input type="text" style="display:none" id="logsheet_detail_detail_id_' + val.rumus_detail_id + '" name="logsheet_detail_detail_id[]" value="' + (new Date().getMilliseconds() * 3600) + '_' + val.rumus_detail_urut + '">';
        body += '<input type="text" id="rumus_detail_id' + val.rumus_detail_id + '" name="rumus_detail_id[]" value="' + val.rumus_detail_id + '" class="form-control" style="display:none">';
        body += '<input type="text" id="rumus_detail_nama' + val.rumus_detail_nama + '" name="rumus_detail_nama[]" value="' + val.rumus_detail_nama + '" class="form-control" style="display:none">';
        body += '<input type="number" id="rumus_detail_isi' + val.rumus_detail_id + '" name="rumus_detail_isi[]" class="form-control" readonly>';
        body += '<input type="text" id="rumus_detail_urut_' + val.rumus_detail_id + '" name="rumus_detail_urut[]" value="' + val.rumus_detail_urut + '" style="display:none">';
        body += '<input type="text" id="rumus_detail_template_' + val.rumus_detail_id + '" name="rumus_detail_template[]" value="' + val.rumus_detail_template + '" style="display:none">';
        body += '<input type="text" id="rumus_detail_jenis_' + val.rumus_detail_id + '" name="rumus_detail_jenis[]" value="' + val.rumus_jenis + '" style="display:none">';
        body += '</td>';
        // }
      });

      header += '<th>Metoda</th>';
      header += '<th>Satuan</th>';
      header += '<th>Hasil</th>';
      // header += '<th>Aksi</th>';
      header += '</tr>';

      body += '<td><input type="text" id="rumus_metoda_' + id + '" name="rumus_metoda[]" value="' + metoda + '" class="form-control rumus_metoda" readonly></td>';
      body += '<td><input type="text" id="rumus_satuan_' + id + '" name="rumus_satuan[]" value="' + satuan + '" class="form-control rumus_satuan" readonly></td>';
      body += '<td>';
      body += '<input type="text" class="form-control hasil_' + id + '" id="hasil_' + id + '" name="hasil_' + id + '[1]" readonly onclick="fun_hitung(`' + id + '`);fun_store_history(`' + id + '`)" readonly placeholder="klik u/ hasil">';
      body += '<input type="text" class="form-control" id="rumus_detail_hasil_' + id + '" name="rumus_detail_hasil[]" style="display:none">';
      body += '</td>';
      // body += '<td width="20px">';
      // body += '<a href="javascript:void(0);" id="' + id + '" onclick="add_simplo(this.id,`' + satuan + '`,`' + metoda + '`)"><i class="fa fa-plus" style="color:green"></i></a><br>';
      // body += '</td>';
      body += '</tr>';

      footer += '<td colspan="' + (json.length + 3) + '"><p>Rata-rata </p></td><td><input class="form-control" placeholder="klik untuk rata-rata" type="text" id="rata_' + id + '" name="rata_rata[]" onclick="fun_average(`' + id + '`)" readonly style="display:none"></td>';
      footer += '</tr>';

      footer_adbk += '<td colspan="' + (json.length + 3) + '"><p>Rata-rata </p></td><td><input class="form-control" placeholder="klik untuk nilai adbk" type="text" id="nilai_adbk_' + id + '" name="nilai_adbk[]" onclick="fun_nilai_adbk(`' + id + '`)" readonly style="display:none"></td>';
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

  /* Tambah Baris Rumus */
  function add_simplo(id, satuan, metoda) {
    var header = "";
    var body = "";
    var footer = "";
    var footer_adbk = "";
    var jumlah = $('tbody #tr_' + id).length + 1;
    var logsheet_detail_id_detail = Date.now() * jumlah;

    $.getJSON('<?= base_url() ?>/master/perhitungan_sample/getDetailRumusSampleTemplate', {
      id_rumus: id
    }, function(json) {
      header += '<tr>';
      header += '<th>No</th>';

      body += '<tr class="tr" id="tr_' + id + '">';
      body += '<td>';
      body += '<input type="text" name="logsheet_detail_urut[]" id="logsheet_detail_urut_' + id + '_' + jumlah + '" value="' + jumlah + '" style="display:none">' + jumlah;
      body += '<input type="text" value="' + jumlah + '" name="logsheet_detail_urut_baris[]" id="logsheet_detail_urut_baris_' + id + '_' + jumlah + '" style="display:none">';
      body += '<input type="text" id="logsheet_rumus_id_' + id + '_' + jumlah + '" value="' + id + '" name="logsheet_rumus_id[]" style="display:none"><input type="text" name="logsheet_detail_id[]" style="display:none" id="logsheet_detail_id_' + id + '_' + jumlah + '" value="' + (logsheet_detail_id_detail) + '">';
      body += '</td>';

      footer += '<tr class="tr_foot_' + id + '" id="tr_foot_' + id + '_' + jumlah + '">';
      footer_adbk += '<tr class="tr_foot_adbk_' + id + '" id="tr_foot_adbk_' + id + '_' + jumlah + '">';

      $.each(json, function(index, val) {
        header += '<th>' + val.rumus_detail_nama + '</th>';

        // if (val.rumus_detail_input != null) {
        //   body += '<td>';
        //   body += '<input type="text" style="display:none" name="logsheet_rumus_id_detail[]" id="logsheet_rumus_id_detail_' + id + '_' + jumlah + '" value="' + id + '">';
        //   body += '<input type="text" name="logsheet_detail_id_detail[]" style="display:none" id="logsheet_detail_id_detail_' + id + '_' + jumlah + '" value="' + (logsheet_detail_id_detail) + '">';
        //   body += '<input type="text" style="display:none" id="logsheet_detail_detail_id_' + val.rumus_detail_id + '_' + jumlah + '" name="logsheet_detail_detail_id[]" value="' + (new Date().getMilliseconds() * 3600 * jumlah) + '_' + val.rumus_detail_urut + '">';
        //   body += '<input type="text" id="rumus_detail_id_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_id[]" value="' + val.rumus_detail_id + '" class="form-control" style="display:none">';
        //   body += '<input type="text" id="rumus_detail_nama_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_nama[]" value="' + val.rumus_detail_nama + '" class="form-control" style="display:none">';
        //   body += '<input type="text" id="rumus_detail_isi_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_isi[]" class="form-control" value="' + val.rumus_detail_input + '" readonly>';
        //   body += '<input type="text" id="rumus_detail_urut_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_urut[]" value="' + val.rumus_detail_urut + '" style="display:none">';
        //   body += '<input type="text" id="rumus_detail_template_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_template[]" value="' + val.rumus_detail_template + '" style="display:none">';
        //   body += '<input type="text" id="rumus_detail_jenis_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_jenis[]" value="' + val.rumus_jenis + '" style="display:none">';
        //   body += '</td>';
        // } else {
        body += '<td>';
        body += '<input type="text" style="display:none" name="logsheet_rumus_id_detail[]" id="logsheet_rumus_id_detail_' + id + '_' + jumlah + '" value="' + id + '">';
        body += '<input type="text" name="logsheet_detail_id_detail[]" style="display:none" id="logsheet_detail_id_detail_' + id + '_' + jumlah + '" value="' + (logsheet_detail_id_detail) + '">';
        body += '<input type="text" style="display:none" id="logsheet_detail_detail_id_' + val.rumus_detail_id + '_' + jumlah + '" name="logsheet_detail_detail_id[]" value="' + (new Date().getMilliseconds() * 3600 * jumlah) + '_' + val.rumus_detail_urut + '">';
        body += '<input type="text" id="rumus_detail_id' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_id[]" value="' + val.rumus_detail_id + '" class="form-control" style="display:none">';
        body += '<input type="text" id="rumus_detail_nama' + val.rumus_detail_nama + '_' + jumlah + '" name="rumus_detail_nama[]" value="' + val.rumus_detail_nama + '" class="form-control" style="display:none">';
        body += '<input type="number" id="rumus_detail_isi' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_isi[]" class="form-control" readonly>';
        body += '<input type="text" id="rumus_detail_urut_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_urut[]" value="' + val.rumus_detail_urut + '" style="display:none">';
        body += '<input type="text" id="rumus_detail_template_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_template[]" value="' + val.rumus_detail_template + '" style="display:none">';
        body += '<input type="text" id="rumus_detail_jenis_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_jenis[]" value="' + val.rumus_jenis + '" style="display:none">';
        body += '</td>';
        // }
      });

      header += '<th>Metoda</th>';
      header += '<th>Satuan</th>';
      header += '<th>Hasil</th>';
      // header += '<th>Aksi</th>';
      header += '</tr>';

      body += '<td><input type="text" id="rumus_metoda_' + id + '_' + jumlah + '" name="rumus_metoda[]" value="' + metoda + '" class="form-control rumus_metoda" readonly></td>';
      body += '<td><input type="text" id="rumus_satuan_' + id + '_' + jumlah + '" name="rumus_satuan[]" value="' + satuan + '" class="form-control rumus_satuan" readonly></td>';
      body += '<td>';
      body += '<input type="text" class="form-control hasil_' + id + '" id="hasil_' + id + '_' + jumlah + '" name="hasil_' + id + '[' + jumlah + ']" readonly placeholder="klik u/ hasil">';
      body += '<input type="text" class="form-control" id="rumus_detail_hasil_' + id + '_' + jumlah + '" name="rumus_detail_hasil[]" style="display:none">';
      body += '</td>';
      // body += '<td>';
      // body += '<a href="javascript:void(0);" id="' + id + '" onclick="add_simplo(this.id,`' + satuan + '`,`' + metoda + '`)"><i class="fa fa-plus" style="color:green"></i></a><br>';
      // body += '<a href="javascript:void(0);" id="remove_simplo" ><i class="fa fa-minus" style="color:red"></i></a>';
      // body += '</td>';
      body += '</tr>';

      footer += '<td colspan="' + (json.length + 3) + '"><p>Rata-rata </p></td><td><input class="form-control" placeholder="klik untuk rata-rata" type="text" id="rata_' + id + '_' + jumlah + '" name="rata_rata[]" onclick="fun_average(`' + id + '`)" readonly></td>';
      footer += '</tr>';

      footer_adbk += '<td  style="display:none" colspan="' + (json.length + 3) + '"><p>Nilai ADBK </p></td><td style="display:none"><input style="display:none" class="form-control" placeholder="klik untuk nilai_adbk" type="text" id="nilai_adbk_' + id + '_' + jumlah + '" name="nilai_adbk[]" onclick="fun_nilai_adbk(`' + id + '`)" readonly></td>';
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

    $(document).on('click', '#hasil_' + id + '_' + jumlah, function() {
      $.getJSON('<?= base_url() ?>/master/perhitungan_sample/getDetailRumusSample', {
        id_rumus: id
      }, function(json) {
        var rumus = '';
        $.each(json, function(index, val) {
          if (val.rumus_jenis == 'I') rumus += '(' + $('#rumus_detail_isi' + val.rumus_detail_id + '_' + jumlah).val() + ')';
          else rumus += val.rumus_detail_input;
        });

        var hasil = math.evaluate(rumus);
        $('#hasil_' + id + '_' + jumlah).val(hasil.toFixed(2));
        $('#rumus_detail_hasil_' + id + '_' + jumlah).val(hasil.toFixed(2));
      });
    });
  }
  /* Tambah Baris Rumus */


  /* Tambah Baris Rumus (jika ada data) */
  function add_simplo_logsheet(id, satuan, metoda, urut) {
    var header = "";
    var body = "";
    var footer = "";
    var footer_adbk = "";
    // var jumlah = $('tbody #tr_' + id).length + 1;
    var jumlah = urut;
    var logsheet_detail_id_detail = Date.now() * jumlah;

    $.getJSON('<?= base_url() ?>/master/perhitungan_sample/getDetailRumusSampleTemplate', {
      id_rumus: id
    }, function(json) {
      header += '<tr>';
      header += '<th>No</th>';

      body += '<tr class="tr" id="tr_' + id + '">';
      body += '<td>';
      body += '<input type="text" name="logsheet_detail_urut[]" id="logsheet_detail_urut_' + id + '_' + jumlah + '" value="' + jumlah + '" style="display:none">' + jumlah;
      body += '<input type="text" value="' + jumlah + '" name="logsheet_detail_urut_baris[]" id="logsheet_detail_urut_baris_' + id + '_' + jumlah + '" style="display:none">';
      body += '<input type="text" id="logsheet_rumus_id_' + id + '_' + jumlah + '" value="' + id + '" name="logsheet_rumus_id[]" style="display:none"><input type="text" name="logsheet_detail_id[]" style="display:none" id="logsheet_detail_id_' + id + '_' + jumlah + '" value="' + (logsheet_detail_id_detail) + '">';
      body += '</td>';

      footer += '<tr class="tr_foot_' + id + '" id="tr_foot_' + id + '_' + jumlah + '">';
      footer_adbk += '<tr class="tr_foot_adbk_' + id + '" id="tr_foot_adbk_' + id + '_' + jumlah + '">';

      $.each(json, function(index, val) {
        header += '<th>' + val.rumus_detail_nama + '</th>';

        // if (val.rumus_detail_input != null) {
        //   body += '<td>';
        //   body += '<input type="text" style="display:none" name="logsheet_rumus_id_detail[]" id="logsheet_rumus_id_detail_' + id + '_' + jumlah + '" value="' + id + '">';
        //   body += '<input type="text" name="logsheet_detail_id_detail[]" style="display:none" id="logsheet_detail_id_detail_' + id + '_' + jumlah + '" value="' + (logsheet_detail_id_detail) + '">';
        //   body += '<input type="text" style="display:none" id="logsheet_detail_detail_id_' + val.rumus_detail_id + '_' + jumlah + '" name="logsheet_detail_detail_id[]" value="' + (new Date().getMilliseconds() * 3600 * jumlah) + '_' + val.rumus_detail_urut + '">';
        //   body += '<input type="text" id="rumus_detail_id_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_id[]" value="' + val.rumus_detail_id + '" class="form-control" style="display:none">';
        //   body += '<input type="text" id="rumus_detail_nama_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_nama[]" value="' + val.rumus_detail_nama + '" class="form-control" style="display:none">';
        //   body += '<input type="text" id="rumus_detail_isi_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_isi[]" class="form-control" value="' + val.rumus_detail_input + '" readonly>';
        //   body += '<input type="text" id="rumus_detail_urut_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_urut[]" value="' + val.rumus_detail_urut + '" style="display:none">';
        //   body += '<input type="text" id="rumus_detail_template_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_template[]" value="' + val.rumus_detail_template + '" style="display:none">';
        //   body += '<input type="text" id="rumus_detail_jenis_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_jenis[]" value="' + val.rumus_jenis + '" style="display:none">';
        //   body += '</td>';
        // } else {
        body += '<td>';
        body += '<input type="text" style="display:none" name="logsheet_rumus_id_detail[]" id="logsheet_rumus_id_detail_' + id + '_' + jumlah + '" value="' + id + '">';
        body += '<input type="text" name="logsheet_detail_id_detail[]" style="display:none" id="logsheet_detail_id_detail_' + id + '_' + jumlah + '" value="' + (logsheet_detail_id_detail) + '">';
        body += '<input type="text" style="display:none" id="logsheet_detail_detail_id_' + val.rumus_detail_id + '_' + jumlah + '" name="logsheet_detail_detail_id[]" value="' + (new Date().getMilliseconds() * 3600 * jumlah) + '_' + val.rumus_detail_urut + '">';
        body += '<input type="text" id="rumus_detail_id' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_id[]" value="' + val.rumus_detail_id + '" class="form-control" style="display:none">';
        body += '<input type="text" id="rumus_detail_nama' + val.rumus_detail_nama + '_' + jumlah + '" name="rumus_detail_nama[]" value="' + val.rumus_detail_nama + '" class="form-control" style="display:none">';
        body += '<input type="number" id="rumus_detail_isi' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_isi[]" class="form-control" readonly>';
        body += '<input type="text" id="rumus_detail_urut_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_urut[]" value="' + val.rumus_detail_urut + '" style="display:none">';
        body += '<input type="text" id="rumus_detail_template_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_template[]" value="' + val.rumus_detail_template + '" style="display:none">';
        body += '<input type="text" id="rumus_detail_jenis_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_jenis[]" value="' + val.rumus_jenis + '" style="display:none">';
        body += '</td>';
        // }
      });

      header += '<th>Metoda</th>';
      header += '<th>Satuan</th>';
      header += '<th>Hasil</th>';
      // header += '<th>Aksi</th>';
      header += '</tr>';

      body += '<td><input type="text" id="rumus_metoda_' + id + '_' + jumlah + '" name="rumus_metoda[]" value="' + metoda + '" class="form-control rumus_metoda" readonly></td>';
      body += '<td><input type="text" id="rumus_satuan_' + id + '_' + jumlah + '" name="rumus_satuan[]" value="' + satuan + '" class="form-control rumus_satuan" readonly></td>';
      body += '<td>';
      body += '<input type="text" class="form-control hasil_' + id + '" id="hasil_' + id + '_' + jumlah + '" name="hasil_' + id + '[' + jumlah + ']" readonly placeholder="klik u/ hasil">';
      body += '<input type="text" class="form-control" id="rumus_detail_hasil_' + id + '_' + jumlah + '" name="rumus_detail_hasil[]" style="display:none">';
      body += '</td>';
      // body += '<td>';
      // body += '<a href="javascript:void(0);" id="' + id + '" onclick="add_simplo(this.id,`' + satuan + '`,`' + metoda + '`)"><i class="fa fa-plus" style="color:green"></i></a><br>';
      // body += '<a href="javascript:void(0);" id="remove_simplo" ><i class="fa fa-minus" style="color:red"></i></a>';
      // body += '</td>';
      body += '</tr>';

      footer += '<td colspan="' + (json.length + 3) + '"><p>Rata-rata </p></td><td><input class="form-control" placeholder="klik untuk rata-rata" type="text" id="rata_' + id + '_' + jumlah + '" name="rata_rata[]" onclick="fun_average(`' + id + '`)" readonly></td>';
      footer += '</tr>';

      footer_adbk += '<td  style="display:none" colspan="' + (json.length + 3) + '"><p>Nilai ADBK </p></td><td style="display:none"><input style="display:none" class="form-control" placeholder="klik untuk nilai_adbk" type="text" id="nilai_adbk_' + id + '_' + jumlah + '" name="nilai_adbk[]" onclick="fun_nilai_adbk(`' + id + '`)" readonly></td>';
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

    $(document).on('click', '#hasil_' + id + '_' + jumlah, function() {
      $.getJSON('<?= base_url() ?>/master/perhitungan_sample/getDetailRumusSample', {
        id_rumus: id
      }, function(json) {
        var rumus = '';
        $.each(json, function(index, val) {
          if (val.rumus_jenis == 'I') rumus += '(' + $('#rumus_detail_isi' + val.rumus_detail_id + '_' + jumlah).val() + ')';
          else rumus += val.rumus_detail_input;
        });

        var hasil = math.evaluate(rumus);
        $('#hasil_' + id + '_' + jumlah).val(hasil.toFixed(2));
        $('#rumus_detail_hasil_' + id + '_' + jumlah).val(hasil.toFixed(2));
      });
    });
  }
  /* Tambah Baris Rumus (jika ada data) */

  /* Hapus Baris Rumus */
  $(document).on('click', '#remove_simplo', function() {
    $(this).parents("tr").remove();
  });
  /* Hapus Baris Rumus */

  /* Fun Hitung */
  function fun_hitung(id) {
    $.getJSON('<?= base_url() ?>/master/perhitungan_sample/getDetailRumusSample', {
      id_rumus: id
    }, function(json) {
      var rumus = '';
      $.each(json, function(index, val) {
        if (val.rumus_jenis == 'I') rumus += '(' + $('#rumus_detail_isi' + val.rumus_detail_id).val() + ')';
        else if (val.rumus_jenis == 'A') rumus += '(' + val.rumus_detail_input + ')';
        else rumus += val.rumus_detail_input;
      });

      var hasil = (math.evaluate(rumus));
      $('#hasil_' + id).val(hasil.toFixed(2));
      $('#rumus_detail_hasil_' + id).val(hasil.toFixed(2));
    });
  }
  /* Fun Hitung */

  /* Fun Log History */
  function fun_store_history(id) {
    $.getJSON('<?= base_url() ?>/master/perhitungan_sample/getDetailRumusSample', {
      id_rumus: id
    }, function(json) {
      var rumus = '';
      var rumus_detail_nama = '';

      $.each(json, function(index, val) {
        if (val.rumus_jenis == 'I') rumus += '(' + $('#rumus_detail_isi' + val.rumus_detail_id).val() + ')';
        else if (val.rumus_jenis == 'A') rumus += '(' + val.rumus_detail_input + ')';
        else rumus += val.rumus_detail_input;

        if (val.rumus_jenis == 'O') rumus_detail_nama += val.rumus_detail_input;
        else rumus_detail_nama += val.rumus_detail_nama;
      });

      var hasil = (math.evaluate(rumus));
      var url = '<?= base_url('sample/inbox/storeLogsheetHistory') ?>';
      var data = new FormData($('#form_logsheet')[0]);
      data.append('logsheet_rumus_nama', rumus_detail_nama)
      data.append('logsheet_rumus', rumus);
      data.append('logsheet_hasil', hasil);

      $.ajax({
        url: url,
        type: 'POST',
        dataType: 'HTML',
        data: data,
        processData: false,
        contentType: false,
        cache: false,
      });
    });
  }
  /* Fun Log History */

  /* Fun Rata-rata */
  function fun_average(id) {
    var header = "";
    var body = "";
    var footer = "";
    var jumlah = $('tbody #tr_' + id).length;

    $.getJSON('<?= base_url() ?>/master/perhitungan_sample/getDetailRumusSample', {
      id_rumus: id
    }, function(json) {
      var hasil = 0;

      $(".hasil_" + id).each(function() {
        hasil += parseFloat($(this).val());
      });

      var total = hasil;
      var rata = (hasil / jumlah);

      $('#rata_' + id + '_' + jumlah).val(rata.toFixed(2));
      $('#rata_' + id).val(rata.toFixed(2));
    });
  }
  /* Fun Rata-rata */

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

  /* Olah Data */
  // $('#simpan').on('click', function() {
  //   var data = new FormData($('#form_logsheet')[0]);
  //   url = '<?= base_url('sample/inbox/insertDraftLogSheet') ?>';
  //   $.ajax({
  //     type: "POST",
  //     url: url,
  //     data: data,
  //     dataType: 'HTML',
  //     processData: false,
  //     contentType: false,
  //     cache: false,
  //     success: function(response) {
  //       location.href = '<?= base_url('sample/inbox/draftLogSheet/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) . '&transaksi_id=' . $_GET['transaksi_id'] . '&transaksi_detail_id=' ?>' + $('#transaksi_detail_id').val() + '&transaksi_detail_status=' + '<?= $_GET['transaksi_detail_status'] + 1 . '&template_logsheet_id=' ?>' + $('#template_logsheet_id').val() + '&logsheet_id=' + $('#logsheet_id').val();
  //     }
  //   });
  // })
  /* Olah Data */

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
  /* Reupload */
</script>