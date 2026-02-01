<?php
    $survey_start_image = DB::table('settings')->where('param','survey_start_image')->first();
    $small_logo = DB::table('settings')->where('param','small_image')->first();
 ?> 
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{env('APP_NAME')}}</title>
    <link rel="stylesheet" href="thanks/assets/css/styles.min.css" />
    <style>
      body {
      background: url('{{ url('/'.$survey_start_image->value) }}');
      background-repeat: no-repeat;
      background-position: center top;
      background-size: 100vw 60vh;
      }
    </style>
  </head>
  <body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
      data-sidebar-position="fixed" data-header-position="fixed">
      <div
        class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
        <div class="d-flex align-items-center justify-content-center w-100">
          <div class="row justify-content-center w-100">
            <div class="col-md-8 col-lg-12 col-xxl-3">
              <a href="#" class="text-nowrap logo-img text-center py-3 w-100">
              <img src="{{url('/'.$small_logo->value)}}" width="100" alt="">
              </a>
              <div class="card mb-0">
                <div class="card-body">
                  <style>
                    .bg-complete {
                    background-color: ;
                    }
                    .bg-terminate {
                    background-color: ;
                    }
                    .bg-qoutafull {
                    background-color: ;
                    }
                  </style>
                  <div class="card">
                    <div class="card-body">
                      <h1 class="fw-semibold mb-4 text-center">Your Survey has been  <span class="mb-0 p-3 rounded-pill text-center text-uppercase" style="color: #28a745; font-weight: 900; "> <u> {{$message}} </u> </span> </h1>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12 d-flex align-items-stretch">
                      <div class="card w-100">
                        <div class="card-body p-4">
                          <div class="table-responsive">
                            <table class="table text-nowrap mb-0 align-middle ">
                              <thead class="text-dark fs-4">
                                <tr>
                                  <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Message</h6>
                                  </th>
                                  <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">UID</h6>
                                  </th>
                                  <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Project ID</h6>
                                  </th>
                                  <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">IP address</h6>
                                  </th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td class="border-bottom-0"  >
                                    <span class="fw-semibold mb-0 p-2 rounded-pill text-white text-center" style="background-color: #28a745 ; font-size:20px;">{{$message}}</span>
                                  </td>

                                  <td class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">{{$uid}}</h6>
                                  </td>
                                  
                                  <td class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">{{$uid}}</h6>
                                  </td>
                                  
                                  <td class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">{{$ip}}</h6>
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
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="thanks/assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="thanks/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  </body>