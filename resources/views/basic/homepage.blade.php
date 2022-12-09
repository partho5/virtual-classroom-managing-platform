<!DOCTYPE HTML>
<!--
	Hielo by TEMPLATED
	templated.co @templatedco
        Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html>
<head>
    <title>EAAS | Expertise As A Service</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<!-- Header -->
<header id="header" class="alt">
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
        <li><a href="{{ $dashboardLink }}">Dash Board</a></li>
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

<!-- Banner -->
<section class="banner full">
    <article>
        <img src="/assets/images/slide01.jpg" alt="" />
        <div class="inner">
            <header class="hide-text">
                <p>The first expert exchange platform for bangladesh</p>
                <h2>Experts</h2>
            </header>
        </div>
    </article>
    <article>
        <img src="/assets/images/slide02.jpg" alt="" />
        <div class="inner">
            <header class="hide-text">
                <p>help bangladesh for fostering research endeavor</p>
                <h2>Research</h2>
            </header>
        </div>
    </article>
    <article>
        <img src="/assets/images/slide03.jpg"  alt="" />
        <div class="inner">
            <header class="hide-text">
                <p>world class network and Infrastructure</p>
                <h2>DLT</h2>
            </header>
        </div>
    </article><article>
        <img src="/assets/images/slide03.jpg"  alt="" />
        <div class="inner">
            <header class="hide-text">
                <p>reach the tertiary education & research in Bangladesh</p>
                <h2>DLT</h2>
            </header>
        </div>
    </article>
    <article>
        <img src="/assets/images/slide04.jpg"  alt="" />
        <div class="inner">
            <header>
                <p>Be the first Contributor for your research sector in Bangladesh</p>
                <h2>EAAS</h2>
            </header>
        </div>
    </article>
    <article>
        <img src="/assets/images/slide05.jpg"  alt="" />
        <div class="inner">
            <header>
                <p>looking for experts? - <a href="/">eaas</a> is your platform.</p>
                <h2>BdREN</h2>
            </header>
        </div>
    </article>
    <article>
        <img src="/assets/images/slide01.jpg" alt="" />
        <div class="inner">
            <header class="hide-text">
                <p>looking for freshers? -  <a href="/">eaas</a> is the best choice</p>
                <h2>DLT</h2>
            </header>
        </div>
    </article>
</section>
<!-- Over Writed by Sourav -->


<!-- my-section-1 -->

