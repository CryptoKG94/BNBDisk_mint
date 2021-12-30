<div class="custom-container">
    <div class='text-center mb-4'>
        <h2>Volumne Created</h2>
    </div>
    <div class="row">
        <?php if ($tokenData['files']) {?>
        <div class='col-6'>
            <b>Total: <?=sizeof($tokenData['files'])?> file(s)</b><br /><br />
            Uploaded:<br />
            <ul>
                <?php foreach ($tokenData['files'] as $file) { ?>
                <li key="<?=$file['name']?>" >
                    <?=$file['name'] . " - " . $file['size']?>
                </li>
                <?php }?>
            </ul>
        </div>
        <?php }?>
        <div class='col-6'>
            <?php if ($tokenData['saleText'] && strlen($tokenData['saleText']) != 0) {?>
            <b>Text Contain: <?=strlen($tokenData['saleText'])?> symbol(s)</b>
            <?php } ?> <br /><br />
            <div class="price-span">
                <h4>Price: <?=$tokenData['bnbVal']?> BNB</h4>
            </div><br />
            Address of seller:<br />
            <b><?=$address?></b><br />
            Sale Count: <?php if ($tokenData['limit']) { ?> No limit <?php } else { echo $tokenData['saleCount']?> time(s)
            <?php }?>
        </div>
    </div>
    <div class="row">
        <div class='col-12 mb-3 mt-3'>
            <div class="alert alert-primary alert-div">
                <p class="text-muted">
                    Please copy and save the link below. Otherwise, you will have to upload the file(s) and write text
                    again. Share this link directly to buyers. Publish at social networks, messenger channel, forum,
                    blog, site, etc...
                </p>
                <div style="display:flex, justifyContent: space-between">
                    <div style="wordWrap:break-word">
                        <!-- <LinkIcon /> -->
                        <a href="<?php echo base_url();?>index.php/sale/loading/<?php echo $tokenId?>"
                            style="marginLeft: 8, fontSize:18px"> <?=base_url();?>sale/<?=$tokenId?>
                        </a>
                    </div>
                    <div>
                        <!-- clipboard copy -->
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-12 text-center">
            <h5>Share this volume with your friends</h5>
        </div>
    </div>
    <!-- backdrop, toast -->
</div>