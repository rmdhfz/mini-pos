<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="main-body">
    <div class="page-wrapper">
        <div class="page-body">
            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Data Monitoring</h5>
                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="table-monitoring" class="table nowrap" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama</th>
                                            <th>Sistem Operasi</th>
                                            <th>Browser</th>
                                            <th>Alamat IP</th>
                                            <th>Waktu</th>
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama</th>
                                            <th>Sistem Operasi</th>
                                            <th>Browser</th>
                                            <th>Alamat IP</th>
                                            <th>Waktu</th>
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
<script type="text/javascript">
    $(document).ready(function() {
        let table;
        table = $("#table-monitoring").DataTable({
            serverside: true,
            ajax: {
                type: "post",
                url: "<?php echo site_url('monitoring/list'); ?>",
            },
            language: {
                zeroRecords: "<center> No Data Avalibale </center>",
            },
            responsive: "true",
        });
        $("#table-monitoring").on('click', '#kick', function(event) {
            event.preventDefault();
            if (confirm("Are you sure ?")) {
                const ip = $(this).data('id');
                if (ip) {
                    $.post('monitoring/kick', {ip_address: ip}).done((res,xhr,status) => {
                        if (res.status) {
                            notif("info", "success", res.msg);
                        }
                    }).fail((xhr, res, err) => {

                    })
                }
            }
        });
    });
</script>