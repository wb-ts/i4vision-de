<?php
/*error_reporting(E_ALL);
ini_set("display_errors", 1);*/
include("inc/functions.php");

$query = "SELECT device.id, device.`description`, device.`device_code`, clients.description as clientname, clients.supervisor_email
from device
cross join clients
on device.client_id = clients.id
WHERE `timestamp_last_accessed`< (CURRENT_TIMESTAMP-sec_to_time(device_heartbeat_minutes*60*2))
and current_time > device_up_time and CURRENT_TIME < device_down_time
and device_heartbeat_minutes >0
and supervisor_warning = 0";

$offlines = dbselect($query);
foreach($offlines as $offline){
	$description = $offline['description'];
	$device_code = $offline['device_code'];
	$clientname = $offline['clientname'];
	$supervisor = $offline['supervisor_email'];
	
	$subject = "Warnung! i4Vision Device $description ist offline";
	$message = "Sie sind als Supervisor hinterlegt für die i4Vision Device $description unseres Kunden $clientname. Das Gerät hat die Kennung $device_code. Bitte prüfen Sie ob mit dem Gerät alles in Ordnung ist. Es erfolgt keine weitere Warnung mehr bis das Gerät wieder online ist.";

	if(sendmail("web@i4vision.de","i4Vision",$supervisor,$subject,$message)){
		dbexecute("update device set supervisor_warning = 1 where id = ".$offline['id']);
	}
	
}