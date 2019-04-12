<?php

  require_once 'dompdf/autoload.inc.php';
  use Dompdf\Dompdf;

  function generatePDF($user_data, $locale, $models_list) {

    $models = "";

    foreach ($models_list as $model) {

      $display = isset( $model->display)?sprintf('%03d', $model->display):'';

      $models .= '<tr>
        <td>' . sprintf('%04d', $model->id) . '</td>
        <td>' . $model->title . '</td>
        <td>' . $model->sigla . '</td>
        <td>' . $model->category . '</td>
        <td>' . $display . '</td>
      </tr>';
    }

    $labels = "";
    $row = "";
    $cell_count = 0;

    foreach ($models_list as $model) {

      $display = isset( $model->display)?( ' - DISP' . sprintf('%03d', $model->display)):'';
      $row .= '<td>' . $model->sigla . $display .' - MOD' .  sprintf('%04d', $model->id) . '</td>';

      $cell_count++;

      if($cell_count == 3) {
        $cell_count = 0;
        $labels .= '<tr>'. $row .'</tr>';
        $row = '';
      }
    }

    if($cell_count != 0) {
      if (count($models_list) > 3) {
        while($cell_count < 3) {
          $row .= '<td></td>';
          $cell_count ++;
        }
      }
      $labels .= '<tr>'. $row .'</tr>';
    }

    if($locale == "it_IT") {
      $page_sep = "di";
      $title = "vms_receipt_title_it";
      $subtitle = "vms_receipt_subtitle_it";
      $toptext = "vms_receipt_top_text_it";
      $bottomtext = "vms_receipt_bottom_text_it";
      $labelstext = "vms_receipt_labels_text_it";
      $model_id = "vms_receipt_model_id_it";
      $model_title = "vms_receipt_model_title_it";
      $model_sigla = "vms_receipt_model_sigla_it";
      $model_category = "vms_receipt_model_category_it";
      $model_display = "vms_receipt_model_display_it";
    }
    else {
      $page_sep = "of";
      $title = "vms_receipt_title_en";
      $subtitle = "vms_receipt_subtitle_en";
      $toptext = "vms_receipt_top_text_en";
      $bottomtext = "vms_receipt_bottom_text_en";
      $labelstext = "vms_receipt_labels_text_en";
      $model_id = "vms_receipt_model_id_en";
      $model_title = "vms_receipt_model_title_en";
      $model_sigla = "vms_receipt_model_sigla_en";
      $model_category = "vms_receipt_model_category_en";
      $model_display = "vms_receipt_model_display_en";
    }
    $html = '<html>
      <head>
        <meta http-equiv="Content-Type" content="charset=utf-8" />
        <style type="text/css">
          h1{
            font-family: "Andes";
          }
          body {
            text-align: center;
          }
          table {
            border-collapse: collapse;
            margin-top: 50px;
            margin-bottom: 50px;
            margin-left: auto;
            margin-right: auto;
            width: 100%;
          }
          .text {
            margin: 50px 0;
          }
          th {
            text-align:center;
            background-color: #dedede;
          }
          td,th {
            padding: 10px;
            border: 1px solid black;
          }
          .line {
            display: block;
            height: 1px;
            border-bottom: 1px dashed black;
            margin: 50px 0;
          }
          .labels {
            text-align:center;
            page-break-inside: avoid;
          }
          .labels table {
            width: 100%;
          }
          .labels table td {
            width: 33%;
            font-size: 12px;
            text-align: center;
          }
          .logo {
            position: absolute;
            top: 20px;
            left: 20px;
            width: 100px;
            height: 100px;
          }
        </style>
        </head>
        <body>
          <script type="text/php">
              if ( isset($pdf) ) {
                  $x = 520;
                  $y = 780;
                  $text = "{PAGE_NUM} ' . $page_sep . ' {PAGE_COUNT}";
                  $font = $fontMetrics->get_font("helvetica", "bold");
                  $size = 8;
                  $color = array(0,0,0);
                  $word_space = 0.0;
                  $char_space = 0.0;
                  $angle = 0.0;
                  $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
              }
          </script>
          <img class="logo" src="' . get_option('vms_receipt_logo') . '"/>
          <h1>' . get_option( $title ) . '</h1>
          <h3>' . get_option( $subtitle ) . '</h3>
          <div>' . date('d/m/Y - H:s') . '</div>
          <div class="text">' . get_option( $toptext ) . '</div>
          <table>
            <thead>
              <tr>
                <th>' . get_option( $model_id ) . '</th>
                <th>' . get_option( $model_title ) . '</th>
                <th>' . get_option( $model_sigla ) . '</th>
                <th>' . get_option( $model_category ) . '</th>
                <th>' . get_option( $model_display ) . '</th>
              </tr>
            </thead>
            <tbody>
              ' . $models . '
            </tbody>
          </table>
          <div class="labels">
            <div class="text">' . get_option( $bottomtext ) . '</div>
            <div class="line"></div>
            <div class="text"><i>' . get_option( $labelstext ) . '</i></div>
            <table>
              <tbody>' . $labels . '</tbody>
            </table>
          </div>
        </body>
      </html>';

    $dompdf = new Dompdf(array('enable_remote' => true,
                               'isPhpEnabled' => true));
    $dompdf->loadHtml($html);

    $dompdf->setPaper('A4', 'portrait');

    $dompdf->render();

    $dompdf->stream( trim($user_data->last_name) . '_' . trim($user_data->first_name) . '.pdf');

    unset($dompdf);
  }

?>
