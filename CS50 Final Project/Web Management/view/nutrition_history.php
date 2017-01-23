<?php if ($option==0): ?>
    <h3> Look up your food log between any two dates!</h3>
    <p class = "paragraph"> Please enter starting and 
    ending dates in the format YYYY-MM-DD.  If the start date field is left 
    empty, all results before the after date will be displayed. If the end date 
    field is left empty, all results between the start date and now will be displayed. </p>

    <form action="nutrition.php" method="post" id = "nutrition_history">
        <fieldset>
            <div class="form-group">
                <input autocomplete="off" autofocus class="form-control" name="start_date" placeholder="Enter start date" type="text"/>
            </div>
            <div class="form-group">
                <input autocomplete="off" autofocus class="form-control" name="end_date" placeholder="Enter end date" type="text"/>
            </div>
            <div class="form-group">
                <button class="btn btn-default" type="submit">
                    <span aria-hidden="true" class="glyphicon glyphicon-log-in"></span>
                    Go!
                </button>
            </div>
        </fieldset>
    </form>
<?php endif; ?>

<?php if ($option==1): ?>
    <h4>Food Log</h4>
    <a name="food_log">Food Log</a> |
    <a href="#nutrition">Nutrition Facts</a>
    <br>
    <br>
    <table class="table table-striped" id = "table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Amount (g)</th>
                <th>Date Added</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($log as $item): ?>
            <tr class="table_row" id = "<?= $item["item_no"] ?>" onclick = openWin(this.id); >
                <?php 
                    if($item["Id_2"]=="N/A")
                    {
                        $item["Id_2"] = "";
                    }
                ?>
                <td class='td0'><?= ucwords($item["Id_2"]." ".$item["Id_1"]) ?></td>
                <td class='td0'><?= $item["amount"] ?></td>
                <td class='td0'><?= $item["time"] ?></td>
            </tr>
        <?php endforeach?>
        </tbody>
    </table>
    <h4>Nutrition Summary from <?=$start?> to <?=$end?></h4>
    <a name="nutrition">Nutrition</a> |
    <a href="#food_log">Food Log</a>

    <table class="table table-striped" id = "table">
    <!-- This will show the nutrition info of the selected range -->
        <thead>
            <tr>
                <th>Nutrient</th>
                <th>Total Amt. Consumed</th>
                <th>Daily Average Consumed</th>
                <th width = 12>Percent of Recommended Daily Value</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($nutrition as $key => $value)
	
                if($recommended_amts[$key]=="N/A") // And other minerals
                {
                    printf("<tr class='table_row'><td>%s </td><td>%s %s</td><td>%s %s</td><td>%s</td></tr>", 
                    str_replace("_"," ",$key),  round($value,2),$units[$key],round($nutrition_daily[$key],2),$units[$key],"N/A"); 
                }
                else
                {
                    printf("<tr class='table_row'><td>%s </td><td>%s %s</td><td>%s %s</td><td>%s%%</td></tr>", 
                    str_replace("_"," ",$key), round($value,2),$units[$key],round($nutrition_daily[$key],2),$units[$key],round(100*$nutrition_daily[$key]/$recommended_amts[$key],2));
                }
            ?>
        </tbody>
    </table>
Click <a href="#top"> here </a>to go back to the top.

<br>
<span class = "bottom">
    Note: All times are Greenwich mean time (UTC). For EST, subtract 6 hours.  
</span>
<?php endif; ?>

<?php if ($option==-1): ?>
    You didn't eat anything during the selected time range.  :-(
    <br>
<?php endif; ?>

<script>
   
    var form = document.getElementById("nutrition_history");
   
    // onsubmit
    form.onsubmit = function() {
        // validate submission
        var start = form.start_date.value;
        var end = form.end_date.value;

        var serror = "Check the format of your start date. See the instructions above for more details.";
        var eerror = "Check the format of your end date. See the instructions above for more details.";
        var cerror = "End date must be after start date!";
        if(start.length == 0 && end.length ==0)
        {
                return true;
        }
        if(start.length ==0)
        {
              start = "2015-12-01";  
        }
        if(end.length ==0)
        {
              end = "2100-12-01";  
        }
        if(start.length != 10 && start.length != 0)
        {
            document.getElementById("warning").textContent=serror;
            return false;
        }
        var s_year = start.substring(0,4);
        var s_month = start.substring(5,7);
        var s_day = start.substring(8,10);
        console.log(s_year);
        console.log(s_month);
        console.log(s_day);
        var day_count = [31,28,31,30,31,30,31,31,30,31,30,31];
        // Account for leap years
        if(!isNaN(s_year))
        {
            if(s_year%4==0 && s_year%100!=0)
            {
                day_count[1]=29;    
            }
        }
        if(isNaN(s_year)|| isNaN(s_month) || isNaN(s_day)||s_month < 1 || s_month >12|| s_day<1||s_day > day_count[s_month-1])
        {
                document.getElementById("warning").textContent=serror;
                return false;
        }

        if(end.length != 10 && end.length != 0)
        {
            document.getElementById("warning").textContent=eerror;
            return false;
        }
        var e_year = end.substring(0,4);
        var e_month = end.substring(5,7);
        var e_day = end.substring(8,10);
        console.log(e_year);
        console.log(e_month);
        console.log(e_day);

        // Account for leap years
        if(!isNaN(e_year))
        {
            if(e_year%4==0 && e_year%100!=0)
            {
                day_count[1]=29;    
            }
        }
        if(isNaN(e_year)|| isNaN(e_month) || isNaN(e_day)||e_month < 1 || e_month >12|| e_day<1||e_day > day_count[e_month-1])
        {
                document.getElementById("warning").textContent=eerror;
                return false;
        }
        // Check that end date is after start date
        if(s_year > e_year)
        {
            document.getElementById("warning").textContent=cerror;
            return false;
        }
        else if(e_year == s_year)
        {
            if(s_month > e_month)
            {
                document.getElementById("warning").textContent=cerror;
                return false;
            }
            else if(e_month == s_month)
            {
                if(s_day > e_day)
                {
                    document.getElementById("warning").textContent=cerror;
                    return false;
                }
                else if(e_day == s_day)
                {
                    return true;
                }
            }
        }
        return true;
    };
        
</script>
