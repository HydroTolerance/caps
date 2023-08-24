<?php
class Controller {
    private $clientRecord;

    public function __construct($clientRecord) {
        $this->clientRecord = $clientRecord;
    }

    public function displayDiagnosisData($id) {
        $diagnosisData = $this->clientRecord->getDiagnosisData($id);
        View::renderDiagnosisTable($diagnosisData);
    }

    // ... (other methods)
}

?>