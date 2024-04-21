<!DOCTYPE html>
<html>
    <head>
        <title>Leave Request Rejection</title>
    </head>
    <body>
        <h1>Hello {{$employee->user->first_name}}</h1>
        
        <p>I hope this email finds you well. We regret to inform you that your leave request has been rejected.</p>

        <p>After careful consideration and discussion with your supervisor, it has been determined that your absence during the requested period would significantly impact ongoing projects and team responsibilities. We understand your need for leave; however, due to [specific reason for rejection, e.g., high workload, project deadlines, team availability], we are unable to approve your request at this time.</p>
        <p>We understand that this may cause inconvenience, and we sincerely apologize for any disruption this may cause to your plans. We encourage you to resubmit your leave request for a future date when it may be more feasible for the team.</p>
        <p>If you have any questions or would like to discuss this further, please do not hesitate to reach out to {{$line_manager->first_name}} {{$line_manager->last_name}} or the HR department.</p>
        <p>Thank you for your understanding and cooperation.</p>
        <p>Best regards,<br >Webmaster, <br >HRMS</p>
    </body>
</html>