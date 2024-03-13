<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="<?= base_url('dashboard/order/?&header_menu=53&menu_id=54') ?>" class="brand-link" style="background-color: white;">
    <center><img src="<?= base_url('gambar/img/logo/logo_digilab.png') ?>" width="100%" alt="logo_digilab"></center>
  </a>
  <!-- Sidebar -->`
  <div class="sidebar">
    <!-- Sidebar user -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="info">
        <a href="#" class="d-block" style="font-size: 12px;">
          <b><?= $user_nama_lengkap ?></b><br>
          <?= $user_unit_kerja_nama ?><br>
          <?= $user_nik_sap ?>
        </a>
      </div>
    </div>
    <!-- Sidebar user -->

    <?php
    $id_menu = str_split($_GET['menu_id'], 2);
    $level1 = (isset($id_menu[0])) ? $id_menu[0] : 0;
    $level2 = (isset($id_menu[1])) ? $id_menu[0] . $id_menu[1] : 0;
    $level3 = (isset($id_menu[2])) ? $_GET['menu_id'] : 0;
    ?>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Level 1 -->
        <?php $menu_level1 = $this->db->query("SELECT * FROM global.global_menu_baru a LEFT JOIN global.global_menu_role b ON a.menu_id = b.id_menu WHERE b.id_role = '" . $role_id . "' AND header_menu IS NULL ORDER BY a.menu_id ASC"); ?>
        <?php foreach ($menu_level1->result_array() as $value) : ?>
          <li class="nav-item has-treeview <?php if ($value['menu_id'] == $level1) echo 'menu-open'; ?>">
            <!-- Cek Level 2 -->
            <?php $menu_level2_cek = $this->db->query("SELECT COUNT(*) AS total FROM global.global_menu_baru a LEFT JOIN global.global_menu_role b ON a.menu_id = b.id_menu WHERE b.id_role = '" . $role_id . "' AND a.header_menu = '" . $value['menu_id'] . "' ")->row_array(); ?>
            <!-- Cek Level 2 -->
            <a href="<?= ($value['menu_link'] != '#') ? base_url($value['menu_link']) . '&header_menu=' . $value['menu_id'] . '&menu_id=' . $value['menu_id'] : '#'; ?>" class="nav-link <?php if ($value['menu_id'] == $level1) echo 'active'; ?>"><i class="nav-icon <?= $value['menu_icon'] ?>" style="font-size: 0.9rem;"></i>
              <p style="font-size: 0.9rem;">
                <?= $value['menu_judul'] ?>
                <!-- Jika Ada Level 2 -->
                <?php if ($menu_level2_cek['total'] > 0) : ?>
                  <i class="right fas fa-angle-left"></i>
                <?php endif ?>
                <!-- Jika Ada Level 2 -->
                <!-- Jika Ada Notif -->
                <?php if ($value['menu_custom_id'] != null) : ?>
                  <span class="right badge badge-danger" id="<?= $value['menu_custom_id'] ?>"></span>
                <?php endif ?>
                <!-- Jika Ada Notif -->
              </p>
            </a>
            <!-- Jika Ada Level 2 -->
            <?php if ($menu_level2_cek['total'] > 0) : ?>
              <ul class="nav nav-treeview">
                <!-- Level 2 -->
                <?php $menu_level2 = $this->db->query("SELECT * FROM global.global_menu_baru a LEFT JOIN global.global_menu_role b ON a.menu_id = b.id_menu WHERE b.id_role = '" . $role_id . "' AND a.header_menu = '" . $value['menu_id'] . "'  ORDER BY menu_urut ASC"); ?>
                <?php foreach ($menu_level2->result_array() as $val) : ?>
                  <li class="nav-item has-treeview <?php if ($val['menu_id'] == $level2) echo 'menu-open'; ?>">
                    <!-- Cek Level 3 -->
                    <?php $menu_level3_cek = $this->db->query("SELECT COUNT(*) AS total FROM global.global_menu_baru a LEFT JOIN global.global_menu_role b ON a.menu_id = b.id_menu WHERE b.id_role = '" . $role_id . "' AND a.header_menu = '" . $val['menu_id'] . "' ")->row_array(); ?>
                    <!-- Cek Level 3 -->
                    <a href="<?= ($val['menu_link'] != '#') ? base_url($val['menu_link']) . '&header_menu=' . $value['menu_id'] . '&menu_id=' . $val['menu_id'] : '#'; ?>" class="nav-link <?php if ($val['menu_id'] == $level2) echo 'active'; ?>"><i class="nav-icon far fa-circle" style="font-size: 0.9rem;"></i>
                      <p style="font-size: 0.9rem;">
                        <?= $val['menu_judul'] ?>
                        <!-- Jika Ada Level 3 -->
                        <?php if ($menu_level3_cek['total'] > 0) : ?>
                          <i class="right fas fa-angle-left"></i>
                        <?php endif ?>
                        <!-- Jika Ada Level 3 -->
                        <!-- Jika Ada Notif -->
                        <?php if ($val['menu_custom_id'] != null) : ?>
                          <span class="right badge badge-danger" id="<?= $val['menu_custom_id'] ?>"></span>
                        <?php endif ?>
                        <!-- Jika Ada Notif -->
                      </p>
                    </a>
                    <!-- Jika Ada Level 3 -->
                    <?php if ($menu_level3_cek['total'] > 0) : ?>
                      <ul class="nav nav-treeview">
                        <?php $menu_level3 = $this->db->query("SELECT * FROM global.global_menu_baru a LEFT JOIN global.global_menu_role b ON a.menu_id = b.id_menu WHERE b.id_role = '" . $role_id . "' AND a.header_menu = '" . $val['menu_id'] . "'  ORDER BY menu_urut ASC"); ?>
                        <?php foreach ($menu_level3->result_array() as $v) : ?>
                          <li class="nav-item">
                            <a href="<?= ($v['menu_link'] != '#') ? base_url($v['menu_link']) . '&header_menu=' . $val['menu_id'] . '&menu_id=' . $v['menu_id'] : '#'; ?>" class="nav-link <?php if ($v['menu_id'] == $level3) echo 'active'; ?>"><i class="far fa-dot-circle nav-icon" style="font-size: 0.9rem;"></i>
                              <p style="font-size: 0.9rem;">
                                <?= $v['menu_judul'] ?>
                                <!-- Jika Ada Notif -->
                                <?php if ($v['menu_custom_id'] != null) : ?>
                                  <span class="right badge badge-danger" id="<?= $v['menu_custom_id'] ?>"></span>
                                <?php endif ?>
                                <!-- Jika Ada Notif -->
                              </p>
                            </a>
                          </li>
                        <?php endforeach ?>
                      </ul>
                    <?php endif ?>
                    <!-- Jika Ada Level 3 -->
                  </li>
                <?php endforeach ?>
                <!-- Level 2 -->
              </ul>
            <?php endif ?>
            <!-- Jika Ada Level 2 -->
          </li>
        <?php endforeach ?>
        <!-- Level 1 -->
        <?php


        ?>
        <?php if ($role_id == '1') : ?>
          <li class="nav-item">
            <a href="<?= base_url('upload/user_guide_digilabs_v2_all.pdf') ?>" class="nav-link" target="_blank" download><i class="nav-icon fas fa-book" style="font-size: 0.9rem;"></i>
              <p style="font-size: 0.9rem;">User Guide<span class="right badge badge-danger"></span></p>
            </a>
          </li>
        <?php else : ?>
          <li class="nav-item">
            <a href="<?= base_url('upload/user_guide_digilabs_v2.pdf') ?>" class="nav-link" target="_blank" download><i class="nav-icon fas fa-book" style="font-size: 0.9rem;"></i>
              <p style="font-size: 0.9rem;">User Guide<span class="right badge badge-danger"></span></p>
            </a>
          </li>
        <?php endif; ?>
        <li class="nav-item">
          <a href="#" class="nav-link" onclick="return logout()"><i class="nav-icon fas fa-power-off" style="font-size: 0.9rem;"></i>
            <p style="font-size: 0.9rem;">Log Out<span class="right badge badge-danger"></span></p>
          </a>
        </li>
        <li class="nav-item" style="height: 60px">
          &nbsp;
        </li>
      </ul>
    </nav>
    <!-- Sidebar Menu -->
  </div>
  <!-- Sidebar -->
</aside>
<!-- Main Sidebar Container -->