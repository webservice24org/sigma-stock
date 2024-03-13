@extends('layouts.admin-master')
@section('admin')
    @include('admin-components.warehouse.index')
    @include('admin-components.warehouse.create')
    @include('admin-components.warehouse.edit')
    
@endsection