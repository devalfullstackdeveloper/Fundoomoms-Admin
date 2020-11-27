<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$userName = $_SESSION['username'];
?>
<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title><?= isset($page_name) && $page_name != "" ? $page_name : "FundooMoms" ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <!-- <link rel="shortcut icon" href="<?= base_url() ?>app-assets/images/favicon.ico"> -->
        <link rel="shortcut icon" href="<?= base_url() ?>app-assets/images/favicon.png">

        <!-- jquery.vectormap css -->
        <link href="<?= base_url() ?>app-assets/css/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
        <!-- Responsive Table css -->
        <link href="<?= base_url() ?>app-assets/css/rwd-table.min.css" rel="stylesheet" type="text/css" />
        <!-- DataTables -->
        <link href="<?= base_url() ?>app-assets/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>app-assets/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <!-- Sweet Alert-->
        <link href="<?= base_url() ?>app-assets/css/sweetalert2.min.css" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
        <link href="<?= base_url() ?>app-assets/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <!-- Bootstrap Css -->
        <link href="<?= base_url() ?>app-assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="<?= base_url() ?>app-assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="<?= base_url() ?>app-assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>app-assets/css/fontello.css" id="app-style" rel="stylesheet" type="text/css" />
        <!-- <link href="<?= base_url() ?>app-assets/css/ajax-loader.css" id="app-style" rel="stylesheet" type="text/css" /> -->

        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
		<link href="<?= base_url() ?>app-assets/css/custom-style.css" rel="stylesheet" type="text/css" />

        <?php
            if(isset($cdnstylescript)){
                foreach ($cdnstylescript as $scrkey => $scrvalue) {
        ?>
                <link rel="stylesheet" type="text/css" href="<?= $scrvalue; ?>">
        <?php             
                } 
            }
        ?>

         <style type="text/css">
            #overlay{   
    position: fixed;
    top: 0;
    z-index: 100;
    width: 100%;
    height:100%;
    display: none;
    background: rgba(0,0,0,0.6);
}
.cv-spinner {
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;  
}
.spinner {
    width: 40px;
    height: 40px;
    border: 4px #ddd solid;
    border-top: 4px #2e93e6 solid;
    border-radius: 50%;
    animation: sp-anime 0.8s infinite linear;
}
@keyframes sp-anime {
    100% { 
        transform: rotate(360deg); 
    }
}
.is-hide{
    display:none;
}
        </style>

    </head>

    <body data-layout="detached" data-topbar="colored">
        <input type="hidden" value="<?= base_url() ?>" id="baseUrl">
        <div class="container-fluid">
            <!-- Begin page -->
            <div id="layout-wrapper">

                <header id="page-topbar">
                    <div class="navbar-header">
                        <div class="container-fluid">
                            <div class="float-right">

                                <div class="dropdown d-inline-block d-lg-none ml-2">
                                    <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="mdi mdi-magnify"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0" aria-labelledby="page-header-search-dropdown">

                                        <form class="p-3">
                                            <div class="form-group m-0">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>


                                <div class="dropdown d-inline-block" >
                                    <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="display: none;">
                                        <i class="mdi mdi-bell-outline"></i>
                                        <span class="badge badge-danger badge-pill">3</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0" aria-labelledby="page-header-notifications-dropdown" >
                                        <div class="p-3">
                                            <div class="row align-items-center">
                                                <div class="col">
                                                    <h6 class="m-0"> Notifications </h6>
                                                </div>
                                                <div class="col-auto">
                                                    <a href="#!" class="small"> View All</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div data-simplebar style="max-height: 230px;">
                                            <a href="" class="text-reset notification-item">
                                                <div class="media">
                                                    <div class="avatar-xs mr-3">
                                                        <span class="avatar-title bg-primary rounded-circle font-size-16">
                                                            <i class="bx bx-cart"></i>
                                                        </span>
                                                    </div>
                                                    <div class="media-body">
                                                        <h6 class="mt-0 mb-1">Your order is placed</h6>
                                                        <div class="font-size-12 text-muted">
                                                            <p class="mb-1">If several languages coalesce the grammar</p>
                                                            <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 3 min ago</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                            <!-- <a href="" class="text-reset notification-item">
                                                <div class="media">
                                                    <img src="<?= base_url() ?>app-assets/images/avatar-3.jpg" class="mr-3 rounded-circle avatar-xs" alt="user-pic">
                                                    <div class="media-body">
                                                        <h6 class="mt-0 mb-1">James Lemire</h6>
                                                        <div class="font-size-12 text-muted">
                                                            <p class="mb-1">It will seem like simplified English.</p>
                                                            <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 1 hours ago</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="" class="text-reset notification-item">
                                                <div class="media">
                                                    <div class="avatar-xs mr-3">
                                                        <span class="avatar-title bg-success rounded-circle font-size-16">
                                                            <i class="bx bx-badge-check"></i>
                                                        </span>
                                                    </div>
                                                    <div class="media-body">
                                                        <h6 class="mt-0 mb-1">Your item is shipped</h6>
                                                        <div class="font-size-12 text-muted">
                                                            <p class="mb-1">If several languages coalesce the grammar</p>
                                                            <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 3 min ago</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>

                                            <a href="" class="text-reset notification-item">
                                                <div class="media">
                                                    <img src="<?= base_url() ?>app-assets/images/avatar-4.jpg" class="mr-3 rounded-circle avatar-xs" alt="user-pic">
                                                    <div class="media-body">
                                                        <h6 class="mt-0 mb-1">Salena Layfield</h6>
                                                        <div class="font-size-12 text-muted">
                                                            <p class="mb-1">As a skeptical Cambridge friend of mine occidental.</p>
                                                            <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 1 hours ago</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a> -->
                                        </div>
                                        <div class="p-2 border-top">
                                            <a class="btn btn-sm btn-link font-size-14 btn-block text-center" href="javascript:void(0)">
                                                <i class="mdi mdi-arrow-right-circle mr-1"></i> View More..
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="dropdown d-inline-block">
                                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?php
                                    // $userImg = '';
                                    $userImg = $_SESSION['LoginUserData']['user_img'];
                                    if(empty($userImg)){
                                    ?>    
                                        <img class="rounded-circle header-profile-user" src="<?= base_url() ?>app-assets/images/icon-pro.png" alt="Header Avatar">
                                    <?php 
                                    }else{
                                    ?>
                                        <img class="rounded-circle header-profile-user" src="<?= base_url()."".$userImg ?>" alt="Header Avatar">
                                    <?php    
                                    }   
                                    ?> 
                                    <?php
                                    if($userName == 'appqa3105@gmail.com') {
										$userName = "Admin";
									}
									?>
                                        <span class="d-none d-xl-inline-block ml-1"><?= $userName ?></span>
                                        <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <!-- item-->
