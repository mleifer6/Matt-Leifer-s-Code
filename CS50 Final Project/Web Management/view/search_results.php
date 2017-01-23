<script type = "text/javascript">
    
    function Verify(value)
    {
        var form = document.getElementById(value);

        if (form.amount.value == '' || isNaN(form.amount.form.amount.value)||form.amount.value<=0)
        {
            document.getElementById("warning").textContent="You must enter an amount";
            return false;
        }
        return true;
    }
    
</script>
<?php if(count($foods)>0):?>
<h3 class = "paragraph;">
    Search Results
</h3>
<p>Click on the names of any of the items to see its nutrition facts.</p>
<div class="table">
    <?php foreach ($foods as $food): 

        if ($food["Id_1"] == "N/A")
        {
            $food["Id_1"] = "";
        }
        if ($food["Id_2"] == "N/A")
        {
            $food["Id_2"] = "";
        }
        if ($food["Id_3"] == "N/A")
        {
            $food["Id_3"] = "";
        }
    ?>

    <form action="add_item.php" class = "tr" method="post" onsubmit = "return Verify(this.id);" id = <?=$food["item_no"]?>  >
        <div class ="tr">
            <span class = "td0">
                <fieldset> 
                    <div class="form-group">
                        <button class="btn btn-default" type="submit" name = "item_no" value = <?=$food["item_no"]?> >
                            + 
                        </button>
                    </div>
                </fieldset>
            </span>
            <span class = "td1" id = <?= $food["item_no"] ?> onclick = openWin(this.id,this.class); > <?=ucwords($food["Id_2"])." ".$food["Id_1"]." ".$food["Id_3"] ?></span>
            <span class = "td2">
                <div class="form-group">
                    <input autocomplete="off"  class="form-control" name="amount" placeholder="Enter Amount" type="text">
                </div>
            </span>
            <span class = "td3">
                <select name = "Units">
                    <option value="g">g</option>
                    <option value="Oz">Oz</option>
                    <?php if ($food["serv_type"]!="N/A"): ?>
                        <option value="serv_type"> <?= $food["serv_type"] ?> </option>
                    <?php endif?>
                </select>
            </span>
        </div>
    </form>
    <?php endforeach ?>
</div>
Click <a href="#top"> here </a>to go back to the top.
<p class = "bottom">If you're not satisfied with these results or you couldn't find what you wanted, click <a href = "add_item.php">here</a> to add the item manually.</p> 
<?php endif ?>
<?php if(count($foods)==0):?>
    <br>
    Sorry, we couldn't find that, but click <a href = "add_item.php">here</a> to add the item manually.
<?php endif ?>
<br>
