<script type="text/javascript">
	$(function () {
    fun_loading();

    /* Isi Table */	
      $('#table').DataTable({
        "scrollX": true,
        "lengthMenu":[[5,10,25,50,-1],[5,10,25,50,"All"]],
        "dom": 'lBfrtip',
        "buttons": ["csv", "pdf", "excel","copy","print"],
        "ajax": {
            "url": "<?= base_url() ?>/master/role/getRole",
            "dataSrc": ""
          },
          "columns": [
            {"data": "role_kode"},
            {"data": "role_nama"},
            {"render": function ( data, type, full, meta ) {
              return full.when_create+' - '+full.who_create;
              }
            },
            {"render": function ( data, type, full, meta ) {
              return '<center><a href="javascript:;" id="'+full.role_id+'" title="Menu" onclick="fun_menu(this.id)"><i class="fa fa-bars" data-toggle="modal" data-target="#modal_menu"></i></a></center>';
              }
            },
            {"render": function ( data, type, full, meta ) {
              return '<center><a href="javascript:;" id="'+full.role_id+'" title="Edit" onclick="fun_edit(this.id)"><i class="fa fa-edit" data-toggle="modal" data-target="#modal" style="color: orange;"></i></a></center>';
              }
            },
            {"render": function ( data, type, full, meta ) {
              return '<center><a href="javascript:;" id="'+full.role_id+'" title="Edit" onclick="fun_delete(this.id)"><i class="fa fa-trash" style="color: red;"></i></a></center>';
              }
            },
          ]
      });
    /* Isi Table */
	})

  /* View Update */
    function fun_edit(id) {
      $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if(!json.user_id){
        fun_notifLogout();
      }else{
      $('#simpan').css('display', 'none');
      $('#edit').css('display', 'block');
      $.getJSON('<?= base_url('master/role/getRole') ?>', {role_id: id}, function(json) {
        $.each(json, function(index, val) {
          $('#'+index).val(val);
        });
      });
    }
    });
    }
  /* View Update */

  /* Proses */
    $("#form_modal").on("submit", function (e) {
      e.preventDefault();
      $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if(!json.user_id){
        fun_notifLogout();
      }else{
      if ($('#role_id').val() != '') var url = '<?= base_url('master/role/updateRole') ?>';
      else var url = '<?= base_url('master/role/insertRole') ?>';

      e.preventDefault();
      $.ajax({
        url:url,
        data:$('#form_modal').serialize(),
        type:'POST',
        dataType: 'html',
        beforeSend:function () {
          $('#loading_form').css('display', 'block');
          $('#simpan').css('display', 'none');
        },success:function(isi) {
          $('#close').click();
          toastr.success('Berhasil');
        }
      });
    }
    });
    });
  /* Proses */

  /* Fun Delete */
    function fun_delete(id) {
      $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if(!json.user_id){
        fun_notifLogout();
      }else{
      $.confirmModal('Apakah anda yakin akan menghapusnya?', function(el) {
        $.get('<?= base_url('master/role/deleteRole') ?>', {role_id: id}, function(data) {
          $('#close').click();
          toastr.success('Berhasil');
        });
      });
    }
    });
    }
  /* Fun Delete */

  /* Fun Close */
    function fun_close() {
      $('#simpan').css('display', 'block');
      $('#edit').css('display', 'none');
      $('#loading_form').css('display', 'none');
      $('#form_modal')[0].reset();
      $('#table').DataTable().ajax.reload();
      fun_loading();
    }
  /* Fun Close */

  $('#modal').on('hidden.bs.modal', function (e) {
    fun_close();
  });

  /* Proses Menu */
    $("#form_modal_menu").on("submit", function (e) {
      e.preventDefault();
      $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if(!json.user_id){
        fun_notifLogout();
      }else{
      url = '<?= base_url('master/role/insertMenuRole') ?>';

      e.preventDefault();
      $.ajax({
        url:url,
        data:$('#form_modal_menu').serialize(),
        type:'POST',
        dataType: 'html',
        success:function(isi) {
          $('#close_menu').click();
          toastr.success('Berhasil');
        }
      });
    }
    });
    });
  /* Proses Menu */

  /* Fun Menu */
    function fun_menu(id) {
      $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if(!json.user_id){
        fun_notifLogout();
      }else{
      $.getJSON('<?= base_url('master/role/getMenuRole') ?>', {role_id: id}, function(json) {
        $.each(json, function(index, val) {
          $('#'+val.menu_id).prop('checked', true);
        });
        $('#role_id_temp').val(id);
      });
    }
    });
    }
  /* Fun Menu */

  /* Fun Close Menu */
    function fun_close_menu() {
      $('#form_modal_menu')[0].reset();
      $('#table').DataTable().ajax.reload();
      fun_loading();
    }
  /* Fun Close Menu */

  $('#modal_menu').on('hidden.bs.modal', function (e) {
    fun_close_menu();
  });

  function fun_loading() {
    var simplebar = new Nanobar();
    simplebar.go(100);
  }
</script>