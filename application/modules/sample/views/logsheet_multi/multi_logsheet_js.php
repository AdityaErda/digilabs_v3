<script>
  $(function() {
    $('.table_rumus').dataTable({
      // "initComplete": function(settings, json) {
      // $("#table_rumus").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
      // },
      "scrollX": true,
      "ordering": false,
      "paging": false,
      "searching": false,
      // bAutoWidth: false,
      // "info": false,
      // "responsive": true
      fixedColumns: {
        leftColumns: 4,
      },

      initComplete: function() {
        $('.dataTables_scrollHead').on('scroll', function() {
          $('.dataTables_scrollBody').scrollLeft($(this).scrollLeft());
        });
      },

    });

    $('.table_rumus_isi').dataTable({
      // "initComplete": function(settings, json) {
      // $("#table_rumus").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
      // },
      "scrollX": false,
      "ordering": false,
      "paging": false,
      "searching": false,
      "info": false,
      "responsive": false,
      bSort: false,
      order: 1
    });

    // add log colume
    // render detail log column
    $(".tanggal").daterangepicker({
      showDropdowns: true,
      singleDatePicker: true,
      locale: {
        format: 'DD-MM-YYYY'
      },
    });

    $(".waktu").daterangepicker({
      showDropdowns: true,
      singleDatePicker: true,
      timePicker: true,
      timePicker24Hour: true,
      timePickerSeconds: true,
      locale: {
        format: 'HH:mm:ss'
      },
    });

    $('#logsheet_pengolah_sample').select2({
      placeholder: 'Pilih',
    })

    $('#rumus').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('sample/inbox/getRumusList') ?>',
        dataType: 'json',
        type: 'GET',
        data: function(params) {
          var queryParameters = {
            param_search: params.term
          }

          return queryParameters;
        }
      }
    })


    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');


    // proses
    $('#simpan').on('click', function() {
      Swal.fire({
        title: "Olah Data",
        text: "Apakah Anda Yakin Akan Olah Data ?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#34c38f",
        cancelButtonColor: "#f46a6a",
        confirmButtonText: "Iya",
        cancelButtonText: "Tidak",
      }).then(function(result) {
        if (result.value) {
          var data = new FormData($('#form_logsheet')[0]);
          url = '<?= base_url('sample/multi_sample/insertOlahLogSheet') ?>';
          $.ajax({
            type: "POST",
            url: url,
            data: data,
            dataType: 'HTML',
            processData: false,
            contentType: false,
            cache: false,
            success: function(response) {
              window.location.replace(response);
            }
          });
        }
      })
    })
  })

  /* Draft */
  $('#draft').on('click', function() {
    var data = new FormData($('#form_logsheet')[0]);
    url = '<?= base_url('sample/multi_sample/insertDraft') ?>';
    $.ajax({
      type: "POST",
      url: url,
      data: data,
      dataType: 'HTML',
      processData: false,
      contentType: false,
      cache: false,
      success: function(response) {
        location.href = '<?= base_url('sample/multi_sample/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>';
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
        data.append('transaksi_non_rutin_id', $('#transaksi_non_rutin_id').val());
        data.append('transaksi_tipe', $('#transaksi_tipe').val());
        data.append('logsheet_multiple_id', $('#logsheet_multiple_id').val());
        data.append('transaksi_reset_logsheet_alasan', 'Upload Ulang Excel');

        var url = '<?= base_url() ?>sample/multi_sample/insertReset';

        $.ajax({
          type: "POST",
          url: url,
          data: data,
          dataType: "HTML",
          contentType: false,
          processData: false,
          Cache: false,
          success: function(response) {
            location.href = '<?= base_url('sample/multi_sample/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>'
          }
        });
      }
    });
  })
  /* Reupload */

  window.onload = fun_rumus('<?= $_GET['template_logsheet_id'] ?>');

  function fun_rumus(id) {
    var html = "";
    $.getJSON('<?= base_url() ?>/master/template_logsheet/getDetailLogsheet', {
      id_logsheet_template: id
    }, function(json) {
      html += '<div class="row">';
      $.each(json, function(index, val) {
        html += '<div class="card-header col-12">';
        html += '<h3 class="card-title">' + val.rumus_nama + ' = <b id="list_' + val.rumus_id + '"></b></h3>';
        html += '<br/><p style="color:red;">* Klik Kolom Hasil Untuk Menghitung</p>';
        html += '<button type="button" id="adbk_' + val.rumus_id + '" name="adbk[]" class="btn btn-info btn-custom float-right" style="display:none" onclick="fun_adbk(`' + val.rumus_id + '`)">ADBK</button>';
        html += '</div>';
        html += '<div class="form-group col-12 row">';
        html += '<input type="text" name="rumus_id[]" id="rumus_id_' + id + '" value="' + val.rumus_id + '" style="display:none">';
        html += '<input type="text" name="rumus_nama[]" id="rumus_nama_' + id + '" value="' + val.rumus_nama + '" style="display:none">';
        // html += ''
        html += '<table id="' + val.rumus_id + '" class="table table-bordered table-striped datatables" width="100%">';
        html += '<thead id="header_' + val.rumus_id + '"></thead>';
        html += '<tbody id="body_' + val.rumus_id + '"></tbody>';
        html += '<tfoot id="footer_' + val.rumus_id + '"></tfoot>'
        html += '</table>';
        html += '</div>';
        fun_detail_rumus(val.rumus_id);
        fun_list_rumus(val.rumus_id);
      });
      html += '</div>';

      $('#div_rumus').html(html);
    });
  }

  function fun_detail_rumus(id) {
    // var simplo = "";
    var header = "";
    var body = "";
    var footer = "";
    var footer_adbk = "";

    $.getJSON('<?= base_url() ?>/master/perhitungan_sample/getDetailRumusSampleTemplate', {
      id_rumus: id
    }, function(json) {
      header += '<tr>'
      header += '<th>No</th>'
      body += '<tr class="tr" id="tr_' + id + '"><td>'
      body += '<input type="text" name="logsheet_detail_urut[]" id="logsheet_detail_urut_' + id + '" value="1" style="display:none">'
      body += '1'
      body += '<input type="text" value="1" name="logsheet_detail_urut_baris[]" id="logsheet_detail_urut_baris_' + id + '" style="display:none">'
      body += '<input type="text" id="logsheet_rumus_id_' + id + '" value="' + id + '" name="logsheet_rumus_id[]" style="display:none">'
      body += '<input type="text" name="logsheet_detail_id[]" style="display:none" id="logsheet_detail_id_' + id + '" value="' + (Date.now()) + '"></td>';

      footer += '<tr class="tr_foot_' + id + '" id="tr_foot_' + id + '" style="display:none">'
      footer_adbk += '<tr class="tr_foot_adbk_' + id + '" id="tr_foot_adbk_' + id + '" style="display:none">'
      $.each(json, function(index, val) {
        header += '<th>' + val.rumus_detail_nama + '</th>'

        if (val.rumus_detail_input != null) {
          body += '<td>'
          body += '<input type="text" id="rumus_detail_isi_' + val.rumus_detail_id + '" name="rumus_detail_isi[]" class="form-control" value="' + val.rumus_detail_input + '" readonly>'
          body += '<input type="text" style="display:none" name="logsheet_rumus_id_detail[]" id="logsheet_rumus_id_detail_' + id + '" value="' + id + '">'
          body += '<input type="text" name="logsheet_detail_id_detail[]" style="display:none" id="logsheet_detail_id_detail_' + id + '" value="' + (Date.now()) + '">'
          body += '<input type="text" style="display:none" id="logsheet_detail_detail_id_' + val.rumus_detail_id + '" name="logsheet_detail_detail_id[]" value="' + (new Date().getMilliseconds() * 3600) + '_' + val.rumus_detail_urut + '">'
          body += '<input type="text" id="rumus_detail_id_' + val.rumus_detail_id + '" name="rumus_detail_id[]" value="' + val.rumus_detail_id + '" class="form-control" style="display:none">'
          body += '<input type="text" id="rumus_detail_nama_' + val.rumus_detail_id + '" name="rumus_detail_nama[]" value="' + val.rumus_detail_nama + '" class="form-control" style="display:none">'
          body += '<input type="text" id="rumus_detail_urut_' + val.rumus_detail_id + '" name="rumus_detail_urut[]" value="' + val.rumus_detail_urut + '" style="display:none">'
          body += '<input type="text" id="rumus_detail_template_' + val.rumus_detail_id + '" name="rumus_detail_template[]" value="' + val.rumus_detail_template + '" style="display:none">'
          body += '<input type="text" id="rumus_detail_jenis_' + val.rumus_detail_id + '" name="rumus_detail_jenis[]" value="' + val.rumus_jenis + '" style="display:none">'
          body += '</td>';
        } else {
          body += '<td>'
          body += '<input type="number" id="rumus_detail_isi' + val.rumus_detail_id + '" name="rumus_detail_isi[]" class="form-control">'
          body += '<input type="text" style="display:none" name="logsheet_rumus_id_detail[]" id="logsheet_rumus_id_detail_' + id + '" value="' + id + '">'
          body += '<input type="text" name="logsheet_detail_id_detail[]" style="display:none" id="logsheet_detail_id_detail_' + id + '" value="' + (Date.now()) + '">'
          body += '<input type="text" style="display:none" id="logsheet_detail_detail_id_' + val.rumus_detail_id + '" name="logsheet_detail_detail_id[]" value="' + (new Date().getMilliseconds() * 3600) + '_' + val.rumus_detail_urut + '">'
          body += '<input type="text" id="rumus_detail_id' + val.rumus_detail_id + '" name="rumus_detail_id[]" value="' + val.rumus_detail_id + '" class="form-control" style="display:none">'
          body += '<input type="text" id="rumus_detail_nama' + val.rumus_detail_nama + '" name="rumus_detail_nama[]" value="' + val.rumus_detail_nama + '" class="form-control" style="display:none">'
          body += '<input type="text" id="rumus_detail_urut_' + val.rumus_detail_id + '" name="rumus_detail_urut[]" value="' + val.rumus_detail_urut + '" style="display:none">'
          body += '<input type="text" id="rumus_detail_template_' + val.rumus_detail_id + '" name="rumus_detail_template[]" value="' + val.rumus_detail_template + '" style="display:none">'
          body += '<input type="text" id="rumus_detail_jenis_' + val.rumus_detail_id + '" name="rumus_detail_jenis[]" value="' + val.rumus_jenis + '" style="display:none">'
          body += '</td>';
        }
      });

      // body += '</form>';
      header += '<th>Hasil</th>'
      header += '<th>Aksi</th></tr>';
      body += '<td>'
      body += '<input type="text" class="form-control hasil_' + id + '" id="hasil_' + id + '" name="hasil_' + id + '[1]" readonly onclick="fun_hitung(`' + id + '`);fun_store_history(`' + id + '`)" readonly placeholder="klik u/ hasil">'
      body += '<input type="text" class="form-control" id="rumus_detail_hasil_' + id + '" name="rumus_detail_hasil[]" style="display:none">'
      body += '</td>'
      body += '<td width="20px">'
      body += '<a href="javascript:void(0);" id="' + id + '" onclick="add_simplo(this.id)"><i class="fa fa-plus" style="color:green"></i></a>'
      body += '<br>'
      body += '</td></tr>';
      footer += '<td colspan="' + (json.length + 1) + '"><p>Rata-rata </p></td>'
      footer += '<td><input class="form-control" placeholder="klik untuk rata-rata" type="text" id="rata_' + id + '" name="rata_rata[]" onclick="fun_average(`' + id + '`)" readonly style="display:none"></td></tr>';
      footer_adbk += '<td colspan="' + (json.length + 1) + '"><p>Rata-rata </p></td>'
      footer_adbk += '<td><input class="form-control" placeholder="klik untuk nilai adbk" type="text" id="nilai_adbk_' + id + '" name="nilai_adbk[]" onclick="fun_nilai_adbk(`' + id + '`)" readonly style="display:none"></td></tr>';

      $('#header_' + id).html(header);
      $('#body_' + id).append(body);
      $('#footer_' + id).append(footer);
      $('#footer_' + id).append(footer_adbk);
    });
  }
  // <input type="number" id="' + val.rumus_detail_id + '" name="' + val.rumus_detail_id + '[0]" class="form-control">\

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

  // function fun_hitung(id, key, key_template) {
  //   $.getJSON('<?= base_url() ?>/master/perhitungan_sample/getDetailRumusSample', {
  //     id_rumus: id
  //   }, function(json) {
  //     var rumus = '';
  //     $.each(json, function(index, val) {
  //       if (val.rumus_jenis == 'I') rumus += '(' + $('#rumus_detail_isi' + val.rumus_detail_id + '_' + key + '_' + key_template).val() + ')';
  //       else if (val.rumus_jenis == 'A') rumus += '(' + val.rumus_detail_input + ')';
  //       else rumus += val.rumus_detail_input;
  //     });
  //     console.log(rumus);
  //     var hasil = (math.evaluate(rumus));
  //     $('#hasil_' + id + '_' + key + '_' + key_template).val(hasil.toFixed(2));
  //     $('#rumus_detail_hasil_' + id + '_' + key + '_' + key_template).val(hasil.toFixed(2));

  //   });
  // }


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

  function fun_nilai_adbk(id) {
    var jumlah = $('tbody #tr_' + id).length;
    var rata = $('#rata_' + id).val();
    var rata_pembanding = $('#rata_33e69e61484d80e34599b5d16c2a0e1255fce468').val();

    var nilai_adbk = rata / (parseFloat('1') - rata_pembanding / parseFloat('100'));

    $('#nilai_adbk_' + id + '_' + jumlah).val(nilai_adbk);
    $('#nilai_adbk_' + id).val(nilai_adbk);
  }


  function fun_store_history(id) {
    // var hasil = "";
    // var data = "";
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
      var data = new FormData($('#form_logsheet')[0]);
      data.append('logsheet_rumus_nama', rumus_detail_nama)
      data.append('logsheet_rumus', rumus);
      data.append('logsheet_hasil', hasil);
      var url = '<?= base_url('sample/inbox/storeLogsheetHistory') ?>';
      $.ajax({
          url: url,
          type: 'POST',
          dataType: 'HTML',
          data: data,
          processData: false,
          contentType: false,
          cache: false,
        })
        .done(function() {
          console.log("success");
        })
        .fail(function() {
          console.log("error");
        })
        .always(function() {
          console.log("complete");
        });

    });

  }

  // $('.add_log_detail').on('click', function() {
  //   alert('Dalam Proses !!');
  // })

  function add_simplo(id) {
    var form = "";
    var header = "";
    var body = "";
    var footer = "";
    var footer_adbk = "";
    var jumlah = $('tbody #tr_' + id).length + 1;
    $.getJSON('<?= base_url() ?>/master/perhitungan_sample/getDetailRumusSampleTemplate', {
      id_rumus: id
    }, function(json) {
      // simplo += ' <button type="button" id="add_log_detail" name="add_log_detail" class="btn btn-info">Simplo / Duplo</button>';
      form += '<form id="form_logsheet_detail">';
      header += '<tr ><th>No</th>';
      body += '<tr class="tr" id="tr_' + id + '"><td>\
    <input type="text" name="logsheet_detail_urut[]" id="logsheet_detail_urut_' + id + '_' + jumlah + '" value="' + jumlah + '" style="display:none">\
    ' + jumlah + '\
    <input type="text" value="' + jumlah + '" name="logsheet_detail_urut_baris[]" id="logsheet_detail_urut_baris_' + id + '_' + jumlah + '" style="display:none">\
    <input type="text" id="logsheet_rumus_id_' + id + '_' + jumlah + '" value="' + id + '" name="logsheet_rumus_id[]" style="display:none"><input type="text" name="logsheet_detail_id[]" style="display:none" id="logsheet_detail_id_' + id + '_' + jumlah + '" value="' + (Date.now() * jumlah) + '"></td>';
      footer += '<tr class="tr_foot_' + id + '" id="tr_foot_' + id + '_' + jumlah + '">'
      footer_adbk += '<tr class="tr_foot_adbk_' + id + '" id="tr_foot_adbk_' + id + '_' + jumlah + '">'
      $.each(json, function(index, val) {
        header += '<th>' + val.rumus_detail_nama + '</th>';
        if (val.rumus_detail_input != null) body += '<td>\
        <input type="text" style="display:none" name="logsheet_rumus_id_detail[]" id="logsheet_rumus_id_detail_' + id + '_' + jumlah + '" value="' + id + '">\
      <input type="text" name="logsheet_detail_id_detail[]" style="display:none" id="logsheet_detail_id_detail_' + id + '_' + jumlah + '" value="' + (Date.now() * jumlah) + '">\
      <input type="text" style="display:none" id="logsheet_detail_detail_id_' + val.rumus_detail_id + '_' + jumlah + '" name="logsheet_detail_detail_id[]" value="' + (new Date().getMilliseconds() * 3600 * jumlah) + '_' + val.rumus_detail_urut + '">\
      <input type="text" id="rumus_detail_id_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_id[]" value="' + val.rumus_detail_id + '" class="form-control" style="display:none">\
      <input type="text" id="rumus_detail_nama_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_nama[]" value="' + val.rumus_detail_nama + '" class="form-control" style="display:none">\
      <input type="text" id="rumus_detail_isi_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_isi[]" class="form-control" value="' + val.rumus_detail_input + '" readonly>\
      <input type="text" id="rumus_detail_urut_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_urut[]" value="' + val.rumus_detail_urut + '" style="display:none">\
      <input type="text" id="rumus_detail_template_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_template[]" value="' + val.rumus_detail_template + '" style="display:none">\
      <input type="text" id="rumus_detail_jenis_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_jenis[]" value="' + val.rumus_jenis + '" style="display:none">\
      </td>';
        //   <input type="text" name="logsheet_detail_id_detail[]" style="display:none" id="logsheet_detail_id_detail_' + id + '_' + jumlah + '" value="' + (Date.now() * jumlah) + '_'+val.rumus_detail_urut+'">\
        //   <input type="text" style="display:none" id="logsheet_detail_detail_id_' + val.rumus_detail_id + '_' + jumlah + '" name="logsheet_detail_detail_id[' + jumlah + '][]" value="' + (new Date().getMilliseconds() * 3600 * jumlah) + '_' + val.rumus_detail_urut + '">\
        //   <input type="text" id="rumus_detail_id_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_id[' + jumlah + '][]" value="' + val.rumus_detail_id + '" class="form-control" style="display:none">\
        //   <input type="text" id="rumus_detail_nama_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_nama[' + jumlah + '][]" value="' + val.rumus_detail_nama + '" class="form-control" style="display:none">\
        // <input type="text" id="rumus_detail_isi_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_isi[' + jumlah + '][]" class="form-control" value="' + val.rumus_detail_input + '" readonly>\
        // <input type="text" id="rumus_detail_urut_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_urut[' + jumlah + '][]" value="' + val.rumus_detail_urut + '" style="display:none">\
        // <input type="text" id="rumus_detail_template_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_template[' + jumlah + '][]" value="' + val.rumus_detail_template + '" style="display:none">\
        // <input type="text" id="rumus_detail_jenis_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_jenis[' + jumlah + '][]" value="' + val.rumus_jenis + '" style="display:none">\
        // </td>';
        else body += '<td>\
      <input type="text" style="display:none" name="logsheet_rumus_id_detail[]" id="logsheet_rumus_id_detail_' + id + '_' + jumlah + '" value="' + id + '">\
      <input type="text" name="logsheet_detail_id_detail[]" style="display:none" id="logsheet_detail_id_detail_' + id + '_' + jumlah + '" value="' + (Date.now() * jumlah) + '">\
      <input type="text" style="display:none" id="logsheet_detail_detail_id_' + val.rumus_detail_id + '_' + jumlah + '" name="logsheet_detail_detail_id[]" value="' + (new Date().getMilliseconds() * 3600 * jumlah) + '_' + val.rumus_detail_urut + '">\
      <input type="text" id="rumus_detail_id' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_id[]" value="' + val.rumus_detail_id + '" class="form-control" style="display:none">\
      <input type="text" id="rumus_detail_nama' + val.rumus_detail_nama + '_' + jumlah + '" name="rumus_detail_nama[]" value="' + val.rumus_detail_nama + '" class="form-control" style="display:none">\
      <input type="number" id="rumus_detail_isi' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_isi[]" class="form-control">\
      <input type="text" id="rumus_detail_urut_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_urut[]" value="' + val.rumus_detail_urut + '" style="display:none">\
      <input type="text" id="rumus_detail_template_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_template[]" value="' + val.rumus_detail_template + '" style="display:none">\
      <input type="text" id="rumus_detail_jenis_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_jenis[]" value="' + val.rumus_jenis + '" style="display:none">\
      </td>';
        // <input type="text" name="logsheet_detail_id_detail[]" style="display:none" id="logsheet_detail_id_detail_' + id + '_' + jumlah + '" value="' + (Date.now() * jumlah) + '_'+val.rumus_detail_urut+'">\
        //   <input type="text" style="display:none" id="logsheet_detail_detail_id_' + val.rumus_detail_id + '_' + jumlah + '" name="logsheet_detail_detail_id[' + jumlah + '][]" value="' + (new Date().getMilliseconds() * 3600 * jumlah) + '_' + val.rumus_detail_urut + '">\
        // <input type="text" id="rumus_detail_id' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_id[' + jumlah + '][]" value="' + val.rumus_detail_id + '" class="form-control" style="display:none">\
        // <input type="text" id="rumus_detail_nama' + val.rumus_detail_nama + '_' + jumlah + '" name="rumus_detail_nama[' + jumlah + '][]" value="' + val.rumus_detail_nama + '" class="form-control" style="display:none">\
        // <input type="number" id="rumus_detail_isi' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_isi[' + jumlah + '][]" class="form-control">\
        // <input type="text" id="rumus_detail_urut_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_urut[' + jumlah + '][]" value="' + val.rumus_detail_urut + '" style="display:none">\
        // <input type="text" id="rumus_detail_template_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_template[' + jumlah + '][]" value="' + val.rumus_detail_template + '" style="display:none">\
        // <input type="text" id="rumus_detail_jenis_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_jenis[' + jumlah + '][]" value="' + val.rumus_jenis + '" style="display:none">\
        // </td>';
      });
      header += '<th>Hasil</th><th>Aksi</th></tr>';
      body += '<td>\
<input type="text" class="form-control hasil_' + id + '" id="hasil_' + id + '_' + jumlah + '" name="hasil_' + id + '[' + jumlah + ']" readonly placeholder="klik u/ hasil">\
<br>\
<input type="text" class="form-control" id="rumus_detail_hasil_' + id + '_' + jumlah + '" name="rumus_detail_hasil[]" style="display:none">\
</td>\
<td>\
<a href="javascript:void(0);" id="' + id + '" onclick="add_simplo(this.id)"><i class="fa fa-plus" style="color:green"></i></a><br>\
<a href="javascript:void(0);" id="remove_simplo" ><i class="fa fa-minus" style="color:red"></i></a>\
</td></tr>';
      footer += '<td colspan="' + (json.length + 1) + '"><p>Rata-rata </p></td><td><input class="form-control" placeholder="klik untuk rata-rata" type="text" id="rata_' + id + '_' + jumlah + '" name="rata_rata[]" onclick="fun_average(`' + id + '`)" readonly></td></tr>';

      footer_adbk += '<td colspan="' + (json.length + 1) + '"><p>Nilai ADBK </p></td><td><input class="form-control" placeholder="klik untuk nilai_adbk" type="text" id="nilai_adbk_' + id + '_' + jumlah + '" name="nilai_adbk[]" onclick="fun_nilai_adbk(`' + id + '`)" readonly></td></tr>';

      form += '</form>';

      $('#header_' + id).html(header);
      $('#body_' + id).append(body);
      // $('#adbk_' + id).show();
      $('.tr_foot_' + id).hide();
      $('#footer_' + id).append(footer);

      $.getJSON('<?= base_url() ?>/master/perhitungan_sample/getPerhitunganSample', {
        rumus_id: id
      }, function(json, textStatus) {
        if (json.is_adbk == 'y') {
          $('.tr_foot_adbk_' + id).hide();
          $('#footer_' + id).append(footer_adbk);
        }
      });

      // $('.tr_foot_adbk_' + id).hide();
      // $('#footer_' + id).append(footer_adbk);

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
    })

  }

  $(document).on('click', '#remove_simplo', function() {
    $(this).parents("tr").remove();
  })


  function fun_hitung(id, urut) {
    $.getJSON('<?= base_url() ?>/master/perhitungan_sample/getDetailRumusSample', {
      id_rumus: id
    }, function(json) {
      var rumus = '';
      $.each(json, function(index, val) {
        console.log(val);
        if (val.rumus_jenis == 'I') rumus += '(' + $('#rumus_detail_isi_' + val.rumus_detail_id + '_' + urut).val() + ')';
        else if (val.rumus_jenis == 'A') rumus += '(' + val.rumus_detail_input + ')';
        else rumus += val.rumus_detail_input;
      });
      // cek hasil
      var hasil = (math.evaluate(rumus));
      $('#hasil_dump_' + id).val(hasil.toFixed(2));
      $('#hasil_' + id + '_' + urut).val(hasil.toFixed(2));
      $('#rumus_hasil_' + id + '_' + urut).val(hasil.toFixed(2));
      // cek cheklist
      var batasan = $('#batasan_' + id).val();
      console.log(hasil);
      console.log(batasan);
      // $('#checklist_' + id).val('');
      if (parseFloat($('#hasil_' + id).val()) < parseFloat($('#batasan_' + id).val())) {
        $('#checklist_' + id).val('√');
        $('#checklist_dump_' + id).html('√');
        $('#kesimpulan_' + id).val('aman');
        $('#kesimpulan_dump_' + id).html('aman');
      } else {
        $('#checklist_' + id).val('X');
        $('#checklist_dump_' + id).html('X');
        $('#kesimpulan_' + id).val('over');
        $('#kesimpulan_dump_' + id).html('over');
      }

    })
  }

  // klik hasil
  function func_hasil(id) {
    $.getJSON('<?= base_url() ?>/master/perhitungan_sample/getDetailRumusSample', {
      id_rumus: id
    }, function(json) {
      var rumus = '';
      $.each(json, function(index, val) {
        if (val.rumus_jenis == 'I') rumus += '(' + $('#rumus_isi_' + val.rumus_detail_id).val() + ')';
        else if (val.rumus_jenis == 'A') rumus += '(' + val.rumus_detail_input + ')';
        else rumus += val.rumus_detail_input;
      });
      // cek hasil
      var hasil = (math.evaluate(rumus));
      $('#hasil_dump_' + id).val(hasil.toFixed(2));
      $('#hasil_' + id).val(hasil.toFixed(2));
      // cek cheklist
      var batasan = $('#batasan_' + id).val();
      console.log(hasil);
      console.log(batasan);
      // $('#checklist_' + id).val('');
      if (parseFloat($('#hasil_' + id).val()) < parseFloat($('#batasan_' + id).val())) {
        $('#checklist_' + id).val('√');
        $('#checklist_dump_' + id).html('√');
        $('#kesimpulan_' + id).val('aman');
        $('#kesimpulan_dump_' + id).html('aman');
      } else {
        $('#checklist_' + id).val('X');
        $('#checklist_dump_' + id).html('X');
        $('#kesimpulan_' + id).val('over');
        $('#kesimpulan_dump_' + id).html('over');
      }
      // cek cheklist

      // cek kesimpulan

      // cek kesimpulan

    })
  }
  // klik hasil

  // proses
</script>