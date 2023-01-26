<?php
include('includes/db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="includes/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
    
    <main>
        <section class="form_process">
            <div class="container form_process_wrapper">
            <?php
                $all_notes = mysqli_query ($connection,"SELECT * FROM `money_count`");
            ?>
        <form method = "POST" action = "index.php">
            <div class = "form_group">
                <label for = "date"> Date </label>
                <input type="date" id="date_time" required value="02.12.2022" name="date_time">
            </div>
            <div class = "form_group">
                <label for = "select_transaction">Type of transaction</label>
                <select id = "select_transaction" name="select_transaction" required>
                    <option selected disabled>Choose please</option>
                    <option value="Income">Income</option>
                    <option value="Expenses">Expenses</option>
                </select>
            </div>
            <div class = "form_group">
                <label for = "category">Сategory</label>
                <select id = "category" name="select_category" required>
                    <option selected disabled>Choose please</option>
                    <option value="salary">Salary</option>
                    <option value="other_income">Other income</option>
                    <option value="food_products">Food products</option>
                    <option value="transport">Transport</option>
                    <option value="mobile_communication">Mobile communication</option>
                    <option value="internet">Internet</option>
                    <option value="entertainment">Entertainment</option>
                    <option value="other_expenses">Other expenses</option>
                </select>
            </div>
            <div class = "form_group">
                <label for = "sum">Money amount</label>
                <input type="number" id="sum" required name="sum">
            </div>
            <div class = "form_group">
                <label for = "comment">Comment</label>
                <textarea id="comment" name="comment" rows="4" cols="50"></textarea>
            </div>
            <div class = "form_group">
                <input class="submit_button" id = "submit_button" type="submit" value="Submit">
            </div>
            
        </form>
        </div>
        </section>
        <section class="table_filters">
            <div class="container table_filters_wrapper">
                <form method = "POST" action = "index.php">
                    
                </form>
            </div>
        </section>
        <section class="form_result">
            <div class="container form_result_wrapper">

            <?php
                if (mysqli_num_rows($all_notes) != 0){
                    while(($cat = mysqli_fetch_assoc($all_notes))){
                        echo '<ul class="one_entry_lest">';
                        echo '<div class="one_entry_lest_box">';
                        echo '<li>'.$cat['date_time'].'</li>';
                        echo '<li>'.$cat['transaction_type'].'</li>';
                        echo '<li>'.$cat['category'].'</li>';
                        echo '<li>'.$cat['sum'].'</li>';
                        echo '<li>'.$cat['comment'].'</li>';
                        echo '</div>';
                        echo '</ul>';
                        // print_r($cat);
                    }
                } else{
                    echo 'we have no notes in db';
                } 
            
            // $data = $_POST['date'];
            // echo $data;
            print_r($_POST);

            

            // $connection->exec("set names utf8");
            // $date_v = $_POST['date_time'];
            $data_v = $_POST['date_time'];
            // echo $data_v;
            $select_transaction_v = $_POST['select_transaction'];
            $select_category_v = $_POST['select_category'];
            $sum_v = $_POST['sum'];
            $comment_v = $_POST['comment'];

            // echo '$_POST['data']';
            // $sql = "INSERT INTO `money_count` (`date_time`, `transaction_type`, `category`, `sum`, `comment`) VALUES ($date_v, $select_transaction_v, $select_category_v, $sum_v, $comment_v)";
            $sql = "INSERT INTO `money_count` (`id`, `date_time`, `transaction_type`, `category`, `sum`, `comment`) VALUES ($date_v, $select_transaction_v, $select_category_v, $sum_v, $comment_v)";
            //$sql = 'INSERT INTO `money_count` (date_time, transaction_type) VALUES ($_POST[`date_time`], $_POST[`select_transaction`], $_POST[`select_category`], $_POST[`sum`],  $_POST[`comment`])';
            // mysqli_query($connection, $sql);
                //if(($_POST['select_transaction'] == 'Income') and ($_POST['select_category'] == 'salary' or 'other_income')){
                    
                    // $connection->query($insert_query)
                    //mysqli_query($connection, $sql);
                //} else if(($_POST['select_transaction'] == 'Expenses') and ($_POST['select_category'] == 'food_products' or 'transport' or 'mobile_communication' or 'internet' or 'entertainment' or 'other_expenses')){
                    //mysqli_query($connection, $sql);
                //} else {
                    //echo 'Apparently you mixed up the transaction type and category, please try again';
                //}
            if (mysqli_query($connection, $sql) == true) {
                echo 'hi, work';    
            } else{
                echo 'hi, hfhdhjsdjhsdhsdhds';
            }
            ?>
        </div>
        </section>
    </main>
</body>
</html>