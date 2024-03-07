$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function () {

    const pcatTable = $("#pCategoryTable").DataTable({
        
    });
    
   //const dataTable = $("#todoTable").dataTable();

    //Create Todo
  $("#pCategoryCreate").click(function () {
    $("#createpCategory #product_category_name").val("");
    $("#createpCategory #product_category_slug").val("");
    $("#createpCategory #category_image").val("");
    $("#createpCategory #category_desc").val("");
    $("#pCategoryForm input, #pCategoryForm textarea").removeAttr("disabled", true);
    $("#pCategoryForm button[type=submit]").removeClass("d-none");
    $("#pCategoryForm #pCatTitle").text("Category Edit");
    $("#pCategoryForm").attr("action", `${baseUrl}/product-categories`); 
    $("#hidden-pcat-id").remove();
    $("#createpCategory").modal("toggle");
  });

  $("#pCategoryForm").validate({
      rules: {
        product_category_name: {
              required: true,
              minlength: 3
          }
      },
      messages: {
        product_category_name: {
            required: "Please enter Category Name",
            minlength: jQuery.validator.format("At least {0} characters required!")
        }
      },
      submitHandler: function (form) {
            $("#response").empty();
            $("#category_image_preview").empty();
          //const pCatData = $(form).serializeArray();
          const pCatData = new FormData(form); 
          const pCatId = $("#hidden-pcat-id").val();
          const methodType = pCatId && 'PUT' || 'POST';
          const formAction = $(form).attr("action");
          $.ajax({
              url: formAction,
              type: methodType,
              data: pCatData,
              processData: false, 
              contentType: false,
              beforeSend: function () {
                  //console.log('loading....');
                 // showLoader();
              },
              success: function(response) {
                console.log(response); // Log the response to the console
            
                $("#pCategoryForm")[0].reset();
                $("#createpCategory").modal("toggle");
                if (response.status === 'success') {
                    toastr.success(response.message);
                
                    const productCategory = response.productCategory;

                    const newRowHtml = `
                        <tr id="pcat_${productCategory.id}">
                            <td>
                                <input type="checkbox" name="selectAllpcategory" id="selectAllpcategory" class="form-check-input pcategory-checkbox" value="${productCategory.id}">
                            </td>
                            <td>${productCategory.id}</td>
                            <td>${productCategory.product_category_name}</td>
                            <td><img src="${productCategory.category_image}" alt="Category Image" style="max-width: 100px; max-height: 100px;"></td>
                            <td>${productCategory.category_desc}</td>
                            <td>${productCategory.product_category_slug}</td>
                            <td>
                                <a href="javascript:void(0)" class="btn btn-primary btn-sm btnPCatView" data-id="${productCategory.id}">View</a>
                                <a href="javascript:void(0)" class="btn btn-success btn-sm btnPCatEdit" data-id="${productCategory.id}">Edit</a>
                                <a href="javascript:void(0)" class="btn btn-danger btn-sm btnPCatDelete" data-id="${productCategory.id}">Delete</a>
                            </td>
                        </tr>
                    `;
                    $('#pCategoryTable tbody').append(newRowHtml);

                
                } else if (response.status === 'failed') {
                    toastr.error(response.message);
                }
            },
            
              error: function (error) {
                  toastr.error(`An error occurred: ${error.statusText}`);
              },
              complete: function() {
                //hideLoader();
              }

          });
        }
    });

    //View 
    $("#pCategoryTable").on("click", ".btnPCatView", function() {
        const pCatId = $(this).data("id");
        const mode = "view";
        pCatId && fetchPcat(pCatId, mode);
    });
    

    function fetchPcat(pCatId, mode = null) {
        if (pCatId) {
            $.ajax({
                url: `product-categories/${pCatId}`,
                type: "GET",
                success: function(response) {
                    if (response.status === "success") {
                        const productCategory = response.productCategory;
    
                        $("#pCategoryForm #product_category_name").val(productCategory.product_category_name);
                        $("#pCategoryForm #category_desc").val(productCategory.category_desc);
                        $("#pCategoryForm #product_category_slug").val(productCategory.product_category_slug);
    
                        // Clear previous image
                        $("#category_image_preview").empty();
    
                        // Create and append image element
                        if (productCategory.category_image) {
                            const img = $('<img>', { src: productCategory.category_image, alt: 'Category Image', style: 'max-width: 100px; max-height: 100px;' });
                            $("#category_image_preview").append(img);
                        }
    
                        if (mode === "view") {
                            $("#pCategoryForm input, #pCategoryForm textarea").attr("disabled", true);
                            $("#pCategoryForm button[type=submit]").addClass("d-none");
                            $("#pCategoryForm #pCatTitle").text("Category Details");
                            $("#pCategoryForm").removeAttr("action");
                        } else if (mode === "edit") {
                            $("#pCategoryForm input, #pCategoryForm textarea").removeAttr("disabled"); // Remove disabled attribute
                            $("#pCategoryForm button[type=submit]").removeClass("d-none");
                            $("#pCategoryForm #pCatTitle").text("Category Edit");
                            $("#pCategoryForm").attr("action", `${baseUrl}/product-categories/${productCategory.id}`);
                            $("#pCategoryForm").append(`<input type="hidden" id="hidden-pcat-id" value="${productCategory.id}">`);
                        }
    
                        $("#createpCategory").modal("toggle");
                    }
                },
                error: function (error) {
                    toastr.error(`An error occurred: ${error.statusText}`);
                }
            });
        }
    }
    
    
    
    

    //Edit
    $("#pCategoryTable").on("click", ".btnPCatEdit", function() {
        const pCatId = $(this).data("id");
        const mode = "edit";
        pCatId && fetchPcat(pCatId, mode);
    });

    //Delete
    $("#pCategoryTable tbody").on("click", ".btnPCatDelete", function () {
        const pCatId = $(this).data("id");
        const buttonObj = $(this);
    
        if (pCatId) {
    
            Swal.fire({
                title: "Are you sure?",
                text: "Once deleted, You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Delete",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `product-categories/${pCatId}`,
                        type: "DELETE",
                        success: function (response) {
                            if (response.status === "success") {
                                if (response.productCategory) {
                                    const rowIndex = pcatTable.row($(`#pcat_${response.productCategory.id}`)).index();
                                    pcatTable.row(rowIndex).remove().draw();
    
                                    Swal.fire({
                                        title: "Deleted!",
                                        text: "Category has been deleted.",
                                        icon: "success",
                                        timer: 1500,
                                    });
                                }
                            } else {
                                Swal.fire({
                                    title: "Failed!",
                                    text: "Unable to delete Category!",
                                    icon: "error",
                                });
                            }
                        },
                        error: function (error) {
                            Swal.fire({
                                title: "Failed!",
                                text: "Unable to delete Category!",
                                icon: "error",
                            });
                        },
                    });
                }
            });
        }
    });
    

    //Bulk select
    $("#selectAllpcategory").on("click", function(){
        const checkboxes = $("tbody input[type='checkbox']");
        checkboxes.prop("checked", $(this).prop("checked"));

        if ($(this).prop("checked")) {
            $("#bulkPCatDelete").removeClass("d-none");
        }
        else{
            $("#bulkPCatDelete").addClass("d-none");
        }
    });


    //Bulk Deleted
    $("#bulkPCatDelete").on("click", function() {
        let selectedcats = [];
    
        $(".pcategory-checkbox:checked").each(function() {
            selectedcats.push($(this).val());
        });
    
        if (selectedcats.length === 0) {
            Swal.fire({
                title: "No categories selected",
                text: "Please select at least one category to delete.",
                icon: "warning",
            });
            return;
        }
    
        Swal.fire({
            title: "Are you sure?",
            text: "Once deleted, you won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "product-categories/bulk-delete",
                    type: "POST",
                    data: {
                        pcatIds: selectedcats
                    },
                    success: function(response) {
                        if (response.status === "success") {
                            $(".pcategory-checkbox:checked").each(function() {
                                pcatTable.row($(this).parents('tr')).remove().draw();
                            });
    
                            Swal.fire({
                                title: "Success!",
                                text: response.message,
                                icon: "success",
                                timer: 1500,
                            });
    
                            $("#bulkPCatDelete").addClass("d-none");
                        } else {
                            Swal.fire({
                                title: "Failed!",
                                text: response.message,
                                icon: "error",
                                timer: 1500,
                            });
                        }
                    },
                    error: function(error) {
                        Swal.fire({
                            title: "Failed!",
                            text: "Unable to delete categories.",
                            icon: "error",
                            timer: 1500,
                        });
                    }
                });
            }
        });
    });
    

 

});
