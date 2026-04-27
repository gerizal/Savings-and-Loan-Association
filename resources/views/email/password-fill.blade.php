
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title></title>
</head>
<body>
  <div bgcolor="#071522">
    <div style="color: #353030; text-align: center; font-family: 'Helvetica'; width: 100%;">
      <div style="background: #F2F2F2; background-size: cover; padding: 35px 0; text-align: center; width: 100%;">
        <div style="max-width: 600px; margin: 0 auto; text-align: left;">
          <div style="padding: 40px 30px 30px; margin: 0 auto; background: #FFFFFF; -webkit-border-radius: 10px; -moz-border-radius: 10px; border-radius: 10px;">
            <div style="margin: 0 auto; text-align: center;">
              <img src="{{ asset ('/img/logo_kpf.jpg') }}" style="margin:0 0 38px; max-height:53px; width:auto; max-width:280px;" alt="">
            </div>
            <div>
              <div style="margin: 0 auto;">
                <p style="font-size: 15px; margin: 0 0 25px; line-height: 22px;">
                  Hello <b>{{ $name }}</b>,
                </p>
                <p style="font-size: 13px; margin: 0 0 25px; line-height: 22px;">
                  You've been invited as user in KPFI.
                </p>
                <center>
                  <a href="{{{$deeplink}}}" target="_blank" style="text-decoration:none; background-color: #607EB6; color: #ffffff; font-size: 13px; font-weight: bold; padding: 12px 55px; border-radius: 30px; cursor: pointer; position: relative; display: inline-block; margin: 0 0 45px; line-height: 17px;">
                    Set Password
                  </a>
                </center>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </body>
</html>
