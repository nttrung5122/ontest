<?php

include '../model/classModel.php';
include '../View/classView.php';

class ClassController{
    
    public static function checkClassExists($idClass){
        $data=ClassModel::getAllClass();
        while ($row = mysqli_fetch_array($data)){
            if($row[0]==$idClass){
                return true;
            }
            
        }
        return false;
    }

    public static function createClass($idClass,$info,$email,$name){
        if(ClassController::checkClassExists($idClass)){
            $data['notice']="Mã lớp đã tồn tại";
            $data['status']="fails";
            return $data;
        }
        else{
            ClassModel::createClass($idClass,$info,$email,$name);
            $data['status']="success";
            $data['notice']="Tạo lớp thành công";
            return $data;
        }

    }

    public static function getClassOfTeacher($email){
        $data= ClassModel::getClassOfTeacher($email);
        return $data;
    }

    public static function getClass($idClass){
        return mysqli_fetch_array(ClassModel::getClass($idClass));
    }
    public static function getClassforteacher($idClass){
        $data=mysqli_fetch_array(ClassModel::getClassforteacher($idClass));
        $data['soLuongbaikt']=mysqli_fetch_array(ClassModel::countTestInClass($idClass))['soLuong'];
        return $data;
    }

    public static function deleteClass($idClass){
        ClassModel::deleteClass($idClass);
        $data['notice']="Xóa lớp thành công";
        $data['status']="success";
        return $data;
    }

    public static function renderListClass($email){
        $dataSQL=ClassController::getClassOfTeacher($email);
        $data=ClassView::rederClass($dataSQL);
        // $data['status']="success";
        return $data;
    }

    public static function renderMember($idClass){
        $dataSQL= ClassModel::getStudentInClass($idClass);
        $data=ClassView::renderMember($dataSQL);
        return $data;
    }

    public static function renderContainerInfoClass(){
        $data=ClassView::renderContainerInfoClass();
        return $data;
    }

    public static function getClassOfStudent($email){
        $data= ClassModel::getClassOfStudent($email);
        return $data;
    }

    public static function renderListClassOfStudent($email){
        $dataSQL=ClassController::getClassOfStudent($email);
        $data=ClassView::rederClass($dataSQL);
        return $data;
    }

    public static function checkStudentInClass($idClass,$email){
        $data=ClassModel::getClassOfStudent($email);
        while($row = mysqli_fetch_array($data)){
            if($row['maLop']==$idClass){
                return true;
            }
        }
        return false;
    }

    public static function addStudentToClass($idClass,$email){
        if(!ClassController::checkClassExists($idClass)){
            $data['notice']="Mã lớp không tồn tại";
            $data['status']="fails";
            return $data;
        }
        if(ClassController::checkStudentInClass($idClass,$email)){
            $data['notice']="Sinh viên đẫ tham gia lớp";
            $data['status']="fails";
            return $data;
        }
        ClassModel::addStudentToClass($idClass,$email);
        $data['status']="success";
        $data['notice']="Tham gia lớp thành công";
        return $data;
    }

    public static function removeStudent($idClass,$email){
        ClassModel::removeStudent($idClass,$email);
        $data['status']="success";
        $data['notice']="Rời lớp thành công";
        return $data;
    }

    public static function removeStudentsFromClass($idClass,$email){
        ClassModel::removeStudent($idClass,$email);
        $data['status']="success";
        $data['notice']="Xóa sinh viên thành công";
        return $data;
    }

    public static function showTestscores($idTest,$idClass){
        $data= ClassModel::getTestscores($idTest,$idClass);
        $result=ClassView::showTestscores($data);
        return $result;
    }

    public static function showDetailstestscores($idTest,$idStudent){
        $answer= ClassModel::getQuestionAndAnswerOfTest($idTest);
        $listAnswer=array();
        while ($row = mysqli_fetch_array($answer)){
            $listAnswer[]=$row;
        }
        $baiLam=ClassModel::getBaiLam($idTest,$idStudent);
        $data=ClassView::showDetailstestscores($listAnswer,$baiLam);
        return $data;
    }

    public static function addListStudent($idClass,$listIdstudent){
        $arrayStudent=json_decode($listIdstudent);
        foreach($arrayStudent as $student){
            if(!ClassController::checkStudentInClass($idClass,$student) && ClassModel::checkUsersExit($student)){
                ClassModel::addStudentToClass($idClass,$student);
            }
        }
        $data['notice']="Thêm sinh viên thành công";
        return $data;
    }
}
    // echo ClassController::renderMember("5IabAbm4");




?>
