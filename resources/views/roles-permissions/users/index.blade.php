@extends('layouts.admin-master')
@section('title', 'Admin Dashboard || Roles')
@section('admin')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="float-start">All Roles</h2>
                    <a href="{{route('users.create')}}" class="btn btn-primary float-end">Add User</a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="userTable">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Picture</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $item)
                            <tr id="user_{{ $item->id }}">
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>
                                    <img src="{{ $item->profile_photo_path }}" alt="{{ $item->name }}" width="100" height="100">
                                </td>
                                <td>
                                    
                                    
                                    <a href="{{ route('users.edit', $item->id) }}" class="btn btn-primary">Edit</a>
                                    <a href="javascript:void(0)" class="btn btn-danger btn-sm deleteUser"
                                            data-id="{{ $item->id }}">Delete</a>
                                    
                                </td>
                            </tr>
                        @endforeach
                                                    
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    

@endsection
    
