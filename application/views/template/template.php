<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SIPADU - 
    <?php if(!empty($judul)){ echo $judul;} ?>
    </title>
    
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-DSQJ2SWBXE"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
    //   gtag('config', 'G-DSQJ2SWBXE');
      gtag('config', 'G-DSQJ2SWBXE', {
        'page_title': document.title,
        'page_path': window.location.pathname
      });
    </script>


    <!-- /theme JS files -->

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="<?= base_url(); ?>/global_assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url(); ?>assets/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url(); ?>assets/css/core.min.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url(); ?>assets/css/layout.min.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url(); ?>assets/css/components.min.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url(); ?>assets/css/colors.min.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="<?= base_url(); ?>/global_assets/js/plugins/loaders/pace.min.js"></script>
    <script src="<?= base_url(); ?>/global_assets/js/main/jquery.min.js"></script>
    <script src="<?= base_url(); ?>/global_assets/js/main/bootstrap.bundle.min.js"></script>
    <!--<script src="<?= base_url(); ?>/global_assets/js/core/libraries/jquery.min.js"></script>-->
    <!--<script src="<?= base_url(); ?>/global_assets/js/core/libraries/bootstrap.min.js"></script>-->
    <script src="<?= base_url(); ?>/global_assets/js/plugins/loaders/blockui.min.js"></script>
    <script src="<?= base_url(); ?>/global_assets/js/plugins/ui/slinky.min.js"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->

    <script src="<?= base_url(); ?>/global_assets/js/plugins/visualization/d3/d3.min.js"></script>
    <script src="<?= base_url(); ?>/global_assets/js/plugins/visualization/d3/d3_tooltip.js"></script>
    <script src="<?= base_url(); ?>/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script src="<?= base_url(); ?>/global_assets/js/plugins/tables/datatables/extensions/responsive.min.js"></script>
    <script src="<?= base_url(); ?>/global_assets/js/plugins/forms/selects/select2.min.js"></script>
    <script src="<?= base_url(); ?>/global_assets/js/plugins/ui/moment/moment.min.js"></script>
    <script src="<?= base_url(); ?>/global_assets/js/plugins/ui/sticky.min.js"></script>

    <script src="<?= base_url(); ?>assets/js/app.js"></script>
    <script src="<?= base_url(); ?>/global_assets/js/demo_pages/dashboard.js"></script>
    <script src="<?= base_url(); ?>/global_assets/js/demo_pages/datatables_basic.js"></script>
    <script src="<?= base_url(); ?>/global_assets/js/demo_pages/datatables_responsive.js"></script>
    <script src="<?= base_url(); ?>/global_assets/js/demo_pages/form_layouts.js"></script>
    <!-- <script src="<?= base_url(); ?>/global_assets/js/demo_pages/navbar_multiple_sticky.js"></script> -->
    <!-- <script src="<?= base_url(); ?>/global_assets/js/demo_pages/navbar_multiple.js"></script>
    <script src="<?= base_url(); ?>/global_assets/js/demo_pages/navbar_multiple_sticky.js"></script> -->

    <!-- /theme JS files -->

    <script src="https://website-widgets.pages.dev/dist/sienna.min.js" defer></script>

</head>

<body>

    <!-- Main navbar -->
    <?php require "navbar.php" ?>
    <!-- /main navbar -->

    <?php require "secondary navbar.php" ?>

    <!-- Page header -->
    <?php //require "page-header.php" 
    ?>
    <!-- /page header -->

    <br>

    <!-- Page content -->
    <div class="page-content pt-0">

        <!-- Main sidebar -->
        <?php //require "sidebar.php" 
        ?>
        <!-- /main sidebar -->


        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Content area -->
            <div class="content">

                <?php echo $contents; ?>

            </div>
            <!-- /content area -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->


    <!-- Footer -->
    <?php require "footer.php" ?>
    <!-- /footer -->

</body>

</html>