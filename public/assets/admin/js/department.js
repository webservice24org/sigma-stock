$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {

    const departmentTable = $('#departmentTable').DataTable();
    $('#departmentCreate').on('click', function () {
        $('#createDepartmentModal').modal('toggle');
    })


    $('#departmentForm').validate({
        rules: {
            department_name: {
                required: true,
                minlength: 3
            }
        },
        messages: {
            department_name: {
                required: "Please enter the Department Name",
                minlength: jQuery.validator.format("At least {0} characters required!")
            }
        },
        submitHandler: function (form) {
            $("#response").empty();
            const formData = $(form).serializeArray();
            $.ajax({
                type: "POST",
                url: "/hrm-departments",
                data: formData,
                dataType: "json",
                success: function (response) {
                    $(form).trigger('reset');
                    $('#createDepartmentModal').modal('toggle');
                    if (response.status === 'success') {
                        toastr.success(response.message);
                        const newRowData = [
                            response.department.id,
                            response.department.user_id,
                            response.department.department_name,

                            '<a href="javascript:void(0)" class="btn btn-success editDepartment" data-id="' + response.department.id + '"><i class="fas fa-pen-to-square"></i></a>' +

                            '<a href="javascript:void(0)" class="btn btn-danger deleteDepartment" data-id="' + response.department.id + '"><i class="fas fa-trash-can"></i></a>'

                        ];
                        $('#departmentTable').DataTable().row.add(newRowData).draw(false);


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


    $('#departmentTable').on('click', '.editDepartment', function () {
        var departmentId = $(this).data('id');
        $.ajax({
            type: 'GET',
            url: `/hrm-departments/${departmentId}/edit`,
            dataType: 'json',
            success: function (response) {
                $('#editDepartmentForm #department_name').val(response.department.department_name);
                $('#editDepartmentForm #departmentId').val(response.department.id);
                $('#editDepartmentModal').modal('toggle');
            },
            error: function (xhr, status, error) {
                console.error('Error fetching department details:', error);
            }
        });
    });

    $('#editDepartmentForm').validate({
        rules: {
            department_name: {
                required: true,
                minlength: 3
            }
        },
        messages: {
            department_name: {
                required: "Please enter the Department Name",
                minlength: jQuery.validator.format("At least {0} characters required!")
            }
        },
        submitHandler: function (form) {
            $("#response").empty();
            const departmentId = $("#departmentId").val();
            const formData = $(form).serializeArray();
            $.ajax({
                type: 'PUT',
                url: `/hrm-departments/${departmentId}`,
                data: formData,
                dataType: 'json',
                success: function (response) {
                    $('#editDepartmentModal').modal('toggle');

                    if (response.status === 'success') {
                        toastr.success(response.message);
                        const rowIndex = departmentTable.row($(`#department_${departmentId}`)).index();

                        var newRowData = [
                            response.department.id,
                            response.department.user_id,
                            response.department.department_name,

                            '<a href="javascript:void(0)" class="btn btn-success editDepartment" data-id="' + response.department.id + '"><i class="fas fa-pen-to-square"></i></a>' +

                            '<a href="javascript:void(0)" class="btn btn-danger deleteDepartment" data-id="' + response.department.id + '"><i class="fas fa-trash-can"></i></a>'

                        ];

                        departmentTable.row(rowIndex).data(newRowData).draw(false);
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

    $("#departmentTable").on("click", ".deleteDepartment", function () {
        var departmentId = $(this).data("id");
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
                    url: `/hrm-departments/${departmentId}`,
                    dataType: "json",
                    success: function (response) {
                        if (response.status === 'success') {
                            departmentTable.row($(`#department_${departmentId}`).closest('tr')).remove().draw(false);
                            toastr.success(response.message);
                        } else if (response.status === 'failed') {
                            toastr.error(response.message);
                        }
                    },
                    error: function (xhr) {
                        toastr.error('An error occurred while deleting the Supplier.');
                    }
                });
            }
        });
    });



});