<!DOCTYPE html>
<html>
<head>
    <title>Speaker | Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/css/bootstrap-datetimepicker.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.16.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/js/bootstrap-datetimepicker.min.js"></script>


    <link rel="stylesheet" type="text/css" href="/assets/css/speaker.css" media="screen" />
</head>
<body>
<div class="container-fluid">
    <div class="col-md-12">
        <div id="left-bar" class="col-md-2">
            <h3 class="text-center">Control Panel</h3>
            <div id="links">
                <p class="link"><a href="/">Home</a></p>
                <p class="link"><a href="/speaker">Admin Panel</a></p>
                <p class="link"><a href="">Past Events</a></p>
                <p class="link"><a href="/event/create">Create Event</a></p>
                <hr>
            </div>

            {{--<p class="info">2 Speakers wanted to deliver speech</p> <hr>--}}
            {{--<p class="info">6 Representatives responded to your request</p> <hr>--}}
            {{--<p class="info">Some more information may remain here</p> <hr>--}}

            {{--<p>Total Users : 178</p>--}}
            {{--<p>Total Admins : 18</p>--}}
            {{--<p>University Reached : 22</p>--}}
            {{--<p>Department Reached : 56</p>--}}
            {{--<p>Total Users : 178</p>--}}
            {{--<p>Total Users : 178</p>--}}
        </div>

        <div id="middle-bar" class="col-md-7">
            @if( ! is_null($successMsg = Session::get('successMsg')) )
                <p class="text-info text-left">{!! $successMsg !!}</p>
                {{ Session::put('successMsg', null) }}
            @endif

                <h2 class="text-center">Upcoming Events</h2>
                @foreach($otherEvents as $event)
                    <div class="single-event col-md-12">
                        <h4 class="col-md-10"><a href="/event/{{ $event->id }}">{{ $event->title }}</a></h4>
                        <div class="col-md-2">
                            <a style="color: #0000cc" href="/event/{{ $event->id }}/edit">Edit</a>
                            <span class="delete-event" style="color: rgba(226,0,0,0.89); margin-left: 10px; cursor: pointer" event-id="{{ $event->id }}">Delete</span>
                        </div>

                        <div class="col-md-12">
                            <p class="speaker-name"><b>Speaker :</b>{{ $event->speakerName }}</p>
                            <p class="abstract"><b>Abstract :</b>{{ $event->abstract }}</p>
                            <p class="keywords"><b>Keywords :</b>{{ $event->keywords }}</p>
                            <p class="target-audience"><b>Target Audience :</b>{{ $event->target_audience }}</p>
                        </div>
                        <hr>
                    </div>
                @endforeach
        </div>

        <div id="right-bar" class="col-md-3">
            <div id="event-wrapper">
                <h3 class="text-center">Other Events</h3>
                @foreach($otherEvents as $event)
                    <div class="event">
                        <p class="event-title other-event"><a href="/event/{{ $event->id }}">{{ $event->title }}</a></p>
                        <p class="date-time">{{ \Carbon\Carbon::parse($event->talk_delivery_time)->format('F j, g:i A') }}</p>
                        <div class="text-center">
                            <span><a target="_blank" href="/event/{{ $event->id }}">Details</a></span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#talk_delivery_time').datetimepicker({
            format : 'YYYY-MM-DD HH:mm'
        });

        $('.delete-event').click(function () {
            var eventId = $(this).attr('event-id');
            if(confirm("Sure Delete ?")){
                $.ajax({
                    url : '/event/delete',
                    type : 'post',
                    data : {
                        _token : "{{ csrf_token() }}", eventId : eventId
                    }, success : function (response) {
                        console.log(response);
                        location.reload();
                    }, error : function () {
                        alert("Couldn't Delete");
                    }
                });
            }
        });


    });
</script>
</body>
</html>