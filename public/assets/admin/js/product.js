$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});



$(document).ready(function () {


    const productTable = $('#productTable').DataTable();


    $('#createProduct').on('click', function () {
        $('#createProductModal').modal('toggle');

    });

    $('#productForm').validate({
        rules: {
            code: {
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
                    $('#createProductModal').modal('toggle');
                    if (response.status === 'success') {
                        toastr.success(response.message);
                        const newRowData = [
                            response.product.id,
                            `<img src="/${response.product.image}" alt="${response.product.name}" class="img-thumbnail" style="max-width: 100px; max-height: 100px;">`,
                            response.product.code,
                            response.product.name,
                            response.product.making_cost,
                            response.product.general_price,
                            response.product.discount,
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
    $("#productTable").on("click", ".editProduct", function () {
        var productId = $(this).data("id");
        $.ajax({
            type: "GET",
            url: `/products/${productId}/edit`,
            dataType: "json",
            success: function (response) {
                if (response.status === 'success') {
                    // Set other fields' values
                    $("#editProductModal #category_id").val(response.product.category_id);
                    $("#editProductModal #unit_id").val(response.product.unit_id);
                    $("#editProductModal #code").val(response.product.code);
                    $("#editProductModal #name").val(response.product.name);
                    $("#editProductModal #making_cost").val(response.product.making_cost);
                    $("#editProductModal #general_price").val(response.product.general_price);
                    $("#editProductModal #discount").val(response.product.discount);
                    $("#editProductModal #tax_rate").val(response.product.tax_rate);
                    $("#editProductModal #stock_alert").val(response.product.stock_alert);
                    $("#editProductModal #product_desc").val(response.product.product_desc);
                    
            
                    // Display existing image
                    if (response.product.image) {
                        $("#editProductModal #existingImage").attr("src", response.product.image);
                    } else {
                        $("#editProductModal #existingImage").hide();
                    }
                    $("#editProductModal #existingImagePath").val(response.product.image);

    
                    $("#editProductModal #editProductId").val(response.product.id);

                    $("#editProductModal").modal('show');
                } else if (response.status === 'failed') {
                    toastr.error(response.message);
                }
            }
            ,
            error: function (xhr, status, error) {
                toastr.error('An error occurred while fetching category details.');
            }
        });
    });
    

    $("#editProductForm").validate({
        rules: {
            code: {
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
        submitHandler: function(form) {
            $("#response").empty();
            const formData = new FormData(form); // Use FormData to handle file inputs
            const productId = $("#editProductId").val();
        
            // Append the image file to the FormData object
            const imageFile = $("#image")[0].files[0];
            formData.append("image", imageFile);
        
            $.ajax({
                type: "POST",
                url: `/product/update/${productId}`,
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function(response) {
                    $("#editProductModal").modal("toggle");
                    if (response.status === 'success') {
                        console.log(response.product);
                        toastr.success(response.message);
                        const rowIndex = productTable.row($(`#product_${productId}`)).index();
                        const rowData = [
                            response.product.id,
                            `<img src="/${response.product.image}" alt="${response.product.name}" class="img-thumbnail" style="max-width: 100px; max-height: 100px;">`,
                            response.product.code,
                            response.product.name,
                            response.product.making_cost,
                            response.product.general_price,
                            response.product.discount,
                            `<div class="btn-group">
                                <a href="javascript:void(0)" class="btn btn-success btn-sm mx-2 editProduct" data-id="${response.product.id}">Edit</a>
                                <a href="javascript:void(0)" class="btn btn-danger btn-sm deleteProduct" data-id="${response.product.id}">Delete</a>
                            </div>`
                        ];
                        productTable.row(rowIndex).data(rowData).draw(false);
                    } else if (response.status === 'failed') {
                        toastr.error(response.message);
                    }
                },
                error: function(error) {
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
