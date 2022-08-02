        <?php
        $info = mysqli_query(
          $koneksi,
          "SELECT a.NIP, b.pns_nip, b.pns_nama 
                  FROM a_useraktif a
                  LEFT JOIN m_pegawai b ON b.pns_nip = a.NIP
                  WHERE a.NIP = '$_SESSION[NIP]'
                  ORDER BY id ASC"
        );
        $rs    = mysqli_fetch_array($info);
        ?>
        <!-- START SIDEBAR-->
        <nav class="page-sidebar" id="sidebar">
            <div id="sidebar">
                <div class="admin-block d-flex">
                    <div>
               <!--<img src="./assets/img/admin-avatar.png" width="45px" />-->
                    </div>
                    <div class="admin-info">
                        <div class="font-strong"><?php echo "$rs[pns_nama]"; ?></div>
                        <small><?php echo "$_SESSION[LEVEL]"; ?> : <?php echo "$_SESSION[LOGIN_TERAKHIR]"; ?></small>
                    </div>
                </div>
                <ul class="side-menu metismenu">
                    <li class="heading">LAYANAN UMUM</li>
                    <li>
                        <a href="javascript:;"><i class="sidebar-item-icon fa fa-bookmark"></i>
                            <span class="nav-label">Referensi</span><i class="fa fa-angle-left arrow"></i></a>
                        <ul class="nav-2-level collapse">
                            <li><a href="#"> Kendaraan Dinas</a></li>
                            <li><a href="#">Ruangan</a></li>
                            <li><a href="?module=tbl_stokbrg">Daftar Stok Barang</a></li>
                            <li><a href="?module=tbl_brg">Tabel Barang</a></li> 
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;"><i class="sidebar-item-icon fa fa-address-card-o"></i>
                            <span class="nav-label">Ekspedisi Surat</span><i class="fa fa-angle-left arrow"></i></a>
                        <ul class="nav-2-level collapse">
                            <li><a href="?module=e_instansi">Master Instansi</a></li>
                            <li><a href="?module=e_catekspedisi">Surat Keluar (Kirim)</a></li>
                            <li><a href="?module=ct_ekpedisi">Cetak Tanda Terima</a></li>
                            <li><a href="?module=paket">Daftarkan Paket (Masuk)</a></li> 
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;"><i class="sidebar-item-icon fa fa-opencart"></i>
                            <span class="nav-label">Persediaan</span><i class="fa fa-angle-left arrow"></i></a>
                        <ul class="nav-2-level collapse">
                            <li><a href="?module=sedia_pengajuan">Permohonan</a></li>
                            <li><a href="?module=c_printsedia">Print Pengajuan</a></li>
                            <li><a href="?module=c_cekstatus">Status Pengajuan</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="sidebar-item-icon fa fa-automobile"></i>
                            <span class="nav-label">Kendaraan Dinas</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"><i class="sidebar-item-icon fa fa-recycle"></i>
                            <span class="nav-label">Lapor Kerusakan</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"><i class="sidebar-item-icon fa fa-recycle"></i>
                            <span class="nav-label">Pemeliharaan</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"><i class="sidebar-item-icon fa fa-thumbs-up"></i>
                            <span class="nav-label">Peminjaman BMN</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"><i class="sidebar-item-icon fa fa-building"></i>
                            <span class="nav-label">Pinjam Ruangan</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"><i class="sidebar-item-icon fa fa-book"></i>
                            <span class="nav-label">Permintaan Blanko</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- END SIDEBAR-->