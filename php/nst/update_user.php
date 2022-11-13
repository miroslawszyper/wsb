<?php 
  session_start();
  if (isset($_POST)) {
    foreach ($_POST as $value) {
      if (empty($value)) {
        header('location: ../5_connect_tabela_update_insert_delete.php?add_user=1');
        exit();
      }
    }
    require_once './connect.php';
    $sql="UPDATE `users` SET `city_id` = '$_POST[city_id]', `name` = '$_POST[name]', `surname` = '$_POST[surname]', `birthday` = '$_POST[birthday]' WHERE `users`.`id` = $_POST[user_id]";
    $conn->query($sql);
    
    if ($conn->affected_rows) {
      $_SESSION['info'] = 'Prawidłowo zaktualizowano użytkownika';
    }else{
      $_SESSION['info'] = 'Nie udało się zaktualizować użytkownika';
    }
    header('location: ../5_connect_tabela_update_insert_delete.php');
  }
 ?>
 