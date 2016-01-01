THIS CODE IS MY OWN WORK, IT WAS WRITTEN WITHOUT CONSULTING A TUTOR OR CODE WRITTEN BY OTHER STUDENTS - James Du

<html>
<head>
<title> CS377 PHP project</title>
</head>
<body>
   	  
<H3>
<HR>
Query answer
<HR>
</H3>
<P> 
<UL>

<?php

//select/connect to a database
$conn = mysqli_connect("holland.mathcs.emory.edu", "cs377", "abc123");

if (mysqli_connect_errno())
{
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit(1);
}

if(!mysqli_select_db($conn, "spjDB"))
{
	printf("Error: %s\n", mysqli_error($conn));
	exit(1);
}

$sname = $_POST['sname'];
$scity = $_POST['scity'];
$pname = $_POST['pname'];
$pcity = $_POST['pcity'];
$jname = $_POST['jname'];
$jcity = $_POST['jcity'];

foreach($_POST as $key => $value){
	if (empty($value)){
		unset($_POST[$key]);
	}
}

$query = "Select sname as 'Supplier Name', s.city as 'Supplier City', pname as 		'Part Name', p.city as 'Part City', jname as 'Project Name', j.city 		as 'Project City', qty as 'Quantity Shipped'
	from spj, supplier s, part p, proj j
	where spj.snum = s.snum 
	and spj.pnum = p.pnum
	and spj.jnum = j.jnum ";

foreach($_POST as $key => $value){
	$query = $query . " and ";
	
	switch($key){
		case "scity":
			$alt = false;
			for($i = 0; $i < strlen($value); $i++){
				if($value[$i] == '*'){
					$value[$i] = '%';
					$query = $query . "s.city LIKE '" . $value . "'";
					$alt = true;
					break;
				}
				else if($value[$i] == '?'){
					$value[$i] = '_';
					$query = $query . "s.city LIKE '" . $value . "'";
					$alt = true;
					break;
				}
			}
			if ($alt == false)
				$query = $query . "s.city = '" . $value . "'";
			break;
		case "pcity":
			$alt = false;
			for($i = 0; $i < strlen($value); $i++){
				if($value[$i] == '*'){
					$value[$i] = '%';
					$query = $query . "p.city LIKE '" . $value . "'";
					$alt = true;
					break;
				}
				else if($value[$i] == '?'){
					$value[$i] = '_';
					$query = $query . "p.city LIKE '" . $value . "'";
					$alt = true;
					break;
				}
			}
			if ($alt == false)
				$query = $query . "p.city = '" . $value . "'";
			break;
		case "jcity":
			$alt = false;
			for($i = 0; $i < strlen($value); $i++){
				if($value[$i] == '*'){
					$value[$i] = '%';
					$query = $query . "j.city LIKE '" . $value . "'";
					$alt = true;
					break;
				}
				else if($value[$i] == '?'){
					$value[$i] = '_';
					$query = $query . "j.city LIKE '" . $value . "'";
					$alt = true;
					break;
				}
			}
			if ($alt == false)
				$query = $query . "j.city = '" . $value . "'";
			break;
		default:
			$query = $query . $key . " = " . "'" . $value . "'";
	}
}

//submit query for execution
if(!($result = mysqli_query($conn, $query)))
{
	printf("Error: %s\n", mysqli_error($conn));
	exit(1);
}

print("<UL>\n");
print("<TABLE bgcolor=\"lightyellow\" BORDER=\"5\">\n");

$printed = false;

while ($row = mysqli_fetch_assoc($result))
{
	if(!$printed)
	{
		$printed = true;
		print("<TR bgcolor=\"lightcyan\">\n");	
		foreach ($row as $key => $value)
		{
			print("<TH>" . $key . "</TH>");
		}
		print("</TH>\n");
	}

	print("<TR>\n");
	foreach ($row as $key => $value)
	{   
		print ("<TD>" . $value . "</TD>");
	}   
	print ("</TR>\n");
}
print("</TABLE>\n");
print("</UL>\n");
print("<P>\n");

mysqli_free_result($result);

mysqli_close($conn);

?>

</UL>
<P> 
<HR>
<HR>
</body>
</html>
