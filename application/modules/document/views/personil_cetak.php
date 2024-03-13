<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Print CV Personil</title>
		<link rel="stylesheet" href="">
        <style type="text/css">
        /* @page { */
 
/* } */
			@page {
			    size: A4;
				margin: 1cm;
                /* counter-increment: page; */
                /* @bottom-center {
                content: counter(page);
            } */
			}
            /* @media screen {
                div.divFooter {
                    display: none;
                }

                .page-number:before {
                    counter-increment: page;
                    content: "Page " counter(page);
                }
            } */
			@media print {
                /* div.divFooter {
                    text-align:right;
                    bottom: 0;
                    position: fixed;
                    left: 0;
                    bottom: 0cm;
                    width: 95%;
                    display:table;
                } */
 			    @page { margin: 0.75cm 0cm 0.6cm 0cm; }
                    body { margin: 1cm; 
                    page-break-after:always;}
				}
				body{
					orientation: potrait;
					width: 210mm;
					/* height: 297mm; */
                    size: A4;
				}
                /* .page-number {
                    display: table-footer-group;
                }
                .page-number:after{
                    counter-increment: page;
                    content: "Hal. " counter(pag);
                } */

			.content{
					border:1px  black solid;
					border-collapse:collapse
			}
            
		</style>
	</head>
	<body>
		<H3>CV Personil</H3>
        <table border="0" width="90%" cellspacing="2" cellpadding="2">
            <tr>
                <th style="text-align:left;width: 20%">NIK</th>
                <td><?=($isi)?$isi[0]['cv_nik']:''?></td>
                <td rowspan="5"></td>
            </tr>
            <tr>
                <th style="text-align:left;width: 20%">Nama Lengkap</th>
                <td><?=($isi)?$isi[0]['user_nama_lengkap']:''?></td>
                <td rowspan="5"></td>
            </tr>
            <tr>
                <th style="text-align:left;width: 15%">Tempat Lahir</th>
                <td><?=($isi)?$isi[0]['user_tempat_lahir']:''?></td>
            </tr>
            <tr>
                <th style="text-align:left;width: 15%">Tanggal Lahir</th>
                <td>
                    <?=($isi)?date("d-m-Y", strtotime($isi[0]['user_tgl_lahir'])):'';?>
                </td>
            </tr>
            <tr>
                <th style="text-align:left;width: 15%">Email</th>
                <td>
                    <?=($isi)?$isi[0]['cv_email']:'';?>
                </td>
            </tr>
            <tr>
                <th style="text-align:left;width: 15%">Alamat</th>
                <td>
                    <?=($isi)?$isi[0]['cv_alamat']:'';?>
                </td>
            </tr>
            <tr>
                <th style="text-align:left;width: 15%">Tanggal Masuk</th>
                <td>
                    <?=($isi)?date("d-m-Y", strtotime($isi[0]['cv_tanggal_masuk'])):'';?>
                </td>
            </tr>
            <tr>
                <th style="text-align:left;width: 15%">Masa Kerja</th>
                <td><?=($isi)?$isi[0]['cv_masa_kerja_tahun']:'';?></td>
            </tr>
        </table>
		
            <hr>
            <br>
            <?php if(@$_GET['cpf']=='cpf'): ?>
            <table id="tbPendidikanFormal" class="content" width="95%" border="1px" >
                <strong>Riwayat Pendidikan Formal</strong>
                <thead>
                <tr>
                    <th>Jenjang</th>
                    <th>Jurusan</th>
                    <th>Nama Instansi</th>
                    <th>Tahun Lulus</th>
                    
                </tr>
                </thead>
                <tbody>
                    
                <?php     
                if($isirpnf):
                foreach($isirpf as $value):
                 ?>    
                    <tr>
                        <td><?=$value['pendidikan_formal_jenjang']?></td>
                        <td><?=$value['pendidikan_formal_jurusan']?></td>
                        <td><?=$value['pendidikan_formal_institusi']?></td>
                        <td><?=$value['pendidikan_formal_tahun']?></td>
                        
                    </tr>
                <?php 
                endforeach;
                endif;
                ?>
                </tbody>
            </table>
            <br/>
            <?php endif; ?>
            
            <?php if(@$_GET['cpnf']=='cpnf'): ?>
            <table id="tbPendidikanNonFormal" class="content" width="95%" border="1px" cellspacing="2" cellpadding="2">
                <strong>Riwayat Pendidikan Non Formal</strong>
                <thead>
                <tr>
                    <th>Judul</th>
                    <th>Nama Institusi</th>
                    <th>Tahun Lulus</th>
                    
                </tr>
                </thead>
                <tbody>
                
                <?php
                    if($isirpnf):
                    foreach($isirpnf as $value):
                ?>    
                    <tr>
                        <td><?=$value['pendidikan_non_formal_judul']?></td>
                        <td><?=$value['pendidikan_non_formal_institusi']?></td>
                        <td><?=$value['pendidikan_non_formal_tahun']?></td>
                        
                    </tr>
                <?php
                    endforeach;
                    endif;    
                ?>
                
                </tbody>
            </table>
            <br/>
            <?php endif; ?>

            <?php if(@$_GET['crj']=='crj'): ?>
            <table id="tbRiwayatJabatan" class="content" width="95%" border="1px" cellspacing="2" cellpadding="2">
                <strong>Riwayat Jabatan</strong>
                <thead>
                <tr>
                    <th>Mulai</th>
                    <th>Selesai</th>
                    <th>Masa Kerja</th>
                    <th>Unit Kerja</th>
                    <th>Jabatan</th>
                    
                </tr>
                </thead>
                <tbody>
                <?php
                    if($isirj): 
                    foreach($isirj as $value): 
                ?>    
                    <tr>
                        <td><?=date('d-m-Y',strtotime($value['jabatan_mulai']))?>
                        <td><?=date('d-m-Y',strtotime($value['jabatan_selesai']))?>
                        <td><?=$value['jabatan_masa_kerja']?></td>
                        <td><?=$value['jabatan_unit_kerja']?></td>
                        <td><?=$value['jabatan_nama']?></td>
                        
                    </tr>
                <?php 
                    endforeach;
                    endif;
                ?>
                </tbody>
            </table>
            <br/>
            <?php endif; ?>

            <?php if(@$_GET['ck']=='ck'): ?>
            <table id="tbKompetensi" class="content" width="95%" border="1px" cellspacing="2" cellpadding="2">
                <strong>Sertifikasi Kompetensi</strong>
                <thead>
                <tr>
                    <th>Judul</th>
                    <th>Nama Kompetensi</th>
                    <th>Tahun Lulus</th>
                    
                </tr>
                </thead>
                <tbody>
                
                <?php
                    if($isik):
                    foreach($isik as $value): 
                ?>    
                    <tr>
                        <td><?=$value['kompetensi_judul']?></td>
                        <td><?=$value['kompetensi_nama']?></td>
                        <td><?=$value['kompetensi_tahun']?></td>
                        
                    </tr>
                <?php 
                    endforeach;
                    endif;    
                ?>
                </tbody>
            </table>
            <br/>
            <?php endif; ?>

            <?php if(@$_GET['cpi']=='cpi'): ?>
            <table id="tbPenugasanInternal" class="content" width="95%" border="1px" cellspacing="2" cellpadding="2">
                <strong>Penugasan Internal</strong>
                <thead>
                <tr>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Penugasan Internal</th>
                    <th>Memo</th>
                    
                </tr>
                </thead>
                <tbody>

                <?php
                    if($isipi): 
                    foreach($isipi as $value): 
                ?>    
                    <tr>
                        <td><?=date('d-m-Y',strtotime($value['penugasan_internal_tanggal_mulai']))?></td>
                        <td><?=date('d-m-Y',strtotime($value['penugasan_internal_tanggal_selesai']))?></td>
                        <td><?=$value['penugasan_internal_nama']?></td>
                        <td><?=$value['penugasan_internal_memo']?></td>
                        
                    </tr>
                <?php 
                    endforeach;
                    endif;
                ?>
                </tbody>
            </table>
            <br/>
            <?php endif; ?>

            <?php if(@$_GET['crk']=='crk'): ?>
            <table id="tbRiwayatKerja" class="content" width="95%" border="1px" cellspacing="2" cellpadding="2">
                <strong>Riwayat Pengalaman Kerja Sebelumnya</strong>
                <thead>
                <tr>                                              
                    <th>Tanggal Mulai</th>	
                    <th>Tanggal Selesai</th>
                    <th>Instansi</th>
                    <th>Unit Kerja</th>
                    <th>Jabatan</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    if($isirk): 
                    foreach($isirk as $value):
                ?>    
                    <tr>
                        <td><?=date('d-m-Y',strtotime($value['pengalaman_tanggal_mulai']))?></td>
                        <td><?=date('d-m-Y',strtotime($value['pengalaman_tanggal_selesai']))?></td>
                        <td><?=$value['pengalaman_instansi']?></td>
                        <td><?=$value['pengalaman_unit_kerja']?></td>
                        <td><?=$value['pengalaman_jabatan']?></td>
                        
                    </tr>
                <?php 
                    endforeach;
                    endif;
                ?>
                </tbody>
            </table>
            <br/>
            <?php endif; ?>

            <?php if(@$_GET['cdk']=='cdk'): ?>
            <table id="tbDataKeluarga" class="content" width="95%" border="1px" cellspacing="2" cellpadding="2">
                <strong>Data Keluarga</strong>
                <thead>
                <tr>
                    <th>Nama Keluarga</th>
                    <th>Status</th>
                    <th>Alamat</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    if($isidk): 
                    foreach($isidk as $value):
                ?>    
                    <tr>
                        <td><?=$value['data_keluarga_nama']?></td>
                        <td><?=$value['data_keluarga_status']?></td>
                        <td><?=$value['data_keluarga_alamat']?></td>
                    </tr>
                <?php
                    endforeach;
                    endif;
                ?>
                </tbody>
            </table>
            <br/>
            <?php endif; ?>
            <div id="content"></div>
            <!-- </div> -->
	</body>
</html>
<script>
    window.print();
</script>
<script type="text/javascript">
          window.onload = addPageNumbers;

          function addPageNumbers() {
            var totalPages = Math.ceil(document.body.scrollHeight / 1123);  //842px A4 pageheight for 72dpi, 1123px A4 pageheight for 96dpi, 
            for (var i = 1; i <= totalPages; i++) {
              var pageNumberDiv = document.createElement("div");
              var pageNumber = document.createTextNode(i + " / " + totalPages);
              pageNumberDiv.style.position = "absolute";
              pageNumberDiv.style.top = "calc((" + i + " * (297mm - 0.5px)) - 20px)"; //297mm A4 pageheight; 0,5px unknown needed necessary correction value; additional wanted 40px margin from bottom(own element height included)
              pageNumberDiv.style.height = "16px";
              pageNumberDiv.appendChild(pageNumber);
              document.body.insertBefore(pageNumberDiv, document.getElementById("content"));
              pageNumberDiv.style.left = "calc(100% - (" + pageNumberDiv.offsetWidth + "px + 20px))";
            }
          }
        </script>