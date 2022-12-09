<!DOCTYPE html>
<html>
<head>
    <title>{{ $profileData['name'] }}</title>
    {{--<meta charset="utf-8">--}}
    {{--<meta name="viewport" content="width=device-width, initial-scale=1">--}}
    {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">--}}
    {{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>--}}
    {{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>--}}

    <link rel="stylesheet" type="text/css" href="/assets/css/profile.css" media="screen" />


    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Patua+One" rel="stylesheet">
</head>
<body>
<!-- Header -->
<header id="header" class="reveal">
    <div class="logo"><a href="/">EAAS <span>BdREN</span></a></div>
</header>
{{--Head End--}}

<div id="head1" class="col-md-12" style="background-color: #f9f9f9 !important;">
    <h2 class="text-center">My Profile</h2>
</div>

<div class="col-md-12 container-fluid" >
    <div class="col-md-6 col-md-offset-3">
        @if( ! is_null($warningMsg = Session::get('warningMsg')) )
            <p class="alert alert-danger" style="font-size: 20px">{{ $warningMsg }}</p>
            {{ Session::put('warningMsg', null) }}
        @endif
        <h3 class="text-center">Edit Profile</h3>
        <form action="/user/profile/{{ \Illuminate\Support\Facades\Auth::id() }}" method="post" enctype="multipart/form-data">
            <h4>General Information</h4>
            <input type="hidden" name="_method" value="PATCH">
            {{ csrf_field() }}
            <div class="form-group">
                <div class="input-group col-md-12">
                    <label for="" class="col-md-4">Name</label>
                    <div class="col-md-8">
                        <input name="name" type="text" class="form-control" value="{{ $profileData['name'] }}" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="input-group col-md-12">
                    <label for="" class="col-md-4">Email</label>
                    <div class="col-md-8">
                        <input name="email" type="email" class="form-control" value="{{ $profileData['email'] }}" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="input-group col-md-12">
                    <label for="" class="col-md-4">Phone Number</label>
                    <div class="col-md-8">
                        <input name="phone" type="text" class="form-control" value="{{ $profileData['phone'] }}" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="input-group col-md-12">
                    <label for="" class="col-md-4">My Photo</label>
                    <div class="col-md-8">
                        <input type="hidden" name="pp_src" value="{{ $profileData['pp_src'] }}">
                        <img src="/uploaded/{{ $profileData['pp_src'] }}" width="100px" height="100px" alt="image">
                        <input name="pp" type="file" class="form-control" {{ is_null($profileData['pp_src']) ? "required":"" }}>
                    </div>
                </div>
            </div>

            <h4>Academic Information</h4>
            <div class="form-group">
                <div class="input-group col-md-12">
                    <label for="" class="col-md-4">University</label>
                    <div class="col-md-12">
                        @foreach($univInfo as $key => $univ)
                            <p class="single-univ col-md-3">
                                <input type="radio" name="univ" {{ $profileData['univ'] == $key ? "checked":"" }} value="{{ $key }}" class="univ-name" required>
                                <span title="{{ $univ['univ_name'] }}">{{ $univ['univ_abbr'] }}</span>
                            </p>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="input-group col-md-12">
                    <label for="" class="col-md-4">Department</label>
                    <div class="col-md-8">
                        <input name="dept" type="text" class="form-control" value="{{ $profileData['dept'] }}" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="input-group col-md-12">
                    <label for="" class="col-md-4">Designation</label>
                    <div class="col-md-8" id="profession-wrapper">
                        <input name="designation" type="text" class="form-control" value="{{ $profileData['designation'] or "" }}" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="input-group col-md-12">
                    <label for="" class="col-md-4">Bio</label>
                    <div class="col-md-8" id="profession-wrapper">
                        <textarea name="bio" class="form-control" rows="4" required>{{ $profileData['bio'] or "" }}</textarea>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="input-group col-md-12">
                    <div class="col-md-4 col-md-offset-4">
                        <input type="submit" class="btn btn-success" value="Update Profile">
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>

<!--Footer-->
<footer id="footer" >
    <div class="container">
    <ul class="icons list-inline">
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

<script>
    $(document).ready(function () {

    });
</script>

</body>
</html>