@extends('ilsung.layouts.layout')

@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <a href="{{ route('update.data.model') }}">
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
            <a href="{{ route('update.data.line') }}">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="bg-warning text-white rounded p-3">
                                <img class=" icon" src="{{ asset('checklist-ilsung/icon/production.png') }}" alt="Camera"
                                    width="30" height="30">
                            </div>
                            <div class="text-end">
                                Products line
                                <h2 class="counter counter_line" style="visibility: visible;">60</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

        </div>
        <div class="col-lg-3 col-md-6">
            <a href="{{ route('update.data.machine') }}">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="bg-success text-white rounded p-3">
                                <img class=" icon" src="{{ asset('checklist-ilsung/icon/machine.png') }}" alt="Camera"
                                    width="30" height="30">
                            </div>
                            <div class="text-end">
                                Machine master
                                <h2 class="counter counter_machine" style="visibility: visible;">80</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6">
            <a href="{{ route('update.data.machine.list') }}">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="bg-danger text-white rounded p-3">
                                <img class=" icon" src="{{ asset('checklist-ilsung/icon/evaluating.png') }}" alt="Camera"
                                    width="30" height="30">
                            </div>
                            <div class="text-end">
                                List machine
                                <h2 class="counter counter-list_machine" style="visibility: visible;">45</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <!-- <div class="col-lg-3 col-md-6">
            <a href="{{ route('update.data.checklist.master') }}">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="bg-warning text-white rounded p-3">
                                <img class=" icon" src="{{ asset('checklist-ilsung/icon/production.png') }}" alt="Camera"
                                    width="30" height="30">
                            </div>
                            <div class="text-end">
                                Checklist master
                                <h2 class="counter counter_line" style="visibility: visible;">60</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

        </div>
        <div class="col-lg-3 col-md-6">
            <a href="{{ route('update.data.checklist.item') }}">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="bg-success text-white rounded p-3">
                                <img class=" icon" src="{{ asset('checklist-ilsung/icon/machine.png') }}" alt="Camera"
                                    width="30" height="30">
                            </div>
                            <div class="text-end">
                               Checklist item
                                <h2 class="counter counter_machine" style="visibility: visible;">80</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div> -->

    </div>
@endsection

@section('admin-js')
   
@endsection