<!--                                        <a class="dropdown-item" href="#"><i class="bx bx-user font-size-16 align-middle mr-1"></i> Profile</a>
                                        <a class="dropdown-item" href="#"><i class="bx bx-wallet font-size-16 align-middle mr-1"></i> My Wallet</a>
                                        <a class="dropdown-item d-block" href="#"><span class="badge badge-success float-right">11</span><i class="bx bx-wrench font-size-16 align-middle mr-1"></i> Settings</a>
                                        <a class="dropdown-item" href="#"><i class="bx bx-lock-open font-size-16 align-middle mr-1"></i> Lock screen</a>
                                        <div class="dropdown-divider"></div>-->
                                        <a class="dropdown-item" href="<?= base_url() ?>Ct_dashboard/AdminProfile/<?= $_SESSION['loginId'] ?>"><i class="bx bx-user font-size-16 align-middle mr-1"></i> Profile</a>
                                        <a class="dropdown-item" href="<?= base_url() ?>/Ct_dashboard/logout"><i class="bx bx-power-off font-size-16 align-middle mr-1"></i> Logout</a>
                                    </div>
                                </div>

                            </div>
                            <div>
                                <!-- LOGO -->
                                <div class="navbar-brand-box">
                                    <a href="<?= base_url() ?>" class="logo logo-dark">
                                        <span class="logo-sm">
                                            <img src="<?= base_url() ?>app-assets/images/logo-sm.png" alt="" height="20">
                                        </span>
                                        <span class="logo-lg">
                                            <img src="<?= base_url() ?>app-assets/images/logo-dark.png" alt="" height="17">
                                        </span>
                                    </a>

                                    <a href="<?= base_url() ?>" class="logo logo-light">
                                        <span class="logo-sm">
                                            <!-- <img src="<?= base_url() ?>app-assets/images/fundoomom_logo.png" alt="" height="20"> -->
                                        </span>
                                        <span class="logo-lg">
                                            <img src="<?= base_url() ?>app-assets/images/fundoomom-transparent.png" height="40" alt="">
                                        </span>
                                    </a>
                                </div>

                                <button type="button" class="btn btn-sm px-3 font-size-16 header-item toggle-btn waves-effect" id="vertical-menu-btn">
                                    <i class="fa fa-fw fa-bars"></i>
                                </button>

                                <!-- App Search-->
                                <!-- <form class="app-search d-none d-lg-inline-block">
                                    <div class="position-relative">
                                        <input type="text" class="form-control" placeholder="Search...">
                                        <span class="bx bx-search-alt"></span>
                                    </div>
                                </form> -->

                            </div>

                        </div>
                    </div>
                </header> <!-- ========== Left Sidebar Start ========== -->
                <div class="vertical-menu ">

                    <div class="h-100">

                        <!--- Sidemenu -->
                        <div id="sidebar-menu">
                            <!-- Left Menu Start -->
                            <ul class="metismenu list-unstyled" id="side-menu">
                                <li class="menu-title"></li>
                                <?php

                                if($_SESSION['LoginUserData']['is_admin']=="1"){
                                $mainMenu = $this->user->mainMenu();
                                foreach ($mainMenu as $im => $mm) {
                                    $subMenu = $this->user->subMenu($mm['mm_id']);
                                    $url = base_url() . $mm['mm_url'];
                                    if (count($subMenu) > 0) {
                                        $url = 'javascript:void(0);';
                                    }

                                    $actLi = '';
                                    $act = '';
                                    if(isset($page_name) && ($page_name == "Add Curriculum" || $page_name == "Edit Curriculum") && $mm['mm_name'] == 'Curriculum'){
                                        $actLi = 'class="mm-active"';
                                        $act = 'active';
                                    }
                                    ?>
                                    <li <?=$actLi?>>
                                        <a href="<?= $url ?>" class="<?= count($subMenu) > 0 ? 'has-arrow' : "" ?> waves-effect <?=$act?>">
                                            <?= $mm['mm_icon'] ?>
                                            <span id="menu_<?=$mm['mm_id']?>"><?= $mm['mm_name'] ?>
                                                <?php
                                                $notView = $this->user->getNotviewedRequest();
                                                if ($mm['mm_name'] == "Call Request" && $notView > 0) {
                                                ?>
                                                    <label class="badge badge-info"><?= $notView; ?></label>
                                                <?php    
                                                }

                                                if($mm['mm_name'] == "Mom's"){
                                                        $count = $this->user->countNewUser();
                                                        if($count>0){
                                                            $badge = '<label class="badge badge-info">'.$count.'</label>';
                                                        }else{
                                                            $badge = '';
                                                        }
                                                    }else{
                                                        $badge = '';
                                                    }
                                                 echo $badge;   
                                                ?>
                                            </span>
                                        </a>
                                        <ul class="sub-menu" aria-expanded="true">
                                            <?php
                                            if (count($subMenu) > 0) {
                                                foreach ($subMenu as $is => $sm) {
                                                    $subSubMenu = $this->user->subSubMenu($mm['mm_id'], $sm['sm_id']);
                                                    $url = base_url() . $sm['sm_url'];
                                                    if (count($subSubMenu) > 0) {
                                                        $url = 'javascript:void(0);';
                                                    }

                                                    
                                                    ?>
                                                    <li>
                                                        <a href="<?= $url ?>" class="<?= count($subSubMenu) > 0 ? 'has-arrow' : "" ?>"><?= $sm['sm_name'] ?></a>
                                                        <ul class="sub-menu" aria-expanded="true">
                                                        <?php                                                        
                                                        if (count($subSubMenu) > 0) {
                                                            foreach ($subSubMenu as $iss => $ssm) {
                                                                ?> <li><a href="<?=base_url().$ssm['ss_url']?>"><?=$ssm['ss_name']?></a></li> <?php
                                                            }
                                                        }
                                                    ?>
                                                        </ul>
                                                    </li>
                                                    <?php
                                                    
                                                }
                                            }
                                            ?>
                                        </ul>
                                        <?php
                                        ?>
                                    </li>
                                    <?php
                                }
                            }else{
                            $roleP = $this->user->rolePermission($_SESSION['LoginUserData']['role']);
                            $perm = json_decode($roleP->permission);
                              $mainMenu = $this->user->mainMenu();

                                foreach ($mainMenu as $im => $mm) {
                                    $MenuId1 = $mm['mm_id'];
                                    
                                    $subMenu = $this->user->subMenu($mm['mm_id']);
                                    $url = base_url() . $mm['mm_url'];
                                    if (count($subMenu) > 0) {
                                        $url = 'javascript:void(0);';
                                    }
                                    ?>
                                    <li><?php if(in_array("MM_".$MenuId1, $perm)){ ?>
                                        <a href="<?= $url ?>" class="<?= count($subMenu) > 0 ? 'has-arrow' : "" ?> waves-effect">
                                            <?= $mm['mm_icon'] ?>
                                            <span><?= $mm['mm_name'] ?></span>
                                        </a>

                                        <ul class="sub-menu" aria-expanded="true">
                                            <?php
                                            if (count($subMenu) > 0) {
                                                foreach ($subMenu as $is => $sm) {
                                                    $SubMenu1 = $sm['sm_id'];
                                                    $subSubMenu = $this->user->subSubMenu($mm['mm_id'], $sm['sm_id']);
                                                    $url = base_url() . $sm['sm_url'];
                                                    if (count($subSubMenu) > 0) {
                                                        $url = 'javascript:void(0);';
                                                    }
                                                    // die("SM_".$SubMenu1);
                                                    // die(print_r($subSubMenu));
                                                    ?>
                                                    <?php 
                                                    // if(count($subSubMenu)>0){
                                                    // if(in_array("SM_".$SubMenu1, $subSubMenu)){
                                                    ?>
                                                    <li>

                                                        <a href="<?= $url ?>" class="<?= count($subSubMenu) > 0 ? 'has-arrow' : "" ?>"><?= $sm['sm_name'] ?></a>
                                                        <ul class="sub-menu" aria-expanded="true">
                                                        <?php                                                        
                                                        if (count($subSubMenu) > 0) {
                                                            foreach ($subSubMenu as $iss => $ssm) {
                                                                
                                                                ?> 
                                                                <li>
                                                                    <a href="<?=base_url().$ssm['ss_url']?>"><?=$ssm['ss_name']?>
                                                                        
                                                                    </a></li> 
                                                                <?php
                                                            }
                                                        }
                                                    ?>
                                                        </ul>
                                                    </li>
                                                    <?php
                                                       // }
                                                    // }
                                                }
                                            }
                                            ?>
                                        </ul>
                                        <?php
                                            }
                                        ?>
                                    </li>
                                    <?php
                                }    
                            }
                            ?>
                            </ul>
                        </div>
                        <!-- Sidebar -->
                    </div>
                </div>
                <!-- Left Sidebar End -->