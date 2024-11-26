@extends('ilsung.OQC.layouts.OQC_layout')

@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <a href="{{ route('Warehouse.update.data.model') }}">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="bg-info text-white rounded p-3">
                                <img class=" icon" src="{{ asset('checklist-ilsung/icon/smartphone.png') }}" alt="Camera"
                                    width="30" height="30">
                            </div>
                            <div class="text-end">
                                Danh sách model
                                <h2 class="counter" style="visibility: visible;">75</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6">
            <a href="{{ route('Warehouse.update.data.kho') }}">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="bg-warning text-white rounded p-3">
                                <img class=" icon" src="{{ asset('checklist-ilsung/icon/production.png') }}" alt="Camera"
                                    width="30" height="30">
                            </div>
                            <div class="text-end">
                               Danh sách kho
                                <h2 class="counter counter_line" style="visibility: visible;">60</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

        </div>
        <div class="col-lg-3 col-md-6">
            <a href="{{ route('Warehouse.update.data.sanpham') }}">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="bg-success text-white rounded p-3">
                                <img class=" icon" src="{{ asset('checklist-ilsung/icon/machine.png') }}" alt="Camera"
                                    width="30" height="30">
                            </div>
                            <div class="text-end">
                            Sản phẩm
                                <h2 class="counter counter_machine" style="visibility: visible;">80</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        

    </div>
@endsection

@section('admin-js')
   
@endsection
