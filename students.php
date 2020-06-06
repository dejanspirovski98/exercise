
<!doctype html>

<html lang="mk">
<head>
  <meta charset="utf-8">

  <title>Grades</title>
  <meta name="description" content="Grades">
  <meta name="author" content="Dejan Spirovski">

  <link rel="stylesheet" href="css/styles.css?v=1.0">

</head>

<body>
	<?php 
		class Student {
			protected $id;
			protected $name;
			protected $grade_1;
			protected $grade_2;
			protected $grade_3;
			protected $grade_4;
			protected $school;
			protected $average_grade;
			protected $final_result;
			
			function __construct($id, $name, $grade_1, $grade_2, $grade_3, $grade_4, $school, $average_grade, $final_result) {
				$this->id = $id;
				$this->name = $name;
				$this->grade_1 = $grade_1;
				$this->grade_2 = $grade_2;
				$this->grade_3 = $grade_3;
				$this->grade_4 = $grade_4;
				$this->school = $school;
				$this->average_grade = $average_grade;
				$this->final_result = $final_result;
			}
			
			public function getData() {
				if ($this->school == 0)	{
					return json_encode(get_object_vars($this));
				}
				else {
					function array_to_xml( $data, &$xml_data ) {
					foreach( $data as $key => $value ) {
						if( is_array($value) ) {
							if( is_numeric($key) ){
								$key = 'item'.$key;
							}
							$subnode = $xml_data->addChild($key);
							array_to_xml($value, $subnode);
						} else {
							$xml_data->addChild("$key",htmlspecialchars("$value"));
						}
					 }
				}

				$data = get_object_vars($this);
				$xml_data = new SimpleXMLElement('<?xml version="1.0"?><data></data>');
				array_to_xml($data,$xml_data);
				$result = $xml_data->asXML();
				return $result;
				}
			}
			
		}
		$servername = "localhost";
		$username = "root";
		$password = "karpos12345";
		$dbname = "students";
		$conn = new mysqli($servername, $username, $password, $dbname);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
			}
		$student_id=$_GET["student"];
		$sql = "SELECT * FROM students WHERE id = $student_id";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			$row = $result->fetch_row();
			$student = new Student($row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7],$row[8]);
			}
		else {
			echo "0 results";
		}
		$conn->close();
		echo $student->getData();
		
	?>
  <script src="js/scripts.js"></script>
</body>
</html>
