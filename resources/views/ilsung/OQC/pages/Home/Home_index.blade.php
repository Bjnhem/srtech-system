@extends('ilsung.layouts.Home_layout')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center">
        <!-- Checklist Card -->
        <div class="col-lg-4 col-md-4 mb-4">
            <a href="{{ route('Home.checklist') }}">
                <div class="card tech-card checklist-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="icon-container">
                                <img src="{{ asset('checklist-ilsung/icon/machine.png') }}" alt="Checklist" width="50" height="50">
                            </div>
                            <div class="card-content">
                                <h3>Checklist</h3>
                                <p>Quản lý checklist EQM</p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- WareHouse Card -->
        <div class="col-lg-4 col-md-4 mb-4">
            <a href="{{ route('Home.WareHouse') }}">
                <div class="card tech-card warehouse-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="icon-container">
                                <img src="{{ asset('checklist-ilsung/icon/machine.png') }}" alt="Warehouse" width="50" height="50">
                            </div>
                            <div class="card-content">
                                <h3>WareHouse</h3>
                                <p>Quản lý kho EQM</p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- OQC Card -->
        <div class="col-lg-4 col-md-4 mb-4">
            <a href="{{ route('Home.OQC') }}">
                <div class="card tech-card oqc-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="icon-container">
                                <img src="{{ asset('checklist-ilsung/icon/machine.png') }}" alt="OQC" width="50" height="50">
                            </div>
                            <div class="card-content">
                                <h3>OQC</h3>
                                <p>Quản lý OQC</p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>



@endsection

@section('admin-js')
@endsection
