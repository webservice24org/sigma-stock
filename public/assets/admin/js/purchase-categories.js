$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {

    const purchaseCategoryTable = $('#purchaseCategoryTable').DataTable();
    $('#purchaseCategoryCreate').on('click', function () {
        $('#createPurchaseCatModal').modal('toggle');
    })


    $('#purchaseCatForm').validate({
        rules: {
            purchase_cat_name: {
                required: true,
                minlength: 3
            }
        },
        messages: {
            purchase_cat_name: {
                required: "Please enter the Purchase Category Name",
                minlength: jQuery.validator.format("At least {0} characters required for the category name")
            }
        },
        submitHandler: function (form) {
            $("#response").empty();
            const formData = $(form).serializeArray();
            $.ajax({
                type: "POST",
                url: "/purchase-categories",
                data: formData,
                dataType: "json",
                success: function (response) {
                    $(form).trigger('reset');
                    $('#createPurchaseCatModal').modal('toggle');
                    if (response.status === 'success') {
                        toastr.success(response.message);
                        const newRowData = [
                            response.purchaseCat.id,
                            response.purchaseCat.purchase_cat_name,
                            '<a href="javascript:void(0)" class="btn btn-success editPurchaseCat" data-id="' + response.purchaseCat.id + '"><i class="fas fa-pen-to-square"></i></a>' +
                            '<a href="javascript:void(0)" class="btn btn-danger deletePurchaseCat" data-id="' + response.purchaseCat.id + '"><i class="fas fa-trash-can"></i></a>'

                        ];
                        $('#purchaseCategoryTable').DataTable().row.add(newRowData).draw(false);

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

    $("#purchaseCategoryTable").on("click", ".editPurchaseCat", function () {
        var purchaseCatId = $(this).data("id");
        $.ajax({
            type: "GET",
            url: `/purchase-categories/${purchaseCatId}/edit`,
            dataType: "json",
            success: function (response) {
                if (response.status === 'success') {
                    $("#editPurchaseCatModal #purchaseCatId").val(response.purchaseCat.id);
                    $("#editPurchaseCatModal #purchase_cat_name").val(response.purchaseCat.purchase_cat_name);
                    $("#editPurchaseCatModal").modal('toggle');
                } else if (response.status === 'failed') {
                    toastr.error(response.message);
                }
            },
            error: function (xhr, status, error) {
                toastr.error('An error occurred while fetching category details.');
            }
        });
    });

    $("#editpurchaseCatForm").validate({
        rules: {
            purchase_cat_name: {
                required: true,
                minlength: 3
            }
        },
        messages: {
            purchase_cat_name: {
                required: "Please enter the Purchase Category Name",
                minlength: jQuery.validator.format("At least {0} characters required for the category name")
            }
        },
        submitHandler: function (form) {
            $("#response").empty();
            const formData = $(form).serializeArray();
            const purchaseCatId = $("#purchaseCatId").val();

            $.ajax({
                type: "PUT",
                url: `/purchase-categories/${purchaseCatId}`,
                data: formData,
                dataType: "json",
                success: function (response) {
                    $("#editPurchaseCatModal").modal("toggle");
                    if (response.status === 'success') {
                        toastr.success(response.message);

                        const rowIndex = purchaseCategoryTable.row($(`#PurchaseCat_${purchaseCatId}`)).index();
                        const rowData = [
                            response.purchaseCat.id,
                            response.purchaseCat.purchase_cat_name,
                            '<a href="javascript:void(0)" class="btn btn-success editPurchaseCat" data-id="' + response.purchaseCat.id + '"><i class="fas fa-pen-to-square"></i></a>' +
                            '<a href="javascript:void(0)" class="btn btn-danger deletePurchaseCat" data-id="' + response.purchaseCat.id + '"><i class="fas fa-trash-can"></i></a>'
                        ];
                        purchaseCategoryTable.row(rowIndex).data(rowData).draw(false);
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

    $("#purchaseCategoryTable").on("click", ".deletePurchaseCat", function () {
        var purchaseCatId = $(this).data("id");
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
                    url: `/purchase-categories/${purchaseCatId}`,
                    dataType: "json",
                    success: function (response) {
                        if (response.status === 'success') {
                            purchaseCategoryTable.row($(`#PurchaseCat_${purchaseCatId}`).closest('tr')).remove().draw(false);
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