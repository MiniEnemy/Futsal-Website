<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Futsal Website</title>
  <link rel="stylesheet" href="../css/index.css">
</head>
<body>
  <?php include('../header&footer/header.php'); ?>
  <div id="big-box">
    <img src="../allpics/first-bar.png" class="goal">
    <div class="box">
      <div class="line"></div>
      <div class="text">WELCOME TO</div>
      <div class="line"></div>
    </div>
  </div>
  <div id="container">
    <div id="slider-container">
      <span onclick="slideRight()" class="btn"></span>
      <div id="slider">
        <div class="slide"><img src="../mainimg/main1.jpg" alt=""></div>
        <div class="slide"><img src="../img/slider/2.png" alt=""></div>
        <div class="slide"><img src="../img/slider/3.png" alt=""></div>
        <div class="slide"><img src="../img/slider/4.png" alt=""></div>
        <div class="slide"><img src="../img/slider/5.png" alt=""></div>
        <div class="slide"><img src="../img/slider/6.png" alt=""></div>
        <div class="slide"><img src="../img/slider/7.png" alt=""></div>
      </div>
      <span onclick="slideLeft()" class="btn"></span>
    </div>
  </div>
  <div class="second-bar">
    <a href="../form/login.php" class="book">
      <div>
        <p>Click to Book</p>
      </div>
    </a>
    <img src="../allpics/second-bar.png" class="goal2">
  </div>
  <?php include('../header&footer/footer.php'); ?>
  <script>
    var container = document.getElementById('container');
    var slider = document.getElementById('slider');
    var slides = document.getElementsByClassName('slide').length;
    var buttons = document.getElementsByClassName('btn');
    var currentPosition = 0;
    var currentMargin = 0;
    var slidesPerPage = 0;
    var slidesCount = slides - slidesPerPage;
    var containerWidth = container.offsetWidth;

    window.addEventListener("resize", checkWidth);

    function checkWidth() {
      containerWidth = container.offsetWidth;
      setParams(containerWidth);
    }

    function setParams(w) {
      if (w < 551) {
        slidesPerPage = 1;
      } else if (w < 901) {
        slidesPerPage = 2;
      } else if (w < 1101) {
        slidesPerPage = 3;
      } else {
        slidesPerPage = 4;
      }
      slidesCount = slides - slidesPerPage;
      if (currentPosition > slidesCount) {
        currentPosition -= slidesPerPage;
      }
      currentMargin = - currentPosition * (100 / slidesPerPage);
      slider.style.marginLeft = currentMargin + '%';
      if (currentPosition > 0) {
        buttons[0].classList.remove('inactive');
      }
      if (currentPosition < slidesCount) {
        buttons[1].classList.remove('inactive');
      }
      if (currentPosition >= slidesCount) {
        buttons[1].classList.add('inactive');
      }
    }

    setParams();

    function slideRight() {
      if (currentPosition != 0) {
        slider.style.marginLeft = currentMargin + (100 / slidesPerPage) + '%';
        currentMargin += (100 / slidesPerPage);
        currentPosition--;
      }
      if (currentPosition === 0) {
        buttons[0].classList.add('inactive');
      }
      if (currentPosition < slidesCount) {
        buttons[1].classList.remove('inactive');
      }
    }

    function slideLeft() {
      if (currentPosition != slidesCount) {
        slider.style.marginLeft = currentMargin - (100 / slidesPerPage) + '%';
        currentMargin -= (100 / slidesPerPage);
        currentPosition++;
      }
      if (currentPosition == slidesCount) {
        buttons[1].classList.add('inactive');
      }
      if (currentPosition > 0) {
        buttons[0].classList.remove('inactive');
      }
    }
  </script>
</body>
</html>
