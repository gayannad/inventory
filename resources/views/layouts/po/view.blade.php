<?php
/**
 * Created by IntelliJ IDEA.
 * User: gayan
 * Date: 6/13/18
 * Time: 9:34 PM
 */ ?>
@extends('admin_template')
@section('content')
    <div class="container" ng-controller="poCtrl" ng-app="poApp">
        <div class="card" id="main">
            <div class="card-header">
                @if($po_details[0]->status ==APPROVED_PO ||$po_details[0]->status ==REJECTED_PO)
                    <button class="btn btn-primary btn-sm" id="print" ng-click="print()"><i class="fa fa-print">
                            print</i>
                    </button>
                @endif
                <div class="card-title float-right font-weight-bold">PURCHASE ORDER</div>
            </div>
            <div class="card-body">
                @if (session('alert') =='Po Successfully Approved !')
                    <div class="alert alert-success">
                        <button type="button"
                                class="close"
                                data-dismiss="alert"
                                aria-hidden="true">&times;
                        </button>
                        {{ session('alert') }}
                    </div>
                @endif
                @if (session('alert') =='Po Successfully Rejected !')
                    <div class="alert alert-danger">
                        <button type="button"
                                class="close"
                                data-dismiss="alert"
                                aria-hidden="true">&times;
                        </button>
                        {{ session('alert') }}
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <div class="row small">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <img class="small" width="90" src="{{ asset('images/logo_company.png') }}"
                                         alt="">
                                    <label for="" class="float-right"><b>PO:</b>{{$po_details[0]->id}}</label>
                                </div>
                                <div class="form-group">
                                    <!--<span class="small">343 Horana Rd, Panadura 12500, www.bestlife.lk, info@bestlifeltd.com</span>-->
                                    <label for="" class="float-right"><b>DATE:</b>{{$po_details[0]->created_at}}
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label for="" class="float-right"><b>DUE DATE:</b>{{$po_details[0]->due_date}}
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
                                        <div class="card-title float-left font-weight-bold text-uppercase">vendor
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group small">
                                            <label class="font-weight-bold float-left" for="">NAME
                                                :</label><span>{{$po_details[0]->comapany_name}}</span>
                                        </div>
                                        <div class="form-group small">
                                            <label class="font-weight-bold float-left" for="">ADDRESS
                                                :</label><span>{{$po_details[0]->comapany_name}}</span>
                                        </div>
                                        <div class="form-group small">
                                            <label class="font-weight-bold float-left" for="">CONTACT PERSON
                                                :</label><span>{{$po_details[0]->contact_person}}</span>
                                        </div>
                                        <div class="form-group small">
                                            <label class="font-weight-bold float-left" for="">TELEPHONE
                                                :</label><span>{{$po_details[0]->telephone}}</span>
                                        </div>
                                        <div class="form-group small">
                                            <label class="font-weight-bold float-left" for="">EMAIL
                                                :</label><span>{{$po_details[0]->email}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 form-group">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title float-left font-weight-bold text-uppercase">ship to
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group small">
                                            <label class="font-weight-bold float-left" for="">NAME
                                                :</label><span>{{$po_details[0]->lemail}}</span>
                                        </div>
                                        <div class="form-group small">
                                            <label class="font-weight-bold float-left" for="">ADDRESS
                                                :</label><span>{{$po_details[0]->laddress}}</span>
                                        </div>
                                        <div class="form-group small">
                                            <label class="font-weight-bold float-left" for="">CONTACT PERSON
                                                :</label><span>{{$po_details[0]->lcontact_person}}</span>
                                        </div>
                                        <div class="form-group small">
                                            <label class="font-weight-bold float-left" for="">TELEPHONE
                                                :</label><span>{{$po_details[0]->ltelephone}}</span>
                                        </div>
                                        <div class="form-group small">
                                            <label class="font-weight-bold float-left" for="">EMAIL
                                                :</label><span>{{$po_details[0]->lemail}}</span>
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
                                    @foreach($po_details['details'] as $po_detail)

                                        <?php

                                        $cost = $po_detail->cost_price * $po_detail->qty;
                                        $total_cost += $cost;
                                        ?>
                                        <tr>
                                            <td>{{$po_detail->item_code}}</td>
                                            <td>{{$po_detail->description}}</td>
                                            <td>LKR: {{number_format($po_detail->cost_price,2)}}</td>
                                            <td>{{$po_detail->qty}}</td>
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
                        @if($po_details[0]->status ==APPROVED_PO)
                            <img class="small float-left" width="250" src="{{ asset('images/approved.jpg') }}"
                                 alt="">
                        @endif
                        @if($po_details[0]->status ==REJECTED_PO)
                            <img class="small float-left" width="200" src="{{ asset('images/rejected.png') }}"
                                 alt="">
                        @endif
                        <div class="form-group float-right">
                            <label class="col-form-label">Remarks:</label>
                            <textarea class="form-control" name="" id="" cols="60" rows="2"></textarea>
                        </div>
                        <div class=""></div>
                    </div>
                    <div class="card-footer">

                        @if($po_details[0]->status ==PENDING_PO)
                            <input type="submit" class="btn btn-primary float-right" value="Approve"
                                   ng-click="approvePo({{$po_details[0]->id}})">

                            <input type="button" class="btn btn-danger float-right" value="Reject"
                                   ng-click="rejectPo({{$po_details[0]->id}})">
                        @endif
                        @if($po_details[0]->status ==APPROVED_PO)
                            <div class="small float-right">
                                <span><b>Created By:</b>{{$po_details[0]->name}}</span>
                                &nbsp;&nbsp;
                                <span><b>Approved By:</b>{{$po_details[0]->muser}}</span>
                            </div>
                        @endif
                        @if($po_details[0]->status ==REJECTED_PO)
                            <div class="small float-right">
                                <span><b>Created By:</b>{{$po_details[0]->name}}</span>
                                &nbsp;&nbsp;
                                <span><b>Rejected By:</b>{{$po_details[0]->muser}}</span>
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

            $scope.approvePo = function (po) {
                bootbox.dialog({
                    message: "Do you want to approve this po?",
                    buttons: {
                        confirm: {
                            label: 'Yes',
                            className: 'btn-success',
                            callback: function () {
                                window.open('/po/approve/' + po, '_self');
                            }
                        },
                        cancel: {
                            label: 'No',
                            className: 'btn-danger'
                        }
                    }

                });

            }

            $scope.rejectPo = function (po) {
                bootbox.dialog({
                    message: "Do you want to reject this po?",
                    buttons: {
                        confirm: {
                            label: 'Yes',
                            className: 'btn-success',
                            callback: function () {
                                window.open('/po/reject/' + po, '_self');
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
    .main-footer{
        visibility: hidden;
    }
    }
    </style>
@endsection
