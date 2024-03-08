@extends('layouts.admin-master')
@section('admin')
    @include('admin-components.customer-categories.index')
    @include('admin-components.customer-categories.create')
    @include('admin-components.customer-categories.edit')
    
@endsection