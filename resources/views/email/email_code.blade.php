<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>邮箱验证</title>
    <style>
        #box{
            padding:12px;
        }
        #box h2{
            font-size:14px;
        }
        #box p:nth-of-type(1),#box p:nth-of-type(2){
            text-indent:2em;
        }
        #code span {
            font-weight: bold;
            color: red;
        }
    </style>
</head>
<body>
<div id="box">
    <h2>{{$email}}，您好</h2>
    <p>请验证您的电子邮件地址: {{$email}}</p>
    <p id="code">你的验证码: <span>{{$code}}</span></p>
    <p>请在3分钟内将此验证码输入验证码输入框，以完成验证。</p>
    <p>此致</p>
    <p>ChinaClown</p>
    <p>如果您并没有进行上述操作，请忽略该邮件。</p>
    <p>您不需要进行退订或者其他操作。</p>
    <p>此邮件为系统自动发出的邮件，请勿直接回复。</p>
</div>
</body>
</html>
