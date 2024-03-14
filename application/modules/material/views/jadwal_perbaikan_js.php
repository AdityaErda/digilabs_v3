<script type="text/javascript">
  function fun_tahun(id) {
    id = $('#tahun_cari').val();
    return id;
    // console.log(id);
  }

  $(function() {
    $('#tanggal_cari').daterangepicker({
      locale: {
        format: 'DD-MM-YYYY'
      },
    })
    /* Isi Table */
    $('#table').DataTable({
      "lengthMenu": [
        [5, 10, 25, 50, -1],
        [5, 10, 25, 50, "All"]
      ],
      "dom": 'lBfrtip',
      "buttons": ["csv", "pdf", "excel", "copy", "print"],
      fixedColumns: {
        leftColumns: 6,
        // rightColumns:1,
      },
      scrollX: true,
      scrollCollapse: true,
      ordering: false,
      autoWidth: true,
      initComplete: function() {
        $('.dataTables_scrollHead').on('scroll', function() {
          $('.dataTables_scrollBody').scrollLeft($(this).scrollLeft());
          $('.DTFC_LeftBodyWrapper').css('top', '15px');

        });
      },
      "ajax": {
        "url": "<?= base_url() ?>/material/jadwal_perbaikan/getJadwalPerbaikan?tahun_cari=<?= date('Y') ?>",
        "dataSrc": ""
      },
      "columns": [{
          "data": "aset_nomor_utama"
        },
        {
          "data": "aset_nama"
        },
        {
          "data": "aset_nomor"
        },
        {
          "data": "peminta_jasa_nama"
        },
        {
          "data": "aset_perbaikan_vendor"
        },
        // {"data" : "aset_perbaikan_status"},
        {
          "render": function(data, type, full, meta) {
            var status_perbaikan = '';
            var tanggal_deadline = new Date(full.aset_perbaikan_tgl_deadline);
            var tanggal_selesai = new Date(full.aset_perbaikan_tgl_selesai);
            if (full.aset_perbaikan_status == 'n') {
              status_perbaikan = 'Pengajuan';
            } else if (full.aset_perbaikan_status == 'k') {
              status_perbaikan = 'Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p') {
              status_perbaikan = 'Pending';
            } else if (full.aset_perbaikan_status == 'y' && tanggal_selesai > tanggal_deadline) {
              status_perbaikan = 'Selesai Melebihi Deadline';
            } else if (full.aset_perbaikan_status == 'y') {
              status_perbaikan = 'Selesai';
            } else if (full.aset_perbaikan_status == 't') {
              status_perbaikan = 'Terjadwal';
            }
            return status_perbaikan;
          }
        },

        {
          "render": function(data, type, full, meta) {
            var status_warna = '';
            var status_warna = '';

            var date1 = new Date(full.aset_perbaikan_tgl_deadline);
            currentdate1 = new Date();
            var oneJan1 = new Date(fun_tahun(data), 0, currentdate1.getDay());
            // console.log(oneJan1);
            var numberOfDays1 = Math.floor((date1 - oneJan1) / (24 * 60 * 60 * 1000));
            var result1 = Math.ceil((currentdate1.getDay() + 1 + numberOfDays1) / 7);

            currentdate = new Date();
            var oneJan = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var oneJan2 = new Date(fun_tahun(data), 0, 7);
            var numberOfDays = Math.floor((oneJan2 - oneJan) / (24 * 60 * 60 * 1000));
            var result = Math.ceil((currentdate.getDay() + 1 + numberOfDays) / 7);

            var date2 = new Date(full.aset_perbaikan_tgl_selesai);
            currentdate2 = new Date();
            var oneJan2 = new Date(fun_tahun(data), 0, 0);
            var numberOfDays2 = Math.floor((date2 - oneJan2) / (24 * 60 * 60 * 1000));
            var result2 = Math.ceil((currentdate2.getDay() + 1 + numberOfDays2) / 7);
            currentdate3 = new Date();
            var oneJan3 = new Date(fun_tahun(data), 0, 0);
            var oneJan4 = new Date(fun_tahun(data), 0, 7);
            var numberOfDays3 = Math.floor((oneJan4 - oneJan3) / (24 * 60 * 60 * 1000));
            var result3 = Math.ceil((currentdate3.getDay() + 1 + numberOfDays3) / 7);


            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#DA70D6';
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#8A2BE2';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Perbaikan Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Terjadwal';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500'
              status_text = 'Kalibrasi Terjadwal';
            }

            // return '<i style="color: '+status_warna+'" class="fa fa-circle"></i>';

            if (result == result1) {
              return '<i style="color: ' + status_warna + '" class="fa fa-circle"></i>';
            } else {
              return '';
            }
          }
        },

        {
          "render": function(data, type, full, meta) {
            var status_warna = '';
            var warna = '';
            var status_warna = '';
            var date = full.aset_perbaikan_tgl_deadline;
            var date1 = new Date(date);
            currentdate1 = new Date();
            var oneJan1 = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var numberOfDays1 = Math.floor((date1 - oneJan1) / (24 * 60 * 60 * 1000));
            var result1 = Math.ceil((currentdate1.getDay() + 1 + numberOfDays1) / 7);
            currentdate = new Date();
            var oneJan = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var oneJan2 = new Date(fun_tahun(data), 0, 15);
            var numberOfDays = Math.floor((oneJan2 - oneJan) / (24 * 60 * 60 * 1000));
            var result = Math.ceil((currentdate.getDay() + 1 + numberOfDays) / 7);

            var date2 = new Date(full.aset_perbaikan_tgl_selesai);
            currentdate2 = new Date();
            var oneJan2 = new Date(fun_tahun(data), 0, 0);
            var numberOfDays2 = Math.floor((date2 - oneJan2) / (24 * 60 * 60 * 1000));
            var result2 = Math.ceil((currentdate2.getDay() + 1 + numberOfDays2) / 7);
            currentdate3 = new Date();
            var oneJan3 = new Date(fun_tahun(data), 0, 0);
            var oneJan4 = new Date(fun_tahun(data), 0, 15);
            var numberOfDays3 = Math.floor((oneJan4 - oneJan3) / (24 * 60 * 60 * 1000));
            var result3 = Math.ceil((currentdate3.getDay() + 1 + numberOfDays3) / 7);

            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#DA70D6';
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#8A2BE2';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Perbaikan Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Terjadwal';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500'
              status_text = 'Kalibrasi Terjadwal';
            }


            if (result == result1) {
              return '<i style="color: ' + status_warna + '" class="fa fa-circle"></i>';
            } else {
              return '';
            }
          }
        },

        {
          "render": function(data, type, full, meta) {
            var status_warna = '';
            var warna = '';
            var status_warna = '';
            var date = full.aset_perbaikan_tgl_deadline;
            var date1 = new Date(date);
            currentdate1 = new Date();
            var oneJan1 = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var numberOfDays1 = Math.floor((date1 - oneJan1) / (24 * 60 * 60 * 1000));
            var result1 = Math.ceil((currentdate1.getDay() + 1 + numberOfDays1) / 7);


            currentdate = new Date();
            var oneJan = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var oneJan2 = new Date(fun_tahun(data), 0, 22);
            var numberOfDays = Math.floor((oneJan2 - oneJan) / (24 * 60 * 60 * 1000));
            var result = Math.ceil((currentdate.getDay() + 1 + numberOfDays) / 7);

            var date2 = new Date(full.aset_perbaikan_tgl_selesai);
            currentdate2 = new Date();
            var oneJan2 = new Date(fun_tahun(data), 0, 0);
            var numberOfDays2 = Math.floor((date2 - oneJan2) / (24 * 60 * 60 * 1000));
            var result2 = Math.ceil((currentdate2.getDay() + 1 + numberOfDays2) / 7);
            currentdate3 = new Date();
            var oneJan3 = new Date(fun_tahun(data), 0, 0);
            var oneJan4 = new Date(fun_tahun(data), 0, 22);
            var numberOfDays3 = Math.floor((oneJan4 - oneJan3) / (24 * 60 * 60 * 1000));
            var result3 = Math.ceil((currentdate3.getDay() + 1 + numberOfDays3) / 7);

            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#DA70D6';
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#8A2BE2';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Perbaikan Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Terjadwal';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500'
              status_text = 'Kalibrasi Terjadwal';
            }


            if (result == result1) {
              return '<i style="color: ' + status_warna + '" class="fa fa-circle"></i>';
            } else {
              return '';
            }

          }
        },

        {
          "render": function(data, type, full, meta) {
            var status_warna = '';
            var warna = '';
            var status_warna = '';
            var date = full.aset_perbaikan_tgl_deadline;
            var date1 = new Date(date);
            currentdate1 = new Date();
            var oneJan1 = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var numberOfDays1 = Math.floor((date1 - oneJan1) / (24 * 60 * 60 * 1000));
            var result1 = Math.ceil((currentdate1.getDay() + 1 + numberOfDays1) / 7);


            currentdate = new Date();
            var oneJan = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var oneJan2 = new Date(fun_tahun(data), 0, 29);
            var numberOfDays = Math.floor((oneJan2 - oneJan) / (24 * 60 * 60 * 1000));
            var result = Math.ceil((currentdate.getDay() + 1 + numberOfDays) / 7);

            var date2 = new Date(full.aset_perbaikan_tgl_selesai);
            currentdate2 = new Date();
            var oneJan2 = new Date(fun_tahun(data), 0, 0);
            var numberOfDays2 = Math.floor((date2 - oneJan2) / (24 * 60 * 60 * 1000));
            var result2 = Math.ceil((currentdate2.getDay() + 1 + numberOfDays2) / 7);
            currentdate3 = new Date();
            var oneJan3 = new Date(fun_tahun(data), 0, 0);
            var oneJan4 = new Date(fun_tahun(data), 0, 29);
            var numberOfDays3 = Math.floor((oneJan4 - oneJan3) / (24 * 60 * 60 * 1000));
            var result3 = Math.ceil((currentdate3.getDay() + 1 + numberOfDays3) / 7);

            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#DA70D6';
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#8A2BE2';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Perbaikan Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Terjadwal';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500'
              status_text = 'Kalibrasi Terjadwal';
            }


            if (result == result1) {
              return '<i style="color: ' + status_warna + '" class="fa fa-circle"></i>';
            } else {
              return '';
            }

          }
        },

        {
          "render": function(data, type, full, meta) {

            var status_warna = '';
            var warna = '';
            var status_warna = '';
            var date = full.aset_perbaikan_tgl_deadline;
            var date1 = new Date(date);
            currentdate1 = new Date();
            var oneJan1 = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var numberOfDays1 = Math.floor((date1 - oneJan1) / (24 * 60 * 60 * 1000));
            var result1 = Math.ceil((currentdate1.getDay() + 1 + numberOfDays1) / 7);


            currentdate = new Date();
            var oneJan = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var oneJan2 = new Date(fun_tahun(data), 1, 7);
            var numberOfDays = Math.floor((oneJan2 - oneJan) / (24 * 60 * 60 * 1000));
            var result = Math.ceil((currentdate.getDay() + 1 + numberOfDays) / 7);

            var date2 = new Date(full.aset_perbaikan_tgl_selesai);
            currentdate2 = new Date();
            var oneJan2 = new Date(fun_tahun(data), 0, 0);
            var numberOfDays2 = Math.floor((date2 - oneJan2) / (24 * 60 * 60 * 1000));
            var result2 = Math.ceil((currentdate2.getDay() + 1 + numberOfDays2) / 7);
            currentdate3 = new Date();
            var oneJan3 = new Date(fun_tahun(data), 0, 0);
            var oneJan4 = new Date(fun_tahun(data), 1, 7);
            var numberOfDays3 = Math.floor((oneJan4 - oneJan3) / (24 * 60 * 60 * 1000));
            var result3 = Math.ceil((currentdate3.getDay() + 1 + numberOfDays3) / 7);

            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#DA70D6';
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#8A2BE2';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Perbaikan Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Terjadwal';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500'
              status_text = 'Kalibrasi Terjadwal';
            }


            if (result == result1) {
              return '<i style="color: ' + status_warna + '" class="fa fa-circle"></i>';
            } else {
              return '';
            }

          }
        },
        {
          "render": function(data, type, full, meta) {
            var status_warna = '';
            var warna = '';
            var status_warna = '';
            var date = full.aset_perbaikan_tgl_deadline;
            var date1 = new Date(date);
            currentdate1 = new Date();
            var oneJan1 = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var numberOfDays1 = Math.floor((date1 - oneJan1) / (24 * 60 * 60 * 1000));
            var result1 = Math.ceil((currentdate1.getDay() + 1 + numberOfDays1) / 7);


            currentdate = new Date();
            var oneJan = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var oneJan2 = new Date(fun_tahun(data), 1, 15);
            var numberOfDays = Math.floor((oneJan2 - oneJan) / (24 * 60 * 60 * 1000));
            var result = Math.ceil((currentdate.getDay() + 1 + numberOfDays) / 7);

            var date2 = new Date(full.aset_perbaikan_tgl_selesai);
            currentdate2 = new Date();
            var oneJan2 = new Date(fun_tahun(data), 0, 0);
            var numberOfDays2 = Math.floor((date2 - oneJan2) / (24 * 60 * 60 * 1000));
            var result2 = Math.ceil((currentdate2.getDay() + 1 + numberOfDays2) / 7);
            currentdate3 = new Date();
            var oneJan3 = new Date(fun_tahun(data), 0, 0);
            var oneJan4 = new Date(fun_tahun(data), 1, 15);
            var numberOfDays3 = Math.floor((oneJan4 - oneJan3) / (24 * 60 * 60 * 1000));
            var result3 = Math.ceil((currentdate3.getDay() + 1 + numberOfDays3) / 7);

            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#DA70D6';
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#8A2BE2';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Perbaikan Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Terjadwal';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500'
              status_text = 'Kalibrasi Terjadwal';
            }


            if (result == result1) {
              return '<i style="color: ' + status_warna + '" class="fa fa-circle"></i>';
            } else {
              return '';
            }
          }
        },

        {
          "render": function(data, type, full, meta) {
            var status_warna = '';
            var warna = '';
            var status_warna = '';
            var date = full.aset_perbaikan_tgl_deadline;
            var date1 = new Date(date);
            currentdate1 = new Date();
            var oneJan1 = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var numberOfDays1 = Math.floor((date1 - oneJan1) / (24 * 60 * 60 * 1000));
            var result1 = Math.ceil((currentdate1.getDay() + 1 + numberOfDays1) / 7);


            currentdate = new Date();
            var oneJan = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var oneJan2 = new Date(fun_tahun(data), 1, 22);
            var numberOfDays = Math.floor((oneJan2 - oneJan) / (24 * 60 * 60 * 1000));
            var result = Math.ceil((currentdate.getDay() + 1 + numberOfDays) / 7);

            var date2 = new Date(full.aset_perbaikan_tgl_selesai);
            currentdate2 = new Date();
            var oneJan2 = new Date(fun_tahun(data), 0, 0);
            var numberOfDays2 = Math.floor((date2 - oneJan2) / (24 * 60 * 60 * 1000));
            var result2 = Math.ceil((currentdate2.getDay() + 1 + numberOfDays2) / 7);
            currentdate3 = new Date();
            var oneJan3 = new Date(fun_tahun(data), 0, 0);
            var oneJan4 = new Date(fun_tahun(data), 1, 22);
            var numberOfDays3 = Math.floor((oneJan4 - oneJan3) / (24 * 60 * 60 * 1000));
            var result3 = Math.ceil((currentdate3.getDay() + 1 + numberOfDays3) / 7);

            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#DA70D6';
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#8A2BE2';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Perbaikan Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Terjadwal';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500'
              status_text = 'Kalibrasi Terjadwal';
            }


            if (result == result1) {
              return '<i style="color: ' + status_warna + '" class="fa fa-circle"></i>';
            } else {
              return '';
            }
          }
        },
        {
          "render": function(data, type, full, meta) {
            var status_warna = '';
            var warna = '';
            var status_warna = '';
            var date = full.aset_perbaikan_tgl_deadline;
            var date1 = new Date(date);
            currentdate1 = new Date();
            var oneJan1 = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var numberOfDays1 = Math.floor((date1 - oneJan1) / (24 * 60 * 60 * 1000));
            var result1 = Math.ceil((currentdate1.getDay() + 1 + numberOfDays1) / 7);


            currentdate = new Date();
            var oneJan = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var oneJan2 = new Date(fun_tahun(data), 1, 29);
            var numberOfDays = Math.floor((oneJan2 - oneJan) / (24 * 60 * 60 * 1000));
            var result = Math.ceil((currentdate.getDay() + 1 + numberOfDays) / 7);

            var date2 = new Date(full.aset_perbaikan_tgl_selesai);
            currentdate2 = new Date();
            var oneJan2 = new Date(fun_tahun(data), 0, 0);
            var numberOfDays2 = Math.floor((date2 - oneJan2) / (24 * 60 * 60 * 1000));
            var result2 = Math.ceil((currentdate2.getDay() + 1 + numberOfDays2) / 7);
            currentdate3 = new Date();
            var oneJan3 = new Date(fun_tahun(data), 0, 0);
            var oneJan4 = new Date(fun_tahun(data), 1, 29);
            var numberOfDays3 = Math.floor((oneJan4 - oneJan3) / (24 * 60 * 60 * 1000));
            var result3 = Math.ceil((currentdate3.getDay() + 1 + numberOfDays3) / 7);

            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#DA70D6';
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#8A2BE2';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Perbaikan Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Terjadwal';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500'
              status_text = 'Kalibrasi Terjadwal';
            }


            if (result == result1) {
              return '<i style="color: ' + status_warna + '" class="fa fa-circle"></i>';
            } else {
              return '';
            }
          }
        },
        {
          "render": function(data, type, full, meta) {
            var status_warna = '';
            var warna = '';
            var status_warna = '';
            var date = full.aset_perbaikan_tgl_deadline;
            var date1 = new Date(date);
            currentdate1 = new Date();
            var oneJan1 = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var numberOfDays1 = Math.floor((date1 - oneJan1) / (24 * 60 * 60 * 1000));
            var result1 = Math.ceil((currentdate1.getDay() + 1 + numberOfDays1) / 7);


            currentdate = new Date();
            var oneJan = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var oneJan2 = new Date(fun_tahun(data), 2, 7);
            var numberOfDays = Math.floor((oneJan2 - oneJan) / (24 * 60 * 60 * 1000));
            var result = Math.ceil((currentdate.getDay() + 1 + numberOfDays) / 7);

            var date2 = new Date(full.aset_perbaikan_tgl_selesai);
            currentdate2 = new Date();
            var oneJan2 = new Date(fun_tahun(data), 0, 0);
            var numberOfDays2 = Math.floor((date2 - oneJan2) / (24 * 60 * 60 * 1000));
            var result2 = Math.ceil((currentdate2.getDay() + 1 + numberOfDays2) / 7);
            currentdate3 = new Date();
            var oneJan3 = new Date(fun_tahun(data), 0, 0);
            var oneJan4 = new Date(fun_tahun(data), 2, 7);
            var numberOfDays3 = Math.floor((oneJan4 - oneJan3) / (24 * 60 * 60 * 1000));
            var result3 = Math.ceil((currentdate3.getDay() + 1 + numberOfDays3) / 7);

            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#DA70D6';
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#8A2BE2';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Perbaikan Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Terjadwal';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500'
              status_text = 'Kalibrasi Terjadwal';
            }


            if (result == result1) {
              return '<i style="color: ' + status_warna + '" class="fa fa-circle"></i>';
            } else {
              return '';
            }
          }
        },
        {
          "render": function(data, type, full, meta) {
            var status_warna = '';
            var warna = '';
            var status_warna = '';
            var date = full.aset_perbaikan_tgl_deadline;
            var date1 = new Date(date);
            currentdate1 = new Date();
            var oneJan1 = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var numberOfDays1 = Math.floor((date1 - oneJan1) / (24 * 60 * 60 * 1000));
            var result1 = Math.ceil((currentdate1.getDay() + 1 + numberOfDays1) / 7);


            currentdate = new Date();
            var oneJan = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var oneJan2 = new Date(fun_tahun(data), 2, 15);
            var numberOfDays = Math.floor((oneJan2 - oneJan) / (24 * 60 * 60 * 1000));
            var result = Math.ceil((currentdate.getDay() + 1 + numberOfDays) / 7);

            var date2 = new Date(full.aset_perbaikan_tgl_selesai);
            currentdate2 = new Date();
            var oneJan2 = new Date(fun_tahun(data), 0, 0);
            var numberOfDays2 = Math.floor((date2 - oneJan2) / (24 * 60 * 60 * 1000));
            var result2 = Math.ceil((currentdate2.getDay() + 1 + numberOfDays2) / 7);
            currentdate3 = new Date();
            var oneJan3 = new Date(fun_tahun(data), 0, 0);
            var oneJan4 = new Date(fun_tahun(data), 2, 15);
            var numberOfDays3 = Math.floor((oneJan4 - oneJan3) / (24 * 60 * 60 * 1000));
            var result3 = Math.ceil((currentdate3.getDay() + 1 + numberOfDays3) / 7);

            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#DA70D6';
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#8A2BE2';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Perbaikan Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Terjadwal';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500'
              status_text = 'Kalibrasi Terjadwal';
            }


            if (result == result1) {
              return '<i style="color: ' + status_warna + '" class="fa fa-circle"></i>';
            } else {
              return '';
            }
          }
        },
        {
          "render": function(data, type, full, meta) {
            var status_warna = '';
            var warna = '';
            var status_warna = '';
            var date = full.aset_perbaikan_tgl_deadline;
            var date1 = new Date(date);
            currentdate1 = new Date();
            var oneJan1 = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var numberOfDays1 = Math.floor((date1 - oneJan1) / (24 * 60 * 60 * 1000));
            var result1 = Math.ceil((currentdate1.getDay() + 1 + numberOfDays1) / 7);


            currentdate = new Date();
            var oneJan = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var oneJan2 = new Date(fun_tahun(data), 2, 22);
            var numberOfDays = Math.floor((oneJan2 - oneJan) / (24 * 60 * 60 * 1000));
            var result = Math.ceil((currentdate.getDay() + 1 + numberOfDays) / 7);

            var date2 = new Date(full.aset_perbaikan_tgl_selesai);
            currentdate2 = new Date();
            var oneJan2 = new Date(fun_tahun(data), 0, 0);
            var numberOfDays2 = Math.floor((date2 - oneJan2) / (24 * 60 * 60 * 1000));
            var result2 = Math.ceil((currentdate2.getDay() + 1 + numberOfDays2) / 7);
            currentdate3 = new Date();
            var oneJan3 = new Date(fun_tahun(data), 0, 0);
            var oneJan4 = new Date(fun_tahun(data), 2, 22);
            var numberOfDays3 = Math.floor((oneJan4 - oneJan3) / (24 * 60 * 60 * 1000));
            var result3 = Math.ceil((currentdate3.getDay() + 1 + numberOfDays3) / 7);

            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#DA70D6';
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#8A2BE2';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Perbaikan Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Terjadwal';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500'
              status_text = 'Kalibrasi Terjadwal';
            }


            if (result == result1) {
              return '<i style="color: ' + status_warna + '" class="fa fa-circle"></i>';
            } else {
              return '';
            }
          }
        },
        {
          "render": function(data, type, full, meta) {
            var status_warna = '';
            var warna = '';
            var status_warna = '';
            var date = full.aset_perbaikan_tgl_deadline;
            var date1 = new Date(date);
            currentdate1 = new Date();
            var oneJan1 = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var numberOfDays1 = Math.floor((date1 - oneJan1) / (24 * 60 * 60 * 1000));
            var result1 = Math.ceil((currentdate1.getDay() + 1 + numberOfDays1) / 7);


            currentdate = new Date();
            var oneJan = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var oneJan2 = new Date(fun_tahun(data), 2, 29);
            var numberOfDays = Math.floor((oneJan2 - oneJan) / (24 * 60 * 60 * 1000));
            var result = Math.ceil((currentdate.getDay() + 1 + numberOfDays) / 7);

            var date2 = new Date(full.aset_perbaikan_tgl_selesai);
            currentdate2 = new Date();
            var oneJan2 = new Date(fun_tahun(data), 0, 0);
            var numberOfDays2 = Math.floor((date2 - oneJan2) / (24 * 60 * 60 * 1000));
            var result2 = Math.ceil((currentdate2.getDay() + 1 + numberOfDays2) / 7);
            currentdate3 = new Date();
            var oneJan3 = new Date(fun_tahun(data), 0, 0);
            var oneJan4 = new Date(fun_tahun(data), 2, 29);
            var numberOfDays3 = Math.floor((oneJan4 - oneJan3) / (24 * 60 * 60 * 1000));
            var result3 = Math.ceil((currentdate3.getDay() + 1 + numberOfDays3) / 7);

            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#DA70D6';
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#8A2BE2';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Perbaikan Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Terjadwal';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500'
              status_text = 'Kalibrasi Terjadwal';
            }


            if (result == result1) {
              return '<i style="color: ' + status_warna + '" class="fa fa-circle"></i>';
            } else {
              return '';
            }
          }
        },
        {
          "render": function(data, type, full, meta) {
            var status_warna = '';
            var warna = '';
            var status_warna = '';
            var date = full.aset_perbaikan_tgl_deadline;
            var date1 = new Date(date);
            currentdate1 = new Date();
            var oneJan1 = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var numberOfDays1 = Math.floor((date1 - oneJan1) / (24 * 60 * 60 * 1000));
            var result1 = Math.ceil((currentdate1.getDay() + 1 + numberOfDays1) / 7);


            currentdate = new Date();
            var oneJan = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var oneJan2 = new Date(fun_tahun(data), 3, 7);
            var numberOfDays = Math.floor((oneJan2 - oneJan) / (24 * 60 * 60 * 1000));
            var result = Math.ceil((currentdate.getDay() + 1 + numberOfDays) / 7);

            var date2 = new Date(full.aset_perbaikan_tgl_selesai);
            currentdate2 = new Date();
            var oneJan2 = new Date(fun_tahun(data), 0, 0);
            var numberOfDays2 = Math.floor((date2 - oneJan2) / (24 * 60 * 60 * 1000));
            var result2 = Math.ceil((currentdate2.getDay() + 1 + numberOfDays2) / 7);
            currentdate3 = new Date();
            var oneJan3 = new Date(fun_tahun(data), 0, 0);
            var oneJan4 = new Date(fun_tahun(data), 3, 7);
            var numberOfDays3 = Math.floor((oneJan4 - oneJan3) / (24 * 60 * 60 * 1000));
            var result3 = Math.ceil((currentdate3.getDay() + 1 + numberOfDays3) / 7);

            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#DA70D6';
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#8A2BE2';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Perbaikan Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Terjadwal';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500'
              status_text = 'Kalibrasi Terjadwal';
            }


            if (result == result1) {
              return '<i style="color: ' + status_warna + '" class="fa fa-circle"></i>';
            } else {
              return '';
            }
          }
        },
        {
          "render": function(data, type, full, meta) {
            var status_warna = '';
            var warna = '';
            var status_warna = '';
            var date = full.aset_perbaikan_tgl_deadline;
            var date1 = new Date(date);
            currentdate1 = new Date();
            var oneJan1 = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var numberOfDays1 = Math.floor((date1 - oneJan1) / (24 * 60 * 60 * 1000));
            var result1 = Math.ceil((currentdate1.getDay() + 1 + numberOfDays1) / 7);
            currentdate = new Date();
            var oneJan = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var oneJan2 = new Date(fun_tahun(data), 3, 15);
            var numberOfDays = Math.floor((oneJan2 - oneJan) / (24 * 60 * 60 * 1000));
            var result = Math.ceil((currentdate.getDay() + 1 + numberOfDays) / 7);

            var date2 = new Date(full.aset_perbaikan_tgl_selesai);
            currentdate2 = new Date();
            var oneJan2 = new Date(fun_tahun(data), 0, 0);
            var numberOfDays2 = Math.floor((date2 - oneJan2) / (24 * 60 * 60 * 1000));
            var result2 = Math.ceil((currentdate2.getDay() + 1 + numberOfDays2) / 7);
            currentdate3 = new Date();
            var oneJan3 = new Date(fun_tahun(data), 0, 0);
            var oneJan4 = new Date(fun_tahun(data), 3, 15);
            var numberOfDays3 = Math.floor((oneJan4 - oneJan3) / (24 * 60 * 60 * 1000));
            var result3 = Math.ceil((currentdate3.getDay() + 1 + numberOfDays3) / 7);

            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#DA70D6';
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#8A2BE2';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Perbaikan Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Terjadwal';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500'
              status_text = 'Kalibrasi Terjadwal';
            }


            if (result == result1) {
              return '<i style="color: ' + status_warna + '" class="fa fa-circle"></i>';
            } else {
              return '';
            }
          }
        },
        {
          "render": function(data, type, full, meta) {
            var status_warna = '';
            var warna = '';
            var status_warna = '';
            var date = full.aset_perbaikan_tgl_deadline;
            var date1 = new Date(date);
            currentdate1 = new Date();
            var oneJan1 = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var numberOfDays1 = Math.floor((date1 - oneJan1) / (24 * 60 * 60 * 1000));
            var result1 = Math.ceil((currentdate1.getDay() + 1 + numberOfDays1) / 7);


            currentdate = new Date();
            var oneJan = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var oneJan2 = new Date(fun_tahun(data), 3, 22);
            var numberOfDays = Math.floor((oneJan2 - oneJan) / (24 * 60 * 60 * 1000));
            var result = Math.ceil((currentdate.getDay() + 1 + numberOfDays) / 7);

            var date2 = new Date(full.aset_perbaikan_tgl_selesai);
            currentdate2 = new Date();
            var oneJan2 = new Date(fun_tahun(data), 0, 0);
            var numberOfDays2 = Math.floor((date2 - oneJan2) / (24 * 60 * 60 * 1000));
            var result2 = Math.ceil((currentdate2.getDay() + 1 + numberOfDays2) / 7);
            currentdate3 = new Date();
            var oneJan3 = new Date(fun_tahun(data), 0, 0);
            var oneJan4 = new Date(fun_tahun(data), 3, 22);
            var numberOfDays3 = Math.floor((oneJan4 - oneJan3) / (24 * 60 * 60 * 1000));
            var result3 = Math.ceil((currentdate3.getDay() + 1 + numberOfDays3) / 7);

            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#DA70D6';
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#8A2BE2';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Perbaikan Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Terjadwal';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500'
              status_text = 'Kalibrasi Terjadwal';
            }


            if (result == result1) {
              return '<i style="color: ' + status_warna + '" class="fa fa-circle"></i>';
            } else {
              return '';
            }
          }
        },
        {
          "render": function(data, type, full, meta) {
            var status_warna = '';
            var warna = '';
            var status_warna = '';
            var date = full.aset_perbaikan_tgl_deadline;
            var date1 = new Date(date);
            currentdate1 = new Date();
            var oneJan1 = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var numberOfDays1 = Math.floor((date1 - oneJan1) / (24 * 60 * 60 * 1000));
            var result1 = Math.ceil((currentdate1.getDay() + 1 + numberOfDays1) / 7);


            currentdate = new Date();
            var oneJan = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var oneJan2 = new Date(fun_tahun(data), 3, 29);
            var numberOfDays = Math.floor((oneJan2 - oneJan) / (24 * 60 * 60 * 1000));
            var result = Math.ceil((currentdate.getDay() + 1 + numberOfDays) / 7);

            var date2 = new Date(full.aset_perbaikan_tgl_selesai);
            currentdate2 = new Date();
            var oneJan2 = new Date(fun_tahun(data), 0, 0);
            var numberOfDays2 = Math.floor((date2 - oneJan2) / (24 * 60 * 60 * 1000));
            var result2 = Math.ceil((currentdate2.getDay() + 1 + numberOfDays2) / 7);
            currentdate3 = new Date();
            var oneJan3 = new Date(fun_tahun(data), 0, 0);
            var oneJan4 = new Date(fun_tahun(data), 3, 29);
            var numberOfDays3 = Math.floor((oneJan4 - oneJan3) / (24 * 60 * 60 * 1000));
            var result3 = Math.ceil((currentdate3.getDay() + 1 + numberOfDays3) / 7);

            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#DA70D6';
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#8A2BE2';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Perbaikan Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Terjadwal';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500'
              status_text = 'Kalibrasi Terjadwal';
            }


            if (result == result1) {
              return '<i style="color: ' + status_warna + '" class="fa fa-circle"></i>';
            } else {
              return '';
            }
          }
        },
        {
          "render": function(data, type, full, meta) {
            var status_warna = '';
            var warna = '';
            var status_warna = '';
            var date = full.aset_perbaikan_tgl_deadline;
            var date1 = new Date(date);
            currentdate1 = new Date();
            var oneJan1 = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var numberOfDays1 = Math.floor((date1 - oneJan1) / (24 * 60 * 60 * 1000));
            var result1 = Math.ceil((currentdate1.getDay() + 1 + numberOfDays1) / 7);


            currentdate = new Date();
            var oneJan = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var oneJan2 = new Date(fun_tahun(data), 4, 7);
            var numberOfDays = Math.floor((oneJan2 - oneJan) / (24 * 60 * 60 * 1000));
            var result = Math.ceil((currentdate.getDay() + 1 + numberOfDays) / 7);

            var date2 = new Date(full.aset_perbaikan_tgl_selesai);
            currentdate2 = new Date();
            var oneJan2 = new Date(fun_tahun(data), 0, 0);
            var numberOfDays2 = Math.floor((date2 - oneJan2) / (24 * 60 * 60 * 1000));
            var result2 = Math.ceil((currentdate2.getDay() + 1 + numberOfDays2) / 7);
            currentdate3 = new Date();
            var oneJan3 = new Date(fun_tahun(data), 0, 0);
            var oneJan4 = new Date(fun_tahun(data), 4, 7);
            var numberOfDays3 = Math.floor((oneJan4 - oneJan3) / (24 * 60 * 60 * 1000));
            var result3 = Math.ceil((currentdate3.getDay() + 1 + numberOfDays3) / 7);

            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#DA70D6';
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#8A2BE2';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Perbaikan Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Terjadwal';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500'
              status_text = 'Kalibrasi Terjadwal';
            }


            if (result == result1) {
              return '<i style="color: ' + status_warna + '" class="fa fa-circle"></i>';
            } else {
              return '';
            }
          }
        },
        {
          "render": function(data, type, full, meta) {
            var status_warna = '';
            var warna = '';
            var status_warna = '';
            var date = full.aset_perbaikan_tgl_deadline;
            var date1 = new Date(date);
            currentdate1 = new Date();
            var oneJan1 = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var numberOfDays1 = Math.floor((date1 - oneJan1) / (24 * 60 * 60 * 1000));
            var result1 = Math.ceil((currentdate1.getDay() + 1 + numberOfDays1) / 7);


            currentdate = new Date();
            var oneJan = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var oneJan2 = new Date(fun_tahun(data), 4, 15);
            var numberOfDays = Math.floor((oneJan2 - oneJan) / (24 * 60 * 60 * 1000));
            var result = Math.ceil((currentdate.getDay() + 1 + numberOfDays) / 7);

            var date2 = new Date(full.aset_perbaikan_tgl_selesai);
            currentdate2 = new Date();
            var oneJan2 = new Date(fun_tahun(data), 0, 0);
            var numberOfDays2 = Math.floor((date2 - oneJan2) / (24 * 60 * 60 * 1000));
            var result2 = Math.ceil((currentdate2.getDay() + 1 + numberOfDays2) / 7);
            currentdate3 = new Date();
            var oneJan3 = new Date(fun_tahun(data), 0, 0);
            var oneJan4 = new Date(fun_tahun(data), 4, 15);
            var numberOfDays3 = Math.floor((oneJan4 - oneJan3) / (24 * 60 * 60 * 1000));
            var result3 = Math.ceil((currentdate3.getDay() + 1 + numberOfDays3) / 7);

            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#DA70D6';
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#8A2BE2';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Perbaikan Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Terjadwal';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500'
              status_text = 'Kalibrasi Terjadwal';
            }


            if (result == result1) {
              return '<i style="color: ' + status_warna + '" class="fa fa-circle"></i>';
            } else {
              return '';
            }
          }
        },
        {
          "render": function(data, type, full, meta) {
            var status_warna = '';
            var warna = '';
            var status_warna = '';
            var date = full.aset_perbaikan_tgl_deadline;
            var date1 = new Date(date);
            currentdate1 = new Date();
            var oneJan1 = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var numberOfDays1 = Math.floor((date1 - oneJan1) / (24 * 60 * 60 * 1000));
            var result1 = Math.ceil((currentdate1.getDay() + 1 + numberOfDays1) / 7);


            currentdate = new Date();
            var oneJan = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var oneJan2 = new Date(fun_tahun(data), 4, 22);
            var numberOfDays = Math.floor((oneJan2 - oneJan) / (24 * 60 * 60 * 1000));
            var result = Math.ceil((currentdate.getDay() + 1 + numberOfDays) / 7);

            var date2 = new Date(full.aset_perbaikan_tgl_selesai);
            currentdate2 = new Date();
            var oneJan2 = new Date(fun_tahun(data), 0, 0);
            var numberOfDays2 = Math.floor((date2 - oneJan2) / (24 * 60 * 60 * 1000));
            var result2 = Math.ceil((currentdate2.getDay() + 1 + numberOfDays2) / 7);
            currentdate3 = new Date();
            var oneJan3 = new Date(fun_tahun(data), 0, 0);
            var oneJan4 = new Date(fun_tahun(data), 4, 22);
            var numberOfDays3 = Math.floor((oneJan4 - oneJan3) / (24 * 60 * 60 * 1000));
            var result3 = Math.ceil((currentdate3.getDay() + 1 + numberOfDays3) / 7);

            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#DA70D6';
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#8A2BE2';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Perbaikan Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Terjadwal';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500'
              status_text = 'Kalibrasi Terjadwal';
            }


            if (result == result1) {
              return '<i style="color: ' + status_warna + '" class="fa fa-circle"></i>';
            } else {
              return '';
            }
          }
        },
        {
          "render": function(data, type, full, meta) {
            var status_warna = '';
            var warna = '';
            var status_warna = '';
            var date = full.aset_perbaikan_tgl_deadline;
            var date1 = new Date(date);
            currentdate1 = new Date();
            var oneJan1 = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var numberOfDays1 = Math.floor((date1 - oneJan1) / (24 * 60 * 60 * 1000));
            var result1 = Math.ceil((currentdate1.getDay() + 1 + numberOfDays1) / 7);


            currentdate = new Date();
            var oneJan = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var oneJan2 = new Date(fun_tahun(data), 4, 29);
            var numberOfDays = Math.floor((oneJan2 - oneJan) / (24 * 60 * 60 * 1000));
            var result = Math.ceil((currentdate.getDay() + 1 + numberOfDays) / 7);

            var date2 = new Date(full.aset_perbaikan_tgl_selesai);
            currentdate2 = new Date();
            var oneJan2 = new Date(fun_tahun(data), 0, 0);
            var numberOfDays2 = Math.floor((date2 - oneJan2) / (24 * 60 * 60 * 1000));
            var result2 = Math.ceil((currentdate2.getDay() + 1 + numberOfDays2) / 7);
            currentdate3 = new Date();
            var oneJan3 = new Date(fun_tahun(data), 0, 0);
            var oneJan4 = new Date(fun_tahun(data), 4, 29);
            var numberOfDays3 = Math.floor((oneJan4 - oneJan3) / (24 * 60 * 60 * 1000));
            var result3 = Math.ceil((currentdate3.getDay() + 1 + numberOfDays3) / 7);

            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#DA70D6';
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#8A2BE2';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Perbaikan Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Terjadwal';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500'
              status_text = 'Kalibrasi Terjadwal';
            }


            if (result == result1) {
              return '<i style="color: ' + status_warna + '" class="fa fa-circle"></i>';
            } else {
              return '';
            }
          }
        },
        {
          "render": function(data, type, full, meta) {
            var status_warna = '';
            var warna = '';
            var status_warna = '';
            var date = full.aset_perbaikan_tgl_deadline;
            var date1 = new Date(date);
            currentdate1 = new Date();
            var oneJan1 = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var numberOfDays1 = Math.floor((date1 - oneJan1) / (24 * 60 * 60 * 1000));
            var result1 = Math.ceil((currentdate1.getDay() + 1 + numberOfDays1) / 7);


            currentdate = new Date();
            var oneJan = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var oneJan2 = new Date(fun_tahun(data), 5, 7);
            var numberOfDays = Math.floor((oneJan2 - oneJan) / (24 * 60 * 60 * 1000));
            var result = Math.ceil((currentdate.getDay() + 1 + numberOfDays) / 7);

            var date2 = new Date(full.aset_perbaikan_tgl_selesai);
            currentdate2 = new Date();
            var oneJan2 = new Date(fun_tahun(data), 0, 0);
            var numberOfDays2 = Math.floor((date2 - oneJan2) / (24 * 60 * 60 * 1000));
            var result2 = Math.ceil((currentdate2.getDay() + 1 + numberOfDays2) / 7);
            currentdate3 = new Date();
            var oneJan3 = new Date(fun_tahun(data), 0, 0);
            var oneJan4 = new Date(fun_tahun(data), 5, 7);
            var numberOfDays3 = Math.floor((oneJan4 - oneJan3) / (24 * 60 * 60 * 1000));
            var result3 = Math.ceil((currentdate3.getDay() + 1 + numberOfDays3) / 7);

            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#DA70D6';
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#8A2BE2';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Perbaikan Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Terjadwal';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500'
              status_text = 'Kalibrasi Terjadwal';
            }


            if (result == result1) {
              return '<i style="color: ' + status_warna + '" class="fa fa-circle"></i>';
            } else {
              return '';
            }
          }
        },
        {
          "render": function(data, type, full, meta) {
            var status_warna = '';
            var warna = '';
            var status_warna = '';
            var date = full.aset_perbaikan_tgl_deadline;
            var date1 = new Date(date);
            currentdate1 = new Date();
            var oneJan1 = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var numberOfDays1 = Math.floor((date1 - oneJan1) / (24 * 60 * 60 * 1000));
            var result1 = Math.ceil((currentdate1.getDay() + 1 + numberOfDays1) / 7);


            currentdate = new Date();
            var oneJan = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var oneJan2 = new Date(fun_tahun(data), 5, 15);
            var numberOfDays = Math.floor((oneJan2 - oneJan) / (24 * 60 * 60 * 1000));
            var result = Math.ceil((currentdate.getDay() + 1 + numberOfDays) / 7);

            var date2 = new Date(full.aset_perbaikan_tgl_selesai);
            currentdate2 = new Date();
            var oneJan2 = new Date(fun_tahun(data), 0, 0);
            var numberOfDays2 = Math.floor((date2 - oneJan2) / (24 * 60 * 60 * 1000));
            var result2 = Math.ceil((currentdate2.getDay() + 1 + numberOfDays2) / 7);
            currentdate3 = new Date();
            var oneJan3 = new Date(fun_tahun(data), 0, 0);
            var oneJan4 = new Date(fun_tahun(data), 5, 15);
            var numberOfDays3 = Math.floor((oneJan4 - oneJan3) / (24 * 60 * 60 * 1000));
            var result3 = Math.ceil((currentdate3.getDay() + 1 + numberOfDays3) / 7);

            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#DA70D6';
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#8A2BE2';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Perbaikan Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Terjadwal';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500'
              status_text = 'Kalibrasi Terjadwal';
            }


            if (result == result1) {
              return '<i style="color: ' + status_warna + '" class="fa fa-circle"></i>';
            } else {
              return '';
            }
          }
        },
        {
          "render": function(data, type, full, meta) {
            var status_warna = '';
            var warna = '';
            var status_warna = '';
            var date = full.aset_perbaikan_tgl_deadline;
            var date1 = new Date(date);
            currentdate1 = new Date();
            var oneJan1 = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var numberOfDays1 = Math.floor((date1 - oneJan1) / (24 * 60 * 60 * 1000));
            var result1 = Math.ceil((currentdate1.getDay() + 1 + numberOfDays1) / 7);


            currentdate = new Date();
            var oneJan = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var oneJan2 = new Date(fun_tahun(data), 5, 22);
            var numberOfDays = Math.floor((oneJan2 - oneJan) / (24 * 60 * 60 * 1000));
            var result = Math.ceil((currentdate.getDay() + 1 + numberOfDays) / 7);

            var date2 = new Date(full.aset_perbaikan_tgl_selesai);
            currentdate2 = new Date();
            var oneJan2 = new Date(fun_tahun(data), 0, 0);
            var numberOfDays2 = Math.floor((date2 - oneJan2) / (24 * 60 * 60 * 1000));
            var result2 = Math.ceil((currentdate2.getDay() + 1 + numberOfDays2) / 7);
            currentdate3 = new Date();
            var oneJan3 = new Date(fun_tahun(data), 0, 0);
            var oneJan4 = new Date(fun_tahun(data), 5, 22);
            var numberOfDays3 = Math.floor((oneJan4 - oneJan3) / (24 * 60 * 60 * 1000));
            var result3 = Math.ceil((currentdate3.getDay() + 1 + numberOfDays3) / 7);

            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#DA70D6';
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#8A2BE2';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Perbaikan Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Terjadwal';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500'
              status_text = 'Kalibrasi Terjadwal';
            }


            if (result == result1) {
              return '<i style="color: ' + status_warna + '" class="fa fa-circle"></i>';
            } else {
              return '';
            }
          }
        },
        {
          "render": function(data, type, full, meta) {
            var status_warna = '';
            var warna = '';
            var status_warna = '';
            var date = full.aset_perbaikan_tgl_deadline;
            var date1 = new Date(date);
            currentdate1 = new Date();
            var oneJan1 = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var numberOfDays1 = Math.floor((date1 - oneJan1) / (24 * 60 * 60 * 1000));
            var result1 = Math.ceil((currentdate1.getDay() + 1 + numberOfDays1) / 7);


            currentdate = new Date();
            var oneJan = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var oneJan2 = new Date(fun_tahun(data), 5, 29);
            var numberOfDays = Math.floor((oneJan2 - oneJan) / (24 * 60 * 60 * 1000));
            var result = Math.ceil((currentdate.getDay() + 1 + numberOfDays) / 7);

            var date2 = new Date(full.aset_perbaikan_tgl_selesai);
            currentdate2 = new Date();
            var oneJan2 = new Date(fun_tahun(data), 0, 0);
            var numberOfDays2 = Math.floor((date2 - oneJan2) / (24 * 60 * 60 * 1000));
            var result2 = Math.ceil((currentdate2.getDay() + 1 + numberOfDays2) / 7);
            currentdate3 = new Date();
            var oneJan3 = new Date(fun_tahun(data), 0, 0);
            var oneJan4 = new Date(fun_tahun(data), 5, 29);
            var numberOfDays3 = Math.floor((oneJan4 - oneJan3) / (24 * 60 * 60 * 1000));
            var result3 = Math.ceil((currentdate3.getDay() + 1 + numberOfDays3) / 7);

            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#DA70D6';
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#8A2BE2';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Perbaikan Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Terjadwal';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500'
              status_text = 'Kalibrasi Terjadwal';
            }


            if (result == result1) {
              return '<i style="color: ' + status_warna + '" class="fa fa-circle"></i>';
            } else {
              return '';
            }
          }
        },
        {
          "render": function(data, type, full, meta) {
            var status_warna = '';
            var warna = '';
            var status_warna = '';
            var date = full.aset_perbaikan_tgl_deadline;
            var date1 = new Date(date);
            currentdate1 = new Date();
            var oneJan1 = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var numberOfDays1 = Math.floor((date1 - oneJan1) / (24 * 60 * 60 * 1000));
            var result1 = Math.ceil((currentdate1.getDay() + 1 + numberOfDays1) / 7);


            currentdate = new Date();
            var oneJan = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var oneJan2 = new Date(fun_tahun(data), 6, 7);
            var numberOfDays = Math.floor((oneJan2 - oneJan) / (24 * 60 * 60 * 1000));
            var result = Math.ceil((currentdate.getDay() + 1 + numberOfDays) / 7);

            var date2 = new Date(full.aset_perbaikan_tgl_selesai);
            currentdate2 = new Date();
            var oneJan2 = new Date(fun_tahun(data), 0, 0);
            var numberOfDays2 = Math.floor((date2 - oneJan2) / (24 * 60 * 60 * 1000));
            var result2 = Math.ceil((currentdate2.getDay() + 1 + numberOfDays2) / 7);
            currentdate3 = new Date();
            var oneJan3 = new Date(fun_tahun(data), 0, 0);
            var oneJan4 = new Date(fun_tahun(data), 6, 7);
            var numberOfDays3 = Math.floor((oneJan4 - oneJan3) / (24 * 60 * 60 * 1000));
            var result3 = Math.ceil((currentdate3.getDay() + 1 + numberOfDays3) / 7);

            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#DA70D6';
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#8A2BE2';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Perbaikan Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Terjadwal';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500'
              status_text = 'Kalibrasi Terjadwal';
            }


            if (result == result1) {
              return '<i style="color: ' + status_warna + '" class="fa fa-circle"></i>';
            } else {
              return '';
            }
          }
        },
        {
          "render": function(data, type, full, meta) {
            var status_warna = '';
            var warna = '';
            var status_warna = '';
            var date = full.aset_perbaikan_tgl_deadline;
            var date1 = new Date(date);
            currentdate1 = new Date();
            var oneJan1 = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var numberOfDays1 = Math.floor((date1 - oneJan1) / (24 * 60 * 60 * 1000));
            var result1 = Math.ceil((currentdate1.getDay() + 1 + numberOfDays1) / 7);


            currentdate = new Date();
            var oneJan = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var oneJan2 = new Date(fun_tahun(data), 6, 15);
            var numberOfDays = Math.floor((oneJan2 - oneJan) / (24 * 60 * 60 * 1000));
            var result = Math.ceil((currentdate.getDay() + 1 + numberOfDays) / 7);

            var date2 = new Date(full.aset_perbaikan_tgl_selesai);
            currentdate2 = new Date();
            var oneJan2 = new Date(fun_tahun(data), 0, 0);
            var numberOfDays2 = Math.floor((date2 - oneJan2) / (24 * 60 * 60 * 1000));
            var result2 = Math.ceil((currentdate2.getDay() + 1 + numberOfDays2) / 7);
            currentdate3 = new Date();
            var oneJan3 = new Date(fun_tahun(data), 0, 0);
            var oneJan4 = new Date(fun_tahun(data), 6, 15);
            var numberOfDays3 = Math.floor((oneJan4 - oneJan3) / (24 * 60 * 60 * 1000));
            var result3 = Math.ceil((currentdate3.getDay() + 1 + numberOfDays3) / 7);

            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#DA70D6';
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#8A2BE2';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Perbaikan Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Terjadwal';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500'
              status_text = 'Kalibrasi Terjadwal';
            }


            if (result == result1) {
              return '<i style="color: ' + status_warna + '" class="fa fa-circle"></i>';
            } else {
              return '';
            }
          }
        },
        {
          "render": function(data, type, full, meta) {
            var status_warna = '';
            var warna = '';
            var status_warna = '';
            var date = full.aset_perbaikan_tgl_deadline;
            var date1 = new Date(date);
            currentdate1 = new Date();
            var oneJan1 = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var numberOfDays1 = Math.floor((date1 - oneJan1) / (24 * 60 * 60 * 1000));
            var result1 = Math.ceil((currentdate1.getDay() + 1 + numberOfDays1) / 7);


            currentdate = new Date();
            var oneJan = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var oneJan2 = new Date(fun_tahun(data), 6, 22);
            var numberOfDays = Math.floor((oneJan2 - oneJan) / (24 * 60 * 60 * 1000));
            var result = Math.ceil((currentdate.getDay() + 1 + numberOfDays) / 7);

            var date2 = new Date(full.aset_perbaikan_tgl_selesai);
            currentdate2 = new Date();
            var oneJan2 = new Date(fun_tahun(data), 0, 0);
            var numberOfDays2 = Math.floor((date2 - oneJan2) / (24 * 60 * 60 * 1000));
            var result2 = Math.ceil((currentdate2.getDay() + 1 + numberOfDays2) / 7);
            currentdate3 = new Date();
            var oneJan3 = new Date(fun_tahun(data), 0, 0);
            var oneJan4 = new Date(fun_tahun(data), 6, 22);
            var numberOfDays3 = Math.floor((oneJan4 - oneJan3) / (24 * 60 * 60 * 1000));
            var result3 = Math.ceil((currentdate3.getDay() + 1 + numberOfDays3) / 7);

            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#DA70D6';
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#8A2BE2';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Perbaikan Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Terjadwal';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500'
              status_text = 'Kalibrasi Terjadwal';
            }


            if (result == result1) {
              return '<i style="color: ' + status_warna + '" class="fa fa-circle"></i>';
            } else {
              return '';
            }
          }
        },
        {
          "render": function(data, type, full, meta) {
            var status_warna = '';
            var warna = '';
            var status_warna = '';
            var date = full.aset_perbaikan_tgl_deadline;
            var date1 = new Date(date);
            currentdate1 = new Date();
            var oneJan1 = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var numberOfDays1 = Math.floor((date1 - oneJan1) / (24 * 60 * 60 * 1000));
            var result1 = Math.ceil((currentdate1.getDay() + 1 + numberOfDays1) / 7);


            currentdate = new Date();
            var oneJan = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var oneJan2 = new Date(fun_tahun(data), 6, 29);
            var numberOfDays = Math.floor((oneJan2 - oneJan) / (24 * 60 * 60 * 1000));
            var result = Math.ceil((currentdate.getDay() + 1 + numberOfDays) / 7);

            var date2 = new Date(full.aset_perbaikan_tgl_selesai);
            currentdate2 = new Date();
            var oneJan2 = new Date(fun_tahun(data), 0, 0);
            var numberOfDays2 = Math.floor((date2 - oneJan2) / (24 * 60 * 60 * 1000));
            var result2 = Math.ceil((currentdate2.getDay() + 1 + numberOfDays2) / 7);
            currentdate3 = new Date();
            var oneJan3 = new Date(fun_tahun(data), 0, 0);
            var oneJan4 = new Date(fun_tahun(data), 6, 29);
            var numberOfDays3 = Math.floor((oneJan4 - oneJan3) / (24 * 60 * 60 * 1000));
            var result3 = Math.ceil((currentdate3.getDay() + 1 + numberOfDays3) / 7);

            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#DA70D6';
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#8A2BE2';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Perbaikan Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Terjadwal';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500'
              status_text = 'Kalibrasi Terjadwal';
            }


            if (result == result1) {
              return '<i style="color: ' + status_warna + '" class="fa fa-circle"></i>';
            } else {
              return '';
            }
          }
        },
        {
          "render": function(data, type, full, meta) {
            var status_warna = '';
            var warna = '';
            var status_warna = '';
            var date = full.aset_perbaikan_tgl_deadline;
            var date1 = new Date(date);
            currentdate1 = new Date();
            var oneJan1 = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var numberOfDays1 = Math.floor((date1 - oneJan1) / (24 * 60 * 60 * 1000));
            var result1 = Math.ceil((currentdate1.getDay() + 1 + numberOfDays1) / 7);


            currentdate = new Date();
            var oneJan = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var oneJan2 = new Date(fun_tahun(data), 7, 7);
            var numberOfDays = Math.floor((oneJan2 - oneJan) / (24 * 60 * 60 * 1000));
            var result = Math.ceil((currentdate.getDay() + 1 + numberOfDays) / 7);

            var date2 = new Date(full.aset_perbaikan_tgl_selesai);
            currentdate2 = new Date();
            var oneJan2 = new Date(fun_tahun(data), 0, 0);
            var numberOfDays2 = Math.floor((date2 - oneJan2) / (24 * 60 * 60 * 1000));
            var result2 = Math.ceil((currentdate2.getDay() + 1 + numberOfDays2) / 7);
            currentdate3 = new Date();
            var oneJan3 = new Date(fun_tahun(data), 0, 0);
            var oneJan4 = new Date(fun_tahun(data), 7, 7);
            var numberOfDays3 = Math.floor((oneJan4 - oneJan3) / (24 * 60 * 60 * 1000));
            var result3 = Math.ceil((currentdate3.getDay() + 1 + numberOfDays3) / 7);

            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#DA70D6';
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#8A2BE2';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Perbaikan Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Terjadwal';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500'
              status_text = 'Kalibrasi Terjadwal';
            }


            if (result == result1) {
              return '<i style="color: ' + status_warna + '" class="fa fa-circle"></i>';
            } else {
              return '';
            }
          }
        },
        {
          "render": function(data, type, full, meta) {
            var status_warna = '';
            var warna = '';
            var status_warna = '';
            var date = full.aset_perbaikan_tgl_deadline;
            var date1 = new Date(date);
            currentdate1 = new Date();
            var oneJan1 = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var numberOfDays1 = Math.floor((date1 - oneJan1) / (24 * 60 * 60 * 1000));
            var result1 = Math.ceil((currentdate1.getDay() + 1 + numberOfDays1) / 7);


            currentdate = new Date();
            var oneJan = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var oneJan2 = new Date(fun_tahun(data), 7, 15);
            var numberOfDays = Math.floor((oneJan2 - oneJan) / (24 * 60 * 60 * 1000));
            var result = Math.ceil((currentdate.getDay() + 1 + numberOfDays) / 7);

            var date2 = new Date(full.aset_perbaikan_tgl_selesai);
            currentdate2 = new Date();
            var oneJan2 = new Date(fun_tahun(data), 0, 0);
            var numberOfDays2 = Math.floor((date2 - oneJan2) / (24 * 60 * 60 * 1000));
            var result2 = Math.ceil((currentdate2.getDay() + 1 + numberOfDays2) / 7);
            currentdate3 = new Date();
            var oneJan3 = new Date(fun_tahun(data), 0, 0);
            var oneJan4 = new Date(fun_tahun(data), 7, 15);
            var numberOfDays3 = Math.floor((oneJan4 - oneJan3) / (24 * 60 * 60 * 1000));
            var result3 = Math.ceil((currentdate3.getDay() + 1 + numberOfDays3) / 7);

            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#DA70D6';
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#8A2BE2';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Perbaikan Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Terjadwal';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500'
              status_text = 'Kalibrasi Terjadwal';
            }


            if (result == result1) {
              return '<i style="color: ' + status_warna + '" class="fa fa-circle"></i>';
            } else {
              return '';
            }
          }
        },
        {
          "render": function(data, type, full, meta) {
            var status_warna = '';
            var warna = '';
            var status_warna = '';
            var date = full.aset_perbaikan_tgl_deadline;
            var date1 = new Date(date);
            currentdate1 = new Date();
            var oneJan1 = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var numberOfDays1 = Math.floor((date1 - oneJan1) / (24 * 60 * 60 * 1000));
            var result1 = Math.ceil((currentdate1.getDay() + 1 + numberOfDays1) / 7);


            currentdate = new Date();
            var oneJan = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var oneJan2 = new Date(fun_tahun(data), 7, 22);
            var numberOfDays = Math.floor((oneJan2 - oneJan) / (24 * 60 * 60 * 1000));
            var result = Math.ceil((currentdate.getDay() + 1 + numberOfDays) / 7);

            var date2 = new Date(full.aset_perbaikan_tgl_selesai);
            currentdate2 = new Date();
            var oneJan2 = new Date(fun_tahun(data), 0, 0);
            var numberOfDays2 = Math.floor((date2 - oneJan2) / (24 * 60 * 60 * 1000));
            var result2 = Math.ceil((currentdate2.getDay() + 1 + numberOfDays2) / 7);
            currentdate3 = new Date();
            var oneJan3 = new Date(fun_tahun(data), 0, 0);
            var oneJan4 = new Date(fun_tahun(data), 7, 22);
            var numberOfDays3 = Math.floor((oneJan4 - oneJan3) / (24 * 60 * 60 * 1000));
            var result3 = Math.ceil((currentdate3.getDay() + 1 + numberOfDays3) / 7);

            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#DA70D6';
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#8A2BE2';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Perbaikan Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Terjadwal';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500'
              status_text = 'Kalibrasi Terjadwal';
            }


            if (result == result1) {
              return '<i style="color: ' + status_warna + '" class="fa fa-circle"></i>';
            } else {
              return '';
            }
          }
        },
        {
          "render": function(data, type, full, meta) {
            var status_warna = '';
            var warna = '';
            var status_warna = '';
            var date = full.aset_perbaikan_tgl_deadline;
            var date1 = new Date(date);
            currentdate1 = new Date();
            var oneJan1 = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var numberOfDays1 = Math.floor((date1 - oneJan1) / (24 * 60 * 60 * 1000));
            var result1 = Math.ceil((currentdate1.getDay() + 1 + numberOfDays1) / 7);


            currentdate = new Date();
            var oneJan = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var oneJan2 = new Date(fun_tahun(data), 7, 29);
            var numberOfDays = Math.floor((oneJan2 - oneJan) / (24 * 60 * 60 * 1000));
            var result = Math.ceil((currentdate.getDay() + 1 + numberOfDays) / 7);

            var date2 = new Date(full.aset_perbaikan_tgl_selesai);
            currentdate2 = new Date();
            var oneJan2 = new Date(fun_tahun(data), 0, 0);
            var numberOfDays2 = Math.floor((date2 - oneJan2) / (24 * 60 * 60 * 1000));
            var result2 = Math.ceil((currentdate2.getDay() + 1 + numberOfDays2) / 7);
            currentdate3 = new Date();
            var oneJan3 = new Date(fun_tahun(data), 0, 0);
            var oneJan4 = new Date(fun_tahun(data), 7, 29);
            var numberOfDays3 = Math.floor((oneJan4 - oneJan3) / (24 * 60 * 60 * 1000));
            var result3 = Math.ceil((currentdate3.getDay() + 1 + numberOfDays3) / 7);

            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#DA70D6';
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#8A2BE2';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Perbaikan Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Terjadwal';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500'
              status_text = 'Kalibrasi Terjadwal';
            }


            if (result == result1) {
              return '<i style="color: ' + status_warna + '" class="fa fa-circle"></i>';
            } else {
              return '';
            }
          }
        },
        {
          "render": function(data, type, full, meta) {
            var status_warna = '';
            var warna = '';
            var status_warna = '';
            var date = full.aset_perbaikan_tgl_deadline;
            var date1 = new Date(date);
            currentdate1 = new Date();
            var oneJan1 = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var numberOfDays1 = Math.floor((date1 - oneJan1) / (24 * 60 * 60 * 1000));
            var result1 = Math.ceil((currentdate1.getDay() + 1 + numberOfDays1) / 7);


            currentdate = new Date();
            var oneJan = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var oneJan2 = new Date(fun_tahun(data), 8, 7);
            var numberOfDays = Math.floor((oneJan2 - oneJan) / (24 * 60 * 60 * 1000));
            var result = Math.ceil((currentdate.getDay() + 1 + numberOfDays) / 7);

            var date2 = new Date(full.aset_perbaikan_tgl_selesai);
            currentdate2 = new Date();
            var oneJan2 = new Date(fun_tahun(data), 0, 0);
            var numberOfDays2 = Math.floor((date2 - oneJan2) / (24 * 60 * 60 * 1000));
            var result2 = Math.ceil((currentdate2.getDay() + 1 + numberOfDays2) / 7);
            currentdate3 = new Date();
            var oneJan3 = new Date(fun_tahun(data), 0, 0);
            var oneJan4 = new Date(fun_tahun(data), 8, 7);
            var numberOfDays3 = Math.floor((oneJan4 - oneJan3) / (24 * 60 * 60 * 1000));
            var result3 = Math.ceil((currentdate3.getDay() + 1 + numberOfDays3) / 7);

            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#DA70D6';
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#8A2BE2';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Perbaikan Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Terjadwal';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500'
              status_text = 'Kalibrasi Terjadwal';
            }


            if (result == result1) {
              return '<i style="color: ' + status_warna + '" class="fa fa-circle"></i>';
            } else {
              return '';
            }
          }
        },
        {
          "render": function(data, type, full, meta) {
            var status_warna = '';
            var warna = '';
            var status_warna = '';
            var date = full.aset_perbaikan_tgl_deadline;
            var date1 = new Date(date);
            currentdate1 = new Date();
            var oneJan1 = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var numberOfDays1 = Math.floor((date1 - oneJan1) / (24 * 60 * 60 * 1000));
            var result1 = Math.ceil((currentdate1.getDay() + 1 + numberOfDays1) / 7);


            currentdate = new Date();
            var oneJan = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var oneJan2 = new Date(fun_tahun(data), 8, 15);
            var numberOfDays = Math.floor((oneJan2 - oneJan) / (24 * 60 * 60 * 1000));
            var result = Math.ceil((currentdate.getDay() + 1 + numberOfDays) / 7);

            var date2 = new Date(full.aset_perbaikan_tgl_selesai);
            currentdate2 = new Date();
            var oneJan2 = new Date(fun_tahun(data), 0, 0);
            var numberOfDays2 = Math.floor((date2 - oneJan2) / (24 * 60 * 60 * 1000));
            var result2 = Math.ceil((currentdate2.getDay() + 1 + numberOfDays2) / 7);
            currentdate3 = new Date();
            var oneJan3 = new Date(fun_tahun(data), 0, 0);
            var oneJan4 = new Date(fun_tahun(data), 8, 15);
            var numberOfDays3 = Math.floor((oneJan4 - oneJan3) / (24 * 60 * 60 * 1000));
            var result3 = Math.ceil((currentdate3.getDay() + 1 + numberOfDays3) / 7);
            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#DA70D6';
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#8A2BE2';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Perbaikan Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Terjadwal';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500'
              status_text = 'Kalibrasi Terjadwal';
            }


            if (result == result1) {
              return '<i style="color: ' + status_warna + '" class="fa fa-circle"></i>';
            } else {
              return '';
            }
          }
        },
        {
          "render": function(data, type, full, meta) {
            var status_warna = '';
            var warna = '';
            var status_warna = '';
            var date = full.aset_perbaikan_tgl_deadline;
            var date1 = new Date(date);
            currentdate1 = new Date();
            var oneJan1 = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var numberOfDays1 = Math.floor((date1 - oneJan1) / (24 * 60 * 60 * 1000));
            var result1 = Math.ceil((currentdate1.getDay() + 1 + numberOfDays1) / 7);


            currentdate = new Date();
            var oneJan = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var oneJan2 = new Date(fun_tahun(data), 8, 22);
            var numberOfDays = Math.floor((oneJan2 - oneJan) / (24 * 60 * 60 * 1000));
            var result = Math.ceil((currentdate.getDay() + 1 + numberOfDays) / 7);

            var date2 = new Date(full.aset_perbaikan_tgl_selesai);
            currentdate2 = new Date();
            var oneJan2 = new Date(fun_tahun(data), 0, 0);
            var numberOfDays2 = Math.floor((date2 - oneJan2) / (24 * 60 * 60 * 1000));
            var result2 = Math.ceil((currentdate2.getDay() + 1 + numberOfDays2) / 7);
            currentdate3 = new Date();
            var oneJan3 = new Date(fun_tahun(data), 0, 0);
            var oneJan4 = new Date(fun_tahun(data), 8, 22);
            var numberOfDays3 = Math.floor((oneJan4 - oneJan3) / (24 * 60 * 60 * 1000));
            var result3 = Math.ceil((currentdate3.getDay() + 1 + numberOfDays3) / 7);

            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#DA70D6';
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#8A2BE2';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Perbaikan Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Terjadwal';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500'
              status_text = 'Kalibrasi Terjadwal';
            }


            if (result == result1) {
              return '<i style="color: ' + status_warna + '" class="fa fa-circle"></i>';
            } else {
              return '';
            }
          }
        },
        {
          "render": function(data, type, full, meta) {
            var status_warna = '';
            var warna = '';
            var status_warna = '';
            var date = full.aset_perbaikan_tgl_deadline;
            var date1 = new Date(date);
            currentdate1 = new Date();
            var oneJan1 = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var numberOfDays1 = Math.floor((date1 - oneJan1) / (24 * 60 * 60 * 1000));
            var result1 = Math.ceil((currentdate1.getDay() + 1 + numberOfDays1) / 7);


            currentdate = new Date();
            var oneJan = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var oneJan2 = new Date(fun_tahun(data), 8, 29);
            var numberOfDays = Math.floor((oneJan2 - oneJan) / (24 * 60 * 60 * 1000));
            var result = Math.ceil((currentdate.getDay() + 1 + numberOfDays) / 7);

            var date2 = new Date(full.aset_perbaikan_tgl_selesai);
            currentdate2 = new Date();
            var oneJan2 = new Date(fun_tahun(data), 0, 0);
            var numberOfDays2 = Math.floor((date2 - oneJan2) / (24 * 60 * 60 * 1000));
            var result2 = Math.ceil((currentdate2.getDay() + 1 + numberOfDays2) / 7);
            currentdate3 = new Date();
            var oneJan3 = new Date(fun_tahun(data), 0, 0);
            var oneJan4 = new Date(fun_tahun(data), 8, 29);
            var numberOfDays3 = Math.floor((oneJan4 - oneJan3) / (24 * 60 * 60 * 1000));
            var result3 = Math.ceil((currentdate3.getDay() + 1 + numberOfDays3) / 7);

            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#DA70D6';
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#8A2BE2';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Perbaikan Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Terjadwal';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500'
              status_text = 'Kalibrasi Terjadwal';
            }


            if (result == result1) {
              return '<i style="color: ' + status_warna + '" class="fa fa-circle"></i>';
            } else {
              return '';
            }
          }
        },
        {
          "render": function(data, type, full, meta) {
            var status_warna = '';
            var warna = '';
            var status_warna = '';
            var date = full.aset_perbaikan_tgl_deadline;
            var date1 = new Date(date);
            currentdate1 = new Date();
            var oneJan1 = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var numberOfDays1 = Math.floor((date1 - oneJan1) / (24 * 60 * 60 * 1000));
            var result1 = Math.ceil((currentdate1.getDay() + 1 + numberOfDays1) / 7);


            currentdate = new Date();
            var oneJan = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var oneJan2 = new Date(fun_tahun(data), 9, 7);
            var numberOfDays = Math.floor((oneJan2 - oneJan) / (24 * 60 * 60 * 1000));
            var result = Math.ceil((currentdate.getDay() + 1 + numberOfDays) / 7);


            var date2 = new Date(full.aset_perbaikan_tgl_selesai);
            currentdate2 = new Date();
            var oneJan2 = new Date(fun_tahun(data), 0, 0);
            var numberOfDays2 = Math.floor((date2 - oneJan2) / (24 * 60 * 60 * 1000));
            var result2 = Math.ceil((currentdate2.getDay() + 1 + numberOfDays2) / 7);
            currentdate3 = new Date();
            var oneJan3 = new Date(fun_tahun(data), 0, 0);
            var oneJan4 = new Date(fun_tahun(data), 9, 7);
            var numberOfDays3 = Math.floor((oneJan4 - oneJan3) / (24 * 60 * 60 * 1000));
            var result3 = Math.ceil((currentdate3.getDay() + 1 + numberOfDays3) / 7);

            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#DA70D6';
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#8A2BE2';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Perbaikan Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Terjadwal';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500'
              status_text = 'Kalibrasi Terjadwal';
            }


            if (result == result1) {
              return '<i style="color: ' + status_warna + '" class="fa fa-circle"></i>';
            } else {
              return '';
            }
          }
        },
        {
          "render": function(data, type, full, meta) {
            var status_warna = '';
            var warna = '';
            var status_warna = '';
            var date = full.aset_perbaikan_tgl_deadline;
            var date1 = new Date(date);
            currentdate1 = new Date();
            var oneJan1 = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var numberOfDays1 = Math.floor((date1 - oneJan1) / (24 * 60 * 60 * 1000));
            var result1 = Math.ceil((currentdate1.getDay() + 1 + numberOfDays1) / 7);


            currentdate = new Date();
            var oneJan = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var oneJan2 = new Date(fun_tahun(data), 9, 15);
            var numberOfDays = Math.floor((oneJan2 - oneJan) / (24 * 60 * 60 * 1000));
            var result = Math.ceil((currentdate.getDay() + 1 + numberOfDays) / 7);

            var date2 = new Date(full.aset_perbaikan_tgl_selesai);
            currentdate2 = new Date();
            var oneJan2 = new Date(fun_tahun(data), 0, 0);
            var numberOfDays2 = Math.floor((date2 - oneJan2) / (24 * 60 * 60 * 1000));
            var result2 = Math.ceil((currentdate2.getDay() + 1 + numberOfDays2) / 7);
            currentdate3 = new Date();
            var oneJan3 = new Date(fun_tahun(data), 0, 0);
            var oneJan4 = new Date(fun_tahun(data), 9, 15);
            var numberOfDays3 = Math.floor((oneJan4 - oneJan3) / (24 * 60 * 60 * 1000));
            var result3 = Math.ceil((currentdate3.getDay() + 1 + numberOfDays3) / 7);

            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#DA70D6';
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#8A2BE2';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Perbaikan Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Terjadwal';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500'
              status_text = 'Kalibrasi Terjadwal';
            }


            if (result == result1) {
              return '<i style="color: ' + status_warna + '" class="fa fa-circle"></i>';
            } else {
              return '';
            }
          }
        },
        {
          "render": function(data, type, full, meta) {
            var status_warna = '';
            var warna = '';
            var status_warna = '';
            var date = full.aset_perbaikan_tgl_deadline;
            var date1 = new Date(date);
            currentdate1 = new Date();
            var oneJan1 = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var numberOfDays1 = Math.floor((date1 - oneJan1) / (24 * 60 * 60 * 1000));
            var result1 = Math.ceil((currentdate1.getDay() + 1 + numberOfDays1) / 7);


            currentdate = new Date();
            var oneJan = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var oneJan2 = new Date(fun_tahun(data), 9, 22);
            var numberOfDays = Math.floor((oneJan2 - oneJan) / (24 * 60 * 60 * 1000));
            var result = Math.ceil((currentdate.getDay() + 1 + numberOfDays) / 7);

            var date2 = new Date(full.aset_perbaikan_tgl_selesai);
            currentdate2 = new Date();
            var oneJan2 = new Date(fun_tahun(data), 0, 0);
            var numberOfDays2 = Math.floor((date2 - oneJan2) / (24 * 60 * 60 * 1000));
            var result2 = Math.ceil((currentdate2.getDay() + 1 + numberOfDays2) / 7);
            currentdate3 = new Date();
            var oneJan3 = new Date(fun_tahun(data), 0, 0);
            var oneJan4 = new Date(fun_tahun(data), 9, 22);
            var numberOfDays3 = Math.floor((oneJan4 - oneJan3) / (24 * 60 * 60 * 1000));
            var result3 = Math.ceil((currentdate3.getDay() + 1 + numberOfDays3) / 7);

            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#DA70D6';
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#8A2BE2';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Perbaikan Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Terjadwal';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500'
              status_text = 'Kalibrasi Terjadwal';
            }


            if (result == result1) {
              return '<i style="color: ' + status_warna + '" class="fa fa-circle"></i>';
            } else {
              return '';
            }
          }
        },
        {
          "render": function(data, type, full, meta) {
            var status_warna = '';
            var warna = '';
            var status_warna = '';
            var date = full.aset_perbaikan_tgl_deadline;
            var date1 = new Date(date);
            currentdate1 = new Date();
            var oneJan1 = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var numberOfDays1 = Math.floor((date1 - oneJan1) / (24 * 60 * 60 * 1000));
            var result1 = Math.ceil((currentdate1.getDay() + 1 + numberOfDays1) / 7);


            currentdate = new Date();
            var oneJan = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var oneJan2 = new Date(fun_tahun(data), 9, 29);
            var numberOfDays = Math.floor((oneJan2 - oneJan) / (24 * 60 * 60 * 1000));
            var result = Math.ceil((currentdate.getDay() + 1 + numberOfDays) / 7);

            var date2 = new Date(full.aset_perbaikan_tgl_selesai);
            currentdate2 = new Date();
            var oneJan2 = new Date(fun_tahun(data), 0, 0);
            var numberOfDays2 = Math.floor((date2 - oneJan2) / (24 * 60 * 60 * 1000));
            var result2 = Math.ceil((currentdate2.getDay() + 1 + numberOfDays2) / 7);
            currentdate3 = new Date();
            var oneJan3 = new Date(fun_tahun(data), 0, 0);
            var oneJan4 = new Date(fun_tahun(data), 9, 29);
            var numberOfDays3 = Math.floor((oneJan4 - oneJan3) / (24 * 60 * 60 * 1000));
            var result3 = Math.ceil((currentdate3.getDay() + 1 + numberOfDays3) / 7);

            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#DA70D6';
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#8A2BE2';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Perbaikan Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Terjadwal';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500'
              status_text = 'Kalibrasi Terjadwal';
            }


            if (result == result1) {
              return '<i style="color: ' + status_warna + '" class="fa fa-circle"></i>';
            } else {
              return '';
            }
          }
        },
        {
          "render": function(data, type, full, meta) {
            var status_warna = '';
            var warna = '';
            var status_warna = '';
            var date = full.aset_perbaikan_tgl_deadline;
            var date1 = new Date(date);
            currentdate1 = new Date();
            var oneJan1 = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var numberOfDays1 = Math.floor((date1 - oneJan1) / (24 * 60 * 60 * 1000));
            var result1 = Math.ceil((currentdate1.getDay() + 1 + numberOfDays1) / 7);


            currentdate = new Date();
            var oneJan = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var oneJan2 = new Date(fun_tahun(data), 10, 7);
            var numberOfDays = Math.floor((oneJan2 - oneJan) / (24 * 60 * 60 * 1000));
            var result = Math.ceil((currentdate.getDay() + 1 + numberOfDays) / 7);
            // console.log(result1);
            // console.log(result);
            // console.log(numberOfDays);

            var date2 = new Date(full.aset_perbaikan_tgl_selesai);
            currentdate2 = new Date();
            var oneJan2 = new Date(fun_tahun(data), 0, 0);
            var numberOfDays2 = Math.floor((date2 - oneJan2) / (24 * 60 * 60 * 1000));
            var result2 = Math.ceil((currentdate2.getDay() + 1 + numberOfDays2) / 7);
            currentdate3 = new Date();
            var oneJan3 = new Date(fun_tahun(data), 0, 0);
            var oneJan4 = new Date(fun_tahun(data), 10, 7);
            var numberOfDays3 = Math.floor((oneJan4 - oneJan3) / (24 * 60 * 60 * 1000));
            var result3 = Math.ceil((currentdate3.getDay() + 1 + numberOfDays3) / 7);

            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#DA70D6';
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#8A2BE2';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Perbaikan Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Terjadwal';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500'
              status_text = 'Kalibrasi Terjadwal';
            }


            if (result == result1) {
              return '<i style="color: ' + status_warna + '" class="fa fa-circle"></i>';
            } else {
              return '';
            }
          }
        },
        {
          "render": function(data, type, full, meta) {
            var status_warna = '';
            var warna = '';
            var status_warna = '';
            var date = full.aset_perbaikan_tgl_deadline;
            var date1 = new Date(date);
            currentdate1 = new Date();
            var oneJan1 = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var numberOfDays1 = Math.floor((date1 - oneJan1) / (24 * 60 * 60 * 1000));
            var result1 = Math.ceil((currentdate1.getDay() + 1 + numberOfDays1) / 7);


            currentdate = new Date();
            var oneJan = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var oneJan2 = new Date(fun_tahun(data), 10, 15);
            var numberOfDays = Math.floor((oneJan2 - oneJan) / (24 * 60 * 60 * 1000));
            var result = Math.ceil((currentdate.getDay() + 1 + numberOfDays) / 7);

            var date2 = new Date(full.aset_perbaikan_tgl_selesai);
            currentdate2 = new Date();
            var oneJan2 = new Date(fun_tahun(data), 0, 0);
            var numberOfDays2 = Math.floor((date2 - oneJan2) / (24 * 60 * 60 * 1000));
            var result2 = Math.ceil((currentdate2.getDay() + 1 + numberOfDays2) / 7);
            currentdate3 = new Date();
            var oneJan3 = new Date(fun_tahun(data), 0, 0);
            var oneJan4 = new Date(fun_tahun(data), 10, 15);
            var numberOfDays3 = Math.floor((oneJan4 - oneJan3) / (24 * 60 * 60 * 1000));
            var result3 = Math.ceil((currentdate3.getDay() + 1 + numberOfDays3) / 7);

            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#DA70D6';
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#8A2BE2';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Perbaikan Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Terjadwal';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500'
              status_text = 'Kalibrasi Terjadwal';
            }


            if (result == result1) {
              return '<i style="color: ' + status_warna + '" class="fa fa-circle"></i>';
            } else {
              return '';
            }
          }
        },
        {
          "render": function(data, type, full, meta) {
            var status_warna = '';
            var warna = '';
            var status_warna = '';
            var date = full.aset_perbaikan_tgl_deadline;
            var date1 = new Date(date);
            currentdate1 = new Date();
            var oneJan1 = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var numberOfDays1 = Math.floor((date1 - oneJan1) / (24 * 60 * 60 * 1000));
            var result1 = Math.ceil((currentdate1.getDay() + 1 + numberOfDays1) / 7);


            currentdate = new Date();
            var oneJan = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var oneJan2 = new Date(fun_tahun(data), 10, 22);
            var numberOfDays = Math.floor((oneJan2 - oneJan) / (24 * 60 * 60 * 1000));
            var result = Math.ceil((currentdate.getDay() + 1 + numberOfDays) / 7);

            var date2 = new Date(full.aset_perbaikan_tgl_selesai);
            currentdate2 = new Date();
            var oneJan2 = new Date(fun_tahun(data), 0, 0);
            var numberOfDays2 = Math.floor((date2 - oneJan2) / (24 * 60 * 60 * 1000));
            var result2 = Math.ceil((currentdate2.getDay() + 1 + numberOfDays2) / 7);
            currentdate3 = new Date();
            var oneJan3 = new Date(fun_tahun(data), 0, 0);
            var oneJan4 = new Date(fun_tahun(data), 10, 22);
            var numberOfDays3 = Math.floor((oneJan4 - oneJan3) / (24 * 60 * 60 * 1000));
            var result3 = Math.ceil((currentdate3.getDay() + 1 + numberOfDays3) / 7);

            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#DA70D6';
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#8A2BE2';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Perbaikan Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Terjadwal';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500'
              status_text = 'Kalibrasi Terjadwal';
            }


            if (result == result1) {
              return '<i style="color: ' + status_warna + '" class="fa fa-circle"></i>';
            } else {
              return '';
            }
          }
        },
        {
          "render": function(data, type, full, meta) {
            var status_warna = '';
            var warna = '';
            var status_warna = '';
            var date = full.aset_perbaikan_tgl_deadline;
            var date1 = new Date(date);
            currentdate1 = new Date();
            var oneJan1 = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var numberOfDays1 = Math.floor((date1 - oneJan1) / (24 * 60 * 60 * 1000));
            var result1 = Math.ceil((currentdate1.getDay() + 1 + numberOfDays1) / 7);


            currentdate = new Date();
            var oneJan = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var oneJan2 = new Date(fun_tahun(data), 10, 29);
            var numberOfDays = Math.floor((oneJan2 - oneJan) / (24 * 60 * 60 * 1000));
            var result = Math.ceil((currentdate.getDay() + 1 + numberOfDays) / 7);

            var date2 = new Date(full.aset_perbaikan_tgl_selesai);
            currentdate2 = new Date();
            var oneJan2 = new Date(fun_tahun(data), 0, 0);
            var numberOfDays2 = Math.floor((date2 - oneJan2) / (24 * 60 * 60 * 1000));
            var result2 = Math.ceil((currentdate2.getDay() + 1 + numberOfDays2) / 7);
            currentdate3 = new Date();
            var oneJan3 = new Date(fun_tahun(data), 0, 0);
            var oneJan4 = new Date(fun_tahun(data), 10, 29);
            var numberOfDays3 = Math.floor((oneJan4 - oneJan3) / (24 * 60 * 60 * 1000));
            var result3 = Math.ceil((currentdate3.getDay() + 1 + numberOfDays3) / 7);

            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#DA70D6';
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#8A2BE2';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Perbaikan Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Terjadwal';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500'
              status_text = 'Kalibrasi Terjadwal';
            }


            if (result == result1) {
              return '<i style="color: ' + status_warna + '" class="fa fa-circle"></i>';
            } else {
              return '';
            }
          }
        },
        {
          "render": function(data, type, full, meta) {
            var status_warna = '';
            var warna = '';
            var status_warna = '';
            var date = full.aset_perbaikan_tgl_deadline;
            var date1 = new Date(date);
            currentdate1 = new Date();
            var oneJan1 = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var numberOfDays1 = Math.floor((date1 - oneJan1) / (24 * 60 * 60 * 1000));
            var result1 = Math.ceil((currentdate1.getDay() + 1 + numberOfDays1) / 7);


            currentdate = new Date();
            var oneJan = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var oneJan2 = new Date(fun_tahun(data), 11, 7);
            var numberOfDays = Math.floor((oneJan2 - oneJan) / (24 * 60 * 60 * 1000));
            var result = Math.ceil((currentdate.getDay() + 1 + numberOfDays) / 7);

            var date2 = new Date(full.aset_perbaikan_tgl_selesai);
            currentdate2 = new Date();
            var oneJan2 = new Date(fun_tahun(data), 0, 0);
            var numberOfDays2 = Math.floor((date2 - oneJan2) / (24 * 60 * 60 * 1000));
            var result2 = Math.ceil((currentdate2.getDay() + 1 + numberOfDays2) / 7);
            currentdate3 = new Date();
            var oneJan3 = new Date(fun_tahun(data), 0, 0);
            var oneJan4 = new Date(fun_tahun(data), 11, 7);
            var numberOfDays3 = Math.floor((oneJan4 - oneJan3) / (24 * 60 * 60 * 1000));
            var result3 = Math.ceil((currentdate3.getDay() + 1 + numberOfDays3) / 7);

            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#DA70D6';
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#8A2BE2';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Perbaikan Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Terjadwal';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500'
              status_text = 'Kalibrasi Terjadwal';
            }


            if (result == result1) {
              return '<i style="color: ' + status_warna + '" class="fa fa-circle"></i>';
            } else {
              return '';
            }
          }
        },
        {
          "render": function(data, type, full, meta) {
            var status_warna = '';
            var warna = '';
            var status_warna = '';
            var date = full.aset_perbaikan_tgl_deadline;
            var date1 = new Date(date);
            currentdate1 = new Date();
            var oneJan1 = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var numberOfDays1 = Math.floor((date1 - oneJan1) / (24 * 60 * 60 * 1000));
            var result1 = Math.ceil((currentdate1.getDay() + 1 + numberOfDays1) / 7);


            currentdate = new Date();
            var oneJan = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var oneJan2 = new Date(fun_tahun(data), 11, 15);
            var numberOfDays = Math.floor((oneJan2 - oneJan) / (24 * 60 * 60 * 1000));
            var result = Math.ceil((currentdate.getDay() + 1 + numberOfDays) / 7);

            var date2 = new Date(full.aset_perbaikan_tgl_selesai);
            currentdate2 = new Date();
            var oneJan2 = new Date(fun_tahun(data), 0, 0);
            var numberOfDays2 = Math.floor((date2 - oneJan2) / (24 * 60 * 60 * 1000));
            var result2 = Math.ceil((currentdate2.getDay() + 1 + numberOfDays2) / 7);
            currentdate3 = new Date();
            var oneJan3 = new Date(fun_tahun(data), 0, 0);
            var oneJan4 = new Date(fun_tahun(data), 11, 15);
            var numberOfDays3 = Math.floor((oneJan4 - oneJan3) / (24 * 60 * 60 * 1000));
            var result3 = Math.ceil((currentdate3.getDay() + 1 + numberOfDays3) / 7);
            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#DA70D6';
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#8A2BE2';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Perbaikan Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Terjadwal';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500'
              status_text = 'Kalibrasi Terjadwal';
            }


            if (result == result1) {
              return '<i style="color: ' + status_warna + '" class="fa fa-circle"></i>';
            } else {
              return '';
            }
          }
        },
        {
          "render": function(data, type, full, meta) {
            var status_warna = '';
            var warna = '';
            var status_warna = '';
            var date = full.aset_perbaikan_tgl_deadline;
            var date1 = new Date(date);
            currentdate1 = new Date();
            var oneJan1 = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var numberOfDays1 = Math.floor((date1 - oneJan1) / (24 * 60 * 60 * 1000));
            var result1 = Math.ceil((currentdate1.getDay() + 1 + numberOfDays1) / 7);


            currentdate = new Date();
            var oneJan = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var oneJan2 = new Date(fun_tahun(data), 11, 22);
            var numberOfDays = Math.floor((oneJan2 - oneJan) / (24 * 60 * 60 * 1000));
            var result = Math.ceil((currentdate.getDay() + 1 + numberOfDays) / 7);

            var date2 = new Date(full.aset_perbaikan_tgl_selesai);
            currentdate2 = new Date();
            var oneJan2 = new Date(fun_tahun(data), 0, 0);
            var numberOfDays2 = Math.floor((date2 - oneJan2) / (24 * 60 * 60 * 1000));
            var result2 = Math.ceil((currentdate2.getDay() + 1 + numberOfDays2) / 7);
            currentdate3 = new Date();
            var oneJan3 = new Date(fun_tahun(data), 0, 0);
            var oneJan4 = new Date(fun_tahun(data), 11, 22);
            var numberOfDays3 = Math.floor((oneJan4 - oneJan3) / (24 * 60 * 60 * 1000));
            var result3 = Math.ceil((currentdate3.getDay() + 1 + numberOfDays3) / 7);

            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#DA70D6';
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#8A2BE2';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Perbaikan Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Terjadwal';
            } else if (full.aset_perbaikan_status == 't' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500'
              status_text = 'Kalibrasi Terjadwal';
            }


            if (result == result1) {
              return '<i style="color: ' + status_warna + '" class="fa fa-circle"></i>';
            } else {
              return '';
            }
          }
        },
        {
          "render": function(data, type, full, meta) {
            var status_warna = '';
            var warna = '';
            var status_warna = '';
            var date = full.aset_perbaikan_tgl_deadline;
            var date1 = new Date(date);
            currentdate1 = new Date();
            var oneJan1 = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var numberOfDays1 = Math.floor((date1 - oneJan1) / (24 * 60 * 60 * 1000));
            var result1 = Math.ceil((currentdate1.getDay() + 1 + numberOfDays1) / 7);


            currentdate = new Date();
            var oneJan = new Date(fun_tahun(data), 0, currentdate1.getDay());
            var oneJan2 = new Date(fun_tahun(data), 11, 29);
            var numberOfDays = Math.floor((oneJan2 - oneJan) / (24 * 60 * 60 * 1000));
            var result = Math.ceil((currentdate.getDay() + 1 + numberOfDays) / 7);

            var date2 = new Date(full.aset_perbaikan_tgl_selesai);
            currentdate2 = new Date();
            var oneJan2 = new Date(fun_tahun(data), 0, 0);
            var numberOfDays2 = Math.floor((date2 - oneJan2) / (24 * 60 * 60 * 1000));
            var result2 = Math.ceil((currentdate2.getDay() + 1 + numberOfDays2) / 7);
            currentdate3 = new Date();
            var oneJan3 = new Date(fun_tahun(data), 0, 0);
            var oneJan4 = new Date(fun_tahun(data), 11, 29);
            var numberOfDays3 = Math.floor((oneJan4 - oneJan3) / (24 * 60 * 60 * 1000));
            var result3 = Math.ceil((currentdate3.getDay() + 1 + numberOfDays3) / 7);

            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Perbaikan Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            }

            if (result == result1) {
              return '<i style="color: ' + status_warna + '" class="fa fa-circle"></i>';
            } else {
              return '';
            }
          }
        },
        <?php $login_as = $this->session->userdata(); ?>
        <?php $role = $this->db->query("SELECT * FROM global.global_role WHERE role_id = '1' OR role_id = 'df416116aa07eba2d4140d461ff2dfc3a927515c' OR role_id= '79d5b34a78b48d85eb1b65249fca73704dc49665'")->result_array(); ?>
        <?php foreach ($role as $value) { ?>
          <?php if ($value['role_id'] == $login_as['role_id']) { ?> {
              "render": function(data, type, full, meta) {
                var tombol = '';
                if (full.aset_perbaikan_status != 'y') {
                  var tombol = '<div class="input-group-prepend" ><button type="button" class="btn btn-primary  dropdown-toggle" data-toggle="dropdown">Action</button><div style="height:auto;max-height: 100px;overflow-x:hidden;" class="dropdown-menu"><a class="dropdown-item" href="javascript:;"  data-target="#modal" data-toggle="modal" id="' + full.aset_perbaikan_id + '" title="Edit" onclick="fun_edit(this.id)">Edit <i style="color:lime"></i></a><a class="dropdown-item" href="javascript:;" id="' + full.aset_perbaikan_id + '" title="Hapus" onclick="return fun_delete(this.id)">Hapus<i style="color:red"  ></i></a></div></div>';
                } else if (full.aset_perbaikan_status == 'y') {
                  var tombol = '<div class="input-group-prepend" ><button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Action</button><div style="height:auto;max-height: 100px;overflow-x:hidden;" class="dropdown-menu"><a target="_blank" href="<?= base_url('upload/') ?>' + full.aset_perbaikan_file + '" class="dropdown-item">Download</a><a href="javascript:;" class="dropdown-item" onclick="func_lihat(this.id)" data-target="#modal_lihat" data-toggle="modal" id="' + full.aset_perbaikan_file + '">Lihat</a><a class="dropdown-item" href="javascript:;" id="' + full.aset_perbaikan_id + '" title="Hapus" onclick="return fun_delete(this.id)">Hapus <i style="color:red"  ></i></a></div></div>';
                }
                return tombol;
              }
            },
        <?php }
        } ?>

      ]
    });
    /* Isi Table */

    /* Tanggal */
    $("#tanggal").daterangepicker({
      showDropdowns: true,
      singleDatePicker: true,
      locale: {
        format: 'DD-MM-YYYY'
      }
    });
    /* Tanggal */

    /* Tanggal */
    $("#tanggal_deadline").daterangepicker({
      showDropdowns: true,
      singleDatePicker: true,
      locale: {
        format: 'DD-MM-YYYY'
      }
    });
    /* Tanggal */

    /* Tanggal */

    $("#tanggal_selesai").daterangepicker({
      showDropdowns: true,
      singleDatePicker: true,
      locale: {
        format: 'DD-MM-YYYY'
      }
    });
    /* Tanggal */

    /* Select2 */
    $('#pekerjaan_id').select2({
      placeholder: 'Pilih',
    });

    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');
    /* Select2 */
    /* Select2 */
    $('#aset_perbaikan_status').select2({
      placeholder: 'Pilih',
    });

    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');
    /* Select2 */
    /* Select2 */
    $('#pekerjaan_id_cari').select2({
      placeholder: 'Pilih',
    });

    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');
    /* Select2 */
    /* Select2 */
    $('#terjadwal_cari').select2({
      placeholder: 'Pilih',
    });

    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');
    /* Select2 */
  });

  $('#aset_id').on('change', function() {
    $('#item_id').empty();
  })

  $('#aset_id').select2({
    placeholder: 'Pilih',
    ajax: {
      delay: 250,
      url: '<?= base_url('material/jadwal_perbaikan/getAsetNama') ?>',
      dataType: 'json',
      type: 'GET',
      data: function(params) {
        var queryParameters = {
          aset_nama: params.term
        }

        return queryParameters;
      }
    }
    // $('#item_id').empty(),
  });

  $('.select2-selection').css('height', '37px');
  $('.select2').css('width', '100%');
  // end select 2 aset

  // start select2 serial number
  $('#item_id').select2({});
  $('.select2-selection').css('height', '37px');
  $('.select2').css('width', '100%');

  function func_gantiKodeItem(isi) {
    $('#item_id').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('material/jadwal_perbaikan/getAsetKode?aset_id=') ?>' + isi,
        dataType: 'json',
        type: 'GET',
        data: function(params) {
          var queryParameters = {
            aset_nomor: params.term
          }

          return queryParameters;
        }
      }
    });
    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');
  }

  // end select 2 serial number

  // start select 2 jenis pekerjaan
  // $('#pekerjaan_id').select2({
  //     placeholder: 'Pilih',
  //     ajax: {
  //       delay: 250,
  //       url: '<?= base_url('material/jadwal_perbaikan/getPekerjaan') ?>',
  //       dataType: 'json',
  //       type: 'GET',
  //       data: function (params) {
  //         var queryParameters = {
  //           sample_pekerjaan_nama : params.term
  //         }

  //         return queryParameters;
  //       }
  //     }
  //   });

  //   $('.select2-selection').css('height', '37px');
  //   $('.select2').css('width', '100%');
  // end select  2 jenis pekerjaan

  // start select 2 jenis pekerjaan
  $('#peminta_id').select2({
    placeholder: 'Pilih',
    ajax: {
      delay: 250,
      url: '<?= base_url('material/request/getPemintaJasa') ?>',
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

  $('.select2-selection').css('height', '37px');
  $('.select2').css('width', '100%');
  // end select  2 jenis pekerjaan
  // }

  /* Tanggal */
  function fun_tanggal() {
    $("#tanggal").daterangepicker({
      showDropdowns: true,
      singleDatePicker: true,
      locale: {
        format: 'DD-MM-YYYY'
      }
    });
    $("#tanggal_deadline").daterangepicker({
      showDropdowns: true,
      singleDatePicker: true,
      locale: {
        format: 'DD-MM-YYYY'
      }
    });
    $("#tanggal_selesai").daterangepicker({
      showDropdowns: true,
      singleDatePicker: true,
      locale: {
        format: 'DD-MM-YYYY'
      }
    });
  }
  /* Tanggal */

  function fun_tambah() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        fun_tanggal();
        fun_loading();
      }
    })
  }

  // ganti serial
  function func_gantiSerial(id) {
    $.getJSON('<?= base_url('material/jadwal_perbaikan/getSerialNumber') ?>', {
      aset_id: id
    }, function(json) {
      $('#aset_nomor_utama').val(json.aset_nomor_utama);
      // console.log(json.aset_nomor_utama);
    })
  }
  // ganti serial
  // filter
  $('#filter').on('submit', function(e) {
    e.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        fun_loading()
        $('#table').DataTable().ajax.url('<?= base_url('material/jadwal_perbaikan/getJadwalPerbaikan?') ?>' + $('#filter').serialize()).load();
      }
    })
  })
  // filter

  // filter diatas table head
  function func_nomor_aset_cari(data) {
    fun_loading();
    $('#table').DataTable().ajax.url('<?= base_url('material/jadwal_perbaikan/getJadwalPerbaikan?aset_nomor_utama=') ?>' + data).load();
  }

  function func_nama_aset_cari(data) {
    fun_loading();
    $('#table').DataTable().ajax.url('<?= base_url('material/jadwal_perbaikan/getJadwalPerbaikan?aset_nama=') ?>' + data).load();
  }

  function func_serial_number_cari(data) {
    fun_loading();
    $('#table').DataTable().ajax.url('<?= base_url('material/jadwal_perbaikan/getJadwalPerbaikan?aset_nomor=') ?>' + data).load();
  }

  function func_pengelola_cari(data) {
    fun_loading();
    $('#table').DataTable().ajax.url('<?= base_url('material/jadwal_perbaikan/getJadwalPerbaikan?pengelola=') ?>' + data).load();
  }

  function func_vendor_cari(data) {
    fun_loading();
    $('#table').DataTable().ajax.url('<?= base_url('material/jadwal_perbaikan/getJadwalPerbaikan?vendor=') ?>' + data).load();
  }

  function fun_edit(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        fun_loading();
        $('#simpan').css('display', 'none');
        $('#edit').css('display', 'block');
        $('#div_file_sebelum').css('display', 'block');
        $('#file_required').hide();
        $.getJSON('<?= base_url('material/jadwal_perbaikan/getJadwalPerbaikan') ?>', {
          aset_perbaikan_id: id
        }, function(json) {
          // console.log(json);
          $.each(json, function(index, val) {
            $('#' + index).val(val);
          });
          $('#tanggal').val(json.tanggal_penyerahan);
          $('#tanggal_deadline').val(json.tanggal_deadline);
          if (json.tanggal_selesai != null) {
            $('#tanggal_selesai').val(json.tanggal_selesai);
          } else {
            $("#tanggal_selesai").daterangepicker({
              showDropdowns: true,
              singleDatePicker: true,
              locale: {
                format: 'DD-MM-YYYY'
              }
            });
          }
          $('#aset_note').val(json.aset_perbaikan_note);
          $('#aset_file_lama').val(json.aset_perbaikan_file);
          $('#aset_perbaikan_vendor').val(json.aset_perbaikan_vendor);
          $('#aset_id').append('<option selected value="' + json.aset_id + '">' + json.aset_nama + '</option>');
          $('#aset_id').select2('data', {
            id: json.aset_id,
            text: json.aset_nama
          });
          $('#aset_id').trigger('change');
          $('#item_id').append('<option selected value="' + json.aset_detail_id + '">' + json.aset_nomor + '</option>');
          $('#item_id').select2('data', {
            id: json.aset_detail_id,
            text: json.aset_nomor
          });
          $('#item_id').trigger('change');

          $('#peminta_id').append('<option selected value="' + json.peminta_jasa_id + '">' + json.peminta_jasa_nama + '</option>');
          $('#peminta_id').select2('data', {
            id: json.peminta_jasa_id,
            text: json.peminta_jasa_nama
          });
          $('#peminta_id').trigger('change');
          $('#aset_perbaikan_status').select2('data', {
            id: json.aset_perbaikan_status,
            text: json.perbaikan_status
          });
          $('#aset_perbaikan_status').trigger('change');
          $('#pekerjaan_id').select2('data', {
            id: json.pekerjaan_id,
            text: json.pekerjaan_nama
          });
          $('#pekerjaan_id').trigger('change');
        });
      }
    })
  }



  function fun_delete($data) {
    // $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
    // if (!json.user_id) {
    // fun_notifLogout();
    // } else {
    fun_loading();
    $.confirmModal('Apakah anda yakin akan menghapusnya?', function(el) {
      $.ajax({
        url: '<?= base_url() ?>material/jadwal_perbaikan/deleteJadwalPerbaikan',
        data: {
          aset_perbaikan_id: $data
        },
        type: 'GET',
        dataType: 'html',
        success: function(isi) {

          $('#form_modal')[0].reset();
          $('#table').DataTable().ajax.reload();
          $('#close').click();
          toastr.success('Berhasil');
          fun_loading();
        }
      })
    })
  }
  // })
  // }


  $("#form_modal").on("submit", function(e) {
    e.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {

        if ($('#aset_perbaikan_id').val() != '') var url = '<?= base_url('material/jadwal_perbaikan/updateJadwalPerbaikan') ?>';
        else var url = '<?= base_url('material/jadwal_perbaikan/insertJadwalPerbaikan') ?>';

        ($('#tanggal').val() == '') ? $('#tanggal_pengajuan_alert').show(): $('#tanggal_pengajuan_alert').hide();
        ($('#tanggal_deadline').val() == '') ? $('#tanggal_deadline_alert').show(): $('#tanggal_deadline_alert').hide();
        ($('#tanggal_selesai').val() == '') ? $('#tanggal_selesai_alert').show(): $('#tanggal_selesai_alert').hide();
        ($('#aset_id').val() == null) ? $('#aset_alert').show(): $('#aset_alert').hide();
        ($('#item_id').val() == null) ? $('#serial_alert').show(): $('#serial_alert').hide();
        ($('#pekerjaan_id').val() == null) ? $('#pekerjaan_alert').show(): $('#pekerjaan_alert').hide();
        ($('#peminta_id').val() == null) ? $('#peminta_alert').show(): $('#peminta_alert').hide();
        ($('#aset_perbaikan_status').val() == null) ? $('#perbaikan_status_alert').show(): $('#perbaikan_status_alert').hide();
        ($('#aset_perbaikan_vendor').val() == '') ? $('#perbaikan_vendor_alert').show(): $('#perbaikan_vendor_alert').hide();
        ($('#aset_note').val() == '') ? $('#note_alert').show(): $('#note_alert').hide();
        if ($('#aset_file_lama').val() != '') {
          $('#file_alert').css('display', 'none');
        } else if ($('#aset_file').val() == '') {
          $('#file_alert').css('display', 'block')
        } else {
          $('#file_alert').css('display', 'none');
        }


        if ($('#tanggal').val() != '' && $('#tanggal_deadline').val() != '' && $('#tanggal_selesai').val() != '' && $('#aset_perbaikan_id').val() != null && $('#item_id').val() != null && $('#pekerjaan_id').val() != null && $('#peminta_id').val() != null && $('#aset_perbaikan_vendor').val() != '' && $('#aset_note').val() != '' && $('#aset_perbaikan_status').val() != '' && ($('#aset_file').val() != '' || $('#aset_file_lama').val() != '') && $('#aset_id').val() != null) {
          var aset_foto = $('#aset_file').prop('files')[0];
          var data = new FormData();
          data.append('aset_perbaikan_id', $('#aset_perbaikan_id').val());
          data.append('aset_detail_id', $('#item_id').val())
          data.append('pekerjaan_id', $('#pekerjaan_id').val())
          data.append('peminta_id', $('#peminta_id').val())
          data.append('aset_perbaikan_tgl_penyerahan', $('#tanggal').val())
          data.append('aset_perbaikan_tgl_deadline', $('#tanggal_deadline').val())
          data.append('aset_perbaikan_tgl_selesai', $('#tanggal_selesai').val())
          data.append('aset_perbaikan_vendor', $('#aset_perbaikan_vendor').val())
          data.append('aset_perbaikan_note', $('#aset_note').val())
          data.append('aset_perbaikan_status', $('#aset_perbaikan_status').val());
          data.append('aset_perbaikan_file', aset_foto);
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
                toastr.warning('Ekstensi File Tidak Diperbolehkan');
              } else {
                $('#close').click();
                toastr.success('Berhasil');
                fun_loading();
              }
            }
          });
        } else {
          e.preventDefault();
        }
      }
    })
  });


  window.onload = func_reminder();

  function func_reminder() {
    $.getJSON('<?= base_url('material/jadwal_perbaikan/getJadwalPerbaikan') ?>', function(json, status) {
      $.each(json, function(index, val) {
        var date = new Date();
        var sehari = 24 * 60 * 60 * 1000;

        var tanggal = new Date(val.aset_perbaikan_tgl_deadline);
        var selisih = new Date(tanggal - date);
        days = selisih / 1000 / 60 / 60 / 24;
        // console.log(days);
        if (days <= 7 && days >= 1 && val.aset_perbaikan_status == 'n') {

          toastr.error('Aset ' + val.aset_nama + ' Hampir Memasuki Masa Perbaikan Harap Cek Sebelum ' + val.aset_perbaikan_tgl_deadline, 'Peringatan', {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "60000",
            "extendedTimeOut": "60000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
          });
        }
      });
    })
  }

  function func_lihat(data) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        fun_loading();
        $('#document').remove();
        // $('#div_document').append('<iframe src="https://docs.google.com/viewer?url=<?= base_url('upload/') ?>'+data+'&embedded=true" frameborder="0" id="document" width="100%"></iframe>');
        $('#div_document').append('<embed src="<?= base_url('upload/') ?>' + data + '#toolbar=0" frameborder="0" id="document" width="100%"></embed>');
      }
    })
  }

  function fun_close() {
    $('#file_required').show();
    $('#simpan').css('display', 'block');
    $('#edit').css('display', 'none');
    $('#div_file_sebelum').css('display', 'none');
    $('#aset_perbaikan_id').empty();
    $('#item_id').empty();
    $('#aset_id').empty();
    // $('#pekerjaan_id').empty();
    $('#peminta_id').empty();
    $('#form_modal')[0].reset();
    $('#table').DataTable().ajax.reload(null, false);
    $('#tanggal_pengajuan_alert').hide();
    $('#tanggal_deadline_alert').hide();
    $('#tanggal_selesai_alert').hide();
    $('#aset_alert').hide();
    $('#serial_alert').hide();
    $('#pekerjaan_alert').hide();
    $('#peminta_alert').hide();
    $('#perbaikan_status_alert').hide();
    $('#perbaikan_vendor_alert').hide();
    $('#note_alert').hide();
    $('#file_alert').hide();
  }
  /* Fun Close */

  $('#modal').on('hidden.bs.modal', function(e) {
    fun_close();
  });

  /* Fun Loading */
  function fun_loading() {
    var simplebar = new Nanobar();
    simplebar.go(100);
  }
  /* Fun Loading */
</script>