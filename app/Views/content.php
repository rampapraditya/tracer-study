<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <h3 class="font-weight-bold"><?php echo "Welcome ".$nama; ?></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body" style="text-align: center;">
                    <h3><?php echo $app_name; ?></h3>
                    <h6><?php echo $slogan; ?></h6>
                    <img src="<?php echo $logo; ?>" style="width: 150px; height: auto; margin-top: 20px;">
                    <p style="margin-top: 50px;"><?php echo $alamat . ' - '; ?><a target="_blank" href="<?php echo $website; ?>"><?php echo $website; ?></a></p>
                    <p style="margin-top: 5px;"><?php echo "Telp : " . $tlp; if(strlen($fax) > 0){ echo ', Fax : ' . $fax; } ?></p>
                </div>
            </div>
        </div>
    </div>
</div>