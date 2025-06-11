<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>tripsVision</title>

  <!-- LOCAL CSS (Fix This) -->
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
  <body>
    <header>
      <a href="#" class="logo">trips<span>Vision</span></a>

      <ul class="navbar">
        <li><a href="#">Homew</a></li>
        <li><a href="../planner.php">Plan</a></li>
        <li><a href="#">Destinations</a></li>
        <li><a href="#">Culinary</a></li>
        <li><a href="#">Stay</a></li>
      </ul>

      <div class="h-right">
        <a href="#"><i class="ri-search-line"></i></a>
        <a href="#"><i class="bx bx-user"></i></a>
        <a href="../logout.php">Logout</a>
      </div>
    </header>

    <!-- home section design -->
    <section class="home">
      <div class="home-text">
        <h5>Let's</h5>
        <h1>                          
          Planning your <br />
          own travel
        </h1>
        <p>
          Indonesia, a Southeast Asian Nation made up of thousand of volcanic
          <br />
          islands, is home to hundreds og ethnic groups speaking
        </p>
        <a href="../planner.php" class="btn">Make a plan</a>
        
      </div>
    </section>

    <!-- feature section design -->
    <section class="feature">
      <div class="feature-content">
        <div class="row">
          <div class="row-img">
            <img src="../assets/imagesProperty/danauToba.jpg" alt="Danau Toba" />
          </div>
          <h4>Danau Toba</h4>
                      <!-- Ganti card Danau Toba -->
<div class="row">
  <a href="{{ route('destinations.show', 'danau-toba') }}" class="destination-link">
    <div class="row-img">
      <img src="{{ asset('assets/imagesProperty/danauToba.jpg') }}" alt="Danau Toba" />
    </div>
    <h4>Danau Toba</h4>
  </a>
</div>
        </div>
        <div class="row">
          <div class="row-img">
            <img
              src="../assets/imagesProperty/gunungTangkubanPerahu.jpg"
              alt="gunungTangkubanPerahu"
            />
          </div>
          <h4>Tangkuban Perahu</h4>
        </div>
        <div class="row">
          <div class="row-img">
            <img src="../assets/imagesProperty/danauToba.jpg" alt="Danau Toba" />
          </div>
       <div class="row">
      <a href="./views/destination-detail.blade.php" class="destination-link">
        <div class="row-img">
          <img src="../assets/imagesProperty/danauToba.jpg" alt="Danau Toba" />
        </div>
        <h4>Danau Toba</h4>
      </a>
    </div>
          <h4>Tangkuban Perahu</h4>
        </div>
      </div>
    </section>

      <!-- Holiday Section Design -->
      <section class="holiday">
        <div class="holiday-img">
          <img src="../assets/imagesProperty/danautoba (2).jpg" alt="Danau Toba" />
        </div>
        <div class="holiday-text">
          <h5>East Nusa</h5>
          <h2>Have an enjoyed your holiday</h2>
          <p>
            You will be amazed if you take part in this sailing Komodo Island
            tour package. So it is also mandatory for you, you also have to
            taste the marine tourism. The beautiful waters of Komodo will make
            you meet many travelers from other countries
          </p>
          <a href="#" class="btn">Read More</a>
        </div>
      </section>

      <!-- Tour Section Design -->
      <section class="tour">
        <div class="center-text">
          <h2>Popular Tours</h2>
        </div>

        <div class="tour-content">
          <div class="box">
            <img src="../assets/imagesProperty/cand.jpg" alt="Cand" />
            <h6>East Java</h6>
            <h4>Mount Bromo</h4>
          </div>
          <div class="box">
            <img src="../assets/imagesProperty/cand.jpg" alt="Cand" />
            <h6>East Java</h6>
            <h4>Mount Bromo</h4>
          </div>
          <div class="box">
            <img src="../assets/imagesProperty/cand.jpg" alt="Cand" />
            <h6>East Java</h6>
            <h4>Mount Bromo</h4>
          </div>
          <div class="box">
            <img src="../assets/imagesProperty/cand.jpg" alt="Cand" />
            <h6>East Java</h6>
            <h4>Mount Bromo</h4>
          </div>
        </div>
        <div class="center-btn">
          <a href="#" class="btn">See Tours</a>
        </div>
      </section>

      <!-- Culture Section Design -->
      <section class="Culture">
        <div class="Culture-text">
          <h5>INDONESIA CULTURE</h5>
          <h2>Our Culture here is very friendly to people</h2>
          <p>
            known for his politeness, manners and gentleness. This becomes a
            charateristic when they mingle with other tribes and become basic
            traits that are passed down by their ancestors
          </p>
          <a href="#" class="btn">Read More</a>
        </div>

        <div class="Culture-img">
          <img src="../assets/imagesProperty/danautoba1.jpg" />
        </div>
      </section>

      
      <!-- Footer Section Design-->
      <section class="footer">
        <div class="footer-box">
          <h3>Services</h3>
          <a href="#">Email</a>
          <a href="#">Campaign</a>
          <a href="#">Branings</a>
          <a href="#">Offline</a>
        </div>

        <div class="footer-box">
          <h3>About</h3>
          <a href="#">Our Story</a>
          <a href="#">Benefits</a>
          <a href="#">Teams</a>
          <a href="#">Careers</a>
        </div>

        <div class="footer-box">
          <h3>Help</h3>
          <a href="#">FAQs</a>
          <a href="#">Contact</a>
        </div>

        <div class="footer-box">
          <h3>Social</h3>
          <div class="social">
            <a href="#"><i class="ri-instagram-fill"></i></a>
            <a href="#"><i class="ri-twitter-fill"></i></a>
            <a href="#"><i class="ri-facebook-fill"></i></a>
          </div>
        </div>
      </section>
    </section>

    <script src="../assets/js/mainLayout.js/"></script>
  </body>
</html>