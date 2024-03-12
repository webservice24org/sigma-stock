<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-9">
                        <h2>Employee List</h2>
                    </div>
                    <div class="col-md-3 text-end">
                        <a href="javascript:void(0)" class="btn btn-primary" id="employeeCreate">Add New Employeee</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle table-bordered" id="employeeTable">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Employee Name</th>
                                <th>Department Name</th>
                                <th>Joining Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $item)
                                <tr id="employee_{{$item->id}}">
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->user->name}}</td>
                                    <td>{{$item->department->department_name}}</td>
                                    <td>{{ date('d-m-Y', strtotime($item->joining_date)) }}</td>
                                    <td>
                                        @if ($item->status == 0)
                                            <span class="badge bg-danger">Pending</span>
                                        @else
                                            <span class="badge bg-success">Approved</span>
                                        @endif
                                    </td>
                                    
                                    <td>
                                        <a href="javascript:void(0)" class="btn btn-success viewEmployee" data-id="{{$item->id}}"><i class="fa-solid fa-eye"></i></a>
                                        <a href="javascript:void(0)" class="btn btn-primary editEmployee" data-id="{{$item->id}}"><i class="fa-solid fa-pen-to-square"></i></a>
                                        @if ($item->status == 0)
                                        <a href="javascript:void(0)" class="btn btn-warning statusEmployee" data-id="{{$item->id}}"><i class="fa-solid fa-lock"></i></a>
                                        @else
                                        <a href="javascript:void(0)" class="btn btn-success statusEmployee" data-id="{{$item->id}}"><i class="fa-solid fa-lock-open"></i></a>
                                        @endif
                                        <a href="javascript:void(0)" class="btn btn-danger deleteEmployee" data-id="{{$item->id}}"><i class="fa-solid fa-trash-can"></i></a>
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