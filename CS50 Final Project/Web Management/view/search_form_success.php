<p>The item you selected was successfully added! Look for another, if you want!</p>
<form action="search.php" method="post" id = "search">
    <fieldset>
        <div class="form-group">
            <input autocomplete="off" autofocus class="form-control" name="food_item" placeholder="Enter food" type="text"/>
        </div>
        <div class="form-group">
            <button class="btn btn-default" type="submit">
                <span aria-hidden="true" class="glyphicon glyphicon-log-in"></span>
                Search
            </button>
        </div>
    </fieldset>
</form>
<script>
    var form = document.getElementById('search');
    // onsubmit
    form.onsubmit = function() {
        // validate search
        if (form.food_item.value == '')
        {
            //alert("Error");
            document.getElementById("warning").textContent="Please enter a search";
            return false;
        }
        return true;
    };
</script>