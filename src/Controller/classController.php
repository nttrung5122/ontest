<?php
namespace App\Controller;
use App\model\ClassModel;
use App\View\ClassView;
// include './model/classModel.php';
// include './View/classView.php';

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
        if(self::checkClassExists($idClass)){
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

    public static function getStudentInClass($idClass){
        $data= ClassModel::getStudentInClass($idClass);
        $listStudent=array();
        while($row=mysqli_fetch_array($data)){
            $listStudent[]=$row;
        }
        return $listStudent;
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



    public static function addListStudent($idClass,$listIdstudent){
        $arrayStudent=json_decode($listIdstudent);
        foreach($arrayStudent as $student){
            if(ClassModel::checkUsersExit($student))
                if(!ClassController::checkStudentInClass($idClass,$student) ){
                    ClassModel::addStudentToClass($idClass,$student);
                }
        }
        $data['notice']="Thêm sinh viên thành công";
        return $data;
    }

    public static function createNotice($title,$notice,$idClass){
        ClassModel::createNotice($title,$notice,$idClass);
        $data['notice']="Thêm thông báo thành công";
        return $data;
    }

    public static function renderAnnouncement($idClass)
    {
        $head = array('Mã thông báo', 'Mã lớp', 'Tiêu đề', 'Nội dung', 'Thời gian');
        $data = ClassModel::getAllAnnouncements($idClass);
        $result = ClassView::createTableAnnouncement($head, $data);
        return $result;
    }

    public static function deleteAnnouncement($id) {
        ClassModel::deleteAnnouncement($id);
    }

    public static function editAnnouncement($id, $tieuDe, $noiDung, $thoiGian)
    {
        if ($tieuDe != null) {
            ClassModel::editAnnouncement($id, 'title', $tieuDe);
        }
        if ($noiDung != null) {
            ClassModel::editAnnouncement($id, 'notice', $noiDung);
        }
        if ($thoiGian != null) {
            ClassModel::editAnnouncement($id, 'date', $thoiGian);
        }
    }

    public static function delete_listStudent($listIdstudent,$idClass){
        $arrayStudent=json_decode($listIdstudent);
        foreach($arrayStudent as $student){
            ClassModel::removeStudent($idClass,$student);
        }
        $data['status']="success";
        $data['notice']="Rời lớp thành công";
        return $data;
    }

}
    // echo ClassController::renderMember("5IabAbm4");
if(isset($request_url_parts))
switch (end($request_url_parts)) {
    case "createClass": {
        $data = ClassController::createClass($_POST['id'], $_POST['info'], $_SESSION['user'][0], $_POST['name']);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    break;
    case "createNotice": {
        $data = ClassController::createNotice($_POST['title'], $_POST['notice'], $_POST['idClass']);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    break;
    case "renderAnnounment": {
        $data = ClassController::renderAnnouncement($_GET['idClass']);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    break;
    case "editAnnouncement": {
        if (isset($_POST['id']) && isset($_POST['tieuDe']) && isset($_POST['noiDung']) && isset($_POST['thoiGian'])) { 
            ClassController::editAnnouncement($_POST['id'], $_POST['tieuDe'], $_POST['noiDung'], $_POST['thoiGian']);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }
    }
    break;
    case "deleteAnnouncement": {
        $data = ClassController::deleteAnnouncement($_POST['id']);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    break;
    case "addListstudenttoclass": {
        $data = ClassController::addListStudent($_POST['idClass'], $_POST['arrayStudentId']);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    break;
    case "renderMember": {
        $data = ClassController::renderMember($_GET['idClass']);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    break;
    case "deleteClass": {
        $data = ClassController::deleteClass($_POST['idClass']);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    break;
    case "renderListClass": {
        $data = ClassController::renderListClass($_SESSION['user'][0]);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    break;
    case "getClassforteacher": {
        $data = ClassController::getClassforteacher($_GET['id']);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    break;        
    case "renderContainerInfoClass": {
        $data = ClassController::renderContainerInfoClass();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    break;
    case "removeStudentsfromclass": {
        $data = ClassController::removeStudentsFromClass($_POST['idClass'], $_POST['mail']);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    break;
    case "getStudentInClass": {
        $data = classController::getStudentInClass($_GET['idClass']);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    break;
    case "delete_listStudent": {
        $data = classController::delete_listStudent($_POST['listIdstudent'], $_POST['idClass']);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    break;
    case "addStudentToClass": {
        $data = ClassController::addStudentToClass($_POST['idClass'], $_SESSION['user'][0]);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    break;
    case "getClass": {
        $data = ClassController::getClass($_GET['idClass']);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    break;
    case "renderListClassOfStudent": {
        $data = ClassController::renderListClassOfStudent($_SESSION['user'][0]);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    break;
    case "removeStudent": {
        $data = ClassController::removeStudent($_POST['idClass'], $_SESSION['user'][0]);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    break;

}