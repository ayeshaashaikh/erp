<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>College ERP System - JMCT Polytechnic</title>
    <link rel="stylesheet" href="css/styles.css"> <!-- Link to your CSS file -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }

       /* Navbar */

 /* Navbar */
/* Navbar */
/* Navbar */
.navbar {
    background-color: rgba(255, 255, 255, 0.1) !important; /* Slightly visible, near-transparent background */
    padding: 0.5rem 1rem; /* Compact padding */
    box-shadow: none; /* Remove shadow for a cleaner look */
    z-index: 1000; /* Ensure the navbar stays above other content */
    padding-bottom:20px;
}

.navbar-brand img {
    height: 50px; /* Adjust logo size */
}

/* Aligning navbar items to the right with space between them */
.navbar-nav {
    margin-left: auto; /* Push items to the right */
    display: flex; /* Ensure items are aligned in a row */
    margin-top:10px;
}

.navbar-nav .nav-item {
    margin-left: 10px; /* Space between items */
}

.navbar-nav .nav-link {
    width: 100px; /* Fixed width for each link */
    color: White !important; /* Light color for contrast */
    padding: 0.5rem; /* Adjust padding to control link height */
    border-radius: 20px; /* Slightly rounded corners */
    background-color: #bd0d0d;
    text-align: center; /* Center text inside the link */
    display: inline-flex; /* Use inline-flex to respect width and align content */
    align-items: center; /* Center items vertically */
    justify-content: center; /* Center items horizontally */
    transition: background-color 0.3s ease, color 0.3s ease;
}

.navbar-nav .nav-link:hover {
    background-color: rgba(255, 255, 255, 0.2); /* Slightly visible background on hover */
    color: #fff !important; /* Keep text color light */
}

.navbar-toggler {
    border-color: #fff !important; /* Light border color for toggler */
}

.navbar-toggler-icon {
    background-image: url('data:image/svg+xml,...'); /* Optional: Custom icon */
}

        /* Hero Section */
        .hero-section {
            position: relative;
           
            background-size: cover;
            text-align: center;
            padding: 0px;
            
            margin-top: -3px;
            color: #fff;
        }

        .hero-section::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 660px;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1;
        }

        .hero-section .container {
            position: relative;
            z-index: 2;
        }

        .hero-section h1 {
            font-size: 3rem;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        .hero-section p {
            font-size: 1.25rem;
            margin-bottom: 30px;
        }

        .hero-section .btn {
            background-color: #d32f2f;
            color: #fff;
            padding: 10px 20px;
            font-size: 1rem;
            border: none;
            text-transform: uppercase;
        }
        /* Carousel */
.carousel-item img {
   
    object-fit: cover; /* Ensures images cover the carousel area without distortion */
    height: 90vh; /* Adjust height as needed, increased from 60vh to 80vh */
    width: 100%;
    margin-bottom:100px;

}

.carousel-caption {
    bottom: 30%; /* Adjusts the vertical position of the caption */
    text-align: center;
    z-index: 2;
}

.carousel-caption h1 {
    font-size: 3rem; /* Adjust size for readability */
    font-weight: 700;
    color: #fff; /* Ensure text is readable */
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7); /* Adds shadow for better text visibility */
    margin-bottom: 10px;
}

.carousel-caption p {
    font-size: 1.25rem;
    color: #fff; /* Keep text color light */
    text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.7); /* Adds shadow for better text visibility */
    margin-bottom: 20px;
}

.carousel-control-prev, .carousel-control-next {
    filter: invert(1); /* Adjust icon color for better visibility on dark backgrounds */
}

.carousel-control-prev-icon, .carousel-control-next-icon {
    background-color: rgba(0, 0, 0, 0.5); /* Add a background for better visibility */
    border-radius: 50%; /* Make icons round */
    padding: 10px; /* Add padding around icons */
}

