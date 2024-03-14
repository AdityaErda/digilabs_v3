<script type="text/javascript">
  $(function () {
    /* Isi Table */ 
      $('#table').DataTable({
        "scrollX": true,
        "ajax": {
            "url": "<?= base_url() ?>/master/barang_material/getBarangMaterial",
            "dataSrc": ""
          },
          "columns": [
            {"data" : "item_kode"},
            {"data" : "item_nama"},
            {"data" : "item_katalog_number"},
            {"data" : "item_merk"},
            {"data" : "jenis_nama"},
            {"data" : "gl_account_nama"},
            {"data" : "item_harga"},
            {"render": function ( data, type, full, meta ) {
              return full.when_create+' - '+full.who_create;
              }
            },
            {"render": function ( data, type, full, meta ) {
              return '<center><a href="javascript:;" id="'+full.item_id+'" title="Edit" onclick="fun_detail(this.id)"><i class="fa fa-search"></i></a></center>';
              }
            },
            {"render": function ( data, type, full, meta ) {
              return '<center><a href="javascript:;" id="'+full.item_id+'" title="Edit" onclick="fun_history(this.id)"><i class="fa fa-history"></i></a></center>';
              }
            },
            {"render": function ( data, type, full, meta ) {
              return '<center><a href="javascript:;" id="'+full.item_id+'" title="Edit" onclick="fun_edit(this.id)"><i class="fa fa-edit" data-toggle="modal" data-target="#modal"></i></a></center>';
              }
            },
            {"render": function ( data, type, full, meta ) {
              return '<center><a href="javascript:;" id="'+full.item_id+'" title="Edit" onclick="fun_delete(this.id)"><i class="fa fa-trash"></i></a></center>';
              }
            },
          ]
      });
    /* Isi Table */

    /* Isi Table Detail */ 
      $('#table_detail').DataTable({
        "scrollX": true,
        "ajax": {
          "url": "<?= base_url('master/barang_material/getKomposisi?item_id=0') ?>",
          "dataSrc": ""
        },
        "columns": [
          {"data" : "nama_item"},
          {"data" : "komposisi_persen"},
          {"data" : "komposisi_harga"},
          {"render": function ( data, type, full, meta ) {
            return full.when_create+' - '+full.who_create;
            }
          },
          {"render": function ( data, type, full, meta ) {
            return '<center><a href="javascript:;" id="'+full.komposisi_id+'" title="Edit" onclick="fun_edit_detail(this.id)"><i class="fa fa-edit" data-toggle="modal" data-target="#modal_detail"></i></a></center>';
            }
          },
          {"render": function ( data, type, full, meta ) {
            return '<center><a href="javascript:;" id="'+full.komposisi_id+'" title="Edit" onclick="fun_delete_detail(this.id)"><i class="fa fa-trash"></i></a></center>';
            }
          },
        ]
      });
    /* Isi Table Detail */

    /* Isi Table History */ 
      $('#table_history').DataTable({
        "scrollX": true,
        "ordering": false,
        "ajax": {
          "url": "<?= base_url('master/barang_material/getHistory?item_id=0') ?>",
          "dataSrc": ""
        },
        "columns": [
          {render: function ( data, type, full, meta ) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }},
          {"data" : "barang_harga"},
          {"render": function ( data, type, full, meta ) {
            return full.log_who+' - '+full.log_when;
            }
          },
        ]
      });
    /* Isi Table History */

    /* Select2 */
      $('#jenis_id').select2({
        placeholder: 'Pilih',
        ajax: {
          delay: 250,
          url: '<?= base_url('master/barang_material/getJenis') ?>',
          dataType: 'json',
          type: 'GET',
          data: function (params) {
            var queryParameters = {
              material_nama: params.term
            }

            return queryParameters;
          }
        }
      });

      $('#gl_account_id').select2({
        placeholder: 'Pilih',
        ajax: {
          delay: 250,
          url: '<?= base_url('master/barang_material/getGlAccount') ?>',
          dataType: 'json',
          type: 'GET',
          data: function (params) {
            var queryParameters = {
              gl_account_nama: params.term
            }

            return queryParameters;
          }
        }
      });

      $('#komposisi_item').select2({
        placeholder: 'Pilih',
        ajax: {
          delay: 250,
          url: '<?= base_url('master/barang_material/getItem') ?>',
          dataType: 'json',
          type: 'GET',
          data: function (params) {
            var queryParameters = {
              item_nama: params.term
            }

            return queryParameters;
          }
        }
      });

      $('.select2-selection').css('height', '37px');
      $('.select2').css('width', '100%');
    /* Select2 */

      var ctx = document.getElementById('myChart').getContext('2d');
      var myChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: [],
          datasets: [{
            label: 'History',
            data: [],
            backgroundColor: ['rgba(255, 99, 132, 0.2)'],
            borderColor: ['rgba(255, 99, 132, 1)'],
            borderWidth: 1
          }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
  });

  /* View Update */
    function fun_edit(id) {
      $('#simpan').css('display', 'none');
      $('#edit').css('display', 'block');
      $.getJSON('<?= base_url('master/barang_material/getBarangMaterial') ?>', {item_id: id}, function(json) {
        $.each(json, function(index, val) {
          $('#'+index).val(val);
        });

        $('#jenis_id').append('<option selected value="'+json.jenis_id+'">'+json.jenis_nama+'</option>');
        $('#jenis_id').select2('data', {id:json.jenis_id, text:json.jenis_nama});
        $('#jenis_id').trigger('change');

        $('#gl_account_id').append('<option selected value="'+json.gl_account_id+'">'+json.gl_account_nama+'</option>');
        $('#gl_account_id').select2('data', {id:json.gl_account_id, text:json.gl_account_nama});
        $('#gl_account_id').trigger('change');
      });
    }
  /* View Update */

  /* Proses */
    $("#form_modal").on("submit", function (e) {
      if ($('#item_id').val() != '') var url = '<?= base_url('master/barang_material/updateBarangMaterial') ?>';
      else var url = '<?= base_url('master/barang_material/insertBarangMaterial') ?>';

      e.preventDefault();
      $.ajax({
        url:url,
        data:$('#form_modal').serialize(),
        type:'POST',
        dataType: 'html',
        success:function(isi) {
          $('#close').click();
        }
      });
    });
  /* Proses */

  /* Fun Delete */
    function fun_delete(id) {
      var result = confirm("Apakah anda yakin akan menghapusnya?");
      if (result) {
        $.get('<?= base_url('master/barang_material/deleteBarangMaterial') ?>', {item_id: id}, function(data) {
          $('#close').click();
        });
      }
    }
  /* Fun Delete */

  /* Fun Close */
    function fun_close() {
      $('#simpan').css('display', 'block');
      $('#edit').css('display', 'none');
      $('#form_modal')[0].reset();
      $("#jenis_id").empty();
      $("#gl_account_id").empty();
      $('#table').DataTable().ajax.reload();
      $('#table_detail').DataTable().ajax.reload();
    }
  /* Fun Close */

  $('#modal').on('hidden.bs.modal', function (e) {
    fun_close();
  });

  /* Fun History */
    function fun_history (id) {
      $('#div_history').css('display', 'block');
      $('#div_detail').css('display', 'none');
      $('#table_history').DataTable().ajax.url('<?= base_url('master/barang_material/getHistory?item_id=') ?>'+id).load();
      $('#id_item').val(id);
      $('html, body').animate({
        scrollTop: $("#div_history").offset().top
      }, 10);

      $.ajax({
        dataType: 'json',
        url: "<?= base_url('master/barang_material/getHistory?item_id=') ?>"+id,
        success: function(isi) {
          var myChart = new Chart(ctx).line(data, options);
          var label = [];
          var value = []

          $.each(isi, function(index, val) {
            label.push(val.log_when);
            value.push(val.barang_harga);
          });
          // process your data to pull out what you plan to use to update the chart
          // e.g. new label and a new data point
          
          // add new label and data point to chart's underlying data structures
          myChart.data.labels.push('1');
          chart.data.datasets.forEach((dataset) => {
              dataset.data.push('1');
          });
          // myChart.data.datasets[0].data.push(value);
          
          // re-render the chart
          myChart.update();
        }
      });
    }
  /* Fun History */

  /* Grafik History */

  /* Grafik History */

  /* Fun Detail */
    function fun_detail (id) {
      $('#div_history').css('display', 'none');
      $('#div_detail').css('display', 'block');
      $('#table_detail').DataTable().ajax.url('<?= base_url('master/barang_material/getKomposisi?item_id=') ?>'+id).load();
      $('#id_item').val(id);
      $('html, body').animate({
        scrollTop: $("#div_detail").offset().top
      }, 10);
    }
  /* Fun Detail */

  /* Fun Tambah Detail */
    function fun_tambah_detail() {
      $('#temp_item_id').val($('#id_item').val());
    }
  /* Fun Tambah Detail */

  /* View Update Detail */
    function fun_edit_detail(id) {
      $('#simpan_detail').css('display', 'none');
      $('#edit_detail').css('display', 'block');
      $.getJSON('<?= base_url('master/barang_material/getKomposisi') ?>', {komposisi_id: id}, function(json) {
        $.each(json, function(index, val) {
          $('#'+index).val(val);
        });
        $('#temp_item_id').val(json.item_id);

        $('#komposisi_item').append('<option selected value="'+json.komposisi_item+'">'+json.nama_item+' - '+json.harga_item+'</option>');
        $('#komposisi_item').select2('data', {id:json.komposisi_item, text:json.nama_item+' - '+json.harga_item});
        $('#komposisi_item').trigger('change');
      });
    }
  /* View Update Detail */

  /* Proses Detail */
    $("#form_modal_detail").on("submit", function (e) {
      if ($('#komposisi_id').val() != '') var url = '<?= base_url('master/barang_material/updateKomposisi') ?>';
      else var url = '<?= base_url('master/barang_material/insertKomposisi') ?>';

      e.preventDefault();
      $.ajax({
        url:url,
        data:$('#form_modal_detail').serialize(),
        type:'POST',
        dataType: 'html',
        success:function(isi) {
          $('#close_detail').click();
        }
      });
    });
  /* Proses Detail */

  /* Fun Delete Detail */
    function fun_delete_detail(id) {
      var result = confirm("Apakah anda yakin akan menghapusnya?");
      if (result) {
        $.get('<?= base_url('master/barang_material/deleteKomposisi') ?>', {komposisi_id: id}, function(data) {
          $('#close_detail').click();
        });
      }
    }
  /* Fun Delete Detail */

  /* Fun Close Detail */
    function fun_close_detail() {
      $('#simpan_detail').css('display', 'block');
      $('#edit_detail').css('display', 'none');
      $("#komposisi_item").empty();
      $('#form_modal_detail')[0].reset();
      $('#table_detail').DataTable().ajax.reload();
      $('#table').DataTable().ajax.reload();
    }
  /* Fun Close Detail */

  $('#modal_detail').on('hidden.bs.modal', function (e) {
    fun_close_detail();
  });
</script>