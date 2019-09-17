
<?php 
if(isset($_SESSION['username'])){
	session_start();
	$_SESSION = array();
	session_destroy();
	header('location: ../../index.html');
}

require_once ("config.php"); 

if(isset($_POST['username']) && isset($_POST['password'])){
    
    $username=trim($_POST['username']);
    $password=$_POST['password'];
    
    $sql="select * from users where username='".$username."'AND password='".$password."'";
    $stmt = mysqli_prepare($conn, $sql);

    $result=mysqli_query($conn,$sql);

    if(mysqli_num_rows($result)){
		session_start();
		$_SESSION['username'] = $username;		
        header("location: ../home.php");
        // TextNode("success","Login Successful");
        // exit();
    }
    else{
        header("location: login.php");
        // TextNode("success", "Login Failed!");
        // echo " You Have Entered Incorrect Password";
        // exit();
    }
        
}
?>

<!DOCTYPE HTML>
<html>
	<head>
	<script language="javascript" type="text/javascript">
    	window.history.forward();
  	</script>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Education &mdash; Free Website Template, Free HTML5 Template by freehtml5.co</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Free HTML5 Website Template by freehtml5.co" />
	<meta name="keywords" content="free website templates, free html5, free template, free bootstrap, free website template, html5, css3, mobile first, responsive" />
	<meta name="author" content="freehtml5.co" />


	<meta property="og:title" content=""/>
	<meta property="og:image" content=""/>
	<meta property="og:url" content=""/>
	<meta property="og:site_name" content=""/>
	<meta property="og:description" content=""/>
	<meta name="twitter:title" content="" />
	<meta name="twitter:image" content="" />
	<meta name="twitter:url" content="" />
	<meta name="twitter:card" content="" />

	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto+Slab:300,400" rel="stylesheet">
	
	<!-- Animate.css -->
	<link rel="stylesheet" href="../../css/animate.css">
	<!-- Icomoon Icon Fonts-->
	<link rel="stylesheet" href="../../css/icomoon.css">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="../../css/bootstrap.css">

	<!-- Magnific Popup -->
	<link rel="stylesheet" href="../../css/magnific-popup.css">

	<!-- Owl Carousel  -->
	<link rel="stylesheet" href="../../css/owl.carousel.min.css">
	<link rel="stylesheet" href="../../css/owl.theme.default.min.css">

	<!-- Flexslider  -->
	<link rel="stylesheet" href="../../css/flexslider.css">

	<!-- Pricing -->
	<link rel="stylesheet" href="../../css/pricing.css">

	<!-- Theme style  -->
	<link rel="stylesheet" href="../../css/style.css">

	<!-- Modernizr JS -->
	<script src="../../js/modernizr-2.6.2.min.js"></script>

	</head>
	<body>
		
	<div class="fh5co-loader"></div>
	
	<div id="page">
	<nav class="fh5co-nav" role="navigation">
		<div class="top">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 text-right">
						<p class="site">www.pheonixhome.org</p>
						<p class="num">Call: +91 123 456 7890</p>
						<ul class="fh5co-social">
							<li><a href="#"><i class="icon-facebook2"></i></a></li>
							<li><a href="#"><i class="icon-twitter2"></i></a></li>
							<li><a href="#"><i class="icon-dribbble2"></i></a></li>
							<li><a href="#"><i class="icon-github"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="top-menu">
			<div class="container">
				<div class="row">
					<div class="col-xs-2">
						<!-- To add orphanage logo here -->
						<div id="fh5co-logo"><a href="../../index.html"><i class="icon-head"></i>PHEONIXHOME</div>
					</div>
					<div class="col-xs-10 text-right menu-1">
						<ul>
							<li><a href="index.html">Home</a></li>
							<li><a href="courses.html">Courses</a></li>
							<li><a href="teacher.html">Teacher</a></li>
							<li><a href="about.html">About</a></li>
							<li><a href="pricing.html">Pricing</a></li>
							<li class="has-dropdown">
								<a href="blog.html">Blog</a>
								<ul class="dropdown">
									<li><a href="#">Web Design</a></li>
									<li><a href="#">eCommerce</a></li>
									<li><a href="#">Branding</a></li>
									<li><a href="#">API</a></li>
								</ul>
							</li>
							<!-- <li class="active"><a href="contact.html">Contact</a></li> -->
							<li class="btn-cta"><a href="login.php"><span>Login</span></a></li>
							<li class="btn-cta"><a href="signup.php"><span>Signup</span></a></li>
						</ul>
					</div>
				</div>
				
			</div>
		</div>
	</nav>

	<div id="fh5co-contact">
		<div class="container">
			<div class="row">
				<div class="col-md-5 col-md-push-1 animate-box">
					
					<div class="fh5co-contact-info">
						<h3>Contact Information</h3>
						<ul>
							<li class="address">198 West 21th Street, <br> Suite 721 New York NY 10016</li>
							<li class="phone"><a href="tel://1234567920">+ 1235 2355 98</a></li>
							<li class="email"><a href="mailto:info@yoursite.com">info@yoursite.com</a></li>
							<li class="url"><a href="http://freehtml5.co">freeHTML5.co</a></li>
						</ul>
					</div>

				</div>

            
				<div class="col-md-6 animate-box">
                    <h3>Login</h3>
                    <p>Please fill in your credentials to login.</p>
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
						<div class="row form-group">
							<div class="col-md-6">
                                <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                                    <input type="text" id="fname" name="username" autocomplete="off" class="form-control" placeholder="Username">
                                </div>    

                                <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                                    <input type="Password" id="subject" name="password" autocomplete="off" class="form-control" placeholder="Password">
                                </div>    
							</div>
						</div>	
						
						<div class="form-group">
                            <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                            <p>Don't have an account? <a href="signup.php">Sign up now</a>.</p>
						</div>

                    </form>		
                    </div>
				</div>
			</div>

	<div id="fh5co-register" style="background-image: url(../../images/img_bg_2.jpg);">
		<div class="overlay"></div>
		<div class="row">
			<div class="col-md-8 col-md-offset-2 animate-box">
				<div class="date-counter text-center">
					<h2>Get your Ticket to the Annual Event</h2>
					<h3>By Pheonix Home</h3>
					<div class="simply-countdown simply-countdown-one"></div>
					<p><strong>Limited Tickets, Hurry Up!</strong></p>
					<p><a href="#" class="btn btn-primary btn-lg btn-reg">Register Now!</a></p>
				</div>
			</div>
		</div>
	</div> 

	<footer id="fh5co-footer" role="contentinfo" style="background-image: url(../../images/img_bg_4.jpg);">
		<div class="overlay"></div>
		<div class="container">
			<div class="row row-pb-md">
				<div class="col-md-3 fh5co-widget">
					<h3>About Phoenix Home</h3>
					<p>A privately funded organization eastablished in 2019 contributing towars the betterment of the society.</p>
				</div>
				<div class="col-md-2 col-sm-4 col-xs-6 col-md-push-1 fh5co-widget">
					<h3>Learning</h3>
					<ul class="fh5co-footer-links">
						<li><a href="#">Course</a></li>
						<li><a href="#">Blog</a></li>
						<li><a href="#">Contact</a></li>
						<li><a href="#">Terms</a></li>
						<li><a href="#">Meetups</a></li>
					</ul>
				</div>

				<div class="col-md-2 col-sm-4 col-xs-6 col-md-push-1 fh5co-widget">
					<h3>Learn &amp; Grow</h3>
					<ul class="fh5co-footer-links">
						<li><a href="#">Blog</a></li>
						<li><a href="#">Privacy</a></li>
						<li><a href="#">Testimonials</a></li>
						<li><a href="#">Handbook</a></li>
						<li><a href="#">Held Desk</a></li>
					</ul>
				</div>

				<div class="col-md-2 col-sm-4 col-xs-6 col-md-push-1 fh5co-widget">
					<h3>Engage us</h3>
					<ul class="fh5co-footer-links">
						<li><a href="#">Marketing</a></li>
						<li><a href="#">Visual Assistant</a></li>
						<li><a href="#">System Analysis</a></li>
						<li><a href="#">Advertise</a></li>
					</ul>
				</div>

				<div class="col-md-2 col-sm-4 col-xs-6 col-md-push-1 fh5co-widget">
					<h3>Legal</h3>
					<ul class="fh5co-footer-links">
						<li><a href="#">Find Designers</a></li>
						<li><a href="#">Find Developers</a></li>
						<li><a href="#">Teams</a></li>
						<li><a href="#">Advertise</a></li>
						<li><a href="#">API</a></li>
					</ul>
				</div>
			</div>

			<div class="row copyright">
				<div class="col-md-12 text-center">
					<p>
						<small class="block">&copy; 2019|All Rights Reserved.</small> 
						<small class="block">Designed by ChildOrphan.org</small>
					</p>
				</div>
			</div>

		</div>
	</footer>
	<div class="gototop js-top">
		<a href="#" class="js-gotop"><i class="icon-arrow-up"></i></a>
	</div>
