<!DOCTYPE html>
<html>
    <head>
        <title>Appointment Confirmation</title>
    </head>
    <body>
        <h1>Hello {{$appointment->patient->first_name}}</h1>
        <p>We have received your request to cancel your appointment with Tracking ID: {{$appointment->transaction_id}}</p>
        <p>Your appointment has been cancelled and your funds are currently been processed.</p>
        <p>You have requested that your funds be deposited to:<br />
            Bank Name: {{$appointment->cancellation->bank->bank_name}}<br />
            Account Name: {{$appointment->cancellation->account_name}}<br />
            Account Number: {{$appointment->cancellation->account_number}}<br />
        </p>
        <p>Please note that you refund would be completed within 3 - 5 working days.</p>
        <p>Thank you</p>
    </body>
</html>