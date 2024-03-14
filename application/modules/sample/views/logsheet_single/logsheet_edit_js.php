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
      timePicker: true,
      timePicker24Hour: true,
      timePickerSeconds: true,
      locale: {
        format: 'DD-MM-YYYY HH:mm:ss'
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
          location.href = '<?= base_url('sample/inbox/draftLogSheet/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) . '&transaksi_id=' . $_GET['transaksi_id'] . '&transaksi_detail_id=' ?>' + $('#transaksi_detail_id').val() + '&transaksi_detail_status=' + '<?= $_GET['transaksi_detail_status'] + 1 . '&template_logsheet_id=' ?>' + $('#template_logsheet_id').val() + '&logsheet_id=' + $('#logsheet_id').val();
        }
      });
    })
  })

  function gantiRumus(id) {

  }
  // proses
</script>