$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {
    
    const warehouseTable = $('#warehouseTable').DataTable();
    $('#warehouseCreate').on('click', function () {
        $('#createWarehouseModal').modal('toggle');
    })

    
    $('#warehouseForm').validate({
        rules: {
            warehouse_name: {
                required: true,
                minlength: 3
            },
            warehouse_address: {
                required: true
            }
        },
        messages: {
            warehouse_name: {
                required: "Please enter the warehouse name",
                minlength: jQuery.validator.format("At least {0} characters required for the warehouse name")
            },
            warehouse_address: {
                required: "Please enter the warehouse address"
            }
        },
        submitHandler: function (form) {
            $("#response").empty();
            const formData = $(form).serializeArray();
            $.ajax({
                type: "POST",
                url: "/warehouses",
                data: formData,
                dataType: "json",
                success: function (response) {
                    $(form).trigger('reset');
                    $('#createWarehouseModal').modal('toggle');
                    if (response.status === 'success') {
                        toastr.success(response.message);
                        const newRowData = [
                            response.warehouse.id,
                            response.warehouse.user_id,
                            response.warehouse.warehouse_name,
                            response.warehouse.warehouse_address,
                            '<a href="javascript:void(0)" class="btn btn-success editWarehouse" data-id="' + response.warehouse.id + '"><i class="fas fa-pen-to-square"></i></a>' +
                            '<a href="javascript:void(0)" class="btn btn-danger deleteWarehouse" data-id="' + response.warehouse.id + '"><i class="fas fa-trash-can"></i></a>'

                        ];
                        $('#warehouseTable').DataTable().row.add(newRowData).draw(false);
                        location.reload();

                    } else if (response.status === 'failed') {
                        toastr.error(response.message);
                    }
                },
                error: function (xhr, status, error) {
                    toastr.error('An error occurred while processing your request.');
                    console.error('Error:', xhr.responseText);
                }
            });
        }
    });

    $("#warehouseTable").on("click", ".editWarehouse", function () {
        var warehouseId = $(this).data("id");
        $.ajax({
            type: "GET",
            url: `/warehouses/${warehouseId}/edit`,
            dataType: "json",
            success: function (response) {
                if (response.status === 'success') {
                    $("#editWarehouseModal #warehouseId").val(response.warehouse.id);
                    $("#editWarehouseModal #warehouse_name").val(response.warehouse.warehouse_name);
                    $("#editWarehouseModal #warehouse_address").val(response.warehouse.warehouse_address);
                    $("#editWarehouseModal").modal('toggle');
                } else if (response.status === 'failed') {
                    toastr.error(response.message);
                }
            },
            error: function (xhr, status, error) {
                toastr.error('An error occurred while fetching category details.');
            }
        });
    });
    
    $("#editWarehouseForm").validate({
        rules: {
            warehouse_name: {
                required: true,
                minlength: 3
            },
            warehouse_address: {
                required: true
            }
        },
        messages: {
            warehouse_name: {
                required: "Please enter the warehouse name",
                minlength: jQuery.validator.format("At least {0} characters required for the warehouse name")
            },
            warehouse_address: {
                required: "Please enter the warehouse address"
            }
        },
        submitHandler: function (form) {
            $("#response").empty();
            const formData = $(form).serializeArray();
            const warehouseId = $("#warehouseId").val();

            $.ajax({
                type: "PUT",
                url: `/warehouses/${warehouseId}`,
                data: formData,
                dataType: "json",
                success: function (response) {
                    $("#editWarehouseModal").modal("toggle");
                    if (response.status === 'success') {
                        toastr.success(response.message);

                        const rowIndex = warehouseTable.row($(`#warehouse_${warehouseId}`)).index();
                        const rowData = [
                            response.warehouse.id,
                            response.warehouse.user_id,
                            response.warehouse.warehouse_name,
                            response.warehouse.warehouse_address,
                            '<a href="javascript:void(0)" class="btn btn-success editWarehouse" data-id="' + response.warehouse.id + '"><i class="fas fa-pen-to-square"></i></a>' +
                            '<a href="javascript:void(0)" class="btn btn-danger deleteWarehouse" data-id="' + response.warehouse.id + '"><i class="fas fa-trash-can"></i></a>'
                        ];
                        warehouseTable.row(rowIndex).data(rowData).draw(false);
                        location.reload();
                    } else if (response.status === 'failed') {
                        toastr.error(response.message);
                    }
                },
                error: function (error) {
                    toastr.error(`An error occurred: ${error.statusText}`);
                }
            });
        }

    });

    $("#warehouseTable").on("click", ".deleteWarehouse", function () {
        var warehouseId = $(this).data("id");
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: `/warehouses/${warehouseId}`,
                    dataType: "json",
                    success: function (response) {
                        if (response.status === 'success') {
                            warehouseTable.row($(`#warehouse_${warehouseId}`).closest('tr')).remove().draw(false);
                            toastr.success(response.message);
                        } else if (response.status === 'failed') {
                            toastr.error(response.message);
                        }
                    },
                    error: function (response) {
                        toastr.error(response.message);
                    }
                });
            }
        });
    });

   
        
    
    

});