  <script type="text/javascript">
    $(function() {
      /* Isi Table */
      $('#table').DataTable({
        "lengthMenu": [
          [5, 10, 25, 50, -1],
          [5, 10, 25, 50, "All"]
        ],
        "dom": 'lBfrtip',
        "buttons": ["csv", "pdf", "excel", "copy", "print"],
        "scrollX": true,
        // "ordering":false,
        "ajax": {
          "url": "<?= base_url('document/pengajuan/getDataPengajuan') ?>",
          "dataSrc": ""
        },
        "columns": [{
            render: function(data, type, full, meta) {
              return meta.row + meta.settings._iDisplayStart + 1;
            }
          },
          {
            "data": "transaksi_tgl_pengajuan"
          },
          {
            "data": "transaksi_tgl_pengesahan"
          },
          {
            "data": "transaksi_judul_document"
          },
          {
            "data": "jenis_nama"
          },
          {
            "data": "transaksi_nomor_document"
          },
          {
            "data": "transaksi_keterangan_document"
          },
          {
            "data": "transaksi_filenya"
          },
          // {"data" : "transaksi_file_pdf"},
          {
            "render": function(data, type, full, meta) {
              var status = '';
              var warna = '';
              if (full.transaksi_status == '0') {
                status = 'Pengajuan';
                warna = '#FFD700';
              } else if (full.transaksi_status == '1') {
                status = 'Approved';
                warna = '#87CEFA';
              } else if (full.transaksi_status == '2') {
                status = 'Tolak';
                warna = '#FF4500';
              }
              return '<span class="badge" style="background-color: ' + warna + '">' + status + '</span>';
            }
          },
          {
            "render": function(data, type, full, meta) {
              return '<center><a href="#" id="' + full.transaksi_file_pdf + '" title="Lihat" onclick="func_lihat(this.id)"><i style="color:red" class="fas fa-file-pdf" data-toggle="modal" data-target="#modal1"></i></a></center>'
            }
          },
          {
            "render": function(data, type, full, meta) {
              // var tambol = '';
              var tombol = '<div class="input-group-prepend" ><button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Action</button><div style="height:auto;max-height: 135px;overflow-x: hidden;" class="dropdown-menu pre-scrollable"><a data-toggle="modal" data-target="#modal" class="dropdown-item" href="#" id="' + full.transaksi_id + '" title="Edit" onclick="func_edit(this.id)">Edit <i style="color:lime" ></i></a><a class="dropdown-item" href="#" id="' + full.transaksi_id + '" title="Hapus" onclick="return func_hapus(this.id)">Hapus <i style="color:red"  ></i></a></div></div>';
              return (full.transaksi_status == '0') ? tombol : '-';
              // return tombol
            }
          },
        ]
      });
      /* Isi Table */
    });



    function func_tanggal() {
      var today = new Date();
      var hari = today.getDate();
      var bulan = today.getMonth() + 1;
      var tahun = today.getFullYear();
      var tanggal = hari + "-" + bulan + "-" + tahun;
      $('#tanggal').val(tanggal);
    }

    // function lih

    // start jenis dokumen select2
    $('#jenis_document').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('document/pengajuan/getJenisDocument') ?>',
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

    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');
    // end jenis dokumen select2

    // start jenis dokumen select2
    $('#seksi').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('document/pengajuan/getSeksi') ?>',
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

    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');
    // end jenis dokumen select2

    // start form modal klik simpan/edit
    $("#form_modal").on("submit", function(e) {
      e.preventDefault();
      $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
        if (!json.user_id) {
          fun_notifLogout();
        } else {
          let url = ($('#transaksi_id').val() != '') ?
            '<?= base_url('document/pengajuan/updatePengajuan') ?>' :
            '<?= base_url('document/pengajuan/insertPengajuan') ?>';

          var file_word = $('#file_word').prop('files')[0];
          var file_pdf = $('#file_pdf').prop('files')[0];

          if ($('#jenis_document').val() == null) {
            $('#jenis_alert').css('display', 'block');
          } else {
            $('#jenis_alert').css('display', 'none');
          }
          if ($('#seksi').val() == null) {
            $('#seksi_alert').css('display', 'block');
          } else {
            $('#seksi_alert').css('display', 'none');
          }
          if ($('#judul_document').val() == '') {
            $('#judul_alert').css('display', 'block');
          } else {
            $('#judul_alert').css('display', 'none');
          }
          if ($('#tanggal').val() == '') {
            $('#tanggal_alert').css('display', 'block');
          } else {
            $('#tanggal_alert').css('display', 'none');
          }
          if ($('#revisi').val() == '') {
            $('#revisi_alert').css('display', 'block');
          } else {
            $('#revisi_alert').css('display', 'none');
          }
          if ($('#terbitan').val() == '') {
            $('#terbitan_alert').css('display', 'block');
          } else {
            $('#terbitan_alert').css('display', 'none');
          }

          if ($('#file_word_lama').val() != '') {
            $('#word_alert').css('display', 'none');
          } else if ($('#file_word').val() == '') {
            $('#word_alert').css('display', 'block')
          } else {
            $('#word_alert').css('display', 'none');
          }

          if ($('#file_pdf_lama').val() != '') {
            $('#pdf_alert').css('display', 'none');
          } else if ($('#file_pdf').val() == '') {
            $('#pdf_alert').css('display', 'block');
          } else {
            $('#pdf_alert').css('display', 'none');
          }
          if ($('#nomor_document').val() == '') {
            $('#nomor_alert').css('display', 'block');
          } else {
            $('#nomor_alert').css('display', 'none');
          }



          if ((($('#jenis_document').val() != null) && ($('#seksi').val() != null) && ($('#judul_document').val() != '') && ($('#tanggal').val() != '') && ($('#revisi').val() != '') && ($('#terbitan').val() != '') && ($('#file_word').val() != '' || $('#file_word_lama').val() != '') && ($('#file_pdf').val() != '' || $('#file_pdf_lama').val() != '') && ($('#nomor_document').val != ''))) {

            var data = new FormData();
            data.append('transaksi_id', $('#transaksi_id').val());
            data.append('transaksi_urut_document', $('#transaksi_urut_document').val());
            data.append('seksi_id', $('#seksi').val());
            data.append('transaksi_keterangan_document', $('#keterangan').val());
            data.append('transaksi_nomor_document', $('#nomor_document').val())
            data.append('jenis_id', $('#jenis_document').val());
            data.append('transaksi_tgl_pengajuan', $('#tanggal').val());
            data.append('transaksi_judul_document', $('#judul_document').val());
            data.append('transaksi_revisi', $('#revisi').val());
            data.append('transaksi_terbitan', $('#terbitan').val());
            data.append('transaksi_file_word', file_word);
            data.append('transaksi_file_pdf', file_pdf);

            e.preventDefault();
            $.ajax({
              url: url,
              data: data,
              type: 'POST',
              processData: false,
              contentType: false,
              beforeSend: function() {
                $('#loading_form').show();
                // $('#edit').hide();
                // $('#simpan').hide();
              },
              complete: function() {
                $('#loading_form').hide();
              },
              success: function(isi) {
                if (isi == 0) {
                  toastr.warning('Ekstensi Dokumen Tidak Diperbolehkan');
                } else {
                  fun_loading();
                  $('#close').click();
                  toastr.success('Berhasil')
                };
              }
            });
          } else {
            e.preventDefault();
            $('#simpan').click();
          }
        }
      })
    });
    // end form modal klik simpan/edit


    // form edit

    // form edit
    function func_edit(id) {
      $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
        if (!json.user_id) {
          fun_notifLogout();
        } else {
          fun_loading();
          $('#word_wajib_bintang').hide();
          $('#pdf_wajib_bintang').hide();
          $('#simpan').css('display', 'none');
          $('#edit').css('display', 'block');
          $('#div_word_lama').css('display', 'block');
          $('#div_pdf_lama').css('display', 'block');

          $.getJSON('<?= base_url('document/pengajuan/getDataPengajuan') ?>', {
            transaksi_id: id
          }, function(json) {
            // console.log(json);
            $.each(json, function(index, val) {
              $('#' + index).val(val);
            });

            func_no_doc();
            func_jenis_no_doc();

            $('#tanggal').val(json.transaksi_tgl_pengajuan);
            $('#judul_document').val(json.transaksi_judul_document);
            $('#revisi').val(json.transaksi_revisi);
            $('#terbitan').val(json.transaksi_terbitan);
            $('#file_word_lama').val(json.transaksi_file_word);
            $('#file_pdf_lama').val(json.transaksi_file_pdf);
            $('#keterangan').val(json.transaksi_keterangan_document);
            $('#nomor_document').val(json.transaksi_nomor_document);


            $('#jenis_document').append('<option selected value="' + json.jenis_id + '">' + json.jenis_nama + '</option>');
            $('#jenis_document').select2('data', {
              id: json.jenis_id,
              text: json.jenis_nama
            });
            // $('#jenis_document').trigger('change');

            $('#seksi').append('<option selected value="' + json.seksi_id + '">' + json.seksi_nama + '</option>');
            $('#seksi').select2('data', {
              id: json.seksi_id,
              text: json.seksi_nama
            });
            // $('#seksi').trigger('change');

          });
        }
      });
    }
    // start tombol tambah
    function func_tambah() {
      $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
        if (!json.user_id) {
          fun_notifLogout();
        } else {
          fun_loading();
          func_tanggal();
        }
      });
    }
    // end tombol tambah

    // start hapus
    function func_hapus(isi) {
      $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
        if (!json.user_id) {
          fun_notifLogout();
        } else {
          fun_loading();
          console.log(isi);
          $.confirmModal('Yakin hapus dokumen ?', function(el) {
            $.post('<?= base_url('document/pengajuan/hapusPengajuan') ?>', {
              transaksi_id: isi
            }, function(data) {
              fun_loading();
              $('#close').click();
              toastr.success('Berhasil');
            })
          })
        }
      });
    }
    // end hapus


    function func_lihat(data) {
      $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
        if (!json.user_id) {
          fun_notifLogout();
        } else {
          $('#div_document').append('<embed src="<?= base_url('upload/') ?>' + data + '#toolbar=0" frameborder="0" id="document" width="100%">');
        }
      });
    }
    // lihat document

    function func_cekNomorKembar(data) {
      $.getJSON('<?= base_url('document/pengajuan/getNomorKembar') ?>', function(json) {
        $.each(json, function(index, val) {
          var data1 = val.transaksi_detail_nomor_document;
          var data2 = data;
          if (data1 === data2) {
            // toastr.error('Nomor Document Sudah Pernah Digunakan');
            // $('#simpan').hide();
            // }else{
            // $('#simpan').show();
            Swal.fire({ //swal untuk logout
              text: "Nomor Document Telah Digunakan, Harap Ganti Nomor Document",
              type: 'warning', //warning,error,success
              confirmButtonColor: "#FF4500", //red
              confirmButtonText: "OK", //"<i class='fa fa-thumbs-up'></i> Great!",
              allowOutsideClick: false, //tidak bisa di klik diluar
            }).then(function(result) { //ketika user menekan tombol ok
              if (result.value) { //jika user menekan tombol ok
                // location.href = '<?= base_url('login') ?>';//maka akan di alihkan ke halaman login
              }
            })
          }
        })
      })
    }

    function fun_close() {

      $('#word_wajib_bintang').show();
      $('#pdf_wajib_bintang').show();
      $('#simpan').css('display', 'block');
      $('#edit').css('display', 'none');
      $('#div_word_lama').css('display', 'none');
      $('#div_pdf_lama').css('display', 'none');
      $('#jenis_alert').css('display', 'none');
      $('#seksi_alert').css('display', 'none');
      $('#judul_alert').css('display', 'none');
      $('#tanggal_alert').css('display', 'none');
      $('#revisi_alert').css('display', 'none');
      $('#terbitan_alert').css('display', 'none');
      $('#keterangan_alert').css('display', 'none');
      $('#word_alert').css('display', 'none');
      $('#pdf_alert').css('display', 'none');
      $('#nomor_alert').css('display', 'none');
      $('#jenis_document').empty();
      $('#seksi').empty();
      $('#transaksi_id').empty();
      $('#form_modal')[0].reset();
      $('#table').DataTable().ajax.reload(null, false);
    }
    /* Fun Close */

    $('#modal').on('hidden.bs.modal', function(e) {
      fun_close();
    });

    function cekBulanKajian() {
      var d = new Date();
      var n = d.getMonth() + 1;
      if (n === 12) {
        toastr.info('Document Dalam Masa Kaji Ulang !!');
      }
    }

    window.onload = cekBulanKajian()

    function func_jenis_no_doc(isi) {
      var data = $('#seksi').val();
      $.getJSON('<?= base_url('document/pengajuan/getNomorDocument') ?>', {
        jenis_id: isi,
        seksi_id: data
      }, function(result, json) {
        $('#nomor_document').val(result.kodefinal)
        $('#transaksi_urut_document').val(result.kodeurut);
      })
      return;
    }

    function func_no_doc(isi) {
      var data = $('#jenis_document').val();
      $.getJSON('<?= base_url('document/pengajuan/getNomorDocument') ?>', {
        jenis_id: data,
        seksi_id: isi
      }, function(result, json) {
        $('#nomor_document').val(result.kodefinal)
        $('#transaksi_urut_document').val(result.kodeurut);
      })
      return;
    }

    function fun_no_kosong() {
      // $('#nomor_document').val('');
      // alert('tes');
    }



    /* Fun Loading */
    function fun_loading() {
      var simplebar = new Nanobar();
      simplebar.go(100);
    }
    /* Fun Loading */
  </script>