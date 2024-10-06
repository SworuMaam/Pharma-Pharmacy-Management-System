function logout(){
    var res =  confirm('Are you sure you want to Logout?');
    if(res == true){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "../php/logout.php", true);
        xmlhttp.send();
        
        // Redirect the user to the desired page after logout
        window.location.href = "login.php";
    }
}