.carousel-control-prev-icon::after, .carousel-control-next-icon::after {
    font-size: 2rem; /* Increase icon size for better visibility */
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .carousel-caption h1 {
        font-size: 2rem;
    }

    .carousel-caption p {
        font-size: 1rem;
    }

    .carousel-control-prev-icon::after, .carousel-control-next-icon::after {
        font-size: 1.5rem;
    }
}


        /* Info Section */
        .info-section {
            padding: 60px 0;
            background-color: #f8f9fa;
            text-align: center;
            transition: all 0.3s ease;
        }

        .info-section:hover {
            background-color: #fff;
        }

        .info-section h2 {
            font-size: 2.5rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 40px;
            position: relative;
        }

        .info-section h2::after {
            content: "";
            width: 60px;
            height: 4px;
            background-color: #d32f2f;
            display: block;
            margin: 20px auto;
        }

        .info-section .col-md-4 h3 {
            font-size: 1.75rem;
            color: #d32f2f;
            margin-bottom: 20px;
        }

        .info-section .col-md-4 p {
            font-size: 1rem;
            color: #555;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .info-section .col-md-4 {
            transition: transform 0.3s ease;
        }

        .info-section .col-md-4:hover {
            transform: translateY(-10px);
        }

        /* Location Section */
        .location-section {
            position: relative;
            padding: 60px 0;
            background-color: #830000;
            color: #fff;
        }

        .location-section .section-heading {
            margin-bottom: 40px;
            font-size: 2.5rem;
            text-transform: uppercase;
            color: #fff;
        }

        .location-section .section-heading::after {
            content: "";
            width: 60px;
            height: 4px;
            background-color: #d32f2f;
            display: block;
            margin: 20px auto;
        }

        .location-section .map {
            width: 100%;
            height: 350px;
            border: none;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-section h1 {
                font-size: 2rem;
            }

            .hero-section p {
                font-size: 1rem;
            }

            .info-section h2 {
                font-size: 2rem;
            }

            .info-section .col-md-4 h3 {
                font-size: 1.5rem;
            }
        }
        /* Style for the icon image */
.icon-img {
    height: 50px; /* Adjust height as needed */
    width: auto; /* Maintain aspect ratio */
    margin-left: 10px; /* Space between the register button and the icon */
    margin-right:30px;
    margin-top:10px;
}
/* Events Section */
.events-section {
    background: rgba(0, 0, 0, 0.7); /* Semi-transparent background */
    padding: 30px 0; /* Reduced padding */
    color: #fff;
    position: relative;
    height: 600px;
    text-align: center;
}

.events-section h2 {
    font-size: 3rem;
    font-weight: 600;
    color: #fff;
    position: absolute;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 3; /* Ensures it stays above carousel items */
}

.events-section h2::after {
    content: "";
    width: 60px;
    height: 4px;
    background-color: #d32f2f;
    display: block;
    margin: 10px auto;
}

/* Carousel styling with transparency */
.event-carousel .carousel-item img {
    opacity: 0.3; /* Makes images semi-transparent */
    height: 400px; /* Adjust height if needed */
    object-fit: cover;
    width: 100%;
    height: 560px;
}

.event-carousel .carousel-caption h3 {
    font-size: 2rem;
    font-weight: 500;
    color: #fff;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7); /* Ensures text is readable */
    position: relative;
    z-index: 2;
    margin-bottom:30px;
}

.event-carousel .carousel-caption {
    position: absolute;
    bottom: 10%;
    z-index: 2; /* Ensures captions stay above the images */
}

.event-carousel .carousel-caption p {
    font-size: 1.25rem;
    color: #fff;
    text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.7);
}

.carousel-control-prev, .carousel-control-next {
    z-index: 2; /* Keep controls above the images */
}

#event_btn {
    background-color: #bb2d3b;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
    margin-bottom: 100px;
}

    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="images/jlogo.png" alt="Logo" class="logo">
        </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                   
                    
                  
                </ul>
                
            </div>
           
        </div>
        <a  href="chatbot.php">
                            <img src="images/chatbot.png" alt="Icon" class="icon-img">
                        </a>
    </nav>
    <!-- Hero Section -->
    <!-- Hero Section -->
