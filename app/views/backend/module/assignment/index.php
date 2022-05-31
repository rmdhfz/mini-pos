<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="main-body">
    <div class="page-wrapper">
        <div class="page-body">
            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Data Assignment</h5>
                            <button type="button" class="btn btn-sm btn-flat btn-danger waves-effect" data-toggle="modal" data-target="#modal-assignment" data-backdrop="static" data-keyboard="false" onclick="ClearFormData($('#form-assignment'));" style="border-radius: 21px;"><i class="fas fa-plus" aria-hidden="true"></i> Add Assignment </button>
                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="table-assignment" class="table nowrap" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Asset</th>
                                            <th>Employee</th>
                                            <th>Date Assign</th>
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No.</th>
                                            <th>Asset</th>
                                            <th>Employee</th>
                                            <th>Date Assign</th>
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
<div class="modal fade modal-flex" id="modal-assignment"  assignment="dialog">
    <div class="modal-dialog" assignment="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #dc3545;">
                <h4 class="modal-title" style="color: white;">Form Assignment</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body model-container">
                <div class="container">
                    <form id="form-assignment" name="form-assignment" accept-charset="utf-8" autocomplete="off" method="post">
                        <input type="hidden" name="id" id="id" />
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label"> Asset </label>
                            <div class="col-sm-5">
                                <select id="asset_id" name="asset_id" class="form-control" required="1">
                                    <option value="" disabled="1" selected="1"> Select Asset</option>
                                </select>
                            </div>
                            <div class="col-sm-5">
                                <select id="employee_id" name="employee_id" class="form-control" required="1">
                                    <option value="" disabled="1" selected="1"> Select Employee</option>
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
        table = $("#table-assignment").DataTable({
            serverside: true,
            ajax: {
                type: "post",
                url: "<?php echo site_url('assignment/list'); ?>",
            },
            language: {
                zeroRecords: "<center> No Data Avalibale </center>",
            },
            responsive: "true",
        });

        getListAsset();
        function getListAsset(){
            $.post('asset/data').done((res,xhr,status) => {
                if (res.status) {
                    const data = res.data;
                    $.each(data, function(index, val) {
                        $("#asset_id").append(`<option value='${val.id}'>${val.name}</option>`);
                    });
                }
            })
        }

        getListEmployee();
        function getListEmployee(){
            $.post('employee/data').done((res,xhr,status) => {
                if (res.status) {
                    const data = res.data;
                    $.each(data, function(index, val) {
                        $("#employee_id").append(`<option value='${val.id}'>${val.name}</option>`);
                    });
                }
            })
        }

        $("#form-assignment").submit(function(event) {
            event.preventDefault();
            let id = $("#id").val(), url;
            if (id) {
                url = "assignment/edit";
            }else{
                url = "assignment/save";
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
        $("#table-assignment").on('click', '#edit', function(event) {
            event.preventDefault();
            const id = $(this).data('id');
            if (!id) {
                alert("id is null");
            }
            $.post('assignment/id', {id: id}).done((res,xhr,status) => {
                if (res.status) {
                    $("#id").val(res.data.id);
                    $("#asset_id").val(res.data.asset_id);
                    $("#employee_id").val(res.data.employee_id);
                    $("#modal-assignment").modal('show');
                }
            })
        });
        $("#table-assignment").on('click', '#delete', function(event) {
            event.preventDefault();
            const id = $(this).data('id');
            if (!id) {
                alert("id is null");
            }
            if (confirm("Are you sure want to delete this data ?")) {
                $.post('assignment/delete', {id: id}).done((res,xhr,status) => {
                    if (res.status) {
                        ReloadTable(table);
                        alert("Success Deleted Data");
                    }
                })
            }
        });
    });
</script>