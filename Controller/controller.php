<?php
if (isset($_POST['act'])){
    switch ($_POST['act']) {
        case "signUp":{
            require './authController.php';
            $data=AuthController::signUp($_POST['user'],$_POST['password'],$_POST['hoten'],$_POST['ngaysinh'],$_POST['sdt'],$_POST['cv']);
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            
        }
        break;
        case "signIn":{
            require './authController.php';
            $data=AuthController::signIn($_POST['user'],$_POST['password']);
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        break;
        case "logOut":{        
            session_unset();
            echo json_encode("success");
        }
        break;
        case "createClass":{
            require './classController.php';
            session_start();
            $data=ClassController::createClass($_POST['id'],$_POST['info'],$_SESSION['user'][0],$_POST['name']);
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        break;
        case "getClass":{
            require './classController.php';
            $data=ClassController::getClass($_POST['id']);
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        break;
        case "getClassforteacher":{
            require './classController.php';
            $data=ClassController::getClassforteacher($_POST['id']);
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        break;
        case "deleteClass":{
            require './classController.php';
            $data=ClassController::deleteClass($_POST['idClass']);
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        break;
        case "deleteTest":{
            require './testController.php';
            $data=TestController::deleteTest($_POST['idTest']);
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        break;
        case "renderListClass":{
           require './classController.php';
           session_start();
           $data=ClassController::renderListClass($_SESSION['user'][0]);
           echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }  
        break;
        case "renderMember":{
            require './classController.php';
            $data=ClassController::renderMember($_POST['idClass']);
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        break;
        case "renderBankQuestion":{
            require './questionController.php';
            $data=QuestionController::renderBankQuestion();
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        break;
        case "renderSltGroupQuestion":{
            require './questionController.php';
            $data=QuestionController::renderSltQuestionGroup();
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        break;
        case "createQuestion":{
            require './questionController.php';
            $data=QuestionController::createQuestion($_POST['noidung'],$_POST['cauA'],$_POST['cauB'],$_POST['cauC'],$_POST['cauD'],$_POST['idGroup'],$_POST['tenNhom'],$_POST['dapAn']);
            echo json_encode($data,JSON_UNESCAPED_UNICODE);

        }
        break;
        case "createTest":{
            require './testController.php';
            $data=TestController::createTest($_POST["idClass"],$_POST['nameTest'],$_POST["thoiGianLamBai"],$_POST["ngayThi"],$_POST["daoCauHoi"]);
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        break;
        case "renderQuestionInSettingTest":{
            require './questionController.php';
            $data=QuestionController::renderAllQuestionInSettingTest();
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        break;
        case "saveQuestionInTest" :{
            require './testController.php';
            $data=TestController::saveQuestionInTest($_POST['idTest'],$_POST['arrQuestion']);
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        break;
        // case "renderListQuestionInSettingTest":{
        //     require './questionController.php';
        //     $data=QuestionController::renderListQuestionOfTest($_POST['idTest']);
        //     return $data;
        // };
        // break;
        case "renderAccountTable":{
            require './adminController.php';
            $data= adminController::renderAccountTable();
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        break;
        case "clickDelete":{
            require './adminController.php';
            $data=adminController::clickDelete($_POST['idAdmin'], $_POST['typeAdmin']);
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        break;
        case "renderClassTable":{
            require './adminController.php';
            $data= adminController::renderClassTable();
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        break;
        case "renderQuestionTable":{
            require './adminController.php';
            $data= adminController::renderQuestionTable();
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        break;
        case "editAccount":{
            require './adminController.php';
            $data= adminController::editAccount($_POST['id'], $_POST['email'], $_POST['password'], $_POST['role'], $_POST['name'], $_POST['birth'], $_POST['phone'], $_POST['active']);
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        break;
        case "editClass":{
            require './adminController.php';
            $data= adminController::editClass($_POST['id'], $_POST['maLop'], $_POST['tenLop'], $_POST['thongTin'], $_POST['email']);
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        break;
        case "editQuestion":{
            require './adminController.php';
            $data= adminController::editQuestion($_POST['id'], $_POST['maCau'], $_POST['maNhom'], $_POST['noiDung'], $_POST['dapAn']);
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        break;
        case "renderListTest" :{
            require './testController.php';
            $data=TestController::renderListTest($_POST['idClass']);
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        break;
        case "renderInfoTest":{
            require './testController.php';
            $data=TestController::renderInfoTest($_POST['idTest']);
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        break;
        case "renderContainerbankquestion":{
            require './questionController.php';
            $data=QuestionController::renderContainerbankquestion();
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        break;
        case "renderContainerInfoClass":{
            require './classController.php';
            $data=ClassController::renderContainerInfoClass();
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        break;
        case "renderListClassOfStudent":{
            require './classController.php';
            session_start();
            $data=ClassController::renderListClassOfStudent($_SESSION['user'][0]);
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
         }  
        break;
        case "renderListTestInStudentPage":{
            require 'testController.php';
            session_start();
            $data=TestController::renderListTestInStudent($_POST['idClass'],$_SESSION['user'][0]);
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        break;
        case "renderInfoTestNoSubmit":{
            require 'testController.php';
            $data=TestController::renderInfoTestNoSubmit($_POST['idTest']);
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        break;
        case "renderInfoTestSubmited":{
            require 'testController.php';
            session_start();
            $data=TestController::renderInfoTestSubmited($_POST['idTest'],$_SESSION['user'][0]);
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        break;
        case "addStudentToClass":{
            require './classController.php';
            session_start();
            $data=ClassController::addStudentToClass($_POST['idClass'],$_SESSION['user'][0]);
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        break;
        case "removeStudent" :{
            require './classController.php';
            session_start();
            $data=ClassController::removeStudent($_POST['idClass'],$_SESSION['user'][0]);
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        break;
        case "takeATest":{
            require './testController.php';
            $data=TestController::takeATest($_POST['idTest']);
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        break;
        case "getListQuestionInTest":{
            require './testController.php';
            $data=TestController::getListQuestionInTest($_POST['idTest']);
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        break;
        case "chamBai":{
            require './testController.php';
            session_start();
            $data=TestController::chamBai($_POST['listAnswer'],$_POST['idTest'],$_SESSION['user'][0]);
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        break;
        case "removeStudentsfromclass":{
            require './classController.php';
            $data=ClassController::removeStudentsFromClass($_POST['idClass'],$_POST['mail']);
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        break;
        case "showTestscores":{
            require './classController.php';
            $data=ClassController::showTestscores($_POST['idTest'],$_POST['idClass']);
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        break;
        case "showDetailstestscores":{
            require './classController.php';
            $data=ClassController::showDetailstestscores($_POST['idTest'],$_POST['idStudent']);
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        break;
        case "addListstudenttoclass":{
            require './classController.php';
            $data=ClassController::addListStudent($_POST['idClass'],$_POST['arrayStudentId']);
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }
    } 
}

?>
