@extends('layouts.app')
@section('title','Edit')
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between py-4">
            <p class="page-title">Edit</p>
            <a class="btn btn-sm btn-warning" href="{{route('permission.index')}}">View All</a>
        </div>
        <div class="card rounded-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{route('permission.update',$permission->id)}}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Name *</label>
                                    <input type="text" class="form-control rounded-0" name="name" value="{{(isset($permission->name)?$permission->name:old('name'))}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Group *</label>
                                    <select class="form-control rounded-0" name="group_id">
                                        <option value="">Please Select</option>
                                        @if(count($groups))
                                            @foreach($groups as $group)
                                                <option value="{{$group->id}}"
                                                        @if($group->id == $permission->group_id) selected @endif
                                                >{{$group->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <input type="submit" class="btn btn-sm btn-success" value="Update">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')

@endpush
