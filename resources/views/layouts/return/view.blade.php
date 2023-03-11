<?php
/**
 * Created by IntelliJ IDEA.
 * User: gayan
 * Date: 11/6/18
 * Time: 2:26 PM
 */ ?>
@extends('admin_template')
@section('content')
    <div class="container-fluid" ng-controller="returnCtrl" ng-app="returnApp">
        <div class="card" id="main">
            <div class="card-header">
                @if($return_details[0]->status ==APPROVED_PO ||$return_details[0]->status ==REJECTED_PO)
                    <button class="btn btn-primary btn-sm" id="print" ng-click="print()"><i class="fa fa-print">
                            print</i>
                    </button>
                @endif
                <div class="card-title float-right font-weight-bold">RETURN NOTE</div>
            </div>
            <div class="card-body">
                @if (session('alert') =='Gtn Approved !')
                    <div class="alert alert-success">
                        <button type="button"
                                class="close"
                                data-dismiss="alert"
                                aria-hidden="true">&times;
                        </button>
                        {{ session('alert') }}
                    </div>
                @endif
                @if (session('alert') =='Gtn Rejected !')
                    <div class="alert alert-danger">
                        <button type="button"
                                class="close"
                                data-dismiss="alert"
                                aria-hidden="true">&times;
                        </button>
                        {{ session('alert')}}
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <div class="row small">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <img class="small" width="90" src="{{ asset('images/logo_company.png') }}"
                                         alt="">
                                    <label for="" class="float-right"><b>RN NO:</b>{{$return_details[0]->id}}</label>
                                </div>
                                <div class="form-group">
                                    <!--<span class="small">343 Horana Rd, Panadura 12500, www.bestlife.lk, info@bestlifeltd.com</span>-->
                                    <label for="" class="float-right"><b>DATE:</b>{{$return_details[0]->created_date}}
                                    </label>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card-body form-group">
                        <div class="row small">
                            <div class="col-sm-6 form-group">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title float-left font-weight-bold text-uppercase">source
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group small">
                                            <label class="font-weight-bold float-left" for="">NAME
                                                :</label><span>{{$return_details[0]->source}}</span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 form-group">
                                <div class="card">
                                    @if($return_details[0]->destination != null)
                                        <div class="card-header">
                                            <div class="card-title float-left font-weight-bold text-uppercase">
                                                destination
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group small">
                                                <label class="font-weight-bold float-left" for="">NAME
                                                    :</label><span>{{$return_details[0]->destination}}</span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="card-header">
                                            <div class="card-title float-left font-weight-bold text-uppercase">
                                                supplier
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group small">
                                                <label class="font-weight-bold float-left" for="">NAME
                                                    :</label><span>{{$return_details[0]->supplier}}</span>
                                            </div>
                                        </div>
                                    @endif
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
                                    @foreach($return_details['details'] as $gtn_detail )

                                        <?php
                                        $cost = $gtn_detail->cost_price * $gtn_detail->qty;
                                        $total_cost += $cost;
                                        ?>
                                        <tr>
                                            <td>{{$gtn_detail->product}}</td>
                                            <td>{{$gtn_detail->description}}</td>
                                            <td>LKR: {{number_format($gtn_detail->cost_price,2)}}</td>
                                            <td>{{$gtn_detail->qty}}</td>
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
                        @if($return_details[0]->status ==APPROVED_PO)
                            <img class="small float-left" width="250" src="{{ asset('images/approved.jpg') }}"
                                 alt="">
                        @endif
                        @if($return_details[0]->status ==REJECTED_PO)
                            <img class="small float-left" width="200" src="{{ asset('images/rejected.png') }}"
                                 alt="">
                        @endif
                        <div class="form-group float-right">
                            <label class="col-form-label">Remarks:</label>
                            <textarea disabled class="form-control" name="" id="" cols="60"
                                      rows="2">{{$return_details[0]->remarks}}</textarea>
                        </div>
                        <div class=""></div>
                    </div>
                    <div class="card-footer">

                        @if($return_details[0]->status ==PENDING_PO)
                            <input type="submit" class="btn btn-primary float-right" value="Approve"
                                   ng-click="approveReturn({{$return_details[0]->id}})">

                            <input type="button" class="btn btn-danger float-right" value="Reject"
                                   ng-click="rejectReturn({{$return_details[0]->id}})">
                        @endif
                        @if($return_details[0]->status ==APPROVED_PO)
                            <div class="small float-right">
                                <span><b>Created By:</b>{{$return_details[0]->user_created}}</span>
                                &nbsp;&nbsp;
                                <span><b>Approved By:</b>{{$return_details[0]->user_approved}}</span>
                            </div>
                        @endif
                        @if($return_details[0]->status ==REJECTED_PO)
                            <div class="small float-right">
                                <span><b>Created By:</b>{{$return_details[0]->user_created}}</span>
                                &nbsp;&nbsp;
                                <span><b>Rejected By:</b>{{$return_details[0]->user_approved}}</span>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('div.alert').delay(2000).slideUp(300);
        var app = angular.module('returnApp', []);

        app.controller('returnCtrl', function ($scope, $http) {

            $scope.print = function () {
                window.print();
            }

            $scope.approveReturn = function (id) {
                bootbox.dialog({
                    message: "Do you want to approve this gtn?",
                    buttons: {
                        confirm: {
                            label: 'Yes',
                            className: 'btn-success',
                            callback: function () {
                                window.open('/return/approve/' + id, '_self');
                            }
                        },
                        cancel: {
                            label: 'No',
                            className: 'btn-danger'
                        }
                    }

                });

            }

            $scope.rejectReturn = function (id) {
                bootbox.dialog({
                    message: "Do you want to reject this gtn?",
                    buttons: {
                        confirm: {
                            label: 'Yes',
                            className: 'btn-success',
                            callback: function () {
                                window.open('/return/reject/' + id, '_self');
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


