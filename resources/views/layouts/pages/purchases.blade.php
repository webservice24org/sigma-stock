@extends('layouts.admin-master')
@section('admin')
    @include('admin-components.purchases.index')
    @include('admin-components.purchases.create')
    @include('admin-components.purchases.view')
    @include('admin-components.purchases.edit')
    
@endsection