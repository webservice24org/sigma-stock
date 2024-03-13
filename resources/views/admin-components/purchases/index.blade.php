<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-9">
                        <h2>Purchase list</h2>
                    </div>
                    <div class="col-md-3 text-end">
                        <a href="javascript:void(0)" class="btn btn-primary" id="addPurchase">Add New Purchase</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle table-bordered" id="purchaseTable">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Purchase Date</th>
                                <th>Payment Status</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($purchases as $item)
                                <tr id="purchase_{{$item->id}}">
                                    <td>{{$item->id}}</td>
                                    <td>{{ date('d-m-Y', strtotime($item->date)) }}</td>
                                    <td>{{$item->payment_statut}}</td>
                                    <td>
                                        @if ($item->status == 0)
                                            <span class="badge bg-danger">Pending</span>
                                        @else
                                            <span class="badge bg-success">Approved</span>
                                        @endif
                                    </td>
                                    
                                    <td>
                                        <a href="javascript:void(0)" class="btn btn-success viewPurchase" data-id="{{$item->id}}"><i class="fa-solid fa-eye"></i></a>
                                        <a href="javascript:void(0)" class="btn btn-primary editPurchase" data-id="{{$item->id}}"><i class="fa-solid fa-pen-to-square"></i></a>
                                        @if ($item->status == 0)
                                        <a href="javascript:void(0)" class="btn btn-warning statusPurchase" data-id="{{$item->id}}"><i class="fa-solid fa-lock"></i></a>
                                        @else
                                        <a href="javascript:void(0)" class="btn btn-success statusPurchase" data-id="{{$item->id}}"><i class="fa-solid fa-lock-open"></i></a>
                                        @endif
                                        <a href="javascript:void(0)" class="btn btn-danger deletePurchase" data-id="{{$item->id}}"><i class="fa-solid fa-trash-can"></i></a>
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