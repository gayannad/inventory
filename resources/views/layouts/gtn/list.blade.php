<?php
/**
 * Created by IntelliJ IDEA.
 * User: gayan
 * Date: 7/12/18
 * Time: 4:59 PM
 */ ?>

@extends('admin_template')
@section('content')
    <div class="container-fluid" ng-controller="gtnCtrl" ng-app="gtnApp">
        <div class="card">
            <div class="card-body">
                <form action="/gtn/search" method="get">
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
                    @if(isset($gtns))
                        <table class="table table-bordered table-responsive-lg">
                            <thead class="">
                            <tr class="">
                                <th>Issue No</th>
                                <th class="text-center">Location</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Status</th>
                                <th>action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($gtns as $key =>$gtn)
                                <tr>
                                    <td>{{$gtn->id}}</td>
                                    <td class="text-center">{{$gtn->destination}}</td>
                                    <td class="text-center">{{$gtn->date}}</td>
                                    <td class="text-center">
                                        @if($gtn->status ==PENDING_GTN) <span
                                                class="badge badge-pill badge-primary font-weight-bold">PENDING</span>
                                        @elseif($gtn->status ==APPROVED_GTN) <span
                                                class="badge badge-pill badge-success font-weight-bold">APPROVED</span>
                                        @elseif($gtn->status ==REJECTED_GTN) <span
                                                class="badge badge-pill badge-danger font-weight-bold">REJECTED</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-primary" ng-click="viewGrn({{$gtn->id}})">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! $gtns->render() !!}
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

        var app = angular.module('gtnApp', []);
        app.controller('gtnCtrl', function ($scope, $http) {

            $scope.viewGrn = function (id) {
                window.open('/issues/view/' + id, '_blank');
            }
        })
    </script>
@endsection


