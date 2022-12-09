<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Virtual Classroom</title>
    <style>
        body{

        }
        h3{
            text-align: center;
            font-weight: normal;
            color: #00565d;
            font-size: 4vh;
        }
        #box1{
            padding: 2vh 4vh;
        }
        .p1{
            color: #c83900;
            font-style: italic;
        }
        .p2{
            font-family: Lucida Sans;
            font-size: 3vh;
            line-height: 1.7;
        }
        #box2{
            padding: 2vh 4vh;

            font-size: 3vh;
        }
        #foot{
            padding: 2vh 4vh;
            font-size: 2.5vh;
        }
    </style>
</head>
<body>
<?php

?>

<div id="box1">
    <h3>{{ $event->title }}</h3>
    <p class="p2">
        {{ $event->abstract }}
    </p>
</div>
<br>

<div id="box2">

</div>
<br>

<div id="foot">

</div>
</body>
</html>