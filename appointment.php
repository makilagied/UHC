<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Booking</title>
    <!-- Include necessary CSS and JavaScript libraries -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <!-- basic -->
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <!-- mobile metas -->
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="viewport" content="initial-scale=1, maximum-scale=1">
   <!-- site metas -->
   <title>smart-Care</title>
   <meta name="keywords" content="">
   <meta name="description" content="">
   <meta name="author" content="">
   <!-- bootstrap css -->
   <link rel="stylesheet" href="css/bootstrap.min.css">
   <!-- style css -->
   <link rel="stylesheet" href="css/style.css">
   <!-- Responsive-->
   <link rel="stylesheet" href="css/responsive.css">
   <!-- fevicon -->
   <link rel="icon" href="images/fevicon.png" type="image/gif" />
   <!-- Scrollbar Custom CSS -->
   <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
   <!-- Tweaks for older IEs-->
   <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
   <!-- owl stylesheets -->
   <link rel="stylesheet" href="css/owl.carousel.min.css">
   <link rel="stylesheet" href="css/owl.theme.default.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
   
   <script defer async>
      document.addEventListener('DOMContentLoaded', function() {
        // setting global variables
        window.botId = 2031
        
        // create div with id = sarufi-chatbox
        const div = document.createElement("div")
        div.id = "sarufi-chatbox"
        document.body.appendChild(div)
    
        // create and attach script tag
        const script = document.createElement("script")
        script.crossOrigin = true
        script.type = "module"
        script.src = "https://cdn.jsdelivr.net/gh/flexcodelabs/sarufi-chatbox/example/vanilla-js/script.js"
        document.head.appendChild(script)
    
        // create and attach css
        const style = document.createElement("link")
        style.crossOrigin = true
        style.rel = "stylesheet"
        style.href = "https://cdn.jsdelivr.net/gh/flexcodelabs/sarufi-chatbox/example/vanilla-js/style.css"
        document.head.appendChild(style)
      });
    </script>
</head>
<body>
    <!-- header section start -->
    <div class="">
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
         <!-- <div class="logo"><a href="index.html"><img src="images/logo.png"></a></div> -->
         <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
               <li class="nav-item active">
                  <a class="nav-link" href="index.html">Home</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="about.html">About</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="service.html">Service</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="location.html">Location</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="#"><img src="images/search-icon.png"></a>
               </li>
            </ul>
         </div>
      </nav>
  
<div class="container">
    <h1>Book an Appointment</h1>
    <form id="appointmentForm" action="backend/appointmentForm.php" method="post">
        <div class="row">
            <!-- Column 1: Full Name and Phone Number -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="patient_name">Full Name:</label>
                    <input type="text" class="form-control" id="patient_name" name="patient_name" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="phone">Phone Number:</label>
                    <input type="tel" class="form-control" id="phone" name="phone" required>
                </div>
            </div>

            <!-- Column 2: Email and Health Insurance -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="health_insurance">Health Insurance Provider:</label>
                    <select class="form-control" id="health_insurance" name="health_insurance" required>
                        <option value="Insurance">Health insurance</option>
                        <option value="NHIF">NHIF</option>
                        <option value="Jubilee">Jubilee</option>
                        <!-- Add more insurance options as needed -->
                    </select>
                </div>
            </div>

            <!-- Column 3: Health Status and Location -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="health_status">Health Status:</label>
                    <input type="text" class="form-control" id="health_status" name="health_status">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="location">Location:</label>
                    <input type="text" class="form-control" id="location" name="location" readonly>
                </div>
            </div>

            <!-- Column 4: Appointment Date, Doctor Specialty, and Time Slot -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="appointment_date">Select Date:</label>
                    <input type="date" class="form-control" id="appointment_date" name="appointment_date" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="doctor_specialty">Select Doctor Specialty:</label>
                    <select class="form-control" id="doctor_specialty" name="doctor_specialty" required>
                        <option value="">Select a Doctor Specialty</option>
                        <!-- Options will be populated dynamically using JavaScript -->
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="selected_time_slot">Select Time Slot:</label>
                    <select class="form-control" id="selected_time_slot" name="selected_time_slot" required>
                        <option value="">Select a Time Slot</option>
                        <!-- Options will be populated dynamically using JavaScript -->
                    </select>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Book Appointment</button>
    </form>
