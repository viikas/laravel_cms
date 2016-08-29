<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta charset="utf-8">
  </head>
  <body>
    <h2>You have changed your password.</h2>
    <div>Dear {{$name}},</div>
    <div>
      Your password has been changed recently. <br/> 
      Your sign up details are below:
    </div>
    <div>Email: {{ $email }}</div>
    <div>Password: {{ $password}} </div>
    <div>Best regards,</div>
    <div>Laravel Site Team</div>
  </body>
</html>