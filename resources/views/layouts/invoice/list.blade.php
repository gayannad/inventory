<?php
/**
 * Created by IntelliJ IDEA.
 * User: gayan
 * Date: 7/17/18
 * Time: 3:31 PM
 */ ?>
@extends('admin_template')

@section('content')
    <div class="container-fluid" ng-controller="invCtrl" ng-app="invApp">
        <div class="card ">
            <div class="card-body">
                @if (session('alert') =='Invoice Cancelled !')
                    <div class="alert alert-danger">
                        <button type="button"
                                class="close"
                                data-dismiss="alert"
                                aria-hidden="true">&times;
                        </button>
                        {{ session('alert') }}
                    </div>
                @endif
                <form action="/invoice/search" method="get">
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
                    @if(isset($invoices))
                        <table class="table table-bordered table-responsive-lg">
                            <thead class="">
                            <tr class="">
                                <th>Invoice</th>
                                <th class="text-center">Location</th>
                                <th class="text-center">date</th>
                                <th class="text-center">status</th>
                                <th>action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($invoices as $key =>$invoice)
                                <tr>
                                    <td>{{$invoice->id}}</td>
                                    <td class="text-center">{{$invoice->name}}</td>
                                    <td class="text-center">{{$invoice->date}}</td>
                                    <td class="text-center">
                                        @if($invoice->status ==ACTIVE_INVOICE) <span
                                                class="badge badge-pill badge-success font-weight-bold">ACTIVE</span>
                                        @elseif($invoice->status ==VOID_INVOICE) <span
                                                class="badge badge-pill badge-danger font-weight-bold">VOID</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-default btn-sm" ng-click="viewInvoice({{$invoice->id}})">
                                            View
                                        </button>
                                        @if($invoice->status ==ACTIVE_INVOICE)
                                            <button class="btn btn-danger btn-sm"
                                                    ng-click="void({{$invoice->id}})">
                                                Void
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! $invoices->render() !!}
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
        $('div.alert').delay(2000).slideUp(300);
        var app = angular.module('invApp', []);
        app.controller('invCtrl', function ($scope, $http) {

            $scope.viewInvoice = function (id) {
                window.open('/invoice/view/' + id, '_blank');
            }

            $scope.void = function (id) {
                bootbox.dialog({
                    message: "Do you want to void this invoice?",
                    buttons: {
                        confirm: {
                            label: 'Yes',
                            className: 'btn-success',
                            callback: function () {
                                window.open('/invoice/void/' + id, '_self');
                            }
                        },
                        cancel: {
                            label: 'No',
                            className: 'btn-danger'
                        }
                    },

                });
            }
        })
    </script>
@endsection
