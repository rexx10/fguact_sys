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

    }elseif($export_type == "to_print"){

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

    for($i=0; $i<count($data_list); $i++){ 
        if(!empty($data_list[$i]["data_count"])){
            if($export_type == "to_pdf"){
                $pdf->AddPage();

                $html .= '<!DOCTYPE html>';
                $html .= '<html lang="en">';
                $html .= '<head>';
                $html .= '<meta charset="utf-8">';
                $html .= '</head>';
                $html .= '<body>';
            }

            $html .= '<div style="text-align:center;font-size:15px;">佛光大學&nbsp;&nbsp;';
            $html .= $data_list[$i]["semester"]."&nbsp;&nbsp;學年度&nbsp;";
            $html .= "【&nbsp;&nbsp;".$data_list[$i]["activity_full_name"];
            $html .= " 】&nbsp;參加人員名單</div>";
            $html .= '<table border="1" cellspacing="1" width ="100%" >
            <tbody>
                <tr>
                    <td width="8%" style="text-align:center;">序號</td>
                    <td width="30%">&nbsp;系所別&nbsp;</td>
                    <td width="17%">&nbsp;姓名&nbsp;</td>
                    <td width="30%">&nbsp;E-MAIL&nbsp;</td>
                    <td width="15%">&nbsp;備註&nbsp;</td>
                </tr>';

            for($n=0; $n<count($data_list[$i]["row_data"]);$n++){
                if(!empty($data_list[$i]["row_data"][$n])){
                    
                    $html .= '<tr>
                                  <td style="text-align:center">'.($n+1).'</td>
                                  <td>&nbsp;'.$data_list[$i]["row_data"][$n]["teach_dep_name"].'&nbsp;</td>
                                  <td>&nbsp;'.$data_list[$i]["row_data"][$n]["staff_name"].'&nbsp;</td>
                                  <td>&nbsp;'.$data_list[$i]["row_data"][$n]["mail"].'&nbsp;</td>
                                  <td></td>
                              </tr>';
 
                }
            }
            
            $html .= "</tbody> </table>";
            
            if($export_type == "to_pdf"){
                
                $html .= "</body> </html>";

                if($row != count($data_list)){
                    
                    $pdf->writeHTML($html, 0, 0, false, false, "");
                }

                $row++;

            }elseif($export_type == "to_print"){
    
                $html .= '<p style="page-break-after:always"></p>';                

            }

        }
        
    }
    
    if($export_type == "to_pdf"){

        $pdf->Output($pdf_file_name.".pdf", "I");

    }elseif($export_type == "to_print"){

        $html .= "</body> </html>";        
        echo $html;

    }


?>