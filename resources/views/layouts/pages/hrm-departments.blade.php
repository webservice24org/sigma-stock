@extends('layouts.admin-master')
@section('admin')
    @include('admin-components.hrm-departments.index')
    @include('admin-components.hrm-departments.create')
    @include('admin-components.hrm-departments.edit')
    
@endsection