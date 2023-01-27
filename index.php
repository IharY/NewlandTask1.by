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
                    <form method = "POST" action = "index.php">
                        <div class = "form_group">
                            <label for = "date_time"> Date </label>
                            <!-- 2023-01-01 01:10:10 -->
                            <!-- <input type="date" id="date_time" required value="02.12.2022" name="date_time"> -->
                            <input type="text" id="date_time" value="2023-01-01 01:10:10" name="date_time">
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
                    <form method = "GET" action = "index.php">
                        <div class="select_filters_wrap">
                            <div class="select_filters_place">
                                <select id = "select_sorting" name="select_sorting" required>
                                    <option selected disabled>no sort</option>
                                    <option value="date_time">date sort</option>
                                    <option value="sum">money sort</option>
                                </select>
                            </div>
                        
                        //Фильтр не доступен 
                            <div class="select_filters_place">
                                <select id = "select_filter" name="select_filter" required>
                                    <option selected disabled>no filter</option>
                                </select>
                            </div>
                        </div>
                    
                        <div class = "form_group">
                            <input class="submit_button" id = "submit_button" type="submit" value="Submit2">
                        </div>
                    </form>
                </div>
            </section>
            <section class="form_result">
                <div class="container form_result_wrapper">
                <?php
                //вывод на экран содержимого таблицы
                    if (mysqli_num_rows($all_notes) != 0){
                        while(($cat = mysqli_fetch_assoc($all_notes))){
                            echo '<ul class="one_entry_lest">';
                                echo '<div class="one_entry_lest_box">';

                                    foreach($cat as $val){
                                        echo '<li>'.$val.'</li>';
                                    }

                                echo '</div>';
                            echo '</ul>';
                        }
                    } else{
                        echo 'we have no notes in db';
                    }
            
            // $date_v = $_POST['date_time'];
            // $select_transaction_v = $_POST['select_transaction'];
            // $select_category_v = $_POST['select_category'];
            // $sum_v = $_POST['sum'];
            // $comment_v = $_POST['comment'];
            // if ($data_v == "SELECT * FROM `money_count`, WHERE 'date_time' )
            // echo '$_POST['data']';
            // print_r($_POST);
                    $previous_note = mysqli_query($connection, "SELECT * FROM `money_count` WHERE `id` = 'max(id)'");
                    $this_previous_note_parts = mysqli_fetch_assoc($previous_note);
                    print_r($this_previous_note_parts); 
            //проверка, чтобы избежать повторной записи содержимого $_POST после перезагрузки, при отсутствии новых занчений (не отработала)
                    if (($this_previous_note_parts['date_time'] == $_POST['date_time']) and 
                        ($this_previous_note_parts['transaction_type'] == $_POST['select_transaction']) and
                        ($this_previous_note_parts['category'] == $_POST['select_category']) and
                        ($this_previous_note_parts['sum'] == $_POST['sum']) and
                        ($this_previous_note_parts['comment'] == $_POST['comment'])){
                        echo 'сomplete match';
                        exit();
                    } 

            //проверка, для дальнейшей перезаписи существующих заметок (если дата точно совпадает, тогда перезапись) (не отработала) 
            //      else if((mysqli_query($connection, "SELECT * FROM `money_count` WHERE `date_time` = '$_POST[date_time]'")) == true){
            //          echo "ready to overwrite";
            //          $change_note = "UPDATE `money_count` SET transaction_type = '$_POST[select_transaction]', category = '$_POST[select_category]', sum = '$_POST[sum]', comment = '$_POST[comment]' WHERE `date_time` = '$_POST[date_time]'";
            //          mysqli_query($connection, $change_note);
            //          exit();
            //      }

                    else{
            //проверка на то чтобы тип денежной операции совпадал с возможными для нее категориями (отработала)
                        $sql = "INSERT INTO `money_count` (`date_time`, `transaction_type`, `category`, `sum`, `comment`) VALUES ('$_POST[date_time]', '$_POST[select_transaction]', '$_POST[select_category]', '$_POST[sum]', '$_POST[comment]')";
                        if(($_POST['select_transaction'] == 'Income') and (($_POST['select_category'] == 'salary') or ($_POST['select_category'] == 'other_income'))){
                            //echo "In Income if (1)";
                            mysqli_query($connection, $sql);
                        } else if(($_POST['select_transaction'] == 'Expenses') and (($_POST['select_category'] == 'food_products') or ($_POST['select_category'] == 'transport') or ($_POST['select_category'] == 'mobile_communication') or ($_POST['select_category'] == 'internet') or ($_POST['select_category'] == 'entertainment') or $_POST['select_category'] == ('other_expenses'))){
                            //echo "In Expenses if (2)";
                            mysqli_query($connection, $sql);
                        } else {
                            echo 'Apparently you mixed up the transaction type and category, please try again';
                            exit();
                            }
                    }
         
            //попытка реализовать функцию сортировки по рпзличным параметрам
                    // print_r($_GET);
                    // switch ($_GET['select_sorting']) {
                    //     case 'no sort':
                    //         $all_notes = mysqli_query ($connection,"SELECT * FROM `money_count`");
                    //         break;
                    //     case 'date sort':
                    //         $all_notes = mysqli_query ($connection,"SELECT * FROM `money_count` ORDER BY 'date_time'");
                    //         break;
                    //     case 'money sort':
                    //         $all_notes = mysqli_query ($connection,"SELECT * FROM `money_count` ORDER BY 'date_time'");
                    //         break;
                    // }
                ?>
        </div>
        </section>
    </main>
</body>
</html>
