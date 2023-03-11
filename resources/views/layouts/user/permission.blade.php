<?php
/**
 * Created by IntelliJ IDEA.
 * User: gayan
 * Date: 11/9/18
 * Time: 10:43 AM
 */ ?>
@extends('admin_template')
@section('content')
    <div class="container-fluid">
        <div class="card small">
            <div class="card-header">
                <div class="card-title text-uppercase"></div>
            </div>
            <div class="card-body">
                <form action="/user/role/search" method="post">
                    <div class="form-group row">
                        {{csrf_field()}}
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="search" placeholder="SEARCH">
                        </div>
                        <div class="col-lg-3">
                            <button type="submit" class="btn btn-primary btn-sm float-left"><i class="fa fa-search">Search</i>
                            </button>
                        </div>
                    </div>
                </form>
                @if (session('alert'))
                    <div class="alert alert-success">
                        <button type="button"
                                class="close"
                                data-dismiss="alert"
                                aria-hidden="true">&times;
                        </button>
                        {{ session('alert') }}
                    </div>
                @endif
                <div class="form-group">
                    @if(isset($users))
                        <table class="table table-bordered table-responsive-lg">
                            <tr>
                                <th class="text-center" rowspan="2">ID</th>
                                <th class="text-center" rowspan="2">Name</th>
                                <th class="text-center" rowspan="2">Username</th>
                                <th colspan="3" class="text-center">Roles</th>
                                <th rowspan="2" class="text-center">Assign</th>
                            </tr>
                            <tr>
                                <th class="text-center">admin</th>
                                <th class="text-center">user</th>
                                <th class="text-center">manager</th>
                            </tr>
                            @foreach($users as $key=> $user)

                                <tr>
                                    <form action="/user/role/assign" method="post">
                                        @csrf
                                        <td>{{$user->id}}</td>
                                        <td>{{$user->first_name .' '. $user->last_name}}</td>
                                        <td>{{$user->username}}<input type="hidden" value="{{$user->username}}" name="username"></td>
                                        <td>
                                            <input type="checkbox" name="role_admin"
                                                   id="" {{$user->hasRole('admin') ? 'checked':''}}>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="role_user"
                                                   id="" {{$user->hasRole('user') ? 'checked':''}}>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="role_manager"
                                                   id="" {{$user->hasRole('manager') ? 'checked':''}}>
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-primary btn-sm">Assign</button>
                                        </td>
                                    </form>
                                </tr>

                            @endforeach
                        </table>
                        {!! $users->render() !!}
                    @else
                        <div class="alert alert-warning col-lg-12 text-center" role="alert">
                            <span>{{ $message }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        $('div.alert').delay(2000).slideUp(300);
    </script>
@endsection
