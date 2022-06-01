<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="main-body">
    <div class="page-wrapper">
        <div class="page-body">
            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Data User</h5>
                            <button type="button" class="btn btn-sm btn-flat btn-danger waves-effect" data-toggle="modal" data-target="#modal-user" data-backdrop="static" data-keyboard="false" onclick="ClearFormData($('#form-user'));" style="border-radius: 21px;"><i class="fas fa-plus" aria-hidden="true"></i> Tambah User </button>
                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="table-user" class="table nowrap" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Username</th>
                                            <th>Status</th>
                                            <th>Tanggal Dibuat</th>
                                            <th>Dibuat Oleh</th>
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Username</th>
                                            <th>Status</th>
                                            <th>Tanggal Dibuat</th>
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
<div class="modal fade modal-flex" id="modal-user"  user="dialog">
    <div class="modal-dialog" user="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #dc3545;">
                <h4 class="modal-title" style="color: white;">Form User</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body model-container">
                <div class="container">
                    <form id="form-user" name="form-user" accept-charset="utf-8" autocomplete="off" method="post">
                        <input type="hidden" name="id" id="id" />
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label"> Nama </label>
                            <div class="col-sm-10">
                                <input type="text"name="name"id="name"class="form-control"required="1"placeholder="nama user"pattern="[a-zA-Z0-9\s]{4,35}"minlength="4"maxlength="35"data-toggle="tooltip"data-placement="top"title="nama user"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label"> Email </label>
                            <div class="col-sm-10">
                                <input type="email"name="email"id="email"class="form-control"required="1"placeholder="example@domain.com"minlength="4"maxlength="35"data-toggle="tooltip"data-placement="top"title="email user"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label"> Username </label>
                            <div class="col-sm-5">
                                <input type="text"name="username"id="username"class="form-control"required="1"placeholder="username"minlength="4"maxlength="35"data-toggle="tooltip"data-placement="top"title="username user"/>
                            </div>
                            <div class="col-sm-5">
                                <input type="password"name="password"id="password"class="form-control"required="1"placeholder="password"minlength="4"maxlength="35"data-toggle="tooltip"data-placement="top"title="password user"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label"> Status </label>
                            <div class="col-sm-10">
                                <select id="status" name="status" required="1" class="form-control">
                                    <option value="" selected="1" disabled="1">Pilih Status</option>
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
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
        let table;
        table = $("#table-user").DataTable({
            serverside: true,
            ajax: {
                type: "post",
                url: "<?php echo site_url('list/user'); ?>",
            },
            language: {
                zeroRecords: "<center> No Data Avalibale </center>",
            },
            responsive: "true",
        });
        $("#form-user").submit(function(event) {
            event.preventDefault();
            let id = $("#id").val(), url;
            id === "" ? url = "user/add" : url = "user/update";
            if (confirm("Is the input data correct ?")) {
                $.post(url, $(this).serialize()).done((res, xhr, status) => {
                    ReloadTable(table);
                    ClearFormData($(this));
                    alert(res.msg);
                });
            }
        });
        $("#table-user").on('click', '#edit', function(event) {
            event.preventDefault();
            const id = $(this).data('id');
            if (!id) {
                alert("id is null");
            }
            $.post('user/id', {id: id}).done((res,xhr,status) => {
                if (res.status) {
                    $("#id").val(res.data.id);
                    $("#name").val(res.data.name);
                    $("#email").val(res.data.email);
                    $("#username").val(res.data.username);
                    $("#status").val(res.data.is_active);
                    $("#modal-user").modal('show');
                }
            })
        });
        $("#table-user").on('click', '#delete', function(event) {
            event.preventDefault();
            const id = $(this).data('id');
            if (!id) {
                alert("id is null");
            }
            if (confirm("Are you sure want to delete this data ?")) {
                $.post('user/delete', {id: id}).done((res,xhr,status) => {
                    if (res.status) {
                        ReloadTable(table);
                        alert("Success Deleted Data");
                    }
                })
            }
        });
    });
</script>