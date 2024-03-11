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

    const customerCategoryTable = $("#customerCategoryTable").DataTable({});

    $('#createCustomerCategory').on('click', function () {
        $('#createCustomerCategoryModal').modal('toggle');

    });
    $('#customerCategoryForm').validate({
        rules: {
            name: {
                required: true,
                minlength: 3
            }
        },
        messages: {
            name: {
                required: "Please enter the name of the Customer Category",
                minlength: jQuery.validator.format("At least {0} characters required!")
            }
        },
        submitHandler: function (form) {
            $("#response").empty();
            const formData = $(form).serializeArray();
            $.ajax({
                type: "POST",
                url: "/customers-categories",
                data: formData,
                dataType: "json",
                success: function (response) {
                    $(form).trigger('reset');
                    $('#createCustomerCategoryModal').modal('toggle');
                    if (response.status === 'success') {
                        toastr.success(response.message);
                        const newRowData = [
                            response.category.id,
                            response.category.createdBy.name,
                            response.category.name,
                            `<a href="javascript:void(0)" class="btn btn-success editCategory" data-id="${response.category.id}}">Edit</a>
                            <a href="javascript:void(0)" class="btn btn-danger deleteCategory" data-id="${response.category.id}}">Delete</a>`
                        ];
                        customerCategoryTable.row.add(newRowData).draw(false);
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
    $("#customerCategoryTable").on("click", ".editCategory", function () {
        var categoryId = $(this).data("id");
        $.ajax({
            type: "GET",
            url: `/customers-categories/${categoryId}/edit`,
            dataType: "json",
            success: function (response) {
                if (response.status === 'success') {
                    $("#editCustomerCategoryModal #editCategoryId").val(response.category.id);
                    $("#editCustomerCategoryModal #name").val(response.category.name);
                    $("#editCustomerCategoryModal").modal('toggle');
                } else if (response.status === 'failed') {
                    toastr.error(response.message);
                }
            },
            error: function (xhr, status, error) {
                toastr.error('An error occurred while fetching category details.');
            }
        });
    });

    $("#editCustomerCategoryForm").validate({
        rules: {
            name: {
                required: true,
                minlength: 3
            }
        },
        messages: {
            name: {
                required: "Please enter the name of the Customer Category",
                minlength: jQuery.validator.format("At least {0} characters required!")
            }
        },
        submitHandler: function (form) {
            $("#response").empty();
            const formData = $(form).serializeArray();
            const categoryId = $("#editCategoryId").val();

            $.ajax({
                type: "PUT",
                url: `/customers-categories/${categoryId}`,
                data: formData,
                dataType: "json",
                success: function (response) {
                    $("#editCustomerCategoryModal").modal("toggle");
                    if (response.status === 'success') {
                        toastr.success(response.message);

                        const rowIndex = customerCategoryTable.row($(`#category_${categoryId}`)).index();
                        const rowData = [
                            response.category.id,
                            response.category.createdBy.name,
                            response.category.cat_name,
                            `<a href="javascript:void(0)" class="btn btn-success editCategory" data-id="${response.category.id}">Edit</a>
                            <a href="javascript:void(0)" class="btn btn-danger deleteCategory" data-id="${response.category.id}">Delete</a>`
                        ];
                        customerCategoryTable.row(rowIndex).data(rowData).draw(false);
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

    $("#customerCategoryTable").on("click", ".deleteCategory", function () {
        var categoryId = $(this).data("id");
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
                    url: `/customers-categories/${categoryId}`,
                    dataType: "json",
                    success: function (response) {
                        if (response.status === 'success') {
                            customerCategoryTable.row($(`#category_${categoryId}`).closest('tr')).remove().draw(false);
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
