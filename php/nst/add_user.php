<?php 
  session_start();
  if (isset($_POST)) {
    // print_r($_POST);
    foreach ($_POST as $value) {
      if (empty($value)) {
        header('location: ../4_connect_tabela_insert_delete.php?add_user=1');
        exit();
      }
    }
    // dane wypełnione prawidłowo
    require_once './connect.php';
    $sql="INSERT INTO `users` (`id`, `city_id`, `name`, `surname`, `birthday`, `created_at`) VALUES (NULL, '$_POST[city_id]', '$_POST[name]', '$_POST[surname]', '$_POST[birthday]', current_timestamp());";
    $conn->query($sql);
    
    if ($conn->affected_rows) {
      $_SESSION['info'] = 'Prawidłowo dodano nowego użytkownika';
    }else{
      $_SESSION['info'] = 'Nie udało się dodać nowego użytkownika';
    }
    header('location: ../4_connect_tabela_insert_delete.php');
  }
 ?>
 