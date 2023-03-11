<?php
/**
 * Created by IntelliJ IDEA.
 * User: gayan
 * Date: 7/18/18
 * Time: 10:05 AM
 */ ?>
<?php
/**
 * Created by IntelliJ IDEA.
 * User: gayan
 * Date: 6/13/18
 * Time: 9:34 PM
 */ ?>
@extends('admin_template')
@section('content')
    <div class="container" ng-controller="invCtrl" ng-app="invApp">
        <div class="card" id="main">
            <div class="card-header">
                @if($invoice_details[0]->status ==ACTIVE_INVOICE)
                    <button class="btn btn-primary btn-sm" id="print" ng-click="print()"><i class="fa fa-print">
                            print</i>
                    </button>
                @endif
                <div class="card-title float-right font-weight-bold">INVOICE</div>
            </div>
            <div class="card-body">

                <div class="card">
                    <div class="card-header">
                        <div class="row small">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <img class="small" width="90" src="{{ asset('images/logo_company.png') }}"
                                         alt="">
                                    <label for="" class="float-right"><b>INVOICE:</b>{{$invoice_details[0]->id}}</label>
                                </div>
                                <div class="form-group">
                                    <!--<span class="small">343 Horana Rd, Panadura 12500, www.bestlife.lk, info@bestlifeltd.com</span>-->
                                    <label for="" class="float-right"><b>DATE:</b>{{$invoice_details[0]->date}}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body form-group">
                        <div class="row small">
                            <div class="col-sm-12 form-group">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title float-left font-weight-bold text-uppercase">Customer
                                            Details
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group small">
                                            <label class="font-weight-bold float-left" for="">NAME
                                                :</label><span>{{$invoice_details[0]->customer_name}}</span>
                                        </div>
                                        <div class="form-group small">
                                            <label class="font-weight-bold float-left" for="">ADDRESS
                                                :</label><span>{{$invoice_details[0]->address}}</span>
                                        </div>
                                        <div class="form-group small">
                                            <label class="font-weight-bold float-left" for="">MOBILE
                                                :</label><span>{{$invoice_details[0]->mobile}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card form-group">
                            <div class="card-body small">
                                <table class="table table-bordered table-responsive-sm small">

                                    <tr>
                                        <th>ITEM CODE</th>
                                        <th>ITEM NAME</th>
                                        <th>UNIT CP</th>
                                        <th>QTY</th>
                                        <th>TOTAL CP</th>
                                    </tr>
                                    <?php
                                    $total_cost = 0;
                                    ?>
                                    @foreach($invoice_details['details'] as $invoice_detail)

                                        <?php

                                        $cost = $invoice_detail->selling_price * $invoice_detail->qty;
                                        $total_cost += $cost;
                                        ?>
                                        <tr>
                                            <td>{{$invoice_detail->product}}</td>
                                            <td>{{$invoice_detail->description}}</td>
                                            <td>LKR: {{number_format($invoice_detail->selling_price,2)}}</td>
                                            <td>{{$invoice_detail->qty}}</td>
                                            <td>LKR: {{number_format($cost,2)}}</td>

                                        </tr>
                                    @endforeach
                                    <tr class="bg-light">
                                        <td colspan="4" class="font-weight-bold">TOTALS</td>
                                        <td>LKR: {{number_format($total_cost,2)}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        {{--@if($invoice_details[0]->status ==APPROVED_PO)--}}
                            {{--<img class="small float-left" width="250" src="{{ asset('images/approved.jpg') }}"--}}
                                 {{--alt="">--}}
                        {{--@endif--}}
                        {{--@if($invoice_details[0]->status ==REJECTED_PO)--}}
                            {{--<img class="small float-left" width="200" src="{{ asset('images/rejected.png') }}"--}}
                                 {{--alt="">--}}
                        {{--@endif--}}
                        <div class="form-group float-right">
                            <label class="col-form-label">Remarks:</label>
                            <textarea class="form-control" name="" id="" cols="60" rows="2"></textarea>
                        </div>
                        <div class=""></div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        $('div.alert').delay(2000).slideUp(300);
        var app = angular.module('invApp', []);

        app.controller('invCtrl', function ($scope, $http) {

            $scope.print = function () {
                window.print();
            }




        });
    </script>

    <style>
        @media print {

            #print {
                visibility: hidden;
            }

            .main-footer {
                visibility: hidden;
            }
        }
    </style>
@endsection

