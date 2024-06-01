$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {


    const roleTable = $('#roleTable').DataTable();

    $("#roleTable").on("click", ".deleteRole", function () {
        var roleId = $(this).data("id");
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to Delete this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: `/roles/${roleId}`,
                    dataType: "json",
                    success: function (response) {
                        if (response.status === 'success') {
                            roleTable.row($(`#role_${roleId}`).closest('tr')).remove().draw(false);
                            toastr.success(response.message);
                        } else if (response.status === 'failed') {
                            toastr.error(response.message);
                        }
                    },
                    error: function (xhr) {
                        toastr.error('An error occurred while deleting the Role.');
                    }
                });
            }
        });
    });



});
