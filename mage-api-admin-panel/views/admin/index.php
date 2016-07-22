<?php
if (isset($_SESSION['authorized']) && $_SESSION['authorized'] == 1) {
    header("Location:" . SITE_URL . "/dashboard");
    exit;
}
use core\View;

?>

<html>
<head>
    <!-- Bootstrap Core CSS -->
    <link href="../../assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../../assets/css/sb-admin.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="../../assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="wrapper">

    <h2>Products Management panel</h2>
    <div class="row">
        <div class="col-lg-6">
            <form role="form" method="post" action="<?=SITE_URL?>/admin/index">

                <?php if(isset(View::$errorMessage)):?>
                    <div class="alert alert-danger">
                        <strong> <?= View::$errorMessage?> </strong>
                     </div>
                 <?php endif;?>

                <?php if(isset($_SESSION['logged_out'])):?>
                    <div class="alert alert-info">
                        <strong> <?=$_SESSION['logged_out']?> </strong>
                        <?php unset($_SESSION['logged_out'])?>
                    </div>
                <?php endif;?>


                <div class="form-group">
                    <label>Email</label>
                    <input class="form-control" name="email" placeholder="Email">
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Password">
                </div>

                <button type="submit" class="btn btn-primary">Enter</button>
                <button type="reset" class="btn btn-default">Reset Button</button>

            </form>

        </div>
    </div>
</div>
</body>
</html>
