<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/2655a12a43.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" type="text/css" href="../css/about2.css">
</head>
<body>
  <!-- Header Section -->
  <?php
include('../header&footer/header.php');
?>



  <!-- Main Body Section -->
  <main class="body-content">
    <div class="about-section" id="about-section">
      <h1>About Us </h1>
      <p id="AboutUsParagraph">Welcome to Elite Strike! Book futsal courts easily and quickly. Join us for a seamless futsal experience. Celebrate the game with us!</p>
    </div>

    <div class="cards">
      <div class="container">
        <img id="myImg1" src="../img/nepali1.jpeg"  width="200" height="200">
        <div class="Text1">
          <h2>michel Ross</h2>
          <p class="title">owner</p>

        </div>
      </div>

      <div class="container">
        <img id="myImg2" src="../img/neapli2.jpeg"  width="200" height="200">
        <div class="Text2">
          <h2>Tharusha Sandeepa</h2>
          <p class="title">manager</p>
        </div>
      </div>
    </div>

    <!-- The Modals -->
    <div id="myModal1" class="modal">
      <span class="close1">&times;</span>
      <img class="modal-content" id="img01" alt="Anjana" src="../img/1st.jpg">
      <div id="caption1"></div>
    </div>

    <div id="myModal2" class="modal">
      <span class="close2">&times;</span>
      <img class="modal-content" id="img02" alt="Tharusha" src="../img/2nd.jpg">
      <div id="caption2"></div>
    </div>
  </main>

  <!-- Footer Section -->
  <footer class="footer">
  <?php
include('../header&footer/footer.php');
?>
  </footer>

  <script>
var modal1 = document.getElementById('myModal1');
var modal2 = document.getElementById('myModal2');
var modal3 = document.getElementById('myModal3');
var modal4 = document.getElementById('myModal4');


// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = document.getElementById('myImg1');
var modalImg = document.getElementById("img01");
var captionText1 = document.getElementById("caption1");
img.onclick = function(){
  modal1.style.display = "block";
  modalImg.src = this.src;
  captionText1.innerHTML = this.alt;
}


var img = document.getElementById('myImg2');
var modalImg = document.getElementById("img02");
var captionText2 = document.getElementById("caption2");
img.onclick = function(){
  modal2.style.display = "block";
  modalImg.src = this.src;
  captionText2.innerHTML = this.alt;
}


var img = document.getElementById('myImg3');
var modalImg = document.getElementById("img03");
var captionText3 = document.getElementById("caption3");
img.onclick = function(){
  modal3.style.display = "block";
  modalImg.src = this.src;
  captionText3.innerHTML = this.alt;
}


var img = document.getElementById('myImg4');
var modalImg = document.getElementById("img04");
var captionText4 = document.getElementById("caption4");
img.onclick = function(){
  modal4.style.display = "block";
  modalImg.src = this.src;
  captionText4.innerHTML = this.alt;
}

// Get the <span> element that closes the modal
var span1 = document.getElementsByClassName("close1")[0];
var span2 = document.getElementsByClassName("close2")[0];
var span3 = document.getElementsByClassName("close3")[0];
var span4 = document.getElementsByClassName("close4")[0];


// When the user clicks on <span> (x), close the modal
span1.onclick = function() { 
  modal1.style.display = "none";
}
span2.onclick = function() { 
  modal2.style.display = "none";
}
span3.onclick = function() { 
  modal3.style.display = "none";
}
span4.onclick = function() { 
  modal4.style.display = "none";
}
//Window when scrolling
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if ( document.documentElement.scrollTop > 10) {
    document.getElementById("Top").style.transition= "background-color ease-in-out 0.5s";
    document.getElementById("Top").style.backgroundColor = "rgba(90, 166, 144)";
  } else {
    document.getElementById("Top").style.backgroundColor = "rgba(108, 109, 109, 0.555)";
  }
}

//dark mode light mode
const LightMode=document.querySelector('#Light');
const AboutUs=document.querySelector('#about-section');
LightMode.addEventListener('click',()=>{
document.body.style.backgroundColor="white";
AboutUs.style.color="#444";

})
const DarkMode=document.querySelector('#Dark');
DarkMode.addEventListener('click',()=>{
  document.body.style.backgroundColor="#444";
AboutUs.style.color="white";

  })
  </script>
</body>
</html>