<h3>Recommendations</h3>
<?php 
    $group1 = strtolower($suggestion1[0]["food_group"]);
    // Adds an 's' to the end of group if there isn't one already
    if($group1[strlen($group1)-1]!='s' && $group1!="dairy" && $group1!="meat")
    {
        $group1[strlen($group1)] = 's';
    }
    $group2 = strtolower($suggestion2[0]["food_group"]);
    // Adds an 's' to the end of group if there isn't one already
    if($group2[strlen($group2)-1]!='s' && $group2!="meat")
    {
        $group2[strlen($group2)] = 's';
    }
    if($success1 == 1)
    {
        // This handles most preferred food group
        if($type1 != "Fast Food" && $type1 != "Alcoholic Beverage")
        {
    ?> 
            <p>You seem to like <?=$group1?>. Here are some similar suggestions:</p>
            <ul>
                <li class="td0" id = <?= $suggestion1[0]["item_no"] ?> onclick = openWin(this.id); ><?=ucwords($suggestion1[0]["Id_2"]." ".$suggestion1[0]["Id_1"])?></li>
                <li class="td0" id = <?= $suggestion1[1]["item_no"] ?> onclick = openWin(this.id); ><?=ucwords($suggestion1[1]["Id_2"]." ".$suggestion1[1]["Id_1"])?></li>
                <li class="td0" id = <?= $suggestion1[2]["item_no"] ?> onclick = openWin(this.id); ><?=ucwords($suggestion1[2]["Id_2"]." ".$suggestion1[2]["Id_1"])?></li>
            </ul>
    <?php 
        }
        else if($type1 == "Alcoholic beverage")
        {
    ?>
            <p>You seem to enjoy alcoholic beverages a lot. Here are some healthier alternatives:</p>
            <ul>
                <li class="td0" id = <?= $suggestion1[0]["item_no"] ?> onclick = openWin(this.id); ><?=ucwords($suggestion1[0]["Id_2"]." ".$suggestion1[0]["Id_1"])?></li>
                <li class="td0" id = <?= $suggestion1[1]["item_no"] ?> onclick = openWin(this.id); ><?=ucwords($suggestion1[1]["Id_2"]." ".$suggestion1[1]["Id_1"])?></li>
                <li class="td0" id = <?= $suggestion1[2]["item_no"] ?> onclick = openWin(this.id); ><?=ucwords($suggestion1[2]["Id_2"]." ".$suggestion1[2]["Id_1"])?></li>
            </ul>
    <?php
        }
        else if($type1 == "Fast Food")
        {
    ?>
            <p>You seem to enjoy fast food a lot. Here are some healthier alternatives:</p>
            <ul>
                <li class="td0" id = <?= $suggestion1[0]["item_no"] ?> onclick = openWin(this.id); ><?=ucwords($suggestion1[0]["Id_2"]." ".$suggestion1[0]["Id_1"])?></li>
                <li class="td0" id = <?= $suggestion1[1]["item_no"] ?> onclick = openWin(this.id); ><?=ucwords($suggestion1[1]["Id_2"]." ".$suggestion1[1]["Id_1"])?></li>
                <li class="td0" id = <?= $suggestion1[2]["item_no"] ?> onclick = openWin(this.id); ><?=ucwords($suggestion1[2]["Id_2"]." ".$suggestion1[2]["Id_1"])?></li>
            </ul>
    <?php
        }
        if($type2 != "Fast Food" && $type2 != "Alcoholic Beverage")
        {
    ?> 
            <p>You seem to like <?=$group2?>. Here are some similar suggestions:</p>
            <ul>
                <li class="td0" id = <?= $suggestion2[0]["item_no"] ?> onclick = openWin(this.id); ><?=ucwords($suggestion2[0]["Id_2"]." ".$suggestion2[0]["Id_1"])?></li>
                <li class="td0" id = <?= $suggestion2[1]["item_no"] ?> onclick = openWin(this.id); ><?=ucwords($suggestion2[1]["Id_2"]." ".$suggestion2[1]["Id_1"])?></li>
                <li class="td0" id = <?= $suggestion2[2]["item_no"] ?> onclick = openWin(this.id); ><?=ucwords($suggestion2[2]["Id_2"]." ".$suggestion2[2]["Id_1"])?></li>
            </ul>
    <?php 
        }
        else if($type2 == "Alcoholic beverage")
        {
    ?>
            <p>You seem to enjoy alcoholic beverages a lot. Here are some healthier alternatives:</p>
            <ul>
                <li class="td0" id = <?= $suggestion2[0]["item_no"] ?> onclick = openWin(this.id); ><?=ucwords($suggestion2[0]["Id_2"]." ".$suggestion2[0]["Id_1"])?></li>
                <li class="td0" id = <?= $suggestion2[1]["item_no"] ?> onclick = openWin(this.id); ><?=ucwords($suggestion2[1]["Id_2"]." ".$suggestion2[1]["Id_1"])?></li>
                <li class="td0" id = <?= $suggestion2[2]["item_no"] ?> onclick = openWin(this.id); ><?=ucwords($suggestion2[2]["Id_2"]." ".$suggestion2[2]["Id_1"])?></li>
            </ul>
    <?php
        }
        else if($type2 == "Fast Food")
        {
    ?>
            <p>You seem to enjoy fast food a lot. Here are some healthier alternatives:</p>
            <ul>
                <li class="td0" id = <?= $suggestion2[0]["item_no"] ?> onclick = openWin(this.id); ><?=ucwords($suggestion2[0]["Id_2"]." ".$suggestion2[0]["Id_1"])?></li>
                <li class="td0" id = <?= $suggestion2[1]["item_no"] ?> onclick = openWin(this.id); ><?=ucwords($suggestion2[1]["Id_2"]." ".$suggestion2[1]["Id_1"])?></li>
                <li class="td0" id = <?= $suggestion2[2]["item_no"] ?> onclick = openWin(this.id); ><?=ucwords($suggestion2[2]["Id_2"]." ".$suggestion2[2]["Id_1"])?></li>
            </ul>
    <?php
        }
    }
    else
    {
    ?>
        <p class = "rec">Because you haven't added enough items to your food log. We can't make a proper recommendation. But, fruits and vegetables are always a good choices so here you go:</p>
        <ul>
            <li class="td0" id = <?= $suggestion1[0]["item_no"] ?> onclick = openWin(this.id); ><?=ucwords($suggestion1[0]["Id_2"]." ".$suggestion1[0]["Id_1"])?></li>
            <li class="td0" id = <?= $suggestion1[1]["item_no"] ?> onclick = openWin(this.id); ><?=ucwords($suggestion1[1]["Id_2"]." ".$suggestion1[1]["Id_1"])?></li>
            <li class="td0" id = <?= $suggestion1[2]["item_no"] ?> onclick = openWin(this.id); ><?=ucwords($suggestion1[2]["Id_2"]." ".$suggestion1[2]["Id_1"])?></li>
        </ul> 
    
    <?php
    }
    
?>
