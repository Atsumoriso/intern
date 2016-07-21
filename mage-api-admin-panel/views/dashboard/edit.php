<?php
use models\Product;
use core\View;
?>


    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Product Editing page
                        <small></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-dashboard"></i>  <a href="<?=SITE_URL?>/dashboard">Dashboard</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-file"></i> Product Editing page
                        </li>
                    </ol>
                    <div>
                        <h2> Edit product ID <?=$product->getId()?></h2>

                        <?php if(isset(View::$errorMessage)):?>
                            <div class="alert alert-danger">
                                <strong> <?= View::$errorMessage?> </strong>
                            </div>
                        <?php endif;?>

                        <div>
                            <form action="<?=SITE_URL . '/dashboard/edit?id=' . $product->getId()?>" method="post">

                                <div class="col-md-12">
                                    <div class="col-md-2">
                                        <p><label for="name">Name</label> </p>

                                    </div>
                                    <div class="col-md-8">
                                        <p><input type="text" name="name" id="name" title="Name" value="<?= isset($name) ? $name : $product->getName() ?>" style="width: 500px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-2">
                                        <p><label for="sku">SKU</label> </p>
                                    </div>
                                    <div class="col-md-8">
                                        <p><input type="text" name="sku" id="sku" title="SKU" value="<?=isset($sku)?$sku:$product->getSku()?>" style="width: 500px;"></p>

                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-2">
                                        <p><label for="price">Price</label> </p>
                                    </div>
                                    <div class="col-md-8">
                                        <p><input type="text" name="price" id="price" title="Price" value="<?=isset($price)?$price:$product->getPrice()?>" style="width: 500px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-2">
                                        <p>Status</p>
                                    </div>
                                    <div class="col-md-8">
                                        <select name="status">

                                            <?php $status =  $product->getStatus();?>

                                            <option value="<?=Product::STATUS_NOT_ACTIVE?>"<?php if(isset($status) && $status== Product::STATUS_NOT_ACTIVE) echo "selected";?>>Disabled</option>
                                            <option value="<?=Product::STATUS_ACTIVE?>"<?php if(isset($status) && $status == Product::STATUS_ACTIVE) echo "selected";?>>Enabled</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="col-md-2">
                                        <p><label for="description">Description</label> </p>
                                    </div>
                                    <div class="col-md-8">
                                        <p><textarea rows="5" cols="57" id="description" name="description" title="Description"><?=isset($description)?$description:$product->getDescription()?></textarea></p>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-2">
                                        <p>Last updated</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p><?=$product->getLastUpdated()?></p>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-success">Save changes</button>
                            </form>
                        </div>

                    </div>
                </div>

            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>




