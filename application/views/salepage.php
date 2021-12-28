<div class="custom-container">
    <div class='text-center mb-4'>
        <h2>Volumne Created</h2>
    </div>
    <div class="row">
        <div class='col-6'>
            <div class="price-span">
                <h4>Price: <?=$tokenData['bnbVal']?> BNB</h4>
            </div><br />
            <div class="count-span">
                <h5>Count: <?php if ($tokenData['limit']) {?>No Limit <?php } else {echo $tokenData['saleCount'];}?>
                </h5>
            </div><br />
            <b>Total: <?=sizeof($tokenData['files'])?> file(s)</b> <br />
            <b>Hidden text contain: <?=strlen($tokenData['saleText'])?> symbol(s)</b><br />
            Download file(s): <br />
            <ul>
                <?php foreach ($tokenData['files'] as $file) {?>
                <li key="<?=$file['name']?>">
                    <?=$file['name'] . " - " . $file['size']?>
                </li>
                <?php }?>
            </ul>
        </div>
        <div class='col-6'>
            <b>Info(Description by file owner):</b><br />
            <strong class="text-muted"><?=$tokenData['fileInfoText']?></strong>
        </div>
    </div>
    <div class="row">
        <div class='col-12 mb-3 mt-3'>
            <div class="alert-div alert alert-primary">
                <div style="display:flex, justifyContent: space-between">
                    <div style="wordWrap: break-word">
                        Address:
                        <input class="custom-input" value="<?=$toaddress?>" name="toaddress" style="width: 430px">
                        <input value="<?=$id?>" name="id" hidden>
                    </div>
                    <div class="mt-2">
                        <a href="<?=base_url().'sale/download/'.$id?>" id="download" class="btn btn-default custom-action-btn mr-3">
                            Download
                        </a>
                        <button id="buy" class="btn btn-default custom-action-btn" style="float: right">
                            Buy
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
/**
 * download for salepage
 */

$("button#download").click(function() {
    var id = document.querySelector('input[name="id"]');
    var toaddress = document.querySelector('input[name="toaddress"]');

    $.ajax({
        method: "POST",
        url: baseUrl + 'index.php/sale/download',
        data: {
            id: id.value,
            toaddress: toaddress.value
        },
        dataType: 'JSON',
        beforeSend: function() {
            // $('.loading').show();
        },
        success: function(data) {
            //what do i fill here
            if (data.success) {

                // var files = data.files;

                // files && files.forEach(file => {
                //     // const url = URL.createObjectURL(baseUrl + 'uploads/' + file[0]);
                //     let url = baseUrl + 'uploads/' + file[0];
                //     const link = document.createElement('a');
                //     link.href = url;
                //     document.body.append(link);
                //     link.click();
                //     document.body.removeChild(link);
                //     URL.revokeObjectURL(url);
                //     console.log('download.');
                // });
            }
        },
        error: function(err) {

        }
    });
})
</script>