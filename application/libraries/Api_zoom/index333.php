<?php
include('config.php');
include('api.php');
$arr['topic'] = 'Test by Ichsan';
// $arr['start_date'] = date('2021-09-30 10:00:30');
$arr['duration'] = 30;
$arr['password'] = 'coba_php';
$arr['type'] = '2';

$result = createMeeting($arr);

if (isset($result->id)) {
	print_r($result);
	// echo "Join URL: <a href='" . $result->join_url . "'>" . $result->join_url . "</a><br/>";
	// echo "Password: " . $result->password . "<br/>";
	// echo "Start Time: " . $result->start_time . "<br/>";
	// echo "Duration: " . $result->duration . "<br/>";
	// echo "Timezone: " . $result->timezone . "<br/>";
} else {
	echo '<pre>';
	print_r($result);
}
