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
        }
        p {
            font-family: 'Raleway', sans-serif;
        }
        a {
            text-decoration: none;
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

            padding-left: 1vh;
            padding-right: 1vh;
            border: 1px solid rgb(196, 196, 196);
        }
        .header {
            background-color: darkcyan;
        }
        .header span {
            color: #FFFFFF;
        }
        .margin {
            margin-top: 7px;
            margin-bottom: 5px;
            padding-left: 3%;
            padding-right: 3%;
            border: 1px solid #678765;
            border-radius: 6px;
            background-color: #ececec;
        }
        #box-1 {
            margin: 5px;
            overflow: auto;
            margin-bottom: 0 !important ;
            padding-left: 3%;
            padding-right: 3%;
            border-top: 1px solid #678765;
            border-radius: 6px;
            background-color: #ececec;
        }
        #box-1 img {
            float: right;
            width: 30%;
            border-radius: 10px;
            margin-top: 15px;
        }
        li {
            list-style-type: none;
        }
        .foot img {
            height: 50px;
        }
        .location {
            font-size: 1.5em;
            padding-left: 0;
        }
        .box-4 {
            /*position: relative;*/
            background-color: #d6d6d6;
        }
        button {
            text-align: center;
            border: 2px solid #456654;
            margin-bottom: 2px;
            background-color: #e8e8e8;
            border-radius: 2px;
        }
        button:hover {
            color: #FFFFFF;
            background-color: #456654;
        }
        button:hover a{
            color: #FFFFFF;
        }
        @media only screen and (max-width: 600px) {
            .bg-design {
                margin-left: 5px;
                margin-right: 5px;
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
        <p class="text-left">{{ $data['msg'] }}</p>
    </div>

    <p class="text-left name">Please have a look ...</p>
    <div id="box3">
        <div class="header">
            <h1 style="text-align: center;"> <span>Seminar on </span>{{ $data['event']->title }}</h1>
        </div>
        <div id="wrapper">
            <div id="box-1">
                <img src="{{ $data['speakerProfile']['pp_src'] }}" alt="">

                <h3 style="text-align: center;">SPEAKER</h3>
                <br>
                <p class="speaker-name text-center">{{ $data['event']->speakerName }}</p>
                <p id="designation" class="text-center">{{ $data['speakerProfile']['designation'] }} </p>
                <p class="text-center">{{ $data['speakerProfile']['dept'] }}</p>
                <p id="university" class="text-center">{{ $data['speakerProfile']['univ'] }}</p>
                <br>
            </div>
            <div class="margin">
                <br>
                <p style="text-align: justify;">
                    BdREN has established more than 4000+ KM fiber optic connectivity for the universities and research organizations. Physical connectivity with 34 public universities has already been established. The established backbone has redundant transmission which ensures the continuation of any on going service even if there is a fiber cut or other technical transmission disruptions. Along with the network, a total of 34 DLT has been established in 33 different public universities. DLT’s are equipped with projector, television displays, sophisticated sound system, electronic white board and many other components. With the devices, tools and software one can conduct a remote class almost just like a local class with the exception of speaker and participants are in a distant location. The electronic board is easy to operate and have the facility to use multi-color pen for better expression and understanding. Projector and television display devices can wonderfully reflect the local and remote participants and presentation of the speaker/white board. The lecture can even be interactive considering the sharing of the electronic while board. Teacher may ask questions remotely and student may response without a hand microphone as there is celling mounted microphone array in the room. The rooms also have acoustic capability to reduce noise and echo while remote lecture is going on.
                </p>
            </div>
            <div class="">
                <div class="">
                    <div class="margin">
                        <h3 style="text-align: center;">ABSTRACT</h3>
                        <br>
                        <p style="text-align: justify;">{{ $data['event']->abstract }}</p>
                        <div class="download-btn text-center">
                            <button style="text-align: center;"><p><a href="{{ $data['event_details_pdf_link'] }}">Download pdf</a></p></button>

                        </div>
                    </div>
                    <div class="margin box-4">
                        <ul class="location">
                            <li> <i class="far fa-clock"></i> {{ \Carbon\Carbon::parse($data['event']->talk_delivery_time)->format('g:i A') }}</li>
                            <li><i class="far fa-calendar-plus"></i>{{ \Carbon\Carbon::parse($data['event']->talk_delivery_time)->format('F j') }} </li>
                            <li><i class="fas fa-phone"></i><b> Dial Number: </b> {{ $data['event']->client_dial_num }} (From your DLT)</li>
                        </ul>
                        <div class="foot">
                            <div>
                                <p><b>Powered by</b></p>
                                <img src="http://103.28.121.11/wp-content/uploads/2017/04/bdren.png" alt="">

                            </div>
                        </div>
                        <div style="text-align: right">
                            <p>Bangladesh Research & Education Network</p>
                            <a href="">eaas.bdren.net.bd</a>
                            <p> Expert as a Service</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</body>
</html>