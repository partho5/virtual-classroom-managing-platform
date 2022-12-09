<!DOCTYPE html>
<html>
<head>
    <title>Resource Person</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="/assets/css/representative.css" media="screen" />
</head>
<body>
    <div id="head1" class="col-md-12">
        <h2 class="text-center">{{ \Illuminate\Support\Facades\Auth::user()->name }} , Welcome !!</h2>
        <p class="text-center">
            You are now a Resource Person of <b>Virtual Classroom </b> project.. <br>
            Glad to have you. <br>
            Visit <a href="/">EAAS Home</a>
        </p>
    </div>
</body>
</html>