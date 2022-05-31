<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="main-body">
    <div class="page-wrapper">
        <div class="page-body">
            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Data Employee</h5>
                            <button type="button" class="btn btn-sm btn-flat btn-danger waves-effect" data-toggle="modal" data-target="#modal-employee" data-backdrop="static" data-keyboard="false" onclick="ClearFormData($('#form-employee'));" style="border-radius: 21px;"><i class="fas fa-plus" aria-hidden="true"></i> Add Employee </button>
                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="table-employee" class="table nowrap" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No.</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
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
<div class="modal fade modal-flex" id="modal-employee"  role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #dc3545;">
                <h4 class="modal-title" style="color: white;">Form Employee</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body model-container">
                <div class="container">
                    <form id="form-employee" name="form-employee" accept-charset="utf-8" autocomplete="off" method="post">
                        <input type="hidden" name="id" id="id" />
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label"> Name </label>
                            <div class="col-sm-5">
                                <input type="text"name="name"id="name"class="form-control"required="1"placeholder="employee name"pattern="[a-zA-Z0-9\s]{4,35}"minlength="4"maxlength="35"data-toggle="tooltip"data-placement="top"title="employee name"/>
                            </div>
                            <div class="col-sm-5">
                                <input type="number"name="phone"id="phone"class="form-control"required="1"placeholder="phone employee"minlength="10"maxlength="12"data-toggle="tooltip"data-placement="top"title="employee phone"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label"> Email </label>
                            <div class="col-sm-10 col-xs-5">
                                <input type="email"name="email"id="email"class="form-control"required="1"placeholder="email employee"minlength="5"maxlength="35"data-toggle="tooltip"data-placement="top"title="email employee"/>
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
        table = $("#table-employee").DataTable({
            serverside: true,
            ajax: {
                type: "post",
                url: "<?php echo site_url('employee/list'); ?>",
            },
            language: {
                zeroRecords: "<center> No Data Avalibale </center>",
            },
            responsive: "true",
        });
        $("#form-employee").submit(function(event) {
            event.preventDefault();
            let id = $("#id").val(), url;
            if (id) {
                url = "employee/edit";
            }else{
                url = "employee/save";
            }
            if (confirm("Is the input data correct ?")) {
                $.post(url, $(this).serialize()).done((res, xhr, status) => {
                    ReloadTable(table);
                    ClearFormData($(this));
                    if (res.status && res.code == 200) {
                        alert("Data Already Exist");
                    }else{
                        alert(res.msg);
                    }
                });
            }
        });
        $("#table-employee").on('click', '#edit', function(event) {
            event.preventDefault();
            const id = $(this).data('id');
            if (!id) {
                alert("id is null");
            }
            $.post('employee/id', {id: id}).done((res,xhr,status) => {
                if (res.status) {
                    $("#id").val(res.data.id);
                    $("#name").val(res.data.name);
                    $("#email").val(res.data.email);
                    $("#phone").val(res.data.phone);
                    $("#modal-employee").modal('show');
                }
            })
        });
        $("#table-employee").on('click', '#delete', function(event) {
            event.preventDefault();
            const id = $(this).data('id');
            if (!id) {
                alert("id is null");
            }
            if (confirm("Are you sure want to delete this data ?")) {
                $.post('employee/delete', {id: id}).done((res,xhr,status) => {
                    if (res.status) {
                        ReloadTable(table);
                        alert("Success Deleted Data");
                    }
                })
            }
        });
    });
</script>