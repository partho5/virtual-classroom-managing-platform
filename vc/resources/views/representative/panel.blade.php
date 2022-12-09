<!DOCTYPE html>
<html>
<head>
    <title>Representative Admin Panel</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="/assets/css/representative.css" media="screen" />
</head>
<body>
<div class="container-fluid">
    <div class="col-md-12">
        <div id="left-bar" class="col-md-2">
            <h3 class="text-center">Representative</h3>
            <div id="links">
                <p class="link"><a href="/">Home</a></p>
                <p class="link"><a href="/representative">Admin Panel</a></p>
                <p class="link"><a href="">Upcoming Events</a></p>
                <p class="link hidden" id="notification-icon">
                    <span>Whats Happening</span>
                    <span class="notification-count">4</span>
                </p>
                <p class="link text-center" id="notification-box">
                    <span class="h5">Notifications</span>
                    <br>
                    <span class="each-notification">
                            <span class="new">New</span>
                            <a href="" class="notification-link">msg 1 msg 1msg 1msg 1msg 1msg</a>
                        </span>

                    <br>
                    <span class="each-notification">
                            <span class="new">New</span>
                            <a href="" class="notification-link">msg 1 msg 1msg 1msg 1msg 1msg</a>
                        </span>

                    <br>
                    <span class="each-notification">
                            <a href="" class="notification-link">msg 1 msg 1msg 1msg 1msg 1msg</a>
                        </span>
                </p>
                <hr>
            </div>

            {{--<p class="info">2 Teachers wanted to deliver speech</p> <hr>--}}
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
            <p id="error-msg" class="text-center">This user is not registered</p>
            <p id="success-msg" class="text-center">Mail Sent</p>

            @if( ! is_null($successMsg = Session::get('successMsg')) )
                <p class="text-info text-left">{!! $successMsg !!}</p>
                {{ Session::put('successMsg', null) }}
            @endif


            <div id="single-admin-wrapper" class="col-md-12">
                <h2 class="text-center">Upcoming Events</h2>
                @foreach($upcomingEvents as $event)
                    <div class="single-event col-md-12">
                        <h4><a href="/event/{{ $event->id }}">{{ $event->title }}</a></h4>
                        <p class="speaker-name"><b>Speaker :</b>{{ $event->speakerName }}</p>
                        <p class="abstract"><b>Abstract :</b>{{ $event->abstract }}</p>
                        <p class="keywords"><b>Keywords :</b>{{ $event->keywords }}</p>
                        <p class="target-audience"><b>Target Audience :</b>{{ $event->target_audience }}</p>
                        <hr>
                        <div class="event-action-wrapper col-md-12">
                            <div class="col-md-8">
                                <span class="attending">{{ $event->totalAttending }} People Are Attending</span>
                                <small>@ <b>{{ \Carbon\Carbon::parse($event->talk_delivery_time)->format('F j [ g:i A ]') }}</b></small>
                            </div>
                            <div class="col-md-4">
                                @if( $event->alreadyAttended)
                                    <span>I am attending</span>
                                @endif
                                <select event-id="{{ $event->id }}" class="attend-via">
                                    @if( ! $event->alreadyAttended)
                                        <option selected disabled>I want to attend</option>
                                    @endif
                                    <option value="0" {{ $event->attendedVia === 0 ? 'selected':'' }}>{{ $attendViaFormField[0] }}</option>
                                    <option value="1" {{ $event->attendedVia === 1 ? 'selected':'' }}>{{ $attendViaFormField[1] }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div id="right-bar" class="col-md-3">
            <h3 class="text-center">Invited People</h3>
            <div id="invited-wrapper">
                {{--@foreach($invitedPersons as $person)--}}
                    {{--<div class="invited">--}}
                        {{--<p class="name"><a href="/user/profile/{{ $person->id }}">{{ $person->name }}</a></p>--}}
                        {{--<p class="email">{{ $person->email }}</p>--}}
                        {{--<small class="text-right" title="{{ \Carbon\Carbon::parse($person->invited_at)->format('F j [ g:i A ]') }}">{{ \Carbon\Carbon::parse($person->invited_at)->diffForHumans() }}</small>--}}
                    {{--</div>--}}
                {{--@endforeach--}}

                <div class="invited">
                    <p class="name">Dr Mamun Or Rashid</p>
                    <p class="email">example@example.com</p>
                    <small class="text-right">5 days ago</small>
                </div>

                <div class="invited">
                    <p class="name">Dr Mamun Or Rashid</p>
                    <p class="email">example@example.com</p>
                    <small class="text-right">1 wek ago</small>
                </div>

                <div class="invited">
                    <p class="name">Dr Mamun Or Rashid</p>
                    <p class="email">example@example.com</p>
                    <small class="text-right">1 wek ago</small>
                </div>

                <div class="invited">
                    <p class="name">Dr Mamun Or Rashid</p>
                    <p class="email">example@example.com</p>
                    <small class="text-right">1 wek ago</small>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {

        $('#notification-icon').click(function () {
            $('#notification-box').show().animate({
                width : '65vh',
                height : '100%',
                opacity : 1,
            });
            $('#notification-box').css('background-color', '#ffffff');
        });

        $(document).mouseup(function(e) {
            var container = $("#notification-box");
            // if the target of the click isn't the container nor a descendant of the container
            if (!container.is(e.target) && container.has(e.target).length === 0){
                container.hide();
            }
        });


        var attendVia, eventId ;
        $('.attend-via').change(function () {
            attendVia = $(this).val();
            eventId = $(this).attr('event-id');
            $.ajax({
                url : '/event/attend',
                type : 'post',
                dataType : 'text',
                data : {
                    _token : "{{ csrf_token() }}", attendVia : attendVia, eventId : eventId
                }, success : function (response) {
                    console.log(response);
                }, error : function (a, b, c) {
                    alert("Error Occurred. Please Reload page and try again");
                }
            });

            console.log(attendVia+' '+eventId);
        });

    });
</script>
</body>
</html>