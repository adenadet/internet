<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>St. Nicholas Hospital UK TB Screening Certificate for {{$patient['first_name']}} {{$patient['last_name']}} </title>
    <!--link rel="stylesheet" href="https://intranet.saintnicholashospital.com/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://intranet.saintnicholashospital.com/dist/css/adminlte.min.css"-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">
    <div class="content">
        <div class="container-fluid">
            <div class="invoice p-5 mb-3">    
                <div class="row">
                    <div class="col-3 p-5"><img src="https://intranet.saintnicholashospital.com/img/applicants/{{$patient['image']}}" class="img-fluid" /></div>
                    <div class="col-9">
                        <div class="row">
                            <div class="col-8"><h5 class="mt-3">UK Pre-Departure Tuberculosis Detection Programme</h5></div>
                            <div class="col-2"><img src="https://intranet.saintnicholashospital.com/img/background/logo/uk-visa.png" class="img-fluid" /></div>
                            <div class="col-2"><img src="https://intranet.saintnicholashospital.com/img/background/logo/snh-square.png" class="img-fluid" /></div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-4 col-form-label" style="color: #222;font-weight:normal !important; ">Certificate No:</label>
                                    <div class="col-sm-8"><div width="100%"  class="pl-2 rounded" style="border: 1px solid #222; color: #222;">
                                        {{is_null($unique_id) ? $unique_id : 'N/A'}}
                                    </div></div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-4 col-form-label" style="font-weight:normal !important; ">SP ID No:</label>
                                    <div class="col-sm-8">
                                        <div width="100%"  class="pl-2 rounded" style="border: 1px solid #222; color: #222;"  v-html="appointment.sp_id != null ? appointment.sp_id : 'N/A'"></div></div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-4 col-form-label" style="font-weight:normal !important; ">City/Town:</label>
                                    <div class="col-sm-8"><div width="100%"  class="pl-2 rounded" style="border: 1px solid #222; color: #222;" >LAGOS ISLAND</div></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-4 col-form-label" style="font-weight:normal !important; ">Issue Date:</label>
                                    <div class="col-sm-8"><div width="100%"  class="pl-2 rounded" style="border: 1px solid #222; color: #222;"  id="inputEmail3">{{$issue_at}}</div></div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-4 col-form-label" style="font-weight:normal !important; ">Expiry Date:</label>
                                    <div class="col-sm-8"><div width="100%"  class="pl-2 rounded" style="border: 1px solid #222; color: #222;" >{{$issue_at }}  <!-- | excel6Months-->}}</div></div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-4 col-form-label" style="font-weight:normal !important;">Country:</label>
                                    <div class="col-sm-8"><div width="100%"  class="pl-2 rounded" style="border: 1px solid #222; color: #222;" >NIGERIA</div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-7">
                    <div class="form-group row">
            <label for="inputEmail3" class="col-sm-5 col-form-label text-small" style="font-weight:normal !important;"><small>Given name(s) (as shown in passport):</small></label>
            <div class="col-sm-6"><div width="100%"  class="pl-2 rounded" style="border: 1px solid #222; color: #222;">{{ $patient['first_name']}} {{ $patient['middle_name']}} </div></div>
        </div>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-5 col-form-label text-small" style="font-weight:normal !important; "><small>Family name (as shown in passport):</small></label>
                    <div class="col-sm-6"><div div width="100%"  class="pl-2 rounded" style="border: 1px solid #222; color: #222;" v-html="appointment.patient.last_name"></div></div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-3 col-form-label text-small" style="font-weight:normal !important; "><small>Gender:</small></label>
                            <div class="col-sm-4">
                                <div class="form-check">
                                    <i class="" :class="appointment.patient.sex == 'Male' ? 'fa fa-check' : 'far fa-square'"></i>
                                    <label class="form-check-label" style="font-weight:normal !important; color: #222;">
                                    <small>Male</small></label>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-check">
                                    <i class="" :class="appointment.patient.sex == 'Female' ? 'fa fa-check' : 'far fa-square'"></i>
                                    <label class="form-check-label" style="font-weight:normal !important; color: #222;"><small>Female</small></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label" style="font-weight:normal !important; "><small>Nationality:</small></label>
                            <div class="col-sm-8"><div width="100%" class="pl-2 rounded" style="border: 1px solid #222; color: #222;"  v-html="appointment.patient.nationality.name"></div></div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4" style="font-weight:normal !important;"><small>Date of Birth:</small></label>
                            <div class="col-sm-6"><div width="100%" class="pl-2 rounded" style="border: 1px solid #222; color: #222;"  v-html="appointment.patient.dob"></div></div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4" style="font-weight:normal !important; "><small>Passport No:</small></label>
                            <div class="col-sm-6"><div width="100%" class="pl-2 rounded" style="border: 1px solid #222; color: #222;" v-html="appointment.patient.passport_no"></div></div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-8 col-form-label" style="font-weight:normal !important; "><small>Number of accompanying children under 11 years of age:</small></label>
                    <div class="col-sm-3"><div width="100%"  class="pl-2 rounded" style="border: 1px solid #222; color: #222;" v-html="appointment.patient.accompanying_kids != null ? appointment.patient.accompanying_kids : 0"></div></div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-5 col-form-label" style="font-weight:normal !important; "><small>Full residential address:</small></label>
                    <div class="col-sm-6" v-html="appointment.patient.nigerian_address" width="100%" min-height="200px" style="border: 1px solid #222; color: #222;"></div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-5 col-form-label" style="font-weight:normal !important; "><small>Address in the UK:</small></label>
                    <div class="col-sm-6" v-html="appointment.patient.uk_address" width="100%" min-height="200px" style="border: 1px solid #222; color: #222;"></div>
                </div>
                            </div>
                            <div class="col-5">
                                <EServiceCertificateSummary :appointment="appointment" />
                            </div>
                            <EServiceCertificateFooter :appointment="appointment" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script src="https://intranet.saintnicholashospital.com/plugins/jquery/jquery.min.js"></script>
<script src="https://intranet.saintnicholashospital.com/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://intranet.saintnicholashospital.com/dist/js/adminlte.min.js"></script>
<script src="https://intranet.saintnicholashospital.com/dist/js/demo.js"></script>
</body>
</html>