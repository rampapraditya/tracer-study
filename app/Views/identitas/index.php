<script type="text/javascript">
    
    $(document).ready(function() {
        
    });
    
    function save(){
        var ins = document.getElementById('ins').value;
        var slogan = document.getElementById('slogan').value;
        var tahun = document.getElementById('tahun').value;
        var pimpinan = document.getElementById('pimpinan').value;
        var alamat = document.getElementById('alamat').value;
        var kdpos = document.getElementById('kdpos').value;
        var tlp = document.getElementById('tlp').value;
        var fax = document.getElementById('fax').value;
        var web = document.getElementById('web').value;
        var lat = document.getElementById('lat').value;
        var lon = document.getElementById('lon').value;
        var email = document.getElementById('email').value;
        var foto = $('#logo').prop('files')[0];
        
        if(ins === ""){
            alert("Instansi tidak boleh kosong");
        }else if(alamat === ""){
            alert("Alamat tidak boleh kosong");
        }else if(tlp === ""){
            alert("Telepon tidak boleh kosong");
        }else{
            $('#btnSave').html('<i class="mdi mdi-content-save"></i> Proses... ');
            $('#btnSave').attr('disabled',true);

            var form_data = new FormData();
            form_data.append('nama', ins);
            form_data.append('slogan', slogan);
            form_data.append('tahun', tahun);
            form_data.append('pimpinan', pimpinan);
            form_data.append('alamat', alamat);
            form_data.append('kdpos', kdpos);
            form_data.append('tlp', tlp);
            form_data.append('fax', fax);
            form_data.append('web', web);
            form_data.append('lat', lat);
            form_data.append('lon', lon);
            form_data.append('email', email);
            form_data.append('file', foto);
            
            $.ajax({
                url: "<?php echo base_url(); ?>/identitas/proses",
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (response) {
                    alert(response.status);
                    
                    $('#btnSave').html('<i class="mdi mdi-content-save"></i> Simpan ');
                    $('#btnSave').attr('disabled',false);

                },error: function (response) {
                    alert(response.status);

                    $('#btnSave').html('<i class="mdi mdi-content-save"></i> Simpan ');
                    $('#btnSave').attr('disabled',false);
                }
            });
        }
    }
    
</script>

<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">IDENTITAS PERUSAHAAN / INSTANSI</h4>
                    <div class="forms-sample">
                        <div class="form-group row">
                            <label for="ins" class="col-sm-2 col-form-label">NAMA INSTANSI</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="ins" name="ins" autofocus="" autocomplete="off" value="<?php echo $instansi; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="slogan" class="col-sm-2 col-form-label">SLOGAN</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="slogan" name="slogan"  autocomplete="off" value="<?php echo $slogan; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tahun" class="col-sm-2 col-form-label">TAHUN BERDIRI</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="tahun" name="tahun" autocomplete="off" onkeypress="return hanyaAngka(event,false);" value="<?php echo $tahun; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pimpinan" class="col-sm-2 col-form-label">PIMPINAN</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="pimpinan" name="pimpinan"  autocomplete="off" value="<?php echo $pimpinan; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="alamat" class="col-sm-2 col-form-label">ALAMAT</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="alamat" name="alamat"  autocomplete="off" value="<?php echo $alamat; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kdpos" class="col-sm-2 col-form-label">KODE POS</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="kdpos" name="kdpos"  autocomplete="off" onkeypress="return hanyaAngka(event, false);" value="<?php echo $kdpos; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tlp" class="col-sm-2 col-form-label">TELEPON</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="tlp" name="tlp"  autocomplete="off" onkeypress="return hanyaAngka(event, false);" value="<?php echo $tlp; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fax" class="col-sm-2 col-form-label">FAX</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="fax" name="fax"  autocomplete="off" value="<?php echo $fax; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fax" class="col-sm-2 col-form-label">EMAIL</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="email" name="email"  autocomplete="off" value="<?php echo $email; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="web" class="col-sm-2 col-form-label">WEBSITE</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="web" name="web"  autocomplete="off" value="<?php echo $website; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="logo" class="col-sm-2 col-form-label">LOGO</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" id="logo" name="logo">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="lat" class="col-sm-2 col-form-label">LINTANG</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="lat" name="lat"  autocomplete="off" value="<?php echo $lat; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="lon" class="col-sm-2 col-form-label">BUJUR</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="lon" name="lon" autocomplete="off" value="<?php echo $lon; ?>">
                            </div>
                        </div>
                        <button id="btnSave" class="btn btn-primary" onclick="save()"><i class="mdi mdi-content-save"></i> Simpan </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>