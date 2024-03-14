<script>
  $(function() {
    document.onreadystatechange = function() {
      // page fully load
      if (document.readyState == "complete") {
        // hide loader after 2 seconds
        setTimeout(function() {
          document.getElementById('loader').style.display = 'none';
        }, 2500);
      }
    }
    // load data
    $(window).on('load', function() {
      var id = '<?= $_GET['non_rutin'] ?>';
      // data utama
      $.getJSON("<?= base_url('sample/request/getRequest') ?>", {
          transaksi_non_rutin_id: id
        },
        function(data, textStatus, jqXHR) {

          // perbutton
          if (data.transaksi_status == '0') {
            // status = 'Draft';
          } else if (data.transaksi_status == '1') {
            // status = 'Pengajuan';
            $('#review').show();
          } else if (data.transaksi_status == '2') {
            $('#approve').show();
          } else if (data.transaksi_status == '3') {
            $('#disposisi_vp').show();
          } else if (data.transaksi_status == '4') {
            $('#disposisi_avp').show();
          } else if (data.transaksi_status == '5') {
            $('#disposisi_pic').show();
            $('#div_disposisi').show();
            $('#div_petugas').show();
          } else if (data.transaksi_status == '6') {
            $('#disposisi_seksi').show();
            $('#div_seksi').show();
          } else if (data.transaksi_status == '7') {
            $('#disposisi_petugas').show();
            $('#div_petugas')
          } else if (data.transaksi_status == '8') {
            status = 'Close Sample'
            $('#close').show();
          }
          // perbutton


          $('#transaksi_non_rutin_id').val(data.transaksi_non_rutin_id);
          $('#transaksi_judul').val(data.transaksi_judul);

          $('#transaksi_kecepatan_tanggap').val(data.transaksi_kecepatan_tanggap).trigger('change');
          $('#transaksi_sifat').val(data.transaksi_sifat).trigger('change');

          $('#transaksi_klasifikasi_id').append('<option selected value="' + data.klasifikasi_id + '">' + data.klasifikasi_nama + ' - ' + data.klasifikasi_kode + '</option>');
          $('#klasifikasi_id').select2('data', {
            id: data.klasifikasi_id,
            text: data.klasifikasi_kode
          });

          $('#transaksi_reviewer').append('<option selected value="' + data.nik_reviewer + '">' + data.nik_reviewer + ' - ' + data.nama_reviewer + ' - ' + data.title_reviewer + '</option>');
          $('#transaksi_reviewer').select2('data', {
            id: data.nik_reviewer,
            text: data.nik_reviewer + '">' + data.nik_reviewer + ' - ' + data.nama_reviewer + ' - ' + data.title_reviewer,
          });
          $('#transaksi_reviewer').trigger('change');

          $('#transaksi_approver').append('<option selected value="' + data.nik_approver + '">' + data.nik_approver + ' - ' + data.nama_approver + ' - ' + data.title_approver + '</option>');
          $('#transaksi_approver').select2('data', {
            id: data.nik_approver,
            text: data.nik_approver + '">' + data.nik_approver + ' - ' + data.nama_approver + ' - ' + data.title_approver,
          });
          $('#transaksi_approver').trigger('change');

          $('#transaksi_tujuan').append('<option selected value="' + data.nik_tujuan + '">' + data.nik_tujuan + ' - ' + data.nama_tujuan + ' - ' + data.title_tujuan + '</option>');
          $('#transaksi_tujuan').select2('data', {
            id: data.nik_tujuan,
            text: data.nik_tujuan + '">' + data.nik_tujuan + ' - ' + data.nama_tujuan + ' - ' + data.title_tujuan,
          });
          $('#transaksi_tujuan').trigger('change');

          $('#transaksi_drafter').append('<option selected value="' + data.nik_drafter + '">' + data.nik_drafter + ' - ' + data.nama_drafter + ' - ' + data.title_drafter + '</option>');
          $('#transaksi_drafter').select2('data', {
            id: data.nik_drafter,
            text: data.nik_drafter + '">' + data.nik_drafter + ' - ' + data.nama_drafter + ' - ' + data.title_drafter,
          });
          $('#transaksi_drafter').trigger('change');

          $('#peminta_jasa_id').append('<option selected value="' + data.peminta_jasa_id + '">' + data.peminta_jasa_nama + '</option>');
          $('#peminta_jasa_id').select2('data', {
            id: data.peminta_jasa_id,
            text: data.peminta_jasa_nama + '">',
          });
          $('#peminta_jasa_id').trigger('change');

          $('#transaksi_drafter').append('<option selected value="' + data.nik_drafter + '">' + data.nik_drafter + ' - ' + data.nama_drafter + ' - ' + data.title_drafter + '</option>');
          $('#transaksi_drafter').select2('data', {
            id: data.nik_drafter,
            text: data.nik_drafter + '">' + data.nik_drafter + ' - ' + data.nama_drafter + ' - ' + data.title_drafter,
          });
          $('#transaksi_drafter').trigger('change');


          $('#transaksi_detail_pic_pengirim').append('<option selected value="' + data.nik_pic_pengirim + '">' + data.nik_pic_pengirim + ' - ' + data.nama_pic_pengirim + ' - ' + data.title_pic_pengirim + '</option>');
          $('#transaksi_detail_pic_pengirim').select2('data', {
            id: data.nik_pic_pengirim,
            text: data.nik_pic_pengirim + '">' + data.nik_pic_pengirim + ' - ' + data.nama_pic_pengirim + ' - ' + data.title_pic_pengirim,
          });
          $('#transaksi_detail_pic_pengirim').trigger('change');

          $('#transaksi_detail_pic_telepon').val(data.transaksi_pic_telepon);
          $('#transaksi_detail_ext_pengirim').val(data.transaksi_pic_ext);
        })

      // data detail
      // $.getJSON("<?= base_url('sample/request/getRequestDetail') ?>", {
      //     transaksi_non_rutin_id: id
      //   },
      //   function(result) {

      //   }
      // );

    });

    $(document).on('click', '#add_item', function() {

      let random = $('.div_item_baru').length + 1;
      var addRow = '<div class="div_item_baru">\
                  <div class="row">\
                <div class="form-group row col-md-12">\
                <div class="input-group col-10">\
                <input id="transaksi_detail_id" name="transaksi_detail_id[]" value="<?= create_id(); ?>_'+random+'" style="display:none">\
                    <input type="text" required class="form-control" id="item_judul" name="item_judul[]" placeholder="Judul" value="Sample '+random+'" style=" border:none;border-bottom: 1px solid #1890ff;padding: 5px 10px;  outline: none;">\
                  </div>\
                  <div class="input-group col-2">\
                    <button class="btn btn-danger btn-block" type="button" id="remove_item">Hapus</button>\
                  </div>\
                </div>\
              </div>\
              <div class="row">\
                <div class="col-6">\
                  <div class="form-group row col-12">\
                    <label class="col-md-4">Jenis Sample</label>\
                    <div class="input-group col-md-8">\
                      <select name="jenis_id[]" id="jenis_id' + random + '" class="form-control select2"></select>\
                    </div>\
                  </div>\
                  <div class="form-group row col-12">\
                    <label class="col-md-4">Jenis Pekerjaan</label>\
                    <div class="input-group col-md-8">\
                      <select name="jenis_pekerjaan_id[]" id="jenis_pekerjaan_id' + random + '" class="form-control select2"></select>\
                    </div>\
                  </div>\
                  <div class="form-group row col-12">\
                    <label for="" class="col-md-4">Jumlah Sample</label>\
                    <div class="input-group col-8">\
                      <input type="text" id="transaksi_detail_jumlah" name="transaksi_detail_jumlah[]" value="1" class="form-control">\
                    </div>\
                  </div>\
                  <div class="form-group row col-12">\
                    <label for="" class="col-md-4">Identitas Sample</label>\
                    <div class="input-group col-8">\
                      <input type="text" id="transaksi_detail_identitas" name="transaksi_detail_identitas[]" placeholder="Identitas Sample" class="form-control">\
                    </div>\
                  </div>\
                  <div class="form-group row col-12">\
                    <label for="" class="col-md-4">Parameter Sample</label>\
                    <div class="input-group col-8">\
                      <input type="text" id="transaksi_detail_parameter" name="transaksi_detail_parameter[]" placeholder="Parameter Sample" class="form-control">\
                    </div>\
                  </div>\
                  <div class="form-group row col-12">\
                    <label for="" class="col-md-4">Deskripsi Parameter Uji / Kalibrasi</label>\
                    <div class="input-group col-8">\
                      <textarea name="transaksi_detail_deskripsi_parameter[]" id="transaksi_detail_deskripsi_parameter" cols="3" rows="3" class="form-control" placholder="Analisa Cu, Pb, Uji Aplikasi, Analisa Kimia / Kalibrasi Suhu Range 10 Derajat C, 20 Derajat C"></textarea>\
                    </div>\
                  </div>\
                  <div class="form-group row col-12">\
                        <label for="" class="col-md-4">Catatan Pengajuan</label>\
                        <div class="input-group col-8">\
                          <textarea name="transaksi_detail_catatan[]" id="transaksi_detail_catatan" cols="3" rows="3" class="form-control" placeholder="Untuk kebutuhan Extra Cek Pabrik NPK 5"></textarea>\
                        </div>\
                      </div>\
                </div>\
                <div class="col-6">\
                  <div class="form-group row col-12">\
                    <label for="" class="col-md-4">Attachment</label>\
                    <div class="input-group col-8">\
                      <input type="file" name="transaksi_detail_attachment[]" id="transaksi_detail_attachment" class="form-control">\
                    </div>\
                  </div>\
                  <div class="form-group row col-12">\
                    <label for="" class="col-md-4">Foto Sample</label>\
                    <div class="input-group col-8">\
                      <input type="file" name="transaksi_detail_file[]" id="transaksi_detail_file" class="form-control">\
                    </div>\
                  </div>\
                </div>\
              </div>\
            </div>';

      $(".div_item").append(addRow);
      // $('.select2').select2()
      $('#jenis_id' + random).select2({
        placeholder: 'Pilih',
        ajax: {
          delay: 250,
          url: '<?= base_url('sample/request/getJenisSampleUji') ?>',
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

      /* Jenis Diklik */
      $('#jenis_id' + random).on('select2:select', function(e) {
        var data = e.params.data;

        fun_parameter(data.parameter);
      });
      /* Jenis Diklik */

      /* Jenis Pekerjaan */
      $('#jenis_pekerjaan_id' + random).select2({
        placeholder: 'Pilih',
        ajax: {
          delay: 250,
          url: '<?= base_url('sample/request/getJenisPekerjaan') ?>',
          dataType: 'json',
          type: 'GET',
          data: function(params) {
            var queryParameters = {
              sample_pekerjaan_nama: params.term
            }

            return queryParameters;
          }
        }
      });
      /* Jenis Pekerjaan */

      $('.select2-selection').css('height', '37px');
      $('.select2').css('width', '100%');

      // index = index + 1;
      // console.log(index);

    })

    // render hapus item
    $(document).on('click', '#remove_item', function() {
      $(this).closest('.div_item_baru').remove();
    })
    // render hapus item

    // render save item
    $('#form_item').on('submit', function(e) {
      e.preventDefault();

      var set_data = new FormData($('#form_item')[0]);
      set_data.append('transaksi_id', $('#transaksi_id').val());
      set_data.append('transaksi_non_rutin_id', $('#transaksi_non_rutin_id').val());

      if ($('#transaksi_detail_id').val() == '') var url = '<?= base_url('sample/request/insertRequestDetail') ?>'
      else var url = '<?= base_url('sample/request/updateRequestDetail') ?>'

      $.ajax({
        type: "POST",
        url: url,
        data: set_data,
        dataType: "HTML",
        contentType: false,
        processData: false,
        cache: false,
        success: function(response) {
          // fun_edit_item();
          toastr.success('Berhasil');
        }
      });
    })
    // render save item

    // Ajukan
    $('#ajukan').on('click', function(e) {
      e.preventDefault();

      var set_data = new FormData($('#form_request')[0]);

      if ($('#is_new').val() == '') var url = '<?= base_url('sample/request/insertAjukan') ?>'
      else var url = '<?= base_url('sample/request/updateAjukan') ?>'

      $.ajax({
        type: "POST",
        url: url,
        data: set_data,
        dataType: "HTML",
        contentType: false,
        processData: false,
        cache: false,
        success: function(response) {
          if (response) {
            toastr.error(response);
          } else {
            // location.href = '<?= base_url('sample/request/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>'
          }
        }
      });
    })
    // Ajukan


    // Ajukan
    $('#draft').on('click', function(e) {
      e.preventDefault();

      var set_data = new FormData($('#form_request')[0]);

      if ($('#is_new').val() == '') var url = '<?= base_url('sample/request/insertDraft') ?>'
      else var url = '<?= base_url('sample/request/updateDraft') ?>'

      $.ajax({
        type: "POST",
        url: url,
        data: set_data,
        dataType: "HTML",
        contentType: false,
        processData: false,
        cache: false,
        success: function(response) {
          if (response) {
            toastr.error(response);
          } else {
            location.href = '<?= base_url('sample/request/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>'
          }
        }
      });
    })
    // Ajukan

    $('#edit').on('click', function(e) {
      e.preventDefault();
      var set_data = new FormData($('#form_request')[0]);

      var url = '<?= base_url('sample/request/updateDraft') ?>';

      $.ajax({
        url: url,
        type: 'POST',
        dataType: 'HTML',
        data: set_data,
        contentType: false,
        processData: false,
        cache: false,
        beforeSend: function() {
          $('#loading_form').show();
          $('#close').hide();
          $('#ajukan').hide();
          $('#draft').hide();
          $('#edit').hide();
        },
        complete: function(xhr, textStatus) {
          //called when complete
        },
        success: function(data, textStatus, xhr) {
          if (response) {
            toastr.error(response);
          } else {
            location.href = '<?= base_url('sample/request/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>'
          }
          //called when successful
        },
        error: function(xhr, textStatus, errorThrown) {}
      });
    })

    $('#review').on('click', function(e) {
      e.preventDefault();
      var set_data = new FormData($('#form_request')[0]);

      var url = '<?= base_url('sample/request/insertProces') ?>';

      $.ajax({
        url: url,
        type: 'POST',
        dataType: 'HTML',
        data: set_data,
        contentType: false,
        processData: false,
        cache: false,
        beforeSend: function() {
          $('#loading_form').show();
          $('#review').hide();
          $('#back').hide();
          $('#reject').hide();
          $('#ajukan').hide();
          $('#draft').hide();
          $('#edit').hide();
        },
        complete: function(xhr, textStatus) {
          //called when complete
        },
        success: function(data, textStatus, xhr) {
          // if (response) {
          // toastr.error(response);
          // } else {
          location.href = '<?= base_url('sample/request/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>'
          // }
        },
        error: function(xhr, textStatus, errorThrown) {}
      });
    })

    $('#approve').on('click', function(e) {
      e.preventDefault();
      var set_data = new FormData($('#form_request')[0]);

      var url = '<?= base_url('sample/request/insertProces') ?>';

      $.ajax({
        url: url,
        type: 'POST',
        dataType: 'HTML',
        data: set_data,
        contentType: false,
        processData: false,
        cache: false,
        beforeSend: function() {
          $('#loading_form').show();
          $('#review').hide();
          $('#back').hide();
          $('#reject').hide();
          $('#ajukan').hide();
          $('#draft').hide();
          $('#edit').hide();
        },
        complete: function(xhr, textStatus) {
          //called when complete
        },
        success: function(data, textStatus, xhr) {
          // if (response) {
          // toastr.error(response);
          // } else {
          location.href = '<?= base_url('sample/request/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>'
          // }
        },
        error: function(xhr, textStatus, errorThrown) {}
      });
    })

    $('#disposisi_vp').on('click', function(e) {
      e.preventDefault();
      var set_data = new FormData($('#form_request')[0]);

      var url = '<?= base_url('sample/request/insertProces') ?>';

      $.ajax({
        url: url,
        type: 'POST',
        dataType: 'HTML',
        data: set_data,
        contentType: false,
        processData: false,
        cache: false,
        beforeSend: function() {
          $('#loading_form').show();
          $('#review').hide();
          $('#back').hide();
          $('#reject').hide();
          $('#ajukan').hide();
          $('#draft').hide();
          $('#edit').hide();
        },
        complete: function(xhr, textStatus) {
          //called when complete
        },
        success: function(data, textStatus, xhr) {
          // if (response) {
          // toastr.error(response);
          // } else {
          location.href = '<?= base_url('sample/request/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>'
          // }
        },
        error: function(xhr, textStatus, errorThrown) {}
      });
    })

    $('#disposisi_avp').on('click', function(e) {
      e.preventDefault();
      var set_data = new FormData($('#form_request')[0]);

      var url = '<?= base_url('sample/request/insertProces') ?>';

      $.ajax({
        url: url,
        type: 'POST',
        dataType: 'HTML',
        data: set_data,
        contentType: false,
        processData: false,
        cache: false,
        beforeSend: function() {
          $('#loading_form').show();
          $('#review').hide();
          $('#back').hide();
          $('#reject').hide();
          $('#ajukan').hide();
          $('#draft').hide();
          $('#edit').hide();
        },
        complete: function(xhr, textStatus) {
          //called when complete
        },
        success: function(data, textStatus, xhr) {
          // if (response) {
          // toastr.error(response);
          // } else {
          location.href = '<?= base_url('sample/request/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>'
          // }
        },
        error: function(xhr, textStatus, errorThrown) {}
      });
    })



    // FORM
    /* Select2 */
    // keterangan
    // keterangan kepada
    $('#keterangan_kepada').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('api/departemen/getDepartemenList') ?>',
        dataType: 'json',
        type: 'GET',
        data: function(params) {
          var queryParameters = {
            param_search: params.term
          }

          return queryParameters;
        }
      }
    });
    // keterangan kepada

    // keterangan dari
    $('#keterangan_dari').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('api/departemen/getDepartemenList') ?>',
        dataType: 'json',
        type: 'GET',
        data: function(params) {
          var queryParameters = {
            param_search: params.term
          }

          return queryParameters;
        }
      }
    });
    // keterangan dari
    // keterangan

    $('#transaksi_jenis_surat').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('master/template_keterangan/getJenisTemplateList') ?>',
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



    /* Peminta Jasa */
    $('#peminta_jasa_id').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('sample/request/getPemintaJasa') ?>',
        dataType: 'json',
        type: 'GET',
        data: function(params) {
          var queryParameters = {
            peminta_jasa_nama: params.term
          }

          return queryParameters;
        }
      }
    });
    /* Peminta Jasa */

    /* Peminta Jasa */
    $('#peminta_jasa_id').on('select2:select', function(e) {
      var data = e.params.data;

      fun_pic(data.id);
    });
    /* Peminta Jasa */

    $('#transaksi_detail_pic_pengirim').select2({
      placeholder: 'Pilih Peminta Jasa Terlebih Dahulu'
    })

    /* Jenis */

    /* Jenis */

    $('#jenis_id').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('sample/request/getJenisSampleUji') ?>',
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

    /* Jenis Diklik */
    $('#jenis_id').on('select2:select', function(e) {
      var data = e.params.data;

      fun_parameter(data.parameter);
    });
    /* Jenis Diklik */

    /* Identitas */
    $('#identitas_id').select2({
      placeholder: 'Pilih Jenis Sample Dahulu',
    });
    /* Identitas */

    /* Identitas Diklik */
    $('#identitas_id').on('select2:select', function(e) {
      var data = e.params.data;

      $.getJSON('<?= base_url('master/jenis_sample_uji/getSampleIdentitas') ?>', {
        identitas_id: data.id
      }, function(json) {
        $('#transaksi_detail_parameter').val(json.identitas_parameter);
      });
    });
    /* Identitas Diklik */

    /* Jenis Pekerjaan */
    $('#jenis_pekerjaan_id').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('sample/request/getJenisPekerjaan') ?>',
        dataType: 'json',
        type: 'GET',
        data: function(params) {
          var queryParameters = {
            sample_pekerjaan_nama: params.term
          }

          return queryParameters;
        }
      }
    });
    /* Jenis Pekerjaan */

    /* Jenis Pekerjaan */
    $('#transaksi_klasifikasi_id').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('master/klasifikasi_sample/getKlasifikasiSampleList') ?>',
        dataType: 'json',
        type: 'GET',
        data: function(params) {
          var queryParameters = {
            klasifikasi_nama: params.term
          }

          return queryParameters;
        }
      }
    });
    /* Jenis Pekerjaan */

    /* Template Keterangan */
    $('#template_keterangan_id').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('master/template_keterangan/getTemplateKeteranganList') ?>',
        dataType: 'json',
        type: 'GET',
        data: function(params) {
          var queryParameters = {
            keterangan_nama: params.term
          }

          return queryParameters;
        }
      }
    });
    /* Template Keterangan */

    /* Template Keterangan diklik */
    $('#template_keterangan_id').on('select2:select', function(e) {
      var data = e.params.data;

      renderTemplate(data.id, data.jenis);
    });
    /* Template Keterangan diklik */

    // Sifat
    $('#transaksi_sifat').select2({
      placeholder: 'Pilih',
    })
    // Sifat

    // Kecepatan Tanggap
    $('#transaksi_kecepatan_tanggap').select2({
      placeholder: 'Pilih',
    })
    // Kecepatan Tanggap

    // reviewer
    $('#transaksi_reviewer').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('api/user/getUserList?direct_superior=' . $this->session->userdata('user_direct_superior')) ?>',
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
    // reviewer

    /* Reviewer Diklik */
    $('#transaksi_reviewer').on('select2:select', function(e) {
      var data = e.params.data;

      var unit_id_cek = '<?= $this->session->userdata('user_unit_id') ?>';

      if (unit_id_cek == 'E44000') {
        var direct_superior = '<?= $this->session->userdata('user_direct_superior') ?>';
      } else {
        var direct_superior = data.direct_superior;
      }

      gantiApprover(direct_superior, data.unit_id);

      gantiTujuan(direct_superior, data.unit_id)
    });
    /* Reviewer Diklik */

    // Approver
    $('#transaksi_approver').select2({
      placeholder: 'Silahkan Pilih Reviewer Dahulu',
    })
    // Approver

    $('#transaksi_drafter').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('api/user/getUserList?user_nik_sap=' . $this->session->userdata('user_nik_sap')) ?>',
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

    $('#transaksi_detail_disposisi').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('sample/approve/getSeksi') ?>',
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

    $('#transaksi_detail_petugas').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('sample/notifikasi/getUser') ?>',
        dataType: 'json',
        type: 'GET',
        data: function(params) {
          var queryParameters = {
            user_nama_lengkap: params.term
          }

          return queryParameters;
        }
      }
    });

    $('#transaksi_tujuan').select2({
      placeholder: 'Silahkan Pilih Reviewer Dahulu',
    })

    if ('<?= $this->session->userdata('user_unit_id') != null ?>') {
      // $('#peminta_jasa_id').append('<option selected value="<?= $this->session->userdata('user_unit_id') ?>"> <?= $this->session->userdata('user_departemen'); ?> </option>');
      // $('#transaksi_detail_pic_pengirim').append('<option selected value="<?= $this->session->userdata('user_nik_sap') ?>"> <?= $this->session->userdata('user_nik_sap') . ' - ' . $this->session->userdata('user_nama') . ' - ' . $this->session->userdata('user_post_title'); ?> </option>');
      // $('#transaksi_detail_pic_pengirim').trigger('change');
    }

    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');
    /* Select2 */
    // FORM
    // Validasi dan Insert

    // Validasi dan Insert
  })

  // approver
  function gantiApprover(direct_superior, unit_id) {
    $('#transaksi_approver').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('api/user/getUserList?direct_superior=') ?>' + direct_superior + '&unit_id=' + unit_id,
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
  }
  // approver

  // tujuan
  function gantiTujuan(direct_superior, unit_id) {
    $('#transaksi_tujuan').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('api/user/getUserList?direct_superior=') ?>' + direct_superior + '&unit_id=' + unit_id,
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
  }
  // tujuan

  // PIC pengirim ID
  function gantiPICPengirim(id) {
    $('#transaksi_pic_pengirim_id').val(id);
  }
  // PIC pengirim ID

  /* Fun PIC */
  function fun_pic(id) {
    $('#transaksi_detail_pic_pengirim').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('api/user/getUserList?user_unit_id=') ?>' + id,
        dataType: 'json',
        type: 'GET',
        data: function(params) {
          var queryParameters = {
            param_search: params.term
          }

          return queryParameters;
        }
      }
    });

    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');
  }
  /* Fun PIC */

  function fun_parameter(parameter) {
    $('#transaksi_detail_parameter').val(parameter);
  }


  // init select2 form
  // init select2 form



  // render simpan item
  // EXTRA
  function fun_loading() {
    var simplebar = new Nanobar();
    simplebar.go(100);
  }
  // EXTRA
</script>