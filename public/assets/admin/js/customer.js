$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});



$(document).ready(function () {

    //Toaster body customization
    toastr.options = {
        closeButton: true,
        progressBar: true,
        positionClass: 'toast-top-right',
        showDuration: 300,
        hideDuration: 1000,
        timeOut: 5000,
        extendedTimeOut: 1000,
        showEasing: 'swing',
        hideEasing: 'linear',
        showMethod: 'fadeIn',
        hideMethod: 'fadeOut',
        tapToDismiss: false
    };

    var customersExist = customerRowCount > 0;

    if (customersExist) {
        var customerTable = $('#customerTable').DataTable();
    }

    $('#createCustomer').on('click', function () {
        $('#createCustomerModal').modal('toggle');

    });


    $('#customerForm').validate({
        rules: {
            category_id: {
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
            },
            tax_rate: {
                required: true,
                number: true
            }
        },
        messages: {
            category_id: {
                required: "Please select the Customer Category"
            },
            shopname: {
                required: "Please enter the Shop Name"
            },
            trade_license: {
                required: "Please enter the Trade License"
            },
            business_phone: {
                required: "Please enter the Business Phone"
            },
            tax_rate: {
                required: "Please enter the Tax Rate",
                number: "Please enter a valid number for the Tax Rate"
            }
        },
        submitHandler: function (form) {
            $("#response").empty();
            const formData = $(form).serializeArray();
            $.ajax({
                type: "POST",
                url: "/customers",
                data: formData,
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    $(form).trigger('reset');
                    $('#createCustomerModal').modal('toggle');
                    if (response.status === 'success') {
                        toastr.success(response.message);
                        const newRowData = [
                            response.customer.id,
                            response.customer.shopname,
                            response.customer.business_phone,
                            `<a href="javascript:void(0)" class="btn btn-success btn-sm editCustomer" data-id="${response.customer.id}}">Edit</a>
                             <a href="javascript:void(0)" class="btn btn-danger btn-sm deleteCustomer" data-id="${response.customer.id}}">Delete</a>`
                        ];
                        customerTable.row.add(newRowData).draw(false);
                    } else if (response.status === 'failed') {
                        toastr.error(response.message);
                    }
                },

                error: function (xhr) {
                    toastr.error('An error occurred while processing your request.');
                    console.error('An error occurred:', xhr.responseText);
                }
            });
        }

    });

    // Edit Category
    $("#customerTable").on("click", ".editCustomer", function () {
        var customerId = $(this).data("id");
        $.ajax({
            type: "GET",
            url: `/customers/${customerId}/edit`,
            dataType: "json",
            success: function (response) {
                if (response.status === 'success') {
                    $("#editCustomerModal #category_id").val(response.customer.category_id);
                    $("#editCustomerModal #user_id").val(response.customer.user_id);
                    $("#editCustomerModal #shopname").val(response.customer.shopname);
                    $("#editCustomerModal #trade_license").val(response.customer.trade_license);
                    $("#editCustomerModal #business_phone").val(response.customer.business_phone);
                    $("#editCustomerModal #tax_rate").val(response.customer.tax_rate);
                    $("#editCustomerModal #editCustomerId").val(response.customer.id);

                    $("#editCustomerModal").modal('show');
                } else if (response.status === 'failed') {
                    toastr.error(response.message);
                }
            },
            error: function (xhr, status, error) {
                toastr.error('An error occurred while fetching category details.');
            }
        });
    });

    $("#editCustomerForm").validate({
        rules: {
            category_id: {
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
            },
            tax_rate: {
                required: true,
                number: true
            }
        },
        messages: {
            category_id: {
                required: "Please select the Customer Category"
            },
            shopname: {
                required: "Please enter the Shop Name"
            },
            trade_license: {
                required: "Please enter the Trade License"
            },
            business_phone: {
                required: "Please enter the Business Phone"
            },
            tax_rate: {
                required: "Please enter the Tax Rate",
                number: "Please enter a valid number for the Tax Rate"
            }
        },
        submitHandler: function (form) {
            $("#response").empty();
            const formData = $(form).serializeArray();
            const customerId = $("#editCustomerId").val();

            $.ajax({
                type: "PUT",
                url: `/customers/${customerId}`,
                data: formData,
                dataType: "json",
                success: function (response) {
                    $("#editCustomerModal").modal("toggle");
                    if (response.status === 'success') {
                        toastr.success(response.message);
                        const rowIndex = customerTable.row($(`#customer_${customerId}`)).index();
                        const rowData = [
                            response.customer.id,
                            response.customer.shopname,
                            response.customer.business_phone,
                            `<a href="javascript:void(0)" class="btn btn-success btn-sm editCustomer" data-id="${response.customer.id}}">Edit</a>
                             <a href="javascript:void(0)" class="btn btn-danger btn-sm deleteCustomer" data-id="${response.customer.id}}">Delete</a>`
                        ];
                        customerTable.row(rowIndex).data(rowData).draw(false);
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

    $("#customerTable").on("click", ".deleteCustomer", function () {
        var customerId = $(this).data("id");
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
                    url: `/customers/${customerId}`,
                    dataType: "json",
                    success: function (response) {
                        if (response.status === 'success') {
                            customerTable.row($(`#customer_${customerId}`).closest('tr')).remove().draw(false);
                            toastr.success(response.message);
                        } else if (response.status === 'failed') {
                            toastr.error(response.message);
                        }
                    },
                    error: function (xhr) {
                        toastr.error('An error occurred while deleting the category.');
                    }
                });
            }
        });
    });


});
