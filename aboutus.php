<?php
    $menu="aboutus";
    include "header.php"; 
?>

    <div class="hb30" style="width:100%;text-align:center;margin-top:20px">About us</div>
    <div class="container_horizon" style="width:70%; background:lightgray; margin-top:20px; margin-left:auto;margin-right:auto;">
        
        <div class="container_vertical" style="width:55%">
            <div class="h20" style="margin-bottom:10px;"><strong>Name:</strong> Uy Vo</div>
            <div class="h20" style="margin-bottom:10px;"><strong>Email:</strong> uyvo@csu.fullerton.edu</div>
            <div class="h20" style="margin-bottom:10px;"><strong>College Level:</strong> senior student at California State University Fullerton.</div>
            <div class="h20" style="margin-bottom:10px;"><strong>Major: </strong>Computer Science</div>
            <div class="h20" style="margin-bottom:10px;"><strong>Department: </strong>ECS</div>
            <div class="h20" style="margin-bottom:10px;"><strong>College: </strong>CSUF</div>
            <div class="h20" style="margin-bottom:10px;"><strong>Personal background: </strong> Dedicated and passionate senior student working toward a BS on May 2024 in computer science at the California State University of Fullerton.</div>
            <div class="h20" style="margin-bottom:10px;"><strong>Hobbies and favorite food or books:</strong> watching movie, playing tennis, reading book. The most favorite book is The Journey to the East by Hermann Hesse and Hilda Hesse, Herman; Rosner.</div>
            <div class="h20" style="margin-bottom:10px;"><strong>Research Interest:</strong> AI and Business</div>
            
        </div>
        <div class="slideshow-container" style="width:40%;">

            <div class="mySlides fade">
            <div class="numbertext">1 / 4</div>
            <img src="images/Dalat-Vietnam3.jpg" style="width:100%">
            <div class="text">Dalat Vietnam</div>
            </div>

            <div class="mySlides fade">
            <div class="numbertext">2 / 4</div>
            <img src="images/Dalat-Vietnam1.jpg" style="width:100%">
            <div class="text">Dalat Vietnam</div>
            </div>

            <div class="mySlides fade">
            <div class="numbertext">3 / 4</div>
            <img src="images/Dalat-Vietnam2.jpg" style="width:100%">
            <div class="text">Dalat Vietnam</div>
            </div>

            <div class="mySlides fade">
            <div class="numbertext">4 / 4</div>
            <img src="images/Dalat-Vietnam4.jpg" style="width:100%">
            <div class="text">Dalat Vietnam</div>
            </div>
            <br>
            <br>
            <br>
            <div style="text-align:center">
            <span class="dot"></span> 
            <span class="dot"></span> 
            <span class="dot"></span>
            <span class="dot"></span> 
            </div>

        </div>
    </div>
<?php
    include "footer.php";
?>
<style>

.mySlides {display: none;}
img {vertical-align: middle;}

/* Slideshow container */
.slideshow-container {
  max-width: 1000px;
  position: relative;
  margin: auto;
}

/* Caption text */
.text {
  color: darkred;
  font-size: 15px;
  padding: 8px 12px;
  position: absolute;
  bottom: 8px;
  width: 100%;
  text-align: center;
  margin-bottom: 10px;
}

/* Number text (1/3 etc) */
.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

/* The dots/bullets/indicators */
.dot {
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
  transition: background-color 0.6s ease;
}

.active {
  background-color: #717171;
}

/* Fading animation */
.fade {
  animation-name: fade;
  animation-duration: 1.5s;
}

@keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
}

/* On smaller screens, decrease text size */
@media only screen and (max-width: 300px) {
  .text {font-size: 11px}
}
</style>


<script>
let slideIndex = 0;
showSlides();

function showSlides() {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  let dots = document.getElementsByClassName("dot");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";  
  }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}    
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " active";
  setTimeout(showSlides, 4000); // Change image every 2 seconds
}
</script>
