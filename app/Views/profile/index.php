<script type="text/javascript">
    
    $(document).ready(function() {
        
    });
    
    function save(){
        var nrp = document.getElementById('nrp').value;
        var nama = document.getElementById('nama').value;
        var tgllahir = document.getElementById('tgllahir').value;
        var agama = document.getElementById('agama').value;
        
        if(nrp === ""){
            alert("NRP tidak boleh kosong");
        }else if(nama === ""){
            alert("Nama tidak boleh kosong");
        }else{
            $('#btnSave').html('<i class="mdi mdi-content-save"></i> Proses... ');
            $('#btnSave').attr('disabled',true);

            var form_data = new FormData();
            form_data.append('nrp', nrp);
            form_data.append('nama', nama);
            form_data.append('tgllahir', tgllahir);
            form_data.append('agama', agama);
            
            $.ajax({
                url: "<?php echo base_url(); ?>/profile/proses",
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (response) {
                    alert(response.status);
                    
                    $('#lama').val("");
                    $('#baru').val("");
                    
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
                    <h4 class="card-title">PROFILE</h4>
                    <div class="forms-sample">
                        <div class="form-group">
                            <label>NRP</label>
                            <input id="nrp" name="nrp" type="text" class="form-control" autocomplete="off" value="<?php echo $nrp; ?>">
                        </div>
                        <div class="form-group">
                            <label>NAMA PERSONIL</label>
                            <input id="nama" name="nama" type="text" class="form-control" autocomplete="off" value="<?php echo $nama; ?>">
                        </div>
                        <div class="form-group">
                            <label>TANGGAL LAHIR</label>
                            <input id="tgllahir" name="tgllahir" type="date" class="form-control" autocomplete="off" value="<?php echo $tgl_lahir; ?>">
                        </div>
                        <div class="form-group">
                            <label>AGAMA</label>
                            <select id="agama" name="agama" class="form-control">
                                <option value="-">- Pilih Agama -</option>
                                <option <?php if($agama == "Islam"){ echo 'selected'; } ?> value="Islam">Islam</option>
                                <option <?php if($agama == "Kristen"){ echo 'selected'; } ?> value="Kristen">Kristen</option>
                                <option <?php if($agama == "Katholik"){ echo 'selected'; } ?> value="Katholik">Katholik</option>
                                <option <?php if($agama == "Hindu"){ echo 'selected'; } ?> value="Hindu">Hindu</option>
                                <option <?php if($agama == "Budha"){ echo 'selected'; } ?> value="Budha">Budha</option>
                            </select>
                        </div>
                        <button id="btnSave" class="btn btn-primary" onclick="save()"><i class="mdi mdi-content-save"></i> Simpan </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>