<?php
/**
 * Created by IntelliJ IDEA.
 * User: gayan
 * Date: 7/24/18
 * Time: 9:40 AM
 */ ?>
@extends('admin_template')
@section('content')
    <div class="container-fluid" ng-app="gtnApp" ng-controller="gtnCtrl">
        <div class="card">
            <div class="card-header small">
                <div class="card-title">GTN Report</div>
            </div>
            <div class="card-body">
                <div class="form-group card" id="header">
                    <div class="card-body">
                        <form action="" id="gtnform">
                            <div class="row">
                                <div class="col-lg-3 small">
                                    <input type="datetime" ui-date="dateOptions" class="form-control"
                                           placeholder="From"
                                           name="from" id="from" ng-model="from" required/>
                                </div>
                                <div class="col-lg-3 small">
                                    <input type="datetime" ui-date="dateOptions" class="form-control"
                                           placeholder="To"
                                           name="to" id="to" ng-model="to" required/>
                                </div>
                                <div class="col-lg-2">
                                    <button type="submit" class="btn btn-primary btn-sm" ng-click="submitForm()">Search
                                    </button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                <div class="card" id="card2">
                    <div class="card-body">
                        <table class="table table-responsive-sm table-bordered small">
                            <thead class="bg-navy">
                            <tr>
                                <th>GTN.No</th>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Cost Price</th>
                                <th>Selling Price</th>
                                <th>Qty</th>
                            </tr>
                            </thead>
                            @foreach($gtns as $gtn)
                                <tr>
                                    <td>{{$gtn->gtn_no}}</td>
                                    <td>{{$gtn->date}}</td>
                                    <td>{{$gtn->description}}</td>
                                    <td>{{$gtn->cost_price}}</td>
                                    <td>{{$gtn->selling_price}}</td>
                                    <td>{{$gtn->qty}}</td>
                                    {{--<td>--}}
                                    {{--<button type="button" class="btn btn-default btn-sm" ng-click="viewPo({{$gtn->po_header}})">View</button>--}}
                                    {{--</td>--}}
                                </tr>
                            @endforeach
                        </table>
                        <div class="btn-group-sm float-right" role="group">
                            <button id="btn" type="button" class="btn btn-success"><i class="fa fa-file-excel"> csv</i>
                            </button>
                            <button type="button" class="btn btn-primary" ng-click="print()"><i class="fa fa-print">
                                    print</i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#btn').click(function () {
            $('.table').tableToCSV({
                filename: "gtn_report"
            });


        })

        var app = angular.module('gtnApp', ['ui.date']);
        app.controller('gtnCtrl', function ($scope, $http) {
            $scope.dateOptions = {
                changeYear: true,
                changeMonth: true,
                dateFormat: 'yy-mm-dd'
            };

            $scope.viewPo = function (id) {
                window.open('/grn/view/' + id, '_blank');
            }

            $scope.print = function () {
                window.print();
            }

            $scope.submitForm = function () {
                $('#gtnform').submit();
            }

        })


    </script>

    <style>
        @media print {

            #header {
                visibility: hidden;
            }

            #card2 {
                margin-top: -150px;
            }

            .main-footer {
                visibility: hidden;
            }

            button {
                visibility: hidden;
            }

        }
    </style>
@endsection
