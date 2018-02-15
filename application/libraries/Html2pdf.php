<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Html2pdf
{
    public function criar($html)
    {
        $mpdf = new mPDF();
		$mpdf->WriteHTML($html);

		return $mpdf->Output(NULL, 'S');
    }
}