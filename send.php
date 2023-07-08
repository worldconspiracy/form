<?php
// файл с подключение к БД
include "db.php";

// создаем переменные, содержащие значения инпутов
$userName = $_POST['name'];
$userPhone = $_POST['phone'];
$userEmail = $_POST['email'];
$userMessage = $_POST['message'];
// создаем массив, содержащий значения переменных
$data = ['name' => $userName, 'phone' => $userPhone, 'email' => $userEmail, 'message' => $userMessage];
// преобразуем массив в строку, для отправки текста на почту
$arrToText = implode ('; ', $data);

// готовим запрос для проверки наличия e-mail в БД
$exam = "SELECT * FROM `tableForUsersData` WHERE `email` = '$userEmail'";
// готовим запрос для отправки данных в БД
$sendToDb = $db->prepare("INSERT INTO `tableForUsersData` (name, phone, email, message) VALUES (:name, :phone, :email, :message)");

// отправляем запрос проверки
$resultOfExam -> execute($exam);
//если в бд нашелся идентичный адрес почты - скрываем кнопку
if ($resultOfExam -> num_rows > 0) {
    print "<script language='javascript'>let btnLocked = document.getElementById('btn').style.visibility=='hidden';</script>";
}    else {
// выполняем запрос с данными
$sendToDb->execute($data);
// отправляем данные на почту используя функцию mail()
$to      = 'ivanulibishev@gmail.com';
$subject = 'Обращение пользователя';
$message = $arrToText;
$headers = 'From: dimasoloview@gmail.com';
if (mail($to, $subject, $message, $headers);) 
    {
    echo "Сообщение отправлено";
}   else {
    echo "Ничего не отправлено(";
}
}
?>
