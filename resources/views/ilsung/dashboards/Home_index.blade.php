@extends('ilsung.layouts.layout')
{{-- @section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="row row-cols-1">
                <div class="d-slider1 overflow-hidden ">
                    <ul class="swiper-wrapper list-inline m-0 p-0 mb-2">
                        <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="700">
                            <div class="card-body">
                                <div class="progress-widget">
                                    <div id="circle-progress-01"
                                        class="circle-progress-01 circle-progress circle-progress-primary text-center"
                                        data-min-value="0" data-max-value="100" data-value="90" data-type="percent">
                                        <svg class="card-slie-arrow " width="24" height="24px" viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M5,17.59L15.59,7H9V5H19V15H17V8.41L6.41,19L5,17.59Z" />
                                        </svg>
                                    </div>
                                    <div class="progress-detail">
                                        <p class="mb-2">Total Sales</p>
                                        <h4 class="counter" style="visibility: visible;">$560K</h4>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="800">
                            <div class="card-body">
                                <div class="progress-widget">
                                    <div id="circle-progress-02"
                                        class="circle-progress-01 circle-progress circle-progress-info text-center"
                                        data-min-value="0" data-max-value="100" data-value="80" data-type="percent">
                                        <svg class="card-slie-arrow " width="24" height="24" viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M19,6.41L17.59,5L7,15.59V9H5V19H15V17H8.41L19,6.41Z" />
                                        </svg>
                                    </div>
                                    <div class="progress-detail">
                                        <p class="mb-2">Total Profit</p>
                                        <h4 class="counter">$185K</h4>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="900">
                            <div class="card-body">
                                <div class="progress-widget">
                                    <div id="circle-progress-03"
                                        class="circle-progress-01 circle-progress circle-progress-primary text-center"
                                        data-min-value="0" data-max-value="100" data-value="70" data-type="percent">
                                        <svg class="card-slie-arrow " width="24" viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M19,6.41L17.59,5L7,15.59V9H5V19H15V17H8.41L19,6.41Z" />
                                        </svg>
                                    </div>
                                    <div class="progress-detail">
                                        <p class="mb-2">Total Cost</p>
                                        <h4 class="counter">$375K</h4>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="1000">
                            <div class="card-body">
                                <div class="progress-widget">
                                    <div id="circle-progress-04"
                                        class="circle-progress-01 circle-progress circle-progress-info text-center"
                                        data-min-value="0" data-max-value="100" data-value="60" data-type="percent">
                                        <svg class="card-slie-arrow " width="24px" height="24px" viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M5,17.59L15.59,7H9V5H19V15H17V8.41L6.41,19L5,17.59Z" />
                                        </svg>
                                    </div>
                                    <div class="progress-detail">
                                        <p class="mb-2">Revenue</p>
                                        <h4 class="counter">$742K</h4>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="1100">
                            <div class="card-body">
                                <div class="progress-widget">
                                    <div id="circle-progress-05"
                                        class="circle-progress-01 circle-progress circle-progress-primary text-center"
                                        data-min-value="0" data-max-value="100" data-value="50" data-type="percent">
                                        <svg class="card-slie-arrow " width="24px" height="24px" viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M5,17.59L15.59,7H9V5H19V15H17V8.41L6.41,19L5,17.59Z" />
                                        </svg>
                                    </div>
                                    <div class="progress-detail">
                                        <p class="mb-2">Net Income</p>
                                        <h4 class="counter">$150K</h4>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="1200">
                            <div class="card-body">
                                <div class="progress-widget">
                                    <div id="circle-progress-06"
                                        class="circle-progress-01 circle-progress circle-progress-info text-center"
                                        data-min-value="0" data-max-value="100" data-value="40" data-type="percent">
                                        <svg class="card-slie-arrow " width="24" viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M19,6.41L17.59,5L7,15.59V9H5V19H15V17H8.41L19,6.41Z" />
                                        </svg>
                                    </div>
                                    <div class="progress-detail">
                                        <p class="mb-2">Today</p>
                                        <h4 class="counter">$4600</h4>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="1300">
                            <div class="card-body">
                                <div class="progress-widget">
                                    <div id="circle-progress-07"
                                        class="circle-progress-01 circle-progress circle-progress-primary text-center"
                                        data-min-value="0" data-max-value="100" data-value="30" data-type="percent">
                                        <svg class="card-slie-arrow " width="24" viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M19,6.41L17.59,5L7,15.59V9H5V19H15V17H8.41L19,6.41Z" />
                                        </svg>
                                    </div>
                                    <div class="progress-detail">
                                        <p class="mb-2">Members</p>
                                        <h4 class="counter">11.2M</h4>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="swiper-button swiper-button-next"></div>
                    <div class="swiper-button swiper-button-prev"></div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-8">
            <div class="row">
                <div class="col-md-12">
                    <div class="card" data-aos="fade-up" data-aos-delay="800">
                        <div class="card-header d-flex justify-content-between flex-wrap">
                            <div class="header-title">
                                <h4 class="card-title">$855.8K</h4>
                                <p class="mb-0">Gross Sales</p>
                            </div>
                            <div class="d-flex align-items-center align-self-center">
                                <div class="d-flex align-items-center text-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" viewBox="0 0 24 24"
                                        fill="currentColor">
                                        <g id="Solid dot2">
                                            <circle id="Ellipse 65" cx="12" cy="12" r="8"
                                                fill="currentColor"></circle>
                                        </g>
                                    </svg>
                                    <div class="ms-2">
                                        <span class="text-secondary">Sales</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center ms-3 text-info">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" viewBox="0 0 24 24"
                                        fill="currentColor">
                                        <g id="Solid dot3">
                                            <circle id="Ellipse 66" cx="12" cy="12" r="8"
                                                fill="currentColor"></circle>
                                        </g>
                                    </svg>
                                    <div class="ms-2">
                                        <span class="text-secondary">Cost</span>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a href="#" class="text-secondary dropdown-toggle" id="dropdownMenuButton2"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    This Week
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton2">
                                    <li><a class="dropdown-item" href="#">This Week</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="d-main" class="d-main"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    <div class="card" data-aos="fade-up" data-aos-delay="1000">
                        <div class="card-header d-flex justify-content-between flex-wrap">
                            <div class="header-title">
                                <h4 class="card-title">Earnings</h4>
                            </div>
                            <div class="dropdown">
                                <a href="#" class="text-secondary dropdown-toggle" id="dropdownMenuButton1"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    This Week
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href="#">This Week</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div id="myChart" class="col-md-8 col-lg-8 myChart"></div>
                                <div class="d-grid gap col-md-4 col-lg-4">
                                    <div class="d-flex align-items-start">
                                        <svg class="mt-2" xmlns="http://www.w3.org/2000/svg" width="14"
                                            viewBox="0 0 24 24" fill="#3a57e8">
                                            <g id="Solid dot">
                                                <circle id="Ellipse 67" cx="12" cy="12" r="8"
                                                    fill="#3a57e8"></circle>
                                            </g>
                                        </svg>
                                        <div class="ms-3">
                                            <span class="text-secondary">Fashion</span>
                                            <h6>251K</h6>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-start">
                                        <svg class="mt-2" xmlns="http://www.w3.org/2000/svg" width="14"
                                            viewBox="0 0 24 24" fill="#4bc7d2">
                                            <g id="Solid dot1">
                                                <circle id="Ellipse 68" cx="12" cy="12" r="8"
                                                    fill="#4bc7d2"></circle>
                                            </g>
                                        </svg>
                                        <div class="ms-3">
                                            <span class="text-secondary">Accessories</span>
                                            <h6>176K</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    <div class="card" data-aos="fade-up" data-aos-delay="1200">
                        <div class="card-header d-flex justify-content-between flex-wrap">
                            <div class="header-title">
                                <h4 class="card-title">Conversions</h4>
                            </div>
                            <div class="dropdown">
                                <a href="#" class="text-secondary dropdown-toggle" id="dropdownMenuButton3"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    This Week
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton3">
                                    <li><a class="dropdown-item" href="#">This Week</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="d-activity" class="d-activity"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-12">
                    <div class="card overflow-hidden" data-aos="fade-up" data-aos-delay="400">
                        <div class="card-header d-flex justify-content-between flex-wrap">
                            <div class="header-title">
                                <h4 class="card-title mb-2">Enterprise Clients</h4>
                                <p class="mb-0">
                                    <svg class ="me-2" width="24" height="24" viewBox="0 0 24 24">
                                        <path fill="#3a57e8" d="M21,7L9,19L3.5,13.5L4.91,12.09L9,16.17L19.59,5.59L21,7Z" />
                                    </svg>
                                    15 new acquired this month
                                </p>
                            </div>
                            <div class="dropdown">
                                <span class="dropdown-toggle" id="dropdownMenuButton7" data-bs-toggle="dropdown"
                                    aria-expanded="false" role="button">
                                </span>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton7">
                                    <a class="dropdown-item " href="javascript:void(0);">Action</a>
                                    <a class="dropdown-item " href="javascript:void(0);">Another action</a>
                                    <a class="dropdown-item " href="javascript:void(0);">Something else here</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive mt-4">
                                <table id="basic-table" class="table table-striped mb-0" role="grid">
                                    <thead>
                                        <tr>
                                            <th>COMPANIES</th>
                                            <th>CONTACTS</th>
                                            <th>ORDER</th>
                                            <th>COMPLETION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img class="bg-soft-primary rounded img-fluid avatar-40 me-3"
                                                        src="{{ asset('images/shapes/01.png') }}" alt="profile">
                                                    <h6>Addidis Sportwear</h6>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="iq-media-group iq-media-group-1">
                                                    <a href="#" class="iq-media-1">
                                                        <div class="icon iq-icon-box-3 rounded-pill">SP</div>
                                                    </a>
                                                    <a href="#" class="iq-media-1">
                                                        <div class="icon iq-icon-box-3 rounded-pill">PP</div>
                                                    </a>
                                                    <a href="#" class="iq-media-1">
                                                        <div class="icon iq-icon-box-3 rounded-pill">MM</div>
                                                    </a>
                                                </div>
                                            </td>
                                            <td>$14,000</td>
                                            <td>
                                                <div class="d-flex align-items-center mb-2">
                                                    <h6>60%</h6>
                                                </div>
                                                <div class="progress bg-soft-primary shadow-none w-100"
                                                    style="height: 4px">
                                                    <div class="progress-bar bg-primary" data-toggle="progress-bar"
                                                        role="progressbar" aria-valuenow="60" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img class="bg-soft-primary rounded img-fluid avatar-40 me-3"
                                                        src="{{ asset('images/shapes/05.png') }}" alt="profile">
                                                    <h6>Netflixer Platforms</h6>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="iq-media-group iq-media-group-1">
                                                    <a href="#" class="iq-media-1">
                                                        <div class="icon iq-icon-box-3 rounded-pill">SP</div>
                                                    </a>
                                                    <a href="#" class="iq-media-1">
                                                        <div class="icon iq-icon-box-3 rounded-pill">PP</div>
                                                    </a>
                                                </div>
                                            </td>
                                            <td>$30,000</td>
                                            <td>
                                                <div class="d-flex align-items-center mb-2">
                                                    <h6>25%</h6>
                                                </div>
                                                <div class="progress bg-soft-primary shadow-none w-100"
                                                    style="height: 4px">
                                                    <div class="progress-bar bg-primary" data-toggle="progress-bar"
                                                        role="progressbar" aria-valuenow="25" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img class="bg-soft-primary rounded img-fluid avatar-40 me-3"
                                                        src="{{ asset('images/shapes/02.png') }}" alt="profile">
                                                    <h6>Shopifi Stores</h6>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="iq-media-group iq-media-group-1">
                                                    <a href="#" class="iq-media-1">
                                                        <div class="icon iq-icon-box-3 rounded-pill">PP</div>
                                                    </a>
                                                    <a href="#" class="iq-media-1">
                                                        <div class="icon iq-icon-box-3 rounded-pill">TP</div>
                                                    </a>
                                                </div>
                                            </td>
                                            <td>$8,500</td>
                                            <td>
                                                <div class="d-flex align-items-center mb-2">
                                                    <h6>100%</h6>
                                                </div>
                                                <div class="progress bg-soft-success shadow-none w-100"
                                                    style="height: 4px">
                                                    <div class="progress-bar bg-success" data-toggle="progress-bar"
                                                        role="progressbar" aria-valuenow="100" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img class="bg-soft-primary rounded img-fluid avatar-40 me-3"
                                                        src="{{ asset('images/shapes/03.png') }}" alt="profile">
                                                    <h6>Bootstrap Technologies</h6>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="iq-media-group iq-media-group-1">
                                                    <a href="#" class="iq-media-1">
                                                        <div class="icon iq-icon-box-3 rounded-pill">SP</div>
                                                    </a>
                                                    <a href="#" class="iq-media-1">
                                                        <div class="icon iq-icon-box-3 rounded-pill">PP</div>
                                                    </a>
                                                    <a href="#" class="iq-media-1">
                                                        <div class="icon iq-icon-box-3 rounded-pill">MM</div>
                                                    </a>
                                                    <a href="#" class="iq-media-1">
                                                        <div class="icon iq-icon-box-3 rounded-pill">TP</div>
                                                    </a>
                                                </div>
                                            </td>
                                            <td>$20,500</td>
                                            <td>
                                                <div class="d-flex align-items-center mb-2">
                                                    <h6>100%</h6>
                                                </div>
                                                <div class="progress bg-soft-success shadow-none w-100"
                                                    style="height: 4px">
                                                    <div class="progress-bar bg-success" data-toggle="progress-bar"
                                                        role="progressbar" aria-valuenow="100" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img class="bg-soft-primary rounded img-fluid avatar-40 me-3"
                                                        src="{{ asset('images/shapes/04.png') }}" alt="profile">
                                                    <h6>Community First</h6>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="iq-media-group iq-media-group-1">
                                                    <a href="#" class="iq-media-1">
                                                        <div class="icon iq-icon-box-3 rounded-pill">MM</div>
                                                    </a>
                                                </div>
                                            </td>
                                            <td>$9,800</td>
                                            <td>
                                                <div class="d-flex align-items-center mb-2">
                                                    <h6>100%</h6>
                                                </div>
                                                <div class="progress bg-soft-success shadow-none w-100"
                                                    style="height: 4px">
                                                    <div class="progress-bar bg-success" data-toggle="progress-bar"
                                                        role="progressbar" aria-valuenow="100" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-4">
            <div class="row">
                <div class="col-md-6 col-lg-12">
                    <div class="card credit-card-widget" data-aos="fade-up" data-aos-delay="900">
                        <div class="card-header pb-4 border-0">
                            <div class="p-4 primary-gradient-card rounded border border-white">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="font-weight-bold">VISA </h5>
                                        <P class="mb-0">PREMIUM ACCOUNT</P>
                                    </div>
                                    <div class="master-card-content">
                                        <svg class="master-card-1" width="60" height="60" viewBox="0 0 24 24">
                                            <path fill="#ffffff"
                                                d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z" />
                                        </svg>
                                        <svg class="master-card-2" width="60" height="60" viewBox="0 0 24 24">
                                            <path fill="#ffffff"
                                                d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="my-4">
                                    <div class="card-number">
                                        <span class="fs-5 me-2">5789</span>
                                        <span class="fs-5 me-2">****</span>
                                        <span class="fs-5 me-2">****</span>
                                        <span class="fs-5">2847</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-2 justify-content-between">
                                    <p class="mb-0">Card holder</p>
                                    <p class="mb-0">Expire Date</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <h6>Mike Smith</h6>
                                    <h6 class="ms-5">06/11</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-itmes-center flex-wrap  mb-4">
                                <div class="d-flex align-itmes-center me-0 me-md-4">
                                    <div>
                                        <div class="p-3 mb-2 rounded bg-soft-primary">
                                            <svg width="20" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M16.9303 7C16.9621 6.92913 16.977 6.85189 16.9739 6.77432H17C16.8882 4.10591 14.6849 2 12.0049 2C9.325 2 7.12172 4.10591 7.00989 6.77432C6.9967 6.84898 6.9967 6.92535 7.00989 7H6.93171C5.65022 7 4.28034 7.84597 3.88264 10.1201L3.1049 16.3147C2.46858 20.8629 4.81062 22 7.86853 22H16.1585C19.2075 22 21.4789 20.3535 20.9133 16.3147L20.1444 10.1201C19.676 7.90964 18.3503 7 17.0865 7H16.9303ZM15.4932 7C15.4654 6.92794 15.4506 6.85153 15.4497 6.77432C15.4497 4.85682 13.8899 3.30238 11.9657 3.30238C10.0416 3.30238 8.48184 4.85682 8.48184 6.77432C8.49502 6.84898 8.49502 6.92535 8.48184 7H15.4932ZM9.097 12.1486C8.60889 12.1486 8.21321 11.7413 8.21321 11.2389C8.21321 10.7366 8.60889 10.3293 9.097 10.3293C9.5851 10.3293 9.98079 10.7366 9.98079 11.2389C9.98079 11.7413 9.5851 12.1486 9.097 12.1486ZM14.002 11.2389C14.002 11.7413 14.3977 12.1486 14.8858 12.1486C15.3739 12.1486 15.7696 11.7413 15.7696 11.2389C15.7696 10.7366 15.3739 10.3293 14.8858 10.3293C14.3977 10.3293 14.002 10.7366 14.002 11.2389Z"
                                                    fill="currentColor"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <h5>1153</h5>
                                        <small class="mb-0">Products</small>
                                    </div>
                                </div>
                                <div class="d-flex align-itmes-center">
                                    <div>
                                        <div class="p-3 mb-2 rounded bg-soft-info">
                                            <svg width="20" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M14.1213 11.2331H16.8891C17.3088 11.2331 17.6386 10.8861 17.6386 10.4677C17.6386 10.0391 17.3088 9.70236 16.8891 9.70236H14.1213C13.7016 9.70236 13.3719 10.0391 13.3719 10.4677C13.3719 10.8861 13.7016 11.2331 14.1213 11.2331ZM20.1766 5.92749C20.7861 5.92749 21.1858 6.1418 21.5855 6.61123C21.9852 7.08067 22.0551 7.7542 21.9652 8.36549L21.0159 15.06C20.8361 16.3469 19.7569 17.2949 18.4879 17.2949H7.58639C6.25742 17.2949 5.15828 16.255 5.04837 14.908L4.12908 3.7834L2.62026 3.51807C2.22057 3.44664 1.94079 3.04864 2.01073 2.64043C2.08068 2.22305 2.47038 1.94649 2.88006 2.00874L5.2632 2.3751C5.60293 2.43735 5.85274 2.72207 5.88272 3.06905L6.07257 5.35499C6.10254 5.68257 6.36234 5.92749 6.68209 5.92749H20.1766ZM7.42631 18.9079C6.58697 18.9079 5.9075 19.6018 5.9075 20.459C5.9075 21.3061 6.58697 22 7.42631 22C8.25567 22 8.93514 21.3061 8.93514 20.459C8.93514 19.6018 8.25567 18.9079 7.42631 18.9079ZM18.6676 18.9079C17.8282 18.9079 17.1487 19.6018 17.1487 20.459C17.1487 21.3061 17.8282 22 18.6676 22C19.4969 22 20.1764 21.3061 20.1764 20.459C20.1764 19.6018 19.4969 18.9079 18.6676 18.9079Z"
                                                    fill="currentColor"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <h5>81K</h5>
                                        <small class="mb-0">Order Served</small>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <div class="d-flex justify-content-between flex-wrap">
                                    <h2 class="mb-2">$405,012,300</h2>
                                    <div>
                                        <span class="badge bg-success rounded-pill">YoY 24%</span>
                                    </div>
                                </div>
                                <p class="text-info">Life time sales</p>
                            </div>
                            <div class="d-grid grid-cols-2 gap">
                                <button class="btn btn-primary text-uppercase p-2">SUMMARY</button>
                                <button class="btn btn-info text-uppercase p-2">ANALYTICS</button>
                            </div>
                        </div>
                    </div>
                    <div class="card" data-aos="fade-up" data-aos-delay="300">
                        <div class="card-body d-flex justify-content-around text-center">
                            <div>
                                <h2 class="mb-2">750<small>K</small></h2>
                                <p class="mb-0 text-secondary">Website Visitors</p>
                            </div>
                            <hr class="hr-vertial">
                            <div>
                                <h2 class="mb-2">7,500</h2>
                                <p class="mb-0 text-secondary">New Customers</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-12">
                    <div class="card" data-aos="fade-up" data-aos-delay="400">
                        <div class="card-header d-flex justify-content-between flex-wrap">
                            <div class="header-title">
                                <h4 class="card-title mb-2">Activity overview</h4>
                                <p class="mb-0">
                                    <svg class ="me-2" width="24" height="24" viewBox="0 0 24 24">
                                        <path fill="#17904b"
                                            d="M13,20H11V8L5.5,13.5L4.08,12.08L12,4.16L19.92,12.08L18.5,13.5L13,8V20Z" />
                                    </svg>
                                    16% this month
                                </p>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class=" d-flex profile-media align-items-top mb-2">
                                <div class="profile-dots-pills border-primary mt-1"></div>
                                <div class="ms-4">
                                    <h6 class=" mb-1">$2400, Purchase</h6>
                                    <span class="mb-0">11 JUL 8:10 PM</span>
                                </div>
                            </div>
                            <div class=" d-flex profile-media align-items-top mb-2">
                                <div class="profile-dots-pills border-primary mt-1"></div>
                                <div class="ms-4">
                                    <h6 class=" mb-1">New order #8744152</h6>
                                    <span class="mb-0">11 JUL 11 PM</span>
                                </div>
                            </div>
                            <div class=" d-flex profile-media align-items-top mb-2">
                                <div class="profile-dots-pills border-primary mt-1"></div>
                                <div class="ms-4">
                                    <h6 class=" mb-1">Affiliate Payout</h6>
                                    <span class="mb-0">11 JUL 7:64 PM</span>
                                </div>
                            </div>
                            <div class=" d-flex profile-media align-items-top mb-2">
                                <div class="profile-dots-pills border-primary mt-1"></div>
                                <div class="ms-4">
                                    <h6 class=" mb-1">New user added</h6>
                                    <span class="mb-0">11 JUL 1:21 AM</span>
                                </div>
                            </div>
                            <div class=" d-flex profile-media align-items-top mb-1">
                                <div class="profile-dots-pills border-primary mt-1"></div>
                                <div class="ms-4">
                                    <h6 class=" mb-1">Product added</h6>
                                    <span class="mb-0">11 JUL 4:50 AM</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection --}}
