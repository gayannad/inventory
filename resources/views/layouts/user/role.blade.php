<?php
/**
 * Created by IntelliJ IDEA.
 * User: gayan
 * Date: 11/8/18
 * Time: 3:59 PM
 */ ?>
@extends('admin_template')
@section('content')
<div class="container">
    <div class="card  bg-light">

        <div class="card-body">
            <form action="/user/role/save" method="post" class="form">
                @csrf
                <div class="row">
                    <div class="form-group col-lg-6">
                        <label class="col-form-label form-control-label">Role Name</label>
                        <input type="text" class="form-control" name="role_name" id="role_name" required>
                    </div>
                    <div class="form-group col-lg-6">
                        <label class="col-form-label form-control-label">Description</label>
                        <input type="text" class="form-control" name="description" id="description" required>
                    </div>
                </div>
                <div class="row float-right">
                    <input type="submit" value="Save" class="btn btn-primary btn-sm ">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection