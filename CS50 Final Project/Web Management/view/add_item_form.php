<form action="add_item.php" method="post" id = "add">
    <fieldset>
        <div class="form-group">
            <input autocomplete="off" autofocus class="form-control" name="Id_1" placeholder="Enter Food Name" type="text"/>
        </div>
        <div class="form-group">
            <input autocomplete="off" autofocus class="form-control" name="Id_2" placeholder="Add some description" type="text"/>
        </div>
        <div class="form-group">
            <input autocomplete="off"  class="form-control" name="calories" placeholder="Enter Calories" type="text"/>
        </div>
        <div class="form-group">
            <input autocomplete="off"  class="form-control" name="amount" placeholder="Enter Amount" type="text"/>
            <select name = "Units">
                <option value="Oz">Oz</option>
                <option value="g">g</option>
            </select>
        </div>
        <br>
        <div>
            Food Group: <select name = "food_group">
                <option value="Dairy">Dairy</option>
                <option value="Meat">Meat</option>
                <option value="Fruit">Fruit</option>
                <option value="Vegetable">Vegetable</option>
                <option value="Nuts">Nuts</option>
                <option value="Oils">Oils</option>
                <option value="Grain">Grain</option>
                <option value="Dessert">Dessert</option>
                <option value="Beverages">Drink</option>
                <option value="Alcoholic beverage">Alcohol</option>
                <option value="Fast Food">Fast Food</option>
            </select>
        </div>
        <br>
        <div class="form-group">
            <button class="btn btn-default" type="submit">
                <span aria-hidden="true" class="glyphicon glyphicon-log-in"></span>
                Add to food log
            </button>
        </div>
    </fieldset>
</form>
<script>
    var form = document.getElementById('add');
    // onsubmit
    form.onsubmit = function() {
        // validate entries
        if(form.Id_1.value == '' || form.Id_2.value == ''|| form.calories.value =='' || isNaN(form.calories.value) || 
        form.amount.value == '' || isNaN(form.amount.value) || form.amount.value<=0)
        {
            // Error checking
            var str = "ERROR: Please fill in the following fields to contine:";
            var error = 0;
            if(form.Id_1.value == '')
            {
                str = str + " name";
                error++;
            }
            if(form.Id_2.value == '')
            {
                if(error>0)
                {
                    str = str+",";
                }
                str = str + " description";
                error++;
            }
            if(form.calories.value =='' || isNaN(form.calories.value))
            {
                if(error>0)
                {
                    str = str+",";
                }
                str = str + " calories";
                error++;
            }
            if (form.amount.value == '' || isNaN(form.amount.value) || form.amount.value<=0)
            {
                if(error>0)
                {
                    str = str+", and";
                }
                str = str + " amount";
            }
            str = str +".";
            document.getElementById("warning").textContent=str;
            return false;
        }
        return true;
    };
</script>