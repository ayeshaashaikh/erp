<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Gallery</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>

        /* General styling */
body {
    font-family: 'Roboto', sans-serif;
    background-color: #f4f4f4;
    color: #333;
}

.header {
    background-color: #b81f18;
    color: white;
    padding: 20px;
    text-align: center;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.events-gallery {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
}

.event-card {
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.event-card:hover {
    transform: translateY(-5px);
}

.event-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.event-details {
    padding: 20px;
}

.event-details h2 {
    margin-bottom: 10px;
    font-size: 1.5rem;
    color: #b81f18;
}

.btn {
    padding: 10px 20px;
    background-color: #b81f18;
    color: white;
    text-decoration: none;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.btn:hover {
    background-color: #b81f18;
}

/* Modal styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    padding-top: 60px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.9);
}

.modal-content {
    position: relative;
    margin: auto;
    padding: 20px;
    max-width: 80%;
    text-align: center;
}

.gallery-images img {
    width: 100%;
    max-height: 500px;
    object-fit: contain;
    display: none;
}

.close {
    position: absolute;
    top: 10px;
    right: 25px;
    color: white;
    font-size: 35px;
    font-weight: bold;
    cursor: pointer;
}

.close:hover {
    color: #bbb;
}

.prev, .next {
    cursor: pointer;
    position: absolute;
    top: 50%;
    width: auto;
    margin-top: -22px;
    padding: 16px;
    color: white;
    font-weight: bold;
    font-size: 20px;
    transition: 0.3s;
    border-radius: 0 3px 3px 0;
    user-select: none;
}

.prev {
    left: 0;
}

.next {
    right: 0;
}

.prev:hover, .next:hover {
    background-color: rgba(0,0,0,0.8);
}

    </style>
</head>
<body>
    <header class="header">
        <h1>Our Events</h1>
    </header>

    <main class="container">
        <section class="events-gallery">
            <div class="event-card">
                <img src="images/eng6.jpeg" alt="Event 1" class="event-image">
                <div class="event-details">
                    <h2>Engineers day</h2>
                    <p>A brief description of the event.</p>
                    <button class="btn view-more-btn" data-event="1">View More</button>
                </div>
            </div>

            <div class="event-card">
                <img src="images/t6.jpeg" alt="Event 2" class="event-image">
                <div class="event-details">
                    <h2>Teachers Day</h2>
                    <p>A brief description of the event.</p>
                    <button class="btn view-more-btn" data-event="2">View More</button>
                </div>
            </div>

            <div class="event-card">
                <img src="images/f1.jpeg" alt="Event 3" class="event-image">
                <div class="event-details">
                    <h2>Freshers Party</h2>
                    <p>A brief description of the event.</p>
                    <button class="btn view-more-btn" data-event="3">View More</button>
                </div>
            </div>

            <div class="event-card">
                <img src="images/in4.jpg" alt="Event 3" class="event-image">
                <div class="event-details">
                    <h2>Independence Day</h2>
                    <p>A brief description of the event.</p>
                    <button class="btn view-more-btn" data-event="4">View More</button>
                </div>
            </div>

            <div class="event-card">
                <img src="images/swc.jpeg" alt="Event 3" class="event-image">
                <div class="event-details">
                    <h2>Swachhta Hi Sewa</h2>
                    <p>A brief description of the event.</p>
                    <button class="btn view-more-btn" data-event="5">View More</button>
                </div>
            </div>

            <div class="event-card">
                <img src="images/sinc.jpeg" alt="Event 3" class="event-image">
                <div class="event-details">
                    <h2>Senior Citizen day</h2>
                    <p>A brief description of the event.</p>
                    <button class="btn view-more-btn" data-event="6">View More</button>
                </div>
            </div>

            <div class="event-card">
                <img src="images/trc.jpeg" alt="Event 3" class="event-image">
                <div class="event-details">
                    <h2>Tree Plantation</h2>
                    <p>A brief description of the event.</p>
                    <button class="btn view-more-btn" data-event="7">View More</button>
                </div>
            </div>

            <div class="event-card">
                <img src="images/skc.jpeg" alt="Event 3" class="event-image">
                <div class="event-details">
                    <h2>Soft Skill Development</h2>
                    <p>A brief description of the event.</p>
                    <button class="btn view-more-btn" data-event="8">View More</button>
                </div>
            </div>

            <div class="event-card">
                <img src="images/cl.jpg" alt="Event 3" class="event-image">
                <div class="event-details">
                    <h2>Our Campus</h2>
                    <p>A brief description of the event.</p>
                    <button class="btn view-more-btn" data-event="9">View More</button>
                </div>
            </div>

        </section>
    </main>

   

    <!-- Modal for Image Gallery -->
    <div id="imageModal" class="modal">
        <span class="close">&times;</span>
        <div class="modal-content">
            <div class="gallery-images" id="gallery-images">
                <!-- Images for the gallery will be inserted here dynamically -->
            </div>
            <button class="prev" onclick="plusSlides(-1)">&#10094;</button>
            <button class="next" onclick="plusSlides(1)">&#10095;</button>
        </div>
    </div>

    <script>
        // Modal functionality for image gallery
let modal = document.getElementById("imageModal");
let galleryImages = document.getElementById("gallery-images");
let slideIndex = 0;
let imagesArray = {
    1: ["images/eng2.jpeg", "images/eng4.jpeg", "images/enga.jpeg","images/engb.jpeg","images/engc.jpeg","images/engd.jpeg","images/enn.jpeg"],
    2: ["images/t1.jpeg", "images/t2.jpeg", "images/t3.jpeg","images/t4.jpeg","images/t5.jpeg","images/t7.jpeg","images/t8.jpeg",],
    3: ["images/f2.jpeg", "images/f3.jpeg", "images/f4.jpeg"],
    4: ["images/in1.jpg", "images/in2.jpg", "images/in3.jpg", "images/in5.jpg"],
    5: ["images/sw1.jpeg", "images/sw2.jpeg"],
    6: ["images/sin1.jpeg", "images/sin2.jpeg"],
    7: ["images/tr1.jpeg", "images/tr2.jpeg","images/tr3.jpeg","images/tr4.jpeg"],
    8: ["images/sk1.jpeg", "images/sk2.jpeg","images/sk3.jpeg","images/sk4.jpeg"],
    9: ["images/cl1.jpg", "images/cl2.jpg","images/cl3.jpg","images/cl4.jpg"]


};

// Open the modal with images
document.querySelectorAll('.view-more-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const eventId = this.getAttribute("data-event");
        openModal(imagesArray[eventId]);
    });
});

// Open modal and display the gallery
function openModal(images) {
    galleryImages.innerHTML = "";
    images.forEach((image, index) => {
        galleryImages.innerHTML += `<img src="${image}" class="gallery-image" style="display:${index === 0 ? 'block' : 'none'}">`;
    });
    slideIndex = 0;
    modal.style.display = "block";
}

// Close the modal
document.querySelector(".close").addEventListener("click", function() {
    modal.style.display = "none";
});

// Navigate through slides
function plusSlides(n) {
    let slides = document.querySelectorAll(".gallery-image");
    slides[slideIndex].style.display = "none";
    slideIndex = (slideIndex + n + slides.length) % slides.length;
    slides[slideIndex].style.display = "block";
}

// Close modal if clicked outside of the content
window.onclick = function(event) {
    if (event.target === modal) {
        modal.style.display = "none";
    }
}

    </script>
</body>
</html>
