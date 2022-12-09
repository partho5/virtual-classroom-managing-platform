<!DOCTYPE html>
<html>
<head>
    <title>Events Manager</title>
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
                <p class="link"><a href="{{ $adminPanelLink }}">Admin Panel</a></p>
                <p class="link" id="invite-link">Send Invitation</p>
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

        <div id="middle-bar" class="col-md-9">
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
                                <input required type="email" id="email" class="form-control">
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


            <h3 class="text-center">Create A New Event</h3>
            <form action="/event" method="post" id="create-event-wrapper" class="container-fluid">
                {{ csrf_field() }}
                <div class="form-group">
                    <div class="input-group col-md-12">
                        <label for="" class="col-md-5">Title</label>
                        <div class="col-md-7">
                            <input required type="text" name="title" class="form-control" value="">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group col-md-12">
                        <label for="" class="col-md-5">Keywords</label>
                        <div class="col-md-7">
                            <input required type="text" name="keywords" class="form-control" value="">
                        </div>
                    </div>
                </div>

                @if($userRole == 'Super Admin')
                    <div class="form-group pop-up">
                        <div class="input-group col-md-12">
                            <label for="" class="col-md-5">Speaker Name</label>
                            <div class="col-md-7">
                                <input required id="speaker_name" class="form-control"  type="text" placeholder="Enter only suggested names">
                                <input required id="speaker_id" name="speaker_id" class="form-control"  type="hidden">
                            </div>
                        </div>
                        <!--hidden-pop-up-->

                        <div class="input-group col-md-12 pop-up-dir" id="speaker-suggestion-wrapper">
                            <label for="" class="col-md-5"></label>
                            <div class="col-md-7 bg">
                                <div class="col-md-12">
                                    <div class="suggestion">
                                        <p class="speaker-name">Name</p>
                                        <p class="speaker-univ">University</p>
                                    </div>
                                    <div class="suggestion">
                                        <p class="speaker-name">Name</p>
                                        <p class="speaker-univ">University</p>
                                    </div>
                                    <div class="suggestion">
                                        <p class="speaker-name">Name</p>
                                        <p class="speaker-univ">University</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                @endif

                <div class="form-group">
                    <div class="input-group col-md-12">
                        <label for="" class="col-md-5">Abstract</label>
                        <div class="col-md-7">
                            <textarea name="abstract" class="form-control" rows="4" ></textarea>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group col-md-12">
                        <label for="" class="col-md-5">Talk Delivery Time</label>
                        <div class="col-md-7">
                            <input required type="text" name="talk_delivery_time" id="talk_delivery_time" class="form-control" value="">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group col-md-12">
                        <label for="" class="col-md-5">Deliver lecture using DLT ?</label>
                        <div class="col-md-7">
                            <select name="use_dlt" id="use_dlt" class="form-control" >
                                <option value="No">No</option>
                                <option value="Yes">Yes</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group col-md-12">
                        <label for="" class="col-md-5">Target Audience</label>
                        <div class="col-md-7">
                            <input required type="text" name="target_audience" class="form-control" value="">
                        </div>
                    </div>
                </div>

                @if($userRole == 'Super Admin')
                    <div class="form-group">
                        <div class="input-group col-md-12">
                            <label for="" class="col-md-5">Dialing Number</label>
                            <div class="col-md-7">
                                <input required type="text" name="client_dial_num" class="form-control" value="">
                            </div>
                        </div>
                    </div>

                    <div class="form-group" id="username-wrapper">
                        <div class="input-group col-md-12">
                            <label for="" class="col-md-5">Username</label>
                            <div class="col-md-7">
                                <input type="text" name="client_username" class="form-control" >
                            </div>
                        </div>
                    </div>

                    <div class="form-group" id="pass-wrapper">
                        <div class="input-group col-md-12">
                            <label for="" class="col-md-5">Password</label>
                            <div class="col-md-7">
                                <input type="text" name="client_password" class="form-control" >
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group col-md-12">
                            <label for="" class="col-md-5">University Contacts</label>
                            <div class="col-md-12">
                                @foreach($univInfo as $key => $univ)
                                    <p class="single-univ col-md-3">
                                        <input {{ $key==0 ? "checked":"" }} type="checkbox" name="univ_id_to_notify[]" value="{{ $key }}" class="univ-name">
                                        <span title="{{ $univ['univ_name'] }}">{{ $univ['univ_abbr'] }}</span>
                                    </p>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group col-md-12">
                            <label for="" class="col-md-12">Email Message To Speaker</label>
                            <div class="col-md-12">
                                Dear < username >,
                                <textarea class="form-control" name="msg_sent_to_speaker" rows="5">{{ $emailMsgToRepresentative }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group col-md-12">
                            <label for="" class="col-md-12">Email Message To Representative ( University Contacts )</label>
                            <div class="col-md-12">
                                Dear < username >,
                                <textarea class="form-control" name="msg_sent_to_representative" rows="5">{{ $emailMsgToRepresentative }}</textarea>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="form-group">
                    <div class="input-group col-md-12">
                        <input required class="btn btn-success col-md-4 col-md-offset-4" type="submit" value="Create Event">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css">
<script>
    $(document).ready(function () {
        $('#talk_delivery_time').datetimepicker({
            format : 'YYYY-MM-DD HH:mm'
        });


        $(function() {
            $( "#speaker_name" ).autocomplete({
                source: "/event_create_helper/get_representative_names",
                focus: function( event, ui ) {
                    $( "#speaker_id" ).val( ui.item.id );
                    return false;
                },
                select: function( event, ui ) {
                    console.log(ui.item);
                    $( "#speaker_name" ).val( ui.item.only_name );
                    $( "#speaker_id" ).val( ui.item.id );
                    return false;
                }
            });
        });



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


        $('#use_dlt').change(function () {
            var useDlt = $(this).val();
            if(useDlt === 'Yes'){
                $('#username-wrapper, #pass-wrapper').slideUp();
            }
            if(useDlt === 'No'){
                $('#username-wrapper, #pass-wrapper').slideDown();
            }
        });

    });
</script>
</body>
</html>