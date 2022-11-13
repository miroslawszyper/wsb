<?php 
  session_start();
 ?>
<!DOCTYPE html>
<html lang="pl" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./css/style.css">
    <title>Połączenie z db</title>
  </head>
  <body>
    <h4>Użytkownicy</h4>
    <?php 
      if (isset($_SESSION['info'])) {
        echo "Komunikat: $_SESSION[info]";
        unset($_SESSION['info']);
      }
     ?>
    <table>
      <tr>
        <th>Imię i nazwisko</th>
        <th>Miasto</th>
        <th>Data urodzenia</th>
        <th>Data dodania użytkownika</th>
      </tr>
<?php 
  require_once './scripts/connect.php';
  // $sql = "SELECT * FROM `users`";
  $sql = "SELECT users.id, name, surname, city, birthday, created_at FROM `users` INNER JOIN `cities` ON `users`.`city_id`=`cities`.`id`;";
  $result = $conn->query($sql);
  $count=0;
  while ($user = $result->fetch_assoc()) {
    echo "<tr>";
    $count++;
    echo <<< E
      <td>$user[name] $user[surname]</td>
      <td>$user[city]</td>
      <td>$user[birthday]</td>
      <td>$user[created_at]</td>
      <td><a href="./scripts/delete.php?id=$user[id]">Usuń</a></td>
      <td><a href="./5_connect_tabela_update_insert_delete.php?updateUserId=$user[id]">Aktualizuj</a></td>
E;
    echo "</tr>";
  }
  echo "</table>";
  
  if (isset($_GET['add_user'])) {
    echo "<h4>Dodawanie użytkownika</h4>";
    echo <<<ADDUSERFORM
      <form action="./scripts/add_user.php" method="post">
      <select name="city_id">
ADDUSERFORM;
        $sql="SELECT * FROM `cities` ORDER BY `city`";
        $result=$conn->query($sql);
        while ($city=$result->fetch_assoc()) {
          echo "<option value=\"$city[id]\">$city[city]</option>";
        }
    echo <<<ADDUSERFORM
        </select><br><br>
        <input type="text" name="name" placeholder="Podaj imię"><br><br>
        <input type="text" name="surname" placeholder="Podaj nazwisko"><br><br>
        <input type="date" name="birthday"><br><br>
        <input type="submit" value="Dodaj użytkownika">
      </form>
ADDUSERFORM;
  }else {
    echo "<a href=\"./5_connect_tabela_update_insert_delete.php?add_user=1\">Dodaj użytkownika</a>";
  }
  
  if (!empty($_GET['updateUserId'])) {
    echo "<h4>Aktualizacja użytkownika</h4>";
    
    require_once './scripts/connect.php';
    $sql="SELECT * FROM `users` WHERE `id`=$_GET[updateUserId]";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();
    
    echo <<<UPDATEUSERFORM
      <form action="./scripts/update_user.php" method="post">
      <select name="city_id">
UPDATEUSERFORM;
        $sql="SELECT * FROM `cities` ORDER BY `city`";
        $result=$conn->query($sql);
        while ($city=$result->fetch_assoc()) {
          if ($user['city_id'] == $city['id']) {
            echo "<option value=\"$city[id]\" selected>$city[city]</option>";
          }else{
            echo "<option value=\"$city[id]\">$city[city]</option>";
          }
        }
    echo <<<UPDATEUSERFORM
        </select><br><br>
        <input type="text" name="name" value="$user[name]"><br><br>
        <input type="text" name="surname" value="$user[surname]"><br><br>
        <input type="date" name="birthday" value="$user[birthday]"><br><br>
        <input type="hidden" name="user_id" value="$_GET[updateUserId]"><br><br>
        <input type="submit" value="Dodaj użytkownika">
      </form>
UPDATEUSERFORM;
  }
  
  $conn->close();
 ?>
 
  </body>
</html>