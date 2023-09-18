<?php  
include "config.php";
$output = '';
if(isset($_POST["export"]))
{
 $query = "SELECT * FROM medicines";
 $result = mysqli_query($variable, $query);
 if(mysqli_num_rows($result) > 0)
 {
  $output .= '
   <table class="table" bordered="1">  
        <tr>
            <td scope="col">MEDICINE</td>
            <td scope="col">QUANTITY</td>
            <td scope="col">TYPE</td>
            <td scope="col">PRICE</td>
            <td scope="col">TOTAL</td>
            <td scope="col">ITEMS SOLD</td>
            <td scope="col">ALL PRICES</td>
            <td scope="col">EXPIRATION</td>
        </tr>
  ';
  while($row = mysqli_fetch_array($result))
  {
   $output .= '
    <tr>  
        <td>'.$row["medicine"].'</td>  
        <td>'.$row["quantity"].'</td>  
        <td>'.$row["type"].'</td>  
        <td>'.$row["price"].'</td> 
        <td>'.$row['quantity']*$row['price'].'</td>
        <td>'.$row['sales_quantity'].'</td>  
        <td>'.$row['quantity']-$row['sales_quantity'].'</td>
        <td>'.$row['expirydate'].'</td>
    </tr>
   ';
  }
  $output .= '</table>';
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename=download.xls');
  echo $output;
 }
}
?>