@extends('layouts.admin-master')
@section('title', 'Admin Dashboard || Add New Role')
@section('admin')
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h2 class="float-start">Add New Role</h2>
                <a href="{{route('roles.index')}}" class="btn btn-primary float-end">Role List</a>
            </div>
            <div class="card-body">
                <form action="{{route('roles.store')}}" method="POST">
                    @csrf
                    <div class="form-group mb-2">
                        <label for="">Role Name</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                    <div class="form-group mb-2">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection