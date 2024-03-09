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
                            response.supplier.createdBy.name,
                            response.supplier.user.name, // Assuming you want the same name here as the created_by
                            response.supplier.shopname,
                            response.supplier.trade_license,
                            response.supplier.business_phone,
                            response.supplier.status ? 'Approved' : 'Pending',
                            '<a href="javascript:void(0)" class="btn btn-success viewSupplier" data-id="' + response.supplier.id + '">View</a>' +
                            '<a href="javascript:void(0)" class="btn btn-success editSupplier" data-id="' + response.supplier.id + '">Edit</a>' +
                            '<a href="javascript:void(0)" class="btn btn-success statusSupplier" data-id="' + response.supplier.id + '">Status</a>' +
                            '<a href="javascript:void(0)" class="btn btn-danger deleteSupplier" data-id="' + response.supplier.id + '">Delete</a>'
                        ];
                        $('#supplierTable').DataTable().row.add(newRowData).draw();
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
    

    

});


