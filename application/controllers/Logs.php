<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Carbon\Carbon;

class Logs extends CI_Controller {

	public function index()
	{
		$logViewer = new \CILogViewer\CILogViewer();
		echo $logViewer->showLogs();
    	return;
	}
}