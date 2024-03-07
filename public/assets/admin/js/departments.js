$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
$(document).ready(function () {    

    const dataTable = $("#depTable").DataTable({
        
    });
    
   //const dataTable = $("#todoTable").dataTable();

    //Create Todo
  $("#createDep").click(function () {
    $("#depModal #department_name").val("");
    $("#depForm input").removeAttr("disabled", true);
    $("#depForm button[type=submit]").removeClass("d-none");
    $("#depForm #depTitle").text("Department Edit");
    $("#depForm").attr("action", `${baseUrl}/departments`); 
    $("#hidden-dep-id").remove();
    $("#depModal").modal("toggle");
  });

  $("#depForm").validate({
      rules: {
            department_name: {
            required: true,
            minlength: 3
        }
      },
      messages: {
            department_name: {
            required: "Please enter Department Name",
            minlength: jQuery.validator.format("At least {0} characters required!")
          }
      },
      submitHandler: function (form) {
            $("#response").empty();
          const formData = $(form).serializeArray();

          const depId = $("#hidden-dep-id").val();
          const methodType = depId && 'PUT' || 'POST';
          const formAction = $(form).attr("action");
          $.ajax({
              url: formAction,
              type: methodType,
              data: formData,
              beforeSend: function () {
                  //console.log('loading....');
                 // showLoader();
              },
              success: function (response) {
                
                $("#depForm")[0].reset();
                $("#depModal").modal("toggle");
            
                if (response.status === 'success') {
                    toastr.success(response.message);
            
                    
                    if (depId) {
                        $(`#dep_${depId} td:nth-child(3)`).html(response.dep.department_name);
                    }
                    else{
                        const newRowData =
                            `<tr id="dep_${response.dep.id}">
                                <td>
                                    <input type="checkbox" name="chaeckDeps" id="chaeckDeps" class="form-check-input dep-checkbox" value="${response.dep.id}">
                                </td>
                                <td>${response.dep.id}</td>
                                <td>${response.dep.department_name}</td>
                                <td>
                                    <a href="javascript:void(0)" class="btn btn-primary btn-sm btnDepview" data-id=${response.dep.id}>View</a>
                                    <a href="javascript:void(0)" class="btn btn-success btn-sm btnDepedit" data-id=${response.dep.id}>Edit</a>
                                    <a href="javascript:void(0)" class="btn btn-danger btn-sm btnDepdelete" data-id=${response.dep.id}>Delete</a>
                                </td>
                            </tr>`;
                            depTable.row.add($(newRowData)).draw(false);
                    }
                } 
                else if (response.status === 'failed') {
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

 
});
