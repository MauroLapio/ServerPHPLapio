<?php
$requestMethod = $_SERVER["REQUEST_METHOD"];
include('./class/Student.php');
$student = new Student();
switch($requestMethod)
{
	case 'GET':
		$id = '';
		if($_GET['id']) {
			$id = $_GET['id'];
			$student->_id = $id;
			$data = $student->one();
		} else {
			$data = $student->list();
		}
		if(!empty($data)) {
          $js_encode = json_encode(array('status'=>TRUE, 'studentInfo'=>$data), true);
        } else {
          $js_encode = json_encode(array('status'=>FALSE, 'message'=>'There is no record yet.'), true);
        }
        header('Content-Type: application/json');
		echo $js_encode;
		break;
    
    case 'POST':
        $name = $_GET['name'];
        $surname = $_GET['surname'];
        $sidiCode = $_GET['sidi_code'];
        $taxCode = $_GET['tax_code'];

        $student->_name = $name;
        $student->_surname = $surname;
        $student->_sidiCode = $sidiCode;
        $student->_taxCode = $taxCode;

        if(strcmp($name,"") != 0 && strcmp($surname,"") != 0 && strcmp($sidiCode,"") != 0 && strcmp($taxCode,"") != 0)
        {
            $data = $student->insert();
            if(!empty($data))
            {
                $js_encode = json_encode(array('status'=>TRUE, 'studentInfo'=>$data), true);
            }
            else
            {
                $js_encode = json_encode(array('status'=>FALSE, 'message'=>'There is no record yet.'), true);
            }

            $data = $student->getLast();
            if(!empty($data))
            {
                $js_encode = json_encode(array('status'=>TRUE, 'studentInfo'=>$data), true);
            }
            else
            {
                $js_encode = json_encode(array('status'=>FALSE, 'message'=>'There is no record yet.'), true);
            }
            header('Content-Type: application/json');
            echo "<b>Aggiunto: </b>" . $js_encode;
        }
        else
        {
            echo "POST studente non valido";
        }
        break;

    case 'DELETE':
        $id = $_GET['id'];
        $student->_id = $id;
        $data = $student->delete();
        if(!empty($data))
        {
            $js_encode = json_encode(array('status'=>TRUE, 'studentInfo'=>$data), true);
        }
        else
        {
            $js_encode = json_encode(array('status'=>FALSE, 'message'=>'There is no record yet.'), true);
        }
        header('Content-Type: application/json');
        echo $js_encode;
        break;
    case 'PATCH':
        //TODO patch json_decode
        break;
    case 'PUT':
        //TODO put json_decode
        break;
    default:
	    header("HTTP/1.0 405 Method Not Allowed");
	    break;
}
?>	