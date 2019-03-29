<?php

  require_once 'dompdf/autoload.inc.php';
  use Dompdf\Dompdf;

  function generatePDF($user_data, $models_list) {

    $models = "";

    for ($i = 1; $i <= 30; $i++) {
      foreach ($models_list as $model) {

        $display = isset( $model->display)?sprintf('%03d', $model->display):'';

        $models .= '<tr>
          <td>' . $model->title . '</td>
          <td>' . sprintf('%04d', $model->id) . '</td>
          <td>' . $model->sigla . '</td>
          <td>' . $model->category . '</td>
          <td>' . $display . '</td>
        </tr>';
      }
    }


    $labels = "";
    $row = "";
    $cell_count = 0;

    for ($i = 1; $i <= 30; $i++) {

      foreach ($models_list as $model) {

        $display = isset( $model->display)?( ' - ' . sprintf('%03d', $model->display)):'';
        $row .= '<td>' . $model->sigla . ' - ' .  sprintf('%04d', $model->id) . $display . '</td>';

        $cell_count++;

        if($cell_count == 3) {
          $cell_count = 0;
          $labels .= '<tr>'. $row .'</tr>';
          $row = '';
        }
      }
    }

    if($cell_count != 0) {
      while($cell_count < 3) {
        $row .= '<td></td>';
        $cell_count ++;
      }
      $labels .= '<tr>'. $row .'</tr>';
    }

    $html = '<html>
      <head>
        <meta http-equiv="Content-Type" content="charset=utf-8" />
        <style type="text/css">
          body {
            text-align: center;
          }
          table {
            border-collapse: collapse;
            margin-top: 50px;
            margin-bottom: 50px;
            margin-left: auto;
            margin-right: auto;
            width: 75%;
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
          }
          .labels {
            text-align:center;
          }

        </style>
        </head>
        <body>
          <h1>Verbania model show 2019</h1>
          <h3>Ricevuta iscrizione modelli</h3>
          <div>' . date('d/m/Y - H:s') . '</div>
          <br/><br/>
          <div>Sono stati registrati con successo i modelli nel seguente elenco:</div>
          <div>Ricordati di presentare questo documento al momento del ritiro modelli.</div>
          <table>
            <thead>
              <tr>
                <th>Titolo</th>
                <th>Id</th>
                <th>Sigla</th>
                <th>Categoria</th>
                <th>Display</th>
              </tr>
            </thead>
            <tbody>
              ' . $models . '
            </tbody>
          </table>
          <div>Sono stati registrati con successo i modelli nel seguente elenco:</div>
          <div>Ricordati di presentare questo documento al momento del ritiro  modelli.</div>
          <div class="line"></div>
          <table class="labels">
            <tbody>' . $labels . '</tbody>
          </table>
        </body>
      </html>';

    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);

    $dompdf->setPaper('A4', 'portrait');

    $dompdf->render();

    $dompdf->stream( $user_data->last_name . '_' . $user_data->first_name . '.pdf');
  }

?>
