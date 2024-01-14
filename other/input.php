$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'sadb';
$secretKey = "mySecretKey";

try
{
	$dbh = new PDO('mysql:host='. $hostname .';dbname='. $database, $username, $password);
}
catch(PDOException $e) 
{
	echo '<h1>An error has ocurred.</h1><pre>', $e->getMessage(),'</pre>';
}

$hash = $_GET['hash'];
$realHash = hash('sha256', $_GET['email'] . $_GET['status'] . $secretKey);

if($realHash == $hash) 
{ 
	$sth = $dbh->prepare('INSERT INTO data VALUES (:email, null, :status)');
	try 
	{
		$sth->bindParam(':email', $_GET['email'], PDO::PARAM_STR);
		$sth->bindParam(':status', $_GET['status'], PDO::PARAM_INT);
		$sth->execute();
	}
	catch(Exception $e) 
	{
		echo '<h1>An error has ocurred.</h1><pre>', $e->getMessage() ,'</pre>';
	}
}