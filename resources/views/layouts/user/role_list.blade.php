<?php
/**
 * Created by IntelliJ IDEA.
 * User: gayan
 * Date: 11/8/18
 * Time: 5:26 PM
 */ ?>
@extends('admin_template')
@section('content')
    <div class="container">
        <div class="card small">
            <div class="card-header">
                <div class="card-title small text-info text-uppercase">Role List
                    <a href="/user/role/create" target="_self">
                        <button type="button" class="btn btn-success btn-sm float-right "><i class="fa fa-plus"> New
                                Role</i>
                        </button>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <table class="table table-bordered table-responsive-lg">
                        <tr>
                            <th>#</th>
                            <th>Role Name</th>
                            <th>Role Description</th>
                        </tr>
                        @foreach($roles as $role)
                            <tr>
                                <td>{{$role->id}}</td>
                                <td>{{$role->name}}</td>
                                <td>{{$role->description}}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
