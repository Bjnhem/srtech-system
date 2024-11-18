@extends('ilsung.layouts.Home_layout')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-lg-4 col-md-4">
                <a href="{{ route('Home.checklist') }}">
                    <div class="card bg-soft-info">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="bg-soft-info rounded p-3">
                                    <img class=" icon" src="{{ asset('checklist-ilsung/icon/machine.png') }}" alt="Camera"
                                        width="30" height="30">
                                </div>
                                <div class="text-end">
                                    <h2 class="counter counter_model" style="visibility: visible;">Checklist</h2>
                                    Quản lý checklist EQM
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-4">
                <a href="{{ route('Home.WareHouse') }}">
                    <div class="card bg-soft-warning">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="bg-soft-warning rounded p-3">
                                    <img class=" icon" src="{{ asset('checklist-ilsung/icon/machine.png') }}"
                                        alt="Camera" width="30" height="30">
                                </div>
                                <div class="text-end">
                                    <h2 class="counter" style="visibility: visible;">WareHouse</h2>
                                   Quản lý kho EQM
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-4">
                <a href="{{ route('Home.OQC') }}">
                    <div class="card bg-soft-danger">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="bg-soft-danger rounded p-3">
                                    <img class=" icon" src="{{ asset('checklist-ilsung/icon/machine.png') }}"
                                        alt="Camera" width="30" height="30">
                                </div>
                                <div class="text-end">
                                    <h2 class="counter" style="visibility: visible;">OQC</h2>
                               Quản lý chất lượng OQC
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>
    </div>
@endsection

@section('admin-js')
   
@endsection
