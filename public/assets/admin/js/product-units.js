$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {

    const unitTable = $('#unitTable').DataTable();
    $('#productUnitCreate').on('click', function () {
        $('#createUnitModal').modal('toggle');
    })


    $('#unitForm').validate({
        rules: {
            unit_name: {
                required: true,
                minlength: 3
            }
        },
        messages: {
            unit_name: {
                required: "Please enter the Unit name",
                minlength: jQuery.validator.format("At least {0} characters required for the warehouse name")
            }
        },
        submitHandler: function (form) {
            $("#response").empty();
            const formData = $(form).serializeArray();
            $.ajax({
                type: "POST",
                url: "/product-units",
                data: formData,
                dataType: "json",
                success: function (response) {
                    $(form).trigger('reset');
                    $('#createUnitModal').modal('toggle');
                    if (response.status === 'success') {
                        toastr.success(response.message);
                        const newRowData = [
                            response.unit.id,
                            response.unit.unit_name,
                            '<a href="javascript:void(0)" class="btn btn-success editunit" data-id="' + response.unit.id + '"><i class="fas fa-pen-to-square"></i></a>' +
                            '<a href="javascript:void(0)" class="btn btn-danger deleteunit" data-id="' + response.unit.id + '"><i class="fas fa-trash-can"></i></a>'

                        ];
                        $('#unitTable').DataTable().row.add(newRowData).draw(false);
                        

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

    $("#unitTable").on("click", ".editunit", function () {
        var unitId = $(this).data("id");
        $.ajax({
            type: "GET",
            url: `/product-units/${unitId}/edit`,
            dataType: "json",
            success: function (response) {
                if (response.status === 'success') {
                    $("#editUnitModal #unitId").val(response.unit.id);
                    $("#editUnitModal #unit_name").val(response.unit.unit_name);
                    $("#editUnitModal").modal('toggle');
                } else if (response.status === 'failed') {
                    toastr.error(response.message);
                }
            },
            error: function (xhr, status, error) {
                toastr.error('An error occurred while fetching category details.');
            }
        });
    });

    $("#editUnitForm").validate({
        rules: {
            unit_name: {
                required: true,
                minlength: 3
            }
        },
        messages: {
            unit_name: {
                required: "Please enter the Unit name",
                minlength: jQuery.validator.format("At least {0} characters required for the warehouse name")
            }
        },
        submitHandler: function (form) {
            $("#response").empty();
            const formData = $(form).serializeArray();
            const unitId = $("#unitId").val();

            $.ajax({
                type: "PUT",
                url: `/product-units/${unitId}`,
                data: formData,
                dataType: "json",
                success: function (response) {
                    $("#editUnitModal").modal("toggle");
                    if (response.status === 'success') {
                        toastr.success(response.message);

                        const rowIndex = unitTable.row($(`#unit_${unitId}`)).index();
                        const rowData = [
                            response.unit.id,
                            response.unit.unit_name,
                            '<a href="javascript:void(0)" class="btn btn-success editunit" data-id="' + response.unit.id + '"><i class="fas fa-pen-to-square"></i></a>' +
                            '<a href="javascript:void(0)" class="btn btn-danger deleteunit" data-id="' + response.unit.id + '"><i class="fas fa-trash-can"></i></a>'
                        ];
                        unitTable.row(rowIndex).data(rowData).draw(false);
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

    $("#unitTable").on("click", ".deleteunit", function () {
        var unitId = $(this).data("id");
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
                    url: `/product-units/${unitId}`,
                    dataType: "json",
                    success: function (response) {
                        if (response.status === 'success') {
                            unitTable.row($(`#unit_${unitId}`).closest('tr')).remove().draw(false);
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