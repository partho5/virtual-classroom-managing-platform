<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Poster</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">


    <style>
        body {
            padding: 0;
            margin: 0;
        }
        p {
            font-family: 'Raleway', sans-serif;
        }
        .header {
            background-color: darkcyan;        }
        .header span {
            color: #FFFFFF;
        }
        #box-1 {
            overflow: auto;
            margin-top: 0 !important ;
            padding-left: 20%;
            padding-right: 20px;
            padding-top: 0 !important;
            background-color: #ececec;
        }
        #box-2 {
            padding-left: 5px;
            padding-right: 5px;
            background-color: #ececec;
        }
        #box-1 img {
            float: right;
            width: 20%;
            border-radius: 10px;
            margin-top: 15px;
        }
        li {
            list-style-type: none;
        }
        .foot img {
            height: 60px;
        }
        .box-4 {
            /*position: relative;*/
            background-color: #d6d6d6;
            padding-left: 20px;
            padding-right: 20px;
            border: 1px solid #678765;
            border-radius: 6px;
            background-color: #ececec;
        }
        .foot {
            position: absolute;
            top: 6%;
            left: 3%;
            padding-right: 10px;
        }
    </style>
</head>
<body>
<div id="box-1">
    <div class="header">
        <h1 style="text-align: center;"> <span>Seminar on </span>{{ $data['event']['title'] }}</h1>
    </div>
    <img src="{{ $data['speakerProfile']['pp_src'] }}" alt="">

    <h3>SPEAKER</h3>
    <span class="speaker-name">{{ $data['speakerProfile']['name'] }}</span><br>
    <span id="designation">{{ $data['speakerProfile']['designation'] }}</span><br>
    <span>{{ $data['speakerProfile']['dept'] }}</span><br>
    <span id="university">{{ $data['speakerProfile']['univ'] }}</span>

</div>
<div id="box-2">
    <br>
    <p style="text-align: justify;">BBio</p>
    <h3 style="text-align: center;">ABSTRACT</h3>
    <span style="text-align: justify;">{{ $data['event']['abstract'] }}</span>
</div>

<div class="box-4">
    <span>Date:  {{ \Carbon\Carbon::parse($data['event']['talk_delivery_time'])->format('F j') }} </span><br>
    <span>Time:  {{ \Carbon\Carbon::parse($data['event']['talk_delivery_time'])->format('g:i A') }}</span><br>
    <span><b> Dial Number: </b> {{ $data['event']['client_dial_num'] }} (From your DLT)</span>
    <!-- class="far fa-clock"></i>
    <i class="far fa-calendar-plus"></i>
        <i class="fas fa-phone"></i>  -->
    <div style="text-align: center">
        <span><a href="">eaas.bdren.net.bd</a></span><br>
        <span>Bangladesh Research & Education Network</span>
    </div>
    <div class="foot">
        <div>
            <p><b>Powered by</b></p>
            <img src="http://103.28.121.11/wp-content/uploads/2017/04/bdren.png" alt="">
        </div>
    </div>
</div>
</body>
</html>