<?php
/**
 * Created by IntelliJ IDEA.
 * User: gayan
 * Date: 7/10/18
 * Time: 10:23 AM
 */ ?>
@extends('admin_template')
@section('content')
    <div class="container-fluid" ng-controller="poCtrl" ng-app="poApp">
        <div class="card" id="main">
            <div class="card-header">
                @if($grn_details[0]->status ==APPROVED_PO ||$grn_details[0]->status ==REJECTED_PO)
                    <button class="btn btn-primary btn-sm" id="print" ng-click="print()"><i class="fa fa-print">
                            print</i>
                    </button>
                @endif
                <div class="card-title float-right font-weight-bold">SUPPLIER INVOICE</div>
            </div>
            <div class="card-body">
                @if (session('alert') =='Grn Approved !')
                    <div class="alert alert-success">
                        <button type="button"
                                class="close"
                                data-dismiss="alert"
                                aria-hidden="true">&times;
                        </button>
                        {{ 'Approved' }}
                    </div>
                @endif
                @if (session('alert') =='Grn Rejected !')
                    <div class="alert alert-danger">
                        <button type="button"
                                class="close"
                                data-dismiss="alert"
                                aria-hidden="true">&times;
                        </button>
                        {{ 'Rejected' }}
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <div class="row small">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <img class="small" width="90" src="{{ asset('images/logo_company.png') }}"
                                         alt="">
                                    <label for="" class="float-right"><b>Stock In No:</b>{{$grn_details[0]->id}}</label>
                                </div>
                                <div class="form-group">
                                    <!--<span class="small">343 Horana Rd, Panadura 12500, www.bestlife.lk, info@bestlifeltd.com</span>-->
                                    <label for="" class="float-right"><b>DATE:</b>{{$grn_details[0]->created_at}}
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label for="" class="float-right"><b>INVOICE:</b>{{$grn_details[0]->invoice}}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body form-group">
                        <div class="row small">
                            <div class="col-sm-12 form-group">
                                <div class="card">

                                    <div class="card-body">
                                        <div class="form-group small">
                                            <label class="font-weight-bold float-left" for="">SUPPLIER
                                                :</label><span>{{$grn_details[0]->comapany_name}}</span>
                                        </div>
                                        <div class="form-group small">
                                            <label class="font-weight-bold float-left" for="">SUPPLIER
                                                :</label><span>{{$grn_details[0]->comapany_name}}</span>
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
                                    @foreach($grn_details['details'] as $grn_detail)

                                        <?php
                                        $cost = $grn_detail->cost_price * $grn_detail->qty;
                                        $total_cost += $cost;
                                        ?>
                                        <tr>
                                            <td>{{$grn_detail->product}}</td>
                                            <td>{{$grn_detail->description}}</td>
                                            <td>LKR: {{number_format($grn_detail->cost_price,2)}}</td>
                                            <td>{{$grn_detail->qty}}</td>
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
                        @if($grn_details[0]->status ==APPROVED_GRN)
                            <img class="small float-left" width="250" src="{{ asset('images/approved.jpg') }}"
                                 alt="">
                        @endif
                        @if($grn_details[0]->status ==REJECTED_GRN)
                            <img class="small float-left" width="200" src="{{ asset('images/rejected.png') }}"
                                 alt="">
                        @endif
                        <div class="form-group float-right">
                            <label class="col-form-label">Remarks:</label>
                            <textarea disabled class="form-control" name="" id="" cols="60" rows="2">{{$grn_details[0]->remarks}}</textarea>
                        </div>
                        <div class=""></div>
                    </div>
                    <div class="card-footer">

                        @if($grn_details[0]->status ==PENDING_GRN)
                            <input type="submit" class="btn btn-primary float-right" value="Approve"
                                   ng-click="approveGrn({{$grn_details[0]->id}})">

                            <input type="button" class="btn btn-danger float-right" value="Reject"
                                   ng-click="rejectGrn({{$grn_details[0]->id}})">
                        @endif
                        @if($grn_details[0]->status ==APPROVED_GRN)
                            <div class="small float-right">
                                <span><b>Created By:</b>{{$grn_details[0]->user_created}}</span>
                                &nbsp;&nbsp;
                                <span><b>Approved By:</b>{{$grn_details[0]->user_authorized}}</span>
                            </div>
                        @endif
                        @if($grn_details[0]->status ==REJECTED_GRN)
                            <div class="small float-right">
                                <span><b>Created By:</b>{{$grn_details[0]->user_created}}</span>
                                &nbsp;&nbsp;
                                <span><b>Rejected By:</b>{{$grn_details[0]->user_authorized}}</span>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('div.alert').delay(2000).slideUp(300);
        var app = angular.module('poApp', []);

        app.controller('poCtrl', function ($scope, $http) {

            $scope.print = function () {
                window.print();
            }

            $scope.approveGrn = function (grn) {

                bootbox.dialog({
                    message: "Do you want to approve this grn?",
                    buttons: {
                        confirm: {
                            label: 'Yes',
                            className: 'btn-success',
                            callback: function () {
                                window.open('/stock/approve/' + grn, '_self');
                            }
                        },
                        cancel: {
                            label: 'No',
                            className: 'btn-danger'
                        }
                    }

                });
            }

            $scope.rejectGrn = function (grn) {
                bootbox.dialog({
                    message: "Do you want to reject this grn?",
                    buttons: {
                        confirm: {
                            label: 'Yes',
                            className: 'btn-success',
                            callback: function () {
                                window.open('/stock/reject/' + grn, '_self');
                            }
                        },
                        cancel: {
                            label: 'No',
                            className: 'btn-danger'
                        }
                    },

                });
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