</div>



   <!-- footer section start -->
   <div class="footer_section layout_padding">
      <div class="container">
         <div class="row">
            <div class="col-lg-3 col-sm-6">
               <div class="footer_logo"><a href="index.html"><img src="images/logo.png"></a></div>
               <h1 class="adderss_text">Contact Us</h1>
               <div class="map_icon"><img src="images/map-icon.png"><span class="paddlin_left_0">Page when looking at its</span></div>
               <div class="map_icon"><img src="images/call-icon.png"><span class="paddlin_left_0">+2556656566</span></div>
               <div class="map_icon"><img src="images/mail-icon.png"><span class="paddlin_left_0">udsmhospital@gmail.com</span></div>
            </div>
            <!--<div class="col-lg-3 col-sm-6">
               <h1 class="adderss_text">Doctors</h1>
               <div class="hiphop_text_1">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour,</div>
            </div> -->
            <div class="col-lg-3 col-sm-6">
               <h1 class="adderss_text">Useful Links</h1>
               <div class="Useful_text">udsmhospital@gmail.com</div>
            </div>
           <!--<div class="col-lg-3 col-sm-6">
               <h1 class="adderss_text">Newsletter</h1>
               <input type="text" class="Enter_text" placeholder="Enter your Email" name="Enter your Email">
               <div class="subscribe_bt"><a href="#">Subscribe</a></div> -->
               <div class="social_icon">
                  <ul>
                     <li><a href="#"><img src="images/fb-icon.png"></a></li>
                     <li><a href="#"><img src="images/twitter-icon.png"></a></li>
                     <li><a href="#"><img src="images/linkedin-icon.png"></a></li>
                     <li><a href="#"><img src="images/instagram-icon.png"></a></li>
                  </ul>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- footer section end -->
   <!-- copyright section start -->
   <div class="copyright_section">
      <div class="container">
         <p class="copyright_text">2019 All Rights Reserved. Design by <a href="https://html.design">Free html Templates</a></p>
      </div>
   </div>
<!-- JavaScript code to dynamically load doctor specialties and time slots -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const doctorSpecialtySelect = document.getElementById("doctor_specialty");
        const timeSlotSelect = document.getElementById("selected_time_slot");
        const appointmentDateInput = document.getElementById("appointment_date");
        const locationInput = document.getElementById("location");

        // Function to load doctor specialties
        function loadDoctorSpecialties() {
            $.ajax({
                type: "GET",
                url: "backend/getDoctorSpecialties.php",
                dataType: "json",
                success: function (data) {
                    // Clear existing options
                    doctorSpecialtySelect.innerHTML = "<option value=''>Select a Doctor Specialty</option>";

                    // Populate 'doctorSpecialtySelect' with fetched data
                    data.specialties.forEach(specialty => {
                        const option = document.createElement("option");
                        option.value = specialty;
                        option.textContent = specialty;
                        doctorSpecialtySelect.appendChild(option);
                    });

                    // Trigger the change event to load time slots based on the initial date
                    doctorSpecialtySelect.dispatchEvent(new Event("change"));
                },
                error: function (xhr, status, error) {
                    console.error("An error occurred:", error);
                }
            });
        }

        // Function to load time slots based on selected date and specialty
        function loadTimeSlots() {
            const selectedSpecialty = doctorSpecialtySelect.value;
            const selectedDate = appointmentDateInput.value;

            // Check if both specialty and date are selected
            if (selectedSpecialty && selectedDate) {
                $.ajax({
                    type: "GET",
                    url: "backend/getTimeSlots.php",
                    data: {
                        specialty: selectedSpecialty,
                        date: selectedDate
                    },
                    dataType: "json",
                    success: function (data) {
                        // Clear existing options
                        timeSlotSelect.innerHTML = "<option value=''>Select a Time Slot</option>";

                        // Populate 'timeSlotSelect' with fetched data
                        data.timeSlots.forEach(slot => {
                            const option = document.createElement("option");
                            option.value = slot;
                            option.textContent = slot;
                            timeSlotSelect.appendChild(option);
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error("An error occurred:", error);
                    }
                });
            } else {
                // Clear the 'selected_time_slot' dropdown if specialty or date is not selected
                timeSlotSelect.innerHTML = "<option value=''>Select a Time Slot</option>";
            }
        }

        // Function to get the user's location
        function getUserLocation() {
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;

                    // Populate the 'locationInput' with the user's coordinates
                    locationInput.value = `Latitude: ${latitude}, Longitude: ${longitude}`;
                }, function (error) {
                    console.error("Error getting user location:", error);
                });
            } else {
                console.error("Geolocation is not available in this browser.");
            }
        }

        // Attach change event listener to the doctor specialty dropdown
        doctorSpecialtySelect.addEventListener("change", function () {
            // Load time slots based on the selected specialty
            loadTimeSlots();
        });

        // Attach change event listener to the appointment date input
        appointmentDateInput.addEventListener("change", function () {
            // Load time slots based on the selected date
            loadTimeSlots();
        });

        // Load doctor specialties when the page loads
        loadDoctorSpecialties();

        // Get the user's location
        getUserLocation();
    });
</script>

</body>
</html>
