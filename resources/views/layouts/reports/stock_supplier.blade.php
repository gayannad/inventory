<?php
/**
 * Created by IntelliJ IDEA.
 * User: gayan
 * Date: 7/24/18
 * Time: 9:40 AM
 */ ?>
@extends('admin_template')
@section('content')
    <div class="container-fluid" ng-controller="stockCtrl" ng-app="stockApp">
        <div class="card">

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-9">
                        <form action="/reports/supplier/search" method="get">
                            <div class="form-group row" id="search">
                                {{csrf_field()}}
                                <div class="col-lg-6">
                                    <select id="supplier" name="supplier" class="form-control" required>
                                        <option value="">Select Supplier</option>
                                    </select>
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
                    <table class="table table-bordered table-responsive-sm">
                        <thead class="">
                        <tr>
                            <th>Product Code</th>
                            <th>Brand</th>
                            <th>Category</th>
                            <th>Supplier</th>
                            <th>Description</th>
                            <th>Qty</th>
                        </tr>
                        </thead>
                        <?php
                        $qty = 0;
                        $total_qty = 0;
                        ?>
                        @foreach($stocks as $stock)

                            <?php
                            $qty = $stock->qty;
                            $total_qty += $qty;
                            ?>
                            <tr>
                                <td>{{$stock->id}}</td>
                                <td>{{$stock->brand}}</td>
                                <td>{{$stock->category}}</td>
                                <td>{{$stock->supplier}}</td>
                                <td>{{$stock->description}}</td>
                                <td>{{$qty}}</td>
                            </tr>
                        @endforeach
                        <tr class="font-weight-bold bg-warning">
                            <td colspan="5">Total</td>
                            <td>{{$total_qty}}</td>
                        </tr>
                    </table>
                </div>
                <div class="btn-group-sm float-right" role="group">
                    <button id="btn" type="button" class="btn btn-success"><i class="fa fa-file-excel"> csv</i></button>
                    <button type="button" class="btn btn-primary" ng-click="print()"><i class="fa fa-print"> print</i>
                    </button>
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

        function getSuppliers() {
            $.getJSON("/supplier/list", function (data) {

                $.each(data, function (key, val) {
                    $('#supplier').append("<option value='" + val.id + "'>" + val.comapany_name + "</option>");
                })
            });
        }

        $(function () {
            getSuppliers();
        });

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
