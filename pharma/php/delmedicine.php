<?php  
	include "connect.php";
	$delid=$_GET['m_id'];
	$delQuery="delete from purchase where m_id='$delid' ";
	$delTransactionQuery="delete from transaction where m_id='$delid' ";

	$checkTransaction = "select * from transaction where m_id='$delid'";
	$checkTransactionExe = mysqli_query($conn,$checkTransaction);

	if($checkTransactionExe) {
		if (mysqli_num_rows($checkTransactionExe) > 0) {
			$inTransaction = mysqli_fetch_assoc($checkTransactionExe);
			
			$statusInNum = $inTransaction['approved'];
			$status = $inTransaction['status'];
			if($statusInNum != 2) {
				echo "Patient has already requested the medicine. status: " .$status;
			} else {
				$delExe=mysqli_query($conn,$delQuery);
				$delTransactionExe=mysqli_query($conn,$delTransactionQuery);
				if ($delExe) {
					echo "Data deleted";
					header('location:displaymedicine.php');
				}else{
					echo "deletion failed";
				}
			}
		} else {
			$delExe=mysqli_query($conn,$delQuery);
			if ($delExe) {
				echo "Data deleted";
				header('location:displaymedicine.php');
			}else{
				echo "deletion failed";
			}
		}
	} else {
        // Query failed
        echo "Error: " . mysqli_error($conn);
    }
	
?>