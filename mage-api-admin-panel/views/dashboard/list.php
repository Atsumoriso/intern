<?php
use components\Paginator;
?>
<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Products List
                    <small></small>
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i>  <a href="<?=SITE_URL?>/dashboard">Dashboard</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-file"></i> Products Listing Page
                    </li>
                </ol>

                <?php $paginator->run($sort, $direction); ?>


                <div>
                    <!-- Form for sorting products -->
                    <div>
                        <form method="GET" action="<?=SITE_URL?>/dashboard/list">
                            <p>SORTED BY <select name="sort">

                                    <option value="name"<?php if(isset($sort) && $sort === "name") echo "selected";?>>Name</option>
                                    <option value="price"<?php if(isset($sort) && $sort === "price") echo "selected";?>>Price</option>

                                </select>
                                <select name="direction">
                                    <option value="asc"<?php if(isset($direction) && $direction == "asc") echo "selected";?>>ascending</option>
                                    <option value="desc"<?php if(isset($direction) && $direction == "desc") echo "selected";?>>descending</option>
                                </select>
                                <input type="submit" value="Sort!"></p>
                        </form>
                    </div>

                    <?php if(isset($_SESSION['edited_successfully'])):?>
                        <div class="alert alert-success">
                            <strong> <?=$_SESSION['edited_successfully']?> </strong>
                            <?php unset($_SESSION['edited_successfully']);?>
                        </div>
                    <?php endif;?>

                    <?php if(isset($_SESSION['imported_successfully'])):?>
                        <div class="alert alert-success">
                            <strong> <?=$_SESSION['imported_successfully']?> </strong>
                            <?php unset($_SESSION['imported_successfully'])?>
                        </div>
                    <?php endif;?>



                    <?php if(isset($products)): ?>

                            <div class="col-md-12">

                                <table border="2">
                                    <col width="500" valign="top">
                                    <col width="150" valign="top">
                                    <col width="150" valign="top">
                                    <tr>
                                        <th>
                                            Product name
                                        </th>
                                        <th>
                                            Product ID
                                        </th>
                                        <th>
                                            Price
                                        </th>
                                        <th>
                                            Photo
                                        </th>
                                    </tr>

                                <?php foreach ($products as $product): ?>

                                    <?php

                                    //todo may be no need to check status??
//                             if($product->status == Product::STATUS_ACTIVE): //todo remove? ?>
                                    <tr>
                                        <td>
                                            <a href="<?=SITE_URL?>/dashboard/edit?id=<?=$product->id?>" title="Edit">
                                                <h3><?=$product->name?></h3>
                                            </a>

                                        </td>
                                        <td>
                                            <?=$product->id?>
                                        </td>
                                        <td>
                                            <b><?=number_format($product->price, '2','.', ' ')?> </b>
                                        </td>
                                        <td>
                                                <img src="<?=$product->image_url?>"  width="100" title="<?=$product->name?>">
                                        </td>

                                    </tr>
                                    <?php //endif;?>
                                <?php endforeach;?>

                                </table>

                            </div>


                    <?php else: ?>
                         No imported products.
                    <?php endif;?>
                </div>

            </div>

         </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div><!-- /.page-wrapper -->


