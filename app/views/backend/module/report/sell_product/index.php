<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="main-body">
    <div class="page-wrapper">
        <div class="page-body">
            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Laporan Penjualan Perproduk</h5> <br><br><br>
                            <form id="search" method="post" aria-hidden="true">
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <select id="category_id" name="category_id" required="1" class="form-control" style="width: 100%;"></select>
                                    </div>
                                    <div class="col-sm-2">
                                        <select id="product_id" name="product_id" required="1" class="form-control" style="width: 100%;"></select>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="date" name="from" id="from" class="form-control" required="1" value="<?php echo date('Y-m-d') ?>" max="<?php echo date('Y-m-d') ?>">
                                    </div>
                                    to
                                    <div class="col-sm-3">
                                        <input type="date" name="to" id="to" class="form-control" required="1" max="<?php echo date('Y-m-d') ?>">
                                    </div>
                                    <button type="submit" class="btn btn-flat btn-sm btn-primary"> Cari </button>
                                </div>
                            </form>
                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <center>
                                    <h2>Laporan Penjualan Perproduk</h2>
                                    <small>Source: minipos.majoo.id</small>
                                    <div class="container">
                                        <hr>
                                    </div> 
                                </center> <br>  <br>
                                <table id="table-sell" class="table nowrap" style="width: 100%;" hidden="1">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Pelanggan</th>
                                            <th>Kategori</th>
                                            <th>Produk</th>
                                            <th>Jumlah</th>
                                            <th>Total</th>
                                            <th>Note</th>
                                            <th>Tanggal</th>
                                            <th>Oleh</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No.</th>
                                            <th>Pelanggan</th>
                                            <th>Kategori</th>
                                            <th>Produk</th>
                                            <th>Jumlah</th>
                                            <th>Total</th>
                                            <th>Note</th>
                                            <th>Tanggal</th>
                                            <th>Oleh</th>
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
<!-- import script -->
<script src="static/assets/js/dataTables.buttons.min.js"></script>
<script src="static/assets/js/jszip.min.js"></script>
<script src="static/assets/js/pdfmake.min.js"></script>
<script src="static/assets/js/vfs_fonts.js"></script>
<script src="static/assets/js/buttons.html5.min.js"></script>
<script src="static/assets/js/buttons.print.min.js"></script>
<!-- import script -->
<script type="text/javascript">
    $(document).ready(function() {
        $("#category_id, #product_id").select2();
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
        let table;
        function searchReport(from, to, product_id)
        {
            table = $("#table-sell").DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excelHtml5', 'pdf', 'print'
                ],
                destroy: true,
                ajax: {
                    type: "post",
                    url: "<?php echo site_url('report/penjualan/produk'); ?>",
                    data: { from: from, to: to, product_id: product_id },
                },
                language: {
                    zeroRecords: "<center> No Data Avalibale </center>",
                },
                responsive: true,
            });
            $("#table-sell").prop('hidden', false);
        }
        $("#search").submit(function(event) {
            event.preventDefault();
            let start, end, product_id;
            start = $("#from").val();
            end = $("#to").val();
            product_id = $("#product_id").val();
            searchReport(start, end, product_id);
        });
    });
</script>