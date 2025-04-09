<?php
// Start session for user authentication
session_start();



// Define room types with their properties
$roomTypes = [
    'Dua Lipa' => [
        'price' => 100,
        'features' => ['Fast entry', 'Free first drink'],
        'description' => '25.08.2025',
        'images' => [
            'img/dualipa_1.jpeg',
            'img/dualipa_2.jpeg'
        ]
    ],
    'Harry Styles' => [
        'price' => 120,
        'features' => ['Queen Bed', 'Ocean View'],
        'description' => '08.07.2023',
        'images' => [
            'img/harrystyles_1.png',
            'img/harrystyles_2.jpeg'
        ]
    ],
    'Mozart Orchestra' => [
        'price' => 215,
        'features' => ['Seat in the front rows'],
        'description' => '01.01.2026',
        'images' => [
            'img/mozart_1.jpeg',
            'img/mozart_2.jpeg'
        ]
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags and CSS imports -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/hotel.ico">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <title>Book an Event</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="./style.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Room card and layout styles */
        .room-grid {
            padding: 2rem;
        }
        .room-card {
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .room-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }
        .room-image {
            height: 300px;
            width: 100%;
            object-fit: cover;
        }
        .room-features {
            list-style: none;
            padding: 0;
        }
        .room-features li {
            padding: 0.5rem 0;
            color: #666;
        }
        .room-price {
            font-size: 2rem;
            color: #2c3e50;
            font-weight: bold;
            margin: 1rem 0;
        }
        .carousel-inner {
            border-radius: 15px 15px 0 0;
        }
    </style>
</head>
<body>
    <?php include 'inc/navbar.php'; ?>

    <main>
        <!-- Room display grid -->
        <div class="container room-grid">
            <h2 class="text-center mb-5">Pick an event</h2>
            <div class="row">
                <!-- Room cards loop -->
                <?php foreach ($roomTypes as $type => $details): ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="room-card">
                            <div id="carousel-<?php echo str_replace(' ', '-', strtolower($type)); ?>" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <?php foreach ($details['images'] as $index => $image): ?>
                                        <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                            <img src="<?php echo $image; ?>" class="room-image" alt="<?php echo $type; ?>">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carousel-<?php echo str_replace(' ', '-', strtolower($type)); ?>" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carousel-<?php echo str_replace(' ', '-', strtolower($type)); ?>" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                            <div class="card-body p-4">
                                <h3 class="mb-3"><?php echo $type; ?></h3>
                                <p class="text-muted"><?php echo $details['description']; ?></p>
                                <div class="room-price">
                                    $<?php echo $details['price']; ?> <small class="text" style = "color: #3a3232">per person</small>
                                </div>
                                <ul class="room-features">
                                    <?php foreach ($details['features'] as $feature): ?>
                                        <li><i class="fas fa-check text-success me-2"></i><?php echo $feature; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                                <button class="btn btn-primary w-100 py-3" 
                                        style="background-color: #3a3232; color: white;" 
                                        onclick="showBookingForm('<?php echo $type; ?>', <?php echo $details['price']; ?>)">
                                    Book Now
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>  

            <!-- Booking form -->
            <div id="bookingForm" class="mt-5" style="display: none; width: 70%; margin: 0 auto;" >
                <div class="card">
                    <div class="card-header">
                        <h3>Complete Your Booking</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="bookingsHistory.php" id="bookingFormSubmit">
                            <input type="hidden" id="selectedRoom" name="roomType">
                            <input type="hidden" id="pricePerNight" name="pricePerNight">
                            <input type="hidden" id="finalTotal" name="finalTotal">
                            <input type="hidden" id="checkInDate1" name="checkInDate">
                            <input type="hidden" id="checkOutDate1" name="checkOutDate">

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="checkInDate" class="form-label">Check-in Date</label>
                                    <input type="date" class="form-control" id="checkInDate" name="checkInDate" 
                                           required min="<?php echo date('Y-m-d'); ?>" 
                                           onchange="updateTotal()"
                                           >
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="checkOutDate" class="form-label">Check-out Date</label>
                                    <input type="date" class="form-control" id="checkOutDate" name="checkOutDate" 
                                           required min="<?php echo date('Y-m-d'); ?>" onchange="updateTotal()">
                                </div>
                            </div>

                            <div class="card mb-3">
                                <div class="card-header">
                                    <h5>Additional Services</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="breakfast" name="services[]" value="breakfast" onchange="updateTotal()">
                                        <label class="form-check-label" for="breakfast">Breakfast ($15 per night)</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="parking" name="services[]" value="parking" onchange="updateTotal()">
                                        <label class="form-check-label" for="parking">Parking ($10 per night)</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="pets" name="services[]" value="pets" onchange="updateTotal()">
                                        <label class="form-check-label" for="pets">Pet Accommodation ($25 per stay)</label>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5>Booking Summary</h5>
                                    <p>Room: <span id="selectedRoomType"></span></p>
                                    <p>Number of nights: <span id="totalNights">0</span></p>
                                    <p>Room Total: $<span id="roomTotal">0</span></p>
                                    <p>Services Total: $<span id="servicesTotal">0</span></p>
                                    <hr>
                                    <p class="h4">Final Total: $<span id="finalTotalValue">0</span></p>
                                </div>
                            </div>

                            <div id="availabilityMessage"></div>
                            <button type="submit" class="btn btn-primary w-100" id="submitBooking" style="background-color: #3a3232;"> Continue Booking </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include 'inc/footer.php'; ?>

    <script>
    // Define service prices
    const SERVICES_PRICES = {
        breakfast: 15,
        parking: 10,
        pets: 25
    };

    // Show booking form when room is selected
    function showBookingForm(roomType, price) {
        document.getElementById('selectedRoom').value = roomType;
        document.getElementById('pricePerNight').value = price;
        const bookingForm = document.getElementById('bookingForm');
        bookingForm.style.display = 'block';
        bookingForm.scrollIntoView({ behavior: 'smooth' });
        document.querySelector('.card-header h3').textContent = 'Complete Your Booking - ' + roomType;
        
        // Initialize date inputs with event listeners
        initializeDateListeners();
    }

    function initializeDateListeners() {
        const checkInInput = document.getElementById('checkInDate');
        const checkOutInput = document.getElementById('checkOutDate');
        
        checkInInput.addEventListener('change', function() {
            console.log('Check-in date changed:', this.value);
            // Set minimum check-out date to check-in date
            checkOutInput.min = this.value;
            
            // Clear check-out date if it's before check-in date
            if (checkOutInput.value && checkOutInput.value < this.value) {
                checkOutInput.value = '';
                alert('Check-out date cannot be earlier than check-in date');
            } else if (checkOutInput.value) {
                updateTotal();
            }
        });
        
        checkOutInput.addEventListener('change', function() {
            console.log('Check-out date changed:', this.value);
            if (this.value < checkInInput.value) {
                this.value = '';
                alert('Check-out date cannot be earlier than check-in date');
            } else if (checkInInput.value) {
                updateTotal();
            }
        });
    }

    function updateTotal() {
        const checkIn = new Date(document.getElementById('checkInDate').value);
        const checkOut = new Date(document.getElementById('checkOutDate').value);
        const pricePerNight = parseFloat(document.getElementById('pricePerNight').value);

        if (checkOut < checkIn) {
            alert('Check-out date cannot be earlier than check-in date');
            document.getElementById('checkOutDate').value = '';
            return;
        }

        console.log('Calculating total with:', {
            checkIn: checkIn,
            checkOut: checkOut,
            pricePerNight: pricePerNight
        });

        if (checkIn && checkOut && !isNaN(pricePerNight)) {
            const nights = Math.ceil((checkOut - checkIn) / (1000 * 60 * 60 * 24));
            const roomTotal = nights * pricePerNight;

            let servicesTotal = 0;
            for (const [service, price] of Object.entries(SERVICES_PRICES)) {
                if (document.getElementById(service).checked) {
                    servicesTotal += service === 'pets' ? price : price * nights;
                }
            }

            const finalTotal = roomTotal + servicesTotal;

            // Update UI elements
            document.getElementById('totalNights').textContent = nights;
            document.getElementById('roomTotal').textContent = roomTotal.toFixed(2);
            document.getElementById('servicesTotal').textContent = servicesTotal.toFixed(2);
            document.getElementById('finalTotalValue').textContent = finalTotal.toFixed(2);
            document.getElementById('finalTotal').value = finalTotal.toFixed(2);
            
            console.log('Updated totals:', {
                nights: nights,
                roomTotal: roomTotal,
                servicesTotal: servicesTotal,
                finalTotal: finalTotal
            });
        }
    }

    // Initialize listeners when DOM is loaded
    document.addEventListener('DOMContentLoaded', initializeDateListeners);
    </script>
</body>
</html>
