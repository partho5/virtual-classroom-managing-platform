<!DOCTYPE html>
<html>
<head>
    <title>Super Admin Panel</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="/assets/css/superadmin.css" media="screen" />
</head>
<body>
    <div class="container-fluid">
        <div class="col-md-12">
            <div id="left-bar" class="col-md-2">
                <h2 class="text-center">Super Admin</h2>
                <div id="links">
                    <p class="link"><a href="/">Home</a></p>
                    <p class="link"><a href="/super">Admin Panel</a></p>
                    <p class="link" id="invite-link">Send Invitation</p>
                    <p class="link"><a href="/event/create">Create Event</a></p>
                    <p class="link hidden" id="notification-icon">
                        <span>Whats Happening</span>
                        <span class="notification-count">{{ count($UnseenNotifications) }}</span>
                    </p>
                    <div class="link text-left" id="notification-box">
                        <span class="h5 text-center">Notifications</span>

                        @foreach($UnseenNotifications as $notification)
                            <br>
                            <span class="each-notification">
                                <span class="unread">New</span>
                                {!! $notification !!}
                            </span>
                        @endforeach
                    </div>
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


                <div id="invite">
                    <h3 class="text-center">Send Invitation</h3>
                    <div class="form-group">
                        <div class="input-group col-md-12">
                            <label for="" class="col-md-3">Invite to be</label>
                            <div class="col-md-9">
                                <select name="invite-to-be" id="invite-to-be" class="form-control">
                                    <option value="Representative">Representative</option>
                                    <option value="Speaker">Resource Person</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group col-md-12">
                            <label for="" class="col-md-3">Email</label>
                            <div class="col-md-9">
                                <input type="email" id="email" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group col-md-12">
                            <label for="" class="col-md-3">Message</label>
                            <div class="col-md-9">
                                <textarea name="" id="msg" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group col-md-12">
                            <button id="invite-to-representative-btn" class="btn btn-success col-md-4 col-md-offset-4">Send Mail</button>
                        </div>
                    </div>
                </div>

                <h3 class="text-center">Events Need My Approval</h3>
                <div id="single-admin-wrapper" class="col-md-12">
                    @foreach($unapprovedEvents as $event)
                        <div class="single-event col-md-12">
                            <h4><a href="/event/{{ $event->id }}">{{ $event->title }}</a></h4>
                            <p class="speaker-name"><b>Speaker :</b>{{ $event->speakerName }}</p>
                            <p class="abstract"><b>Abstract :</b>{{ $event->abstract }}</p>
                            <p class="keywords"><b>Keywords :</b>{{ $event->keywords }}</p>
                            <p class="target-audience"><b>Target Audience :</b>{{ $event->target_audience }}</p>
                            <hr>
                            <button class="show-approval-btn btn btn-info form-control">Show Approval Options</button>
                            <div class="event-action-wrapper col-md-12">
                                <h4>
                                    @if($event->use_dlt == 'No')
                                    Desktop Video Conference Client (In case of lecture out of DLT)
                                    @else
                                    Dial number to enter DLT
                                    @endif
                                </h4>
                                <div class="form-group">
                                    <label for="" class="col-md-5">Dialing Number</label>
                                    <div class="input-group col-md-7">
                                        <input type="text" id="client-dial-number{{ $event->id }}" class="form-control">
                                    </div>
                                </div>

                                @if($event->use_dlt == 'Yes')
                                <div class="form-group">
                                    <label for="" class="col-md-5">Username</label>
                                    <div class="input-group col-md-7">
                                        <input type="text" id="client-username{{ $event->id }}" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-md-5">Password</label>
                                    <div class="input-group col-md-7">
                                        <input type="password" id="client-password{{ $event->id }}" class="form-control">
                                    </div>
                                </div>
                                @endif

                                <h4>Notify University Contacts</h4>
                                <div id="univ-names-wrapper{{ $event->id }}" class="col-md-12">
                                @foreach($univInfo as $key => $univ)
                                    <p class="single-univ col-md-3">
                                        <input type="checkbox" value="{{ $key }}" class="univ-name">
                                        <span title="{{ $univ['univ_name'] }}">{{ $univ['univ_abbr'] }}</span>
                                    </p>
                                @endforeach
                                </div>

                                <h4>Action</h4>
                                <div class="form-group">
                                    <label>Email Message To Speaker</label>
                                    <div class="input-group col-md-12">
                                        Dear < username >,
                                        <textarea id="email-msg-to-speaker{{ $event->id }}" class="form-control" rows="5">{{ $emailMsgToSpeaker }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Email Message To Representative ( University Contacts )</label>
                                    <div class="input-group col-md-12">
                                        Dear < username >,
                                        <textarea id="email-msg-to-representative{{ $event->id }}" class="form-control" rows="5">{{ $emailMsgToRepresentative }}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <hr>
                                    <h4 class="col-md-7">
                                        <input type="checkbox" class="i-understand-checkbox"> I have completed all activities
                                    </h4>
                                    <button class="approve-btn btn btn-success col-md-4" event-id="{{ $event->id }}">Approve</button>
                                </div>
                            </div>
                        </div>
                    @endforeach


                    {{--@foreach($representativeProfiles as $profile)--}}
                        {{--<div class="single-admin col-md-12">--}}
                            {{--<img src="/uploaded/{{ $profile['pp_src'] }}" alt="" class="col-md-4">--}}
                            {{--<div class="col-md-8">--}}
                                {{--<p class="name"><a href="/user/profile/{{ $profile['user_id'] }}">{{ $profile['name'] }}</a></p>--}}
                                {{--<p class="designation">{{ $profile['designation'] }}</p>--}}
                                {{--<p class="institute">{{ $profile['dept'] }}, {{ $profile['univ'] }}</p>--}}
                                {{--<p class="email">Email : {{ $profile['email'] }}</p>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="single-admin col-md-12">--}}
                            {{--<img src="/uploaded/{{ $profile['pp_src'] }}" alt="" class="col-md-4">--}}
                            {{--<div class="col-md-8">--}}
                                {{--<p class="name"><a href="/user/profile/{{ $profile['user_id'] }}">{{ $profile['name'] }}</a></p>--}}
                                {{--<p class="designation">{{ $profile['designation'] }}</p>--}}
                                {{--<p class="institute">{{ $profile['dept'] }}, {{ $profile['univ'] }}</p>--}}
                                {{--<p class="email">Email : {{ $profile['email'] }}</p>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="single-admin col-md-12">--}}
                            {{--<img src="/uploaded/{{ $profile['pp_src'] }}" alt="" class="col-md-4">--}}
                            {{--<div class="col-md-8">--}}
                                {{--<p class="name"><a href="/user/profile/{{ $profile['user_id'] }}">{{ $profile['name'] }}</a></p>--}}
                                {{--<p class="designation">{{ $profile['designation'] }}</p>--}}
                                {{--<p class="institute">{{ $profile['dept'] }}, {{ $profile['univ'] }}</p>--}}
                                {{--<p class="email">Email : {{ $profile['email'] }}</p>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--@endforeach--}}
                </div>
            </div>

            <div id="right-bar" class="col-md-3">
                @if(count($invitedPersons) > 0)
                    <h3 class="text-center">Invited People</h3>
                    <div id="invited-wrapper">
                        @foreach($invitedPersons as $person)
                            <div class="invited">
                                <p class="name"><a href="/user/profile/{{ $person->id }}">{{ $person->name }}</a></p>
                                <p class="email">{{ $person->email }}</p>
                                <small class="text-right" title="{{ \Carbon\Carbon::parse($person->invited_at)->format('F j [ g:i A ]') }}">{{ \Carbon\Carbon::parse($person->invited_at)->diffForHumans() }}</small>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if(count($upcomingEvents) > 0)
                    <h3 class="text-center">Upcoming Events</h3>
                    <div id="upcoming-event-wrapper">
                        @foreach($upcomingEvents as $event)
                            <div class="each-event">
                                <p class="event-title"><a href="/event/{{ $event->id }}">{{ $event->title }}</a></p>
                                <p class="date-time">{{ \Carbon\Carbon::parse($event->talk_delivery_time)->format('F j, g:i A') }}</p>
                                <div class="text-center">
                                    <span class="col-md-4"><a target="_blank" href="/event/{{ $event->id }}">Details</a></span>
                                    <span class="col-md-4"><a href="/event/{{ $event->id }}/edit">Edit</a></span>
                                    <form action="{{ URL::route('event.destroy', $event->id) }}" method="POST">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button class="delete-event-btn btn-danger" style="font-size: 12px">Delete</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

<script type="text/javascript">
    $(document).ready(function () {

        $('#invite-link').click(function () {
            $('#invite').show().animate({
                opacity : 1,
                height : '100%',
            });
        });

        $('#invite-to-representative-btn').click(function () {
            var email = $('#email').val();
            var msg = $('#msg').val();
            var inviteToBe = $('#invite-to-be').val();

            if(email && msg){
                $.ajax({
                    url : '/super/invite_to_come_in_role',
                    type : 'post',
                    dataType : 'text',
                    data : {
                        _token : "{{ csrf_token() }}", email : email, msg : msg, inviteToBe : inviteToBe
                    }, success : function (response) {
                        console.log(response);
                        if(response == 404){
                            $('#error-msg').show();
                            $('#error-msg').animate({
                                marginTop : '30%',
                                opacity : 1
                            }, function () {
                                setTimeout(function () {
                                    $('#error-msg').fadeOut(1000);
                                }, 1500);
                            });
                            console.log(response);
                        }else if (response === 'sent'){
                            $('#success-msg').show();
                            $('#success-msg').animate({
                                marginTop : '30%',
                                opacity : 1
                            }, function () {
                                setTimeout(function () {
                                    $('#success-msg').animate({
                                        opacity : 0
                                    });
                                    location.reload();
                                }, 1500);
                            });
                            console.log(response);
                        } else if(response === 'already invited'){
                            alert("This person is already invited");
                        }
                    }, error : function (a, b, c) {
                        console.log(c);
                    }
                }); // ajax
            }else{
                alert("Email and Message both fields are mandatory");
            }
        }); // #invite-to-representative-btn clicked


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

        $('.notification-link').hover(function () {
            var id = $(this).attr('id');
            var source = $(this).attr('source');

            console.log(id+' '+source);
        });


        $('.show-approval-btn').click(function () {
            var btnTxt = $(this).text();
            if(btnTxt === "Show Approval Options"){
                btnTxt = "Hide Options";
            } else if(btnTxt === "Hide Options"){
                btnTxt = "Show Approval Options";
            }
            $(this).text(btnTxt);
            $(this).siblings('.event-action-wrapper').slideToggle();
        });

        $('.i-understand-checkbox').click(function () {
            if($(this).is(':checked')){
                $(this).parent().siblings('.approve-btn').show();
            }else{
                $(this).parent().siblings('.approve-btn').hide();
            }
        });


        $('.approve-btn').click(function () {
            var eventId = $(this).attr('event-id');
            var clientUserName = $('#client-username'+eventId).val();
            var clientPassword = $('#client-password'+eventId).val();
            var clientDialNumber = $('#client-dial-number'+eventId).val();
            var univIdToNotify = [];
            $('#univ-names-wrapper'+eventId+' input').each(function () {
                if( $(this).is(':checked') ){
                    univIdToNotify.push( $(this).val() );
                }
            });
            univIdToNotify = JSON.stringify(univIdToNotify);
            var emailMsgToSpeaker = $('#email-msg-to-speaker'+eventId).val();
            var emailMsgToRepresentative = $('#email-msg-to-representative'+eventId).val();


            //console.log(clientUserName+clientPassword+clientDialNumber+clientAppInstallLink);
            //console.log(emailMsgToRepresentative+emailMsgToSpeaker);

            var t1 = new Date();
            var t2;
            t1 = t1.getTime();
            alert('Please wait till system gives the confirmation message');

            $.ajax({
                url : '/event/approve',
                type : 'post',
                datType : 'text',
                data : {
                    _token : "{{ csrf_token() }}", id : eventId, client_username : clientUserName,
                    client_password : clientPassword, client_dial_num : clientDialNumber,
                    univ_id_to_notify : univIdToNotify,
                    msg_sent_to_speaker : emailMsgToSpeaker, msg_sent_to_representative : emailMsgToRepresentative,
                }, success : function (response) {
                    console.log(response);
                    alert("Approved");
                    location.reload();
                    t2 = new Date();
                    t2 = t2.getTime();
                    console.log(t1 - t2);
                }, error : function (a, b, c) {
                    alert("Opss ! Error Occurred. Please Try Again");
                }
            });
        });


        $('.delete-event-btn').click(function (e) {
            if( ! confirm("Sure delete ? Once deleted this can't be undone")){
                e.preventDefault();
            }
        });

    });
</script>
</body>
</html>