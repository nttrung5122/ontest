<?php

include '../model/dataProvider.php';

class ClassModel{

    public static function createClass($idClass,$info,$email,$name){
        $sql = "INSERT INTO `lop`(`maLop`, `tenLop`, `ThongTin`, `maGiangVien`) VALUES ('$idClass','$name','$info','$email');";
        $data= DataProvider::executeSQL($sql);
    }

    public static function getAllUsers(){
        $sql = "SELECT * FROM `taikhoan`;";
        $dataSql= DataProvider::executeSQL($sql);
        return $dataSql;
    }

    public static function checkUsersExit($email){
        $dataSql=  ClassModel :: getAllUsers();
        while ($row = mysqli_fetch_array($dataSql)){
            if($row[0]==$email){
                return true;
            }
            
        }
        return false;
    }   
    

    public static function getClassOfTeacher($email){
        // $sql = "SELECT * FROM `lop` WHERE `maGiangVien`=\`$email\`;";
        $sql = "SELECT * FROM `lop` WHERE `maGiangVien`=\"$email\";";

        $data= DataProvider::executeSQL($sql);
        return $data;
    }

    public static function getAllClass(){
        $sql = "SELECT * FROM `lop`;";
        $data= DataProvider::executeSQL($sql);
        return $data;
    }

    public static function getClass($idClass){
        $sql = "SELECT * FROM `lop`,taikhoan WHERE lop.maGiangVien=taikhoan.mail and `maLop`=\"$idClass\";";
        $data= DataProvider::executeSQL($sql);
        return $data;
    }

    public static function getClassforteacher($idClass){
        $sql = "SELECT * FROM `lop`,taikhoan WHERE lop.maGiangVien=taikhoan.mail and `maLop`=\"$idClass\";";
        // $sql = "SELECT *,COUNT(chitietlop.maTaiKhoan) as soLuong FROM lop LEFT JOIN chitietlop on lop.maLop=chitietlop.maLop WHERE `lop.maLop`=\"$idClass\" GROUP BY lop.maLop;";
        // $sql = "SELECT * FROM `lop`,taikhoan WHERE lop.maGiangVien=taikhoan.mail and `maLop`=\"$idClass\";";
        $sql = "SELECT *,COUNT(chitietlop.maTaiKhoan) as soLuong FROM lop LEFT JOIN chitietlop on lop.maLop=chitietlop.maLop WHERE lop.maLop='$idClass' GROUP BY lop.maLop;";
        $data= DataProvider::executeSQL($sql);
        return $data;
    }

    public static function countTestInClass($idClass){
        $sql = "SELECT COUNT(bode.maDe) as soLuong FROM lop LEFT JOIN bode on lop.maLop=bode.maLop  WHERE lop.maLop='$idClass' GROUP BY lop.maLop;";
        $data= DataProvider::executeSQL($sql);
        return $data;
    }

    public static function deleteClass($idClass){
        $sql = "DELETE FROM `lop` WHERE `malop`='$idClass';";
        $data= DataProvider::executeSQL($sql);    
        //TO DO remove Student, remove Test
    }  

    public static function getStudentInClass($idClass){
        $sql = "SELECT hoTen,mail FROM chitietlop,taikhoan WHERE chitietlop.maTaiKhoan=taikhoan.mail AND maLop=\"$idClass\";";
        $data= DataProvider::executeSQL($sql);    
        return $data;
    }

    public static function addStudentToClass($idClass,$email){
        $sql = "INSERT INTO `chitietlop`(`maLop`, `maTaiKhoan`) VALUES ('$idClass','$email');";
        $data= DataProvider::executeSQL($sql);    
    }

    public static function removeStudent($idClass,$email){
        $sql = "DELETE FROM `chitietlop` WHERE chitietlop.maLop='$idClass' and chitietlop.maTaiKhoan='$email';";
        $data= DataProvider::executeSQL($sql);    

    }

    public static function getClassOfStudent($email){
        $sql = "SELECT * FROM lop,chitietlop WHERE lop.maLop=chitietlop.maLop and chitietlop.maTaiKhoan='$email';";
        $data= DataProvider::executeSQL($sql);    
        return $data;
    }

    public static function getTestscores($idTest,$idClass){
        // $sql = "SELECT taikhoan.mail,taikhoan.hoten,taikhoan.ngaysinh,bailam.diem FROM taikhoan,chitietlop LEFT JOIN bailam ON chitietlop.maTaiKhoan=bailam.maTaiKhoan AND bailam.maDe='$idTest' WHERE taikhoan.mail=chitietlop.maTaiKhoan and chitietlop.maLop='$idClass';";
        $sql = "SELECT taikhoan.mail,taikhoan.hoten,taikhoan.ngaysinh,bailam.diem,bailam.maDe FROM taikhoan,chitietlop LEFT JOIN bailam ON chitietlop.maTaiKhoan=bailam.maTaiKhoan AND bailam.maDe='$idTest' WHERE taikhoan.mail=chitietlop.maTaiKhoan and chitietlop.maLop='$idClass';";
        $data= DataProvider::executeSQL($sql);    
        return $data;
    }

    public static function getQuestionAndAnswerOfTest($idTest){
        $sql = "SELECT cauhoi_nganhang.noiDung, cauhoi_nganhang.maCau,cauhoi_nganhang.dapAn FROM chitietbode,cauhoi_nganhang WHERE chitietbode.maCau=cauhoi_nganhang.maCau and chitietbode.maBoDe='$idTest';";
        $data = DataProvider::executeSQL($sql);
        return $data;
    }

    public static function getBaiLam($idTest,$idStudent){
        $sql = "SELECT * FROM `chitietbailam` WHERE chitietbailam.maTaiKhoan='$idStudent' AND chitietbailam.maDe='$idTest';"; 
        $data = DataProvider::executeSQL($sql);
        return $data;
    }

    public static function addListStudent($idClass,$listIdstudent){

    }

}
?>