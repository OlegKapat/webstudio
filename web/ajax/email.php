<?
// Здесь нужно ввести свой адрес
$emailAddress = 'support@lito-webdesign.com.ua';
$a = iconv('UTF-8', 'windows-1251', $_GET['one']);

// Используем сессию, чтобы предотвратить флудинг:

session_name('quickFeedback');
session_start();

// Если последняя форма была отправлена меньше 10 секунд назад,
// или пользователь уже послал 10 сообщений за последний час

if(	$_SESSION['lastSubmit'] && ( time() - $_SESSION['lastSubmit'] < 10 || $_SESSION['submitsLastHour'][date('d-m-Y-H')] > 10 )){
	die('Пожалуста, подождите несколько минут, прежде чем отправить сообщение снова.');
}

$_SESSION['lastSubmit'] = time();
$_SESSION['submitsLastHour'][date('d-m-Y-H')]++;


require "phpmailer/class.phpmailer.php";

if(ini_get('magic_quotes_gpc')){
	$_POST['message'] = stripslashes($_POST['message']);
}

if(mb_strlen($_POST['message'],'utf-8') < 5){
	die('Ваше сообщение слишком короткое.');
}

$msg = nl2br(strip_tags($_POST['message']));

// Используем класс PHPMailer

$mail = new PHPMailer();
$mail->IsMail();

// Добавляем адрес получателя
$mail->AddAddress($emailAddress);

$mail->Subject = 'Новое письмо из формы обратной связи';
$mail->MsgHTML($msg);

$mail->AddReplyTo('noreply@'.$_SERVER['HTTP_HOST'], 'Форма обратной связи на демо странице');
$mail->SetFrom('noreply@'.$_SERVER['HTTP_HOST'], 'Форма обратной связи на демо странице');

$mail->Send();


echo 'Спасибо!';
?>