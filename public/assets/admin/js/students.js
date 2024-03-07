$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });
    const studentTable = $("#studentTable").DataTable({});
    $("#addNewStudent").on('click', function () {
        $("#studantModal").modal("toggle");
    });

    $("#studentForm").validate({
        rules:{
            name: {
                required: true,
                minlength: 3
            },
            email:{
                required: true,
                email: true
            },
            phone:{
                required: true,
                minlength: 11
            }
        },
        messages:{
            name:{
              required: "Please enter name of student",
              minlength: jQuery.validator.format("At least {0} characters required!")
            },
            email:{
              required: "Please enter a valid email",
            },
            phone:{
                required: "Please enter a valid phone number",
                minlength: jQuery.validator.format("At least {0} characters required!")
            }
        }, 
        submitHandler: function(form) {
            $("#response").empty();
            const formData = $(form).serializeArray();
            $.ajax({
                type: "POST",
                url: "/students",
                data: formData,
                dataType: "json",
                success: function(response) {
                    $("#studantModal").modal("toggle");
                    $(form).trigger('reset');
                    if (response.status === 'success') {
                        toastr.success(response.message);
                        const newRowData = [
                            response.student.id,
                            response.student.name,
                            response.student.email,
                            response.student.phone,
                            `<a href="javascript:void(0)" class="btn btn-success editStudent" data-id="${response.student.id}}">Edit</a>
                             <a href="javascript:void(0)" class="btn btn-danger deleteStudent" data-id="${response.student.id}}">Delete</a>`
                        ];
                        studentTable.row.add(newRowData).draw(false);
                    } else if (response.status === 'failed') {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        toastr.error(xhr.responseJSON.message);
                    } else {
                        toastr.error('An error occurred while processing your request.');
                    }
                }
                
            });
        }
        
    });

    $("#studentTable").on("click", ".editStudent", function() {
        var studentId = $(this).data("id");
        $.ajax({
            type: "GET",
            url: `/students/${studentId}/edit`,
            dataType: "json",
            success: function(response) {
                if (response.status === 'success') {
                    $("#studantEditModal #name").val(response.student.name);
                    $("#studantEditModal #email").val(response.student.email);
                    $("#studantEditModal #phone").val(response.student.phone);
    
                    $("#studentId").val(studentId);
                    $("#studantEditModal").modal("toggle");
                } else {
                    toastr.error('Failed to fetch student details.');
                }
            },
            error: function(xhr, status, error) {
                toastr.error('An error occurred while fetching student details.');
            }
        });
    });
    

    $("#updateStudentForm").validate({
        rules:{
            name: {
                required: true,
                minlength: 3
            },
            email:{
                required: true,
                email: true
            },
            phone:{
                required: true,
                minlength: 11
            }
        },
        messages:{
            name:{
              required: "Please enter name of student",
              minlength: jQuery.validator.format("At least {0} characters required!")
            },
            email:{
              required: "Please enter a valid email",
            },
            phone:{
                required: "Please enter a valid phone number",
                minlength: jQuery.validator.format("At least {0} characters required!")
            }
        }, 
        submitHandler: function(form) {
            $("#response").empty();
            const formData = $(form).serializeArray();
            const studentId = $("#studentId").val();
            
            $.ajax({
                type: "PUT",
                url: `/students/${studentId}`, 
                data: formData,
                dataType: "json",
                success: function(response) {
                    $("#studantEditModal").modal("toggle");
                    if (response.status === 'success') {
                        toastr.success(response.message);
                        $(`#student_${studentId} td:nth-child(2)`).html(response.student.name);
                        $(`#student_${studentId} td:nth-child(3)`).html(response.student.email);
                        $(`#student_${studentId} td:nth-child(4)`).html(response.student.phone);
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
    
    $("#studentTable").on("click", ".deleteStudent", function() {
        var studentId = $(this).data("id");
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: `/students/${studentId}`,
                    dataType: "json",
                    success: function(response) {
                        if (response.status === 'success') {
                            const rowIndex = studentTable.row($(`#student_${response.student.id}`)).index();
                            studentTable.row(rowIndex).remove().draw();
                            toastr.success(response.message);
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        toastr.error('An error occurred while deleting the student.');
                    }
                });
            }
        });
    });
    
    
});