<?php
/**
 * Created by IntelliJ IDEA.
 * User: gayan
 * Date: 7/5/18
 * Time: 10:40 AM
 */ ?>
@extends('admin_template')
@section('content')
    <div class="container-fluid" ng-controller="grnCtrl" ng-app="grnApp">
        <div class="card ">

            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Stock In List</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Stock</a></li>
                            <li class="breadcrumb-item active">Stock In List</li>
                        </ol>
                    </div><!-- /.col -->
                </div>
{{--                {{dd(session('alert'))}}--}}
                @if (session('alert') =='Successfully Saved !')
                    <div class="alert alert-success">
                        <button type="button"
                                class="close"
                                data-dismiss="alert"
                                aria-hidden="true">&times;
                        </button>
                        {{ session('alert') }}
                    </div>
                @elseif (session('alert') =='Error!')
                    <div class="alert alert-danger">
                        <button type="button"
                                class="close"
                                data-dismiss="alert"
                                aria-hidden="true">&times;
                        </button>
                        {{ session('alert') }}
                    </div>
                @endif
                <form action="/grn/search" method="get">
                    <div class="form-group row">
                        {{csrf_field()}}
                        <div class="col-lg-6">
                            <input type="text" name="search" class="form-control" placeholder="SEARCH">
                        </div>
                        <div class="col-lg-3">
                            <button type="submit" class="btn btn-primary btn-sm float-left"><i
                                        class="fa fa-search">Search</i></button>
                        </div>

                    </div>
                </form>
                <div class="form-group row">
                    @if(isset($grns))
                        <table class="table table-bordered table-responsive-lg">
                            <thead class="">
                            <tr>
                                <th>#ID</th>
                                <th class="text-center">Location</th>
{{--                                <th class="text-center">Type</th>--}}
                                <th class="text-center">Date</th>
                                <th class="text-center">Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($grns as $key =>$grn)
                                <tr>
                                    <td>{{$grn->id}}</td>
                                    <td class="text-center">{{$grn->name}}</td>
{{--                                    <td class="text-center">--}}
{{--                                        @if($grn->grn_type ==GRN_TYPE_DIRECT) <span--}}
{{--                                                class="badge badge-pill badge-warning font-weight-bold">DIRECT</span>--}}
{{--                                        @elseif($grn->grn_type ==GRN_TYPE_GTN) <span--}}
{{--                                                class="badge badge-pill badge-info font-weight-bold">BY GTN</span>--}}
{{--                                        @endif--}}
{{--                                    </td>--}}
                                    <td class="text-center">{{$grn->date}}</td>
                                    <td class="text-center">
                                        @if($grn->status ==PENDING_GRN) <span
                                                class="badge badge-pill badge-primary font-weight-bold">PENDING</span>
                                        @elseif($grn->status ==APPROVED_GRN) <span
                                                class="badge badge-pill badge-success font-weight-bold">APPROVED</span>
                                        @elseif($grn->status ==REJECTED_GRN) <span
                                                class="badge badge-pill badge-danger font-weight-bold">REJECTED</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-primary" ng-click="viewGrn({{$grn->id}})">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! $grns->render() !!}
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

        var app = angular.module('grnApp', []);
        app.controller('grnCtrl', function ($scope, $http) {

            $scope.viewGrn = function (id) {
                window.open('/stock/view/' + id, '_blank');
            }
        })
    </script>
@endsection