</div>

	
<!-- jQuery -->
<script src="../../js/jquery.min.js"></script>
	<!-- jQuery Easing -->
	<script src="../../js/jquery.easing.1.3.js"></script>
	<!-- Bootstrap -->
	<script src="../../js/bootstrap.min.js"></script>
	<!-- Waypoints -->
	<script src="../../js/jquery.waypoints.min.js"></script>
	<!-- Stellar Parallax -->
	<script src="../../js/jquery.stellar.min.js"></script>
	<!-- Carousel -->
	<script src="../../js/owl.carousel.min.js"></script>
	<!-- Flexslider -->
	<script src="../../js/jquery.flexslider-min.js"></script>
	<!-- countTo -->
	<script src="../../js/jquery.countTo.js"></script>
	<!-- Magnific Popup -->
	<script src="../../js/jquery.magnific-popup.min.js"></script>
	<script src="../../js/magnific-popup-options.js"></script>
	<!-- Count Down -->
	<script src="../../js/simplyCountdown.js"></script>
	<!-- Main -->
	<script src="../../js/main.js"></script>

	<script>
        var d = new Date(new Date().getTime() + 1000 * 30 * 60 * 2000);

        // default example
        simplyCountdown('.simply-countdown-one', {
            year: d.getFullYear(),
            month: d.getMonth() + 1,
            day: d.getDate()
        });

        //jQuery example
        $('#simply-countdown-losange').simplyCountdown({
            year: d.getFullYear(),
            month: d.getMonth() + 1,
            day: d.getDate(),
            enableUtc: false
        });
	</script>
	</body>
</html>

