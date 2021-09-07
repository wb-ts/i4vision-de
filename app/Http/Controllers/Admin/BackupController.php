<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;

class BackupController extends Controller
{

    public $suffix;
    public $dirs;
    protected $dbInstance;
    public function __construct() {
        try{

            // $pdo = DB::connection()->getPdo();
            $db_connection = env('DB_CONNECTION');
            $db_host = env('DB_HOST');
            $db_name = env('DB_DATABASE');
            $username = env('DB_USERNAME');
            $password = env('DB_PASSWORD');
            $this->dbInstance = new PDO($db_connection . ":host=".$db_host.";dbname=".$db_name, 
            $username, $password);
        } catch(Exception $e) {
            die("Error ".$e->getMessage());
        }
        $this->suffix = date('Ymd_His');
    }

    public function db_backup($tables = '*'){
        $output = "-- database backup - ".date('Y-m-d H:i:s').PHP_EOL;
        $output .= "SET NAMES utf8;".PHP_EOL;
        $output .= "SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';".PHP_EOL;
        $output .= "SET foreign_key_checks = 0;".PHP_EOL;
        $output .= "SET AUTOCOMMIT = 0;".PHP_EOL;
        $output .= "START TRANSACTION;".PHP_EOL;
        //get all table names
        if($tables == '*') {
          $tables = [];
          $query = $this->dbInstance->prepare('SHOW TABLES');
          $query->execute();
          while($row = $query->fetch(PDO::FETCH_NUM)) {
            $tables[] = $row[0];
          }
          $query->closeCursor();
        }
        else {
          $tables = is_array($tables) ? $tables : explode(',',$tables);
        }
     
        foreach($tables as $table) {
     
          $query = $this->dbInstance->prepare("SELECT * FROM `$table`");
          $query->execute();
          $output .= "DROP TABLE IF EXISTS `$table`;".PHP_EOL;
     
          $query2 = $this->dbInstance->prepare("SHOW CREATE TABLE `$table`");
          $query2->execute();
          $row2 = $query2->fetch(PDO::FETCH_NUM);
          $query2->closeCursor();
          $output .= PHP_EOL.$row2[1].";".PHP_EOL;
     
            while($row = $query->fetch(PDO::FETCH_NUM)) {
              $output .= "INSERT INTO `$table` VALUES(";
              for($j=0; $j<count($row); $j++) {
                $row[$j] = addslashes($row[$j]);
                $row[$j] = str_replace("\n","\\n",$row[$j]);
                if (isset($row[$j]))
                  $output .= "'".$row[$j]."'";
                else $output .= "''";
                if ($j<(count($row)-1))
                 $output .= ',';
              }
              $output .= ");".PHP_EOL;
            }
          }
          $output .= PHP_EOL.PHP_EOL;
     
        $output .= "COMMIT;";
        //save filename
     
        $filename = 'db_backup_'.$this->suffix.'.sql';
        $this->writeUTF8filename($filename,$output);

        return back();
      }
     
     
      private function writeUTF8filename($fn,$c){  /* save as utf8 encoding */
        // $path = '/backup/'. $fn;
        
        $f=fopen($fn,"w+");
        # Now UTF-8 - Add byte order mark
        fwrite($f, pack("CCC",0xef,0xbb,0xbf));
        fwrite($f,$c);
        fclose($f);
      }
}
