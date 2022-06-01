<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- ckeditor -->
<script src="https://cdn.ckeditor.com/ckeditor5/34.1.0/classic/ckeditor.js"></script>
<style type="text/css">
    .ck-editor__editable_inline {
        min-height: 250px;
    }
</style>
<div class="main-body">
    <div class="page-wrapper">
        <div class="page-body">
            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Data Produk</h5>
                            <button type="button" class="btn btn-sm btn-flat btn-success waves-effect" data-toggle="modal" data-target="#modal-product" data-backdrop="static" data-keyboard="false" onclick="ClearFormData($('#form-product'));" style="border-radius: 21px;"><i class="fas fa-plus" aria-hidden="true"></i> Tambah Produk </button>
                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="table-product" class="table nowrap" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama</th>
                                            <th>Kategori</th>
                                            <th>Harga</th>
                                            <th>Margin</th>
                                            <th>Stok</th>
                                            <th>Produk</th>
                                            <th>Dibuat Oleh</th>
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama</th>
                                            <th>Kategori</th>
                                            <th>Harga</th>
                                            <th>Margin</th>
                                            <th>Stok</th>
                                            <th>Produk</th>
                                            <th>Dibuat Oleh</th>
                                            <th>Opsi</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade modal-flex" id="modal-product"  product="dialog">
    <div class="modal-dialog modal-lg" product="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #2ed8b6;">
                <h4 class="modal-title" style="color: white;">Form Produk</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body model-container">
                <div class="container">
                    <form id="form-product" name="form-product" accept-charset="utf-8" autocomplete="off" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id" />
                        <input type="hidden" name="fileold" id="fileold">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label"> Nama </label>
                            <div class="col-sm-5">
                                <input type="text"name="name"id="name"class="form-control"required="1"placeholder="nama produk"pattern="[a-zA-Z0-9\s]{4,20}"minlength="4"maxlength="20"data-toggle="tooltip"data-placement="top"title="nama produk"/>
                            </div>
                            <div class="col-sm-5">
                                <select id="unit" name="unit" class="form-control" required="1" style="width: 100%;">
                                    <option value="" disabled="1" selected="1">Pilih Satuan</option>
                                    <option value="pcs">Pcs</option>
                                    <option value="unit">Unit</option>
                                    <option value="lusin">Lusin</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label"> Kategori </label>
                            <div class="col-sm-10">
                                <select id="category_id" name="category_id" class="form-control" required="1" style="width: 100%;">
                                    <option value="" disabled="1" selected="1">Pilih Kategori</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label"> Harga </label>
                            <div class="col-sm-5">
                                <input type="text" name="buy_price" id="buy_price" class="form-control" required="1" placeholder="harga beli produk">
                            </div>
                            <div class="col-sm-5">
                                <input type="text" name="sell_price" id="sell_price" class="form-control" required="1" placeholder="harga jual produk">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label"> Produk </label>
                            <div class="col-sm-5">
                                <input type="file" name="file" id="file" accept="image/*" required="1" class="form-control">
                            </div>
                            <div class="col-sm-5">
                                <img src="" id="preview" alt="preview" class="img-thumbnail">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label"> Deskripsi </label>
                            <div class="col-sm-10">
                                <textarea id="description" name="description"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label"> Barcode </label>
                            <div class="col-sm-5">
                                <input type="text" name="barcode" id="barcode" class="form-control" required="1" placeholder="barcode produk">
                            </div>
                            <div class="col-sm-5">
                                <input type="number" name="stock" id="stock" class="form-control" required="1" min="1" max="999" placeholder="stok produk">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label"> Status </label>
                            <div class="col-sm-10">
                                <select id="status" name="status" class="form-control" required="1" style="width: 100%;">
                                    <option value="" selected="1" disabled="1">Pilih Status</option>
                                    <option value="1">Publikasi</option>
                                    <option value="0">Tidak Dipublikasi (draft)</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" name="submit" id="_submit" value="1" hidden="1"></button>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="submit-button" onclick="$('#_submit').click();" class="btn btn-sm waves-effect waves-light btn-default btn-outline-default btn-block">Submit</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        
        let myEditor;
        function initEditor(){
            return ClassicEditor.create(document.querySelector('#description'), {
                placeholder: "Masukan deskripsi produk"
            })
            .then(editor => {
                window.editor = editor;
                myEditor = editor;
            })
            .catch(err=> {
                console.error(err);
            });
        }
        initEditor();
        function formatIDR(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, "").toString(),
                split = number_string.split(","),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);
                if (ribuan) {
                    separator = sisa ? "." : "";
                    rupiah += separator + ribuan.join(".");
                }
                rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
                return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
        }
        $("#buy_price, #sell_price").on('keyup', function(event) {
            event.preventDefault();
            $(this).val(formatIDR($(this).val(), "Rp. "));
        });

        $("#category_id, #unit, #status").select2();
        async function getCategory()
        {
            setupselect("#category_id", "Kategori");
            await $.post("<?php echo site_url('data/category'); ?>").done((res,xhr,status) => {
                if (res.status) {
                    const data = res.data;
                    $.each(data, function(index, val) {
                        $("#category_id").append(
                            `<option value='${val.id}'>${val.name}</option>`
                        );
                    });
                }
            }).fail((xhr,res,err) => {
                console.log(err);
            })
        }
        getCategory();

        function previewImg(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#file").on('change', function(event) {
            event.preventDefault();
            previewImg(this);
        });

        let table;
        table = $("#table-product").DataTable({
            serverside: true,
            ajax: {
                type: "post",
                url: "<?php echo site_url('list/product'); ?>",
            },
            language: {
                zeroRecords: "<center> No Data Avalibale </center>",
            },
            responsive: "true",
        });
        async function uploadProduct(url, data)
        {
            await $.ajax({
                url: url,
                data: data,
                type: "post",
                method: "post",
                cache: false,
                contentType: false,
                processData: false,
            }).done((res, status, xhr) => {
                if (res.status) {
                    ReloadTable(table);
                    notif('info', 'success', res.msg);
                    myEditor.setData('');
                }
            }).fail((xhr, status, err) => {
                notif('info', 'info', err);
            })
        }
        $("#form-product").submit(function(event) {
            event.preventDefault();
            let id = $("#id").val(), url;
            id === "" ? url = "product/add" : url = "product/update";
            if (confirm("Apakah Anda yakin data yang diinput sudah benar ?")) {
                uploadProduct(url, new FormData($(this)[0]));
                ClearFormData($(this));
            }
        });
        $("#table-product").on('click', '#edit', function(event) {
            event.preventDefault();
            const id = $(this).data('id');
            if (!id) {
                alert("id is null");
            }
            $.post('product/id', {id: id}).done((res,xhr,status) => {
                if (res.status) {
                    const PATH_PRODUCT = "<?php echo PATH_PRODUCT; ?>",
                          image_product = PATH_PRODUCT + '/' + res.data.img;
                    $("#id").val(res.data.id);
                    $("#name").val(res.data.name);
                    $("#buy_price").val(res.data.buy_price);
                    $("#sell_price").val(res.data.sell_price);
                    $("#barcode").val(res.data.barcode);
                    $("#stock").val(res.data.stock);
                    $("#file").removeAttr('required');
                    $("#fileold").val(res.data.img);
                    $("#preview").attr('src', image_product);
                    $("#unit").val(res.data.unit).trigger('change');
                    $("#category_id").val(res.data.category_id).trigger('change');
                    $("#status").val(res.data.is_publish).trigger('change');
                    $("#modal-product").modal('show');
                    myEditor.setData(res.data.description);
                }
            })
        });
        $("#table-product").on('click', '#delete', function(event) {
            event.preventDefault();
            const id = $(this).data('id');
            if (!id) {
                alert("id is null");
            }
            if (confirm("Apakah Anda yakin data ini ingin dihapus ?")) {
                $.post('product/delete', {id: id}).done((res,xhr,status) => {
                    if (res.status) {
                        ReloadTable(table);
                        notif('info', 'info', res.msg);
                    }
                })
            }
        });
    });
</script>