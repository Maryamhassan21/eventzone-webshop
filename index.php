<?php
session_start();

?>

<!DOCTYPE html>
<?php include 'inc/head.php'; ?>
<html lang="en">
    <head>
        <style>
            .carousel-item img {
                width: 100%;
                height: 500px; /* Set a fixed height */
                object-fit: cover; /* Maintain aspect ratio */
            }
        </style>
    </head>
    
    <body>
    <!--navvar -->
    <?php include 'inc/navbar.php'; ?>


    <main>
        <!-- our hotel intro -->
        <section class ="description">
            <h2 class="text-center">Welcome to EVENTZONE</h2>
            <p class="text-center">Every Event you can imagen!</p>
            <p class="text-center"></p>
        </section>

        <!-- Slider Carousel -->
        <section id="resort-slider">
            <div id="hotelCarousel" class="carousel slide mx-auto" style="max-width: 80%; border-radius: 15px; overflow: hidden;" data-bs-ride="carousel" data-bs-interval="30000">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="img/Classic_2.jpg" class="d-block w-100" alt="Classical Concert">
                    </div>
                    <div class="carousel-item">
                        <img src="img/Classic_1.jpg" class="d-block w-100" alt="Classical Concert">
                    </div>
                    <div class="carousel-item">
                        <img src="img/Concert_1.jpg" class="d-block w-100" alt="Pop Concert">
                    </div>
                    <div class="carousel-item">
                        <img src="img/Concert_2.jpg" class="d-block w-100" alt="Hiphop Concert">
                    </div>
                    <div class="carousel-item">
                        <img src="img/Podcast.jpg" class="d-block w-100" alt="Podcast">
                    </div>
                </div>
                <!-- Buttons -->    
                <button class="carousel-control-prev" type="button" data-bs-target="#hotelCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#hotelCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </section>

        <!-- more -->
        <div class="offer-section">
            <section id="offers">
                <h2>What We Offer</h2>
                <ul>
                    <li>Tickets for the hottest pop concerts, classical performances, and live podcasts</li>
                    <li>Access to local and international events — all in one place</li>
                    <li>A wide variety of genres and shows to suit every taste</li>
                    <li>Easy and secure booking with digital tickets</li>
                    <li>24/7 customer support to help you with all your ticketing needs</li>
                </ul>

            </section>
        </div>

        <!-- Footer -->
        <?php include 'inc/footer.php'; ?>

    </body>
</html>