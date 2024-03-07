$(document).ready(function () {
    const brandTable = $("#brandTable").DataTable();
        $("#brandCreate").click(function () {
            $("#createBrands #brand_name").val("");
            $("#createBrands #brand_image").val("");
            $("#brand_image_preview").empty();
            $("#brandForm input").removeAttr("disabled");
            $("#brandForm button[type=submit]").removeClass("d-none");
            $("#brandForm #brandTitle").text("Create Brand");
            $("#brandForm").attr("action", `${baseUrl}/brands`);
            $("#hidden-brand-id").remove();
            $("#createBrands").modal("toggle");
        });

        $("#brandForm").validate({
            rules: {
                brand_name: {
                    required: true,
                    minlength: 2
                }
            },
            messages: {
                brand_name: {
                    required: "Please enter Brand Name",
                    minlength: jQuery.validator.format("At least {0} characters required!")
                }
            },
            submitHandler: function (form) {
                $("#response").empty();
                
                const brandData = new FormData(form); 

                const brandId = $("#hidden-brand-id").val();
                const methodType = brandId ? "PUT" : "POST"; 
                const formAction = $(form).attr("action");
                $.ajax({
                    url: formAction,
                    type: methodType,
                    data: brandData,
                    processData: false, 
                    contentType: false,
                    beforeSend: function () {
                        //console.log('loading....');
                        //showLoader();
                    },
                    success: function(response) {
                        $("#brandForm")[0].reset();
                        $("#createBrands").modal("toggle");
                        if (response.status === 'success') {
                            toastr.success(response.message);
                    
                            if (response.brand) {
                                const brand = response.brand;
                                const brandId = brand.id;
                                const brandRow = $(`#brand_${brandId}`);
                    
                                if (brandRow.length) {
                                    // Update existing row
                                    brandRow.find('td:nth-child(3)').text(brand.brand_name);
                                    brandRow.find('td:nth-child(4)').text(brand.brand_image);
                                } else {
                                    
                                    brandTable.row.add([
                                        `<input type="checkbox" name="checkAllBrands" id="checkAllBrands${brandId}" class="form-check-input brand-checkbox" value="${brandId}">`,
                                        brandId,
                                        brand.brand_name,
                                        `<img src="${brand.brand_image}" alt="Brand Image" style="max-width: 100px; max-height: 100px;">`, 
                                        `<td>
                                            <a href="javascript:void(0)" class="btn btn-primary btn-sm btnBrandView" data-id="${brandId}">View</a>
                                            <a href="javascript:void(0)" class="btn btn-success btn-sm btnBrandEdit" data-id="${brandId}">Edit</a>
                                            <a href="javascript:void(0)" class="btn btn-danger btn-sm btnBrandDelete" data-id="${brandId}">Delete</a>
                                        </td>`
                                    ]).draw(false);
                                    
                                }
                            }
                        } else if (response.status === 'failed') {
                            toastr.error(response.message);
                        }
                    },
                    
                    
                    error: function (error) {
                        toastr.error(`An error occurred: ${error.statusText}`);
                    },
                    complete:function(){
                        //hideLoader();
                    }
                });
            }
        });


        //View Brand
        $("#brandTable").on("click", ".btnBrandView", function() {
            const brandId = $(this).data("id");
            const mode = "view";
            brandId && fetchBrand(brandId, mode);
        });

        //Brand Edit
        $("#brandTable").on("click", ".btnBrandEdit", function() {
            const brandId = $(this).data("id");
            const mode = "edit";
            brandId && fetchBrand(brandId, mode);
        });

        function fetchBrand(brandId, mode=null) { 
            //showLoader();
            if (brandId) {
                
                
                $.ajax({
                    url: `brands/${brandId}`,
                    type: "GET",
                    // processData: false,
                    // contentType: false,
                    success: function(response){
                        if (response.status === "success") {
                            const brand = response.brand;
        
                            $("#createBrands #brand_name").val(brand.brand_name);
                            
                            $("#brand_image_preview").empty();
                            if (brand.brand_image) {
                                const img = $('<img>', { src: brand.brand_image, alt: 'Brand Image', style: 'max-width: 100px; max-height: 100px;' });
                                $("#brand_image_preview").append(img);
                            }
        
                            if (mode === "view") {
                                $("#brandForm input, #brandForm textarea").attr("disabled", true);
                                $("#brandForm button[type=submit]").addClass("d-none");
                                $("#brandForm #brandTitle").text("Brand Details");
                                $("#brandForm").removeAttr("action");
                            } else if (mode === "edit") {
                                $("#brandForm input, #brandForm textarea").removeAttr("disabled");
                                $("#brandForm button[type=submit]").removeClass("d-none");
                                $("#brandForm #brandTitle").text("Edit Brands Details");
                                $("#brandForm").attr("action", `${baseUrl}/brands/${brand.id}`);
                                $("#brandForm").append(`<input type="hidden" id="hidden-brand-id" value="${brand.id}">`); 
                            }
        
                            $("#createBrands").modal("toggle");
                        }
                    },
                    error: function(error){
                        console.error(error);
                    },
                    complete:function(){
                        //hideLoader();
                    }
                });
            }
        }
        

       

        //Delete brand
        $("#brandTable").on("click", ".btnBrandDelete", function () {
            const brandId = $(this).data("id");
            const buttonObj = $(this);
        
            if (brandId) {
        
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
                            url: `brands/${brandId}`,
                            type: "DELETE",
                            success: function (response) {
                                if (response.status === "success") {
                                    if (response.brand) {
                                        const rowIndex = brandTable.row($(`#brand_${response.brand.id}`)).index();
                                        brandTable.row(rowIndex).remove().draw();
        
                                        Swal.fire({
                                            title: "Deleted!",
                                            text: "News Category has been deleted.",
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
        $("#selectAllBrands").on("click", function(){
            const checkboxes = $("#brandTable tbody input[type='checkbox']");
            checkboxes.prop("checked", $(this).prop("checked"));

            if ($(this).prop("checked")) {
                $("#bulkBrandDelete").removeClass("d-none");
            }
            else{
                $("#bulkBrandDelete").addClass("d-none");
            }
        });

        //Bulk Deleted
        $("#bulkBrandDelete").on("click", function() {
            let selectedBrands = [];

            $(".brand-checkbox:checked").each(function() {
                selectedBrands.push($(this).val());
            });
            Swal.fire({
                title: "Are you sure?",
                text: "This action will delete selected brands. Continue?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete!",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "brands/bulk-delete",
                        type: "POST",
                        data: {
                            brandIds: selectedBrands
                        },
                        success: function(response) {
                            if (response.status === "success") {

                                $(".brand-checkbox:checked").each(function() {
                                    brandTable.row($(this).parents('tr')).remove().draw();
                                });

                                Swal.fire({
                                    title: "Success!",
                                    text: response.message,
                                    icon: "success",
                                    timer: 1500,
                                });

                                $("#bulkBrandDelete").addClass("d-none");
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