@extends('layouts.admin-master')
@section('title', 'Admin Dashboard || Roles')
@section('admin')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="float-start">All Roles</h2>
                    <a href="{{route('roles.create')}}" class="btn btn-primary float-end">Add Role</a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="roleTable">
                        <thead>
                            <tr>
                                <th>Role ID</th>
                                <th>Role Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($roles as $item)
                            <tr id="role_{{ $item->id }}">
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>
                                    
                                    <a href="{{ url('roles/'.$item->id.'/give-permissions') }}" class="btn btn-primary">Add/Edit Permission</a>
                                    <a href="{{ route('roles.edit', $item->id) }}" class="btn btn-primary">Edit</a>
                                    <form action="{{ route('roles.destroy', $item->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>

                                    
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
    
