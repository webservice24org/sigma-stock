@extends('layouts.admin-master')
@section('admin')
    @include('admin-components.purchase-categories.index')
    @include('admin-components.purchase-categories.create')
    @include('admin-components.purchase-categories.edit')
    
@endsection