<section class="hero-section">
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="images/cl1.jpg" class="d-block w-100" alt="Image 1">
                <div class="carousel-caption d-none d-md-block">
                    <h1>Welcome to JMCT Polytechnic College ERP System</h1>
                    <p>Efficiently manage college operations with our comprehensive ERP system designed to meet all your academic and administrative needs.</p>
                    <a href="login.php" class="btn btn-danger">Get Started</a>
                </div>
            </div>

            <div class="carousel-item active">
                <img src="images/cl.jpg" class="d-block w-100" alt="Image 1">
                <div class="carousel-caption d-none d-md-block">
                    <h1>Welcome to JMCT Polytechnic College ERP System</h1>
                    <p>Efficiently manage college operations with our comprehensive ERP system designed to meet all your academic and administrative needs.</p>
                    <a href="login.php" class="btn btn-danger">Get Started</a>
                </div>
            </div>
           
            <div class="carousel-item">
                <img src="images/corr1.png" class="d-block w-100" alt="Image 3">
                <div class="carousel-caption d-none d-md-block">
                    <h1>Empowering Minds, Shaping Futures</h1>
                    
                </div>
            </div>
          

            <div class="carousel-item">
                <img src="images/ind5.jpg" class="d-block w-100" alt="Image 3">
                <div class="carousel-caption d-none d-md-block">
                    <h1>Vibrant, expansive, welcoming campus</h1>
                    
                </div>
            </div>
        
        </div>

        
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>


    <!-- Info Section -->
    <section class="info-section">
        <div class="container">
            <h2>About Us</h2>
            <div class="row">
                <div class="col-md-4">
                    <h3>About Us</h3>
                   <p> Located in Nashik, our institute offers a diverse range of diploma programs, distinguished faculty, and vibrant campus community create an enriching learning environment where students can thrive.</p>                </div>
                <div class="col-md-4">
                    <h3>Our Vision</h3>
                    <p>We aim to equip our students with not only academic knowledge but also critical thinking, leadership, and interpersonal skills.</p>
                </div>
                <div class="col-md-4">
                    <h3>Our Mission</h3>
                    <p>To deliver quality education through a rigorous curriculum and practical experience, fostering a culture of excellence and continuous improvement.</p>
                </div>
            </div>
        </div>
    </section>
<!-- Info Section -->
<section class="info-section">
    <!-- Your existing info section content here -->
</section>
<!-- Events Section -->
<section class="events-section">
    <h2>Our Events</h2>
    <div id="eventCarousel" class="carousel slide event-carousel" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="images/eng.jpeg" class="d-block w-100" >
                <div class="carousel-caption d-none d-md-block">
                    <h3>Engineers day</h3>
                    <a href="events.php" class="btn btn-danger" id="event_btn">Browse More</a>
                    
                </div>
            </div>
            <div class="carousel-item">
                <img src="images/t1.jpeg" class="d-block w-100">
                <div class="carousel-caption d-none d-md-block">
                    <h3>Teachers Day</h3>
                    <a href="events.php" class="btn btn-danger" id="event_btn">Browse More</a>
                  
                </div>
            </div>
            <div class="carousel-item">
                <img src="images/freshers.jpeg" class="d-block w-100">
                <div class="carousel-caption d-none d-md-block">
                    <h3>Freshers Party</h3>
                    <a href="events.php" class="btn btn-danger" id="event_btn">Browse More</a>
                   
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#eventCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#eventCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>


    <!-- Location Section -->
    <section class="location-section">
        <div class="container">
            <h2>Our Location</h2>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3749.757318574993!2d73.79058257500164!3d19.976705681422366!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bddeb136735a373%3A0xd82532a4a38ee6b0!2sJMCT%20Campus!5e0!3m2!1sen!2sin!4v1725735571313!5m2!1sen!2sin" width="1200" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>        </div>
    </section>
    
</body>
</html>
