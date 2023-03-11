<?php
/**
 * Created by IntelliJ IDEA.
 * User: gayan
 * Date: 11/7/18
 * Time: 8:46 PM
 */ ?>
@extends('admin_template')
@section('content')

    <div class="container-fluid" ng-controller="stockCtrl" ng-app="stockApp">
        <div class="card">

            <div class="card-body">
                <div class="form-group">
                    <table class="table table-responsive-sm table-bordered">
                        <thead class="">
                        <tr>
                            <th>Product Code</th>
                            <th>Brand</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Qty</th>
                            <th>Unit Cost|P</th>
                            <th>Unit Selling|P</th>
                            <th>Total Cost|P</th>
                            <th>Total Selling|P</th>
                        </tr>
                        </thead>
                        <?php
                        $unit_cp = 0;
                        $total_cp = 0;
                        $unit_sp = 0;
                        $total_sp = 0;
                        $total_cp_amount = 0;
                        $total_sp_amount = 0;
                        ?>

                        @foreach($valuations as $valuation)
                            <?php
                            $unit_cp = $valuation->cost_price;
                            $total_cp = $valuation->cost_price * $valuation->qty;
                            $unit_sp = $valuation->selling_price;
                            $total_sp = $valuation->selling_price * $valuation->qty;
                            $total_cp_amount += $total_cp;
                            $total_sp_amount += $total_sp;
                            ?>
                            <tr>
                                <td>{{$valuation->id}}</td>
                                <td>{{$valuation->brand}}</td>
                                <td>{{$valuation->category}}</td>
                                <td>{{$valuation->description}}</td>
                                <td>{{$valuation->qty}}</td>
                                <td>{{number_format($unit_cp,2)}}</td>
                                <td>{{number_format($unit_sp,2)}}</td>
                                <td>{{number_format($total_cp,2)}}</td>
                                <td>{{number_format($total_sp,2)}}</td>
                            </tr>
                        @endforeach
                        <tr class="font-weight-bold bg-warning">
                            <td colspan="7">Total</td>
                            <td>{{number_format($total_cp_amount,2)}}</td>
                            <td>{{number_format($total_sp_amount,2)}}</td>
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

