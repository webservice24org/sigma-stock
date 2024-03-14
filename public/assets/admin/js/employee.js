$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {

    const employeeTable = $('#employeeTable').DataTable();
    $('#employeeCreate').on('click', function () {
        $('#createEmployeeModal').modal('toggle');
    })

    $('#createEmployeeModal').on('shown.bs.modal', function () {
        $.ajax({
            type: 'GET',
            url: '/users',
            dataType: "json",
            success: function (response) {
                $('#user_id').empty();
                $.each(response.users, function (index, user) {
                    $('#user_id').append($('<option>', {
                        value: user.id,
                        text: user.name
                    }));
                });
            },
            error: function (xhr, status, error) {
                console.error('Error fetching users:', error);
            }
        });

    });

    $('#createEmployeeModal').on('shown.bs.modal', function () {
        $.ajax({
            type: 'GET',
            url: '/departments',
            dataType: "json",
            success: function (response) {
                $('#hrm_department_id').empty();
                $.each(response.departments, function (index, department) {
                    $('#hrm_department_id').append($('<option>', {
                        value: department.id,
                        text: department.department_name
                    }));
                });
            },
            error: function (xhr, status, error) {
                console.error('Error fetching Departments:', error);
            }
        });
    });




    $('#employeeForm').validate({
        rules: {
            user_id: {
                required: true
            },
            hrm_department_id: {
                required: true
            },
            salary_amount: {
                required: true,
                minlength: 2
            },
            joining_date: {
                required: true
            }
        },
        messages: {
            user_id: {
                required: "Please Select User"
            },
            hrm_department_id: {
                required: "Please Department"
            },
            salary_amount: {
                required: "Please enter Salary Amount",
                minlength: jQuery.validator.format("At least {0} characters required!")
            },
            joining_date: {
                required: "Please Select Joining Date"
            }
        },
        submitHandler: function (form) {
            $("#response").empty();
            const formData = $(form).serializeArray();
            $.ajax({
                type: "POST",
                url: "/employees",
                data: formData,
                dataType: "json",
                success: function (response, status, xhr) {
                    $(form).trigger('reset');
                    $('#createEmployeeModal').modal('toggle');
                    if (xhr.status === 201) {
                        toastr.success(response.message);
                        const newRowData = [
                            response.employee.id,
                            response.employee.user_id,
                            response.employee.hrm_department_id,
                            response.employee.joining_date,
                            response.employee.status ? 'Active' : 'Inactive',

                            '<a href="javascript:void(0)" class="btn btn-success viewEmployee" data-id="' + response.employee.id + '"><i class="fas fa-eye"></i></a>' +
                            '<a href="javascript:void(0)" class="btn btn-success editEmployee" data-id="' + response.employee.id + '"><i class="fas fa-pen-to-square"></i></a>' +
                            '<a href="javascript:void(0)" class="btn btn-warning statusEmployee" data-id="' + response.employee.id + '"><i class="fas fa-lock"></i></a>' +
                            '<a href="javascript:void(0)" class="btn btn-danger deleteEmployee" data-id="' + response.employee.id + '"><i class="fas fa-trash-can"></i></a>'
                        ];
                        $('#employeeTable').DataTable().row.add(newRowData).draw(false);
                        location.reload();
                    } else if (xhr.status === 409) {
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


    $('#employeeTable').on('click', '.viewEmployee', function () {
        var employeeId = $(this).data('id');
        $.ajax({
            type: 'GET',
            url: '/employees/' + employeeId,
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {

                    if (response.employee.profile_photo_path) {
                        $("#viewEmployeeModal #profile_photo").attr("src", response.employee.profile_photo_path);
                    } else {
                        $("#viewEmployeeModal #profile_photo").attr("src", '/assets/admin/img/users/default.png');
                    }
                    var employee = response.employee;
                    $('#viewEmployeeModal #employeeName').text(employee.user_name);
                    $('#viewEmployeeModal #employeeId').text(employee.id);
                    $('#viewEmployeeModal #departmentName').text(employee.department_name);
                    $('#viewEmployeeModal #salaryAmount').text(employee.salary_amount);
                    $('#viewEmployeeModal #joiningDate').text(employee.joining_date);
                    $('#viewEmployeeModal #regineDate').text(employee.regine_date);
                    $('#viewEmployeeModal #email').text(employee.email);
                    $('#viewEmployeeModal #phone').text(employee.phone);
                    $('#viewEmployeeModal #address').text(employee.address);
                    $('#viewEmployeeModal #dob').text(employee.dob);
                    $('#viewEmployeeModal #nid').text(employee.nid);
                    $('#viewEmployeeModal #bankName').text(employee.bank_name);
                    $('#viewEmployeeModal #accountHolder').text(employee.account_holder);
                    $('#viewEmployeeModal #accountNnumber').text(employee.account_number);

                    $('#viewEmployeeModal').modal('toggle');

                    $('#printEmployee').click(function () {
                        window.print();
                    });

                } else {
                    toastr.error(response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('An error occurred while fetching employee data.');
                console.error('Error:', xhr.responseText);
                toastr.error('An error occurred while fetching employee data.');
            }
        });
    });


    $('#employeeTable').on('click', '.editEmployee', function () {
        var employeeId = $(this).data('id');
        $.ajax({
            type: 'GET',
            url: '/departments',
            dataType: 'json',
            success: function (departmentResponse) {
                $('#editEmployeeModal #department_id').empty();
                departmentResponse.departments.forEach(function (department) {
                    $('#editEmployeeModal #department_id').append($('<option>', {
                        value: department.id,
                        text: department.department_name
                    }));
                });

                $.ajax({
                    type: 'GET',
                    url: '/employees/' + employeeId,
                    dataType: 'json',
                    success: function (response) {
                        $('#editEmployeeModal #employeeId').val(response.employee.id);
                        $('#editEmployeeModal #user_id').val(response.employee.user_id);
                        $('#editEmployeeModal #userName').text(response.employee.user_name);
                        $('#editEmployeeModal #department_id').val(response.employee.hrm_department_id);
                        $('#editEmployeeModal #salary_amount').val(response.employee.salary_amount);

                        $('#editEmployeeModal #note').val(response.employee.note);

                        $('#editEmployeeModal').modal('show');
                    },
                    error: function (xhr, status, error) {
                        console.error('Error fetching employee data:', error);

                    }
                });
            },
            error: function (xhr, status, error) {
                console.error('Error fetching departments:', error);

            }
        });
    });



    $('#editEmployeeForm').submit(function (event) {
        event.preventDefault();

        var formData = $(this).serialize();
        const employeeId = $("#employeeId").val();
        $.ajax({
            type: 'PUT',
            url: '/employees/' + $('#editEmployeeModal #employeeId').val(),
            data: formData,
            dataType: 'json',
            success: function (response) {
                $('#editEmployeeModal').modal('hide');
                toastr.success(response.message);
                const rowIndex = employeeTable.row($(`#employee_${employeeId}`)).index();
                const newRowData = [
                    response.employee.id,
                    response.employee.user_id,
                    response.employee.hrm_department_id,
                    response.employee.joining_date,
                    response.employee.status ? 'Active' : 'Inactive',

                    '<a href="javascript:void(0)" class="btn btn-success viewEmployee" data-id="' + response.employee.id + '"><i class="fas fa-eye"></i></a>' +
                    '<a href="javascript:void(0)" class="btn btn-success editEmployee" data-id="' + response.employee.id + '"><i class="fas fa-pen-to-square"></i></a>' +
                    '<a href="javascript:void(0)" class="btn btn-warning statusEmployee" data-id="' + response.employee.id + '"><i class="fas fa-lock"></i></a>' +
                    '<a href="javascript:void(0)" class="btn btn-danger deleteEmployee" data-id="' + response.employee.id + '"><i class="fas fa-trash-can"></i></a>'
                ];
                employeeTable.row(rowIndex).data(newRowData).draw(false);
                location.reload();
            },
            error: function (xhr, status, error) {
                console.error('Error updating employee:', error);

            }
        });
    });

    $("#employeeTable").on("click", ".deleteEmployee", function () {
        var employeeId = $(this).data("id");
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
                    url: `/employees/${employeeId}`,
                    dataType: "json",
                    success: function (response) {
                        if (response.status === 'success') {
                            employeeTable.row($(`#employee_${employeeId}`).closest('tr')).remove().draw(false);
                            toastr.success(response.message);
                        } else if (response.status === 'failed') {
                            toastr.error(response.message);
                        }
                    },
                    error: function (xhr) {
                        toastr.error('An error occurred while deleting the Employee.');
                    }
                });
            }
        });
    });

    $("#employeeTable").on("click", ".statusEmployee", function () {
        var employeeId = $(this).data('id');
        var row = $(this).closest('tr');

        var currentStatusText = row.find('td:eq(4)').text();
        var currentStatus = currentStatusText.trim().toLowerCase() === 'active' ? 1 : 0;

        var newStatus;
        var confirmMessage;
        if (currentStatus === 0) {
            newStatus = 1;
            confirmMessage = "Are you sure you want to active?";
        } else {
            newStatus = 0;
            confirmMessage = "Are you sure you want to make suspend?";
        }

        Swal.fire({
            title: 'Confirmation',
            text: confirmMessage,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'PUT',
                    url: '/employees/' + employeeId + '/status',
                    data: { status: newStatus },
                    dataType: 'json',
                    success: function (response) {
                        toastr.success(response.message);

                        var rowIndex = employeeTable.row(row).index();
                        var rowData = employeeTable.row(rowIndex).data();
                        rowData[4] = newStatus === 1 ? 'Active' : 'Suspended';
                        employeeTable.row(rowIndex).data(rowData).draw(false);
                    },
                    error: function (xhr, status, error) {
                        console.error('An error occurred while processing your request.');
                        console.error('Error:', xhr.responseText);
                        toastr.error('An error occurred while processing your request.');
                    }
                });
            }
        });
    });


});