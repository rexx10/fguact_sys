<?php if(!defined("BASEPATH")) exit("No direct script access allowed");

require_once dirname(__FILE__)."/tcpdf_o/tcpdf.php";

class CI_Pdf_lib extends TCPDF{
	function __construct(){
		parent::__construct();
	}
}
?>