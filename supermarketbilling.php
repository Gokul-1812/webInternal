<?php

$db = mysqli_connect('localhost', 'root', '', 'billing');


$create_table_qry = 'CREATE TABLE IF NOT EXISTS `supermarket` (
    `item_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `item_name` varchar(50) NOT NULL,
    `item_quantity` int(11) NOT NULL,
    `unit_price` int(11) NOT NULL,
    `total` int(11) NOT NULL
  )';

$create_table = mysqli_query($db, $create_table_qry);

$err_msg = $succ_msg = '';



if (isset($_POST['add_supermarket'])) {
    $item_id = $_POST['item_id'];
    $item_name = $_POST['item_name'];
    $item_quantity = $_POST['item_quantity'];
    $unit_price = $_POST['unit_price'];
    
    $err_msg .= (empty($item_id)) ? '<p>Please enter  item id</p>' : '';
    $err_msg .= (empty($item_name)) ? '<p>Please enter item name</p>' : '';
    $err_msg .= (empty($item_quantity)) ? '<p>Please enter  item_quantity</p>' : '';
    $err_msg .= (empty($unit_price)) ? '<p>Please enter  unit_price</p>' : '';

    $err_msg .= (!is_numeric($unit_price)) ? '<p>Please enter an integer value for unit_price</p>' : '';
    $err_msg .= (!is_numeric($item_quantity)) ? '<p>Please enter an integer value for item_quantity</p>' : '';


    if (strlen($err_msg) == 0) {
        $total = $unit_price * $item_quantity;
        $insert_supermarket = "INSERT INTO supermarket (item_id, item_name, item_quantity,unit_price, total) VALUES ('$item_id','$item_name',$item_quantity,$unit_price,$total)";
        $insert_result = mysqli_query($db, $insert_supermarket);

        if ($insert_result)
            $succ_msg = "<p>Successfully Added the item!!</p>";
        else
            $err_msg = "<p>Could not the item!!</p>";
    }
}


$supermarkets_qry = "SELECT * from supermarket";
$supermarkets_records = mysqli_query($db, $supermarkets_qry);



?>

<title>supermarket-billing</title>

<body>

    <center>
        <h2>SuperMarket Billing System</h2>
    </center>

    <div class="container">

        


        <div>

            <div class="alert alert-error" id="error_message" style="display: none;">
            </div>

            <?php if (strlen($err_msg > 0)) : ?>


                <div class="alert alert-error">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                    <?= $err_msg ?>
                </div>




            <?php endif; ?>

            <?php if (strlen($succ_msg > 0)) : ?>


                <div class="alert alert-success">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                    <?= $succ_msg ?>
                </div>



            <?php endif; ?>



            <form method="post" onsubmit="return check_validation()">
                <label for="lname">Item ID</label>
                <input type="text" id="item_id" name="item_id" required>

                <label for="fname">Item name</label>
                <input type="text" id="item_name" name="item_name" required>


                <label for="lname">Item quantity</label>
                <input type="text" id="item_quantity" name="item_quantity" required>


                <label for="lname">Unit price</label>
                <input type="text" id="unit_price" name="unit_price" required>




                <div class="wrapper">
                    <input type="submit" name="add_supermarket" value="ADD ITEM" style= background-color: "#702963">
                </div>
            </form>
        </div>
        <div>
                <div class="wrapper">
                    <button id="view_supermarket" name="view_supermarket" onclick="show_list()">View Item List</button>
                </div>
            <table id="table_list" style="display: none; ">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Item ID</th>
                        <th>Item name</th>
                        <th>Item Quantity</th>
                        <th>Unit price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    while ($supermarkets = mysqli_fetch_array($supermarkets_records)) {
                    ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= $supermarkets['item_id'] ?></td>
                            <td><?= $supermarkets['item_name'] ?></td>
                            <td><?= $supermarkets['item_quantity'] ?></td>
                            <td><?= $supermarkets['unit_price'] ?></td>
                            <td><?= $supermarkets['total'] ?></td>

                        </tr>
                    <?php }  ?>
                </tbody>
            </table>
        </div>



    </div>
</body>

<script>
    function show_list() {
        var x = document.getElementById("table_list");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }

    }

    function check_validation() {
        var item_name = document.getElementById("item_id").value;
        var item_name = document.getElementById("item_name").value;
        var item_quantity = document.getElementById("item_quantity").value;
        var unit_price = document.getElementById("unit_price").value;


        var error_message = document.getElementById("error_message");

        var err_msg = "";
        if (item_id == "")
            err_msg += "<p>Item ID cannot be empty</p>";

        if (item_name == "")
            err_msg += "<p>Item name cannot be empty</p>";

        if (item_quantity == "" || isNaN(item_quantity))
            err_msg += "<p>Item quantity cannot be empty and must be an integer</p>";

        if (unit_price == "" || isNaN(unit_price))
            err_msg += "<p>Unit price cannot be empty and must be an integer</p>";

       
        if (err_msg.length == 0)
            return true;



        error_message.style.display = 'block';
        error_message.innerHTML = err_msg;
        return false;
    }
</script>


<style>

    body{
        font-family: Tahoma, sans-serif;
    }
    h2{
        padding:50px;
        margin: 50px;
    }
    table {
        border-collapse: collapse;
        width: 100%;
        border-radius: 6px;
        
    }

    table td,
    table th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    table th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #402335;
        color: white;
    }


    input[type=text],
    input[type=date],
    input[type=time],
    textarea,
    select {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    button[name=view_supermarket] {
        width: 30%;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        border-radius: 22px;
        cursor: pointer;
        background-color: #393939 !important;
    }
    .wrapper {
        text-align: center;
    }

    .button {
        position: absolute;
        top: 50%;

    }

    input[type=submit] {
        width: 30%;
        background-color: #702963;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        border-radius: 22px;
        cursor: pointer;
    }

    input[type=submit]:hover {
        background-color: #622456;
    }

    div {
        border-radius: 5px;
        background-color: #f2f2f2;
        padding: 20px;
    }

    .col-3 {
        width: 50%;
    }

    .alert {
        padding: 20px;
        background-color: #f44336;
        color: #fff;
        margin-bottom: 2%;
    }

    .alert-error {
        background-color: #f44336;
    }

    .alert-success {
        background-color: #2eb885;
    }

    .closebtn {
        margin-left: 15px;
        color: white;
        font-weight: bold;
        float: right;
        font-size: 22px;
        line-height: 20px;
        cursor: pointer;
        transition: 0.3s;
    }

    .closebtn:hover {
        color: black;
    }
</style>