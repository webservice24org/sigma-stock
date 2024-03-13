$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {

    const purchaseTable = $('#purchaseTable').DataTable();

    $('#addPurchase').on('click', function () {
        $.ajax({
            type: 'GET',
            url: '/all-suppliers',
            dataType: 'json',
            success: function (response) {
                $('#supplier_id').empty();
                $.each(response.allSuppliers, function (index, allSuppliers) {
                    $('#supplier_id').append($('<option>', {
                        value: allSuppliers.id,
                        text: allSuppliers.shopname
                    }));
                });
            },
            error: function (xhr, status, error) {
                console.error('Error fetching suppliers:', error);
            }
        });
        $.ajax({
            type: 'GET',
            url: '/all-warehouses',
            dataType: 'json',
            success: function (response) {
                $('#warehouse_id').empty();
                $.each(response.allwarehouses, function (index, allwarehouses) {
                    $('#warehouse_id').append($('<option>', {
                        value: allwarehouses.id,
                        text: allwarehouses.warehouse_name
                    }));
                });
            },
            error: function (xhr, status, error) {
                console.error('Error fetching Warehouse:', error);
            }
        });

        $.ajax({
            type: 'GET',
            url: '/all-purchase-cats',
            dataType: 'json',
            success: function (response) {
                $('#purchase_category_id').empty();
                $.each(response.allPurchseCats, function (index, allPurchseCats) {
                    $('#purchase_category_id').append($('<option>', {
                        value: allPurchseCats.id,
                        text: allPurchseCats.purchase_cat_name
                    }));
                });
            },
            error: function (xhr, status, error) {
                console.error('Error fetching Warehouse:', error);
            }
        });
        $.ajax({
            type: 'GET',
            url: '/all-units',
            dataType: 'json',
            success: function (response) {
                $('#unit_id').empty();
                $.each(response.allUnits, function (index, allUnits) {
                    $('#unit_id').append($('<option>', {
                        value: allUnits.id,
                        text: allUnits.unit_name
                    }));
                });
            },
            error: function (xhr, status, error) {
                console.error('Error fetching Warehouse:', error);
            }
        });

        $('#createPurchaseModal').modal('toggle');
    });


    $('#purchaseForm').validate({
        rules: {
            supplier_id: {
                required: true
            },warehouse_id: {
                required: true
            },purchase_category_id: {
                required: true
            },unit_id: {
                required: true
            },date: {
                required: true
            },tax_rate: {
                required: true
            },payment_statut: {
                required: true
            },notes: {
                required: true
            }
        },
        submitHandler: function (form) {
            $("#response").empty();
            const formData = $(form).serializeArray();
            $.ajax({
                type: "POST",
                url: "/purchases",
                data: formData,
                dataType: "json",
                success: function (response, status, xhr) {
                    $(form).trigger('reset');
                    $('#createPurchaseModal').modal('toggle');
                    if (xhr.status === 201) {
                        toastr.success(response.message);
                        const newRowData = [
                            response.purchase.id,
                            response.purchase.date.split(' ')[0],
                            response.purchase.payment_statut ? 'Paid' : 'Partial',
                            response.purchase.status ? 'Approved' : 'Pending',

                            '<a href="javascript:void(0)" class="btn btn-success viewPurchase" data-id="' + response.purchase.id + '"><i class="fas fa-eye"></i></a>' +
                            '<a href="javascript:void(0)" class="btn btn-success editPurchase" data-id="' + response.purchase.id + '"><i class="fas fa-pen-to-square"></i></a>' +
                            '<a href="javascript:void(0)" class="btn btn-warning statusPurchase" data-id="' + response.purchase.id + '"><i class="fas fa-lock"></i></a>' +
                            '<a href="javascript:void(0)" class="btn btn-danger deletePurchase" data-id="' + response.purchase.id + '"><i class="fas fa-trash-can"></i></a>'
                        ];
                        $('#purchaseTable').DataTable().row.add(newRowData).draw(false);
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