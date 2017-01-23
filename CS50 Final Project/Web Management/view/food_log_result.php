<?php if ($success==1): ?>
     <p>Click on any of the rows to see the nutrition facts for each item.</p>
    <table class="table table-striped" id = "table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Calories</th>
                <th>Amount (g)</th>
            </tr>
        </thead>
        <tbody> 
        <?php foreach ($log as $item): ?>
            <tr class="table_row"  id = "<?= $item["item_no"] ?>" onclick = openWin(this.id,this.class); >
                <td class="td0"><?= $item["Id_1"].":".$item["Id_2"] ?></td>
                <td class="td0"><?= $item["amt_adjusted_calories"] ?></td>
                <td class="td0"><?= $item["amount"] ?></td>
            </tr>
        <?php endforeach?>
        </tbody>
    </table>
<?php else: ?>
    You haven't added any food to your food log. :-(
    <br>
<?php endif; ?>