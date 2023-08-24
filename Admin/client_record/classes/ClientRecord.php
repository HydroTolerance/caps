<?php
class ClientRecord {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getDiagnosisData($id) {
        $info_sql = "SELECT * FROM zp_derma_record WHERE patient_id=?";
        $info_stmt = mysqli_prepare($this->conn, $info_sql);
        mysqli_stmt_bind_param($info_stmt, "i", $id);
        mysqli_stmt_execute($info_stmt);
        $info_result = mysqli_stmt_get_result($info_stmt);

        $diagnosisData = [];

        if (mysqli_num_rows($info_result) > 0) {
            while ($info_row = mysqli_fetch_assoc($info_result)) {
                $date_diagnosis = $info_row['date_diagnosis'];
                $history = $info_row['history'];
                $diagnosis = $info_row['diagnosis'];
                $management = $info_row['management'];

                $diagnosisData[] = [
                    'date_diagnosis' => $date_diagnosis,
                    'history' => $history,
                    'diagnosis' => $diagnosis,
                    'management' => $management
                ];
            }
        }

        mysqli_stmt_close($info_stmt);

        return $diagnosisData;
    }

}

?>