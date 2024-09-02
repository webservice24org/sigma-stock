@extends('layouts.admin-master')
@section('title', 'Admin Dashboard || Roles')
@section('admin')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="float-start">Role: {{$role->name}}</h2>
                    <a href="{{route('roles.index')}}" class="btn btn-primary float-end">Role List</a>
                </div>
                <div class="card-body">
                <form action="{{url('roles/'.$role->id.'/give-permissions')}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-2">
                        <div class="row">
                            @foreach ($permissions as $item)
                            
                                <div class="col-md-2">
                                    <label>
                                        <input 
                                        type="checkbox" 
                                        name="permission[]" 
                                        value="{{$item->name}}"
                                        {{in_array($item->id, $rolePermissions) ? 'checked' : ''}}
                                        />
                                        {{$item->name}}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group mt-2 mb-2">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
    

@endsection
    
