<!DOCTYPE html>
<html>
    <head>
        <title>UK TB Screening Certificate</title>
    </head>
    <body>
        <h1>Hello {{$appointment->patient->first_name}}</h1>
        <p>Thank you for choosing St. Nicholas Hospital.</p>
        <p>Your appointment for {{$appointment->service->name}} has been completed.</p>
        <p>Kindly come into the facility to pick up your certificate.</p>
        <p>Thank you</p>
    </body>
</html>