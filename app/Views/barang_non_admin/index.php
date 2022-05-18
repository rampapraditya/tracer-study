<script type="text/javascript">

    var save_method; //for save method string
    var tb_platform, tb_sewaco, tb_komaliwan, tb_br_umum;

    $(document).ready(function () {
        tb_platform = $('#tb_platform').DataTable({
            ajax: "<?php echo base_url(); ?>/barangnoadmin/ajaxlistplatform",
            ordering: false
        });
        
        tb_sewaco = $('#tb_sewaco').DataTable({
            ajax: "<?php echo base_url(); ?>/barangnoadmin/ajaxlist_sewaco",
            ordering: false
        });
        
        tb_komaliwan = $('#tb_komaliwan').DataTable({
            ajax: "<?php echo base_url(); ?>/barangnoadmin/ajaxlist_komaliwan",
            ordering: false
        });
        
        tb_br_umum = $('#tb_br_umum').DataTable({
            ajax: "<?php echo base_url(); ?>/barangnoadmin/ajaxlist_br_umum",
            ordering: false
        });
    });

    function reload() {
        tb_platform.ajax.reload(null, false);
        tb_sewaco.ajax.reload(null, false);
        tb_komaliwan.ajax.reload(null, false);
        tb_br_umum.ajax.reload(null, false);
    }

    function add() {
        save_method = 'add';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Tambah barang');
    }

    function save() {
        var kode = document.getElementById('kode').value;
        var gudang = document.getElementById('gudang').value;
        var gambar = $('#gambar').prop('files')[0];
        var deskripsi = document.getElementById('deskripsi').value;
        var pn_nsn = document.getElementById('pn_nsn').value;
        var ds_number = document.getElementById('ds_number').value;
        var holding = document.getElementById('holding').value;
        var equipment = document.getElementById('equipment').value;
        var store = document.getElementById('store').value;
        var supplementary = document.getElementById('supplementary').value;
        var quant = document.getElementById('quant').value;
        var uoi = document.getElementById('uoi').value;
        var verwendung = document.getElementById('verwendung').value;
        
        if (gudang === "-") {
            alert("Gudang tidak boleh kosong");
        } else if (deskripsi === "") {
            alert("Deskripsi tidak boleh kosong");
        } else if (pn_nsn === "") {
            alert("PN/NSN tidak boleh kosong");
        } else {
            $('#btnSave').text('Saving...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 

            var url = "";
            if (save_method === 'add') {
                url = "<?php echo base_url(); ?>/barangnoadmin/ajax_add";
            } else {
                url = "<?php echo base_url(); ?>/barangnoadmin/ajax_edit";
            }

            var form_data = new FormData();
            form_data.append('kode', kode);
            form_data.append('gudang', gudang);
            form_data.append('file', gambar);
            form_data.append('deskripsi', deskripsi);
            form_data.append('pn_nsn', pn_nsn);
            form_data.append('ds_number', ds_number);
            form_data.append('holding', holding);
            form_data.append('equipment', equipment);
            form_data.append('store', store);
            form_data.append('supplementary', supplementary);
            form_data.append('quant', quant);
            form_data.append('uoi', uoi);
            form_data.append('verwendung', verwendung);

            // ajax adding data to database
            $.ajax({
                url: url,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (data) {
                    alert(data.status);
                    $('#modal_form').modal('hide');
                    reload();

                    $('#btnSave').text('Save'); //change button text
                    $('#btnSave').attr('disabled', false); //set button enable 
                }, error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error json " + errorThrown);

                    $('#btnSave').text('Save'); //change button text
                    $('#btnSave').attr('disabled', false); //set button enable 
                }
            });
        }
    }

    function hapus(id, nama) {
        if (confirm("Apakah anda yakin menghapus barang " + nama + " ?")) {
            $.ajax({
                url: "<?php echo base_url(); ?>/barangnoadmin/hapus/" + id,
                type: "POST",
                dataType: "JSON",
                success: function (data) {
                    alert(data.status);
                    reload();
                }, error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error hapus data');
                }
            });
        }
    }

    function ganti(id) {
        save_method = 'update';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Ganti barang');
        $.ajax({
            url: "<?php echo base_url(); ?>/barangnoadmin/ganti/" + id,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('[name="kode"]').val(data.idbarang);
                $('[name="deskripsi"]').val(data.deskripsi);
                $('[name="pn_nsn"]').val(data.pn_nsn);
                $('[name="ds_number"]').val(data.ds_number);
                $('[name="holding"]').val(data.holding);
                $('[name="equipment"]').val(data.equipment_desc);
                $('[name="store"]').val(data.store_location);
                $('[name="supplementary"]').val(data.supplementary_location);
                $('[name="quant"]').val(data.qty);
                $('[name="uoi"]').val(data.uoi);
                $('[name="verwendung"]').val(data.verwendung);
                $('[name="gudang"]').val(data.idjenisbarang);

            }, error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data');
            }
        });
    }

    function closemodal() {
        $('#modal_form').modal('hide');
    }

    function uploadfile() {
        $('#form_upload')[0].reset();
        $('#modal_upload').modal('show');
    }

    function closemodal_upload() {
        $('#modal_upload').modal('hide');
    }

    function save_upload() {
        var gudang = document.getElementById('gudang_upload').value;
        var file = $('#file_upload').prop('files')[0];

        if (gudang === "-") {
            alert("Gudang tidak boleh kosong");
        } else {
            $('#btnSaveUpload').text('Saving...');
            $('#btnSaveUpload').attr('disabled', true);

            var form_data = new FormData();
            form_data.append('gudang', gudang);
            form_data.append('file', file);

            // ajax adding data to database
            $.ajax({
                url: "<?php echo base_url(); ?>/barangnoadmin/prosesfile",
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (data) {
                    alert(data.status);
                    $('#modal_upload').modal('hide');
                    reload();

                    $('#btnSaveUpload').text('Save');
                    $('#btnSaveUpload').attr('disabled', false);
                }, error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error json " + errorThrown);

                    $('#btnSaveUpload').text('Save');
                    $('#btnSaveUpload').attr('disabled', false);
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
                    <h4 class="card-title">MASTER BARANG</h4>
                    <p class="card-description">Maintenance data barang</p>
                    <button type="button" class="btn btn-primary" onclick="add();">Tambah</button>
                    <button type="button" class="btn btn-secondary" onclick="uploadfile();">Upload File</button>
                </div>
                <div class="card-body">
                    <nav>
                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="head_nav_platform" data-toggle="tab" href="#nav_platform" role="tab" aria-controls="nav_platform" aria-selected="true">Platform</a>
                            <a class="nav-item nav-link" id="head_nav_sewaco" data-toggle="tab" href="#nav_sewaco" role="tab" aria-controls="nav_sewaco" aria-selected="false">Sewaco</a>
                            <a class="nav-item nav-link" id="head_nav_komaliwan" data-toggle="tab" href="#nav_komaliwan" role="tab" aria-controls="nav_komaliwan" aria-selected="false">Komaliwan</a>
                            <a class="nav-item nav-link" id="head_nav_nav_barangumum" data-toggle="tab" href="#nav_barangumum" role="tab" aria-controls="nav_barangumum" aria-selected="false">Barang Umum</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav_platform" role="tabpanel" aria-labelledby="nav_platform">
                            <div class="table-responsive">
                                <table id="tb_platform" class="table table-bordered" style="width: 100%; font-size: 11px;">
                                    <thead>
                                        <tr>
                                            <th>GAMBAR</th>
                                            <th>DESCRIPTION</th>
                                            <th>PN/NSN</th>
                                            <th>DS NUMBER</th>
                                            <th>Holding</th>
                                            <th style="text-align: center;">EQUIPMENT<br>DESCRIPTION</th>
                                            <th style="text-align: center;">STORE<br>LOCATION</th>
                                            <th style="text-align: center;">SUPPLEMENTARY<br>LOCATION</th>
                                            <th style="text-align: center;">UOI</th>
                                            <th style="text-align: center;">Verwendung</th>
                                            <th style="text-align: center;">AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav_sewaco" role="tabpanel" aria-labelledby="nav_sewaco">
                            <div class="table-responsive">
                                <table id="tb_sewaco" class="table table-bordered" style="width: 100%; font-size: 11px;">
                                    <thead>
                                        <tr>
                                            <th>GAMBAR</th>
                                            <th>DESCRIPTION</th>
                                            <th>PN/NSN</th>
                                            <th>DS NUMBER</th>
                                            <th>Holding</th>
                                            <th style="text-align: center;">EQUIPMENT<br>DESCRIPTION</th>
                                            <th style="text-align: center;">STORE<br>LOCATION</th>
                                            <th style="text-align: center;">SUPPLEMENTARY<br>LOCATION</th>
                                            <th style="text-align: center;">QUANT</th>
                                            <th style="text-align: center;">UOI</th>
                                            <th style="text-align: center;">Verwendung</th>
                                            <th style="text-align: center;">AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav_komaliwan" role="tabpanel" aria-labelledby="nav_komaliwan">
                            <div class="table-responsive">
                                <table id="tb_komaliwan" class="table table-bordered" style="width: 100%; font-size: 11px;">
                                    <thead>
                                        <tr>
                                            <th>GAMBAR</th>
                                            <th>DESCRIPTION</th>
                                            <th>PN/NSN</th>
                                            <th>DS NUMBER</th>
                                            <th>Holding</th>
                                            <th style="text-align: center;">EQUIPMENT<br>DESCRIPTION</th>
                                            <th style="text-align: center;">STORE<br>LOCATION</th>
                                            <th style="text-align: center;">SUPPLEMENTARY<br>LOCATION</th>
                                            <th style="text-align: center;">QUANT</th>
                                            <th style="text-align: center;">UOI</th>
                                            <th style="text-align: center;">Verwendung</th>
                                            <th style="text-align: center;">AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav_barangumum" role="tabpanel" aria-labelledby="nav_barangumum">
                            <div class="table-responsive">
                                <table id="tb_br_umum" class="table table-bordered" style="width: 100%; font-size: 11px;">
                                    <thead>
                                        <tr>
                                            <th>GAMBAR</th>
                                            <th>DESCRIPTION</th>
                                            <th>PN/NSN</th>
                                            <th>DS NUMBER</th>
                                            <th>Holding</th>
                                            <th style="text-align: center;">EQUIPMENT<br>DESCRIPTION</th>
                                            <th style="text-align: center;">STORE<br>LOCATION</th>
                                            <th style="text-align: center;">SUPPLEMENTARY<br>LOCATION</th>
                                            <th style="text-align: center;">QUANT</th>
                                            <th style="text-align: center;">UOI</th>
                                            <th style="text-align: center;">Verwendung</th>
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

<div class="modal fade" id="modal_form" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closemodal();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form" class="form-horizontal">
                    <input type="hidden" name="kode" id="kode">
                    <div class="form-group">
                        <label>GUDANG</label>
                        <select id="gudang" name="gudang" class="form-control">
                            <option value="-">- PILIH GUDANG -</option>
                            <?php
                            foreach ($gudang->getResult() as $row) {
                                ?>
                                <option value="<?php echo $row->idjenisbarang; ?>"><?php echo $row->nama_jenis; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>GAMBAR</label>
                        <input id="gambar" name="gambar" class="form-control" type="file" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>DESKRIPSI</label>
                        <input id="deskripsi" name="deskripsi" class="form-control" type="text" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>PN/NSN</label>
                        <input id="pn_nsn" name="pn_nsn" class="form-control" type="text" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>DS NUMBER</label>
                        <input id="ds_number" name="ds_number" class="form-control" type="text" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Holding</label>
                        <input id="holding" name="holding" class="form-control" type="text" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>EQUIPMENT DESCRIPTION</label>
                        <input id="equipment" name="equipment" class="form-control" type="text" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>STORE  LOCATION</label>
                        <input id="store" name="store" class="form-control" type="text" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>SUPPLEMENTARY LOCATION</label>
                        <input id="supplementary" name="supplementary" class="form-control" type="text" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>QUANT</label>
                        <input id="quant" name="quant" class="form-control" type="text" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>UOI</label>
                        <input id="uoi" name="uoi" class="form-control" type="text" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Verwendung</label>
                        <input id="verwendung" name="verwendung" class="form-control" type="text" autocomplete="off">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnSave" type="button" class="btn btn-primary" onclick="save();">Save</button>
                <button type="button" class="btn btn-secondary" onclick="closemodal();">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_upload" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Upload File</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closemodal();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_upload" class="form-horizontal">
                    <div class="form-group">
                        <label>GUDANG</label>
                        <select id="gudang_upload" name="gudang_upload" class="form-control">
                            <option value="-">- PILIH GUDANG -</option>
                            <?php
                            foreach ($gudang->getResult() as $row) {
                                ?>
                                <option value="<?php echo $row->idjenisbarang; ?>"><?php echo $row->nama_jenis; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>FILE</label>
                        <input id="file_upload" name="file_upload" class="form-control" type="file" autocomplete="off" accept=".xls, .xlsx">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnSaveUpload" type="button" class="btn btn-primary" onclick="save_upload();">Upload</button>
                <button type="button" class="btn btn-secondary" onclick="closemodal_upload();">Close</button>
            </div>
        </div>
    </div>
</div>