$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {
    const supplierTable = $('#supplierTable').DataTable();
    $('#supplierCreate').on('click', function () {
        $('#createSupplierModal').modal('toggle');
    })

    $('#createSupplierModal').on('shown.bs.modal', function () {
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

    $('#createSupplierForm').validate({
        rules: {
            user_id: {
                required: true
            },
            shopname: {
                required: true
            },
            trade_license: {
                required: true
            },
            business_phone: {
                required: true
            }
        },
        messages: {
            user_id: {
                required: "Please select a user"
            },
            shopname: {
                required: "Please enter the shop name"
            },
            trade_license: {
                required: "Please enter the trade license number"
            },
            business_phone: {
                required: "Please enter the business phone number"
            }
        },
        submitHandler: function (form) {
            $("#response").empty();
            const formData = $(form).serializeArray();
            $.ajax({
                type: "POST",
                url: "/suppliers",
                data: formData,
                dataType: "json",
                success: function (response) {
                    $(form).trigger('reset');
                    $('#createSupplierModal').modal('toggle');
                    if (response.status === 'success') {
                        toastr.success(response.message);
                        const newRowData = [
                            response.supplier.id,
                            response.supplier.shopname,
                            response.supplier.trade_license,
                            response.supplier.business_phone,
                            response.supplier.status ? 'Approved' : 'Pending',
                            '<a href="javascript:void(0)" class="btn btn-success viewSupplier" data-id="' + response.supplier.id + '"><i class="fas fa-eye"></i></a>' +
                            '<a href="javascript:void(0)" class="btn btn-success editSupplier" data-id="' + response.supplier.id + '"><i class="fas fa-pen-to-square"></i></a>' +
                            '<a href="javascript:void(0)" class="btn btn-warning statusSupplier" data-id="' + response.supplier.id + '"><i class="fas fa-lock"></i></a>' +
                            '<a href="javascript:void(0)" class="btn btn-danger deleteSupplier" data-id="' + response.supplier.id + '"><i class="fas fa-trash-can"></i></a>'

                        ];
                        $('#supplierTable').DataTable().row.add(newRowData).draw(false);


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


    $("#supplierTable").on('click', '.viewSupplier', function () {
        var supplierId = $(this).data('id');

        $.ajax({
            type: 'GET',
            url: '/suppliers/' + supplierId,
            dataType: 'json',
            success: function (response) {
                if (response.supplier.profile_photo_path) {
                    $("#viewSupplierForm #user_photo").attr("src", response.supplier.profile_photo_path);
                } else {
                    $("#viewSupplierForm #user_photo").attr("src", '/assets/admin/img/users/default.png');
                }
                $("#viewSupplierForm #user_id").val(response.supplier.supplier_name);
                $("#viewSupplierForm #user_mail").val(response.supplier.email);
                $("#viewSupplierForm #shopname").val(response.supplier.shopname);
                $("#viewSupplierForm #status").val(response.supplier.status ? 'Approved' : 'Pending');
                $("#viewSupplierForm #trade_license").val(response.supplier.trade_license);
                $("#viewSupplierForm #business_phone").val(response.supplier.business_phone);
                $("#viewSupplierForm #user_phone").val(response.supplier.phone);
                $("#viewSupplierForm #address").val(response.supplier.address);
                $("#viewSupplierForm #dob").val(response.supplier.dob);
                $("#viewSupplierForm #nid").val(response.supplier.nid);
                $("#viewSupplierForm #bank_name").val(response.supplier.bank_name);
                $("#viewSupplierForm #account_holder").val(response.supplier.account_holder);
                $("#viewSupplierForm #account_number").val(response.supplier.account_number);
                $("#viewSupplierForm #note").val(response.supplier.note);
                $("#viewSupplierForm #supplierId").val(response.supplier.id);
                $("#viewSupplierForm #created_by").val(response.supplier.created_by_name);
                $("#viewSupplierForm input, #viewSupplierForm textarea").attr("disabled", true);

                $('#supplierViewModal').modal('toggle');

                $('#printSupplier').click(function () {
                    window.print();
                });
            },

            error: function (xhr, status, error) {
                console.error('AJAX error:', error);
            }
        });
    });

    $('#supplierTable').on('click', '.editSupplier', function () {
        var supplierId = $(this).data('id');
        $.ajax({
            type: 'GET',
            url: `/suppliers/${supplierId}/edit`,
            dataType: 'json',
            success: function (response) {
                $('#editSupplierForm #supplier_name').val(response.supplier.user.name);
                $('#editSupplierForm #shopname').val(response.supplier.shopname);
                $('#editSupplierForm #trade_license').val(response.supplier.trade_license);
                $('#editSupplierForm #business_phone').val(response.supplier.business_phone);
                $('#editSupplierForm #note').val(response.supplier.note);
                $('#editSupplierForm').attr('action', '/suppliers/' + supplierId);

                $('#editSupplierForm #user_id').val(response.supplier.id);
                $('#editSupplierModal').modal('toggle');
            },
            error: function (xhr, status, error) {
                console.error('Error fetching supplier details:', error);
            }
        });
    });

    $('#editSupplierForm').validate({
        rules: {
            shopname: {
                required: true
            },
            trade_license: {
                required: true
            },
            business_phone: {
                required: true
            }
        },
        messages: {
            shopname: {
                required: "Please enter the shop name"
            },
            trade_license: {
                required: "Please enter the trade license number"
            },
            business_phone: {
                required: "Please enter the business phone number"
            }
        },
        submitHandler: function (form) {
            const supplierId = $("#user_id").val();
            $.ajax({
                type: 'PUT',
                url: $(form).attr('action'),
                data: $(form).serialize(),
                dataType: 'json',
                success: function (response) {
                    $('#editSupplierModal').modal('toggle');

                    toastr.success(response.message);
                    console.log('Response:', response);
                    const rowIndex = supplierTable.row($(`#supplier_${supplierId}`)).index();

                    var newRowData = [
                        response.supplier.id,
                        response.supplier.shopname,
                        response.supplier.trade_license,
                        response.supplier.business_phone,
                        response.supplier.status ? 'Approved' : 'Pending',
                        '<a href="javascript:void(0)" class="btn btn-success viewSupplier" data-id="' + response.supplier.id + '"><i class="fas fa-eye"></i></a>' +
                        '<a href="javascript:void(0)" class="btn btn-success editSupplier" data-id="' + response.supplier.id + '"><i class="fas fa-pen-to-square"></i></a>' +
                        '<a href="javascript:void(0)" class="btn btn-warning statusSupplier" data-id="' + response.supplier.id + '"><i class="fas fa-lock"></i></a>' +
                        '<a href="javascript:void(0)" class="btn btn-danger deleteSupplier" data-id="' + response.supplier.id + '"><i class="fas fa-trash-can"></i></a>'

                    ];

                    supplierTable.row(rowIndex).data(newRowData).draw(false);
                },
                error: function (xhr, status, error) {
                    toastr.error('An error occurred while processing your request.');
                    console.error('Error:', xhr.responseText);
                }
            });
        }
    });


    $("#supplierTable").on("click", ".deleteSupplier", function () {
        var supplierId = $(this).data("id");
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
                    url: `/suppliers/${supplierId}`,
                    dataType: "json",
                    success: function (response) {
                        if (response.status === 'success') {
                            supplierTable.row($(`#supplier_${supplierId}`).closest('tr')).remove().draw(false);
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


    $("#supplierTable").on("click", ".statusSupplier", function () {
        var supplierId = $(this).data('id');

        // Get the DataTables row corresponding to the clicked statusSupplier button
        var row = $(this).closest('tr');

        // Get the current status from the text content of the status cell
        var currentStatusText = row.find('td:eq(4)').text();
        var currentStatus = currentStatusText.trim().toLowerCase() === 'approved' ? 1 : 0;

        var newStatus;
        var confirmMessage;
        if (currentStatus === 0) {
            newStatus = 1;
            confirmMessage = "Are you sure you want to approve?";
        } else {
            newStatus = 0;
            confirmMessage = "Are you sure you want to make pending?";
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
                    url: '/suppliers/' + supplierId + '/status',
                    data: { status: newStatus },
                    dataType: 'json',
                    success: function (response) {
                        toastr.success(response.message);

                        var rowIndex = supplierTable.row(row).index();
                        var rowData = supplierTable.row(rowIndex).data();
                        rowData[4] = newStatus === 1 ? 'Approved' : 'Pending';
                        supplierTable.row(rowIndex).data(rowData).draw(false);
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