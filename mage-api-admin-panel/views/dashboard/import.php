<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Products Import Page
                    <small></small>
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i>  <a href="<?=SITE_URL?>/dashboard">Dashboard</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-file"></i> Products Import Page
                    </li>
                </ol>


                <div>
                    <form method="post" action="<?=SITE_URL?>/dashboard/import">
                        <div class="form-group">
                            <label>Magento base url</label>
                            <input type="text" name="magento_base_url" value="http://magento-1.local">
                        </div>

                        <button type="submit" class="btn btn-success">IMPORT PRODUCTS</button>
                    </form>
                </div>

            </div>

        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div><!-- /.page-wrapper -->
