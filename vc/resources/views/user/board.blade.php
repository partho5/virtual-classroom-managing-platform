<!DOCTYPE HTML>
<html>
<head>
    <title>My Profile</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Patua+One" rel="stylesheet">

    <link rel="stylesheet" href="/assets/css/user-dash-nav-bar.css">

    <link rel="stylesheet" type="text/css" href="/assets/css/user.css" media="screen" />
</head>
<body>

<!-- Header -->
<header id="header" class="reveal">
    <div class="logo"><a href="/">EAAS <span>BdREN</span></a></div>
    <a href="#menu"><b>Menu</b></a>
</header>

<!-- Nav -->
<nav id="menu">
    <ul class="links">
        <li><a href="/">Home</a></li>
        @if( ! \Illuminate\Support\Facades\Auth::id() )
            <li><a href="/login">Login</a></li>
            <li><a href="/register">Registration</a></li>
        @endif

        @if( \Illuminate\Support\Facades\Auth::id() )
            <li><a href="/user/profile">Edit My Profile</a></li>
            <li>
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault();
               document.getElementById('logout-form').submit();">
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        @endif
    </ul>
</nav>


<div class="container-fluid">
    <div id="events-wrapper" class="col-md-12">
        <div id="events" class="col-md-8">
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

        <div id="right-bar" class="col-md-4">
            <div id="past-events" class="">
                <h2 class="text-center">Past Events</h2>
                @foreach($pastEvents as $event)
                    <div class="event-wrapper col-md-12">
                        <div class="event-title col-md-9">{{ $event->title }}</div>
                        <div class="col-md-3 attending-status">{{ $event->alreadyAttended ? 'Attended':'Missed' }}</div>
                    </div>
                @endforeach
            </div>

            <div id="past-events2" class="">
                <h3 class="text-center">Something Else</h3>
                <div class="event-wrapper col-md-12">
                    <div class="event-title col-md-9">When Goal Is Google</div>
                    <div class="col-md-3 attending-status">Missed</div>
                </div>

                <div class="event-wrapper col-md-12">
                    <div class="event-title col-md-9">A Step Towards Machine Learning</div>
                    <div class="col-md-3 attending-status">Attended</div>
                </div>

                <div class="event-wrapper col-md-12">
                    <div class="event-title col-md-9">When Goal Is Google</div>
                    <div class="col-md-3 attending-status">Missed</div>
                </div>

                <div class="event-wrapper col-md-12">
                    <div class="event-title col-md-9">When Goal Is Google</div>
                    <div class="col-md-3 attending-status">Missed</div>
                </div>
            </div>

            <div id="request-wrapper" class="">
                <h3 class="text-center">Request For Speech</h3>
                <p>Write Something</p>
                <textarea name="" id="" class="col-md-12" rows="4" placeholder="Write Something"></textarea>
                <div class="col-md-12">
                    <br>
                    <button class="btn btn-success col-md-6 col-md-offset-3">Request</button>
                </div>
            </div>
        </div>

    </div>
</div>


<!--Footer-->
<footer id="footer">
    <div class="container">
        <ul class="icons">
            <li><a href="#" class="fa fa-twitter"><span class="label">Twitter</span></a></li>
            <li><a href="#" class="fa fa-facebook"><span class="label">Facebook</span></a></li>
            <li><a href="#" class="fa fa-instagram"><span class="label">Instagram</span></a></li>
            <li><a href="#" class="fa fa-envelope-o"><span class="label">Email</span></a></li>
        </ul>
    </div>
    <div class="copyright">
        &copy; Dr. Md. Mamun-Or-Rashid. All rights reserved.
    </div>
</footer>

<!-- Scripts -->
<script src="/assets/js/jquery.min.js"></script>
<script src="/assets/js/jquery.scrollex.min.js"></script>
<script src="/assets/js/skel.min.js"></script>
<script src="/assets/js/util.js"></script>
<script src="/assets/js/main.js"></script>


<script>
    $(document).ready(function () {
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