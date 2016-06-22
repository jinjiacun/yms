<?php
function toDate($time, $format='Y-m-d H:i:s')
{
	return date('Y-m-d', strtotime($time));
}