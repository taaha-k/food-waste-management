@extends('layouts.app')
@section('title','Edit')
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between py-4">
            <p class="page-title">Edit</p>
            <a class="btn btn-sm btn-warning" href="{{route('role.index')}}">View All</a>
        </div>
        <div class="card rounded-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{route('role.update',$role->id)}}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Full Name *</label>
                                    <input type="text" class="form-control rounded-0" name="name" value="{{(isset($role->name))?$role->name:old('name')}}">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="row">
                                        @foreach($groups as $group)
                                            <h3 class="h6">{{$group->name}}</h3>
                                            @foreach($group->permissions as $permissions)
                                                <div class="col-3 mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"  name="permission[]" value="{{$permissions->id}}"
                                                               @foreach($role->permissions as $per)
                                                               @if($per->id == $permissions->id) checked @endif
                                                            @endforeach>
                                                        <label class="form-check-label" for="flexCheckDefault">
                                                            {{ $permissions->name }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endforeach
                                    </div>
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
