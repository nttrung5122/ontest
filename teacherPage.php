<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/1f286772f7.js" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/dde1966e52.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <title>Giảng Viên</title>
    <style>
        .active {
            background-color: #198754 !important;
        }

        .nav-pills .nav-link:hover {
            background-color: #198754;
        }

        .scrollClass {
            height: 42vh;
            overflow-y: auto;
        }


        table thead,
        table tfoot {
            position: sticky;
        }

        table thead {
            inset-block-start: 0;
            /* "top" */
        }

        table tfoot {
            inset-block-end: 0;
            /* "bottom" */
        }
    </style>
    <script>
        var idTest;
        window.onload = function() {

            renderContainerbankquestion();
            // renderBankQuestion();


        };
        $(document).ready(function() {
            $("#class").on("click", "a", function(event) {
                $('#class').find('a.active').addClass('link-dark');
                $('#class').find('a.active').removeClass('active');
                $(this).addClass('active');
                $(this).removeClass('link-dark');
            });
            $('#tabs a').click(function() {
                $('#tabs').find('a.active').addClass('link-dark');
                $('#tabs').find('a.active').removeClass('active');
                $(this).addClass('active');
                $(this).removeClass('link-dark');
            });
            $('#btnRandomCode').click(function() {
                $("#txtIdClass").val(gen_Code(8));
            });
            $('#btnLogOut').click(function() {
                $.ajax({
                    type: 'POST',
                    url: "./Controller/controller.php",
                    data: {
                        act: 'logOut'
                    },
                    success: function(data) {
                        console.log(data);
                    }
                })
                window.location = './homePage.php';

            });
            $("#btnCreateClass").click(function() {
                let id = $("#txtIdClass").val().trim();
                let name = $("#txtNameClass").val().trim();
                let info = $("#txtInfoClass").val();
                if(name==''){
                    showNotice("Vui lòng nhập tên lớp");
                    return;
                }
                console.log(id);
                console.log(name);
                console.log(info);
                $.ajax({
                    type: "POST",
                    url: "./Controller/controller.php",
                    data: {
                        act: "createClass",
                        id: id,
                        name: name,
                        info: info,
                    },
                    success: function(data) {
                        console.log(data);
                        showNotice(JSON.parse(data)['notice']);
                        if (JSON.parse(data)['status'] == 'success') {
                            setTimeout(() => {
                                // window.location.reload();
                                $('.modal').modal('hide');
                                renderListclass();
                            }, 2000);

                        }
                    }
                })
            });
            $("#bankQuestion").click(function() {
                renderContainerbankquestion();
            });
            $("#btnRenderMember").click(function() {
                renderMember();
            });
            $('#btnCreateTest').click(function() {
                let thoiGianLamBai = $('#thoiGianLamBai').val();
                let ngayThi = $('#ngayThi').val();
                let daoCauHoi = $('input[name="daoCauHoi"]:checked').val();
                let idClass = $("#idClassCurent").val();
                let nameTest = $('#txtNameTest').val();
                if(nameTest.trim()==""){
                    showNotice("Vui lòng nhập tên bài kiểm tra");
                    return ;
                }
                console.log(nameTest);
                console.log(thoiGianLamBai);
                console.log(ngayThi);
                console.log(daoCauHoi);
                console.log(idClass);
                $.ajax({
                    type: "POST",
                    url: "./Controller/controller.php",
                    data: {
                        act: 'createTest',
                        thoiGianLamBai: thoiGianLamBai,
                        nameTest: nameTest,
                        ngayThi: ngayThi,
                        daoCauHoi: daoCauHoi,
                        idClass: idClass,
                    },
                    success: function(data) {
                        console.log(data);
                        idTest = JSON.parse(data)['maDe'];
                        console.log(idTest);
                        showNotice(JSON.parse(data)['notice']);
                        setTimeout(() => {
                            $('.modal').modal('hide');
                            showSettingTest(JSON.parse(data)['maDe']);
                        }, 1000);
                    },
                })
            });
            $('#btnSaveQuestionInTest').click(function() {
                $.ajax({
                    type: "POST",
                    url: "./Controller/controller.php",
                    data: {
                        act: "saveQuestionInTest",
                        arrQuestion: JSON.stringify(questionArr),
                        // arrQuestion: arrQuestion,
                        idTest: idTest,
                    },
                    success: function(data) {
                        console.log(JSON.parse(data));
                        showNotice(JSON.parse(data)['notice']);
                        setTimeout(() => {
                            $('.modal').modal('hide');
                            renderListTest();
                        }, 1000);
                    }
                })
            });
            $('#btnTongQuan').click(function() {
                renderListTest();

            })
            $('#btnCreateQuestion').click(function() {
                createQuestion();
            })
            $('#btnAddstudent').click(function() {
                addListStudent();
            })

        });

        function addListStudent(){
            let listId=$("#txtListstudent").val();
            let sep = /\r\n|\n/;
            let arrayId=listId.split(sep);
            let idClass= $("#idClassCurent").val();
            console.log(arrayId);
            console.log(idClass);
            $.ajax({
                type: "POST",
                url : "./Controller/controller.php",
                data: {
                    act: "addListstudenttoclass",
                    arrayStudentId: JSON.stringify(arrayId),
                    idClass: idClass,
                },
                success: function(data) {
                    console.log(data);
                    showNotice(JSON.parse(data)['notice']);
                    renderInfoclass(idClass);
                }
            })
        }

        function createQuestion() {
            let noidung = $('#txtQuestion').val();
                let cauA = $('#txtCauA').val();
                let cauB = $('#txtCauB').val();
                let cauC = $('#txtCauC').val();
                let cauD = $('#txtCauD').val();
                let idGroup = $('#sltQuestionGroup').val();
                let dapAn = $('#sltAnswer').val();
                let tenNhom = $('#txtNewGroup').val();
                console.log(noidung);
                console.log(cauA);
                console.log(cauB);
                console.log(cauC);
                console.log(cauD);
                console.log(idGroup);
                console.log(dapAn);
                console.log(tenNhom);
                if (noidung == "") {
                    showNotice("Vui lòng nhập nội dung câu hỏi");
                    return;
                }
                if (cauA == "") {
                    showNotice("Vui lòng nhập nội dung đáp án A");
                    return;
                }

                if (cauB == "") {
                    showNotice("Vui lòng nhập nội dung đáp án B");
                    return;
                }

                if (cauC == "") {
                    showNotice("Vui lòng nhập nội dung đáp án C");
                    return;
                }

                if (cauD == "") {
                    showNotice("Vui lòng nhập nội dung đáp án D");
                    return;
                }
                if (idGroup == null) {
                    showNotice("Vui lòng chọn nhóm câu hỏi");
                    return;
                }
                if (idGroup == "newGroup" && tenNhom == "") {
                    showNotice("Vui lòng nhập tên nhóm muốn tạo");
                    return;
                }

                if (dapAn == null) {
                    showNotice("Vui lòng chọn đáp án");
                    return;
                }
                $.ajax({
                    type: "POST",
                    url: "./Controller/controller.php",
                    data: {
                        act: 'createQuestion',
                        noidung: noidung,
                        cauA: cauA,
                        cauB: cauB,
                        cauC: cauC,
                        cauD: cauD,
                        idGroup: idGroup,
                        tenNhom: tenNhom,
                        dapAn: dapAn,
                    },
                    success: function(data) {
                        showNotice(JSON.parse(data)['notice']);
                        renderBankQuestion();
                    }
                })
        }

        function renderMember(){
            let idClass = $("#idClassCurent").val();
                if (idClass == "")
                    return;

                $.ajax({
                    type: "POST",
                    url: "./Controller/controller.php",
                    data: {
                        act: 'renderMember',
                        idClass: idClass,
                    },
                    success: function(data) {
                        // console.log(data);
                        // console.log(JSON.parse(data));
                        $("#content").html(JSON.parse(data));
                        $("#right_content").html("");
                    }
                });
        }

        function deleteClass() {
            if (!confirm('Bạn có chắc muốn xóa lớp này'))
                return;
            let idClass = $("#idClassCurent").val();
            console.log(idClass);
            if (idClass == "")
                return;
            $.ajax({
                type: "POST",
                url: "./Controller/controller.php",
                data: {
                    act: 'deleteClass',
                    idClass: idClass
                },
                success: function(data) {
                    console.log(idClass);
                    console.log(data);
                    showNotice(JSON.parse(data)['notice']);
                    if (JSON.parse(data)['status'] == 'success') {
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    }
                }
            });
        }

        function renderContainerbankquestion() {
            $.ajax({
                type: "POST",
                url: "./Controller/controller.php",
                data: {
                    act: "renderContainerbankquestion",
                },
                success: function(data) {
                    // console.log(data);
                    $('#container').html(JSON.parse(data));
                }
            });
            renderBankQuestion();
            renderListclass();
            $('#tabs').find('a.menuClass').addClass('disabled');
        }

        function renderBankQuestion() {
            $.ajax({
                type: "POST",
                url: "./Controller/controller.php",
                data: {
                    act: "renderBankQuestion",
                },
                success: function(data) {
                    // console.log(data);
                    // console.log(JSON.parse(data)['question']);
                    $('#bangCauHoi').html(JSON.parse(data)['question']);
                    $('#sltGroupQuestion').html(JSON.parse(data)['groupQuestion']);
                }
            });
            $.ajax({
                type: "POST",
                url: "./Controller/controller.php",
                data: {
                    act: "renderSltGroupQuestion",
                },
                success: function(data) {
                    // console.log(data);
                    $('#sltQuestionGroup').html(JSON.parse(data));
                }

            });
        }



        function renderInfoTest(idTest) {
            console.log(idTest);
            $.ajax({
                type: "POST",
                url: "./Controller/controller.php",
                data: {
                    idTest: idTest,
                    act: "renderInfoTest",
                },
                success: function(data) {
                    // console.log(data);
                    $('#right_content').html(JSON.parse(data));
                }

            })
        }

        function renderSettingTest() {
            $.ajax({
                type: "POST",
                url: "./Controller/controller.php",
                data: {
                    act: 'renderQuestionInSettingTest',
                },
                success: function(data) {
                    // console.log(data);
                    $('#listQuestioninfrom').html(JSON.parse(data)['question']);
                    $('#sltGroupQuestionInFormCreateTest').html(JSON.parse(data)['groupQuestion']);
                }

            })
        }

        function renderListTest() {
            let idClass = $("#idClassCurent").val();
            console.log(idClass);
            $.ajax({
                type: "POST",
                url: "./Controller/controller.php",
                data: {
                    act: "renderListTest",
                    idClass: idClass,

                },
                success: function(data) {
                    // console.log(data);
                    $('#content').html(JSON.parse(data));
                }
            })
        }

        function renderListclass() {
            $.ajax({
                type: "POST",
                url: "./Controller/controller.php",
                data: {
                    act: 'renderListClass',
                },
                success: function(data) {
                    $("#class").html(JSON.parse(data));
                    // console.log(data);
                }
            });
        }

        function deleteTest(idTest) {
            if (!confirm('Bạn có chắc muốn xóa đề thi này'))
                return;
            $.ajax({
                type: "POST",
                url: "./Controller/controller.php",
                data: {
                    act: 'deleteTest',
                    idTest: idTest
                },
                success: function(data) {
                    // console.log(idClass);
                    // console.log(data);
                    showNotice(JSON.parse(data)['notice']);
                    if (JSON.parse(data)['status'] == 'success') {
                        setTimeout(() => {
                            renderListTest();
                            $('.modal').modal('hide');
                        }, 2000);
                    }
                }
            });
        }

        function showSettingTest(idTest) {
            renderSettingTest();
            $('#form_settingTest').modal('show');
        }

        function gen_Code(length, special) {
            let iteration = 0;
            let password = "";
            let randomNumber;
            if (special == undefined) {
                var special = false;
            }
            while (iteration < length) {
                randomNumber = (Math.floor((Math.random() * 100)) % 94) + 33;
                if (!special) {
                    if ((randomNumber >= 33) && (randomNumber <= 47)) {
                        continue;
                    }
                    if ((randomNumber >= 58) && (randomNumber <= 64)) {
                        continue;
                    }
                    if ((randomNumber >= 91) && (randomNumber <= 96)) {
                        continue;
                    }
                    if ((randomNumber >= 123) && (randomNumber <= 126)) {
                        continue;
                    }
                }
                iteration++;
                password += String.fromCharCode(randomNumber);
            }
            return password;
        }

        var infoClassCurent;

        function renderInfoclass(idClass) {
            $('#tabs').find('a.menuClass').removeClass('disabled');
            $('#tabs').find('a.active').addClass('link-dark');
            $('#tabs').find('a.active').removeClass('active');
            $('a[name="tongQuan"]').addClass('active');
            $('a[name="tongQuan"]').removeClass('link-dark');
            // $('#class').find('a.active').removeClass('active');
            // $('#class a').removeClass('link-dark');

            renderContainerInfoClass();
            $.ajax({
                type: "POST",
                url: "./Controller/controller.php",
                data: {
                    act: "getClassforteacher",
                    id: idClass,
                },
                success: function(data) {
                    data = JSON.parse(data);
                    console.log(data);
                    infoClassCurent = data;
                    $("#nameClass").html(data['tenLop']);
                    $("#infoClass").html(data['ThongTin']);
                    $("#idClass").html("Mã lớp: " + data['0']);
                    $("#soHs").html(data['soLuong']);
                    $("#idClassCurent").val(data['0']);
                    // console.log(data["soLuongbaikt"]);
                    $("#soBaikt").html(data["soLuongbaikt"]);
                    renderListTest();
                }
            })
        }

        function renderContainerInfoClass() {
            $.ajax({
                type: "POST",
                url: "./Controller/controller.php",
                data: {
                    act: "renderContainerInfoClass",
                },
                success: function(data) {
                    // console.log(data);
                    $('#container').html(JSON.parse(data));
                }
            })
        }

        function timCauhoi() {
            // tạo biến
            var input, filterByinput, filterByradio, table, tr, td, i, txtValue;
            input = document.getElementById("searchCauhoi");
            radio = document.getElementsByName("loaiCauhoi");
            filterByinput = input.value.toUpperCase();
            filterByradio = radio.value;
            console.log(filterByinput);
            table = document.getElementById("bangCauHoi");
            tr = table.getElementsByTagName("tr");

            // lọc câu hỏi
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filterByinput) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

        function timCauhoiRadio(loai) {
            console.log(loai.value);

            // tạo biến
            var filterByradio, table, tr, td, i, txtValue;

            radio = document.getElementsByName("loaiCauhoi");
            filterByradio = loai.value.toUpperCase();
            table = document.getElementById("bangCauHoi");
            tr = table.getElementsByTagName("tr");

            // lọc câu hỏi
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filterByradio) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
         function deleteStudent(idStudent){
            let idClass = $("#idClassCurent").val();
            $.ajax({
                type: "POST",
                url : "./Controller/controller.php",
                data: {
                    act : "removeStudentsfromclass",
                    mail:idStudent,
                    idClass: idClass,
                },
                success: function(data) {
                    console.log(data);
                    showNotice(JSON.parse(data)['notice']);
                    renderMember();
                }
            })
         }
         function showTest(idTest){
            //  console.log(idTest);
            let idClass = $("#idClassCurent").val();

            $.ajax({
                type: "POST",
                url : "./Controller/controller.php",
                data: {
                    act : "showTestscores",
                    idTest: idTest,
                    idClass: idClass,
                },
                success: function(data) {
                    // console.log(data);
                    $('#listTestscores').html(JSON.parse(data));
                    $('#formShowtestscores').modal('show');
                }
            })
         }

         function showDetails(idStudent,idTest,diem){
            $.ajax({
                type: "POST",
                url : "./Controller/controller.php",
                data: {
                    act: "showDetailstestscores",
                    idTest: idTest,
                    idStudent: idStudent,
                },
                success: function(data) {
                    // console.log(data);
                    console.log(JSON.parse(data));
                    $('#chiTietbailam').html(JSON.parse(data)['html']);
                    $('#soCaudung_formDetails').html(JSON.parse(data)['soCaudung']);
                    $('#soCausai_formDetails').html(JSON.parse(data)['soCausai']);
                    $('#soCauchualam_formDetails').html(JSON.parse(data)['soCauchualam']);
                    $('#diem_formDetails').html(diem);
                    $('#formShowtestscores').modal('hide');
                    $('#formShowdetailstestscores').modal('show');
                }
            })
         }

         function cancelShowdetails(){
             $('#formShowdetailstestscores').modal('hide');
             $('#formShowtestscores').modal('show');
         }
    </script>
