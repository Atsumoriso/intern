
    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Profile
                        <small>page</small>
                    </h1>

                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-dashboard"></i>  <a href="<?=SITE_URL?>/dashboard/index">Dashboard</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-file"></i>Profile
                        </li>
                    </ol>

                    <div>
                        Вы вошли как  <b><?php echo $_SESSION['user_name'];?></b>
                        <br>
                        Ваш E-mail: <b><?php echo $_SESSION['user_email'];?></b>

                    </div>
                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
