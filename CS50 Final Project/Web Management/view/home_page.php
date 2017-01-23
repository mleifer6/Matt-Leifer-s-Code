<h3>Welcome, <?= $_SESSION["username"]?>!</h3>
<p class = "paragraph">
    Health+ is a web-app designed to help users track their daily food intake 
    and stay healthy. Anyone can easily look up foods and find their nutritional 
    information. Along with the power to help you find nutritional facts, Health+ allows you to keep 
    track of the food you have eaten and record that food into your very own food log. Within the
    food log you can view what you have eaten within a certain time period and even health metrics
    over that period of time. Lastly, Health+ will take a look at the foods you have logged to help 
    you make healthy dietary choices. 
</p>    
<p class = "paragraph">
    The goal of Health+ is to make all of the users more cognizant of the food they consume. By
    making nutritional information readily available we hope users will actively try to be more
    aware of their diet. Health+ also provides health metrics and recommendations with the aim of
    trying to guide the user to a healthier lifestyle.
</p>
<script type="text/javascript">
    // declaring new variables for the images to be displayed in the slideshow
    var image1 = new Image();
    image1.src = "img/Good_Food_Display_-_NCI_Visuals_Online.jpg";
    var image2 = new Image();
    image2.src = "img/fruits-in-gardens.jpg";
    var image3 = new Image();
    image3.src = "img/wallpapers54245.jpg";
    var image4 = new Image();
    image4.src = "img/thanksgiving-dinner-delicious-wallpaper-hd-2015-HDBcn.jpg";
    var image5 = new Image();
    image5.src = "img/food-pyramid-guide-12749123.jpg";
</script>
<p><img src="img/Good_Food_Display_-_NCI_Visuals_Online.jpg" width="500" height="300" name="slide" /></p>
<script type="text/javascript">
        // slide show implementation, displays a new image every 3 seconds
        var step=1;
        function slideit()
        {
            document.images.slide.src = eval("image"+step+".src");
            if(step<5)
                step++;
            else
                step=1;
            setTimeout("slideit()",3000);
        }
        slideit();
</script>

<p>
    And remember, more you log your eating habits, the more accurate the data will be! Stay healthy!
</p>