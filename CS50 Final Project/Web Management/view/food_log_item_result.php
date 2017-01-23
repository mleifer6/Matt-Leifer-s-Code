<h3 style="text-align:center">
    <?php 
        $head = " ";
        if($data["food_group"]!="N/A" && $data["food_group"]!="Beverages" && $data["food_group"]!="Alcoholic beverage")
        {
            $head = $head.$data["food_group"].":";
        }
        for($i=1;$i<14;$i++)
        {
            $id = "Id_";
            $id = $id.$i;
            if($data[$id]=="N/A")
            {
                break;
            }
            // Special formatting case for beverages because beverages are their own food group 
            else if($i == 1 && ($data["food_group"]=="Beverages" || $data["food_group"]=="Alcoholic beverage"))
            {
                $head = $head.$data["food_group"].": ";
            }
            else
            {
                $head = $head." ".$data[$id]; 
            }
        }
        print $head;
    ?>
</h3>
<table class="table table-striped" id = "table">
<!-- This will show the nutrition info of the selected range -->
    <thead>
        <tr>
            <th>Type</th>
            <th>Amount per 100g</th>
            <th>Percent of Daily Value</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($units as $key => $value)
            if(!isset($data[$key]) || $data[$key]=="N/A" || $data[$key]<0) 
            {
                continue;
            }
            else if($recommended_amts[$key]!="N/A" && $recommended_amts[$key]>0)
            {
                printf("<tr class='table_row'><td>%s</td><td>%s %s </td><td>%s%%</td></tr>", str_replace("_"," ",$key),$data[$key], $units[$key],round($data[$key]/$recommended_amts[$key]*100,2));
            }
            else
            {
                printf("<tr class='table_row'><td>%s</td><td>%s %s </td><td>%s</td></tr>", str_replace("_"," ",$key),$data[$key], $units[$key],"N/A");
            }
        ?>
    </tbody>
</table>