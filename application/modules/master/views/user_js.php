<script type="text/javascript">
  $(function() {
    fun_loading();

    /* Isi Table Seksi */
    $('#table_seksi').DataTable({
      "scrollX": true,
      "lengthMenu": [
        [5, 10, 25, 50, -1],
        [5, 10, 25, 50, "All"]
      ],
      "dom": 'lBfrtip',
      "buttons": ["csv", "pdf", "excel", "copy", "print"],
      "ajax": {
        "url": "<?= base_url('master/user/getSeksi') ?>",
        "dataSrc": ""
      },
      "fnRowCallback": function(data, type, full, meta) {
        $(data).attr('class', 'warna');;
      },
      "columns": [{
          "data": "seksi_kode"
        },
        {
          "data": "seksi_nama"
        },
        // {
        //   "data": "user_nama_lengkap"
        // },
        {
          "render": function(data, type, full, meta) {
            return full.when_create + ' - ' + full.who_create;
          }
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:;" id="' + full.seksi_id + '" title="Kasie" onclick="fun_tambah_kasie(this.id)"><i class="fa fa-plus-circle" data-toggle="modal" data-target="#modal_kasie" style="color: green;"></i></a></center>';
          }
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:;" id="' + full.seksi_id + '" title="Seksi" onclick="fun_detail_seksi(this.id)"><i class="fa fa-search"></i></a></center>';
          }
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:;" id="' + full.seksi_id + '" title="Edit" onclick="fun_edit_seksi(this.id)"><i class="fa fa-edit" data-toggle="modal" data-target="#modal_seksi" style="color: orange;"></i></a></center>';
          }
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:;" id="' + full.seksi_id + '" title="Edit" onclick="fun_delete_seksi(this.id)"><i class="fa fa-trash" style="color: red;"></i></a></center>';
          }
        },
      ]
    });
    /* Isi Table Seksi */

    /* Isi Table */
    $('#table').DataTable({
      "scrollX": true,
      "lengthMenu": [
        [5, 10, 25, 50, -1],
        [5, 10, 25, 50, "All"]
      ],
      "dom": 'lBfrtip',
      "buttons": ["csv", "pdf", "excel", "copy", "print"],
      "ajax": {
        "url": "<?= base_url('master/user/getUser?seksi_id=0') ?>",
        "dataSrc": ""
      },
      "columns": [{
          "data": "role_nama"
        },
        {
          "data": "seksi_nama"
        },
        {
          "data": "user_username"
        },
        {
          "data": "user_nama_lengkap"
        },
        {
          "data": "user_tempat_lahir"
        },
        {
          "render": function(data, type, full, meta) {
            return (full.user_tgl_lahir) ? full.user_tgl_lahir.split("-").reverse().join("-") : '';
          }
        },
        {
          "render": function(data, type, full, meta) {
            return full.when_create + ' - ' + full.who_create;
          }
        },
        {
          "render": function(data, type, full, meta) {
            return (full.user_tanda_tangan != null) ? '<center><a href="javascript:;" id="' + full.user_tanda_tangan + '" title="Lihat" onclick="func_lihat(this.id)"><i style="color:red" class="fa fa-image" data-toggle="modal" data-target="#modal_lihat"></i></a></center>' : '';
          }
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:;" id="' + full.user_id + '" title="Edit" onclick="fun_edit(this.id)"><i class="fa fa-edit" data-toggle="modal" data-target="#modal" style="color: orange;"></i></a></center>';
          }
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:;" id="' + full.user_id + '" title="Edit" onclick="fun_delete(this.id)"><i class="fa fa-trash" style="color: red;"></i></a></center>';
          }
        },
      ]
    });
    /* Isi Table */

    /* Tanggal */
    $(".tanggal").daterangepicker({
      showDropdowns: true,
      singleDatePicker: true,
      locale: {
        format: 'DD-MM-YYYY'
      }
    });
    /* Tanggal */

    /* Select2 */
    $('#role_id').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('master/user/getRole') ?>',
        dataType: 'json',
        type: 'GET',
        data: function(params) {
          var queryParameters = {
            role_nama: params.term
          }

          return queryParameters;
        }
      }
    });

    $('#seksi_id_user').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('master/user/getSeksiUser') ?>',
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

    /* Get Kasie */
    $('#kasie_nama').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('master/user/getNamaKasie') ?>',
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

    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');
    /* Select2 */
  });

  /* Fun Tambah */
  function fun_tambah() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $('#id_seksi').val($('#temp_seksi_id').val());
      }
    });
  }
  /* Fun Tambah */

  /* View Update */
  function fun_edit(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $('#simpan').css('display', 'none');
        $('#edit').css('display', 'block');
        $('#div_seksi_id_user').css('display', 'block');
        $.getJSON('<?= base_url('master/user/getUser') ?>', {
          user_id: id
        }, function(json) {
          $.each(json, function(index, val) {
            $('#' + index).val(val);
            console.log(json, val);
          });
          $('#user_password_lama').val(json.user_password);

          $('#role_id').append('<option selected value="' + json.role_id + '">' + json.role_nama + '</option>');
          $('#role_id').select2('data', {
            id: json.role_id,
            text: json.role_nama
          });
          $('#role_id').trigger('change');

          $('#seksi_id_user').append('<option selected value="' + json.seksi_id + '">' + json.seksi_nama + '</option>');
          $('#seksi_id_user').select2('data', {
            id: json.seksi_id,
            text: json.seksi_nama
          });
          $('#seksi_id_user').trigger('change');
        });
      }
    });
  }
  /* View Update */

  /* Proses */
  $("#form_modal").on("submit", function(e) {
    e.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        if ($('#user_id').val() != '') var url = '<?= base_url('master/user/updateUser') ?>';
        else var url = '<?= base_url('master/user/insertUser') ?>';

        var user_tanda_tangan = $('#user_tanda_tangan').prop('files')[0];

        var data = new FormData();
        data.append('user_nama_lengkap', $('#user_nama_lengkap').val());
        data.append('user_tempat_lahir', $('#user_tempat_lahir').val());
        data.append('user_tgl_lahir', $('#user_tgl_lahir').val());
        data.append('user_tanda_tangan', user_tanda_tangan);
        data.append('role_id', $('#role_id').val());
        data.append('seksi_id_user', $('#seksi_id_user').val());
        data.append('user_username', $('#user_username').val());
        data.append('user_password', $('#user_password').val());
        data.append('user_password_lama', $('#user_password_lama').val());
        data.append('user_id', $('#user_id').val());
        data.append('id_seksi', $('#id_seksi').val());

        e.preventDefault();
        $.ajax({
          url: url,
          data: data,
          type: 'POST',
          processData: false,
          contentType: false,
          success: function(isi) {
            $('#close').click();
            toastr.success('Berhasil');
          }
        });
      }
    })
  });
  /* Proses */

  /* Fun Delete */
  function fun_delete(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $.confirmModal('Apakah anda yakin akan menghapusnya?', function(el) {
          $.get('<?= base_url('master/user/deleteUser') ?>', {
            user_id: id
          }, function(data) {
            $('#close').click();
            toastr.success('Berhasil');
          });
        });
      }
    });
  }
  /* Fun Delete */

  function func_lihat(data) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        fun_loading();
        $('#document').remove();
        $('#div_document').append('<embed src="<?= base_url('document/') ?>' + data + '#toolbar=0" frameborder="0" id="document" width="100%" height="600px"></embed>');
      }
    });
  }

  /* Fun Close */
  function fun_close() {
    $('#simpan').css('display', 'block');
    $('#edit').css('display', 'none');
    $('#div_seksi_id_user').css('display', 'none');
    $('#form_modal')[0].reset();
    $("#role_id").empty();
    $('#table').DataTable().ajax.reload();
    fun_loading();
  }
  /* Fun Close */

  $('#modal').on('hidden.bs.modal', function(e) {
    fun_close();
  });


  /* Tambah Kasie */
  function fun_tambah_kasie(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $('#simpan_kasie').css('display', 'block');
        // $('#edit_kasie').css('display', 'block');
        $.getJSON('<?= base_url('master/user/getSeksi') ?>', {
          seksi_id: id
        }, function(json) {
          $.each(json, function(index, val) {
            var cek = $('#' + index).val(val);
          });
          $('#identitas_kasie_nama').val(json.seksi_id);
          $('#kasie_nama').val(json.seksi_kepala);
        });
      }
    });
  }

  /* Sumbit Kasie */
  $('#form_modal_kasie').on('submit', function(e) {
    e.preventDefault();
    $.getJSON("<?= base_url() ?>login/login/checkLogin", {},
      function(data, textStatus, jqXHR) {
        if (!data.user_id) {
          fun_notifLogout();
        } else {
          $.ajax({
            type: "POST",
            dataType: "HTML",
            url: "<?= base_url('master/user/updateKasieNama') ?>",
            data: $('#form_modal_kasie').serialize(),
            processData: false,
            cache: false,
            beforeSend: function() {
              $('#simpan_kasie').show();
            },
            success: function(response) {
              $('#close_kasie').click();
              fun_close_kasie();
            }
          });
        }
      }
    );
  })
  /* Sumbit Kasie */


  /* View Update Seksi */
  function fun_edit_seksi(id) {

    $('#simpan_seksi').css('display', 'none');
    $('#edit_seksi').css('display', 'block');
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $.getJSON('<?= base_url('master/user/getSeksi') ?>', {
          seksi_id: id
        }, function(json) {
          $.each(json, function(index, val) {
            $('#' + index).val(val);
          });

          if (json.is_disposisi == 'y') $('#is_disposisi').prop('checked', true);
          $('#is_disposisi').val('y');
        });
      }
    });
  }
  /* View Update Seksi */

  /* Proses Seksi */
  $("#form_modal_seksi").on("submit", function(e) {
    e.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        if ($('#seksi_id').val() != '') var url = '<?= base_url('master/user/updateSeksi') ?>';
        else var url = '<?= base_url('master/user/insertSeksi') ?>';

        e.preventDefault();
        $.ajax({
          url: url,
          data: $('#form_modal_seksi').serialize(),
          type: 'POST',
          dataType: 'html',
          success: function(isi) {
            $('#close_seksi').click();
            toastr.success('Berhasil');
          }
        });
      }
    })
  });
  /* Proses Seksi */

  /* Fun Delete Seksi */
  function fun_delete_seksi(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $.confirmModal('Apakah anda yakin akan menghapusnya?', function(el) {
          $.get('<?= base_url('master/user/deleteSeksi') ?>', {
            seksi_id: id
          }, function(data) {
            $('#close_seksi').click();
            toastr.success('Berhasil');
          });
        });
      }
    });
  }
  /* Fun Delete Seksi */

  /* Fun Close Seksi */
  function fun_close_seksi() {
    $('#simpan_seksi').css('display', 'block');
    $('#edit_seksi').css('display', 'none');
    $('#form_modal_seksi')[0].reset();
    $('#is_disposisi').val('y');
    $('#table_seksi').DataTable().ajax.reload();
    fun_loading();
  }
  /* Fun Close Seksi */

  $('#modal_seksi').on('hidden.bs.modal', function(e) {
    fun_close_seksi();
  });

  /* Fun Close Kasie */
  function fun_close_kasie() {
    $('#simpan_seksi').css('display', 'block');
    $('#edit_seksi').css('display', 'none');
    $('#form_modal_kasie')[0].reset();
    $('#table_seksi').DataTable().ajax.reload(null, false);
    $("#kasie_nama").empty();
    fun_loading();
  }
  /* Fun Close Kasie */

  $('#modal_kasie').on('hidden.bs.modal', function(e) {
    fun_close_kasie();
  });


  /* Fun Detail */
  function fun_detail_seksi(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $('#div_detail').css('display', 'block');
        $('#table').DataTable().ajax.url('<?= base_url('master/user/getUser?id_seksi=') ?>' + id).load();
        $('#temp_seksi_id').val(id);
        $('html, body').animate({
          scrollTop: $("#div_detail").offset().top
        }, 10);
        setTimeout(function() {
          $('.warna').removeAttr('style')
        }, 500);
        setTimeout(function() {
          $('#' + id).parents('tr').attr('style', 'color: red')
        }, 1000);
      }
    });
  }
  /* Fun Detail */

  function fun_loading() {
    var simplebar = new Nanobar();
    simplebar.go(100);
  }
</script>