<section style="padding-top:0px;" class="wrapper style2">
    <div class="inner">

        <!-- S-1 -->
        <div class="gallery">
            <div>
                <header class="align-center">
                    <h2>Introduction</h2>
                </header>
                <div class="image fit" style="text-align: justify">
                    <p>
                        Bangladesh one of the densely populated country of the world is now in the driving seat for its true recent developments. The significant strength, people of Bangladesh are contributing all over the world in research and technologies. Also, there are people who are contributing other sectors as well. An extremely potential country lacks a platform where experts in different sector can collaborate and communicate. Therefore, Bangladesh Research and Education Network (BdREN) would like to facilitate the potentials through a common platform titled Expert as a Service platform. The platform would be an enabler for different stakeholders to implement various communication and collaboration services in tertiary education sector of Bangladesh. BdREN has already implemented a huge network and other relevant infrastructure to provide the service.

                    </p>
                </div>
            </div>
            <div id="upcoming-events" style="line-height: 0.5;">
                <header class="align-center">
                    <h2>Upcomming Events</h2>
                </header>
                <div class="image fit">
                    @foreach($upcomingEvents as $event)
                        <h3 class="text-center" style="text-align: center; color: #cb4900">{{ $event->title }}</h3>
                        <p><b>Date Time:</b>{{ \Carbon\Carbon::parse($event->talk_delivery_time)->format('F j , g:i A') }}</p>
                        <p><a target="_blank" href="/event/{{ $event->id }}">Details</a></p>
                        <hr>
                    @endforeach

                        <footer class="align-center">
                            <a href="" class="button alt">View More</a>
                        </footer>
                </div>
            </div>
        </div>

        <!-- S-2 -->

        <header class="align-center">
            <h2>Infrastructure</h2>
        </header>

        <!-- S-3 -->

        <div class="gallery" style="text-align: justify">
            <div>
                <div class="image fit">
                    <img src="/assets/images/pic01.jpg" alt="" />
                    <p>
                        BdREN has established more than 4000+ KM fiber optic connectivity for the universities and research organizations. Physical connectivity with 34 public universities has already been established. The established backbone has redundant transmission which ensures the continuation of any on going service even if there is a fiber cut or other technical transmission disruptions. Along with the network, a total of 34 DLT has been established in 33 different public universities. DLT’s are equipped with projector, television displays, sophisticated sound system, electronic white board and many other components. With the devices, tools and software one can conduct a remote class almost just like a local class with the exception of speaker and participants are in a distant location. The electronic board is easy to operate and have the facility to use multi-color pen for better expression and understanding. Projector and television display devices can wonderfully reflect the local and remote participants and presentation of the speaker/white board.
                    </p>
                </div>
            </div>
            <div>
                <div class="image fit">
                    <img src="/assets/images/pic02.jpg" alt="" />
                    <p style="text-align: justify">
                        The lecture can even be interactive considering the sharing of the electronic while board. Teacher may ask questions remotely and student may response without a hand microphone as there is celling mounted microphone array in the room. The rooms also have acoustic capability to reduce noise and echo while remote lecture is going on. <br><br><br><br><br><br><br> Another twenty five (25) DLTs are going to be built in medical colleges and research institutes.  The primary objective is to supplement the classroom teaching with expert resources. Also, agricultural and other research centers are distributed all over the country. Video conferencing facility through DLTs would enable collaborative research among the centers as well as researches all over the world.
                    </p>
                </div>
            </div>
        </div>

        <!-- S-4 -->

        <div id="two" class="wrapper style3">
            <div class="inner">
                <header class="align-center">
                    <p>Distance Learning Theater</p>
                    <h2 style="font-size:10vh;">Intended Services</h2>
                </header>
            </div>
        </div>

        <!-- S-5 -->

        <div class="grid-style" style="padding-top:5vh;">

            <div>
                <div class="box">
                    <div class="image fit">
                        <img src="/assets/images/pic02.jpg" alt="" />
                    </div>
                    <div class="content">
                        <header class="align-center">
                            <p>Distance Learning Theater</p>
                            <h2>Knowledge Sharing</h2>
                        </header>
                        <p style="text-align: justify"> Researcher/Academicians/Faculties serving in Bangladesh or abroad may share their valuable research content through remote lecture. Interested expert may register at our site and request for a remote lecture to the relevant participants. The platform will automatically enable the resource person/expert with an account and inform participants regarding the lecture.</p>
                        <footer class="align-center">
                            <a href="" class="button alt">Learn More</a>
                        </footer>
                    </div>
                </div>
            </div>

            <div>
                <div class="box">
                    <div class="image fit">
                        <img src="/assets/images/pic03.jpg" alt="" />
                    </div>
                    <div class="content">
                        <header class="align-center">
                            <p>Distance Learning Theater</p>
                            <h2>Student Hiring</h2>
                        </header>
                        <p style="text-align: justify"> A good number of Bangladeshi nationals are working in different universities other than Bangladesh. If they want to hire postgraduate students, may request through our platform. The platform will help you to deliver your speech through DLT and interested students will be notified according to date and time to grab the opportunity.<br><br>  </p>
                        <footer class="align-center">
                            <a href="" class="button alt">Learn More</a>
                        </footer>
                    </div>
                </div>
            </div>

        </div>

        <!-- S-6 -->

        <div style="width: 100% !important;margin-top: 5vh;">

            <div>
                <div class="box">
                    <div class="content">
                        <header class="align-center">
                            <p>Distance Learning Theater</p>
                            <h2>Hiring Graduates</h2>
                        </header>
                        <p> Bangladeshis working in giants like google, facebook may inform Bangladeshi graduates regarding the opportunities in their respective organizations</p>
                        <footer class="align-center">
                            <a href="" class="button alt">Learn More</a>
                        </footer>
                    </div>
                </div>
            </div>

        </div>

    </div>   <!-- The inner tag -->
</section>
<!-- End overwrite -->


<!-- Footer -->
<footer id="footer">
    <div class="container">
        <ul class="icons">
            <li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
            <li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
            <li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
            <li><a href="#" class="icon fa-envelope-o"><span class="label">Email</span></a></li>
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

</body>
</html>