@section('content')
    {{-- <div class="container-fluid" style="margin-top: 1px;"> --}}
        <!-- Content Row -->
        <div class="card mb-4">
            {{-- <div class="card-header py-3">
                <h5 class="text-primary mx-3"><b><i class="icon-line-database" style="padding-right: 5px"></i>
                        CHECKLIST EQM STATUS</b>
                </h5>
            </div> --}}
            <div class="card-body">

                <div class="row" id="progress-container-1">

                </div>
                <br>
                <div class="row">

                    <div class=" col-sm-6 col-xl-3 mb-3 bottommargin-sm">

                        <label for="">Machine-ID</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Nhập code machine"
                                aria-label="Nhập code machine" aria-describedby="Code_machine" id="Code_machine">
                            <button class="btn btn-outline-secondary btn-primary" type="button"
                                id="Scan_QR">Scan</button>
                        </div>
                    </div>
                    <div class=" col-sm-6 col-xl-3 mb-3 bottommargin-sm">
                        <label for="">Date Search</label>
                        <div class="input-daterange component-datepicker input-group">
                            <input type="text" value="" class="form-control text-start" id="date_form"
                                placeholder="YYYY-MM-DD">
                        </div>
                    </div>
                    <div class="col-sm-4 col-xl-2 mb-3">
                        <span>Line:</span>
                        <select name="line" id="Line_search" class="form-select">
                        </select>
                    </div>
                    <div class="col-sm-4 col-xl-2 mb-3">
                        <span>Shift:</span>
                        <select name="shift" id="shift_search" class="form-select">
                            <option value="">All</option>
                            <option value="Ca ngày">Ca ngày</option>
                            <option value="Ca đêm">Ca đêm</option>

                        </select>
                    </div>
                    <div class="col-sm-4 col-xl-2 mb-3">
                        <span>Tình trạng:</span>
                        <select name="shift" id="Status_search" class="form-select">
                            <option value="">All</option>
                            <option value="Completed">Completed</option>
                            <option value="Pending" selected>Pending</option>

                        </select>
                    </div>
                </div>
                <br>

                <div class="table-responsive">
                    <table id="table_check_list_search" class="table table-bordered table-hover"
                        style="width:100%;border-collapse:collapse;">
                    </table>
                </div>


            </div>
        </div>



        {{-- model show check list --}}

        <div class="modal" id="modal-check">
            <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
                <div class="modal-content">
                    {{-- <div class="modal-header">
                        <h5 class="text-primary mx-3"><b><i class="icon-line-check-square"
                                    style="padding-right: 5px"></i>CHECK LIST
                                EQM ILSUNG</b>
                        </h5>
                        </h5>
                    </div>
                    <div class="modal-footer mx-5">
                        <button type="button" id="save-check-list" class="btn btn-success">Save
                        </button>
                        <button type="button" id="update-check-list" class="btn btn-success">Update
                        </button>
                        <button type="button" class="btn btn-warning close close-model-checklist"
                            id="close-model">Close</button>
                    </div> --}}

                    <div class="modal-header d-flex justify-content-between align-items-center">
                        <!-- Tiêu đề bên trái -->
                        <h5 class="text-primary mx-3">
                            CHECK LIST EQM
                        </h5>

                        <!-- Các nút button nằm bên phải -->
                        <div>
                            <button type="button" id="save-check-list" class="btn btn-success">Save</button>
                            <button type="button" id="update-check-list" class="btn btn-success">Update</button>
                            <button type="button" class="btn btn-warning close close-model-checklist"
                                id="close-model">Close</button>
                        </div>
                    </div>
                    <div class="modal-body" style="background-color: white">
                        <div class="row">


                            <div class="col-sm-4 col-xl-2 mb-3">
                                <span>Model:</span>
                                <select name="model" id="Model" class="form-select">
                                </select>
                            </div>
                            <div class="col-sm-4 col-xl-2 mb-3">
                                <span>Line:</span>
                                <select name="line" id="Line" class="form-select">
                                </select>
                            </div>
                            <div class="col-sm-4 col-xl-2 mb-3">
                                <span>Machine:</span>
                                <select name="Machine" id="Machine" class="form-select">
                                </select>
                            </div>
                            <div class="col-sm-4 col-xl-2 mb-3">
                                <span>Machine-ID:</span>

                                <input name="ID_machine" type="text" id="ID_machine" class="form-control"
                                    placeholder="Chọn ID máy...">
                                <div id="suggestions" style="border: 1px solid #ccc; display: none;"></div>
                                <div id="error-message" style="color: red; display: none;"></div>


                            </div>

                            <div class="col-sm-4 col-xl-2 mb-3">
                                <span>Item check list:</span>
                                <select name="item" id="Checklist_item" class="form-select">
                                </select>
                            </div>
                            <div class="col-sm-4 col-xl-2 mb-3">
                                <span>Khung check:</span>
                                <select name="shift" id="Khung_gio" class="form-select">
                                </select>
                            </div>
                        </div>
                        <br>
                        <table class="table table-bordered text-center mt-4 table-hover" id="table-check-list"
                            style="width: 100%; text-align: center; vertical-align:middle">
                            <thead class="table-success">
                                <tr>
                                    <th style="width:3%" rowspan="2">STT</th>
                                    <th style="width:77" rowspan="2">Nội dung</th>
                                    <th style="width:10%" colspan="2">Tình trạng</th>
                                    <th style="width:10%" rowspan="2">Vấn đề</th>
                                </tr>
                                <tr>
                                    <th style="width:5%">OK</th>
                                    <th style="width:5%">NG</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- modal Scan --}}
        <div class="modal" id="modal-scan">
            <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="text-primary mx-3">Quét QR Code</b>
                        </h5>

                    </div>
                    <div class="modal-footer mx-5">
                        <button type="button" class="btn btn-warning close close-model-scan"
                            id="close-model-scan">Close</button>
                    </div>
                    <div class="modal-body mx-5" style="background-color: white; ">
                        <div id="qr-reader" style="width:100%"></div>
                        <button id="closeScanBtn" style="display: none;">Đóng Quét</button>
                    </div>
                </div>
            </div>
        </div>


    {{-- </div> --}}
