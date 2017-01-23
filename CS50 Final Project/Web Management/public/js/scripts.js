/**
 * scripts.js
 *
 * CS50 Final Project
 * Matt Leife and Kian Simpson
 *
 * Global JavaScript.
 */

function openWin(name){
        var request = "http://final-project-matthewleifer.cs50.io/food_log_item.php?q="+name;
        window.open(request,"","width = auto, height = auto, scrollbars = yes");
}

