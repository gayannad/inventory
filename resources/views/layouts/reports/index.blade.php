<?php
/**
 * Created by IntelliJ IDEA.
 * User: gayan
 * Date: 7/18/18
 * Time: 12:39 PM
 */ ?>
@extends('admin_template')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Reports</div>
            </div>
            <div class="card-body">
                <div class="row form-group font-weight-bold">
                    <div class="col-lg-2 form-group">
                        <a href="/reports/stock" class="fa fa-link"> Stock Report</a>
                    </div>
                    <div class="col-lg-2 form-group">
                        <a href="/reports/valuation" class="fa fa-link"> Stock Valuation Report</a>
                    </div>
                    <div class="col-lg-2 form-group">
                        <a href="/reports/stockSupplier" class="fa fa-link"> Stock By Supplier</a>
                    </div>
                    <div class="col-lg-2 form-group">
                        <a href="/reports/stockLocation" class="fa fa-link"> Stock By Location</a>
                    </div>
                    <div class="col-lg-2 form-group">
                        <a href="/reports/poReport" class="fa fa-link"> Purchase Order History</a>
                    </div>
                    <div class="col-lg-2 form-group">
                        <a href="/reports/grnReport" class="fa fa-link"> Goods Receive History</a>
                    </div>
                    <div class="col-lg-2 form-group">
                        <a href="/reports/gtnReport" class="fa fa-link"> Goods Transfer History</a>
                    </div>
                    <div class="col-lg-2 form-group">
                        <a href="/reports/salesReport" class="fa fa-link"> Sales Report</a>
                    </div>
                    <div class="col-lg-2 form-group">
                        <a href="/reports/saleProduct" class="fa fa-link"> Sales By Product </a>
                    </div>
                    <div class="col-lg-2 form-group">
                        <a href="/reports/saleSupplier" class="fa fa-link"> Sales By Supplier</a>
                    </div>
                    <div class="col-lg-2 form-group">
                        <a href="/reports/binCard" class="fa fa-link"> Bin Card</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection