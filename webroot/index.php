<?php
//$start = microtime(true);

define('WEBROOT',dirname(__FILE__)); 
define('ROOT',dirname(WEBROOT)); 
define('DS',DIRECTORY_SEPARATOR);
define('CORE',ROOT.DS.'core'); 
define('BASE_URL',dirname(dirname($_SERVER['SCRIPT_NAME']))); 

require CORE.DS.'includes.php'; 
new Dispatcher(); 

/*?>

<div style="position:fixed;bottom:0; background:#900; color:#FFF; line-height:30px; height:30px; left:0; right:0; padding-left:10px; ">
<?php 
$end = microtime(true); 

echo ' Page générée en '. round($end - $start,5).' secondes'; 
echo ' /  '. round(($end - $start) * 1000,0).' ms';
?>
</div>*/