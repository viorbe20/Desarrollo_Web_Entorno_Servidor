<?php

namespace App\Controllers;

use App\Models\Student;
use App\Models\Group;
use App\Models\Ayear;
use App\Models\Term;

require_once '../app/Config/constantes.php';
require_once '../../fct/utils/my_utils.php';

$_SESSION['currentAcademicYear'] = getCurrentAcademicYear();
$_SESSION['currentTerm'] = getCurrentTerm();

class AssigmentController extends BaseController
{
    /**
     * Insert a new assigment
     * @return void
     */
    public function getStudentsByGroupAction($request)
    {
        if ($_SESSION['user']['profile'] == 'guest') {
            $data = array();
            $this->renderHTML('../view/home.php', $data);
        } else {
            $rest = explode("/", $request);
            $studentData = end($rest);
            $dividedData = explode("_", $studentData);

            $student = new Student();
            $student->setAyear((int)$dividedData[0]);
            $student->setTerm((int)$dividedData[1]);
            $student->setGroup((int)$dividedData[2]);

            //If get somenthing, send data to assignments.js
            if ($student->getStudentsByGroupData()) {
                echo json_encode($student->getStudentsByGroupData());
            } else {
                echo json_encode(array('error' => 'No hay datos'));
            }
        }
    }
}
