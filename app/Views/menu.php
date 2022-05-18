<div class="container-fluid page-body-wrapper">
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#home" aria-expanded="false" aria-controls="home">
                    <i class="icon-monitor menu-icon"></i>
                    <span class="menu-title">HOME</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="home">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="<?php echo base_url(); ?>/home">Beranda</a></li>
                        <li class="nav-item"> <a class="nav-link" href="<?php echo base_url(); ?>/identitas">Identitas</a></li>
                        <li class="nav-item"> <a class="nav-link" href="<?php echo base_url(); ?>/profile">Profile</a></li>
                        <li class="nav-item"> <a class="nav-link" href="<?php echo base_url(); ?>/gantipass">Ganti Password</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#master" aria-expanded="false" aria-controls="master">
                    <i class="icon-grid-2 menu-icon"></i>
                    <span class="menu-title">MASTER</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="master">
                    <ul class="nav flex-column sub-menu">
                        <!--
                        <li class="nav-item"> <a class="nav-link" href="<?php //echo base_url(); ?>/korps">Korps</a></li>
                        <li class="nav-item"> <a class="nav-link" href="<?php //echo base_url(); ?>/pangkat">Pangkat</a></li>
                        -->
                        <li class="nav-item"> <a class="nav-link" href="<?php echo base_url(); ?>/role">Divisi / Role</a></li>
                        <li class="nav-item"> <a class="nav-link" href="<?php echo base_url(); ?>/kapal">KRI</a></li>
                        <li class="nav-item"> <a class="nav-link" href="<?php echo base_url(); ?>/pengguna">Pengguna</a></li>
                        <li class="nav-item"> <a class="nav-link" href="<?php echo base_url(); ?>/jenis">Gudang</a></li>
                        <li class="nav-item"> <a class="nav-link" href="<?php echo base_url(); ?>/barang">Barang</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#trans" aria-expanded="false" aria-controls="trans">
                    <i class="icon-file-add menu-icon"></i>
                    <span class="menu-title">TRANSAKSI</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="trans">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>/brgmasuk">Barang Masuk</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>/brgkeluar">Barang Keluar</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#report" aria-expanded="false" aria-controls="report">
                    <i class="icon-paper menu-icon"></i>
                    <span class="menu-title">LAPORAN</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="report">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>/laporan">Stok</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </nav>
    <!-- partial -->
    <div class="main-panel">