@extends('layouts.admin-master')
@section('admin')
  <div class="row">
    <div class="col-md-12 col-sm-12">
      <div class="card text-start">
        <div class="card-header">
          <h2>create quotation</h2>
        </div>
        <div class="card-body">
          <form action="{{ route('quotations.update', ['quotation' => $quotation->id]) }}" method="PUT">
          @csrf
          @method('PUT') 
          <div class="row">
            <div class="col-md-4 col-sm-12">
                <div class="form-group mb-2">
                    <label for="date" class="pb-2">Quotation Date</label>
                    <input type="date" class="form-control" id="date" value="{{$quotation->date}}" name="date" required>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="form-group mb-2">
                    <label for="customer_id" class="pb-2">Select Customer</label>
                    <select name="customer_id" id="customer_id" class="form-select" required>
                        <option value="disabled">Select Customer</option>
                        @foreach($customers as $item)
                            
                            <option class="form-control" value="{{$item->id}}" {{$item->id == $quotation->customer_id ? 'selected': ''}}>{{ $item->user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="form-group mb-2">
                    <label for="warehouse_id" class="pb-2">Select Warehouse</label>
                    <select name="warehouse_id" id="warehouse_id" class="form-select" required>
                        <option value="" disabled selected>Select Warehouse</option>
                        @foreach($warehouses as $item)
                            
                            <option class="form-control" value="{{$item->id}}" {{$item->id == $quotation->warehouse_id ? 'selected': ''}}>{{ $item->warehouse_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
          </div>
            <div class="row mb-3">
              <div class="col-md-4 col-sm-12">
                <div class="form-group mb-2">
                  <label for="product_id" class="pb-2">Select Product</label>
                  <select name="product_id" id="product_id" class="form-select" required>
                    <option value="" disabled selected>Select Products</option>
                      @foreach($products as $item)
                      <option value="{{$item->id}}" class="form-control">{{$item->name}}</option>
                        <option class="form-control" value="{{$item->id}}" {{$item->id == $quotation->product_id ? 'selected': ''}}>{{ $item->name }}</option>
                      @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-4 col-sm-12">
                <div class="form-group mb-2">
                  <label for="total_amount" class="pb-2">Total Amount</label>
                  <input type="number" class="form-control" name="total_amount" id="total_amount" value="{{$quotation->total_amount}}" required>
                </div>
              </div>
              <div class="col-md-4 col-sm-12">
                <div class="form-group mb-2">
                  <label for="shipping_amount" class="pb-2">Shipping Cost</label>
                  <input type="number" class="form-control" name="shipping_amount" id="shipping_amount" value="{{$quotation->shipping_amount}}" required>
                </div>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-4 col-sm-12">
                <div class="form-group mb-2">
                  <label for="tax_percentage" class="pb-2">Tax percentage</label>
                  <input type="number" class="form-control" name="tax_percentage" id="tax_percentage" value="{{$quotation->tax_percentage}}" required>
                </div>
              </div>
              <div class="col-md-4 col-sm-12">
                <div class="form-group mb-2">
                  <label for="discount" class="pb-2">Discount</label>
                  <input type="number" class="form-control" name="discount" id="discount" value="{{$quotation->discount}}" required>
                </div>
              </div>
              <div class="col-md-4 col-sm-12">
                
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-12 col-sm-12">
                <label for="note">Note</label>
                <textarea name="note" id="note" cols="30" rows="10" class="form-control">{{$quotation->note}}</textarea>
              </div>
            </div>

            <div class="form-group">
              <input type="submit" class="btn btn-success" value="Submit">
            </div>
          </form>
        </div>
      </div>
      
    </div>
  </div>
@endsection