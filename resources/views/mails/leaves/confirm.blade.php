<!DOCTYPE html>
<html>
    <head>
        <title>Leave Request Confirmation</title>
    </head>
    <body>
        <h1>Hello {{$employee->user->first_name}}</h1>
        <p>I hope this email finds you well. We are writing to inform you that your leave request has been approved by your supervisor.</p>
        <p>Here are the details of your approved leave:
            <ul>
                <li>Start Date: {{$leave_request->start_date}}</li>
                <li>End Date: {{$leave_request->end_date}}</li>
                <li>Total Number of Leave Days: {{$days}}</li>
            </ul>
        </p>
        <p>Your supervisor has reviewed your request and found it to be suitable considering the workload and team arrangements. Your absence during this period has been duly noted, and necessary adjustments will be made to ensure continuity in operations.</p>
        <p>Please make sure to wrap up any pending tasks and inform your team about your absence. If there are any specific handover procedures or responsibilities that need to be addressed before you leave, please ensure they are taken care of promptly.</p>
        <p>If you have any questions or need further clarification regarding your approved leave, feel free to contact {{$line_manager->first_name}} {{$line_manager->last_name}} or the HR department.</p>
        <p>We wish you a restful and rejuvenating time during your leave.</p>
        <p>Best regards,<br >Webmaster, <br >HRMS</p>
    </body>
</html>