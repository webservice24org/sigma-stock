<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-9">
                        <h2>HRM Departments</h2>
                    </div>
                    <div class="col-md-3 text-end">
                        <a href="javascript:void(0)" class="btn btn-primary" id="departmentCreate">Add New Department</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle table-bordered" id="departmentTable">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Created By</th>
                                <th>Department Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($departments as $item)
                                <tr id="department_{{$item->id}}">
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->user->name}}</td>
                                    <td>{{$item->department_name}}</td>
                                    
                                    <td>
                                        <a href="javascript:void(0)" class="btn btn-primary editDepartment" data-id="{{$item->id}}"><i class="fa-solid fa-pen-to-square"></i></a>
                                        
                                        <a href="javascript:void(0)" class="btn btn-danger deleteDepartment" data-id="{{$item->id}}"><i class="fa-solid fa-trash-can"></i></a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>