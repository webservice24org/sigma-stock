$.ajaxSetup({
  headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

    const supplierTable = $('#supplierTable').DataTable();
    $('#supplierCreate').on('click', function() {
        $('#createSupplierModal').modal('toggle');
    })

    $('#createSupplierModal').on('shown.bs.modal', function () {
        $.ajax({
            type: 'GET',
            url: '/users', 
            dataType: "json",
            success: function(response) {
                $('#user_id').empty();
                $.each(response.users, function(index, user) {
                    $('#user_id').append($('<option>', {
                        value: user.id,
                        text: user.name
                    }));
                });
            },
            error: function(xhr, status, error) {
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
        submitHandler: function(form) {
            $("#response").empty();
            const formData = $(form).serializeArray();
            $.ajax({
                type: "POST",
                url: "/suppliers",
                data: formData,
                dataType: "json",
                success: function(response) {
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
                            '<a href="javascript:void(0)" class="btn btn-success viewSupplier" data-id="' + response.supplier.id + '">View</a>' +
                            '<a href="javascript:void(0)" class="btn btn-success editSupplier" data-id="' + response.supplier.id + '">Edit</a>' +
                            '<a href="javascript:void(0)" class="btn btn-success statusSupplier" data-id="' + response.supplier.id + '">Status</a>' +
                            '<a href="javascript:void(0)" class="btn btn-danger deleteSupplier" data-id="' + response.supplier.id + '">Delete</a>'
                        ];
                        $('#supplierTable').DataTable().row.add(newRowData).draw(false);
                        //supplierTable.row.add(newRowData).draw(false);


                    } else if (response.status === 'failed') {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error('An error occurred while processing your request.');
                    console.error('Error:', xhr.responseText);
                }
            });
        }
    });
    

    $("#supplierTable ").on('click', '.viewSupplier', function() {
        var supplierId = $(this).data('id');
        
        $.ajax({
            type: 'GET',
            url: '/suppliers/' + supplierId,
            dataType: 'json',
            success: function(response) {
                
                if (response.supplier.user.profile_photo_path) {
                    $("#viewSupplierForm #user_photo").attr("src", response.supplier.user.profile_photo_path);
                }else{
                    $("#viewSupplierForm #user_photo").attr("src", '/assets/admin/img/users/default.png');

                }
                $("#viewSupplierForm #user_id").val(response.supplier.user.name);
                $("#viewSupplierForm #user_mail").val(response.supplier.user.email);
                $("#viewSupplierForm #shopname").val(response.supplier.shopname);
                $("#viewSupplierForm #status").val(response.supplier.status ? 'Approved' : 'Pending');
                $("#viewSupplierForm #trade_license").val(response.supplier.trade_license);
                $("#viewSupplierForm #business_phone").val(response.supplier.business_phone);
                $("#viewSupplierForm #user_phone").val(response.supplier.user_detail.phone);
                $("#viewSupplierForm #address").val(response.supplier.user_detail.address);
                $("#viewSupplierForm #dob").val(response.supplier.user_detail.dob);
                $("#viewSupplierForm #nid").val(response.supplier.user_detail.nid);
                $("#viewSupplierForm #bank_name").val(response.supplier.user_detail.bank_name);
                $("#viewSupplierForm #account_holder").val(response.supplier.user_detail.account_holder);
                $("#viewSupplierForm #account_number").val(response.supplier.user_detail.account_number);
                $("#viewSupplierForm #note").val(response.supplier.note);
                $("#viewSupplierForm #supplierId").val(response.supplier.id);
                $("#viewSupplierForm #created_by").val(response.supplier.created_by.name);
                $("#viewSupplierForm input, #viewSupplierForm textarea").attr("disabled", true);
                    
                        
                $('#supplierViewModal').modal('toggle');
                
                $('#printSupplier').click(function() {
                    window.print();
                }); 
                
                
            },
            
            error: function(xhr, status, error) {
                console.error('AJAX error:', error);
            }
        });
    });

    
        // Open edit modal when edit button is clicked
        $('#supplierTable').on('click', '.editSupplier', function() {
            var supplierId = $(this).data('id');
            
            // Fetch supplier details via AJAX
            $.ajax({
                type: 'GET',
                url: `/suppliers/${supplierId}/edit`,
                dataType: 'json',
                success: function(response) {
                    $('#editSupplierForm #supplier_name').val(response.supplier.user.name);
                    $('#editSupplierForm #shopname').val(response.supplier.shopname);
                    $('#editSupplierForm #trade_license').val(response.supplier.trade_license);
                    $('#editSupplierForm #business_phone').val(response.supplier.business_phone);
                    $('#editSupplierForm #note').val(response.supplier.note);
                    $('#editSupplierForm').attr('action', '/suppliers/' + supplierId);
                    
                    $('#editSupplierForm #user_id').val(response.supplier.id);
                    $('#editSupplierModal').modal('toggle');
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching supplier details:', error);
                }
            });
        });
    
        $('#editSupplierForm').validate({
            rules: {
                // Define validation rules for each form field
                // For example:
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
                // Define error messages for each field if validation fails
                // For example:
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
            submitHandler: function(form) {
                const supplierId = $("#user_id").val();
                $.ajax({
                    type: 'PUT',
                    url: $(form).attr('action'),
                    data: $(form).serialize(),
                    dataType: 'json',
                    success: function(response) {
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
                            '<a href="javascript:void(0)" class="btn btn-success viewSupplier" data-id="' + response.supplier.id + '">View</a>' +
                            '<a href="javascript:void(0)" class="btn btn-success editSupplier" data-id="' + response.supplier.id + '">Edit</a>' +
                            '<a href="javascript:void(0)" class="btn btn-success statusSupplier" data-id="' + response.supplier.id + '">Status</a>' +
                            '<a href="javascript:void(0)" class="btn btn-danger deleteSupplier" data-id="' + response.supplier.id + '">Delete</a>'
                        ];
                        
                        supplierTable.row(rowIndex).data(newRowData).draw(false);
                    },
                    error: function(xhr, status, error) {
                        // Handle AJAX errors
                        toastr.error('An error occurred while processing your request.');
                        console.error('Error:', xhr.responseText);
                    }
                });
            }
        });
        
    
    
    
    

    
    