@endsection

@section('admin-js')
    <script src="{{ asset('checklist-ilsung/html5.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var colum_table = [];
            var line_check = @json($line_id);
            var tables;
            var tables_check;
            var table_edit;
            var table = 'result';
            var table_2 = 'result_detail'
            var table_result = table;
            var table_result_detail = table_2;
            var ID_machine_list = [];
            var shift;
            var currentDate = new Date();
            var date = currentDate.toISOString().split('T')[0];
            $('#date_form').val(date);

            localStorage.setItem('activeItem', 'Checklist');
            var activeItem = localStorage.getItem('activeItem');
            let list = document.querySelectorAll(".sidebar-body-menu a");
            list.forEach((item) => item.addEventListener('click', activeLink));
            if (activeItem) {
                var selectedItem = document.getElementById(activeItem);
                if (selectedItem) {
                    selectedItem.classList.add('active');
                }
            }


            function activeLink() {
                var itemId = this.id;
                list.forEach((item) => {
                    item.classList.remove("active");
                });
                this.classList.add("active");
                localStorage.setItem('activeItem', itemId);
            }
            show_master_check();
            show_master_status();

            function reader_QR() {
                var lastResult, countResults = 0;

                function onScanSuccess(decodedText, decodedResult) {
                    if (decodedText !== lastResult) {
                        ++countResults;
                        lastResult = decodedText;
                        // Handle on success condition with the decoded message.

                        $('#Code_machine').val(lastResult);
                        // console.log(`Scan result ${decodedText}`, decodedResult);
                        html5QrcodeScanner.clear();
                        $('#modal-scan').modal('hide');
                        search();
                        show_overview()

                    }
                }


                html5QrcodeScanner = new Html5QrcodeScanner(
                    "qr-reader", {
                        fps: 10,
                        qrbox: 250,
                        experimentalFeatures: {
                            useBarCodeDetectorIfSupported: true
                        },
                        rememberLastUsedCamera: true,
                        showTorchButtonIfSupported: true
                    });
                html5QrcodeScanner.render(onScanSuccess);
            }




            const qrInput = document.getElementById('Scan_QR');
            qrInput.addEventListener('click', () => {
                $('#modal-scan').modal('show');
                reader_QR();
            });

            function show_master_status() {
                $.ajax({
                    type: "GET",
                    url: "{{ route('check.list.masster') }}",
                    dataType: "json",
                    success: function(response) {
                        $('#line_search').empty();
                        $.each(response.line, function(index, value) {
                            $('#Line_search').append($('<option>', {
                                value: value.id,
                                text: value.line_name,
                            }));
                        });

                        // $('#Line_search option:selected').text(line_check);
                        $('#Line_search').val(line_check);
                        search();
                        show_overview();


                    }
                });

            }

            function show_master_check() {
                $.ajax({
                    type: "GET",
                    url: "{{ route('check.list.masster') }}",
                    dataType: "json",
                    // data: {
                    //     id: "1"
                    // },
                    success: function(response) {
                        $('#Machine').empty();
                        $('#ID_machine').empty();
                        $('#line').empty();
                        $('#Model').empty();
                        $('#line').empty();
                        $('#Checklist_item').empty();
                        $('#Khung_gio').empty();
                        $('#Machine').append($('<option>', {
                            value: "",
                            text: "---",
                        }));
                        $('#Checklist_item').append($('<option>', {
                            value: "",
                            text: "---",
                        }));

                        $('#Khung_gio').append($('<option>', {
                            value: "",
                            text: "---",
                        }));

                        $('#Model').append($('<option>', {
                            value: "",
                            text: "---",
                        }));

                        ID_machine_list = [];
                        $.each(response.machine, function(index, value) {
                            $('#Machine').append($('<option>', {
                                value: value.id,
                                text: value.Machine,
                            }));
                        });
                        $.each(response.line, function(index, value) {
                            $('#Line').append($('<option>', {
                                value: value.id,
                                text: value.line_name,
                            }));
                        });
                        $.each(response.model, function(index, value) {
                            $('#Model').append($('<option>', {
                                value: value.id,
                                text: value.model,
                            }));
                        });



                        // $("#ID_machine").autocomplete({
                        //     source: ID_machine_list,
                        //     minLength: 0, // Để hiển thị gợi ý ngay khi nhấp vào ô
                        //     focus: function(event, ui) {
                        //         event.preventDefault(); // Ngăn chặn việc điền tự động
                        //     },
                        //     select: function(event, ui) {
                        //         $('#ID_machine').val(ui.item
                        //             .value); // Điền giá trị đã chọn vào input
                        //         return false; // Ngăn chặn hành vi mặc định
                        //     }
                        // }).focus(function() {
                        //     $(this).autocomplete('search',
                        //         ''); // Tìm kiếm tất cả gợi ý khi nhấp vào
                        // });


                    }
                });

            }

            function show_model_check() {
                $.ajax({
                    type: "GET",
                    url: "{{ route('check.list.masster') }}",
                    dataType: "json",
                    success: function(response) {

                        $('#Model').empty();
                        $('#Model').append($('<option>', {
                            value: "",
                            text: "---",
                        }));
                        $.each(response.model, function(index, value) {
                            $('#Model').append($('<option>', {
                                value: value.id,
                                text: value.model,
                            }));
                        });
                    }
                });

            }

            function show_overview() {
                $('#progress-container-1').html("");
                var shift_search = $('#shift_search option:selected').text();
                var date_form = ($('#date_form').val());
                var line = $('#Line_search option:selected').text();
                $.ajax({
                    url: "{{ route('checklist.overview') }}",
                    method: 'GET',

                    dataType: "json",
                    data: {
                        shift: shift_search,
                        date_form: date_form,
                        line: line
                    },
                    success: function(data) {
                        var data_detail = data.progressData;
                        data_detail.forEach(item => {
                            createProgressBar(item.Locations + '  - (' + data
                                .completed_checklists +
                                '/' + data.total_checklists + ')', item
                                .completion_percentage);
                        });
                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    }
                });

            }

            $('#Line_search').on('change', function(e) {
                e.preventDefault();
                search();
                show_overview()

            });

            $('#Code_machine').on('change', function(e) {
                e.preventDefault();
                search();
                show_overview()

            });
            $('#Shift_search').on('change', function(e) {
                e.preventDefault();
                search();
                show_overview()

            });

            $('#date_form').on('change', function(e) {
                e.preventDefault();
                search();
                show_overview()

            });
            $('#Status_search').on('change', function(e) {
                e.preventDefault();
                search();
                show_overview()

            });

            function createProgressBar(line, completion) {
                const progressContainer = $('#progress-container-1');
                const progressCol = $('<div>').addClass('col-xl-8 col-sm-8');
                const progressDiv = $('<div>').addClass('progress').attr('data-line', line);
                const progressBar = $('<div>').addClass('progress-bar').css({
                    width: `${completion}%`,
                    background: '#25babc'
                });

                const progressValue = $('<div>').addClass('progress-value').html(`<span>${completion}</span>%`);
                const progressTitle = $('<div>').addClass('progressbar-title').html(
                    'Rate completed ' + line);

                progressBar.append(progressValue).append(progressTitle);
                progressDiv.append(progressBar);
                progressCol.append(progressDiv);
                progressContainer.append(progressCol);

            }

            function show_check_list(ID_checklist) {
                console.log(ID_checklist);
                $.ajax({
                    type: "GET",
                    url: '{{ route('check.list.search') }}',
                    data: {
                        item_check: ID_checklist,
                    },
                    success: function(response) {
                        // console.log(response.data_checklist);
                        // $('#table-check-list').DataTable().destroy();
                        var count = 0;
                        var data = [];
                        $.each(response.data_checklist, function(index, value) {
                            count++;
                            var status_OK =
                                '<input type="radio" class="btn-check status_OK" name="options-outlined_' +
                                value.id + '" autocomplete="off"  check_id="' +
                                value.id + '" id="status_OK_' + value.id + '">' +
                                '<label class="btn btn-outline-success" for="status_OK_' + value
                                .id + '">OK</label>';

                            // ' <input type="checkbox" value="OK" class="status_OK" check_id="' +
                            // value.id + '" id="status_OK_' + value.id + '" > ';
                            var status_NG =
                                '<input type="radio" class="btn-check status_NG" name="options-outlined_' +
                                value.id + '" autocomplete="off"  check_id="' +
                                value.id + '" id="status_NG_' + value.id + '">' +
                                '<label class="btn btn-outline-danger" for="status_NG_' + value
                                .id + '">NG</label>';


                            // ' <input type="checkbox" value="NG" class="status_NG" check_id="' +
                            // value.id + '" id="status_NG_' + value.id + '" > ';
                            var problem =
                                '<input name="problem"  type="text" id="' + value.id +
                                '" class="form-control problem">';

                            data.push([
                                count,
                                value.Hang_muc,
                                status_OK,
                                status_NG,
                                problem,
                            ]);
                        });
                        $('#table-check-list').DataTable().destroy();
                        $('#table-check-list').DataTable({
                            data: data,
                            "info": false,
                            'ordering': false,
                            'searching': false,
                            "lengthMenu": [
                                [-1],
                                ["Show all"]
                            ]
                        });

                        // document.querySelectorAll(".status_OK").forEach(function(okCheckbox) {
                        //     okCheckbox.addEventListener('change', function() {
                        //         // Lấy id của mục hiện tại
                        //         const itemId = okCheckbox.getAttribute('check_id');
                        //         console.log(itemId);
                        //         // const ngCheckbox = document.querySelector('.status_NG[data-id="' + itemId +
                        //         //     '"]');
                        //         const Id = "status_NG_" + itemId;
                        //         const ngCheckbox = document.getElementById(Id);


                        //         // Nếu checkbox OK được chọn, bỏ chọn checkbox NG
                        //         if (okCheckbox.checked) {
                        //             ngCheckbox.checked = false;
                        //         }
                        //     });
                        // });

                        // document.querySelectorAll('.status_NG').forEach(function(ngCheckbox) {
                        //     ngCheckbox.addEventListener('change', function() {
                        //         // Lấy id của mục hiện tại
                        //         const itemId = ngCheckbox.getAttribute('check_id');
                        //         const Id = "status_OK_" + itemId;
                        //         console.log(itemId);
                        //         // const okCheckbox = document.querySelector('.status_OK[data-id="' + itemId +
                        //         //     '"]');
                        //         const okCheckbox = document.getElementById(Id);

                        //         // Nếu checkbox NG được chọn, bỏ chọn checkbox OK
                        //         if (ngCheckbox.checked) {
                        //             okCheckbox.checked = false;
                        //         }
                        //     });
                        // });


                    }
                });
            }

            function show_check_list_edit(ID_checklist) {
                console.log(ID_checklist);
                $.ajax({
                    type: "GET",
                    url: '{{ route('check.list.edit.search') }}',
                    data: {
                        id_checklist: ID_checklist,
                    },
                    success: function(response) {
                        console.log(response.data_checklist);
                        // $('#table-check-list').DataTable().destroy();
                        var count = 0;
                        var data = [];
                        $.each(response.data_checklist, function(index, value) {
                            count++;

                            if (value.Check_status == "OK") {
                                var status_OK =
                                    '<input type="radio" class="btn-check status_OK" name="options-outlined_' +
                                    value.id + '" autocomplete="off"  check_id="' +
                                    value.id + '" id="status_OK_' + value.id + '" checked>' +
                                    '<label class="btn btn-outline-success" for="status_OK_' +
                                    value
                                    .id + '">OK</label>';

                                var status_NG =
                                    '<input type="radio" class="btn-check status_NG" name="options-outlined_' +
                                    value.id + '" autocomplete="off"  check_id="' +
                                    value.id + '" id="status_NG_' + value.id + '">' +
                                    '<label class="btn btn-outline-danger" for="status_NG_' +
                                    value
                                    .id + '">NG</label>';
                            } else {
                                var status_OK =
                                    '<input type="radio" class="btn-check status_OK" name="options-outlined_' +
                                    value.id + '" autocomplete="off"  check_id="' +
                                    value.id + '" id="status_OK_' + value.id + '">' +
                                    '<label class="btn btn-outline-success" for="status_OK_' +
                                    value
                                    .id + '">OK</label>';

                                var status_NG =
                                    '<input type="radio" class="btn-check status_NG" name="options-outlined_' +
                                    value.id + '" autocomplete="off"  check_id="' +
                                    value.id + '" id="status_NG_' + value.id + '" checked>' +
                                    '<label class="btn btn-outline-danger" for="status_NG_' +
                                    value
                                    .id + '">NG</label>';

                            }
                            if (value.Status == null) {
                                var Status = "";
                            } else {
                                var Status = value.Status;
                            }

                            var problem =
                                '<input name="problem"  type="text" id="' + value.id +
                                '" class="form-control problem" value="' + Status + '">';

                            data.push([
                                count,
                                value.Hang_muc,
                                status_OK,
                                status_NG,
                                problem,
                            ]);
                        });
                        $('#table-check-list').DataTable().destroy();
                        $('#table-check-list').DataTable({
                            data: data,
                            "info": false,
                            'ordering': false,
                            'searching': false,
                            "lengthMenu": [
                                [-1],
                                ["Show all"]
                            ]
                        });


                    }
                });
            }

            // function show_check_list_edit(ID_checklist) {
            //     console.log(ID_checklist);
            //     $.ajax({
            //         type: "GET",
            //         url: '{{ route('check.list.edit.search') }}',
            //         data: {
            //             id_checklist: ID_checklist,
            //         },
            //         success: function(response) {
            //             console.log(response.data_checklist);
            //             $('#table-check-list').DataTable().destroy();
            //             var count = 0;
            //             var data = [];
            //             $.each(response.data_checklist, function(index, value) {
            //                 count++;
            //                 if (value.Check_status == "OK")
            //                     var status =
            //                         '<select name = "status" id="' + value.id +
            //                         '" class="form-select">\
            //                                                                                                                                                                                                                                                                                              <option value = "OK" selected>OK</option>\
            //                                                                                                                                                                                                                                                                                             <option value = "NG">NG</option>\
            //                                                                                                                                                                                                                                                                                              </select>';

            //                 else {
            //                     var status =
            //                         '<select name = "status" id="' + value.id +
            //                         '" class="form-select">\
            //                                                                                                                                                                                                                                                                                              <option value = "OK">OK</option>\
            //                                                                                                                                                                                                                                                                                             <option value = "NG" selected>NG</option>\
            //                                                                                                                                                                                                                                                                                              </select>';
            //                 }
            //                 var problem =
            //                     '<input name="problem" type="text" id="' + value.id +
            //                     '" class="form-control">';
            //                 var process =
            //                     '<select name = "process" id="' + value.id +
            //                     '"class="form-select">\
            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <option value = "OK"></option>\
            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <option value = "Complete">Complete</option>\
            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <option value = "Pending">Pending</option>\
            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <option value = "Improgress" >Improgress</option>\
            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         </select >';
            //                 data.push([
            //                     count,
            //                     value.Machine,
            //                     value.item_checklist,
            //                     value.Hang_muc,
            //                     value.Khung_check,
            //                     status,
            //                     problem,
            //                     process
            //                 ]);
            //             });
            //             $('#table-check-list').DataTable().destroy();
            //             $('#table-check-list').DataTable({
            //                 data: data,
            //                 "info": false,
            //                 'ordering': false,
            //                 'searching': false,
            //                 "lengthMenu": [
            //                     [-1],
            //                     ["Show all"]
            //                 ]
            //             });

            //         }
            //     });
            // }

            function search() {

                if (tables) {
                    $('#table_check_list_search').DataTable().destroy();
                }
                var line_search = $('#Line_search option:selected').text();
                var shift_search = $('#shift_search option:selected').text();
                var Status_search = $('#Status_search option:selected').text();
                var Code_machine = $('#Code_machine').val();
                var date_form = ($('#date_form').val());
                if ($('#date_form').val() == 0) {
                    alert('Vui lòng chọn thời gian kiểm tra');
                } else {
                    $.ajax({
                        type: "POST",
                        url: '{{ route('check.list.overview') }}',
                        dataType: 'json',
                        data: {
                            line: line_search,
                            shift: shift_search,
                            date_form: date_form,
                            Status: Status_search,
                            Code_machine: Code_machine,
                        },
                        success: function(users) {
                            var count = 0;
                            var data = [];
                            var colum = [];
                            var data;
                            console.log(users.data);
                            $.each(users.data, function(index, value) {
                                count++;
                                if (value.Check_status == "Completed") {
                                    var view =
                                        '<button type="button" value="' + value
                                        .id +
                                        '" data-bs-toggle="modal" data-bs-target="#modal-check" class="btn btn-success view-show check editbtn btn-sm" id="' +
                                        value.ID_checklist + '">View</button>' +
                                        ' <input type="hidden" value="' + value.ID_checklist +
                                        '" id="' + value.id + '">' +
                                        '<button type="button" value="' + value
                                        .id +
                                        '" data-bs-toggle="modal" data-bs-target="#modal-check" class="btn btn-warning view-edit check editbtn btn-sm" id="' +
                                        value.ID_checklist + '">Edit</button>' +
                                        ' <input type="hidden" value="' + value.ID_checklist +
                                        '" id="' + value.id + '">' +
                                        '<button type="button" value="' + value
                                        .id +
                                        '" data-bs-toggle="modal" data-bs-target="#modal-delete" class="btn btn-danger view-delete check editbtn btn-sm" id="' +
                                        value.ID_checklist + '">Delete</button>' +
                                        ' <input type="hidden" value="' + value.ID_checklist +
                                        '" id="' + value.id + '">';
                                } else if (value.Check_status == "Pending") {
                                    var view =
                                        '<button type="button" value="' +
                                        value
                                        .id +
                                        '" data-bs-toggle="modal" data-bs-target="#modal-check" class="btn btn-primary  view-check check editbtn btn-sm" id="' +
                                        value.ID_checklist + '">Check</button>' +
                                        '<input type="hidden" value ="' + value.ID_checklist +
                                        '" id="' + value.id + '">';
                                } else {
                                    var view = '<button type="button" value="' + value
                                        .id +
                                        '" data-bs-toggle="modal" data-bs-target="#modal-delete" class="btn btn-danger view-delete check editbtn btn-sm" id="' +
                                        value.ID_checklist + '">Delete All</button>' +
                                        ' <input type="hidden" value="' + value.ID_checklist +
                                        '" id="' + value.id + '">';
                                }
                                data.push([
                                    count,
                                    value.Locations,
                                    value.Model,
                                    value.Machine,
                                    value.Code_machine,
                                    value.item_checklist,
                                    value.Khung_check,
                                    // value.Shift,
                                    // value.Check_status,
                                    // value.Date_check,
                                    view,
                                ]);
                            });

                            var header =
                                '<thead class="table-success" style="text-align: center; vertical-align:middle">' +
                                '<tr style="text-align: center">' +
                                '<th style="text-align: center">STT</th>' +
                                '<th style="text-align: center">Line</th>' +
                                '<th style="text-align: center">Model</th>' +
                                '<th style="text-align: center">Machine</th>' +
                                '<th style="text-align: center">Code QL</th>' +
                                '<th style="text-align: center">Check List</th>' +
                                '<th style="text-align: center">Khung check</th>' +
                                // '<th style="text-align: center">Shift</th>' +
                                // '<th style="text-align: center">Trạng thái</th>' +
                                // '<th style="text-align: center">Date</th>' +
                                '<th style="text-align: center">Edit</th>' +
                                '</tr>'
                            '</thead>'

                            $('#table_check_list_search').html(header);
                            tables = $('#table_check_list_search').DataTable({
                                data: data,
                                "info": true,
                                'ordering': false,
                                'autowidth': true,
                                // "dom": 'Bfrtip',
                                select: {
                                    style: 'single',
                                },

                            });
                        }
                    });
                }
            };


            var id_checklist_detail = 0;
            $(document).on('click', '.view-check', function(e) {
                e.preventDefault();
                // show_model_check();
                const button1 = document.getElementById('save-check-list');
                button1.style.display = 'unset'; // Ẩn button
                const button2 = document.getElementById('update-check-list');
                button2.style.display = 'none'; // Ẩn button
                id_checklist_detail = $(this).val();
                id_checklist = this.id;

                rowSelected = tables.rows('.selected').indexes();
                if (rowSelected.length > 0) {
                    var rowData = tables.row(rowSelected[0]).data();
                    // Lấy dữ liệu của dòng đầu tiên được chọn
                    $('#Machine option').text(rowData[3]);
                    $('#ID_machine').val(rowData[4]);
                    $('#line option').text(rowData[1]);
                    $('#Checklist_item option').text(rowData[5]);
                    $('#Khung_gio option').text(rowData[6]);
                    date = rowData[9];
                    shift = rowData[7];
                    $('#Model option:selected').filter(function() {
                        return $(this).text() === rowData[2];
                    }).prop('selected', true);

                    $('#Model').prop('disabled', false);
                    $('#Machine').prop('disabled', true);
                    $('#ID_machine').prop('disabled', true);
                    $('#Line').prop('disabled', true);
                    $('#Checklist_item').prop('disabled', true);
                    $('#Khung_gio').prop('disabled', true);
                }


                show_check_list(id_checklist)

            });

            $(document).on('click', '.view-edit', function(e) {
                e.preventDefault();
                const button1 = document.getElementById('save-check-list');
                button1.style.display = 'none'; // Ẩn button
                const button2 = document.getElementById('update-check-list');
                button2.style.display = 'unset'; // Ẩn button
                id_checklist_detail = $(this).val();
                id_checklist = this.id;

                rowSelected = tables.rows('.selected').indexes();
                if (rowSelected.length > 0) {
                    var rowData = tables.row(rowSelected[0]).data();
                    // Lấy dữ liệu của dòng đầu tiên được chọn
                    $('#Machine option').text(rowData[3]);
                    $('#ID_machine').val(rowData[4]);
                    $('#line option').text(rowData[1]);
                    $('#Checklist_item option').text(rowData[5]);
                    $('#Khung_gio option').text(rowData[6]);
                    $('#Model option:selected').text(rowData[2]);
                    date = rowData[9];
                    shift = rowData[7];

                    $('#Model option:selected').filter(function() {
                        return $(this).text() === rowData[2];
                    }).prop('selected', true);

                    $('#Model').prop('disabled', false);
                    $('#Machine').prop('disabled', true);
                    $('#ID_machine').prop('disabled', true);
                    $('#Line').prop('disabled', true);
                    $('#Checklist_item').prop('disabled', true);
                    $('#Khung_gio').prop('disabled', true);
                }


                show_check_list_edit(id_checklist_detail)

            });

            $(document).on('click', '.view-show', function(e) {
                e.preventDefault();
                const button1 = document.getElementById('save-check-list');
                button1.style.display = 'none'; // Ẩn button
                const button2 = document.getElementById('update-check-list');
                button2.style.display = 'none'; // Ẩn button
                id_checklist_detail = $(this).val();
                id_checklist = this.id;

                rowSelected = tables.rows('.selected').indexes();
                if (rowSelected.length > 0) {
                    var rowData = tables.row(rowSelected[0]).data();
                    // Lấy dữ liệu của dòng đầu tiên được chọn
                    $('#Machine option').text(rowData[3]);
                    $('#ID_machine').val(rowData[4]);
                    $('#line option').text(rowData[1]);
                    $('#Checklist_item option').text(rowData[5]);
                    $('#Khung_gio option').text(rowData[6]);
                    $('#Model option:selected').text(rowData[2]);
                    date = rowData[9];
                    shift = rowData[7];

                    $('#Model option:selected').filter(function() {
                        return $(this).text() === rowData[2];
                    }).prop('selected', true);

                    $('#Model').prop('disabled', true);
                    $('#Machine').prop('disabled', true);
                    $('#ID_machine').prop('disabled', true);
                    $('#Line').prop('disabled', true);
                    $('#Checklist_item').prop('disabled', true);
                    $('#Khung_gio').prop('disabled', true);
                }


                show_check_list_edit(id_checklist_detail)

            });


            $(document).on('click', '.view-delete', function() {
                const idChecklist = $(this).val(); // Lấy ID của checklist từ nút
                // id_checklist_detail = $(this).val();
                const row = $(this).closest('tr'); // Lưu tham chiếu đến dòng chứa nút
                if (confirm('Bạn có chắc chắn muốn xóa không?')) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('delete.check.list', ':id') }}".replace(':id', idChecklist),
                        success: function(response) {
                            if (response.status === 200) {
                                alert('Xóa thành công');
                                // Cập nhật lại bảng hoặc xóa hàng đã xóa
                                $('#table_check_list_search').DataTable().row(row).remove()
                                    .draw();

                            } else {
                                alert('Có lỗi xảy ra. Không thể xóa.');
                            }
                        },
                        error: function() {
                            alert('Có lỗi xảy ra. Không thể xóa.');
                        }
                    });
                }
            });


            $(document).on('click', '#save-check-list', function(e) {
                e.preventDefault();
                let shouldExit = false;
                const line = $('#Line option:selected').text();
                const Model = $('#Model option:selected').text();
                const Machine = $('#Machine option:selected').text();
                const Khung_gio = $('#Khung_gio option:selected').text();
                const ID_machine = $('#ID_machine').val();
                const Checklist_item = $('#Checklist_item option:selected').text();
                const data = {
                    id_checklist: id_checklist_detail,
                    Model,
                    date,
                    ID_machine,
                    details: [] // Thêm một mảng để chứa các chi tiết
                };
                $('#table-check-list').DataTable().rows().every(function() {
                    if (shouldExit) {
                        return false; // Nếu flag là true, thoát khỏi vòng lặp
                    }
                    const rowData = this.data();
                    const problems = $(this.node()).find('.problem').val();
                    const status_OK = $(this.node()).find('.status_OK').prop('checked');
                    const status_NG = $(this.node()).find('.status_NG').prop('checked');
                    if (!status_OK && !status_NG) {
                        shouldExit = true;
                        return;
                    } else {
                        if (status_OK) {
                            var status = 'OK';
                        } else {
                            var status = 'NG';
                        }
                        data.details.push({
                            Locations: line,
                            Model: Model,
                            ID_item_checklist: "1",
                            Machine: Machine,
                            Hang_muc: rowData[1],
                            item_checklist: Checklist_item,
                            Khung_check: Khung_gio,
                            Shift: shift,
                            Code_machine: ID_machine,
                            Check_status: status,
                            Status: problems,
                            // Remark: process,
                            Date_check: date
                        });
                    }


                });

                if (Model === "---") {
                    return alert("Vui lòng chọn model, nếu không có thì chọn COMMON");
                } else if (shouldExit) {
                    alert("Kiểm tra hạng mục checklist chưa check");
                } else {
                    // Gửi yêu cầu AJAX với cả hai dữ liệu
                    $.ajax({
                        type: "POST",
                        url: "{{ route('save.check.list', ':table') }}".replace(':table',
                            'checklist_result'),
                        dataType: 'json',
                        data: JSON.stringify(data), // Chuyển đổi thành chuỗi JSON
                        contentType: 'application/json',
                        success: function(response) {
                            if (response.status === 400) {
                                return alert('Update plan check list');
                            }
                            alert('Lưu check-list thành công');
                            $('#table_check_list').DataTable().clear();
                            show_overview();
                            $('#modal-check').modal('hide');
                        },
                        error: function() {
                            alert('Lưu check-list thất bại');
                        }
                    });
                    search();
                }



            });


            $(document).on('click', '#update-check-list', function(e) {
                e.preventDefault();
                var data = [];
                // var data2 = [];
                let shouldExit = false;
                var line = $('#Line option:selected').text();
                var Model = $('#Model option:selected').text();
                var Machine = $('#Machine option:selected').text();
                var Khung_gio = $('#Khung_gio option:selected').text();
                var ID_machine = $('#ID_machine').val();
                var Checklist_item = $('#Checklist_item option:selected').text();
                $('#table-check-list').DataTable().rows().every(function() {
                    if (shouldExit) {
                        return false; // Nếu flag là true, thoát khỏi vòng lặp
                    }
                    const rowData = this.data();
                    const problems = $(this.node()).find('.problem').val();
                    const status_OK = $(this.node()).find('.status_OK').prop('checked');
                    const status_NG = $(this.node()).find('.status_NG').prop('checked');
                    if (!status_OK && !status_NG) {
                        shouldExit = true;
                        return;
                    } else {
                        if (status_OK) {
                            var status = 'OK';
                        } else {
                            var status = 'NG';
                        }
                        data.push({
                            id_checklist_result: id_checklist_detail,
                            Locations: line,
                            Model: Model,
                            ID_item_checklist: "1",
                            Machine: Machine,
                            Hang_muc: rowData[1],
                            item_checklist: Checklist_item,
                            Khung_check: Khung_gio,
                            Shift: shift,
                            Code_machine: ID_machine,
                            Check_status: status,
                            Status: problems,
                            // Remark: process,
                            Date_check: date

                        });
                    }


                });


                $.ajax({
                    type: "POST",
                    url: "{{ route('update.check.list.detail', ':table') }}"
                        .replace(':table', id_checklist_detail),
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    success: function(users) {
                        alert('Update check-list Thành công');
                        $('#table_check_list').DataTable().clear();
                        $('#modal-check').modal('hide');
                    }
                });



                search();
            });

            function editTable(table_edit, table) {

                $('#' + table_edit).Tabledit({
                    url: "check-list/edit-table/" + table,
                    method: 'POST',
                    dataType: 'json',
                    columns: {
                        identifier: [0, 'id'],
                        editable: colum_table,
                    },
                    restoreButton: true,
                    deleteButton: false,
                    uploadButton: false,
                    onSuccess: function(data, textStatus, jqXHR) {
                        if (data.action == 'delete') {
                            $('#' + data.id).remove();
                            $('#' + table_id).DataTable().ajax.reload();
                        }

                    }
                });
            }

            $('#table_check_list_view').on('draw.dt', function() {
                editTable('table_check_list_view', table_edit);
            });

            $(document).on('click', '.close-model-checklist', function(e) {
                e.preventDefault();
                $('#table_check_list').DataTable().clear();
                $('#table_check_list thead tr').remove();
                $('#modal-check').modal('hide');
                show_model_check();
            });

            $(document).on('click', '.close-model-scan', function(e) {
                e.preventDefault();
                $('#modal-scan').modal('hide');
                html5QrcodeScanner.clear();
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content')
                }
            });
        });
    </script>
@endsection