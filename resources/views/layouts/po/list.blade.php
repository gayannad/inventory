<?php
/**
 * Created by IntelliJ IDEA.
 * User: gayan
 * Date: 6/11/18
 * Time: 10:25 AM
 */ ?>
@extends('admin_template')
@section('content')

    <div class="container-fluid" ng-controller="poCtrl" ng-app="poApp">
        <div class="card small">
            <div class="card-header">
                <div class="card-title text-info text-uppercase">PURCHASE ORDER LIST
                    <a href="/po/index" target="_self">
                        <button type="button" class="btn btn-success btn-sm float-right "><i class="fa fa-plus"> New
                                Po</i>
                        </button>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form action="/po/search" method="get">
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
                    @if(isset($pos))
                    <table class="table table-bordered table-responsive-lg">
                        <thead class="bg-navy">
                        <tr class="text-uppercase">
                            <th>PO</th>
                            <th class="text-center">supplier</th>
                            <th class="text-center">date</th>
                            <th class="text-center">status</th>
                            <th>action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($pos as $key =>$po)
                            <tr>
                                <td>{{$po->id}}</td>
                                <td class="text-center">{{$po->comapany_name}}</td>
                                <td class="text-center">{{$po->created_at}}</td>
                                <td class="text-center">
                                    @if($po->status ==PENDING_PO) <span
                                            class="badge badge-pill badge-primary font-weight-bold">PENDING</span>
                                    @elseif($po->status ==APPROVED_PO) <span class="badge badge-pill badge-success font-weight-bold">APPROVED</span>
                                    @elseif($po->status ==REJECTED_PO) <span class="badge badge-pill badge-danger font-weight-bold">REJECTED</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-default btn-sm" ng-click="viewPo({{$po->id}})">view</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {!! $pos->render() !!}
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

        var app = angular.module('poApp', []);

        app.controller('poCtrl', function ($scope, $http) {

            $scope.viewPo = function (id) {
                window.open('/po/view/'+id, '_blank');
            }

        });
    </script>
@endsection

