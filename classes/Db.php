<?PHP

class Db 
{
    public static function connect()
    {
         $dsn = "mysql:host=" . HOST . 
        ";dbname=" . DBNAME . ";charset=" . CHARSET;
        $user = USER;
        $password = PASSWORD;
        $opt= [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES  => true
        ];
		
        try
        {
            $pdo = new PDO($dsn, $user, $password, $opt);
        }
        catch(PDOException $e) 
        {  
            $pdo = $e->getMessage();
        }
        return $pdo; 
    }
}