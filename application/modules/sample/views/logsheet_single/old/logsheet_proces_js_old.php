<script>
  $(function() {

    // Render Main Log
    // add log
    $(document).on('click', '#add_log', function() {

      let random = $('.div_log_baru').length + 1;
      var addLog = '<div class="div_log_baru">\
      <div class="row">\
      <div class="col-6">\
      <div class="form-group row col-12">\
      <label class="col-md-4">Jenis Uji</label>\
      <div class="input-group col-md-8">\
      <input type="text" class="form-control" id="log_jenis_nama' + random + '" name="log_jenis_nama[' + random + ']" placeholder="Jenis Uji" value="<?= $inbox_detail[0]['jenis_nama'] ?>">\
      </div>\
      </div>\
      <div class="form-group row col-12">\
      <label class="col-md-4">Satuan</label>\
      <div class="input-group col-md-8">\
      <input type="text" class="form-control" id="log_jenis_unit' + random + '" name="log_jenis_unit[' + random + ']" placeholder="Satuan">\
      </div>\
      </div>\
      <div class="form-group row col-12">\
      <label class="col-md-4">Deskripsi</label>\
      <div class="input-group col-md-8">\
      <textarea name="log_deskripsi[' + random + ']" id="log_deskripsi' + random + '" cols="30" rows="3" class="form-control" placeholder="Deskripsi Sample"></textarea>\
      </div>\
      </div>\
      </div>\
      <div class="col-6">\
      <div class="form-group row col-12">\
      <label class="col-md-4">Metoda</label>\
      <div class="input-group col-md-8">\
      <input type="text" class="form-control" id="log_metoda' + random + '" name="log_metoda[' + random + ']" placeholder="Metoda">\
      </div>\
      </div>\
      <div class="form-group row col-12">\
      <label class="col-md-4">Rumus</label>\
      <div class="input-group col-md-8">\
      <select id="rumus' + random + '" name="rumus[' + random + ']" class="form-control select2 rumus"></select>\
      </div>\
      </div>\
      </div>\
      <div class="input-group col-md-3" >\
      <button type="button" id="remove_log" name="remove_log" class="btn btn-danger">Batalkan Parameter Uji</button>\
      </div>\
      <div class="input-group col-1" style="min-width:max-content">\
      <button type="button" id="add_log_detail' + random + '" name="add_log_detail" class="btn btn-info">Simplo / Duplo</button>\
      </div>\
      <div class="input-group col-1" style="min-width:max-content">\
      <!-- <button type="button" id="add_log_detail_column' + random + '" name="add_log_detail_column" class="btn btn-info">Tambah Kolom</button> -->\
      </div>\
      </div>\
      <br>\
      <div class="row">\
      <div class=" form-group col-12 row">\
      <table id="table' + random + '" class="table table-bordered table-striped" width="100%">\
      <thead>\
      <tr>\
      <th>No</th>\
      <th>Vol Orsat</th>\
      <th>Vol Sisa Gas</th>\
      <th>Hasil</th>\
      <th>Aksi</th>\
      </tr>\
      </thead>\
      <tbody class="tbody" id="tbody' + random + '">\
      <input type="text" style="display:none" id="logsheet_urut" name="logsheet_urut[' + random + ']" value="' + random + '">\
      <input type="text" style="display:none" id="logsheeet_detail_id" name="logsheet_detail_id[' + random + ']" value="' + $('.logsheet_detail_id').val() + '_' + random + '">\
      <tr class="tr" id="tr' + random + '">\
      <td class="td">\
      <input type="text" id="logsheet_urut_kolom" name="logsheet_urut_kolom[' + random + ']" value="1" style="display:none">\
      <input type="text" id="param_urut_1' + random + '" name="param_urut[' + random + '][]" value="1" style="display:none">\
      <input type="text" class="form-control" id="urut' + random + '" name="urut[' + random + '][]" value="1" readonly></td>\
      <td class="td">\
      <input type="text" id="param_urut_2' + random + '" name="param_urut[' + random + '][]" value="2" style="display:none">\
      <input type="text" class="form-control" id="vol_orsat' + random + '" name="vol_orsat[' + random + '][]"></td>\
      <td class="td">\
      <input type="text" id="param_urut_3' + random + '" name="param_urut[' + random + '][]" value="3" style="display:none">\
      <input type="text" class="form-control" id="vol_sisa_gas' + random + '" name="vol_sisa_gas[' + random + '][]"></td>\
      <td class="td">\
      <input type="text" id="param_urut_4' + random + '" name="param_urut[' + random + '][]" value="4" style="display:none">\
      <input type="text" class="form-control" id="hasil' + random + '" name="hasil[' + random + '][]"></td>\
      <td class="td"><button type="button" class="btn btn-danger" id="remove_log_detail' + random + '">Hapus</button></td>\
      </tr>\
      </tbody>\
      </table>\
      </div>\
      </div>\
      <hr>\
      </div>';

      $(".div_log").append(addLog);

      $('#rumus' + random).select2({
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

      $(document).on('click', '#add_log_detail' + random, function() {
        var rand = $('#tr' + random).length + 1
        var addRowDetail = '<tr class="tr" id="tr' + rand + '">\
        <td>\
        <input type="text" id="logsheet_urut_kolom" name="logsheet_urut_kolom[' + rand + ']" value="' + rand + '" style="display:none">\
        <input type="text" id="param_urut_' + rand + '" name="param_urut[' + rand + '][]" value="1" style="display:none">\
        <input type="text" class="form-control" id="urut_' + rand + '" name="urut[' + rand + '][]" value="' + rand + '" readonly></td>\
        <td>\
        <input type="text" id="param_urut_' + rand + '" name="param_urut[' + rand + '][]" value="2" style="display:none">\
        <input type="text" class="form-control" id="vol_orsat_' + rand + '" name="vol_orsat[' + rand + '][]"></td>\
        <td>\
        <input type="text" id="param_urut_' + rand + '" name="param_urut[' + rand + '][]" value="3" style="display:none">\
        <input type="text" class="form-control" id="vaol_sisa_gas_' + rand + '" name="vol_sisa_gas[' + rand + '][]"></td>\
        <td>\
        <input type="text" id="param_urut_' + rand + '" name="param_urut[' + rand + '][]" value="4" style="display:none">\
        <input type="text" class="form-control" id="hasil_' + rand + '" name="hasil[' + rand + '][]"></td>\
        <td><button type="button" class="btn btn-danger" id="remove_log_detail' + rand + '">Hapus</button></td>\
        </tr>';
        $('#tbody' + random).append(addRowDetail);
      })

      $(document).on('click', '#remove_log_detail' + random, function() {
        $(this).parents("tr").remove();
      })

    })

    // add log

    // remove log
    $(document).on('click', '#remove_log', function() {
      $(this).closest('.div_log_baru').remove();
    })
    // remove log
    // Render Main Log



    // render detail log
    // add log
    $(document).on('click', '#add_log_detail', function() {
      var jumlah = $('tr').length;
      console.log(jumlah);
      var addLogRow = '<tr class="tr">\
  <td>\
  <input type="text" id="logsheet_urut_kolom" name="logsheet_urut_kolom[0]" value="' + jumlah + '" style="display:none">\
  <input type="text" id="param_urut_1' + jumlah + '" name="param_urut[0][]" value="1" style="display:none">\
  <input type="text" class="form-control" id="urut_' + jumlah + '" name="urut[0][]" value="' + jumlah + '" readonly>\
  </td>\
  <td>\
  <input type="text" id="param_urut_2' + jumlah + '" name="param_urut[0][]" value="2" style="display:none">\
  <input type="text" class="form-control" id="vol_orsat_' + jumlah + '" name="vol_orsat[0][]">\
  </td>\
  <td>\
  <input type="text" id="param_urut_3' + jumlah + '" name="param_urut[0][]" value="3" style="display:none">\
  <input type="text" class="form-control" id="vol_sisa_gas_' + jumlah + '" name="vol_sisa_gas[0][]"></td>\
  <td>\
  <input type="text" id="param_urut_4' + jumlah + '" name="param_urut[0][]" value="4" style="display:none">\
  <input type="text" class="form-control" id="hasil_' + jumlah + '" name="hasil[0][]"></td>\
  <td><button type="button" class="btn btn-danger" id="remove_log_detail">Hapus</button></td>\
  </tr>';

      $('#tbody').append(addLogRow);
    })
    // add log

    // remove log
    $(document).on('click', '#remove_log_detail', function() {
      $(this).parents("tr").remove();
    })
    // remove log
    // render detail log

    // render detail log column
    // add log colume
    $(document).on('click', '#add_log_detail_column', function() {
      var length = $('td').length + 1;
      var addLogColumn = '<td><input type="text" class="form-control" id="param_' + length + '" name="param_' + length + '"></td>'
      $('.tr > .td' + length + ':last-child')
      console.log(addLogColumn)
        .before(addLogColumn);
    })

    // $('#add_log_detail_column').on("click", function() {
    //   var length = $('td').length + 1;
    //   // $('#table thead tr').append($('<th><input type="text" class="form-control" id="param_' + length + '" name="param_' + length + '"></th>'));
    //   // $('#table tbody tr').append($('<td><input type="text" class="form-control" id="param_' + length + '" name="param_' + length + '"></td>'));
    //   // $('#table thead tr>td:last').html($('#col').val());

    //   $('#tr > #td' + length + ':last-child')
    //     .before('<td><input type="text" class="form-control" id="param_' + length + '" name="param_' + length + '"></td>')
    // });
    // add log colume
    // render detail log column
    $(".tanggal").daterangepicker({
      showDropdowns: true,
      singleDatePicker: true,
      // timePicker: true,
      // timePicker24Hour: true,
      // timePickerSeconds: true,
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
      var data = new FormData($('#form_logsheet')[0]);
      url = '<?= base_url('sample/inbox/insertDraftLogSheet1') ?>';
      $.ajax({
        type: "POST",
        url: url,
        data: data,
        dataType: 'HTML',
        processData: false,
        contentType: false,
        cache: false,
        success: function(response) {
          // location.href = '<?= base_url('sample/inbox/draftLogSheet/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) . '&transaksi_id=' . $_GET['transaksi_id'] . '&transaksi_detail_id=' ?>' + $('#transaksi_detail_id').val() + '&transaksi_detail_status=' + '<?= $_GET['transaksi_detail_status'] + 1 . '&template_logsheet_id=' ?>' + $('#template_logsheet_id').val() + '&logsheet_id=' + $('#logsheet_id').val();
        }
      });
    })
  })

  function gantiRumus(id) {

  }

  window.onload = fun_rumus('<?= $_GET['template_logsheet_id'] ?>');

  function fun_rumus(id) {
    var html = "";
    $.getJSON('http://103.157.97.200/digilab_v2/master/template_logsheet/getDetailLogsheet', {
      id_logsheet_template: id
    }, function(json) {
      html += '<div class="row">';
      $.each(json, function(index, val) {
        html += '<div class="card-header col-12">';
        html += '<h3 class="card-title">' + val.rumus_nama + ' = <b id="list_' + val.rumus_id + '"></b></h3>';
        html += '<button type="button" id="average_' + val.rumus_id + '" name="average[]" class="btn btn-info btn-custom float-right" style="display:none" onclick="fun_average(`' + val.rumus_id + '`)">Rata-rata</button>';
        // html += '<a href="<?= base_url('sample/request/addRequest?') . 'header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id'] ?>" class="btn btn-primary float-right btn-custom-small  ">Tambah</a>';
        html += '</div>';
        html += '<div class="form-group col-12 row">';
        html += '<input type="text" name="rumus_id[]" value="' + val.rumus_id + '" style="display:none">';
        html += '<input type="text" name="rumus_nama[]" value="' + val.rumus_nama + '" style="display:none">';
        html += '<table id="' + val.rumus_id + '" class="table table-bordered table-striped datatables" width="100%">';
        html += '<thead id="header_' + val.rumus_id + '"></thead>';
        html += '<tbody id="body_' + val.rumus_id + '"></tbody>';
        html += '<tfoot id="footer_' + val.rumus_id + '"></tfoot>'
        html += '</table>';
        html += '<p style="color:red;">* Klik Hasil Untuk Menghitung</p>';
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
    $.getJSON('http://103.157.97.200/digilab_v2/master/perhitungan_sample/getDetailRumusSampleTemplate', {
      id_rumus: id
    }, function(json) {
      // simplo += ' <button type="button" id="add_log_detail" name="add_log_detail" class="btn btn-info">Simplo / Duplo</button>';
      header += '<tr ><th>No</th>';
      // body += '<form id="form_rumus_detail_' + id + '">'
      body += '<tr class="tr" id="tr_' + id + '"><td>1</td>';
      $.each(json, function(index, val) {
        header += '<th>' + val.rumus_detail_nama + '</th>';
        if (val.rumus_detail_input != null) body += '<td>\
        <input type="text" id="rumus_detail_id_input' + val.rumus_detail_id + '" name="rumus_detail_id[0][]" value="' + val.rumus_detail_id + '" class="form-control" style="display:none">\
      <input type="text" id="rumus_detail_nama_input' + val.rumus_detail_id + '" name="rumus_detail_nama[0][]" value="' + val.rumus_detail_nama + '" class="form-control" style="display:none">\
      <input type="text" id="rumus_detail_isi_input' + val.rumus_detail_id + '" name="rumus_detail_isi[0][]" class="form-control" value="' + val.rumus_detail_input + '" readonly>\
      </td>';
        else body += '<td>\
      <input type="text" id="rumus_detail_id' + val.rumus_detail_id + '" name="rumus_detail_id[0][]" value="' + val.rumus_detail_id + '" class="form-control" style="display:none">\
      <input type="text" id="rumus_detail_nama' + val.rumus_detail_nama + '" name="rumus_detail_nama[0][]" value="' + val.rumus_detail_nama + '" class="form-control" style="display:none">\
      <input type="number" id="rumus_detail_isi' + val.rumus_detail_id + '" name="rumus_detail_isi[0][]" class="form-control">\
      </td>';
      });
      // body += '</form>';
      header += '<th>Hasil</th><th>Aksi</th></tr>';
      body += '<td>\
    <input type="text" class="form-control" id="hasil_' + id + '" name="hasil_' + id + '[]" readonly onclick="fun_hitung(`' + id + '`);" readonly>\
    <input type="text" class="form-control" id="hasil_rumus_detail_' + id + '" name="hasil_rumus_detail[0][]" style="display:none">\
    </td>\
    <td width="20px">\
    <a href="javascript:void(0);" id="' + id + '" onclick="add_simplo(this.id)"><i class="fa fa-plus" style="color:green"></i></a>\
    <br>\
    <a href="javascript:void(0);" id="remove_simplo" ><i class="fa fa-minus" style="color:red"></i></a>\
    </td></tr>';

      $('#header_' + id).html(header);
      $('#body_' + id).append(body);
    });


  }
  // <input type="number" id="' + val.rumus_detail_id + '" name="' + val.rumus_detail_id + '[0]" class="form-control">\

  function fun_list_rumus(id) {
    var html = "";
    $.getJSON('http://103.157.97.200/digilab_v2/master/perhitungan_sample/getListRumus', {
      id_rumus: id
    }, function(json) {
      $.each(json, function(index, val) {
        html += val.rumus;
      });

      $('#list_' + id).html(html);
    });
  }

  function fun_hitung(id) {
    $.getJSON('http://103.157.97.200/digilab_v2/master/perhitungan_sample/getDetailRumusSample', {
      id_rumus: id
    }, function(json) {
      var rumus = '';
      $.each(json, function(index, val) {
        if (val.rumus_jenis == 'I') rumus += '(' + $('#rumus_detail_isi' + val.rumus_detail_id).val() + ')';
        else rumus += val.rumus_detail_input;
      });

      var hasil = math.evaluate(rumus);
      $('#hasil_' + id).val(hasil.toFixed(2));
      $('#hasil_rumus_detail_' + id).val(hasil.toFixed(2));

    });
  }

  // function fun_store(id) {
  //   $.getJSON('http://103.157.97.200/digilab_v2/master/perhitungan_sample/getDetailRumusSample', {
  //     id_rumus: id
  //   }, function(json) {
  //     var rumus = '';
  //     $.each(json, function(index, val) {
  //       if (val.rumus_jenis == 'I') rumus += '(' + $('#rumus_detail_isi' + val.rumus_detail_id).val() + ')';
  //       else rumus += val.rumus_detail_input;
  //       var logsheet_detail_detail_id = Date.now() + '_' + val.rumus_detail_id;
  //       // id_logsheet
  //       // id_logsheet_detail
  //       var rumus_detail_id = val.rumus_detail_id;
  //       var id_rumus = val.id_rumus;
  //       // rumus_detail_input
  //       var rumus_detail_nama = val.rumus_detail_nama;
  //       if (val.rumus_jenis == 'I') var rumus_detail_isi = '(' + $('#rumus_detail_isi' + val.rumus_detail_id).val() + ')';
  //       else var rumus_detail_isi = val.rumus_detail_input;
  //       // rumus_detail_isi
  //       var rumus_jenis = val.rumus_jenis;
  //       // when_create
  //       // who_create
  //       var rumus_detail_urut = val.rumus_detail_urut;
  //       var rumus_detail_template = val.rumus_detail_template;

  //       var data = new FormData();

  //       data.append('logsheet_detail_detail_id', logsheet_detail_detail_id);
  //       // data.append('id_logsheet');
  //       // data.append('id_logsheet_detail');
  //       data.append('rumus_detail_id', rumus_detail_id);
  //       data.append('id_rumus', id_rumus);
  //       // data.append('rumus_detail_input',);
  //       data.append('rumus_detail_nama', rumus_detail_nama);
  //       data.append('rumus_detail_isi', rumus_detail_isi);
  //       data.append('rumus_jenis', rumus_jenis);
  //       // data.append('when_create');
  //       // data.append('who_create');
  //       data.append('rumus_detail_urut', rumus_detail_urut);
  //       data.append('rumus_detail_template', rumus_detail_template);

  //       console.log(data);
  //     });

  //     // console.log(rumus);



  //   });
  // }

  function fun_average(id) {
    var header = "";
    var body = "";
    var footer = "";
    var jumlah = $('tbody #tr_' + id).length;
    $.getJSON('http://103.157.97.200/digilab_v2/master/perhitungan_sample/getDetailRumusSample', {
      id_rumus: id
    }, function(json) {

      var hasil = '';

      for (i = 1; i <= jumlah; i++) {
        hasil = $('[name="hasil_' + id + '[]"]').val();
        console.log(hasil);
      }

      // for (var i = 0; i <= jumlah; i++) {
      //   console.log(jumlah);
      //   hasil = $('[name="hasil_' + id + '"]').val();
      //   // hasil = $('#hasil_' + id).val();
      //   console.log(hasil);
      // }



      // var hasil = math.evaluate(rumus);

      footer += '<tr class="tr_foot_' + id + '" id="tr_foot_' + id + '">'
      footer += '<td colspan=""></td><td><input type="text" class="average_' + id + '"></td></tr>';
      // $(this).parents("tr").remove();
      $('#tr_foot_' + id).append(footer);
    });

  }
  // $('.add_log_detail').on('click', function() {
  //   alert('Dalam Proses !!');
  // })

  function add_simplo(id) {
    var header = "";
    var body = "";
    var footer = "";
    var jumlah = $('tbody #tr_' + id).length + 1;
    $.getJSON('http://103.157.97.200/digilab_v2/master/perhitungan_sample/getDetailRumusSampleTemplate', {
      id_rumus: id
    }, function(json) {
      // simplo += ' <button type="button" id="add_log_detail" name="add_log_detail" class="btn btn-info">Simplo / Duplo</button>';
      header += '<tr ><th>No</th>';
      body += '<tr class="tr" id="tr_' + id + '"><td>' + jumlah + '</td>';
      footer += '<tr class="tr_foot">'
      $.each(json, function(index, val) {
        header += '<th>' + val.rumus_detail_nama + '</th>';
        if (val.rumus_detail_input != null) body += '<td>\
        <input type="text" id="rumus_detail_id_input' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_id[' + jumlah + '][]" value="' + val.rumus_detail_id + '" class="form-control" style="display:none">\
      <input type="text" id="rumus_detail_nama_input' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_nama[' + jumlah + '][]" value="' + val.rumus_detail_nama + '" class="form-control" style="display:none">\
      <input type="text" id="rumus_detail_isi_input' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_isi[' + jumlah + '][]" class="form-control" value="' + val.rumus_detail_input + '" readonly>\
      </td>';
        else body += '<td>\
      <input type="text" id="rumus_detail_id' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_id[' + jumlah + '][]" value="' + val.rumus_detail_id + '" class="form-control" style="display:none">\
      <input type="text" id="rumus_detail_nama' + val.rumus_detail_nama + '_' + jumlah + '" name="rumus_detail_nama[' + jumlah + '][]" value="' + val.rumus_detail_nama + '" class="form-control" style="display:none">\
      <input type="number" id="rumus_detail_isi' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_isi[' + jumlah + '][]" class="form-control">\
      </td>';
      });
      header += '<th>Hasil</th><th>Aksi</th></tr>';
      body += '<td>\
    <input type="text" class="form-control" id="hasil_' + id + '_' + jumlah + '" name="hasil_' + id + '[]" readonly>\
    <br>\
    <input type="text" class="form-control" id="hasil_rumus_detail_' + id + '_' + jumlah + '" name="hasil_rumus_detail[' + jumlah + '][]" style="display:none">\
    </td>\
    <td>\
    <a href="javascript:void(0);" id="' + id + '" onclick="add_simplo(this.id)"><i class="fa fa-plus" style="color:green"></i></a>\
    <a href="javascript:void(0);" id="remove_simplo" ><i class="fa fa-minus" style="color:red"></i></a>\
    </td></tr>';
      footer += '<td><input type="text"></td></tr>';

      $('#header_' + id).html(header);
      $('#body_' + id).append(body);
      $('#average_' + id).show();
      // $('tfoot:last').append(footer);
    });

    $(document).on('click', '#hasil_' + id + '_' + jumlah, function() {
      $.getJSON('http://103.157.97.200/digilab_v2/master/perhitungan_sample/getDetailRumusSample', {
        id_rumus: id
      }, function(json) {
        var rumus = '';
        $.each(json, function(index, val) {
          if (val.rumus_jenis == 'I') rumus += '(' + $('#rumus_detail_isi' + val.rumus_detail_id + '_' + jumlah).val() + ')';
          else rumus += val.rumus_detail_input;
        });

        var hasil = math.evaluate(rumus);
        $('#hasil_' + id + '_' + jumlah).val(hasil.toFixed(2));
        $('#hasil_rumus_detail_' + id + '_' + jumlah).val(hasil.toFixed(2));
      });
    })

  }

  $(document).on('click', '#remove_simplo', function() {
    $(this).parents("tr").remove();
  })

  // proses
</script>