<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{$appointment->patient->last_name}}, {{$appointment->patient->first_name}} {{$appointment->patient->middle_name}} | St. Nicholas Hospital UK TB Screening Certificate </title>
    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        @media print{@page {size: landscape}}
    </style>
</head>
<body>
    <div class="row m-0">
        <div class="col-2 p-3 pt-0">
            <img src="/img/applicants/{{$appointment->patient->image}}" class="img-fluid" />
        </div>
        <div class="col-10">
            <div class="row">
                <div class="col-9"><h4 class="mt-3">UK Pre-Departure Tuberculosis Detection Programme</h4></div>
                <div class="col-1 offset-1"><img src="/img/background/logo/uk-visa.png" class="img-fluid" /></div>
                <div class="col-1"><img src="/img/background/logo/snh-square.png" class="img-fluid" /></div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="row">
                        <label class="col-4" style="color: #222;font-weight:normal !important; ">Certificate No:</label>
                        <div class="col-8"><div width="100%"  class="pl-2 rounded" style="border: 1px solid #222; color: #222;"> {{$appointment->unique_id}}</div></div>
                    </div>
                    <div class="row">
                        <label for="inputPassword3" class="col-4" style="font-weight:normal !important; ">SP ID No:</label>
                        <div class="col-8"><div width="100%"  class="pl-2 rounded" style="border: 1px solid #222; color: #222;">N/A</div></div>
                    </div>
                    <div class="row">
                        <label for="inputPassword3" class="col-4" style="font-weight:normal !important; ">City/Town:</label>
                        <div class="col-8"><div width="100%"  class="pl-2 rounded" style="border: 1px solid #222; color: #222;" >LAGOS ISLAND</div></div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="row">
                        <label class="col-4" style="font-weight:normal !important; ">Issue Date:</label>
                        <div class="col-8"><div width="100%"  class="pl-2 rounded" style="border: 1px solid #222; color: #222;">{{date('d M, Y', strtotime($appointment->issue_at))}}</div></div>
                    </div>
                    <div class="row">
                        <label for="inputPassword3" class="col-4" style="font-weight:normal !important; ">Expiry Date:</label>
                        <div class="col-8"><div width="100%"  class="pl-2 rounded" style="border: 1px solid #222; color: #222;">{{date('d M, Y', strtotime("+6 months", strtotime($appointment->issue_at)))}}</div></div>
                    </div>
                    <div class="row">
                        <label for="inputPassword3" class="col-4" style="font-weight:normal !important;">Country:</label>
                        <div class="col-8"><div width="100%"  class="pl-2 rounded" style="border: 1px solid #222; color: #222;" >NIGERIA</div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row m-0">
        <div class="col-6">@include('certificates.biodata')</div>
        <div class="col-6">
            @include('certificates.report')
            @include('certificates.consultation')
        </div>
    </div>
    <div class="row m-0">
        <div class="col-11">
            <p class="m-0 p-2" style="font-size: small; font-weight:normal !important; text-align: justify; border: 2px solid #222;"><b>IMPORTANT:</b> You must carry this certificate with you, in your hand luggage, when you travel to the UK and present it to the Immigration Officer on arrival. Failure to do so will result in a delay to your journey as you <b><u>may be</u></b> required to undergo the tests again. Upon arrival in the UK you should register with a General Practitioner (GP) and supply a copy of this certificate for their records. If your chest X-ray shows abnormality requiring follow-up, we will also give a copy of the chest X-ray and X-ray interpretation and this should also be supplied.
            </p>
        </div>
        <div class="col-1 mt-3">
            {!! QrCode::size(50)->generate('https://intranet.saintnicholashospital.com/certificates/'.$appointment->id) !!}
        </div>
    </div>
    @include('certificates.signature')
</body>
</html>