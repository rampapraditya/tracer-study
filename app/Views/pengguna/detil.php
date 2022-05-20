<script type="text/javascript">

    $(document).ready(function () {

    });

    function save() {
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

        if (ins === "") {
            alert("Instansi tidak boleh kosong");
        } else if (alamat === "") {
            alert("Alamat tidak boleh kosong");
        } else if (tlp === "") {
            alert("Telepon tidak boleh kosong");
        } else {
            $('#btnSave').html('<i class="mdi mdi-content-save"></i> Proses... ');
            $('#btnSave').attr('disabled', true);

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
                    $('#btnSave').attr('disabled', false);

                }, error: function (response) {
                    alert(response.status);

                    $('#btnSave').html('<i class="mdi mdi-content-save"></i> Simpan ');
                    $('#btnSave').attr('disabled', false);
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
                    <hr>

                    <nav>
                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="head_nav_personil" data-toggle="tab" href="#nav_personil" role="tab" aria-controls="nav_platform" aria-selected="true">Personil</a>
                            <a class="nav-item nav-link" id="head_nav_p_umum" data-toggle="tab" href="#nav_p_umum" role="tab" aria-controls="nav_p_umum" aria-selected="false">Pendidikan Umum</a>
                            <a class="nav-item nav-link" id="head_nav_p_militer" data-toggle="tab" href="#nav_p_militer" role="tab" aria-controls="nav_p_militer" aria-selected="false">Pendidikan Militer</a>
                            <a class="nav-item nav-link" id="head_nav_b_asing" data-toggle="tab" href="#nav_b_asing" role="tab" aria-controls="nav_b_asing" aria-selected="false">Bahasa Asing</a>
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
                                                    <option <?php if($row->idpangkat == $pers_head->idpangkat){ echo 'selected'; } ?> value="<?php echo $row->idpangkat; ?>"><?php echo $row->nama_pangkat; ?></option>
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
                                                <input type="text" class="form-control" id="tmt_tni" name="tmt_tni" value="<?php echo $tmt_tni; ?>">
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
                                                <input type="text" class="form-control" id="jabatan" name="jabatan" value="<?php echo $suku; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row" style="margin-top: -20px;">
                                            <label for="lama_jab" class="col-sm-3 col-form-label"><b>LAMA JAB</b></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="lama_jab" name="lama_jab">
                                            </div>
                                        </div>
                                        <div class="form-group row" style="margin-top: -20px;">
                                            <label for="ALAMAT" class="col-sm-3 col-form-label"><b>ALAMAT</b></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="alamat" name="alamat">
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
                                                    <option <?php if($row->idkorps == $pers_head->idkorps){ echo 'selected'; } ?> value="<?php echo $row->idkorps; ?>"><?php echo $row->nama_korps; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row" style="margin-top: -20px;">
                                            <label for="tmt_fiktif" class="col-sm-4 col-form-label"><b>TMT FIKTIF</b></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="tmt_fiktif" name="tmt_fiktif">
                                            </div>
                                        </div>
                                        <div class="form-group row" style="margin-top: -20px;">
                                            <label for="jkel" class="col-sm-4 col-form-label"><b>JKEL</b></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="jkel" name="jkel">
                                            </div>
                                        </div>
                                        <div class="form-group row" style="margin-top: -20px;">
                                            <label for="agama" class="col-sm-4 col-form-label"><b>AGAMA</b></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="agama" name="agama">
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
                                        <img src="<?php echo $foto_personil; ?>" class="img-thumbnail">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button id="btnSave" class="btn btn-primary" onclick="save()"><i class="mdi mdi-content-save"></i> Simpan </button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav_p_umum" role="tabpanel" aria-labelledby="nav_p_umum">
                            <table id="tb_p_umum" class="table table-bordered" style="width: 100%; font-size: 11px;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>NAMA PENDIDIKAN</th>
                                        <th>TAHUN</th>
                                        <th>KETERANGAN</th>
                                        <th>FILE</th>
                                        <th style="text-align: center;">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="nav_p_militer" role="tabpanel" aria-labelledby="nav_p_militer">

                        </div>
                        <div class="tab-pane fade" id="nav_b_asing" role="tabpanel" aria-labelledby="nav_b_asing">

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>