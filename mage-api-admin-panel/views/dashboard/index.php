<?php
use core\View;
?>

<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Main Page
                    <small>Subheading</small>
                </h1>

                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i>  <a href="<?=SITE_URL?>/dashboard/index">Dashboard</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-file"></i>
                    </li>
                </ol>

                <?php if(isset(View::$successMessage)):?>
                    <div class="alert alert-success">
                        <strong> <?= View::$successMessage?> </strong>
                    </div>
                <?php endif;?>


                <?php if(isset($message)):?>
                <div class="alert alert-success">
                    <strong> <?=$message?> </strong>
                </div>
                <?php endif;?>

                <div>
                    <h4>To start - please try to click menu items on the left panel.</h4>
                </div>

            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->

</div>
