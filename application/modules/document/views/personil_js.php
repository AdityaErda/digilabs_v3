<script type="text/javascript">
  $(function() {
    /* Isi Table */
    $('#table').DataTable({
      // "ordering":false,
      "lengthMenu": [
        [5, 10, 25, 50, -1],
        [5, 10, 25, 50, "All"]
      ],
      "dom": 'lBfrtip',
      "buttons": ["csv", "pdf", "excel", "copy", "print"],
      "scrollX": true,
      "ajax": {
        "url": "<?= base_url() ?>document/personil/getDaftar",
        "dataSrc": ""
      },
      "columns": [{
          "data": "user_nama_lengkap"
        },
        {
          "data": "user_tempat_lahir"
        },
        {
          "data": "user_tgl_lahir"
        },
        {
          "render": function(data, type, full, meta) {
            var tambol = '';
            var tombol = '<div class="input-group-prepend" ><button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Action</button><div style="height:auto;max-height: 140px;overflow-x:hidden;" class="dropdown-menu"><a class="dropdown-item" href="javascript:;" data-toggle="modal" data-target="#modal_downloadCV" id="' + full.user_id + '" title="Edit" onclick="func_downloadCV(this.id)">Download<i style="color:darkcyan" ></i></a><a class="dropdown-item" href="javascript:;" data-toggle="modal" data-target="#modal" id="' + full.user_id + '" title="Edit" onclick="fun_edit(this.id);">Detail<i  style="color:lawngreen"></i></a></div></div>';
            return tombol;
          }
        }
      ]
    });
    /* Isi Table */

    /* Isi Table riwayat untuk download */
    $('#tbPendidikanFormal').DataTable({
      "scrollX": true,
      "paging": false,
      "searching": false,
      "ordering": false,
      "info": false,
      "ajax": {
        "url": "<?= base_url() ?>document/personil/getEasyuiRiwayatPendidikanFormal",
        "dataSrc": ""
      },
      "columns": [{
          "data": "pendidikan_formal_jenjang"
        },
        {
          "data": "pendidikan_formal_jurusan"
        },
        {
          "data": "pendidikan_formal_institusi"
        },
        {
          "data": "pendidikan_formal_tahun"
        },
      ]
    });
    /* Isi table untuk donwload riwayat pendidikan */

    /* Isi Table riwayat untuk download */
    $('#tbPendidikanNonFormal').DataTable({
      "scrollX": true,
      "paging": false,
      "searching": false,
      "ordering": false,
      "info": false,
      "ajax": {
        "url": "<?= base_url() ?>document/personil/getEasyuiRiwayatPendidikanNonFormal",
        "dataSrc": ""
      },
      "columns": [{
          "data": "pendidikan_non_formal_judul"
        },
        {
          "data": "pendidikan_non_formal_institusi"
        },
        {
          "data": "pendidikan_non_formal_tahun"
        },
      ]
    });
    /* Isi table untuk donwload riwayat pendidikan */

    /* Isi Table riwayat untuk download */
    $('#tbRiwayatJabatan').DataTable({
      "scrollX": true,
      "paging": false,
      "searching": false,
      "ordering": false,
      "info": false,
      "ajax": {
        "url": "<?= base_url() ?>document/personil/getEasyuiRiwayatJabatan",
        "dataSrc": ""
      },
      "columns": [{
          "data": "jabatan_mulai"
        },
        {
          "data": "jabatan_selesai"
        },
        {
          "data": "jabatan_masa_kerja"
        },
        {
          "data": "jabatan_unit_kerja"
        },
        {
          "data": "jabatan_nama"
        },
      ]
    });
    /* Isi table untuk donwload riwayat pendidikan */
    /* Isi Table riwayat untuk download */
    $('#tbKompetensi').DataTable({
      "scrollX": true,
      "paging": false,
      "searching": false,
      "ordering": false,
      "info": false,
      "ajax": {
        "url": "<?= base_url() ?>document/personil/getEasyuiKompetensi",
        "dataSrc": ""
      },
      "columns": [{
          "data": "kompetensi_judul"
        },
        {
          "data": "kompetensi_nama"
        },
        {
          "data": "kompetensi_tahun"
        },
      ]
    });
    /* Isi table untuk donwload riwayat pendidikan */
    /* Isi Table riwayat untuk download */
    $('#tbPenugasanInternal').DataTable({
      "scrollX": true,
      "paging": false,
      "searching": false,
      "ordering": false,
      "info": false,
      "ajax": {
        "url": "<?= base_url() ?>document/personil/getEasyuiPenugasanInternal",
        "dataSrc": ""
      },
      "columns": [{
          "data": "penugasan_internal_tanggal_mulai"
        },
        {
          "data": "penugasan_internal_tanggal_selesai"
        },
        {
          "data": "penugasan_internal_nama"
        },
        {
          "data": "penugasan_internal_memo"
        },
      ]
    });
    /* Isi table untuk donwload riwayat pendidikan */

    /* Isi Table riwayat untuk download */
    $('#tbRiwayatKerja').DataTable({
      "scrollX": true,
      "paging": false,
      "searching": false,
      "ordering": false,
      "info": false,
      "ajax": {
        "url": "<?= base_url() ?>document/personil/getEasyuiRiwayatPengalamanKerja",
        "dataSrc": ""
      },
      "columns": [{
          "data": "pengalaman_tanggal_mulai"
        },
        {
          "data": "pengalaman_tanggal_selesai"
        },
        {
          "data": "pengalaman_instansi"
        },
        {
          "data": "pengalaman_unit_kerja"
        },
      ]
    });
    /* Isi table untuk donwload riwayat pendidikan */

    /* Isi Table riwayat untuk download */
    $('#tbDataKeluarga').DataTable({
      "scrollX": true,
      "paging": false,
      "searching": false,
      "ordering": false,
      "info": false,
      "ajax": {
        "url": "<?= base_url() ?>document/personil/getEasyuiDataKeluarga",
        "dataSrc": ""
      },
      "columns": [{
          "data": "data_keluarga_nama"
        },
        {
          "data": "data_keluarga_status"
        },
        {
          "data": "data_keluarga_alamat"
        },
      ]
    });
    /* Isi table untuk donwload riwayat pendidikan */


  });


  function func_downloadCV(isi) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        fun_loading();
        $.getJSON('<?= base_url('master/user/getUser') ?>', {
          user_id: isi
        }, function(json) {
          // console.log(isi);
          $('#download_user_id').val(json.user_id)
          $('#download_user_nama').val(json.user_nama_lengkap);
          $('#download_tempat_lahir').val(json.user_tempat_lahir);
          $('#download_tanggal_lahir').val(json.user_tgl_lahir);

          $.getJSON('<?= base_url('document/personil/getCV') ?>', {
            user_id: json.user_id
          }, function(result) {

            if (result != null) {
              $('#tbPendidikanFormal').DataTable().ajax.url('<?= base_url() ?>document/personil/getEasyuiRiwayatPendidikanFormal?cv_id=' + result.cv_id).load();
              $('#tbPendidikanNonFormal').DataTable().ajax.url('<?= base_url() ?>document/personil/getEasyuiRiwayatPendidikanNonFormal?cv_id=' + result.cv_id).load();
              $('#tbRiwayatJabatan').DataTable().ajax.url('<?= base_url() ?>document/personil/getEasyuiRiwayatJabatan?cv_id=' + result.cv_id).load();
              $('#tbKompetensi').DataTable().ajax.url('<?= base_url() ?>document/personil/getEasyuiKompetensi?cv_id=' + result.cv_id).load();
              $('#tbPenugasanInternal').DataTable().ajax.url('<?= base_url() ?>document/personil/getEasyuiPenugasanInternal?cv_id=' + result.cv_id).load();
              $('#tbRiwayatKerja').DataTable().ajax.url('<?= base_url() ?>document/personil/getEasyuiRiwayatPengalamanKerja?cv_id=' + result.cv_id).load();
              $('#tbDataKeluarga').DataTable().ajax.url('<?= base_url() ?>document/personil/getEasyuiDataKeluarga?cv_id=' + result.cv_id).load();
            } else {
              $('#tbPendidikanFormal').DataTable().ajax.url('<?= base_url() ?>document/personil/getEasyuiRiwayatPendidikanFormal?cv_id=0').load();
              // $('#tbPendidikanFormal').DataTable().ajax.reload(null,false);
              $('#tbPendidikanNonFormal').DataTable().ajax.url('<?= base_url() ?>document/personil/getEasyuiRiwayatPendidikanNonFormal?cv_id=0').load();
              $('#tbRiwayatJabatan').DataTable().ajax.url('<?= base_url() ?>document/personil/getEasyuiRiwayatJabatan?cv_id=0').load();
              $('#tbKompetensi').DataTable().ajax.url('<?= base_url() ?>document/personil/getEasyuiKompetensi?cv_id=0').load();
              $('#tbPenugasanInternal').DataTable().ajax.url('<?= base_url() ?>document/personil/getEasyuiPenugasanInternal?cv_id=0').load();
              $('#tbRiwayatKerja').DataTable().ajax.url('<?= base_url() ?>document/personil/getEasyuiRiwayatPengalamanKerja?cv_id=0').load();
              $('#tbDataKeluarga').DataTable().ajax.url('<?= base_url() ?>document/personil/getEasyuiDataKeluarga?cv_id=0').load();
            }

            $('#download_nik').val(result.cv_nik);
            $('#download_cv_id').val(result.cv_id);
            $('#download_email').val(result.cv_email);
            $('#download_alamat').val(result.cv_alamat);
            $('#download_tanggal_masuk').val(result.cv_tanggal_masuk);
            $('#download_masa_kerja_tahun').val(result.cv_masa_kerja_tahun);
          })
        })
      }
    })
  }

  function func_cetakCV() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        fun_loading();
        var data = $('#form_modalDownloadCV').serialize();
        window.open('<?= base_url('document/personil/cetakCV?') ?>' + data, '_blank');
      }
    })
  }

  function func_pilih_semua() {

    if ($('.pilih_semua').is(':checked')) {
      $('.pilih_cetak').prop('checked', true);
    } else {
      $('.pilih_cetak').prop('checked', false);
    }

  }


  function fun_edit(isi) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        fun_loading();
        // $('#konfirmasi').click();
        $.getJSON('<?= base_url('master/user/getUser') ?>', {
          user_id: isi
        }, function(json) {

          $('#user_id').val(json.user_id);
          $('#user_nama').val(json.user_nama_lengkap);
          $('#tempat_lahir').val(json.user_tempat_lahir);
          $('#tanggal_lahir').val(json.user_tgl_lahir);

          $.getJSON('<?= base_url('document/personil/getCV') ?>', {
            user_id: json.user_id
          }, function(json) {

            if (json != null) {
              $('#nik').val(json.cv_nik);
              $('#cv_id').val(json.cv_id);
              $('#email').val(json.cv_email);
              $('#alamat').val(json.cv_alamat);
              $('#tanggal_masuk').val(json.cv_tanggal_masuk);
              $('#masa_kerja_tahun').val(json.cv_masa_kerja_tahun);

              setTimeout(() => {

                $('#dg_pendidikan_formal').edatagrid({
                  url: '<?= base_url() ?>document/personil/getEasyuiRiwayatPendidikanFormal?cv_id=' + json.cv_id,
                  saveUrl: '<?= base_url() ?>document/personil/insertEasyuiRiwayatPendidikanFormal',
                  updateUrl: '<?= base_url() ?>document/personil/editEasyuiRiwayatPendidikanFormal',

                  onEndEdit: function(index, row) {
                    var e = $(this).datagrid('getEditor', {
                      index: index,
                      field: 'pendidikan_formal_file'
                    });
                    var files = $(e.target).filebox('files');
                    if (files.length) {
                      row.filerpf = e.target.filebox('getText');
                    }
                  },

                  columns: [
                    [{
                        field: 'pendidikan_formal_jenjang',
                        title: 'Jenjang',
                        width: '20%',
                        editor: {
                          type: 'text'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },
                      {
                        field: 'pendidikan_formal_jurusan',
                        title: 'Jurusan',
                        width: '20%',
                        editor: {
                          type: 'text'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },
                      {
                        field: 'pendidikan_formal_institusi',
                        title: 'Nama Institusi',
                        width: '20%',
                        editor: {
                          type: 'text'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },
                      {
                        field: 'pendidikan_formal_tahun',
                        title: 'Tahun Lulus',
                        width: '20%',
                        editor: {
                          type: 'numberspinner'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },
                      {
                        field: 'pendidikan_formal_file',
                        title: 'File',
                        width: '20%',
                        formatter: (value, row) => row.fileName || value,
                        editor: {
                          type: 'filebox',
                          options: {
                            accept: 'application/pdf',
                            buttonText: '...',
                            onChange: function(newValue, oldValue) {
                              var self = $(this);
                              var files = self.filebox('files')
                              var formData = new FormData();

                              const validExtensions = ['pdf'];
                              const fileExtension = newValue.split('.').pop().toLowerCase();

                              if (validExtensions.indexOf(fileExtension) === -1) {
                                $.messager.alert('Error', 'Format Tidak Didukung');
                                self.filebox('setText', '');
                              } else {
                                self.filebox('setText', 'Menyimpan...');
                                formData.append('cv_id', json.cv_id);
                                for (var i = 0; i < files.length; i++) {
                                  var file = files[i];
                                  formData.append('file', file, file.name);
                                }
                                $.ajax({
                                  url: '<?= base_url('document/personil/insertEasyuiPendidikanFormalFile') ?>',
                                  type: 'post',
                                  data: formData,
                                  contentType: false,
                                  processData: false,
                                  success: function(data) {
                                    self.filebox('setText', data);
                                  }
                                })
                              }
                            }
                          },
                        },
                      },
                    ],
                  ],
                });


                $('#dg_pendidikan_non_formal').edatagrid({
                  url: '<?= base_url() ?>document/personil/getEasyuiRiwayatPendidikanNonFormal?cv_id=' + json.cv_id,
                  saveUrl: '<?= base_url() ?>document/personil/insertEasyuiRiwayatPendidikanNonFormal',
                  updateUrl: '<?= base_url() ?>document/personil/editEasyuiRiwayatPendidikanNonFormal',
                  onEndEdit: function(index, row) {
                    var e = $(this).datagrid('getEditor', {
                      index: index,
                      field: 'pendidikan_non_formal_file'
                    });
                    var files = $(e.target).filebox('files');
                    if (files.length) {
                      row.fil_pendidikan_non_formal = e.target.filebox('getText');
                    }
                  },

                  columns: [
                    [{
                        field: 'pendidikan_non_formal_judul',
                        title: 'Judul ',
                        width: '25%',
                        editor: {
                          type: 'text'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },
                      {
                        field: 'pendidikan_non_formal_institusi',
                        title: 'Nama Institusi',
                        width: '25%',
                        editor: {
                          type: 'text'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },
                      {
                        field: 'pendidikan_non_formal_tahun',
                        title: 'Tahun Lulus',
                        width: '25%',
                        editor: {
                          type: 'numberspinner'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },
                      {
                        field: 'pendidikan_non_formal_file',
                        title: 'File',
                        width: '25%',
                        formatter: (value, row) => row.fileName || value,
                        editor: {
                          type: 'filebox',
                          options: {
                            accept: 'application/pdf',
                            buttonText: '...',
                            onChange: function(newValue, oldValue) {
                              var self = $(this);
                              var files = self.filebox('files')
                              var formData = new FormData();

                              const validExtensions = ['pdf'];
                              const fileExtension = newValue.split('.').pop().toLowerCase();

                              if (validExtensions.indexOf(fileExtension) === -1) {
                                $.messager.alert('Error', 'Format Tidak Didukung');
                                self.filebox('setText', '');
                              } else {
                                self.filebox('setText', 'Menyimpan...');

                                formData.append('cv_id', json.cv_id);

                                for (var i = 0; i < files.length; i++) {
                                  var file = files[i];
                                  formData.append('file', file, file.name);
                                }

                                $.ajax({
                                  url: '<?= base_url('document/personil/insertEasyuiPendidikanNonFormalFile') ?>',
                                  type: 'post',
                                  data: formData,
                                  contentType: false,
                                  processData: false,
                                  success: function(data) {
                                    self.filebox('setText', data);
                                  }
                                })
                              }
                            }
                          },
                        },
                      },
                    ],
                  ],
                });

                $('#dg_jabatan').edatagrid({
                  url: '<?= base_url() ?>document/personil/getEasyuiRiwayatJabatan?cv_id=' + json.cv_id,
                  saveUrl: '<?= base_url() ?>document/personil/insertEasyuiRiwayatJabatan',
                  updateUrl: '<?= base_url() ?>document/personil/editEasyuiRiwayatJabatan',
                  onEndEdit: function(index, row) {
                    var e = $(this).datagrid('getEditor', {
                      index: index,
                      field: 'jabatan_file'
                    });
                    var files = $(e.target).filebox('files');
                    if (files.length) {
                      row.filerj = e.target.filebox('getText');
                    }
                  },
                  onClickRow: function(rowIndex) {
                    if (lastIndex != rowIndex) {
                      $(this).datagrid('endEdit', lastIndex);
                      $(this).datagrid('beginEdit', rowIndex);
                    }
                    lastIndex = rowIndex;
                  },
                  onBeginEdit: function(rowIndex) {
                    var editors = $('#dg_jabatan').datagrid('getEditors', rowIndex);
                    var n1 = $(editors[0].target);
                    var n2 = $(editors[1].target);
                    var n3 = $(editors[2].target);
                    n1.add(n2).datebox({
                      onChange: function() {
                        var cost = n2.datebox('getValue').split('/')[2] - n1.datebox('getValue').split('/')[2];
                        n3.numberbox('setValue', cost);
                        console.log(cost);
                      }
                    })
                  },
                  columns: [
                    [{
                        field: 'jabatan_mulai',
                        title: 'Tanggal Mulai',
                        width: '17%',
                        editor: {
                          type: 'datebox'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },
                      {
                        field: 'jabatan_selesai',
                        title: 'Tanggal Selesai',
                        width: '16%',
                        editor: {
                          type: 'datebox'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },
                      {
                        field: 'jabatan_masa_kerja',
                        title: 'Masa Kerja',
                        width: '17%',
                        editor: {
                          type: 'numberspinner'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },
                      {
                        field: 'jabatan_unit_kerja',
                        title: 'Unit Kerja',
                        width: '17%',
                        editor: {
                          type: 'text'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },

                      {
                        field: 'jabatan_nama',
                        title: 'Jabatan',
                        width: '17%',
                        editor: {
                          type: 'text'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },
                      {
                        field: 'jabatan_file',
                        title: 'File',
                        width: '17%',
                        formatter: (value, row) => row.fileName || value,
                        editor: {
                          type: 'filebox',
                          options: {
                            accept: 'application/pdf',
                            buttonText: '...',
                            onChange: function(newValue, oldValue) {
                              var self = $(this);
                              var files = self.filebox('files')
                              var formData = new FormData();

                              const validExtensions = ['pdf'];
                              const fileExtension = newValue.split('.').pop().toLowerCase();

                              if (validExtensions.indexOf(fileExtension) === -1) {
                                $.messager.alert('Error', 'Format Tidak Didukung');
                                self.filebox('setText', '');
                              } else {
                                self.filebox('setText', 'Menyimpan...');

                                formData.append('cv_id', json.cv_id);

                                for (var i = 0; i < files.length; i++) {
                                  var file = files[i];
                                  formData.append('file', file, file.name);
                                }

                                $.ajax({
                                  url: '<?= base_url('document/personil/insertEasyuiRiwayatJabatanFile') ?>',
                                  type: 'post',
                                  data: formData,
                                  contentType: false,
                                  processData: false,
                                  success: function(data) {
                                    self.filebox('setText', data);
                                  }
                                })
                              }
                            }
                          },
                        },
                      },
                    ],
                  ],
                });

                $('#dg_kompetensi').edatagrid({
                  url: '<?= base_url() ?>document/personil/getEasyuiKompetensi?cv_id=' + json.cv_id,
                  saveUrl: '<?= base_url() ?>document/personil/insertEasyuiKompetensi',
                  updateUrl: '<?= base_url() ?>document/personil/editEasyuiKompetensi',
                  onEndEdit: function(index, row) {
                    var e = $(this).datagrid('getEditor', {
                      index: index,
                      field: 'kompetensi_file'
                    });
                    var files = $(e.target).filebox('files');
                    if (files.length) {
                      row.filekp = e.target.filebox('getText');
                    }
                  },

                  columns: [
                    [{
                        field: 'kompetensi_judul',
                        title: 'Judul ',
                        width: '25%',
                        editor: {
                          type: 'text'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },
                      {
                        field: 'kompetensi_nama',
                        title: 'Nama Kompetensi',
                        width: '25%',
                        editor: {
                          type: 'text'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },
                      {
                        field: 'kompetensi_tahun',
                        title: 'Tahun Lulus',
                        width: '25%',
                        editor: {
                          type: 'numberspinner'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },
                      {
                        field: 'kompetensi_file',
                        title: 'File',
                        width: '25%',
                        formatter: (value, row) => row.fileName || value,
                        editor: {
                          type: 'filebox',
                          options: {
                            accept: 'application/pdf',
                            buttonText: '...',
                            onChange: function(newValue, oldValue) {
                              var self = $(this);
                              var files = self.filebox('files')
                              var formData = new FormData();

                              const validExtensions = ['pdf'];
                              const fileExtension = newValue.split('.').pop().toLowerCase();

                              if (validExtensions.indexOf(fileExtension) === -1) {
                                $.messager.alert('Error', 'Format Tidak Didukung');
                                self.filebox('setText', '');
                              } else {


                                self.filebox('setText', 'Menyimpan...');

                                formData.append('cv_id', json.cv_id);

                                for (var i = 0; i < files.length; i++) {
                                  var file = files[i];
                                  formData.append('file', file, file.name);
                                }

                                $.ajax({
                                  url: '<?= base_url('document/personil/insertEasyuiKompetensiFile') ?>',
                                  type: 'post',
                                  data: formData,
                                  contentType: false,
                                  processData: false,
                                  success: function(data) {
                                    self.filebox('setText', data);
                                  }
                                })
                              }
                            }
                          },
                        },
                      },
                    ],
                  ],
                });

                $('#dg_penugasan_internal').edatagrid({
                  url: '<?= base_url() ?>document/personil/getEasyuiPenugasanInternal?cv_id=' + json.cv_id,
                  saveUrl: '<?= base_url() ?>document/personil/insertEasyuiPenugasanInternal',
                  updateUrl: '<?= base_url() ?>document/personil/editEasyuiPenugasanInternal',

                  onEndEdit: function(index, row) {
                    var e = $(this).datagrid('getEditor', {
                      index: index,
                      field: 'penugasan_internal_file'
                    });
                    var files = $(e.target).filebox('files');
                    if (files.length) {
                      row.fil_pendidikan_non_formal = e.target.filebox('getText');
                    }
                  },

                  columns: [
                    [{
                        field: 'penugasan_internal_tanggal_mulai',
                        title: 'Tanggal Mulai',
                        width: '20%',
                        editor: {
                          type: 'datebox'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },
                      {
                        field: 'penugasan_internal_tanggal_selesai',
                        title: 'Tanggal Selesai',
                        width: '20%',
                        editor: {
                          type: 'datebox'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },
                      {
                        field: 'penugasan_internal_nama',
                        title: 'Penugasan Internal',
                        width: '20%',
                        editor: {
                          type: 'text'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },
                      {
                        field: 'penugasan_internal_memo',
                        title: 'Memo',
                        width: '20%',
                        editor: {
                          type: 'text'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },
                      {
                        field: 'penugasan_internal_file',
                        title: 'File',
                        width: '20%',
                        formatter: (value, row) => row.fileName || value,
                        editor: {
                          type: 'filebox',
                          options: {
                            accept: 'application/pdf',
                            buttonText: '...',
                            onChange: function(newValue, oldValue) {
                              var self = $(this);
                              var files = self.filebox('files')
                              var formData = new FormData();

                              const validExtensions = ['pdf'];
                              const fileExtension = newValue.split('.').pop().toLowerCase();

                              if (validExtensions.indexOf(fileExtension) === -1) {
                                $.messager.alert('Error', 'Format Tidak Didukung');
                                self.filebox('setText', '');
                              } else {
                                self.filebox('setText', 'Menyimpan...');

                                formData.append('cv_id', json.cv_id);

                                for (var i = 0; i < files.length; i++) {
                                  var file = files[i];
                                  formData.append('file', file, file.name);
                                }

                                $.ajax({
                                  url: '<?= base_url('document/personil/insertEasyuiPenugasanInternalFile') ?>',
                                  type: 'post',
                                  data: formData,
                                  contentType: false,
                                  processData: false,
                                  success: function(data) {
                                    self.filebox('setText', data);
                                  }
                                })
                              }
                            }
                          },
                        },
                      },
                    ],
                  ],
                });

                $('#dg_pengalaman_kerja').edatagrid({
                  url: '<?= base_url() ?>document/personil/getEasyuiRiwayatPengalamanKerja?cv_id=' + json.cv_id,
                  saveUrl: '<?= base_url() ?>document/personil/insertEasyuiRiwayatPengalamanKerja',
                  updateUrl: '<?= base_url() ?>document/personil/editEasyuiRiwayatPengalamanKerja',

                  onEndEdit: function(index, row) {
                    var e = $(this).datagrid('getEditor', {
                      index: index,
                      field: 'pengalaman_file'
                    });
                    var files = $(e.target).filebox('files');
                    if (files.length) {
                      row.filerpk = e.target.filebox('getText');
                    }
                  },
                  columns: [
                    [{
                        field: 'pengalaman_tanggal_mulai',
                        title: 'Tanggal Mulai',
                        width: '17%',
                        editor: {
                          type: 'datebox'
                        }
                      },
                      {
                        field: 'pengalaman_tanggal_selesai',
                        title: 'Tanggal Selesai',
                        width: '17%',
                        editor: {
                          type: 'datebox'
                        }
                      },
                      {
                        field: 'pengalaman_instansi',
                        title: 'Nama Instansi',
                        width: '17%',
                        editor: {
                          type: 'text'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },
                      {
                        field: 'pengalaman_unit_kerja',
                        title: 'Unit Kerja',
                        width: '17%',
                        editor: {
                          type: 'text'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },
                      {
                        field: 'pengalaman_nama',
                        title: 'Jabatan',
                        width: '17%',
                        editor: {
                          type: 'text'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },
                      {
                        field: 'pengalaman_file',
                        title: 'File',
                        width: '17%',
                        formatter: (value, row) => row.fileName || value,
                        editor: {
                          type: 'filebox',
                          options: {
                            accept: 'application/pdf',
                            buttonText: '...',
                            onChange: function(newValue, oldValue) {
                              var self = $(this);
                              var files = self.filebox('files')
                              var formData = new FormData();

                              const validExtensions = ['pdf'];
                              const fileExtension = newValue.split('.').pop().toLowerCase();

                              if (validExtensions.indexOf(fileExtension) === -1) {
                                $.messager.alert('Error', 'Format Tidak Didukung');
                                self.filebox('setText', '');
                              } else {


                                self.filebox('setText', 'Menyimpan...');

                                formData.append('cv_id', json.cv_id);

                                for (var i = 0; i < files.length; i++) {
                                  var file = files[i];
                                  formData.append('file', file, file.name);
                                }

                                $.ajax({
                                  url: '<?= base_url('document/personil/insertEasyuiPengalamanKerjaFile') ?>',
                                  type: 'post',
                                  data: formData,
                                  contentType: false,
                                  processData: false,
                                  success: function(data) {
                                    self.filebox('setText', data);
                                  }
                                })
                              }
                            }
                          },
                        },
                      },
                    ],
                  ],
                });

                $('#dg_data_keluarga').edatagrid({
                  url: '<?= base_url() ?>document/personil/getEasyuiDataKeluarga?cv_id=' + json.cv_id,
                  saveUrl: '<?= base_url() ?>document/personil/insertEasyuiDataKeluarga',
                  updateUrl: '<?= base_url() ?>document/personil/editEasyuiDataKeluarga',
                  columns: [
                    [{
                        field: 'data_keluarga_nama',
                        title: 'Nama',
                        width: '33%',
                        editor: {
                          type: 'text'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },
                      {
                        field: 'data_keluarga_status',
                        title: 'Status',
                        width: '33%',
                        editor: {
                          type: 'text'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },
                      {
                        field: 'data_keluarga_alamat',
                        title: 'Alamat',
                        width: '33%',
                        editor: {
                          type: 'text'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },
                    ]
                  ],
                  // data: items.map(item => {
                  //   // Escape user-generated data before rendering it in the grid
                  //   return {
                  //     data_keluarga_nama: escapeHtml(item.data_keluarga_nama),
                  //     data_keluarga_status: escapeHtml(item.data_keluarga_nama),
                  //     data_keluarga_alamat: escapeHtml(item.data_keluarga_alamat),
                  //   };
                  // })
                });

              }, 1000);

            } else {
              setTimeout(() => {
                $('#dg_pendidikan_formal').edatagrid({
                  url: '<?= base_url() ?>document/personil/getEasyuiRiwayatPendidikanFormal?cv_id=0',
                  saveUrl: '<?= base_url() ?>document/personil/insertEasyuiRiwayatPendidikanFormal',
                  updateUrl: '<?= base_url() ?>document/personil/editEasyuiRiwayatPendidikanFormal',
                  onEndEdit: function(index, row) {
                    var e = $(this).datagrid('getEditor', {
                      index: index,
                      field: 'pendidikan_formal_file'
                    });
                    var files = $(e.target).filebox('files');
                    if (files.length) {
                      row.filerpf = e.target.filebox('getText');
                    }
                  },

                  columns: [
                    [{
                        field: 'pendidikan_formal_jenjang',
                        title: 'Jenjang',
                        width: '20%',
                        editor: {
                          type: 'text'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },
                      {
                        field: 'pendidikan_formal_jurusan',
                        title: 'Jurusan',
                        width: '20%',
                        editor: {
                          type: 'text'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },
                      {
                        field: 'pendidikan_formal_institusi',
                        title: 'Nama Institusi',
                        width: '20%',
                        editor: {
                          type: 'text'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },
                      {
                        field: 'pendidikan_formal_tahun',
                        title: 'Tahun Lulus',
                        width: '20%',
                        editor: {
                          type: 'numberspinner'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },
                      {
                        field: 'pendidikan_formal_file',
                        title: 'File',
                        width: '20%',
                        formatter: (value, row) => row.fileName || value,
                        editor: {
                          type: 'filebox',
                          options: {
                            accept: 'application/pdf',
                            buttonText: '...',
                            onChange: function(newValue, oldValue) {
                              var self = $(this);
                              var files = self.filebox('files')
                              var formData = new FormData();

                              const validExtensions = ['pdf'];
                              const fileExtension = newValue.split('.').pop().toLowerCase();

                              if (validExtensions.indexOf(fileExtension) === -1) {
                                $.messager.alert('Error', 'Format Tidak Didukung');
                                self.filebox('setText', '');
                              } else {


                                self.filebox('setText', 'Menyimpan...');

                                formData.append('cv_id', json.cv_id);

                                for (var i = 0; i < files.length; i++) {
                                  var file = files[i];
                                  formData.append('file', file, file.name);
                                }

                                $.ajax({
                                  url: '<?= base_url('document/personil/insertEasyuiPendidikanFormalFile') ?>',
                                  type: 'post',
                                  data: formData,
                                  contentType: false,
                                  processData: false,
                                  success: function(data) {
                                    self.filebox('setText', data);
                                  }
                                })
                              }
                            }
                          },
                        },
                      },
                    ],
                  ],
                });


                $('#dg_pendidikan_non_formal').edatagrid({
                  url: '<?= base_url() ?>document/personil/getEasyuiRiwayatPendidikanNonFormal?cv_id=0',
                  saveUrl: '<?= base_url() ?>document/personil/insertEasyuiRiwayatPendidikanNonFormal',
                  updateUrl: '<?= base_url() ?>document/personil/editEasyuiRiwayatPendidikanNonFormal',
                  onEndEdit: function(index, row) {
                    var e = $(this).datagrid('getEditor', {
                      index: index,
                      field: 'pendidikan_non_formal_file'
                    });
                    var files = $(e.target).filebox('files');
                    if (files.length) {
                      row.fil_pendidikan_non_formal = e.target.filebox('getText');
                    }
                  },

                  columns: [
                    [{
                        field: 'pendidikan_non_formal_judul',
                        title: 'Judul ',
                        width: '25%',
                        editor: {
                          type: 'text'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },
                      {
                        field: 'pendidikan_non_formal_institusi',
                        title: 'Nama Institusi',
                        width: '25%',
                        editor: {
                          type: 'text'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },
                      {
                        field: 'pendidikan_non_formal_tahun',
                        title: 'Tahun Lulus',
                        width: '25%',
                        editor: {
                          type: 'numberspinner'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },
                      {
                        field: 'pendidikan_non_formal_file',
                        title: 'File',
                        width: '25%',
                        formatter: (value, row) => row.fileName || value,
                        editor: {
                          type: 'filebox',
                          options: {
                            accept: 'application/pdf',
                            buttonText: '...',
                            onChange: function(newValue, oldValue) {
                              var self = $(this);
                              var files = self.filebox('files')
                              var formData = new FormData();

                              const validExtensions = ['pdf'];
                              const fileExtension = newValue.split('.').pop().toLowerCase();

                              if (validExtensions.indexOf(fileExtension) === -1) {
                                $.messager.alert('Error', 'Format Tidak Didukung');
                                self.filebox('setText', '');
                              } else {

                                self.filebox('setText', 'Menyimpan...');

                                formData.append('cv_id', json.cv_id);

                                for (var i = 0; i < files.length; i++) {
                                  var file = files[i];
                                  formData.append('file', file, file.name);
                                }

                                $.ajax({
                                  url: '<?= base_url('document/personil/insertEasyuiPendidikanNonFormalFile') ?>',
                                  type: 'post',
                                  data: formData,
                                  contentType: false,
                                  processData: false,
                                  success: function(data) {
                                    self.filebox('setText', data);
                                  }
                                })
                              }
                            }
                          },
                        },
                      },
                    ],
                  ],
                });

                $('#dg_jabatan').edatagrid({
                  url: '<?= base_url() ?>document/personil/getEasyuiRiwayatJabatan?cv_id=0',
                  saveUrl: '<?= base_url() ?>document/personil/insertEasyuiRiwayatJabatan',
                  updateUrl: '<?= base_url() ?>document/personil/editEasyuiRiwayatJabatan',
                  onEndEdit: function(index, row) {
                    var e = $(this).datagrid('getEditor', {
                      index: index,
                      field: 'jabatan_file'
                    });
                    var files = $(e.target).filebox('files');
                    if (files.length) {
                      row.filerj = e.target.filebox('getText');
                    }
                  },
                  columns: [
                    [{
                        field: 'jabatan_mulai',
                        title: 'Tanggal Mulai',
                        width: '17%',
                        editor: {
                          type: 'datebox',
                          options: {
                            // accept: 'application/',
                            onChange: function(isi, value) {
                              var row = $('#dg_jabatan').datagrid('getSelected');
                              rowIndex = $('#dg_jabatan').datagrid('getRowIndex', row);
                              rows = $('#dg_jabatan').datagrid('getRows');
                              var ed = $('#dg_jabatan').datagrid('getEditor', {
                                index: rowIndex,
                                field: 'jabatan_unit_kerja'
                              });
                              var text = $(ed.target).numberspinner('setValue', value);
                            }
                          }
                        }
                      },
                      {
                        field: 'jabatan_selesai',
                        title: 'Tanggal Selesai',
                        width: '16%',
                        editor: {
                          type: 'datebox'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },
                      {
                        field: 'jabatan_masa_kerja',
                        title: 'Masa Kerja',
                        width: '17%',
                        editor: {
                          type: 'numberspinner'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },
                      {
                        field: 'jabatan_unit_kerja',
                        title: 'Unit Kerja',
                        width: '17%',
                        editor: {
                          type: 'text'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },

                      {
                        field: 'jabatan_nama',
                        title: 'Jabatan',
                        width: '17%',
                        editor: {
                          type: 'text'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },
                      {
                        field: 'jabatan_file',
                        title: 'File',
                        width: '17%',
                        formatter: (value, row) => row.fileName || value,
                        editor: {
                          type: 'filebox',
                          options: {
                            accept: 'application/pdf',
                            buttonText: '...',
                            onChange: function(newValue, oldValue) {
                              var self = $(this);
                              var files = self.filebox('files')
                              var formData = new FormData();

                              const validExtensions = ['pdf'];
                              const fileExtension = newValue.split('.').pop().toLowerCase();

                              if (validExtensions.indexOf(fileExtension) === -1) {
                                $.messager.alert('Error', 'Format Tidak Didukung');
                                self.filebox('setText', '');
                              } else {
                                self.filebox('setText', 'Menyimpan...');

                                formData.append('cv_id', json.cv_id);

                                for (var i = 0; i < files.length; i++) {
                                  var file = files[i];
                                  formData.append('file', file, file.name);
                                }

                                $.ajax({
                                  url: '<?= base_url('document/personil/insertEasyuiRiwayatJabatanFile') ?>',
                                  type: 'post',
                                  data: formData,
                                  contentType: false,
                                  processData: false,
                                  success: function(data) {
                                    self.filebox('setText', data);
                                  }
                                })
                              }
                            }
                          },
                        },
                      },
                    ],
                  ],
                });

                $('#dg_kompetensi').edatagrid({
                  url: '<?= base_url() ?>document/personil/getEasyuiKompetensi?cv_id=0',
                  saveUrl: '<?= base_url() ?>document/personil/insertEasyuiKompetensi',
                  updateUrl: '<?= base_url() ?>document/personil/editEasyuiKompetensi',
                  onEndEdit: function(index, row) {
                    var e = $(this).datagrid('getEditor', {
                      index: index,
                      field: 'kompetensi_file'
                    });
                    var files = $(e.target).filebox('files');
                    if (files.length) {
                      row.filekp = e.target.filebox('getText');
                    }
                  },

                  columns: [
                    [{
                        field: 'kompetensi_judul',
                        title: 'Judul ',
                        width: '25%',
                        editor: {
                          type: 'text'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },
                      {
                        field: 'kompetensi_nama',
                        title: 'Nama Kompetensi',
                        width: '25%',
                        editor: {
                          type: 'text'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },
                      {
                        field: 'kompetensi_tahun',
                        title: 'Tahun Lulus',
                        width: '25%',
                        editor: {
                          type: 'numberspinner'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },
                      {
                        field: 'kompetensi_file',
                        title: 'File',
                        width: '25%',
                        formatter: (value, row) => row.fileName || value,
                        editor: {
                          type: 'filebox',
                          options: {
                            accept: 'application/pdf',
                            buttonText: '...',
                            onChange: function(newValue, oldValue) {
                              var self = $(this);
                              var files = self.filebox('files')
                              var formData = new FormData();

                              const validExtensions = ['pdf'];
                              const fileExtension = newValue.split('.').pop().toLowerCase();

                              if (validExtensions.indexOf(fileExtension) === -1) {
                                $.messager.alert('Error', 'Format Tidak Didukung');
                                self.filebox('setText', '');
                              } else {

                                self.filebox('setText', 'Menyimpan...');

                                formData.append('cv_id', json.cv_id);

                                for (var i = 0; i < files.length; i++) {
                                  var file = files[i];
                                  formData.append('file', file, file.name);
                                }

                                $.ajax({
                                  url: '<?= base_url('document/personil/insertEasyuiKompetensiFile') ?>',
                                  type: 'post',
                                  data: formData,
                                  contentType: false,
                                  processData: false,
                                  success: function(data) {
                                    self.filebox('setText', data);
                                  }
                                })
                              }
                            }
                          },
                        },
                      },
                    ],
                  ],
                });

                $('#dg_penugasan_internal').edatagrid({
                  url: '<?= base_url() ?>document/personil/getEasyuiPenugasanInternal?cv_id=0',
                  saveUrl: '<?= base_url() ?>document/personil/insertEasyuiPenugasanInternal',
                  updateUrl: '<?= base_url() ?>document/personil/editEasyuiPenugasanInternal',

                  onEndEdit: function(index, row) {
                    var e = $(this).datagrid('getEditor', {
                      index: index,
                      field: 'penugasan_internal_file'
                    });
                    var files = $(e.target).filebox('files');
                    if (files.length) {
                      row.fil_pendidikan_non_formal = e.target.filebox('getText');
                    }
                  },

                  columns: [
                    [{
                        field: 'penugasan_internal_tanggal_mulai',
                        title: 'Tanggal Mulai',
                        width: '20%',
                        editor: {
                          type: 'datebox'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },
                      {
                        field: 'penugasan_internal_tanggal_selesai',
                        title: 'Tanggal Selesai',
                        width: '20%',
                        editor: {
                          type: 'datebox'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },
                      {
                        field: 'penugasan_internal_nama',
                        title: 'Penugasan Internal',
                        width: '20%',
                        editor: {
                          type: 'text'
                        }
                      },
                      {
                        field: 'penugasan_internal_memo',
                        title: 'Memo',
                        width: '20%',
                        editor: {
                          type: 'text'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },
                      {
                        field: 'penugasan_internal_file',
                        title: 'File',
                        width: '20%',
                        formatter: (value, row) => row.fileName || value,
                        editor: {
                          type: 'filebox',
                          options: {
                            accept: 'application/pdf',
                            buttonText: '...',
                            onChange: function(newValue, oldValue) {
                              var self = $(this);
                              var files = self.filebox('files')
                              var formData = new FormData();

                              const validExtensions = ['pdf'];
                              const fileExtension = newValue.split('.').pop().toLowerCase();

                              if (validExtensions.indexOf(fileExtension) === -1) {
                                $.messager.alert('Error', 'Format Tidak Didukung');
                                self.filebox('setText', '');
                              } else {

                                self.filebox('setText', 'Menyimpan...');

                                formData.append('cv_id', json.cv_id);

                                for (var i = 0; i < files.length; i++) {
                                  var file = files[i];
                                  formData.append('file', file, file.name);
                                }

                                $.ajax({
                                  url: '<?= base_url('document/personil/insertEasyuiPenugasanInternalFile') ?>',
                                  type: 'post',
                                  data: formData,
                                  contentType: false,
                                  processData: false,
                                  success: function(data) {
                                    self.filebox('setText', data);
                                  }
                                })
                              }
                            }
                          },
                        },
                      },
                    ],
                  ],
                });

                $('#dg_pengalaman_kerja').edatagrid({
                  url: '<?= base_url() ?>document/personil/getEasyuiRiwayatPengalamanKerja?cv_id=0',
                  saveUrl: '<?= base_url() ?>document/personil/insertEasyuiRiwayatPengalamanKerja',
                  updateUrl: '<?= base_url() ?>document/personil/editEasyuiRiwayatPengalamanKerja',

                  onEndEdit: function(index, row) {
                    var e = $(this).datagrid('getEditor', {
                      index: index,
                      field: 'pengalaman_file'
                    });
                    var files = $(e.target).filebox('files');
                    if (files.length) {
                      row.filerpk = e.target.filebox('getText');
                    }
                  },
                  columns: [
                    [{
                        field: 'pengalaman_tanggal_mulai',
                        title: 'Tanggal Mulai',
                        width: '17%',
                        editor: {
                          type: 'datebox'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },
                      {
                        field: 'pengalaman_tanggal_selesai',
                        title: 'Tanggal Selesai',
                        width: '17%',
                        editor: {
                          type: 'datebox'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },
                      {
                        field: 'pengalaman_instansi',
                        title: 'Nama Instansi',
                        width: '17%',
                        editor: {
                          type: 'text'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },
                      {
                        field: 'pengalaman_unit_kerja',
                        title: 'Unit Kerja',
                        width: '17%',
                        editor: {
                          type: 'text'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },
                      {
                        field: 'pengalaman_nama',
                        title: 'Jabatan',
                        width: '17%',
                        editor: {
                          type: 'text'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },
                      {
                        field: 'pengalaman_file',
                        title: 'File',
                        width: '17%',
                        formatter: (value, row) => row.fileName || value,
                        editor: {
                          type: 'filebox',
                          options: {
                            accept: 'application/pdf',
                            buttonText: '...',
                            onChange: function(newValue, oldValue) {
                              var self = $(this);
                              var files = self.filebox('files')
                              var formData = new FormData();

                              const validExtensions = ['pdf'];
                              const fileExtension = newValue.split('.').pop().toLowerCase();

                              if (validExtensions.indexOf(fileExtension) === -1) {
                                $.messager.alert('Error', 'Format Tidak Didukung');
                                self.filebox('setText', '');
                              } else {

                                self.filebox('setText', 'Menyimpan...');

                                formData.append('cv_id', json.cv_id);

                                for (var i = 0; i < files.length; i++) {
                                  var file = files[i];
                                  formData.append('file', file, file.name);
                                }

                                $.ajax({
                                  url: '<?= base_url('document/personil/insertEasyuiPengalamanKerjaFile') ?>',
                                  type: 'post',
                                  data: formData,
                                  contentType: false,
                                  processData: false,
                                  success: function(data) {
                                    self.filebox('setText', data);
                                  }
                                })
                              }
                            }
                          },
                        },
                      },
                    ],
                  ],
                });

                $('#dg_data_keluarga').edatagrid({
                  url: '<?= base_url() ?>document/personil/getEasyuiDataKeluarga?cv_id=0',
                  saveUrl: '<?= base_url() ?>document/personil/insertEasyuiDataKeluarga',
                  updateUrl: '<?= base_url() ?>document/personil/editEasyuiDataKeluarga',
                  columns: [
                    [{
                        field: 'data_keluarga_nama',
                        title: 'Nama',
                        width: '33%',
                        editor: {
                          type: 'text'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },
                      {
                        field: 'data_keluarga_status',
                        title: 'Status  ',
                        width: '33%',
                        editor: {
                          type: 'text'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },
                      {
                        field: 'data_keluarga_alamat',
                        title: 'Alamat',
                        width: '33%',
                        editor: {
                          type: 'text'
                        },
                        formatter: function(value) {
                          return $('<div/>').text(value).html();
                        }
                      },

                    ],
                  ],
                });
              }, 1500);
            }
          })
        })
      }
    })
  }


  // easy ui
  // tambah
  function fun_tambah_pendidikan_formal() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        var id = $('#cv_id').val();
        $('#dg_pendidikan_formal').edatagrid('addRow', {
          index: 0,
          row: {
            cv_id: id
          },
        });
      }
    })
  }

  function fun_tambah_pendidikan_non_formal() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        var id = $('#cv_id').val();
        $('#dg_pendidikan_non_formal').edatagrid('addRow', {
          index: 0,
          row: {
            cv_id: id
          },
        });
      }
    })
  }

  function fun_tambah_jabatan() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        var id = $('#cv_id').val();
        $('#dg_jabatan').edatagrid('addRow', {
          index: 0,
          row: {
            cv_id: id
          },
        });
      }
    })
  }

  function fun_tambah_kompetensi() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        var id = $('#cv_id').val();
        $('#dg_kompetensi').edatagrid('addRow', {
          index: 0,
          row: {
            cv_id: id
          },
        });
      }
    })
  }


  function fun_tambah_penugasan_internal() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        var id = $('#cv_id').val();
        $('#dg_penugasan_internal').edatagrid('addRow', {
          index: 0,
          row: {
            cv_id: id
          },
        });
      }
    })
  }

  function fun_tambah_pengalaman_kerja() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        var id = $('#cv_id').val();
        $('#dg_pengalaman_kerja').edatagrid('addRow', {
          index: 0,
          row: {
            cv_id: id
          },
        });
      }
    })
  }

  function fun_tambah_data_keluarga() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        var id = $('#cv_id').val();
        $('#dg_data_keluarga').edatagrid('addRow', {
          index: 0,
          row: {
            cv_id: id
          },
        });
      }
    })
  }
  // tambah

  // simpan
  function fun_simpan_pendidikan_formal() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $('#dg_pendidikan_formal').edatagrid('saveRow');
        setTimeout(() => {
          $('#dg_pendidikan_formal').datagrid('reload')
        }, 1000);
        // }
      }
    })
  }

  function fun_simpan_pendidikan_non_formal() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $('#dg_pendidikan_non_formal').edatagrid('saveRow');
        setTimeout(() => {
          $('#dg_pendidikan_non_formal').datagrid('reload')
        }, 1000);
      }
    })
  }

  function fun_simpan_jabatan() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $('#dg_jabatan').edatagrid('saveRow');
        setTimeout(() => {
          $('#dg_jabatan').datagrid('reload')
        }, 1000);
      }
    })
  }

  function fun_simpan_kompetensi() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $('#dg_kompetensi').edatagrid('saveRow');
        setTimeout(() => {
          $('#dg_kompetensi').datagrid('reload')
        }, 1000);
      }
    })
  }

  function fun_simpan_penugasan_internal() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $('#dg_penugasan_internal').edatagrid('saveRow');
        setTimeout(() => {
          $('#dg_penugasan_internal').datagrid('reload')
        }, 1000);
      }
    })
  }

  function fun_simpan_pengalaman_kerja() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $('#dg_pengalaman_kerja').edatagrid('saveRow');
        setTimeout(() => {
          $('#dg_pengalaman_kerja').datagrid('reload')
        }, 1000);
      }
    })
  }

  function fun_simpan_data_keluarga() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $('#dg_data_keluarga').edatagrid('saveRow');
        setTimeout(() => {
          $('#dg_data_keluarga').datagrid('reload')
        }, 1000);
      }
    })
  }
  // simpan

  // hapus
  function fun_hapus_pendidikan_formal() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        var row = $('#dg_pendidikan_formal').datagrid('getSelected');
        $.post('<?= base_url() ?>document/personil/deleteEasyuiRiwayatPendidikanFormal', {
          pendidikan_formal_id: row.pendidikan_formal_id
        }, function(data, textStatus, xhr) {
          $('#dg_pendidikan_formal').datagrid('reload');
        });
      }
    })
  }

  function fun_hapus_pendidikan_non_formal() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        var row = $('#dg_pendidikan_non_formal').datagrid('getSelected');
        $.post('<?= base_url() ?>document/personil/deleteEasyuiRiwayatPendidikanNonFormal', {
          pendidikan_non_formal_id: row.pendidikan_non_formal_id
        }, function(data, textStatus, xhr) {
          $('#dg_pendidikan_non_formal').datagrid('reload');
        });
      }
    })
  }

  function fun_hapus_jabatan() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        var row = $('#dg_jabatan').datagrid('getSelected');
        $.post('<?= base_url() ?>document/personil/deleteEasyuiRiwayatjabatan', {
          jabatan_id: row.jabatan_id
        }, function(data, textStatus, xhr) {
          $('#dg_jabatan').datagrid('reload');
        });
      }
    })
  }

  function fun_hapus_kompetensi() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        var row = $('#dg_kompetensi').datagrid('getSelected');
        $.post('<?= base_url() ?>document/personil/deleteEasyuiKompetensi', {
          kompetensi_id: row.kompetensi_id
        }, function(data, textStatus, xhr) {
          $('#dg_kompetensi').datagrid('reload');
        });
      }
    })
  }

  function fun_hapus_penugasan_internal() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        var row = $('#dg_penugasan_internal').datagrid('getSelected');
        $.post('<?= base_url() ?>document/personil/deleteEasyuiPenugasanInternal', {
          penugasan_internal_id: row.penugasan_internal_id
        }, function(data, textStatus, xhr) {
          $('#dg_penugasan_internal').datagrid('reload');
        });
      }
    })
  }

  function fun_hapus_pengalaman_kerja() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        var row = $('#dg_pengalaman_kerja').datagrid('getSelected');
        $.post('<?= base_url() ?>document/personil/deleteEasyuiRiwayatPengalamanKerja', {
          pengalaman_id: row.pengalaman_id
        }, function(data, textStatus, xhr) {
          $('#dg_pengalaman_kerja').datagrid('reload');
        });
      }
    })
  }

  function fun_hapus_data_keluarga() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        var row = $('#dg_data_keluarga').datagrid('getSelected');
        $.post('<?= base_url() ?>document/personil/deleteEasyuiDataKeluarga', {
          data_keluarga_id: row.data_keluarga_id
        }, function(data, textStatus, xhr) {
          $('#dg_data_keluarga').datagrid('reload');
        });
      }
    })
  }
  // hapus
  // easyui


  $('#simpan').on('click', function() {
    // setTimeout(()=>{
    // $('#loading_form_simpan').show();
    // },2000)
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        toastr.success('Berhasil');
        $('#close').click();
      }
    })
  })


  $('#konfirmasi').on('click', function() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        var url = ($('#cv_id').val() != '') ? '<?= base_url('document/personil/updateCV') ?>' : '<?= base_url('document/personil/insertCV') ?>';

        var data = new FormData();
        data.append('nik', $('#nik').val())
        data.append('user_id', $('#user_id').val())
        data.append('cv_id', $('#cv_id').val())
        data.append('email', $('#email').val())
        data.append('alamat', $('#alamat').val())
        data.append('tanggal_masuk', $('#tanggal_masuk').val())
        data.append('masa_kerja_tahun', $('#masa_kerja_tahun').val())

        $.ajax({
          url: url,
          data: data,
          type: 'POST',
          processData: false,
          contentType: false,
          beforeSend: function() {
            $('#loading_form').show();
            $('#konfirmasi').hide();
          },
          complete: function() {
            $('#loading_form').hide();
            $('#konfirmasi').show();
          },
          success: function(isi) {
            var id = $('#user_id').val();
            toastr.success('Terkonfirmasi');
            fun_edit(id);
          }
        })
      }
    })
  })



  function func_masaKerja(awal) {
    tglmasuk = awal;
    tanggal = tglmasuk.split("-");

    t = tanggal[2];
    bln = (tanggal[1] - 1);
    thn = tanggal[0];

    var d = new Date();
    d.setDate(t);
    d.setMonth(bln);
    d.setFullYear(thn);
    x1 = d.getTime();
    var d2 = new Date();
    x2 = d2.getTime();
    beda = x2 - x1;


    var masakerjatahun = beda / (1000 * 60 * 60 * 24 * 365);
    var masakerjabulan = (masakerjatahun - Math.floor(masakerjatahun)) * 12;
    var masakerjahari = (masakerjabulan - Math.floor(masakerjabulan)) * 31;

    document.getElementById("masa_kerja_tahun").value = Math.floor(masakerjatahun);
    // document.getElementById("bulan").value = Math.floor(masakerjabulan);
    // document.getElementById("hari").value = Math.floor(masakerjahari);
  }

  function fun_close() {
    fun_loading();
    $('#simpan').css('display', 'block');
    $('#edit').css('display', 'none');
    // $('#konfirmasi').css('display', 'none');
    $('#div_word_lama').css('display', 'none');
    $('#div_pdf_lama').css('display', 'none');
    $('#jenis_document').empty();
    $('#seksi').empty();
    $('#transaksi_id').empty();
    $('#form_modal')[0].reset();
    $('#form_modalDownloadCV')[0].reset();
    $('#table').DataTable().ajax.reload(null, false);

    $('#tbPendidikanFormal').DataTable().ajax.reload(null, false);
    $('#tbPendidikanNonFormal').DataTable().ajax.reload(null, false);
    $('#tbRiwayatJabatan').DataTable().ajax.reload(null, false);
    $('#tbKompetensi').DataTable().ajax.reload(null, false);
    $('#tbPenugasanInternal').DataTable().ajax.reload(null, false);
    $('#tbRiwayatKerja').DataTable().ajax.reload(null, false);
    $('#tbDataKeluarga').DataTable().ajax.reload(null, false);

    $('#dg_pendidikan_formal').datagrid('reload');
    $('#dg_pendidikan_non_formal').datagrid('reload');
    $('#dg_kompetensi').datagrid('reload');
    $('#dg_penugasan_internal').datagrid('reload');
    $('#dg_pengalaman_kerja').datagrid('reload');
    $('#dg_data_keluarga').datagrid('reload');
  }
  /* Fun Close */

  $('#modal').on('hidden.bs.modal', function(e) {
    fun_close();
  });
  $('#modal_downloadCV').on('hidden.bs.modal', function(e) {
    fun_close();
  });

  /* Fun Loading */
  function fun_loading() {
    var simplebar = new Nanobar();
    simplebar.go(100);
  }
  /* Fun Loading */

  // Function to escape HTML entities
  function escapeHtml(unsafe) {
    return unsafe
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;")
      .replace(/'/g, "&#039;");
  }
</script>