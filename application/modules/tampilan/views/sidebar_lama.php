<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="<?= base_url('dashboard/order/?&header_menu=53&menu_id=54') ?>" class="brand-link" style="background-color: white;">
    <center><img src="<?= base_url('gambar/img/logo/logo_digilab.png') ?>" width="100%"></center>
  </a>
  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="info">
        <a href="#" class="d-block" style="font-size: 12px;">
          <b><?= $user_nama_lengkap ?></b><br>
          <?= $cv_nik ?>
        </a>
      </div>
    </div>
    <!-- Sidebar user -->

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <?php $main_menu = $this->db->query("SELECT * FROM global.global_menu a LEFT JOIN global.global_menu_role b ON a.menu_id = b.id_menu WHERE b.id_role = '" . $role_id . "' AND header_menu IS NULL ORDER BY a.menu_urut ASC"); ?>
        <?php foreach ($main_menu->result() as $value) : ?>
          <?php $sub_menu = $this->db->query("SELECT * FROM global.global_menu a LEFT JOIN global.global_menu_role b ON a.menu_id = b.id_menu WHERE b.id_role = '" . $role_id . "' AND a.header_menu = '" . $value->menu_id . "' ORDER BY a.menu_urut ASC"); ?>
          <?php if ($sub_menu->num_rows() > 0) : ?>
            <li class="nav-item has-treeview <?php if ($value->menu_id == $_GET['header_menu']) echo 'menu-open'; ?>">
              <a href="#" class="nav-link <?php if ($value->menu_id == $_GET['header_menu']) echo 'active'; ?>"><i class="nav-icon <?= $value->menu_icon ?>" style="font-size: 0.9rem;"></i>
                <p style="font-size: 0.9rem;"><?= $value->menu_judul ?><i class="right fas fa-angle-left"></i><span class="right badge badge-danger" id="<?= $value->menu_custom_id ?>"></span></p>
              </a>
              <ul class="nav nav-treeview">
                <?php foreach ($sub_menu->result() as $val) : ?>
                  <li class="nav-item"><a href="<?= base_url($val->menu_link) . '&header_menu=' . $value->menu_id . '&menu_id=' . $val->menu_id ?>" class="nav-link <?php if ($val->menu_id == $_GET['menu_id']) echo 'active'; ?>"><i class="<?= $val->menu_icon ?> nav-icon" style="font-size: 0.9rem;"></i>
                      <p style="font-size: 0.9rem;"><?= $val->menu_judul ?><span class="right badge badge-danger" id="<?= $val->menu_custom_id ?>"></span></p>
                    </a></li>
                <?php endforeach ?>
              </ul>
            </li>
          <?php else : ?>
            <li class="nav-item <?php if ($value->menu_id == $_GET['header_menu']) echo 'menu-open'; ?> ">
              <a href="<?= base_url($value->menu_link) . '&header_menu=' . $value->menu_id . '&menu_id=' ?>" class="nav-link <?php if ($value->menu_id == $_GET['header_menu']) echo 'active'; ?>"><i class="nav-icon <?= $value->menu_icon ?>" style="font-size: 0.9rem;"></i>
                <p style="font-size: 0.9rem;"><?= $value->menu_judul ?><span class="right badge badge-danger" id="<?= $value->menu_custom_id ?>"></span></p>
              </a>
            </li>
          <?php endif ?>
        <?php endforeach ?>
        <li class="nav-item">
          <a href="#" class="nav-link" onclick="return logout()"><i class="nav-icon fas fa-power-off"></i>
            <p>Log Out<span class="right badge badge-danger"></span></p>
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