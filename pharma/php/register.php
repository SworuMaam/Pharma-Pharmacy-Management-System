<!DOCTYPE html>
<html>
<head>
	<title>Pharma</title>
	<link rel="stylesheet" type="text/css" href="../css/login.css">
	<style>
		#container{
			margin-top: 50px;
			width: 390px;
		}
	</style>

</head>
<body>
<div id="container">
	<form action="registerval.php" method="POST">
		<fieldset >
			<legend align="center">Pharma registration</legend>
			<table>
				<tr>
					<td>Username:</td>
					<td><input type="text" name="uname" minlength="3"/></td>
				</tr>
				<tr>
					<td>Password:</td>
					<td><input type="password" name="pass"/></td>
				</tr>
				<tr>
					<td>Confirm Password:</td>
					<td><input type="password" name="repass"/></td>
				</tr>
				<tr>
					<td>Address:</td>
					<td><input type="text" name="address"/></td>
				</tr>
				<tr>
					<td>Email:</td>
					<td><input type="text" name="email"/></td>
				</tr>
				<tr>
					<td>Contact:</td>
					<td><input type="number" name="contact"/></td>
				</tr>
				<tr>
					
					<td><input type="submit" name="submit" value="Submit"/></td>
					<td><input type="reset" name="reset"/></td>
				</tr>
			</table>
		</fieldset>
	</form>
</div>
</body>
</html>