</head>

<body>
    <!-- Header -->
    <?php require("./View/_partial/Header_Footer/Header_Footer.php");
    head($teacherPage);
    include "./View/form/form_create_class.php";
    include "./View/_partial/popup/notice.php";
    include "./View/form/taoCautrucde_windows.php";
    include "./View/testPage/testPage.php";
    include "./View/form/form_create_question.php";
    include "./View/hienThiDiem/hienThiDiem.php";
    include "./View/chiTietdiem/chitietdiem.php";
    include "./View/form/form_addStudent.php";
    ?>

    <!-- Side Navigation -->
    <div class="d-flex flex-column fixed-top flex-shrink-0 p-2 overflow-auto" style="height:93%; width: 280px; margin-top: 60.2px; background-color: #82dda5; z-index: 1;">
        <!-- Tính năng -->
        <?php require("./View/_partial/TeacherAndStudent_Component/Sidebar.php");
        Sidebar($teacherPage); ?>
        <!-- Danh sách lớp -->
        <span class="fs-3 fw-bold">Danh sách lớp</span>
        <ul id="class" class="nav nav-pills flex-column mb-5 border-top border-dark pt-2">

        </ul>
    </div>

    <!-- Content -->

    <div style="margin-left: 280px; margin-top: 0px;">
        <div class="row" style="margin-left: 0; margin-right: 0;" id="container">

        </div>
    </div>
</body>

</html>