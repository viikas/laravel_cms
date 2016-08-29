<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta charset="utf-8">
  </head>
  <body>
    <h2>You password has been reset</h2>
    <div>Dear {{$name}},</div>
    <div>
      Your password has been reset recently by the admin of laravel site. <br/> 
      Your sign up details are below:
    </div>
    <div>Email: {{ $email }}</div>
    <div>Password: {{ $password}} </div>
    <div>Best regards,</div>
    <div>Laravel Site Team</div>
  </body>
</html>