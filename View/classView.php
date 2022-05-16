
<?php

// include '../Controller/classController.php';

class ClassView
{

    public static function rederClass($data)
    {
        $result = "";
        while ($row = mysqli_fetch_array($data)) {
            $result .= '            <li>
            <a href="#" class="nav-link link-dark" onclick="renderInfoclass(\'' . $row['maLop'] . '\')">'

                . $row['tenLop'] .
                '</a>
        </li>';
        }

        return $result;
    }   
    public static function renderMember($data)
    {
        $result = '<div class="card "><div class="card-body scrollClass"><div class="">';
        while ($row = mysqli_fetch_array($data)) {
            $result .= ' 
            <div class ="row">
            <p class="card-text fs-4 col-8 ">' . $row['hoTen'] . '</p>
            
            <button class ="col-1 offset-3 btn btn-danger" onclick="deleteStudent(\''.$row['mail'].'\')"> Xóa</button>
            
            </div>
            <hr>
            ';
        }
        $result .= '</div></div></div>';
        return $result;
    }

    public static function renderContainerInfoClass(){
        $result='
        <div class="col-sm-8 mt-5 ">
    <!-- Classroom information -->

    <div class="container border border-3">
        <h4 id="nameClass"></h4>
        <h4>Mô tả:</h4>
        <!-- p for chú thích -->
        <p class="ps-3" id="infoClass"></p>
        <div class="row py-2">
            <div class="col">
                <h4 id="idClass">Mã lớp:</h4>
                <input type="hidden" name="" value="" id="idClassCurent">
            </div>
            <div class="col">
            </div>
            <div class="col justify-content-between">
                <button type="button" class="btn btn-info text-center fw-bold" data-bs-toggle="modal" data-bs-target="#formAddstudent" id="btnAddstudent">
                    <i class="fa-solid fa-plus"></i>Thêm học sinh</button>
            </div>
            <div class="col justify-content-between">
                <button type="button" class="btn btn-warning text-center fw-bold" id="btnDeleteClass" onclick="deleteClass()">
                    <i class="fa-solid fa-trash"></i> Xóa Lớp</button>
            </div>
        </div>
    </div>
    <!-- Statistical Card -->
    <div class="row gap-5 justify-content-center mt-5" style="margin-left: 0; margin-right: 0;">
        <div class="card bg-primary bg-gradient col-sm-4" style="padding-right:0px;">
            <div class="card-body" style="padding-left: 0; padding-right: 0;">
                <div class="card-content">
                    <div class="media d-flex row">
                        <div class="align-self-center col-sm-3">
                            <i class="far fa-user fs-1"></i>
                        </div>
                        <div class="media-body text-end col-sm-8" style="padding-right:0px;">
                            <h3 id="soHs">40</h3>
                            <span>Số học sinh</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card bg-danger bg-gradient col-sm-4" style="padding-right:0px;">
            <div class="card-body" style="padding-left: 0; padding-right: 0;">
                <div class="card-content">
                    <div class="media d-flex row">
                        <div class="align-self-center col-sm-3">
                            <i class="fas fa-book fs-1"></i>
                        </div>
                        <div class="media-body text-end col-sm-8" style="padding-right:0px;">
                            <h3 id="soBaikt">3</h3>
                            <span>Bài kiểm tra</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Average grade -->
    <!-- Nhấp vào sẽ hiện thông tin của bài ktra ở phần information -->
    <div class="mt-5 pb-5" id="content">

    </div>
</div>
<div class="container col-sm-3 overflow-auto text-center fixed-top bg-light" style="margin-right:0px; margin-top:70px; height:90%; z-index: 1;" id="right_content">

</div>';
        return $result;
    }

    public static function showTestscores($data){
        $result='
        <thead class="bg-success bg-opacity-25">
            <tr>
                <th>Email</th>
                <th>Tên</th>
                <th>Ngày sinh</th>
                <th>Điểm</th>
                <th class="text-center">Hành động</th>
            </tr>
        </thead>
        <tbody>
        ';
        while ($row = mysqli_fetch_array($data)) {
            $diem=$row['diem'];
            $disabled="";
            if($row['diem']==null){
                $diem="Chưa làm bài";
                $disabled="disabled";
            }
            $result .= '
            <tr>
                <td>'.$row['mail'].'</td>
                <td>'.$row['hoten'].'</td>
                <td>'.$row['ngaysinh'].'</td>
                <td>'.$diem.'</td>
                <td class="text-center">
                    <button class="btn btn-success" onclick="showDetails(\''.$row['mail'].'\',\''.$row['maDe'].'\','.$diem.')" '.$disabled.'>
                        Chi Tiết
                    </button>
                </td>
            </tr>
            ';
        }
        return $result;
    }

    public static function showDetailstestscores($listAnswer,$baiLam){
        $html='';
        $soCaudung=0;
        $soCausai=0;
        $soCauchualam=0;
        $test=0;
        while ($row = mysqli_fetch_array($baiLam)){
            if($row['dapAnChon']==''){
                $soCauchualam++;
                $html.=
                '
                <div class="hstack gap-3 mb-2 bg-secondary bg-opacity-25 text-black p-3">
                    <div class="fs-4 fw-bold">Câu '.$row['maCau'].':</div>
                    <div class="ms-auto fs-7 fw-bold" style="width: 3rem;">Chưa làm</div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-question-lg" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M4.475 5.458c-.284 0-.514-.237-.47-.517C4.28 3.24 5.576 2 7.825 2c2.25 0 3.767 1.36 3.767 3.215 0 1.344-.665 2.288-1.79 2.973-1.1.659-1.414 1.118-1.414 2.01v.03a.5.5 0 0 1-.5.5h-.77a.5.5 0 0 1-.5-.495l-.003-.2c-.043-1.221.477-2.001 1.645-2.712 1.03-.632 1.397-1.135 1.397-2.028 0-.979-.758-1.698-1.926-1.698-1.009 0-1.71.529-1.938 1.402-.066.254-.278.461-.54.461h-.777ZM7.496 14c.622 0 1.095-.474 1.095-1.09 0-.618-.473-1.092-1.095-1.092-.606 0-1.087.474-1.087 1.091S6.89 14 7.496 14Z" />
                    </svg>
                </div>
                ';
            }else{
                // $test++;
                foreach($listAnswer as $answer){
                    if($row['maCau']==$answer['maCau']){
                        if($row['dapAnChon']==$answer['dapAn']){
                            $soCaudung++;
                            $html.=
                            '
                            <div class="hstack gap-3 mb-2 bg-success bg-opacity-25 text-black p-3">
                                <div class="fs-4 fw-bold">Câu '.$row['maCau'].':</div>
                                <div class="ms-auto fs-5 fw-bold" style="width: 3rem;">'.$row['dapAnChon'].'</div>
                                <!-- icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                </svg>
                            </div>
                            ';
                        }else{
                            $soCausai++;
                            $html.=
                            '
                            <div class="hstack gap-3 mb-2 bg-danger bg-opacity-25 text-black p-3">
                            <div class="fs-4 fw-bold">Câu '.$row['maCau'].':</div>
                            <div class="ms-auto fs-5 fw-bold" style="width: 3rem;">'.$row['dapAnChon'].'</div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z" />
                                <path fill-rule="evenodd" d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z" />
                            </svg>
                        </div>
                            ';
                        }
                    }
                }
            }
        }
        $result['html']=$html;
        $result['soCausai']=$soCausai;
        $result['soCaudung']=$soCaudung;
        $result['soCauchualam']=$soCauchualam;
        // $result['test']=$test;
        return $result;
    }
}
