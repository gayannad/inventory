<?php
/**
 * Created by IntelliJ IDEA.
 * User: gayan
 * Date: 7/18/18
 * Time: 1:56 PM
 */ ?>
@extends('admin_template')
@section('content')

    <div class="container-fluid" ng-controller="stockCtrl" ng-app="stockApp">
        <div class="card">

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-9">
                        <form action="/reports/stock/search" method="get">
                            <div class="form-group row" id="search">
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
                    </div>
                </div>
                <div class="form-group">
                    <table class="table table-responsive-sm table-bordered">
                        <thead class="">
                        <tr>
                            <th>Product Code</th>
                            <th>Brand</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Qty</th>
                        </tr>
                        </thead>
                        @foreach($stocks as $stock)
                            <tr>
                                <td>{{$stock->id}}</td>
                                <td>{{$stock->brand}}</td>
                                <td>{{$stock->category}}</td>
                                <td>{{$stock->description}}</td>
                                <td>{{$stock->qty}}</td>
                            </tr>
                        @endforeach
                    </table>


                </div>
                <div class="btn-group-sm float-right" role="group">
                    <button id="btn" type="button" class="btn btn-success"><i class="fa fa-file-excel"> csv</i></button>
                    <button type="button" class="btn btn-primary" ng-click="print()"><i class="fa fa-print"> print</i></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        var app = angular.module('stockApp', []);
        app.controller('stockCtrl', function ($scope, $http) {
            $scope.print = function () {
                window.print();
            }
        })

        $('#btn').click(function () {
            $('.table').tableToCSV({
                filename: "stock_report"
            });


        })

        function exportPdf() {
            window.open('/reports/downloadPDF/', '_self');
        }

    </script>
    <style>
        @media print {

            #search {
                visibility: hidden;
            }

            button {
                visibility: hidden;
            }

        }
    </style>
@endsection
