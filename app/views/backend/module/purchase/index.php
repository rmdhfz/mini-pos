<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- ckeditor -->
<script src="https://cdn.ckeditor.com/ckeditor5/34.1.0/classic/ckeditor.js"></script>
<style type="text/css">
    .ck-editor__editable_inline {
        min-height: 150px;
    }
</style>
<div class="main-body">
    <div class="page-wrapper">
        <div class="page-body">
            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Data Pembelian</h5>
                            <button type="button" class="btn btn-sm btn-flat btn-success waves-effect" data-toggle="modal" data-target="#modal-purchase" data-backdrop="static" data-keyboard="false" onclick="ClearFormData($('#form-purchase'));" style="border-radius: 21px;"><i class="fas fa-plus" aria-hidden="true"></i> Tambah Pembelian </button>
                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="table-purchase" class="table nowrap" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Supplier</th>
                                            <th>Kategori</th>
                                            <th>Produk</th>
                                            <th>Jumlah</th>
                                            <th>Total</th>
                                            <th>Note</th>
                                            <th>Tanggal</th>
                                            <th>Oleh</th>
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No.</th>
                                            <th>Supplier</th>
                                            <th>Kategori</th>
                                            <th>Produk</th>
                                            <th>Jumlah</th>
                                            <th>Total</th>
                                            <th>Note</th>
                                            <th>Tanggal</th>
                                            <th>Oleh</th>
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
<div class="modal fade modal-flex" id="modal-purchase"  purchase="dialog">
    <div class="modal-dialog modal-lg" purchase="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #2ed8b6;">
                <h4 class="modal-title" style="color: white;">Form Pembelian</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body model-container">
                <div class="container">
                    <form id="form-purchase" name="form-purchase" accept-charset="utf-8" autocomplete="off" method="post">
                        <input type="hidden" name="id" id="id" />
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label"> Supplier </label>
                            <div class="col-sm-10">
                                <select id="supplier_id" name="supplier_id" class="form-control" required="1" style="width: 100%;">
                                    <option value="" disabled="1" selected="1">Pilih Supplier</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label"> Kategori </label>
                            <div class="col-sm-5">
                                <select id="category_id" name="category_id" class="form-control" required="1" style="width: 100%;">
                                    <option value="" disabled="1" selected="1">Pilih Kategori</option>
                                </select>
                            </div>
                            <div class="col-sm-5">
                                <select id="product_id" name="product_id" class="form-control" required="1" style="width: 100%;">
                                    <option value="" disabled="1" selected="1">Pilih Produk</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                             <label class="col-sm-2 col-form-label"> Jumlah </label>
                            <div class="col-sm-5">
                                <input type="number" name="qty" id="qty" class="form-control" required="1" min="1" max="999">
                            </div>
                            <div class="col-sm-5">
                                <input type="text" name="total" id="total" class="form-control" required="1" readonly="1">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label"> Deskripsi </label>
                            <div class="col-sm-10">
                                <textarea id="note" name="note"></textarea>
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
        let price, myEditor;
        function initEditor(){
            return ClassicEditor.create(document.querySelector('#note'), {
                placeholder: "Keterangan penjualan (opsional)"
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
        $("#supplier_id, #category_id, #product_id").select2();
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
        async function getSupplier()
        {
            setupselect("#supplier_id", "Supplier");
            await $.post("<?php echo site_url('data/supplier'); ?>").done((res,xhr,status) => {
                if (res.status) {
                    const data = res.data;
                    $.each(data, function(index, val) {
                        $("#supplier_id").append(
                            `<option value='${val.id}'>${val.name}</option>`
                        );
                    });
                }
            }).fail((xhr,res,err) => {
                console.log(err);
            })
        }
        getSupplier();

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

        async function getProduct(id)
        {
            setupselect("#product_id", "Produk");
            await $.post("<?php echo site_url('data/product'); ?>", {category_id: id}).done((res,xhr,status) => {
                if (res.status) {
                    const data = res.data;
                    $.each(data, function(index, val) {
                        $("#product_id").append(
                            `<option value='${val.id}' data-price='${val.price}'>${val.name}</option>`
                        );
                    });
                }
            }).fail((xhr,res,err) => {
                console.log(err);
            })
        }

        $("#category_id").on('change', function(event) {
            event.preventDefault();
            if ($(this).val()) {
                getProduct($(this).val());
            }
        });

        $("#product_id").on('change', function(event) {
            event.preventDefault();
            if ($(this).val()) {
                price = $("#product_id :selected").data('price');
            }
        });

        $("#qty").on('keyup', function(event) {
            event.preventDefault();
            if ($(this).val() > 0) {
                let total = price * $(this).val(),
                    rupiah = formatIDR(total.toString(), "Rp. ");
                $("#total").val(rupiah);
                console.log(`Total is ${rupiah}`)
            }
            console.log(`Value qty is ${$(this).val()}`)
        });

        let table;
        table = $("#table-purchase").DataTable({
            serverside: true,
            ajax: {
                type: "post",
                url: "<?php echo site_url('list/purchase'); ?>",
            },
            language: {
                zeroRecords: "<center> No Data Avalibale </center>",
            },
            responsive: "true",
        });
        $("#form-purchase").submit(function(event) {
            event.preventDefault();
            let id = $("#id").val(), url;
            id === "" ? url = "purchase/add" : url = "purchase/update";
            if (confirm("Apakah Anda yakin data yang diinput sudah benar ?")) {
                $.post(url, $(this).serialize()).done((res, xhr, status) => {
                    ReloadTable(table);
                    ClearFormData($(this));
                    notif("info", "success", res.msg);
                    myEditor.setData('');
                });
            }
        });
        $("#table-purchase").on('click', '#edit', function(event) {
            event.preventDefault();
            const id = $(this).data('id');
            if (!id) {
                alert("id is null");
            }
            $.post('purchase/id', {id: id}).done((res,xhr,status) => {
                if (res.status) {
                    price = res.data.price.replace(/\D/g,'');
                    let note = (res.data.note) == null ? " " : res.data.note;
                    myEditor.setData(note);
                    $("#id").val(res.data.id);
                    $("#supplier_id").val(res.data.supplier_id).trigger('change');
                    $("#category_id").val(res.data.category_id).trigger('change');
                    $("#product_id").val(res.data.product_id).trigger('change');
                    $("#qty").val(res.data.qty);
                    $("#total").val(res.data.total);
                    $("#modal-purchase").modal('show');
                }
            })
        });
        $("#table-purchase").on('click', '#delete', function(event) {
            event.preventDefault();
            const id = $(this).data('id');
            if (!id) {
                alert("id is null");
            }
            if (confirm("Apakah Anda yakin data ini ingin dihapus ?")) {
                $.post('purchase/delete', {id: id}).done((res,xhr,status) => {
                    if (res.status) {
                        ReloadTable(table);
                        notif("info", "info", res.msg);
                    }
                })
            }
        });
    });
</script>