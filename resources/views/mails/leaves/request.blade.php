<!DOCTYPE html>
<html>
    <head>
        <title>Leave Request Notification</title>
    </head>
    <body>
        <h1>Hello {{$line_manager->first_name}}</h1>
        
        <p>I hope this email finds you well. I wanted to bring to your attention that one of your team members has recently applied for leave through our Human Resource Management System (HRMS).</p>

        <p>{{$employee->user->first_name}} {{$employee->user->last_name}} ({{$employee->unique_id}}) has submitted a leave request and it now requires your attention for approval. To confirm or reject the request, please <b><a href="https://intranet.saintnicholashospital.com/leave_management/confirm_request/{{$leave_request->id}}" target="_blank">click here</a></b></p>

        <p>Your prompt action on this matter would be greatly appreciated to ensure smooth workflow and proper management of team resources.</p>

        <p>If you encounter any issues or have any questions regarding the leave request process, please don't hesitate to reach out to our HR department for assistance.</p>

        <p>Thank you for your cooperation in this matter.</p>

        <p>Best regards,<br >Webmaster, <br >HRMS</p>
    </body>
</html>