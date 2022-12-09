<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/css/bootstrap-datetimepicker.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.16.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/js/bootstrap-datetimepicker.min.js"></script>


    <link rel="stylesheet" type="text/css" href="/assets/css/event.css" media="screen" />
</head>
<body>
<div class="container-fluid">
    <h1 class="text-center">{{ $event->title }}</h1>
    <div id="event-details-wrapper" class="col-md-6 col-md-offset-3">
        <div class="each-row col-md-12">
            <span class="col-md-4">Speaker</span>
            <span class="col-md-8">{{ $event->speaker_name }}</span>
        </div>

        <div class="each-row col-md-12">
            <span class="col-md-4">Date</span>
            <span class="col-md-8">{{ \Carbon\Carbon::parse($event->talk_delivery_time)->format('F j') }}</span>
        </div>

        <div class="each-row col-md-12">
            <span class="col-md-4">Time</span>
            <span class="col-md-8">{{ \Carbon\Carbon::parse($event->talk_delivery_time)->format('g:i A') }}</span>
        </div>

        <div class="each-row col-md-12">
            <span class="col-md-4">Abstract</span>
            <p class="col-md-8">{{ $event->abstract }}</p>
        </div>

        <div class="each-row col-md-12">
            <span class="col-md-4">Keywords</span>
            <span class="col-md-8">{{ $event->keywords }}</span>
        </div>
    </div>

    <div class="col-md-8 col-md-offset-2">
        <br><br>
        <h3>Why Attend This Lecture ?</h3>
        <p>
            It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using '
        </p>
        <h3>Have a question ?</h3>
        <p>Feel free to ask example@example.com</p>
    </div>

</div>

</body>
</html>