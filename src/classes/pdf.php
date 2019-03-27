<?php

  require_once 'dompdf/autoload.inc.php';
  use Dompdf\Dompdf;

  function generatePDF() {

    $user_data = wp_get_current_user();

    $dompdf = new Dompdf();
    $dompdf->loadHtml("Ricevuta");

    $dompdf->setPaper('A4', 'portrait');

    $dompdf->render();

    $dompdf->stream( $user_data->last_name . '_' . $user_data->first_name . '.pdf');
  }

?>
