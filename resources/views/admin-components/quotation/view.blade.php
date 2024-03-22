@extends('layouts.admin-master')
@section('admin')
<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="col-md-6 col-sm-12">
        {{$quotation->user->name}} <br>
        {{$quotation->date}} <br>
        {{$quotation->customer->user->name}} <br>
        {{$quotation->warehouse->warehouse_name}} <br>
        {{$quotation->tax_percentage}} <br>
        {{$quotation->discount}} <br>
        {{$quotation->shipping_amount}} <br>
        {{$quotation->total_amount}} <br>
        {{$quotation->product_id }} <br>
        {{$quotation->note }} <br>
      </div>
    </div>
    
  </div>
</div>

@endsection