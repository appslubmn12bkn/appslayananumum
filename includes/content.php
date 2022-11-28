<style type="text/css">
  ul.timeline {
    list-style-type: none;
    position: relative;
}
ul.timeline:before {
    content: ' ';
    background: #d4d9df;
    display: inline-block;
    position: absolute;
    left: 29px;
    width: 2px;
    height: 100%;
    z-index: 400;
}
ul.timeline > li {
    margin: 20px 0;
    padding-left: 20px;
}
ul.timeline > li:before {
    content: ' ';
    background: white;
    display: inline-block;
    position: absolute;
    border-radius: 50%;
    border: 3px solid #22c0e8;
    left: 20px;
    width: 20px;
    height: 20px;
    z-index: 400;
}
</style>
<?php $b = getdate() ?>
<?php
error_reporting(0);
error_reporting('E_NONE');
session_start();
include "config/koneksi.php";
date_default_timezone_set("Asia/Bangkok");
$tgl = mysqli_query($koneksi, "SELECT s_tglawal, s_tglakhir, s_thnang FROM s_settgl
                               ORDER BY idtgl ASC");
$rs        = mysqli_fetch_array($tgl);

$dtPsedia = mysqli_query($koneksi," SELECT  a.kd_brg, a.ur_brg,
                                            a.kd_kbrg, a.kd_jbrg, 
                                            a.satuan, a.kd_lokasi
                                    FROM c_brgsedia a
                                    ORDER BY a.kd_brg ASC");
$Pesedia = mysqli_num_rows($dtPsedia);


$unit = mysqli_query($koneksi," SELECT  a.idminta, a.registrasi, a.qtypesanan,
                                        a.unut, a.tglmohon, a.unit,
                                        b.r_idutama, b.r_ruangutama
                                FROM c_unitsediaminta a 
                                LEFT JOIN r_ruangutama b ON b.r_idutama=a.unut
                                ORDER BY registrasi ASC");

$keluar = mysqli_query($koneksi," SELECT id, registrasi, COUNT(kd_brg) AS brg_kel 
                                  FROM c_sediakeluarunit 
                                  ORDER BY registrasi ASC");
$out = mysqli_fetch_array($keluar);

$info = mysqli_query($koneksi," SELECT idinfo, judul, tglinfo, info_gudang 
                                FROM c_infogudang 
                                WHERE tglinfo between '$rs[s_tglawal]' AND '$rs[s_tglakhir]'
                                ORDER BY idinfo ASC");


if ($_GET['module'] == 'home') {
  echo "
              <div class='page-content fade-in-up'>
                <div class='row'>
                    <div class='col-lg-3 col-md-6'>
                        <div class='ibox bg-success color-white widget-stat'>
                            <div class='ibox-body'>
                                <h2 class='m-b-5 font-strong'>201</h2>
                                <div class='m-b-5'>NEW ORDERS</div><i class='ti-shopping-cart widget-stat-icon'></i>
                                <div><i class='fa fa-level-up m-r-5'></i><small>25% higher</small></div>
                            </div>
                        </div>
                    </div>
                    <div class='col-lg-3 col-md-6'>
                        <div class='ibox bg-info color-white widget-stat'>
                            <div class='ibox-body'>
                                <h2 class='m-b-5 font-strong'>1250</h2>
                                <div class='m-b-5'>UNIQUE VIEWS</div><i class='ti-bar-chart widget-stat-icon'></i>
                                <div><i class='fa fa-level-up m-r-5'></i><small>17% higher</small></div>
                            </div>
                        </div>
                    </div>
                    <div class='col-lg-3 col-md-6'>
                        <div class='ibox bg-warning color-white widget-stat'>
                            <div class='ibox-body'>
                                <h2 class='m-b-5 font-strong'>$1570</h2>
                                <div class='m-b-5'>TOTAL INCOME</div><i class='fa fa-money widget-stat-icon'></i>
                                <div><i class='fa fa-level-up m-r-5'></i><small>22% higher</small></div>
                            </div>
                        </div>
                    </div>
                    <div class='col-lg-3 col-md-6'>
                        <div class='ibox bg-danger color-white widget-stat'>
                            <div class='ibox-body'>
                                <h2 class='m-b-5 font-strong'>108</h2>
                                <div class='m-b-5'>NEW USERS</div><i class='ti-user widget-stat-icon'></i>
                                <div><i class='fa fa-level-down m-r-5'></i><small>-12% Lower</small></div>
                            </div>
                        </div>
                    </div>


                  <div class='col-md-8'>
                    <div class='ibox'>
                            <div class='ibox-head'>
                                <div class='ibox-title'>Log Activity</div>
                                <ul class='nav nav-tabs tabs-line   '>
                                    <li class='nav-item'>
                                        <a class='nav-link' href='#tab-8-3' data-toggle='tab'><i class=' ti-shopping-cart'></i> Informasi Terkini</a>
                                    </li>
                                    <li class='nav-item'>
                                        <a class='nav-link active' href='#tab-8-2' data-toggle='tab'><i class='fa fa-info'></i> Activity-Persediaan masuk</a>
                                    </li>
                                </ul>
                            </div>
                            <div class='ibox-body'>
                                <div class='tab-content'>
                                    <div class='tab-pane' id='tab-8-2'>
                                    Aktivitas Persediaan Masuk
                                    </div>

                                    <div class='tab-pane fade'id='tab-8-3'>
                                    
                                        <div class='container mt-10 mb-2'>
                                          <div class='row'>
                                          <h4><strong>Lates News</strong></h4>
                                            <div class='col-md-12'>";
                                            while ($news = mysqli_fetch_array($info)) {
                                        echo"   <ul class='timeline'>
                                                <li>
                                                   <font color='#d15b0d'><strong>$news[judul]
                                                   </strong></font>
                                                    <div class='float-right'><font color='#d15b0d'>
                                                    $news[tglinfo]</font></div>
                                                    <p>
                                                    $news[info_gudang]
                                                    </p>
                                                </li>
                                                </ul>";
                                              }
                                       echo"  </div>
                                          </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                  </div>


                            <div class='col-md-4'>

                                <div class='box'>
                                    <div class='ibox'>
                                        <div class='ibox-head'>
                                           <div class='ibox-title'>Layanan Persediaan</div>
                                        </div>
                                        <div class='ibox-body'> ";
                                        while ($reg = mysqli_fetch_array($unit)) {
                                echo"    <h6>$reg[r_ruangutama] - $reg[tglmohon]
                                         <div class='pull-right'><span class='badge badge-primary m-r-5 m-b-1'>$reg[qtypesanan]</span></div></h6><br>";

                                        }
                                echo"   </div>
                                    </div>
                                </div>

                                <div class='box'>
                                    <div class='ibox'>
                                        <div class='ibox-head'>
                                           <div class='ibox-title'>Layanan Kendaraan Dinas</div>
                                        </div>
                                        <div class='ibox-body'> 
                                          

                                        </div>
                                    </div>
                                </div>

                                <div class='box'>
                                    <div class='ibox'>
                                        <div class='ibox-head'>
                                           <div class='ibox-title'>Layanan Pinjam BMN</div>
                                        </div>
                                        <div class='ibox-body'> 
                                          
SEDANG PROSES
                                        </div>
                                    </div>
                                </div>

                                <div class='box'>
                                    <div class='ibox'>
                                        <div class='ibox-head'>
                                           <div class='ibox-title'>Laporan Kerusakan</div>
                                        </div>
                                        <div class='ibox-body'> 
                                          
SEDANG PROSES
                                        </div>
                                    </div>
                                </div>

                                <div class='box'>
                                    <div class='ibox'>
                                        <div class='ibox-head'>
                                           <div class='ibox-title'>Layanan Pinjam Ruangan</div>
                                        </div>
                                        <div class='ibox-body'> 
                                          
SEDANG PROSES
                                        </div>
                                    </div>
                                </div>

                                <div class='box'>
                                    <div class='ibox'>
                                        <div class='ibox-head'>
                                           <div class='ibox-title'>Permohonan Blanko</div>
                                        </div>
                                        <div class='ibox-body'> 
                                          
SEDANG PROSES
                                        </div>
                                    </div>
                                </div>

                            </div>

            </div>
            </div>


      
";
} elseif ($_GET['module'] == 'tbl_brg') {
  if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
    include 'media/sedia_tabel/tabelpsedia.php';
  }
} elseif ($_GET['module'] == 'tbl_stokbrg') {
  if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
    include 'media/sedia_tabel/tabelpsedia_stock.php';
  }
} 
elseif ($_GET['module'] == 'sedia_pengajuan') {
  if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
    include 'media/sedia_permohonan/sedia_pengajuan.php';
  }

} elseif ($_GET['module'] == 'c_printsedia') {
  if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
    include 'media/sedia_aksiunit/sedia_cetak.php';
  }
}elseif ($_GET['module'] == 'c_cekstatus') {
  if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
    include 'media/sedia_aksiunit/sedia_statuscek.php';
  }
}elseif ($_GET['module'] == 'c_aksiProsedia') {
  if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
    include 'media/aksiunit/sedia_aksiunit.php';
  }
}elseif ($_GET['module'] == 'c_spamPsedia') {
  if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
    include 'media/aksiunit/sedia_spamunit.php';
  }
}elseif ($_GET['module'] == 'e_instansi') {
  if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
    include 'media/ekspedisi/e_instansi.php';
  }
}
elseif ($_GET['module'] == 'e_catekspedisi') {
  if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
    include 'media/ekspedisi/e_catatekspedisi.php';
  }
}
elseif ($_GET['module'] == 'ct_ekpedisi') {
  if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
    include 'media/ekspedisi/e_cetakekspedisi.php';
  }
}

elseif ($_GET['module'] == 'paket') {
  if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
    include 'media/ekspedisi/e_ambilpaket.php';
  }
}

//MENU BMN
elseif ($_GET['module'] == 'bmnMaster') {
  if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
    include 'media/bmn/bmnMaster.php';
  }
}

elseif ($_GET['module'] == 'bmnHistory') {
  if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
    include 'media/bmn/bmnHistory.php';
  }
}

elseif ($_GET['module'] == 'bmnTambah') {
  if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
    include 'media/bmn/bmnTambah.php';
  }
}

?>