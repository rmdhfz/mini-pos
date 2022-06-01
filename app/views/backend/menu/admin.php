<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<ul class="pcoded-item pcoded-left-item no-print" id="menu">
    <li>
        <a href="<?php echo site_url('dashboard') ?>" class="waves-effect waves-dark">
            <span class="pcoded-micon">
                <i class="feather icon-home" aria-hidden="true"></i>
            </span>
            <span class="pcoded-mtext"> Dashboard </span>
        </a>
    </li>
    <li class="pcoded-hasmenu">
        <a href="javascript:void(0)" class="waves-effect waves-dark">
            <span class="pcoded-micon"><i class="fas fa-folder" aria-hidden="true"></i></span>
            <span class="pcoded-mtext">Data Master</span>
        </a>
        <ul class="pcoded-submenu">
            <li>
                <a href="<?php echo site_url('user') ?>" class="waves-effect waves-dark" data-toggle="tooltip" data-placement="right" title="Lihat Data User">
                    <span class="pcoded-mtext">Data User</span>
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('supplier') ?>" class="waves-effect waves-dark" data-toggle="tooltip" data-placement="right" title="Lihat Data Supplier">
                    <span class="pcoded-mtext">Data Supplier</span>
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('kategori') ?>" class="waves-effect waves-dark" data-toggle="tooltip" data-placement="right" title="Lihat Data Kategori Produk">
                    <span class="pcoded-mtext">Data Kategori Produk</span>
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('produk') ?>" class="waves-effect waves-dark" data-toggle="tooltip" data-placement="right" title="Lihat Data Produk">
                    <span class="pcoded-mtext">Data Produk</span>
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('pelanggan') ?>" class="waves-effect waves-dark" data-toggle="tooltip" data-placement="right" title="Lihat Data Pelanggan">
                    <span class="pcoded-mtext">Data Pelanggan</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="pcoded-hasmenu">
        <a href="javascript:void(0)" class="waves-effect waves-dark">
            <span class="pcoded-micon"><i class="fas fa-folder" aria-hidden="true"></i></span>
            <span class="pcoded-mtext">Data Transaksi</span>
        </a>
        <ul class="pcoded-submenu">
            <li>
                <a href="<?php echo site_url('pembelian') ?>" class="waves-effect waves-dark" data-toggle="tooltip" data-placement="right" title="Lihat Data Transaksi Pembelian">
                    <span class="pcoded-mtext">Data Pembelian</span>
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('penjualan') ?>" class="waves-effect waves-dark" data-toggle="tooltip" data-placement="right" title="Lihat Data Transaksi Penjualan">
                    <span class="pcoded-mtext">Data Penjualan</span>
                </a>
            </li>
        </ul>
    </li>
    <li>
        <a href="<?php echo site_url('monitoring') ?>" class="waves-effect waves-dark" data-toggle="tooltip" data-placement="right" title="Klik untuk melihat pengguna login">
            <span class="pcoded-micon">
                <i class="feather icon-monitor" aria-hidden="true"></i>
            </span>
            <span class="pcoded-mtext"> Monitoring Login </span>
        </a>
    </li>
    <li class="pcoded-hasmenu">
        <a href="javascript:void(0)" class="waves-effect waves-dark">
            <span class="pcoded-micon"><i class="fas fa-cogs" aria-hidden="true"></i></span>
            <span class="pcoded-mtext">Pengaturan Sistem</span>
        </a>
        <ul class="pcoded-submenu">
            <li>
                <a href="<?php echo site_url('backup/database') ?>" class="waves-effect waves-dark" data-toggle="tooltip" data-placement="right" title="Klik untuk melakukan backup database">
                    <span class="pcoded-mtext">Backup Database</span>
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('backup/aplikasi') ?>" class="waves-effect waves-dark" data-toggle="tooltip" data-placement="right" title="Klik untuk melakukan backup aplikasi">
                    <span class="pcoded-mtext">Backup Aplikasi</span>
                </a>
            </li>
        </ul>
    </li>
    <div class="pcoded-navigation-label">OTHER NAVIGATION</div>
    <li>
        <a href="javascript:void(0)" id="keluar" class="waves-effect waves-dark" data-toggle="tooltip" data-placement="right" title="keluar">
            <span class="pcoded-micon">
                <i class="fas fa-sign-out-alt" aria-hidden="true"></i>
            </span>
            <span class="pcoded-mtext">Keluar</span>
        </a>
    </li>
</ul>
