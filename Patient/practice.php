<?php

class Appointment {
    public function getSlots(){	
		if($this->doctorId && $this->appointmentDate) {


			$sqlQuery = "
				SELECT appointment_time
				FROM ".$this->appointmentTable."			
				WHERE appointment_date = ? ";	
					
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->bind_param("s", $this->appointmentDate);	
			$stmt->execute();
			$result = $stmt->get_result();				
			$records = array();		
			while ($bookedSlot = $result->fetch_assoc()) { 					
				$records[$bookedSlot['appointment_time']] = $bookedSlot['appointment_time'];					
			}
			
			
			
			$stmt = $this->conn->prepare("
			SELECT *
			FROM ".$this->slotsTable);				
			$stmt->execute();			
			$result = $stmt->get_result();			
			$slotsList = '';
			while ($slots = $result->fetch_assoc()) {
				$disabled = '';
				if(isset($records[$slots['id']])) {
					$disabled = 'disabled="disabled"';
				}
				$slotsList .= '<option value="'.$slots['id'].'" '.$disabled.'>'.$slots['slots'].'</option>';
			}
			echo $slotsList;
		}
	}	
}
?>