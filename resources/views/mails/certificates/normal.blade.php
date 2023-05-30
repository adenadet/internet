<!DOCTYPE html>
<html>
    <head>
        <title>UK TB Screening Certificate</title>
    </head>
    <body>
        <h1>Hello {{$appointment->patient->first_name}}</h1>
        <p>Thank you for choosing St. Nicholas Hospital.</p>
        <p>Your appointment for {{$appointment->service->name}} has been completed.</p>
        <p>Find attached your {{$appointment->service->name}} certificate. <br />For best quality, kindly print the certificate on Conqueror paper.</p>
        <p>Alternatively, if the PDF is not downloading, kindly <a href="https://intranet.saintnicholashospital.com/certificates/{{$appointment->id}}" target="_blank">click here</a> to print it directly</p>
        <p>Thank you</p>
    </body>
</html>