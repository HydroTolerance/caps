<?php
class View {
    public static function renderDiagnosisTable($diagnosisData) {
        if (empty($diagnosisData)) {
            echo '<p>No diagnosis information available for this patient.</p>';
            return;
        }

        echo '<table class="table table-bordered table-striped">';
        echo '  <thead>
                    <tr>
                        <th style="width:20%">Date:</th>
                        <th style="width:20%">History:</th>
                        <th>Diagnosis:</th>
                        <th>Management:</th>
                    </tr>
                </thead>';
        echo '<tbody>';

        foreach ($diagnosisData as $data) {
            echo '
            <tr>
                <td>' . date("F jS Y ", strtotime(strval($data['date_diagnosis']))) . '</td>
                <td>' . $data['history'] . '</td>
                <td>' . $data['diagnosis'] . '</td>
                <td>' . $data['management'] . '</td>
            </tr>';
        }

        echo '</tbody></table>';
    }
}


?>