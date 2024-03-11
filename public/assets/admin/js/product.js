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

    var productsExist = productRowCount > 0;

    if (productsExist) {
        var productTable = $('#productTable').DataTable();
    }

    $('#createProduct').on('click', function () {
        $('#createProductModal').modal('toggle');

    });

    $('#productForm').validate({
        rules: {
            code: {
                required: true
            },
            type_barcode: {
                required: true
            },
            name: {
                required: true
            },
            making_cost: {
                required: true,
                number: true
            },
            general_price: {
                required: true,
                number: true
            },
            category_id: {
                required: true
            },

            unit_id: {
                number: true
            },

            discount: {
                number: true
            },
            tax_rate: {
                number: true
            },
            stock_alert: {
                number: true
            }

        },
        messages: {
            category_id: {
                required: "Please select the product Category"
            },
            code: {
                required: "Please enter the product Code"
            },
            type_barcode: {
                required: "Please enter the product Barcode"
            },
            name: {
                required: "Please enter the product Name"
            },
            making_cost: {
                required: "Please enter the Making Cost",
                number: "Please enter a valid number for the Making Cost"
            },
            general_price: {
                required: "Please enter the General Price",
                number: "Please enter a valid number for the General Price"
            },
            unit_id: {
                number: "Please select a valid unit"
            },
            discount: {
                number: "Please enter a valid number for the Discount"
            },
            tax_rate: {
                number: "Please enter a valid number for the Tax Rate"
            },
            stock_alert: {
                number: "Please enter a valid number for the Stock Alert"
            }

        },
        submitHandler: function (form) {
            $("#response").empty();
            const formData = new FormData(form);
            $.ajax({
                type: "POST",
                url: "/products",
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function (response) {
                    $(form).trigger('reset');
                    $('#createCustomerModal').modal('toggle');
                    if (response.status === 'success') {
                        toastr.success(response.message);
                        const newRowData = [
                            `<img src="/${response.teacher.photo}" alt="${rresponse.product.image}" class="img-thumbnail" style="max-width: 100px; max-height: 100px;">`,
                            response.product.code,
                            response.product.name,
                            response.product.category.name,
                            response.product.type_barcode,
                            response.product.making_cost,
                            response.product.general_price,
                            response.product.unit.name,
                            response.product.discount,
                            response.product.tax_rate,
                            response.product.note,
                            response.product.stock_alert,
                            response.product.created_by.name,
                            `<div class="btn-group">
                                <a href="javascript:void(0)" class="btn btn-success btn-sm mx-2 editProduct" data-id="${response.product.id}">Edit</a>
                                <a href="javascript:void(0)" class="btn btn-danger btn-sm deleteProduct" data-id="${response.product.id}">Delete</a>
                            </div>`
                        ];
                        productTable.row.add(newRowData).draw(false);
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
                    $("#editCustomerModal #shopname").val(response.customer.shopname);
                    $("#editCustomerModal #trade_license").val(response.customer.trade_license);
                    $("#editCustomerModal #business_phone").val(response.customer.business_phone);
                    $("#editCustomerModal #product_rate").val(response.customer.product_rate);
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
            code: {
                required: true
            },
            type_barcode: {
                required: true
            },
            name: {
                required: true
            },
            making_cost: {
                required: true,
                number: true
            },
            general_price: {
                required: true,
                number: true
            },
            category_id: {
                required: true
            },

            unit_id: {
                number: true
            },

            discount: {
                number: true
            },
            tax_rate: {
                number: true
            },
            stock_alert: {
                number: true
            }

        },
        messages: {
            category_id: {
                required: "Please select the product Category"
            },
            code: {
                required: "Please enter the product Code"
            },
            type_barcode: {
                required: "Please enter the product Barcode"
            },
            name: {
                required: "Please enter the product Name"
            },
            making_cost: {
                required: "Please enter the Making Cost",
                number: "Please enter a valid number for the Making Cost"
            },
            general_price: {
                required: "Please enter the General Price",
                number: "Please enter a valid number for the General Price"
            },
            unit_id: {
                number: "Please select a valid unit"
            },
            discount: {
                number: "Please enter a valid number for the Discount"
            },
            tax_rate: {
                number: "Please enter a valid number for the Tax Rate"
            },
            stock_alert: {
                number: "Please enter a valid number for the Stock Alert"
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
                            response.customer.user.name,
                            response.customer.user.email,
                            response.customer.category.name,
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

    $("#productTable").on("click", ".deleteProduct", function () {
        var productId = $(this).data("id");
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
                    url: `/products/${productId}`,
                    dataType: "json",
                    success: function (response) {
                        if (response.status === 'success') {
                            productTable.row($(`#product_${productId}`).closest('tr')).remove().draw(false);
                            toastr.success(response.message);
                        } else if (response.status === 'failed') {
                            toastr.error(response.message);
                        }
                    },
                    error: function (xhr) {
                        toastr.error('An error occurred while deleting the product.');
                    }
                });
            }
        });
    });


});
