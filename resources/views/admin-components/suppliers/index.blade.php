<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-9">
                        <h2>All Product Suppliers <small>from whom we buy raw materials</small></h2>
                    </div>
                    <div class="col-md-3 text-end">
                        <a href="javascript:void(0)" class="btn btn-primary" id="supplierCreate">Create Supplier</a>

                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle table-bordered" id="supplierTable">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Shop Name</th>
                                <th>Trade License</th>
                                <th>Business Phone</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($suppliers as $item)
                                <tr id="supplier_{{$item->id}}">
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->shopname}}</td>
                                    <td>{{$item->trade_license}}</td>
                                    <td>{{$item->business_phone}}</td>
                                    <td>
                                        @if ($item->status == 0)
                                            <span class="badge bg-warning">Pending</span>
                                        @else
                                            <span class="badge bg-success">Approved</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)" class="btn btn-success viewSupplier" data-id="{{$item->id}}">View</a>
                                        <a href="javascript:void(0)" class="btn btn-success editSupplier" data-id="{{$item->id}}">Edit</a>
                                        <a href="javascript:void(0)" class="btn btn-success statusSupplier" data-id="{{$item->id}}">Status</a>
                                        <a href="javascript:void(0)" class="btn btn-danger deleteSupplier" data-id="{{$item->id}}">Delete</a>
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