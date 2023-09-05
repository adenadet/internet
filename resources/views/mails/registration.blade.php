<!DOCTYPE html>
<html>
    <head>
        <title>Appointment Confirmation</title>
    </head>
    <body>
        <h1>Hello {{$appointment->patient->first_name}}</h1>
        <p>Thank you for choosing St. Nicholas Hospital.</p>
        <p>Your appointment for {{$appointment->service->name}} is confirmed.</p>
        <p>Below are the details:<br />
            Name: {{$appointment->patient->last_name}}, {{$appointment->patient->first_name}} {{$appointment->patient->middle_name}}<br />
            Venue: 57, Campbell Street, Lagos Island, Lagos, Nigeria.<br />
            Date: {{$appointment->date}}<br />
            Time: {{$appointment->schedule}}
        </p>
        <p>Your payment details are as follows:<br />
            Payment Mode: {{$appointment->payment->channel}}<br />
            Amount: &#8358; {{$appointment->payment->amount}}<br />
            Date: {{$appointment->payment->created_at}}<br />
            Transaction ID: {{$appointment->payment->details}}<br />
            Tracking ID: {{$appointment->transaction_id}}<br />
            In subsequent communications, kindly make use of the Tracking ID. 
        </p>
        <p>Come along with a printed copy of this mail and  your valid travel documents (i.e. International Passport).</p>
        <p>Thank you</p>
    </body>
</html>