<?php 

    $html = "";
    
    if($export_type == "to_pdf"){
        
        $pdf->SetFont('msungstdlight', '', 10);

        //取消header
        $pdf->setPrintHeader(false);
        //取消footer
        $pdf->setPrintFooter(false);
    
        //Add a page
        //$pdf->AddPage();
        $row = 0;
        $pdf->AddPage();
        
    }elseif($export_type == "to_print"){

        $html .= '<!DOCTYPE html>';
        $html .= '<html lang="en">';
        $html .= '<head>';
        $html .= '<meta charset="utf-8">';
        $html .= '</head>';

        $html .= '
        <body onLoad="printPage();">';
        
        $html .= '
        <style>
            table {
                text-align: center;
                border-collapse: collapse; /* 邊框合並屬性  */
                table-layout: fixed;
                margin: 0px;
                padding: 0px;
                /*word-wrap:break-word;*/
                /*word-break:break-all;*/
                /*padding: 0px 0px;*/
                /*margin: 0px 0px;*/
            }

            th {
                border: 1px solid #666666;
            }

            td {
                border: 1px solid #666666;
                padding: 0px;
                margin: 0px;
                word-wrap: break-word;
            }
        </style>';

        $html .= '
        <script LANGUAGE="JavaScript">
            <!--// 自動列印: 會彈出印表機交談視窗
            function printPage(){
                window.print();
            }
            //-->
        </script>';


    }
    
    if(!empty(count($data_list["semester_team"]))){

        if($export_type == "to_pdf"){
            $html .= '<!DOCTYPE html> <html lang="en"> <head> <meta charset="utf-8"> </head> <body>';
        }

        $html .= '<div style="text-align:center;font-size:30px;">佛光大學 活動統計</div>';
        $html .= '<h3 style="text-align:center;">【&nbsp;'.count($data_list["semester_team"]);
        $html .= '&nbsp;&nbsp;個學年度&nbsp;&nbsp;共舉辦&nbsp;&nbsp;'.$data_list["activity_total"];
        $html .= '&nbsp;&nbsp;場活動&nbsp;】</h3>';
        $html .= '<table border="1" cellspacing="1" width="100%">';
        $html .= '<tbody> <tr>';
        $html .= '<td width="8%" style="text-align:center;">序號</td>
                                <td width="30%">&nbsp;學年&nbsp;</td>
                                <td width="30%">&nbsp;活動名稱&nbsp;</td>
                                <td width="30%">&nbsp;備註&nbsp;</td> </tr>';
        // $row = 0;

                    for($i=0; $i<count($data_list["row_data"]); $i++){
                        
                        $html .=  '<tr>';
                        $html .=  '<td colspan="4" style="text-align:center;">'.$data_list["semester_team"][$i];
                        $html .=  '&nbsp;&nbsp;學期共舉辦&nbsp;&nbsp;'.count($data_list["row_data"][$i]);
                        $html .=  '&nbsp;&nbsp;場活動</td> </tr>';
                
                        for($n=0; $n<count($data_list["row_data"][$i]); $n++){
                  
                                $html .=  '<tr>';
                                $html .=  '<td style="text-align:center;">'.($n+1).'</td>';
                        $html .=  '<td>&nbsp;'.$data_list["row_data"][$i][$n]["semester"].'&nbsp;</td>';
                        $html .=  '<td>&nbsp;'.$data_list["row_data"][$i][$n]["activity_full_name"].'&nbsp;</td>';
                        $html .=  '<td></td> </tr>';
 
                        }
                    }

        $html .= '</tbody> </table>';

        if($export_type == "to_pdf"){

            $html .= "</body> </html>";
            $pdf->writeHTML($html, 0, 0, false, false, "");

        }

    }

    if($export_type == "to_pdf"){

        $pdf->Output($pdf_file_name.".pdf", "I");
        
    }elseif($export_type == "to_print"){

        $html .= "</body> </html>";
        echo $html;

    }

?>