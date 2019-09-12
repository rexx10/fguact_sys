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

    for($i=0; $i<$data_list["people_num"]; $i++){ 
        if(!empty($data_list["row_data"][$i])){

            if($export_type == "to_pdf"){

                $pdf->AddPage();
                $html .= '<!DOCTYPE html>';
                $html .= '<html lang="en">';
                $html .= '<head>';
                $html .= '<meta charset="utf-8">';
                $html .= '</head>';
                $html .= '<body>';

            }

            $html .= '<div style="text-align:center;font-size:30px;">佛光大學      【教師參與活動資料】</div>';
            $html .= '<h3 style="text-align: center;">';
            $html .= '教師【&nbsp;'.$data_list["staff_name"][$i].'&nbsp;】&nbsp;&nbsp;歷年共參加&nbsp;&nbsp;'.$data_list["row_data"][$i]["act_count"].'&nbsp;&nbsp;項活動<BR>';
            $html .= '教師信箱【&nbsp;'.$data_list["mail"][$i].'&nbsp;】</h3>';
            $html .= '<table border="1" cellspacing="1" width="100%">';
            $html .= '<tbody>
                      <tr>
                          <td width="8%" style="text-align:center;">序號</td>
                          <td width="7%">&nbsp;學期&nbsp;</td>
                          <td width="11%">&nbsp;日期&nbsp;</td>
                          <td width="20%">&nbsp;活動名稱&nbsp;</td>
                          <td width="19%">&nbsp;院別&nbsp;</td>
                          <td width="23%">&nbsp;系別&nbsp;</td>
                          <td width="10%">&nbsp;備註&nbsp;</td>
                      </tr>';

            for($n=0; $n<count($data_list["row_data"][$i]);$n++){
                if(!empty($data_list["row_data"][$i][$n])){
                   
                    $html .= '<tr>';
                    $html .= '<td style="text-align:center;">'.($n+1).'</td>';

                    for($k=0; $k<count($data_list["row_data"][$i][$n]);$k++){
                        if(!empty($data_list["row_data"][$i][$n][$k])){
                    
                            $html .= '<td>&nbsp;'.$data_list["row_data"][$i][$n][$k].'</td>';
 
                        }
                    }

                    $html .= '<td></td>';
                    $html .= '</tr>';

                }
            }

            $html .= '</tbody> </table>';

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