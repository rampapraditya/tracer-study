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
                    <h4 class="card-title">KUTIPAN RIWAYAT HIDUP</h4>
                    <div class="forms-sample">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="nrp" class="col-sm-3 col-form-label">NRP</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="nrp" name="nrp">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            
                        </div>
                        <div class="col-md-12">
                            <button id="btnSave" class="btn btn-primary" onclick="save()"><i class="mdi mdi-content-save"></i> Simpan </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>