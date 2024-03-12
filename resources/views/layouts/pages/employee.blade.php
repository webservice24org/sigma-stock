@extends('layouts.admin-master')
@section('admin')
    @include('admin-components.employee.index')
    @include('admin-components.employee.create')
    @include('admin-components.employee.edit')
    
@endsection