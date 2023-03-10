<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url(); ?>">
        <div class="sidebar-brand-icon">
            <img src="<?php echo base_url() . '/assets/images/icon.png' ?>" width="40px">
        </div>
        <div class="sidebar-brand-text mx-3">Kerma</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="<?= base_url(); ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('kerma'); ?>">
            <i class="fas fa-fw fa-table"></i>
            <span>Kerma</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Data
    </div>

    <!-- Nav Item - Pages Collapse Menu -->

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-folder"></i>
            <span>Mitra</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Kerja Sama:</h6>
                <a class="collapse-item" href="<?= base_url('mitra'); ?>">Mitra</a>
                <a class="collapse-item" href="<?= base_url('mitra/jenis'); ?>">Jenis Mitra</a>
                <a class="collapse-item" href="<?= base_url('mitra/tingkat'); ?>">Tingkat</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('bidang'); ?>">
            <i class="fas fa-fw fa-cog"></i>
            <span>Bidang</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('ruang-lingkup'); ?>">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Ruang Lingkup</span></a>
    </li>
    <!-- Nav Item - Utilities Collapse Menu -->


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>