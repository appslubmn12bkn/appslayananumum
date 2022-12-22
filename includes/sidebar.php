        <?php
        $query  = "SELECT a.NIP, b.pns_nip, b.pns_nama FROM a_useraktif a
                  LEFT JOIN m_pegawai b ON b.pns_nip = a.NIP WHERE a.NIP = '$_SESSION[NIP]' ORDER BY id ASC";
        $info   = mysqli_query($koneksi,$query);
        $rs     = mysqli_fetch_array($info);
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
                    <li class="heading">MENU LAYANAN UMUM</li>  

                    <?php if($cek==1 OR $_SESSION[LEVEL]=='admin' OR $_SESSION[LEVEL]=='user'){ ?>
                    <li>
                        <a href="javascript:;"><i class="sidebar-item-icon fa fa-bookmark"></i>
                            <span class="nav-label">Referensi</span><i class="fa fa-angle-left arrow"></i></a>
                        <ul class="nav-2-level collapse">
                            <?php include 'mn_side/mn_referensi.php';?>
                        </ul>
                    </li>
                    <?php } ?>

                    <?php if($cek==1 OR $_SESSION[LEVEL]=='admin' OR $_SESSION[LEVEL]=='user'){ ?>
                    <li>
                        <a href="javascript:;"><i class="sidebar-item-icon fa fa-user"></i>
                            <span class="nav-label">PPNPN</span><i class="fa fa-angle-left arrow"></i></a>
                        <ul class="nav-2-level collapse">
                            <?php include 'mn_side/mn_ppnpn.php';?>
                        </ul>
                    </li>
                    <?php } ?>

                    <?php if($cek==1 OR $_SESSION[LEVEL]=='admin' OR $_SESSION[LEVEL]=='user'){ ?>
                    <li>
                        <a href="javascript:;"><i class="sidebar-item-icon fa fa-plane"></i>
                            <span class="nav-label">Barang Milik Negara</span><i class="fa fa-angle-left arrow"></i></a>
                        <ul class="nav-2-level collapse">
                            <?php include 'mn_side/mn_bmn.php';?>
                        </ul>
                    </li>
                    <?php } ?>

<!--

                    <?php if($cek==1 OR $_SESSION[LEVEL]=='admin' OR $_SESSION[LEVEL]=='user'){ ?>
                    <li>
                        <a href="javascript:;"><i class="sidebar-item-icon fa fa-address-card-o"></i>
                            <span class="nav-label">Ekspedisi Surat</span><i class="fa fa-angle-left arrow"></i></a>
                        <ul class="nav-2-level collapse">
                           <?php //include 'mn_side/mn_ekpedisisurat.php';?>
                        </ul>
                    </li>
                    <?php } ?>

                    <?php if($cek==1 OR $_SESSION[LEVEL]=='admin' OR $_SESSION[LEVEL]=='user'){ ?>
                    <li>
                        <a href="javascript:;"><i class="sidebar-item-icon fa fa-opencart"></i>
                            <span class="nav-label">Persediaan</span><i class="fa fa-angle-left arrow"></i></a>
                        <ul class="nav-2-level collapse">
                            <?php //include 'mn_side/mn_persediaan.php';?>
                        </ul>
                    </li>
                    <?php } ?>



                    <?php if($cek==1 OR $_SESSION[LEVEL]=='admin' OR $_SESSION[LEVEL]=='user'){ ?>
                    <li>
                        <a href="javascript:;"><i class="sidebar-item-icon fa fa-automobile"></i>
                            <span class="nav-label">Kendaraan Dinas</span><i class="fa fa-angle-left arrow"></i></a>
                        <ul class="nav-2-level collapse">
                            <?php //include 'mn_side/mn_mobnas.php';?>
                        </ul>
                    </li>
                    <?php } ?>

                    <?php if($cek==1 OR $_SESSION[LEVEL]=='admin' OR $_SESSION[LEVEL]=='user'){ ?>
                    <li>
                        <a href="javascript:;"><i class="sidebar-item-icon fa fa-recycle"></i>
                            <span class="nav-label">Pemeliharaan</span><i class="fa fa-angle-left arrow"></i></a>
                        <ul class="nav-2-level collapse">
                            <?php  //include  'mn_side/mn_pelihara.php';?>
                        </ul>
                    </li>
                    <?php } ?>

                     

                    <?php if($cek==1 OR $_SESSION[LEVEL]=='admin'){ ?>
                    <li>
                        <a href="javascript:;"><i class="sidebar-item-icon fa fa-thumbs-up"></i>
                            <span class="nav-label">Pinjam Pakai</span>
                            <i class="fa fa-angle-left arrow"></i></a>
                        <ul class="nav-2-level collapse">
                            <?php // include 'mn_side/mn_persediaan.php';?>
                        </ul>
                    </li>
                    <?php } ?>

                    <?php if($cek==1 OR $_SESSION[LEVEL]=='admin'){ ?>
                    <li>
                        <a href="javascript:;"><i class="sidebar-item-icon fa fa-book"></i>
                            <span class="nav-label">Permintaan Blanko</span><i class="fa fa-angle-left arrow"></i></a>
                        <ul class="nav-2-level collapse">
                            <?php // include 'mn_side/mn_persediaan.php';?>
                        </ul>
                    </li>
                    <?php } ?>
UNDER CONSTRUCTION -->
                </ul>
            </div>
        </nav>
        <!-- END SIDEBAR-->