$(document).ready(function () {
    const teacherTable = $("#teacherTable").DataTable({});
    $("#addNewTeacher").on('click', function () {
        $("#teacherModal").modal('toggle');
    });
    $("#teacherForm").validate({
        rules: {
            name: {
                required: true,
                minlength: 3
            },
            email: {
                required: true,
                email: true
            },
            phone: {
                required: true,
                minlength: 11
            }
        },
        messages: {
            name: {
                required: "Please enter name of student",
                minlength: jQuery.validator.format("At least {0} characters required!")
            },
            email: {
                required: "Please enter a valid email",
            },
            phone: {
                required: "Please enter a valid phone number",
                minlength: jQuery.validator.format("At least {0} characters required!")
            }
        },
        submitHandler: function (form) {
            $("#response").empty();
            const formData = new FormData(form);
            $.ajax({
                type: "POST",
                url: "/teachers",
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function (response) {
                    $("#teacherModal").modal("toggle");
                    $(form).trigger('reset');
                    if (response.status === 'success') {
                        toastr.success(response.message);
                        const newRowData = [
                            response.teacher.id,
                            response.teacher.name,
                            response.teacher.email,
                            response.teacher.phone,
                            `<img src="/assets/admin/img/teacher/${response.teacher.photo}" alt="${response.teacher.name}" class="img-thumbnail" style="max-width: 100px; max-height: 100px;">`,
                            `<a href="javascript:void(0)" class="btn btn-success editTeacher" data-id="${response.teacher.id}">Edit</a>
                             <a href="javascript:void(0)" class="btn btn-danger deleteTeacher" data-id="${response.teacher.id}">Delete</a>`
                        ];
                        teacherTable.row.add(newRowData).draw(false);
                    } else if (response.status === 'failed') {
                        toastr.error(response.message);
                    }
                },
                error: function (xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        toastr.error(xhr.responseJSON.message);
                    } else {
                        toastr.error('An error occurred while processing your request.');
                    }
                }

            });
        }


    });
    $('#photo').change(function () {
        let reader = new FileReader();
        reader.onload = (e) => {
            $('#teacherThmb').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    });

    // Edit Teacher
    $("#teacherTable").on("click", ".editTeacher", function () {
        var teacherId = $(this).data("id");

        $.ajax({
            type: "GET",
            url: `/teachers/${teacherId}/edit`,
            dataType: "json",
            success: function (response) {
                if (response.status === 'success') {
                    $("#teacherEditModal #teacherId").val(response.teacher.id);
                    $("#teacherEditModal #name").val(response.teacher.name);
                    $("#teacherEditModal #email").val(response.teacher.email);
                    $("#teacherEditModal #phone").val(response.teacher.phone);
                    
                    if (response.teacher.photo) {
                        var photoUrl = `/assets/admin/img/teacher/${response.teacher.photo}`;
                        $("#teacherEditModal #teacherPhoto").attr("src", photoUrl);
                    } else {
                        var defaultPhotoUrl = `/assets/admin/img/teacher/default.png`;
                        $("#teacherEditModal #teacherPhoto").attr("src", defaultPhotoUrl);
                    }
                    $("#teacherId").val(teacherId);

                    $("#teacherEditModal").modal("toggle");
                } else {
                    toastr.error('Failed to fetch teacher details.');
                }
            },
            error: function (xhr, status, error) {
                toastr.error('An error occurred while fetching teacher details.');
            }
        });
    });

    $('#teacherEditModal #photo').change(function () {
        let reader = new FileReader();
        reader.onload = (e) => {
            $('#teacherPhoto').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    });

    // Update Teacher
    $('#updateTeacherForm').validate({
        rules: {
            name: {
                required: true,
                minlength: 3
            },
            email: {
                required: true,
                email: true
            },
            phone: {
                required: true,
                minlength: 11
            }
        },
        messages: {
            name: {
                required: "Please enter the teacher's name",
                minlength: jQuery.validator.format("At least {0} characters required!")
            },
            email: {
                required: "Please enter a valid email",
                email: "Please enter a valid email"
            },
            phone: {
                required: "Please enter a valid phone number",
                minlength: jQuery.validator.format("At least {0} characters required!")
            }
        },
        submitHandler: function (form) {
            var formData = new FormData(form);
            var teacherId = $('#teacherId').val();
            var currentPhoto = $('#teacherPhoto').attr('src'); // Get the current photo URL
            if ($('#photo')[0].files[0]) {
                formData.append('photo', $('#photo')[0].files[0]);
            } else {
                formData.append('current_photo', currentPhoto);
            }
            $.ajax({
                type: "POST",
                url: `/teacher/update/${teacherId}`,
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    $("#teacherEditModal").modal("toggle");
                    if (response.status === 'success') {
                        toastr.success(response.message);
                        const updatedRowData = [
                            response.teacher.id,
                            response.teacher.name,
                            response.teacher.email,
                            response.teacher.phone,
                            `<img src="/assets/admin/img/teacher/${response.teacher.photo}" alt="${response.teacher.name}" class="img-thumbnail" style="width: 100px; height: 100px;">`,
                            `<a href="javascript:void(0)" class="btn btn-success editTeacher" data-id="${response.teacher.id}">Edit</a>
                                    <a href="javascript:void(0)" class="btn btn-danger deleteTeacher" data-id="${response.teacher.id}">Delete</a>`
                        ];
                        const rowIndex = teacherTable.row(`#teacher_${response.teacher.id}`).index();
                        teacherTable.row(rowIndex).data(updatedRowData).draw(false);
                    } else if (response.status === 'failed') {
                        toastr.error(response.message);
                    }
                },
                error: function (xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        toastr.error(xhr.responseJSON.message);
                    } else {
                        toastr.error('An error occurred while processing your request.');
                    }
                }
            });
        }

    });

    //delete

    $("#teacherTable").on("click", ".deleteTeacher", function () {
        var teacherId = $(this).data("id");
    
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: `/teachers/${teacherId}`,
                    dataType: "json",
                    success: function (response) {
                        if (response.status === 'success') {
                            const rowIndex = teacherTable.row($(`#teacher_${teacherId}`)).index();
                            teacherTable.row(rowIndex).remove().draw(false);
                            
                            toastr.success(response.message);
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function (xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            toastr.error(xhr.responseJSON.message);
                        } else {
                            toastr.error('An error occurred while processing your request.');
                        }
                    }
                });
            }
        });
    });
    
    




});