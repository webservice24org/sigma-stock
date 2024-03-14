$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {

    const purchaseTable = $('#purchaseTable').DataTable();

    $('#addPurchase').on('click', function () {
        $.ajax({
            type: 'GET',
            url: '/all-suppliers',
            dataType: 'json',
            success: function (response) {
                $('#supplier_id').empty();
                $.each(response.allSuppliers, function (index, allSuppliers) {
                    $('#supplier_id').append($('<option>', {
                        value: allSuppliers.id,
                        text: allSuppliers.shopname
                    }));
                });
            },
            error: function (xhr, status, error) {
                console.error('Error fetching suppliers:', error);
            }
        });
        $.ajax({
            type: 'GET',
            url: '/all-warehouses',
            dataType: 'json',
            success: function (response) {
                $('#warehouse_id').empty();
                $.each(response.allwarehouses, function (index, allwarehouses) {
                    $('#warehouse_id').append($('<option>', {
                        value: allwarehouses.id,
                        text: allwarehouses.warehouse_name
                    }));
                });
            },
            error: function (xhr, status, error) {
                console.error('Error fetching Warehouse:', error);
            }
        });

        $.ajax({
            type: 'GET',
            url: '/all-purchase-cats',
            dataType: 'json',
            success: function (response) {
                $('#purchase_category_id').empty();
                $.each(response.allPurchseCats, function (index, allPurchseCats) {
                    $('#purchase_category_id').append($('<option>', {
                        value: allPurchseCats.id,
                        text: allPurchseCats.purchase_cat_name
                    }));
                });
            },
            error: function (xhr, status, error) {
                console.error('Error fetching Warehouse:', error);
            }
        });
        $.ajax({
            type: 'GET',
            url: '/all-units',
            dataType: 'json',
            success: function (response) {
                $('#unit_id').empty();
                $.each(response.allUnits, function (index, allUnits) {
                    $('#unit_id').append($('<option>', {
                        value: allUnits.id,
                        text: allUnits.unit_name
                    }));
                });
            },
            error: function (xhr, status, error) {
                console.error('Error fetching Warehouse:', error);
            }
        });

        $('#createPurchaseModal').modal('toggle');
    });


    $('#purchaseForm').validate({
        rules: {
            supplier_id: {
                required: true
            },warehouse_id: {
                required: true
            },purchase_category_id: {
                required: true
            },unit_id: {
                required: true
            },date: {
                required: true
            },tax_rate: {
                required: true
            },payment_statut: {
                required: true
            },notes: {
                required: true
            }
        },
        submitHandler: function (form) {
            $("#response").empty();
            const formData = $(form).serializeArray();
            $.ajax({
                type: "POST",
                url: "/purchases",
                data: formData,
                dataType: "json",
                success: function (response, status, xhr) {
                    $(form).trigger('reset');
                    $('#createPurchaseModal').modal('toggle');
                    if (xhr.status === 201) {
                        toastr.success(response.message);
                        const newRowData = [
                            response.purchase.id,
                            response.purchase.date.split(' ')[0],
                            response.purchase.grand_total,
                            response.purchase.paid_amount,
                            response.purchase.due_amount,

                            '<a href="javascript:void(0)" class="btn btn-success viewPurchase" data-id="' + response.purchase.id + '"><i class="fas fa-eye"></i></a>' +
                            '<a href="javascript:void(0)" class="btn btn-success editPurchase" data-id="' + response.purchase.id + '"><i class="fas fa-pen-to-square"></i></a>' +
                            '<a href="javascript:void(0)" class="btn btn-danger deletePurchase" data-id="' + response.purchase.id + '"><i class="fas fa-trash-can"></i></a>'
                        ];
                        $('#purchaseTable').DataTable().row.add(newRowData).draw(false);
                    } else if (xhr.status === 409) {
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


    $('#purchaseTable').on('click', '.viewPurchase', function () {
        var purchaseId = $(this).data('id');
        $.ajax({
            type: 'GET',
            url: '/purchases/' + purchaseId,
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {

                    var purchase = response.purchase;
                    $('#viewPurchaseModal input, #viewPurchaseModal textarea').prop('disabled', true);
                    $('#viewPurchaseModal #user_name').text(purchase.user_name);
                    $('#viewPurchaseModal #supplier_id').val(purchase.supplier_shop);
                    $('#viewPurchaseModal #warehouse_id').val(purchase.warehouse_name);
                    $('#viewPurchaseModal #purchase_category_id').val(purchase.purchase_cat_name);
                    $('#viewPurchaseModal #unit_id').val(purchase.unit_name);
                    $('#viewPurchaseModal #purchase_qty').val(purchase.purchase_qty);
                    $('#viewPurchaseModal #date').val(purchase.date);
                    $('#viewPurchaseModal #tax_rate').val(purchase.tax_rate);
                    $('#viewPurchaseModal #payment_statut').val(purchase.payment_statut ===0 ? 'Full Paid' : 'Partial');
                    $('#viewPurchaseModal #grand_total').val(purchase.grand_total);
                    $('#viewPurchaseModal #paid_amount').val(purchase.paid_amount);
                    $('#viewPurchaseModal #discount').val(purchase.discount);
                    $('#viewPurchaseModal #due_amount').val(purchase.due_amount);
                    $('#viewPurchaseModal #shipping_cost').val(purchase.shipping_cost);
                    $('#viewPurchaseModal #notes').val(purchase.notes);
                    

                    $('#viewPurchaseModal').modal('toggle');

                    $('#printPurchase').click(function () {
                        window.print();
                    });

                } else {
                    toastr.error(response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('An error occurred while fetching employee data.');
                console.error('Error:', xhr.responseText);
                toastr.error('An error occurred while fetching employee data.');
            }
        });
    });


    $("#purchaseTable").on('click', '.editPurchase', function () {
        var purchaseId = $(this).data('id'); 
    
        $.ajax({
            type: 'GET',
            url: '/purchases/' + purchaseId + '/edit',
            dataType: 'json',
            success: function(response) {
                $('editPurchaseModal #supplier_id').val(response.purchase.supplier_id);
                $('editPurchaseModal #warehouse_id').val(response.purchase.warehouse_id);
                $('editPurchaseModal #purchase_category_id').val(response.purchase.purchase_category_id);
                $('editPurchaseModal #unit_id').val(response.purchase.unit_id);
                
                $('#editPurchaseModal').modal('toggle');
            },
            error: function(xhr, status, error) {
                console.error('Error fetching purchase data:', error);
            }
        });
        
    });
            
    
    



    

    $("#purchaseTable").on("click", ".deletePurchase", function () {
        var purchaseId = $(this).data('id');
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
                    url: `/purchases/${purchaseId}`,
                    dataType: "json",
                    success: function (response) {
                        if (response.status === 'success') {
                            purchaseTable.row($(`#purchase_${purchaseId}`).closest('tr')).remove().draw(false);
                            toastr.success(response.message);
                        } else if (response.status === 'failed') {
                            toastr.error(response.message);
                        }
                    },
                    error: function (xhr) {
                        toastr.error('An error occurred while deleting the Employee.');
                    }
                });
            }
        });
    });

    


});