<html>
<head>
    <title>EAAS Mail</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">

    <style>
        body {
            padding: 0;
            margin: 0;
            background-color: #eee;
        }
        .bg-design {
            background-color: rgba(232, 199, 67,0.5);
            margin-left: 15%;
            margin-right: 15%;
            /*border: 2px solid #0f0; */
        }
        .text-center{
            text-align: center;
        }
        .text-left{
            text-align: left;
        }
        .name {
            padding-left: 3vh;
        }
        h2{
            font-size: 4vh;
        }
        h3{
            font-family: 'Supermercado One';
            font-size: 3vh;
        }
        p {
            font-family: 'Raleway', sans-serif;
        }

        #heading {
            font-size: 6vh;
        }
        #box1 , #box4{
            color: #fff;
            background-color: rgba(44, 46, 135, 0.5);
            padding: 5px 0px;
            margin-bottom: 5px;
            /* border: 1px solid rgba(0, 169, 98, 0.45); */
            font-size: 3vh;
            padding: 5px;
        }
        #box2{
            background-color: rgba(246, 246, 246, 0.78);
            padding: 1vh 3vh 1vh 3vh;
            /* border : 1px solid rgba(0, 133, 202, 0.82); */
            font-size: 3vh;
        }
        #box3{
            margin-top: 5px;
            background-color: rgba(0, 66, 226, 0.25);

            padding-left: 3vh;
            padding-right: 3vh;
            border: 1px solid rgb(196, 196, 196);
            font-size: 3vh;
        }
        @media only screen and (max-width: 600px) {
            .images {
                width: 100%;
            }

            .bg-design {
                margin-left: 5px;
                margin-right: 5px;
                /* border: 2px solid #0f0; */
            }
        }
    </style>
</head>
<body>
<div class="bg-design">
    <div id="box1" class="text-center">
        <h2 id="heading">Distance Learning Theater</h2>
        <h3>Virtual Classroom</h3>
    </div>

    <p class="text-left name">Dear {{ $data['name'] }},</p>
    <div id="box2" class="text-center">
        <p class="p1 text-left">
            Some information of an upcoming event has been changed. <br>
            Please have a look at the following event:
        </p>
    </div>

    <div id="box3">
        <h4 class="text-center">{{ $data['event']->title }}</h4>
        <p class="p2 text-center">
        <p>Date : {{ \Carbon\Carbon::parse($data['event']->talk_delivery_time)->format('F j') }}</p>
        <p>Time : {{ \Carbon\Carbon::parse($data['event']->talk_delivery_time)->format('g:i A') }}</p>
        <p>Abstract : {{ $data['event']->abstract }}</p>
        <p>Keywords : {{ $data['event']->keywords }}</p>
        </p>

        <p>
            <a href="{{ $data['event']->event_details_pdf_link }}">Download Event details</a>
        </p>

        <div id="box4">
            Regards, <br>
            <a style="text-decoration: none;color:#00553b; " href="http://eaas.bdren.net.bd">EAAS</a> <br>
            <p>A Virtual Classroom, Distance Learning Theater<br>Bangladesh</p>
        </div>
    </div>
</div>

</body>
</html>