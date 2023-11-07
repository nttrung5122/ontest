<?php

include './model/questionModel.php';
include './View/questionView.php';

class QuestionController {

    public static function renderBankQuestion(){
        $question=QuestionModel::getAllQuestion();
        $answer=QuestionModel::getAllAnswer();
        $result['question']=QuestionView::renderBankQuestion($question,$answer);
        $data=QuestionModel::getAllGroupQuestions();
        $result['groupQuestion']=QuestionView::renderQuestionGroup($data);
        return $result;
    }

    public static function renderSltQuestionGroup(){
        $data=QuestionModel::getAllGroupQuestions();
        $result=QuestionView::renderSltQuestionGroup($data);
        return $result;
    }

    public static function createQuestion($noidung,$cauA,$cauB,$cauC,$cauD,$idGroup,$tenNhom,$dapAn){
        if($idGroup=='newGroup'){
            $idGroup=QuestionModel::createQuestionGroup($tenNhom);
        }
        $idQuestion=QuestionModel::createQuestion($noidung,$idGroup,$dapAn);
        QuestionModel::createAnswer($idQuestion,'a',$cauA,'a'==$dapAn);
        QuestionModel::createAnswer($idQuestion,'b',$cauB,'b'==$dapAn);
        QuestionModel::createAnswer($idQuestion,'c',$cauC,'c'==$dapAn);
        QuestionModel::createAnswer($idQuestion,'d',$cauD,'d'==$dapAn);
        $data['status']="success";
        $data['notice']="Tạo câu hỏi thành công";
        return $data;
        // return $data;
    }

    public static function renderAllQuestionInSettingTest(){
        $question = QuestionModel::getAllQuestion();
        $answer=QuestionModel::getAllAnswer();

        $result['question']=QuestionView::renderAllQuestionInSettingTest($question,$answer);
        $data=QuestionModel::getAllGroupQuestions();
        $result['groupQuestion']=QuestionView::renderQuestionGroupInFrom($data);
        return $result;
    }

    public static function renderListQuestionOfTest($idTest){
        $question = QuestionModel::getQuestionOfTest($idTest);
        $answer=QuestionModel::getAllAnswer();
        $data=QuestionView::renderListQuestionOfTest($question,$answer);
        return $data;
    }

    public static function renderContainerbankquestion(){
        $result = QuestionView::renderContainerbankquestion();
        return $result;
    }
}

// echo QuestionController::renderQuestionInSettingTest();
switch (end($request_url_parts)) {
    case "createQuestion": {
        $data = QuestionController::createQuestion($_POST['noidung'], $_POST['cauA'], $_POST['cauB'], $_POST['cauC'], $_POST['cauD'], $_POST['idGroup'], $_POST['tenNhom'], $_POST['dapAn']);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    break;
    case "renderSltGroupQuestion": {
        $data = QuestionController::renderSltQuestionGroup();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    break;
    case "renderContainerbankquestion": {
        $data = QuestionController::renderContainerbankquestion();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    break;
    case "renderBankQuestion": {
        $data = QuestionController::renderBankQuestion();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    break;
    case "renderQuestionInSettingTest": {
        $data = QuestionController::renderAllQuestionInSettingTest();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    break;
}