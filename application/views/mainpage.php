<!-- Start Header -->

<div class="custom-container">
    <div>
        <h1>Upload, share and sale for BNB</h1>
    </div>
    <FlexContent class="row">
        <div class='col-lg-6 col-md-6'>
            <label>Upload any files (max file size 50MB):</label>
            <form action="/target" class="dropzone dz-clickable" id="my-dropzone">
                <!-- <div class="dz-message d-flex flex-column">
                    Drag &amp; Drop here or click
                </div> -->
            </form>
            <!-- <textarea class="form-control textarea-style" rows="7"> </textarea> -->
        </div>
        <div class='col-lg-6 col-md-6'>
            <label>or text for sale:</label>
            <textarea class="form-control textarea-style" name="desc" id="desc" rows="7" data-toggle="tooltip"
                data-placement="top" title=""
                data-original-title="You can sale text only without any files. Or sale files+text. As you wish. Max text lenght: 64kb."></textarea>
        </div>
    </FlexContent>
</div>
<div class="custom-container" style="marginTop: 1rem">
    <div class='row' style="display: flex">
        <div class='col-lg-6 col-md-6'>
            <label>Open info about your files (optional): </label>
            <textarea class="form-control textarea-style" title="" name="info" id="info" rows="12" data-toggle="tooltip"
                data-placement="top"
                placeholder="What you sale:&#10&#10Short description:&#10&#10Contact info:&#10&#10email, phone, social media, jabber, etc."
                data-original-title="Buyers will pay faster If have more seller's info and reputation."></textarea>
        </div>
        <div class='col-lg-6 col-md-6'>
            <div class="form-group">
                <label>Your Wallet Address<span class="text-danger">*</span></label>
                <input type="text" name="wallet-address" class="form-control" id="wallet-address" placeholder=""
                    required="" title="" readonly />
            </div>
            <div class="row">
                <p class="col-12 text-muted m-sm-0">Price<span class="text-danger">*</span>:</p>
                <div class="col-lg-5 mt-3">
                    <div class="input-group form-group">
                        <label>BNB</label>
                        <input name="price" type="number" class="form-control" min="0.000" step="0.001" max="17"
                            title="" />
                    </div>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5" hidden>
                    <div class="input-group form-group">
                        <label>$</label>
                        <input name="usd" type="price" class="form-control" max="10" data-toggle="tooltip"
                            data-placement="top" title=""
                            data-original-title="Amount in USD will be calculated into BNB and store. We accept BNB and forward to yours wallet." />
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label class="mb-4 mt-3">Count of Sales (Zero is an unlimited Sales):</label>
                        <input type="range" class="form-control-range" name="count" id="count">
                        <span class="font-weight-bold text-primary mt-1 valueSpan"></span>
                        <!-- <input id="count" type="text" data-provide="slider" data-slider-ticks="[0, 25, 50, 75, 100]" data-slider-ticks-snap-bounds="5" data-slider-ticks-labels='["0", "25", "50", "75", "100"]'/> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 text-center mt-4">
            <input name="filenames" type="text" hidden />
            <input name="filedirnames" type="text" hidden />
            <button type="submit" class="btn btn-primary" id="updateandshare">Upload and Share
            </button>
        </div>
    </div>
</div>


<script>
Dropzone.autoDiscover = false;
</script>
<!-- End Content -->