<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-9">
                        <h2>Product Units</h2>
                    </div>
                    <div class="col-md-3 text-end">
                        <a href="javascript:void(0)" class="btn btn-primary" id="productUnitCreate">Add New Product Unit</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle table-bordered" id="unitTable">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Unit Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productUnits as $item)
                                <tr id="unit_{{$item->id}}">
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->unit_name}}</td>
                                    
                                    <td>
                                        <a href="javascript:void(0)" class="btn btn-primary editunit" data-id="{{$item->id}}"><i class="fa-solid fa-pen-to-square"></i></a>
                                        
                                        <a href="javascript:void(0)" class="btn btn-danger deleteunit" data-id="{{$item->id}}"><i class="fa-solid fa-trash-can"></i></a>
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