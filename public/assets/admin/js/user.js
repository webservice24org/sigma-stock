$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {

    const userTable = $('#userTable').DataTable();

    $("#userTable").on("click", ".deleteUser", function () {
        var userId = $(this).data("id");
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
                    url: `/users/${userId}`,
                    dataType: "json",
                    success: function (response) {
                        if (response.status === 'success') {
                            // Remove the row from the table
                            $(`#user_${userId}`).closest('tr').remove();
                            // Display success message
                            Swal.fire(
                                'Deleted!',
                                response.message,
                                'success'
                            );
                        } else if (response.status === 'failed') {
                            // Display error message
                            Swal.fire(
                                'Failed!',
                                response.message,
                                'error'
                            );
                        }
                    },
                    error: function (xhr) {
                        // Display error message
                        Swal.fire(
                            'Error!',
                            'An error occurred while deleting the User.',
                            'error'
                        );
                    }
                });
            }
        });
    });

    $('#profile_photo_path').change(function() {
        var input = this;

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#picturePreView').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    });

    document.getElementById('logoutLink').addEventListener('click', function() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You will be logged out of your account!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, log out!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Perform logout via AJAX
                fetch("{{ route('logout') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        _method: 'POST'
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        window.location.href = "{{ route('login') }}";
                        Swal.fire('Logged Out!', data.message, 'success');
                    } else {
                        Swal.fire('Error!', data.message, 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Error!', 'An error occurred while logging out.', 'error');
                });
            }
        });
    });

});
