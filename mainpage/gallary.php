<!DOCTYPE html>
<!-- Coding By CodingNepal - codingnepalweb.com -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta data-name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Gallery with Search Box</title>
    <style>
        /* Google Font Import - Poppins */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600&display=swap');
        
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        .container{
            position: relative;
            min-height: 100vh;
            max-width: 1000px;
            width: 100%;
            margin: 0 auto;
            padding: 40px 20px;
        }
        
        .container .search-box{
            position: relative;
            height: 42px;
            max-width: 400px;
            margin: 0 auto;
            margin-bottom: 40px;
        }
        
        .search-box input{
            position: absolute;
            height: 100%;
            width: 100%;
            outline: none;
            border: none;
            background-color: #323334;
            padding: 0 15px 0 45px;
            color: #fff;
            border-radius: 6px;
        }
        
        .search-box i{
            position: absolute;
            z-index: 2;
            color: #999;
            top: 50%;
            left: 15px;
            font-size: 20px;
            transform: translateY(-50%);
        }
        
        .container .images .image-box{
            position: relative;
            height: 300px;
            width: 210px;
            border-radius: 6px;
            overflow: hidden;
        }
        
        .images{
            width: 100%;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .images .image-box{
            margin: 8px;
        }
        
        .images .image-box img{
            height: 100%;
            width: 100%;
            border-radius: 6px;
            transition: transform 0.2s linear;
        }
        
        .image-box:hover img{
            transform: scale(1.05);
        }
        
        .image-box h6{
            position: absolute;
            bottom: 10px;
            left: 10px;
            color: #fff;
            font-size: 12px;
            font-weight: 400;
            text-transform: capitalize;
        }
    </style>
</head>
<body>
    <?php include("header.php")?>
    <div class="container">

        <div class="images">
            <div class="image-box" data-name="spiderman">
                <img src="./img/1st.jpg" alt="">
                <h6>spiderman</h6>
            </div>
            <div class="image-box" data-name="joker">
            <img src="./img/2nd.jpg" alt="">
                <h6>joker</h6>
            </div>
            <div class="image-box" data-name="ironman">
            <img src="./img/1st.jpg" alt="">
                <h6>ironman</h6>
            </div>
            <div class="image-box" data-name="passenger">
            <img src="./img/2nd.jpg" alt="">
                <h6>passenger</h6>
            </div>
            <div class="image-box" data-name="space">
            <img src="./img/1st.jpg" alt="">
                <h6>the space</h6>
            </div>
            <div class="image-box" data-name="spiderman">
            <img src="./img/2nd.jpg" alt="">
                <h6>spiderman 2</h6>
            </div>
            <div class="image-box" data-name="universe">
            <img src="./img/1st.jpg" alt="">
                <h6>the universe</h6>
            </div>
            <div class="image-box" data-name="spiderman">
            <img src="./img/2nd.jpg" alt="">
                <h6>spiderman 3</h6>
            </div>
            <div class="image-box" data-name="holiday">
            <img src="./img/1st.jpg" alt="">
                <h6>holiday</h6>
            </div>
            <div class="image-box" data-name="ironman">
            <img src="./img/2nd.jpg" alt="">
                <h6>ironman 2</h6>
            </div>
        </div>
    </div>

    <?php include("footer.php")?>
</body>
</html>
