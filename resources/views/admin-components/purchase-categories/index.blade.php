<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-9">
                        <h2>Purchase categories</h2>
                    </div>
                    <div class="col-md-3 text-end">
                        <a href="javascript:void(0)" class="btn btn-primary" id="purchaseCategoryCreate">Add New Purchase Category</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle table-bordered" id="purchaseCategoryTable">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Category Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($purchaseCates as $item)
                                <tr id="PurchaseCat_{{$item->id}}">
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->purchase_cat_name}}</td>
                                    
                                    <td>
                                        <a href="javascript:void(0)" class="btn btn-primary editPurchaseCat" data-id="{{$item->id}}"><i class="fa-solid fa-pen-to-square"></i></a>
                                        
                                        <a href="javascript:void(0)" class="btn btn-danger deletePurchaseCat" data-id="{{$item->id}}"><i class="fa-solid fa-trash-can"></i></a>
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