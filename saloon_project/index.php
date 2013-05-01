<?php
session_start();


include_once 'View/header.html';

if(isset($_GET['regSuccess']))
{
    echo "<b style='color: green'>Registration Successful please login</b>";
}

if(isset($_GET['logOut']))
{
    session_destroy();
    header("location: index.php");
}

if(isset($_GET['error']))
{
    echo "<b style='color: Red'>login Faied</b>";
}

if(isset($_GET['visitorArea'])){
    if(isset($_SESSION['visitorData']))
    {
        $data=$_SESSION['visitorData']; 
        include_once 'View/visitorArea.php'; 
    }
    else
    {
        include_once 'View/login.html';
    }
}
elseif(isset($_GET['clientArea'])){
		if(isset($_SESSION['clientData']))
		{
			$data=$_SESSION['clientData'];
			include_once 'View/clientArea.php';
			if(empty($_SESSION['clientSaloonData']))
			{
				include_once 'View/fillSaloonInfo.php';
	
			}
			else
			{
				echo "<pre>";
				print_r($_SESSION['clientSaloonData']);
				echo "</pre>";
				include_once 'View/salonCalander.php';
			}
		}
		else
		{
			include_once 'View/login.html';
		}
}
else{
	    if(isset($_SESSION['clientData']))
	    {
	        header("location:index.php?clientArea") ;
	    }
	    elseif(isset($_SESSION['visitorData']))
	    {
	    	header("location:index.php?visitorArea") ;
	    }
	    else
	    {
	    include_once 'View/login.html';
	    }
}

include_once 'View/footer.html';

?>