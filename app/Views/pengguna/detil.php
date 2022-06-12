<script type="text/javascript">
    
    var save_method = "";
    var tb_p_umum, tb_p_militer, tb_bahasa_asing, tb_bahasa_daerah;
    
    $(document).ready(function () {
        tb_p_umum = $('#tb_p_umum').DataTable({
            ajax: "<?php echo base_url(); ?>/pengguna/ajaxlist_p_umum",
            ordering : false,
            paging : false,
            searching : false
        });
        
        tb_p_militer = $('#tb_p_militer').DataTable({
            ajax: "<?php echo base_url(); ?>/pengguna/ajaxlist_p_militer",
            ordering : false,
            paging : false,
            searching : false
        });
        
        tb_bahasa_asing = $('#tb_bahasa_asing').DataTable({
            ajax: "<?php echo base_url(); ?>/pengguna/ajaxlist_b_asing",
            ordering : false,
            paging : false,
            searching : false
        });
        
        tb_bahasa_daerah = $('#tb_bahasa_daerah').DataTable({
            ajax: "<?php echo base_url(); ?>/pengguna/ajaxlist_b_daerah",
            ordering : false,
            paging : false,
            searching : false
        });
    });

    function load_pend_umum(){
        tb_p_umum = $('#tb_p_umum').DataTable({
            ajax: "<?php echo base_url(); ?>/pengguna/ajaxlist_p_umum",
            ordering : false,
            paging : false,
            searching : false,
            retrieve : true
        });
        tb_p_umum.destroy();
        tb_p_umum = $('#tb_p_umum').DataTable({
            ajax: "<?php echo base_url(); ?>/pengguna/ajaxlist_p_umum",
            ordering : false,
            paging : false,
            searching : false,
            retrieve : true
        });
    }
    
    function load_pend_militer(){
        tb_p_militer = $('#tb_p_militer').DataTable({
            ajax: "<?php echo base_url(); ?>/pengguna/ajaxlist_p_militer",
            ordering : false,
            paging : false,
            searching : false,
            retrieve : true
        });
        tb_p_militer.destroy();
        tb_p_militer = $('#tb_p_militer').DataTable({
            ajax: "<?php echo base_url(); ?>/pengguna/ajaxlist_p_militer",
            ordering : false,
            paging : false,
            searching : false,
            retrieve : true
        });
    }
    
    function load_bahasa(){
        tb_bahasa_asing = $('#tb_bahasa_asing').DataTable({
            ajax: "<?php echo base_url(); ?>/pengguna/ajaxlist_b_asing",
            ordering : false,
            paging : false,
            searching : false,
            retrieve : true
        });
        tb_bahasa_asing.destroy();
        tb_bahasa_asing = $('#tb_bahasa_asing').DataTable({
            ajax: "<?php echo base_url(); ?>/pengguna/ajaxlist_b_asing",
            ordering : false,
            paging : false,
            searching : false,
            retrieve : true
        });
        
        
        tb_bahasa_daerah = $('#tb_bahasa_daerah').DataTable({
            ajax: "<?php echo base_url(); ?>/pengguna/ajaxlist_b_daerah",
            ordering : false,
            paging : false,
            searching : false,
            retrieve : true
        });
        tb_bahasa_daerah.destroy();
        tb_bahasa_daerah = $('#tb_bahasa_daerah').DataTable({
            ajax: "<?php echo base_url(); ?>/pengguna/ajaxlist_b_daerah",
            ordering : false,
            paging : false,
            searching : false,
            retrieve : true
        });
    }
    
    function save() {
        var idusers = document.getElementById('idusers').value;
        var nrp = document.getElementById('nrp').value;
        var nama = document.getElementById('nama').value;
        var pangkat = document.getElementById('pangkat').value;
        var dinas_pangkat = document.getElementById('dinas_pangkat').value;
        var tmt_tni = document.getElementById('tmt_tni').value;
        var dinas_tni = document.getElementById('dinas_tni').value;
        var tmp_lahir = document.getElementById('tmp_lahir').value;
        var tgl_lahir = document.getElementById('tgl_lahir').value;
        var jabatan = document.getElementById('jabatan').value;
        var lama_jab = document.getElementById('lama_jab').value;
        var alamat = document.getElementById('alamat').value;
        var korps = document.getElementById('korps').value;
        var tmt_fiktif = document.getElementById('tmt_fiktif').value;
        var agama = document.getElementById('agama').value;
        var suku = document.getElementById('suku').value;
        
        if (nrp === "") {
            alert("NRP tidak boleh kosong");
        } else if (nama === "") {
            alert("Nama tidak boleh kosong");
        } else if (pangkat === "-") {
            alert("Pangkat tidak boleh kosong");
        } else if (korps === "-") {
            alert("Korps tidak boleh kosong");
        } else {
            $('#btnSave').html('<i class="mdi mdi-content-save"></i> Proses... ');
            $('#btnSave').attr('disabled', true);

            var form_data = new FormData();
            form_data.append('idusers', idusers);
            form_data.append('nrp', nrp);
            form_data.append('nama', nama);
            form_data.append('dinas_pangkat', dinas_pangkat);
            form_data.append('tmt_tni', tmt_tni);
            form_data.append('alamat', alamat);
            form_data.append('dinas_tni', dinas_tni);
            form_data.append('tmp_lahir', tmp_lahir);
            form_data.append('tgl_lahir', tgl_lahir);
            form_data.append('jabatan', jabatan);
            form_data.append('lama_jab', lama_jab);
            form_data.append('alamat', alamat);
            form_data.append('korps', korps);
            form_data.append('tmt_fiktif', tmt_fiktif);
            form_data.append('agama', agama);
            form_data.append('suku', suku);
            form_data.append('jkel', getJkel());

            $.ajax({
                url: "<?php echo base_url(); ?>/pengguna/prosestab1",
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (response) {
                    alert(response.status);

                    $('#btnSave').html('<i class="mdi mdi-content-save"></i> Simpan ');
                    $('#btnSave').attr('disabled', false);

                }, error: function (response) {
                    alert(response.status);

                    $('#btnSave').html('<i class="mdi mdi-content-save"></i> Simpan ');
                    $('#btnSave').attr('disabled', false);
                }
            });
        }
    }
    
    function getJkel(){
        var jkel = "";
        if(document.getElementById('rb_laki').checked){
            jkel = "L";
        }else if(document.getElementById('rb_perempuan').checked){
            jkel = "P";
        }
        return jkel;
    }
    
    function closemodal(){
        $('#modal_form').modal('hide');
    }
    
    function open_form_foto(){
        $('#form_foto')[0].reset();
        $('#modal_upload_foto').modal('show');
    }
    
    function closemodal_foto(){
        $('#modal_upload_foto').modal('hide');
    }
    
    function save_foto(){
        var idusers = document.getElementById('idusers').value;
        var foto = $('#file_foto').prop('files')[0];

        if (idusers === "") {
            alert("ID users tidak boleh kosong");
        } else {
            $('#btnSaveFoto').text('Saving...'); 
            $('#btnSaveFoto').attr('disabled', true);

            var form_data = new FormData();
            form_data.append('idusers', idusers);
            form_data.append('file', foto);

            $.ajax({
                url: "<?php echo base_url(); ?>/pengguna/prose_upload_foto",
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (response) {
                    alert(response.status);
                    
                    $('#modal_upload_foto').modal('hide');
                    $('#btnSaveFoto').text('Save'); 
                    $('#btnSaveFoto').attr('disabled', false);
                    
                    load_foto();
                }, error: function (response) {
                    alert(response.status);

                    $('#btnSaveFoto').text('Save');
                    $('#btnSaveFoto').attr('disabled', false);
                }
            });
        }
    }
    
    function load_foto(){
        var idusers = document.getElementById('idusers').value;
        $.ajax({
            url: "<?php echo base_url(); ?>/pengguna/load_foto/" + idusers,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('#foto').attr("src", data.foto);
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert('Error load foto');
            }
        });
    }
    
    function pend_umum(){
        save_method = "add";
        document.getElementById('mode_pend').value = "umum";
        $('#judul_pendidikan').html("Tambah Pendidikan Umum");
        $('#form_pendidikan')[0].reset();
        $('#modal_pendidikan').modal('show');
    }
    
    function save_pendidikan(){
        var kode = document.getElementById('kode_pend').value;
        var idusers = document.getElementById('idusers').value;
        var nama = document.getElementById('nm_pend').value;
        var tahun = document.getElementById('tahun_pendidikan').value;
        var ket = document.getElementById('ket_pendidikan').value;
        var file = $('#file_pendidikan').prop('files')[0];
        var mode = document.getElementById('mode_pend').value;

        if (idusers === "") {
            alert("ID users tidak boleh kosong");
        }else if(nama === ""){
            alert("Nama tidak boleh kosong");
        }else if(tahun === ""){
            alert("Tahun tidak boleh kosong");
        } else {
            $('#btnSaveP').text('Saving...'); 
            $('#btnSaveP').attr('disabled', true);

            var form_data = new FormData();
            form_data.append('kode', kode);
            form_data.append('idusers', idusers);
            form_data.append('nama', nama);
            form_data.append('tahun', tahun);
            form_data.append('ket', ket);
            form_data.append('file', file);
            
            var url = "";
            if ( (save_method === "add") && (mode === "umum")) {
                url = "<?php echo base_url(); ?>/pengguna/ajax_add_pend_umum";
            } else if ((save_method === "update") && (mode === "umum")) {
                url = "<?php echo base_url(); ?>/pengguna/ajax_edit_pend_umum";
            } else if ((save_method === "add") && (mode === "militer")) {
                url = "<?php echo base_url(); ?>/pengguna/ajax_add_pend_militer";
            } else if ((save_method === "update") && (mode === "militer")) {
                url = "<?php echo base_url(); ?>/pengguna/ajax_edit_pend_militer";
            }
            
            $.ajax({
                url: url,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (response) {
                    alert(response.status);
                    
                    $('#modal_pendidikan').modal('hide');
                    load_pend_umum();
                    load_pend_militer();
                    
                    $('#btnSaveP').text('Save'); 
                    $('#btnSaveP').attr('disabled', false);
                    
                }, error: function (response) {
                    alert(response.status);

                    $('#btnSaveP').text('Save');
                    $('#btnSaveP').attr('disabled', false);
                }
            });
        }
    }
    
    function closemodal_pendidikan(){
        $('#modal_pendidikan').modal('hide');
    }
    
    function show_pend_umum(id){
        save_method = 'update';
        $('#judul_pendidikan').html("Ganti Pendidikan Umum");
        $('#form_pendidikan')[0].reset();
        $('#modal_pendidikan').modal('show');
        document.getElementById('mode_pend').value = "umum";
        $.ajax({
            url: "<?php echo base_url(); ?>/pengguna/show_pend_umum/" + id,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('[name="kode_pend"]').val(data.idpendidikan);
                $('[name="nm_pend"]').val(data.nm_pendidikan);
                $('[name="tahun_pendidikan"]').val(data.tahun);
                $('[name="ket_pendidikan"]').val(data.keterangan);
                
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data');
            }
        });
    }
    
    function hapus_pend_umum(id, nama){
        if (confirm("Apakah anda yakin menghapus pendidikan umum " + nama + " ?")) {
            $.ajax({
                url: "<?php echo base_url(); ?>/pengguna/hapuspendumum/" + id,
                type: "POST",
                dataType: "JSON",
                success: function (data) {
                    alert(data.status);
                    load_pend_umum();
                }, error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error hapus data');
                }
            });
        }
    }
    
    function showimg(kode, mode){
        $('#modal_show_img').modal('show');
        
        document.getElementById('kode').value = kode;
        document.getElementById('mode').value = mode;
        
        $.ajax({
            url: "<?php echo base_url(); ?>/pengguna/load_detil_img/" + kode + "/" + mode,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('#imgdetil').attr("src", data.foto);
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert('Error load foto');
            }
        });
    }
    
    function pend_militer(){
        save_method = "add";
        document.getElementById('mode_pend').value = "militer";
        $('#judul_pendidikan').html("Tambah Pendidikan Militer");
        $('#form_pendidikan')[0].reset();
        $('#modal_pendidikan').modal('show');
    }
    
    function unduh(){
        var kode = document.getElementById('kode').value;
        var mode = document.getElementById('mode').value;
        window.location.href = "<?php echo base_url(); ?>/pengguna/unduhfile/" + kode + "/" + mode;
    }
    
    function show_pend_militer(id){
        save_method = 'update';
        $('#judul_pendidikan').html("Ganti Pendidikan Militer");
        $('#form_pendidikan')[0].reset();
        $('#modal_pendidikan').modal('show');
        document.getElementById('mode_pend').value = "militer";
        $.ajax({
            url: "<?php echo base_url(); ?>/pengguna/show_pend_militer/" + id,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('[name="kode_pend"]').val(data.idpendidikan);
                $('[name="nm_pend"]').val(data.nm_pendidikan);
                $('[name="tahun_pendidikan"]').val(data.tahun);
                $('[name="ket_pendidikan"]').val(data.keterangan);
                
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data');
            }
        });
    }
    
    function hapus_pend_militer(id, nama){
        if (confirm("Apakah anda yakin menghapus pendidikan militer " + nama + " ?")) {
            $.ajax({
                url: "<?php echo base_url(); ?>/pengguna/hapuspendmiliter/" + id,
                type: "POST",
                dataType: "JSON",
                success: function (data) {
                    alert(data.status);
                    load_pend_militer();
                }, error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error hapus data');
                }
            });
        }
    }
    
    function b_asing(){
        save_method = "add";
        document.getElementById('mode_bahasa').value = "asing";
        $('#judul_bahasa').html("Tambah Bahasa Asing");
        $('#form_bahasa')[0].reset();
        $('#modal_bahasa').modal('show');
    }
    
    function b_daerah(){
        save_method = "add";
        document.getElementById('mode_bahasa').value = "daerah";
        $('#judul_bahasa').html("Tambah Bahasa Daerah");
        $('#form_bahasa')[0].reset();
        $('#modal_bahasa').modal('show');
    }
    
    function closemodal_bahasa(){
        $('#modal_bahasa').modal('hide');
    }
    
    function save_bahasa(){
        var kode = document.getElementById('kode_bahasa').value;
        var idusers = document.getElementById('idusers').value;
        var nama = document.getElementById('nm_bahasa').value;
        var ket = document.getElementById('ket_bahasa').value;
        var file = $('#file_bahasa').prop('files')[0];
        var mode = document.getElementById('mode_bahasa').value;

        if (idusers === "") {
            alert("ID users tidak boleh kosong");
        }else if(nama === ""){
            alert("Nama bahasa tidak boleh kosong");
        } else {
            $('#btnSaveBahasa').text('Saving...'); 
            $('#btnSaveBahasa').attr('disabled', true);

            var form_data = new FormData();
            form_data.append('kode', kode);
            form_data.append('idusers', idusers);
            form_data.append('nama', nama);
            form_data.append('tahun', tahun);
            form_data.append('ket', ket);
            form_data.append('file', file);
            
            var url = "";
            if ( (save_method === "add") && (mode === "umum")) {
                url = "<?php echo base_url(); ?>/pengguna/ajax_add_pend_umum";
            } else if ((save_method === "update") && (mode === "umum")) {
                url = "<?php echo base_url(); ?>/pengguna/ajax_edit_pend_umum";
            } else if ((save_method === "add") && (mode === "militer")) {
                url = "<?php echo base_url(); ?>/pengguna/ajax_add_pend_militer";
            } else if ((save_method === "update") && (mode === "militer")) {
                url = "<?php echo base_url(); ?>/pengguna/ajax_edit_pend_militer";
            }
            
            $.ajax({
                url: url,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (response) {
                    alert(response.status);
                    
                    $('#modal_pendidikan').modal('hide');
                    load_pend_umum();
                    load_pend_militer();
                    
                    $('#btnSaveBahasa').text('Save'); 
                    $('#btnSaveBahasa').attr('disabled', false);
                    
                }, error: function (response) {
                    alert(response.status);

                    $('#btnSaveBahasa').text('Save');
                    $('#btnSaveBahasa').attr('disabled', false);
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
                    <input type="hidden" name="idusers" id="idusers" value="<?php echo $idusers; ?>">
                    <hr>
                    <nav>
                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="head_nav_personil" data-toggle="tab" href="#nav_personil" role="tab" aria-controls="nav_platform" aria-selected="true">Personil</a>
                            <a class="nav-item nav-link" id="head_nav_p_umum" data-toggle="tab" href="#nav_p_umum" role="tab" aria-controls="nav_p_umum" aria-selected="false">Pendidikan Umum</a>
                            <a class="nav-item nav-link" id="head_nav_p_militer" data-toggle="tab" href="#nav_p_militer" role="tab" aria-controls="nav_p_militer" aria-selected="false">Pendidikan Militer</a>
                            <a class="nav-item nav-link" id="head_nav_b_asing" data-toggle="tab" href="#nav_b_asing" role="tab" aria-controls="nav_b_asing" aria-selected="false">Bahasa Asing</a>
                            <a class="nav-item nav-link" id="head_nav_b_daerah" data-toggle="tab" href="#nav_b_daerah" role="tab" aria-controls="nav_b_daerah" aria-selected="false">Bahasa Daerah</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav_personil" role="tabpanel" aria-labelledby="nav_personil">
                            <div class="forms-sample">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group row">
                                            <label for="nrp" class="col-sm-3 col-form-label"><b>NRP</b></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="nrp" name="nrp" value="<?php echo $pers_head->nrp; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row" style="margin-top: -20px;">
                                            <label for="nama" class="col-sm-3 col-form-label"><b>NAMA</b></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $pers_head->nama; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row" style="margin-top: -20px;">
                                            <label for="pangkat" class="col-sm-3 col-form-label"><b>PANGKAT</b></label>
                                            <div class="col-sm-9">
                                                <select id="pangkat" name="pangkat" class="form-control">
                                                    <option value="-">- PILIH PANGKAT -</option>
                                                    <?php
                                                    foreach ($pangkat->getResult() as $row) {
                                                        ?>
                                                    <option <?php if ($row->idpangkat == $pers_head->idpangkat) { echo 'selected'; } ?> value="<?php echo $row->idpangkat; ?>"><?php echo $row->nama_pangkat; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row" style="margin-top: -20px;">
                                            <label for="dinas_pangkat" class="col-sm-7 col-form-label"><b>MASA DINAS DLM PANGKAT</b></label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" id="dinas_pangkat" name="dinas_pangkat" value="<?php echo $dinas_pangkat; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row" style="margin-top: -20px;">
                                            <label for="tmt_tni" class="col-sm-3 col-form-label"><b>TMT TNI</b></label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control" id="tmt_tni" name="tmt_tni" value="<?php echo $tmt_tni; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row" style="margin-top: -20px;">
                                            <label for="dinas_tni" class="col-sm-6 col-form-label"><b>MASA DINAS PRAJURIT</b></label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" id="dinas_tni" name="dinas_tni" value="<?php echo $ms_dinas_prajurit; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row" style="margin-top: -20px;">
                                            <label for="tmp_lahir" class="col-sm-6 col-form-label"><b>TEMPAT LAHIR</b></label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" id="tmp_lahir" name="tmp_lahir" value="<?php echo $tmp_lahir; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row" style="margin-top: -20px;">
                                            <label for="tgl_lahir" class="col-sm-6 col-form-label"><b>TANGGAL LAHIR</b></label>
                                            <div class="col-sm-6">
                                                <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" value="<?php echo $tgl_lahir; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row" style="margin-top: -20px;">
                                            <label for="jabatan" class="col-sm-3 col-form-label"><b>JABATAN</b></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="jabatan" name="jabatan" value="<?php echo $jabatan; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row" style="margin-top: -20px;">
                                            <label for="lama_jab" class="col-sm-3 col-form-label"><b>LAMA JAB</b></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="lama_jab" name="lama_jab" value="<?php echo $lama_jabatan; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row" style="margin-top: -20px;">
                                            <label for="alamat" class="col-sm-3 col-form-label"><b>ALAMAT</b></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $alamat; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label for="korps" class="col-sm-4 col-form-label"><b>KORPS</b></label>
                                            <div class="col-sm-8">
                                                <select id="korps" name="korps" class="form-control">
                                                    <option value="-">- PILIH KORPS -</option>
                                                    <?php
                                                    foreach ($korps->getResult() as $row) {
                                                        ?>
                                                    <option <?php if ($row->idkorps == $pers_head->idkorps) { echo 'selected'; } ?> value="<?php echo $row->idkorps; ?>"><?php echo $row->nama_korps; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row" style="margin-top: -20px;">
                                            <label for="tmt_fiktif" class="col-sm-4 col-form-label"><b>TMT FIKTIF</b></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="tmt_fiktif" name="tmt_fiktif" value="<?php echo $tmt_fiktif; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row" style="margin-top: -20px;">
                                            <label class="col-sm-4 col-form-label"><b>JKEL</b></label>
                                            <div class="col-sm-8">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="jkel" id="rb_laki" value="L" <?php if($jkel == "L"){ echo "checked"; } ?>>
                                                        Laki - laki
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="jkel" id="rb_perempuan" value="P" <?php if($jkel == "P"){ echo "checked"; } ?>>
                                                        Perempuan
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row" style="margin-top: -20px;">
                                            <label for="agama" class="col-sm-4 col-form-label"><b>AGAMA</b></label>
                                            <div class="col-sm-8">
                                                <select id="agama" name="agama" class="form-control">
                                                    <option value="-">- PILIH AGAMA -</option>
                                                    <option <?php if($agama == "Islam"){ echo 'selected'; } ?> value="Islam">Islam</option>
                                                    <option <?php if($agama == "Kristen"){ echo 'selected'; } ?> value="Kristen">Kristen</option>
                                                    <option <?php if($agama == "Katholik"){ echo 'selected'; } ?> value="Katholik">Katholik</option>
                                                    <option <?php if($agama == "Hindu"){ echo 'selected'; } ?> value="Hindu">Hindu</option>
                                                    <option <?php if($agama == "Budha"){ echo 'selected'; } ?> value="Budha">Budha</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row" style="margin-top: -20px;">
                                            <label for="suku" class="col-sm-4 col-form-label"><b>SUKU</b></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="suku" name="suku" value="<?php echo $suku; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <img id="foto" src="<?php echo $foto_personil; ?>" class="img-thumbnail">
                                        <button class="btn btn-primary btn-xs btn-block" style="margin-top: 10px;" onclick="open_form_foto()"> Browse </button>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button id="btnSave" class="btn btn-primary" onclick="save()"><i class="mdi mdi-content-save"></i> Simpan </button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav_p_umum" role="tabpanel" aria-labelledby="nav_p_umum">
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-primary btn-xs" onclick="pend_umum()"> Pendidikan Umum </button>
                                </div>
                                <div class="col-md-12" style="margin-top: 10px;">
                                    <table id="tb_p_umum" class="table table-bordered" style="width: 100%; font-size: 11px;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>NAMA PENDIDIKAN</th>
                                                <th>TAHUN</th>
                                                <th>FILE</th>
                                                <th>KETERANGAN</th>
                                                <th style="text-align: center;">AKSI</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav_p_militer" role="tabpanel" aria-labelledby="nav_p_militer">
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-primary btn-xs" onclick="pend_militer()"> Pendidikan Militer </button>
                                </div>
                                <div class="col-md-12" style="margin-top: 10px;">
                                    <table id="tb_p_militer" class="table table-bordered" style="width: 100%; font-size: 11px;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>NAMA PENDIDIKAN</th>
                                                <th>TAHUN</th>
                                                <th>FILE</th>
                                                <th>KETERANGAN</th>
                                                <th style="text-align: center;">AKSI</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav_b_asing" role="tabpanel" aria-labelledby="nav_b_asing">
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-primary btn-xs" onclick="b_asing()"> Bahasa Asing </button>
                                </div>
                                <div class="col-md-12" style="margin-top: 10px;">
                                    <table id="tb_bahasa_asing" class="table table-bordered" style="width: 100%; font-size: 11px;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>NAMA BAHASA</th>
                                                <th>KETERANGAN</th>
                                                <th>FILE</th>
                                                <th style="text-align: center;">AKSI</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav_b_daerah" role="tabpanel" aria-labelledby="nav_b_daerah">
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-primary btn-xs" onclick="b_daerah()"> Bahasa Daerah </button>
                                </div>
                                <div class="col-md-12" style="margin-top: 10px;">
                                    <table id="tb_bahasa_daerah" class="table table-bordered" style="width: 100%; font-size: 11px;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>NAMA BAHASA</th>
                                                <th>KETERANGAN</th>
                                                <th>FILE</th>
                                                <th style="text-align: center;">AKSI</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_upload_foto" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Upload Foto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closemodal_foto();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_foto" class="form-horizontal">
                    <div class="form-group row">
                        <label for="file_foto" class="col-sm-3 col-form-label">File Foto</label>
                        <div class="col-sm-9">
                            <input id="file_foto" name="file_foto" class="form-control" type="file" autocomplete="off">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnSaveFoto" type="button" class="btn btn-primary btn-xs" onclick="save_foto();">Save</button>
                <button type="button" class="btn btn-secondary btn-xs" onclick="closemodal_foto();">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_pendidikan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="judul_pendidikan">Pendidikan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closemodal_pendidikan();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_pendidikan" class="form-horizontal">
                    <input type="hidden" id="kode_pend" name="kode_pend">
                    <input type="hidden" id="mode_pend" name="mode_pend">
                    
                    <div class="form-group row">
                        <label for="nm_pend" class="col-sm-3 col-form-label">Pendidikan</label>
                        <div class="col-sm-9">
                            <input id="nm_pend" name="nm_pend" class="form-control" type="text" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row" style="margin-top: -12px;">
                        <label for="tahun_pendidikan" class="col-sm-3 col-form-label">Tahun</label>
                        <div class="col-sm-9">
                            <input id="tahun_pendidikan" name="tahun_pendidikan" class="form-control" type="text" autocomplete="off" onkeypress="return hanyaAngka(event,false);">
                        </div>
                    </div>
                    <div class="form-group row" style="margin-top: -12px;">
                        <label for="file_pendidikan" class="col-sm-3 col-form-label">File</label>
                        <div class="col-sm-9">
                            <input id="file_pendidikan" name="file_pendidikan" class="form-control" type="file" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row" style="margin-top: -12px;">
                        <label for="ket_pendidikan" class="col-sm-3 col-form-label">Keterangan</label>
                        <div class="col-sm-9">
                            <input id="ket_pendidikan" name="ket_pendidikan" class="form-control" type="text" autocomplete="off">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnSaveP" type="button" class="btn btn-primary btn-xs" onclick="save_pendidikan();">Save</button>
                <button type="button" class="btn btn-secondary btn-xs" onclick="closemodal_pendidikan();">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_show_img" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Detail Gambar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closemodal_detil_img();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="kode" name="kode">
                <input type="hidden" id="mode" name="mode">
                <img id="imgdetil" src="<?php echo $defimg; ?>" class="img-thumbnail">
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-xs" onclick="unduh()">Download</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_bahasa" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="judul_bahasa">Bahasa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closemodal_bahasa();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_bahasa" class="form-horizontal">
                    <input type="hidden" id="kode_bahasa" name="kode_bahasa">
                    <input type="hidden" id="mode_bahasa" name="mode_bahasa">
                    
                    <div class="form-group row">
                        <label for="nm_bahasa" class="col-sm-3 col-form-label">BAHASA</label>
                        <div class="col-sm-9">
                            <input id="nm_bahasa" name="nm_bahasa" class="form-control" type="text" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row" style="margin-top: -12px;">
                        <label for="file_bahasa" class="col-sm-3 col-form-label">File</label>
                        <div class="col-sm-9">
                            <input id="file_bahasa" name="file_bahasa" class="form-control" type="file" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row" style="margin-top: -12px;">
                        <label for="ket_bahasa" class="col-sm-3 col-form-label">KETERANGAN</label>
                        <div class="col-sm-9">
                            <input id="ket_bahasa" name="ket_bahasa" class="form-control" type="text" autocomplete="off">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnSaveBahasa" type="button" class="btn btn-primary btn-xs" onclick="save_bahasa();">Save</button>
                <button type="button" class="btn btn-secondary btn-xs" onclick="closemodal_bahasa();">Close</button>
            </div>
        </div>
    </div>
</div>