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
                                <th>Total Amount</th>
                                <th>Paid Amount</th>
                                <th>Due Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($purchases as $item)
                                <tr id="purchase_{{$item->id}}">
                                    <td>{{$item->id}}</td>
                                    <td>{{ date('d-m-Y', strtotime($item->date)) }}</td>
                                    <td>{{$item->grand_total}}</td>
                                    <td>{{$item->paid_amount}}</td>
                                    <td>{{$item->due_amount}}</td>
                                    
                                    <td>
                                        <a href="javascript:void(0)" class="btn btn-success viewPurchase" data-id="{{$item->id}}"><i class="fa-solid fa-eye"></i></a>
                                        <a href="javascript:void(0)" class="btn btn-primary editPurchase" data-id="{{$item->id}}"><i class="fa-solid fa-pen-to-square"></i></a>
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