<!DOCTYPE html>
<html>
	<head>
	<meta charset="UTF-8">
	</head>
	<body>
    
<?php
   $db = new PDO('mysql:host=localhost;dbname=trälleborg;charset=utf8mb4', 'root', ''); 
$stmt = $db->query('SELECT * FROM books');

while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	echo '<tr>';
    echo "<td>{$row['title']}</td>";
    echo '<td>'.$row['ISBN'].'</td>';
	echo '<td>'.$row['author'].'</td>'; 
	echo '</tr>';
}
    ?>