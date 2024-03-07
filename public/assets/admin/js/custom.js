$.ajaxSetup({
  headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

$(document).ready(function () {

    function showLoader() {
        $('#loader').removeClass('d-none');
    }
    
    function hideLoader() {
        $('#loader').addClass('d-none');
    }
    

    const dataTable = $("#todoTable").DataTable({
        
    });
    
   //const dataTable = $("#todoTable").dataTable();

    //Create Todo
  $("#createTodo").click(function () {
    $("#todoCreate #title").val("");
    $("#todoCreate #description").val("");
    $("#todoForm input, #todoForm textarea").removeAttr("disabled", true);
    $("#todoForm button[type=submit]").removeClass("d-none");
    $("#todoForm #createTodoTitle").text("Todo Edit");
    $("#todoForm").attr("action", `${baseUrl}/todos`); 
    $("#hidden-todo-id").remove();
    $("#todoCreate").modal("toggle");
  });

  $("#todoForm").validate({
      rules: {
          title: {
              required: true,
              minlength: 3
          },
          description: {
              required: true,
              minlength: 5
          }
      },
      messages: {
          title: {
              required: "Please enter what you want to do",
              minlength: jQuery.validator.format("At least {0} characters required!")
          },
          description: {
              required: "Please enter Todo Description",
              minlength: jQuery.validator.format("At least {0} characters required!")
          }
      },
      submitHandler: function (form) {
            $("#response").empty();
          const formData = $(form).serializeArray();

          const todoId = $("#hidden-todo-id").val();
          const methodType = todoId && 'PUT' || 'POST';
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
                
                $("#todoForm")[0].reset();
                $("#todoCreate").modal("toggle");
            
                if (response.status === 'success') {
                    toastr.success(response.message);
            
                    
                    if (todoId) {
                        $(`#todo_${todoId} td:nth-child(3)`).html(response.todo.title);
                        $(`#todo_${todoId} td:nth-child(4)`).html(response.todo.description);
                    }
                    else{
                        const newRowData =
                            `<tr id="todo_${response.todo.id}">
                                <td>
                                    <input type="checkbox" name="checkAll" id="chaeckAll" class="form-check-input todo-checkbox" value="${response.todo.id}">
                                </td>
                                <td>${response.todo.id}</td>
                                <td>${response.todo.title}</td>
                                <td>${response.todo.description}</td>
                                <td>${response.todo.is_completed ? 'yes' : 'no'}</td>
                                <td>
                                    <a href="javascript:void(0)" class="btn btn-primary btn-sm btn-view" data-id=${response.todo.id}>View</a>
                                    <a href="javascript:void(0)" class="btn btn-success btn-sm btn-edit" data-id=${response.todo.id}>Edit</a>
                                    <a href="javascript:void(0)" class="btn btn-danger btn-sm btn-delete" data-id=${response.todo.id}>Delete</a>
                                </td>
                            </tr>`;
                            dataTable.row.add($(newRowData)).draw(false);
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

    //View Todo
    $("#todoTable").on("click", ".btn-view", function() {
        const todoId = $(this).data("id");
        const mode = "view";
        todoId && fetchTodo(todoId, mode);
    });

    function fetchTodo(todoId, mode=null) {
        //showLoader();
        if (todoId) {
            $.ajax({
                url: `todos/${todoId}`,
                type: "GET",
                success: function(response) {
                    if (response.status==="success") {
                        const todo = response.todo;

                        $("#todoCreate #title").val(todo.title);
                        $("#todoCreate #description").val(todo.description);

                        if (mode==="view") {
                            $("#todoForm input, #todoForm textarea").attr("disabled", true);
                            $("#todoForm button[type=submit]").addClass("d-none");
                            $("#todoForm #createTodoTitle").text("Todo Details");
                            $("#todoForm").removeAttr("action");
                        }else if (mode==="edit") {
                            $("#todoForm input, #todoForm textarea").removeAttr("disabled", true);
                            $("#todoForm button[type=submit]").removeClass("d-none");
                            $("#todoForm #createTodoTitle").text("Todo Edit");
                            $("#todoForm").attr("action", `${baseUrl}/todos/${todo.id}`); 
                            $("#todoForm").append(`<input type="hidden" id="hidden-todo-id" value="${todo.id}">`); 
                        }

                        $("#todoCreate").modal("toggle");
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

    //Edit Todo
    $("#todoTable").on("click", ".btn-edit", function() {
        const todoId = $(this).data("id");
        const mode = "edit";
        todoId && fetchTodo(todoId, mode);
    });

    //Delete Todo
    $("#todoTable tbody").on("click", ".btn-delete", function () {
        const todoId = $(this).data("id");
        const buttonObj = $(this);
    
        if (todoId) {
    
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
                        url: `todos/${todoId}`,
                        type: "DELETE",
                        success: function (response) {
                            if (response.status === "success") {
                                if (response.todo) {
                                    const rowIndex = dataTable.row($(`#todo_${response.todo.id}`)).index();
                                    dataTable.row(rowIndex).remove().draw();
    
                                    Swal.fire({
                                        title: "Deleted!",
                                        text: "Todo has been deleted.",
                                        icon: "success",
                                        timer: 1500,
                                    });
                                }
                            } else {
                                Swal.fire({
                                    title: "Failed!",
                                    text: "Unable to delete Todo!",
                                    icon: "error",
                                });
                            }
                        },
                        error: function (error) {
                            Swal.fire({
                                title: "Failed!",
                                text: "Unable to delete Todo!",
                                icon: "error",
                            });
                        },
                    });
                }
            });
        }
    });
    

    //Bulk select
    $("#selectAll").on("click", function(){
        const checkboxes = $("tbody input[type='checkbox']");
        checkboxes.prop("checked", $(this).prop("checked"));

        if ($(this).prop("checked")) {
            $("#markCompleted").removeClass("d-none");
            $("#bulkDelete").removeClass("d-none");
        }
        else{
            $("#markCompleted").addClass("d-none");
            $("#bulkDelete").addClass("d-none");
        }
    });

    $("#markCompleted").on("click", function() {
        let selectedTodos = [];

        $(".todo-checkbox:checked").each(function() {
            selectedTodos.push($(this).val());
        });

        if (selectedTodos.length > 0) {
            $.ajax({
                url: "todos/mark-completed",
                type: "POST",
                data: {
                    todoIds: selectedTodos
                },
                success: function(response) {
                   if (response.status === "success") {
                        const todos = response.todos;

                        $.each(todos, function(index, todo) {
                            $(`#todo_${todo.id} td:nth-child(5)`).html( todo.is_completed ? 'Yes' : 'No' );
                        });

                        Swal.fire({
                            title: "Updated!",
                            text: "Todo has been marked as completed.",
                            icon: "success",
                            timer: 1500,
                        });
                   }

                   else {
                    Swal.fire({
                        title: "Failed!",
                        text: "Unable to mark as completed.",
                        icon: "error",
                        timer: 1500,
                    });
                   }
                },
                error: function(error) {
                    Swal.fire({
                        title: "Failed!",
                        text: "Something went wrong!.",
                        icon: "error",
                        timer: 1500,
                    });
                }
            });
        }
    });

    //Bulk Deleted
    $("#bulkDelete").on("click", function() {
        let selectedTodos = [];

        $(".todo-checkbox:checked").each(function() {
            selectedTodos.push($(this).val());
        });

        $.ajax({
            url: "todos/bulk-delete",
            type: "POST",
            data: {
                todoIds: selectedTodos
            },
            success: function(response) {
                if (response.status === "success") {

                    $(".todo-checkbox:checked").each(function() {
                        dataTable.row($(this).parents('tr')).remove().draw();
                    });

                    Swal.fire({
                        title: "Success!",
                        text: response.message,
                        icon: "success",
                        timer: 1500,
                    });

                    $("#markCompleted").addClass("d-none");
                    $("#bulkDelete").addClass("d-none");
                }
                else {
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
                    text: "Unable to delete todos.",
                    icon: "error",
                    timer: 1500,
                });
            }
        })
    });

    //Toaster body customization
    toastr.options = {
        closeButton: true, 
        progressBar: true,
        positionClass: 'toast-top-right',
        showDuration: 300,
        hideDuration: 1000,
        timeOut: 5000,
        extendedTimeOut: 1000,
        showEasing: 'swing',
        hideEasing: 'linear',
        showMethod: 'fadeIn',
        hideMethod: 'fadeOut',
        tapToDismiss: false
    };

    //Create News Category

    const categoryTable = $("#categoryTable").DataTable();
    $("#categoryCreate").click(function () {
        $("#CreateNewsCats #category_name").val("");
        $("#CreateNewsCats #category_desc").val("");
        $("#categoryForm input, #categoryForm textarea").removeAttr("disabled");
        $("#categoryForm button[type=submit]").removeClass("d-none");
        $("#categoryForm #CatTitle").text("Create News Category");
        $("#categoryForm").attr("action", `${baseUrl}/categories`);
        $("#hidden-category-id").remove();
        $("#CreateNewsCats").modal("toggle");
    });

    $("#categoryForm").validate({
        rules: {
            category_name: {
                required: true,
                minlength: 3
            }
        },
        messages: {
            category_name: {
                required: "Please enter Category Name",
                minlength: jQuery.validator.format("At least {0} characters required!")
            }
        },
        submitHandler: function (form) {
            $("#response").empty();
            const catData = $(form).serializeArray();

            const catId = $("#hidden-category-id").val();
            const methodType = catId ? "PUT" : "POST"; 
            const formAction = $(form).attr("action");
            $.ajax({
                url: formAction,
                type: methodType,
                data: catData,
                beforeSend: function () {
                    //console.log('loading....');
                    //showLoader();
                },
                success: function(response) {
                    $("#categoryForm")[0].reset();
                    $("#CreateNewsCats").modal("toggle");
                    if (response.status === 'success') {
                        toastr.success(response.message);
                
                        if (response.category) {
                            const category = response.category;
                            const categoryId = category.id;
                            const categoryRow = $(`#category_${categoryId}`);
                
                            if (categoryRow.length) {
                                categoryRow.find('td:nth-child(3)').text(category.category_name);
                                categoryRow.find('td:nth-child(4)').text(category.category_desc);
                            } else {
                                categoryTable.row.add([
                                    `<input type="checkbox" name="checkAllCats" id="checkAllCats_${categoryId}" class="form-check-input category-checkbox" value="${categoryId}">`,
                                    categoryId,
                                    category.category_name,
                                    category.category_desc,
                                    `<td>
                                        <a href="javascript:void(0)" class="btn btn-primary btn-sm btnCatView" data-id="${categoryId}">View</a>
                                        <a href="javascript:void(0)" class="btn btn-success btn-sm btnCatEdit" data-id="${categoryId}">Edit</a>
                                        <a href="javascript:void(0)" class="btn btn-danger btn-sm btnCatDelete" data-id="${categoryId}">Delete</a>
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


    //View news Category
    $("#categoryTable").on("click", ".btnCatView", function() {
        const catId = $(this).data("id");
        const mode = "view";
        catId && fetchCategory(catId, mode);
    });
    function fetchCategory(catId, mode=null) { 
        //showLoader();
        if (catId) {
            $.ajax({
                url: `categories/${catId}`,
                type: "GET", 
                success: function(response){
                    if (response.status==="success") {
                        const category = response.category;

                        $("#CreateNewsCats #category_name").val(category.category_name)
                        $("#CreateNewsCats #category_desc").val(category.category_desc)

                        if (mode==="view") {
                            $("#categoryForm input, #categoryForm textarea").attr("disabled", true);
                            $("#categoryForm button[type=submit]").addClass("d-none");
                            $("#categoryForm #CatTitle").text("News Category Details");
                            $("#categoryForm").removeAttr("action");
                        }else if (mode==="edit") {
                            $("#categoryForm input, #categoryForm textarea").removeAttr("disabled");
                            $("#categoryForm button[type=submit]").removeClass("d-none");
                            $("#categoryForm #CatTitle").text("Edit News Category Details");
                            $("#categoryForm").attr("action", `${baseUrl}/categories/${category.id}`);
                            $("#categoryForm").append(`<input type="hidden" id="hidden-category-id" value="${category.id}">`); 
                        }

                        $("#CreateNewsCats").modal("toggle");
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
    }

    $("#categoryTable").on("click", ".btnCatEdit", function() {
        const catId = $(this).data("id");
        const mode = "edit";
        catId && fetchCategory(catId, mode);
    });

    //Delete Todo
    $("#categoryTable").on("click", ".btnCatDelete", function () {
        const catId = $(this).data("id");
        const buttonObj = $(this);
    
        if (catId) {
    
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
                        url: `categories/${catId}`,
                        type: "DELETE",
                        success: function (response) {
                            if (response.status === "success") {
                                if (response.category) {
                                    const rowIndex = categoryTable.row($(`#category_${response.category.id}`)).index();
                                    categoryTable.row(rowIndex).remove().draw();
    
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
    $("#selectAllCats").on("click", function(){
        const checkboxes = $("#categoryTable tbody input[type='checkbox']");
        checkboxes.prop("checked", $(this).prop("checked"));

        if ($(this).prop("checked")) {
            $("#bulkCatDelete").removeClass("d-none");
        }
        else{
            $("#bulkCatDelete").addClass("d-none");
        }
    });

    //Bulk Deleted
    $("#bulkCatDelete").on("click", function() {
        let selectedCats = [];

        $(".category-checkbox:checked").each(function() {
            selectedCats.push($(this).val());
        });
        Swal.fire({
            title: "Are you sure?",
            text: "This action will delete selected categories. Continue?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete!",
        }).then((result) => {
            if (result.isConfirmed) {
                // If user confirms, proceed with bulk delete action
                $.ajax({
                    url: "categories/bulk-delete",
                    type: "POST",
                    data: {
                        categoryIds: selectedCats
                    },
                    success: function(response) {
                        if (response.status === "success") {

                            $(".category-checkbox:checked").each(function() {
                                categoryTable.row($(this).parents('tr')).remove().draw();
                            });

                            Swal.fire({
                                title: "Success!",
                                text: response.message,
                                icon: "success",
                                timer: 1500,
                            });

                            $("#bulkCatDelete").addClass("d-none");
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
