<?php
/**
 * Created by IntelliJ IDEA.
 * User: gayan
 * Date: 11/6/18
 * Time: 10:51 AM
 */ ?>
@extends('admin_template')
@section('content')
    <div class="container-fluid" ng-controller="returnCtrl" ng-app="returnApp">
        <div class="card small">
            <div class="card-header">
                <div class="card-title text-info text-uppercase">Return List
                    <a href="/return/index" target="_self">
                        <button type="button" class="btn btn-success btn-sm float-right "><i class="fa fa-plus"> New
                                Return</i>
                        </button>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form action="/return/search" method="get">
                    <div class="form-group row">
                        {{csrf_field()}}
                        <div class="col-lg-2">
                            <input type="text" name="search" class="form-control" placeholder="SEARCH">
                        </div>
                        <div class="col-lg-3">
                            <button type="submit" class="btn btn-primary btn-sm float-left"><i
                                        class="fa fa-search">Search</i></button>
                        </div>

                    </div>
                </form>
                <div class="form-group row">
                    @if(isset($returns))
                        <table class="table table-bordered table-responsive-lg">
                            <thead class="bg-navy">
                            <tr class="text-uppercase">
                                <th>Return No</th>
                                <th class="text-center">Location</th>
                                <th class="text-center">Supplier</th>
                                <th class="text-center">date</th>
                                <th class="text-center">status</th>
                                <th>action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($returns as $key =>$return)
                                <tr>
                                    <td>{{$return->id}}</td>
                                    <td class="text-center">{{$return->destination}}</td>
                                    <td class="text-center">{{$return->supplier}}</td>
                                    <td class="text-center">{{$return->created_date}}</td>
                                    <td class="text-center">
                                        @if($return->status ==PENDING_GTN) <span
                                                class="badge badge-pill badge-primary font-weight-bold">PENDING</span>
                                        @elseif($return->status ==APPROVED_GTN) <span
                                                class="badge badge-pill badge-success font-weight-bold">APPROVED</span>
                                        @elseif($return->status ==REJECTED_GTN) <span
                                                class="badge badge-pill badge-danger font-weight-bold">REJECTED</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-default btn-sm" ng-click="viewReturn({{$return->id}})">
                                            View
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! $returns->render() !!}
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

        var app = angular.module('returnApp', []);
        app.controller('returnCtrl', function ($scope, $http) {

            $scope.viewReturn = function (id) {
                window.open('/return/view/' + id, '_blank');
            }

        })
    </script>
@endsection



