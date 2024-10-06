<?php
    include "connect.php";

    if (isset($_POST['submit'])) {
        if (isset($_FILES['imageUpload']) && $_FILES['imageUpload']['error'] === UPLOAD_ERR_OK) {
			// Get the temporary file path
			$tmpFilePath = $_FILES['imageUpload']['tmp_name'];
	
			// Read the file content
			$imgData = file_get_contents($tmpFilePath);
	
			// Escape special characters in binary data
			$escapedImgData = $conn->real_escape_string($imgData);
		}

        $sname = $_POST['sname'];
        $mid = $_POST['mid'];
        $sid = $_POST['sid'];
        $address = $_POST['address'];
        $contact = $_POST['contact'];
        $mname = $_POST['mname'];
        $batch = $_POST['batch'];
        $manuDate = $_POST['mdate'];
        $expDate = $_POST['edate'];
        $price = $_POST['price'];
        $qty = $_POST['qty'];
        $description = $_POST['desc'];
        $purDate = $_POST['purdate'];

 
        // Perform validation on the form inputs
        if (empty($batch) || empty($price) || empty($qty)) {
            echo "Please enter all required fields.";
        } else {
            // Perform database update
            $update_query = "UPDATE purchase SET s_name='$sname', address='$address', contact='$contact', m_name='$mname', 
                batch_no='$batch', mft_date='$manuDate', exp_date='$expDate', price='$price', qty='$qty', 
                descript='$description', p_date='$purDate', image='$escapedImgData' WHERE s_id='$sid' AND m_id='$mid'";
            $update_result = mysqli_query($conn, $update_query);

            if ($update_result) {
                echo "Stock updated successfully.";
                header('location:displaymedicine.php');
            } else {
                echo "Failed to update stock.";
            }
        }
    }
?>
