<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Config Metas -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Dynamic Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="theme-color" content="#000000" />
    <meta name="description" content="BNBDisk" />
    <meta name="author" content="">
    <title>BNBDisk</title>

    <!-- Static Metas -->
    <!-- <link rel="icon" href="../../favicon.ico"> -->

    <!-- Tags Link -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" />
    <link href="<?php echo base_url(); ?>assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/theme.css" rel="stylesheet">
    <script src="<?php echo base_url(); ?>assets/js/ie-emulation-modes-warning.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

    <script src='<?=base_url()?>assets/js/common.js' type='text/javascript'></script>

    <!-- upload link -->
    <link href='<?=base_url()?>assets/css/dropzone.css' type='text/css' rel='stylesheet'>
    <script src='<?=base_url()?>assets/js/dropzone.js' type='text/javascript'></script>

    <!-- Dropzone CDN -->
    <!--
    <link href='https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.css' type='text/css' rel='stylesheet'>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js' type='text/javascript'></script>
    -->

    <!-- web3 -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/ethjs@0.3.4/dist/ethjs.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/web3/1.2.7-rc.0/web3.min.js"></script>
    <!-- end -->

    <!-- slider for count -->
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/11.0.2/bootstrap-slider.min.js"></script>
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/11.0.2/bootstrap-slider.js"></script>

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/11.0.2/css/bootstrap-slider.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/11.0.2/css/bootstrap-slider.min.css" />
    <!-- end -->

    <script>
    var gaddress = '';
    var baseUrl = '<?=base_url()?>';
    </script>

</head>

<body style="background-color:#070b28">

    <!-- Start Responsive Container -->
    <!-- <div class="container theme-showcase" role="main"> -->
    <section class="showcase">
        <div class="container">
            <div class="container-main">
                <div class="header-container">
                    <div style="float:right">
                        <a href="/" class="header-link">BNBDisk</a>
                        <?php if ($sliced_address != '') {?>
                        <button class="btn btn-default connect-wallet-btn" id="connect-btn"> <?=$sliced_address?> </button>
                        <?php } else {?>
                        <button class="btn btn-default connect-wallet-btn" id="connect-btn">Connect</button>
                        <?php }?>
                    </div>
                </div>