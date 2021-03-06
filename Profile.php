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
    <title>Profile</title>
    <style>
        .list-group-item:hover {
            background-color: whitesmoke;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('#btnLogOut').click(function() {
                $.ajax({
                    type: 'POST',
                    url: "./Controller/controller.php",
                    data: {
                        act: 'logOut'
                    },
                    success: function(data) {
                        // console.log(data);
                    }
                });
                window.location = './index.php';

            });
            $('#saveBasic').click(function() {
                var name = $('#name').val();
                var birth = $('#birth').val();
                $.ajax({
                    type: 'POST',
                    url: "./Controller/controller.php",
                    data: {
                        act: 'saveBasic',
                        name: name,
                        birth: birth,
                    },
                    success: function(data) {
                        data = JSON.parse(data);
                        $('#showName').html(data['hoten']);
                        $('#showBirth').html(data['ngaysinh']);
                        $('#name').val('');
                        $('#birth').val('');
                    }
                });
            });
            $('#saveContact').click(function() {
                var phone = $('#phone').val();
                if (!checkSdt(phone)) {
                    showNotice('S??? ??i???n tho???i c???a b???n kh??ng ????ng ?????nh d???ng!');
                    return false;
                }
                $.ajax({
                    type: 'POST',
                    url: "./Controller/controller.php",
                    data: {
                        act: 'saveContact',
                        phone: phone,
                    },
                    success: function(data) {
                        data = JSON.parse(data);
                        $('#showPhone').html(data['sdt']);
                        $('#phone').val('');
                    }
                });
            });
            $('#savePass').click(function() {
                var pass1 = $('#pass1').val();
                var pass2 = $('#pass2').val();
                if (!checkPass(pass1)) {
                    showNotice('M???t kh???u kh??ng ???????c ch???a k?? t??? ?????t bi???t v?? ph???i h??n 8 k?? t???');
                    return false;
                }
                if (pass1 != pass2) {
                    showNotice("M???t kh???u kh??ng kh???p vui l??ng nh???p l???i");
                    return false;
                }
                $.ajax({
                    type: 'POST',
                    url: "./Controller/controller.php",
                    data: {
                        act: 'savePass',
                        password: pass1,
                    },
                    success: function(data) {
                        $('#pass1').val('');
                        $('#pass2').val('');
                        showNotice("Thay ?????i m???t kh???u th??nh c??ng");
                    }
                });
            });
        });

        function checkPass(pass) {
            let pass_regex = /^[a-zA-Z0-9]{8,}$/;
            return pass_regex.test(pass);
        }

        function checkSdt(sdt) {
            var vnf_regex = /((09|03|07|08|05)+([0-9]{8})\b)/g;
            return vnf_regex.test(sdt);
        }
    </script>
</head>

<body>
    <!-- Header -->
    <?php
    include "./View/_partial/popup/notice.php";
    require("./View/_partial/Header_Footer/Header_Footer.php");
    head($profile);
    ?>

    <!-- Content -->
    <div class="container p-5" style="margin-top:80px;">
        <!-- Title -->
        <h3 class="text-center">Th??ng tin c?? nh??n</h3>
        <p class="text-center">Th??ng tin v??? b???n v?? c??c l???a ch???n ??u ti??n c???a b???n tr??n c??c d???ch v??? c???a OnTest</p>

        <!-- Description -->
        <div class="row">
            <div class="col-md-6 pt-5">
                <h2>Th??ng tin trong h??? s?? c???a b???n tr??n OnTest</h2>
                <p>Th??ng tin c?? nh??n v?? c??c t??y ch???n gi??p qu???n l?? th??ng tin ????. B???n c?? th??? cho ph??p ng?????i kh??c nh??n th???y m???t s??? d??? li???u c???a th??ng tin n??y (ch???ng h???n nh?? th??ng tin li??n h???) ????? h??? c?? th??? d??? d??ng li??n h??? v???i b???n. B???n c??ng c?? th??? xem th??ng tin t??m t???t v??? c??c h??? s?? c???a m??nh.</p>
            </div>
            <div class="col-md-6">
                <img src="./Assets/img/Indentity.jpg" alt="" style="width: 500px" class="float-end rounded" />
            </div>
        </div>

        <div class="container d-flex justify-content-center mt-5">
            <div class="card shadow" style="width: 50rem;">
                <div class="card-body">
                    <h5 class="card-title ms-1">Th??ng tin c?? b???n</h5>
                    <h6 class="card-subtitle mb-2 ms-1 text-muted">M???t s??? th??ng tin c?? th??? hi???n th??? cho nh???ng ng?????i kh??c</h6>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <div class="row" style="transform: rotate(0);">
                                <div class="col-md-3">
                                    <p class="text-muted">M?? c?? nh??n</p>
                                </div>
                                <div class="col-md-8">
                                    <p id="showName" class="fw-bold"><?php echo $_SESSION['user']['maCanhan']; ?> </p>
                                </div>
                                <div class="col-md-1">
                                    <i class="fas fa-angle-right"></i>
                                </div>
                                <!-- <a class="stretched-link" data-bs-toggle="collapse" href="#info1" role="button" aria-expanded="false" aria-controls="info1"></a> -->
                            </div>
                            <!-- <div class="collapse multi-collapse" id="info1">
                                <input id="name" type="text" class="form-control" placeholder="Nh???p t??n m???i">
                            </div> -->
                        </li>
                        <li class="list-group-item">
                            <div class="row" style="transform: rotate(0);">
                                <div class="col-md-3">
                                    <p class="text-muted">T??n</p>
                                </div>
                                <div class="col-md-8">
                                    <p id="showName" class="fw-bold"><?php echo $_SESSION['user']['hoten']; ?> </p>
                                </div>
                                <div class="col-md-1">
                                    <i class="fas fa-angle-right"></i>
                                </div>
                                <a class="stretched-link" data-bs-toggle="collapse" href="#info1" role="button" aria-expanded="false" aria-controls="info1"></a>
                            </div>
                            <div class="collapse multi-collapse" id="info1">
                                <input id="name" type="text" class="form-control" placeholder="Nh???p t??n m???i">
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row" style="transform: rotate(0);">
                                <div class="col-md-3">
                                    <p class="text-muted">Ng??y sinh</p>
                                </div>
                                <div class="col-md-8">
                                    <p id="showBirth" class="fw-bold"><?php echo $_SESSION['user']['ngaysinh']; ?></p>
                                </div>
                                <div class="col-md-1">
                                    <i class="fas fa-angle-right"></i>
                                </div>
                                <a class="stretched-link" data-bs-toggle="collapse" href="#info2" role="button" aria-expanded="false" aria-controls="info2"></a>
                            </div>
                            <div class="collapse multi-collapse" id="info2">
                                <input id="birth" type="date" class="form-control">
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row" style="transform: rotate(0);">
                                <div class="col-md-3">
                                    <p class="text-muted">Ch???c v???</p>
                                </div>
                                <div class="col-md-8">
                                    <p class="fw-bold"><?php
                                                        if ($_SESSION['user']['loaiTk'] == 'gv') {
                                                            echo 'Gi???ng vi??n';
                                                        } else if ($_SESSION['user']['loaiTk'] == 'sv') {
                                                            echo 'Sinh vi??n';
                                                        } else {
                                                            echo 'Admin';
                                                        }
                                                        ?></p>
                                </div>
                                <div class="col-md-1">
                                    <i class="fas fa-angle-right"></i>
                                </div>
                                <!-- <a class="stretched-link" data-bs-toggle="collapse" href="#info3" role="button" aria-expanded="false" aria-controls="info3"></a> -->
                            </div>
                            <!-- <div class="collapse multi-collapse" id="info3">
                                <input type="text" class="form-control" placeholder="Nh???p ch???c v??? m???i">
                            </div> -->
                        </li>
                    </ul>
                    <div class="d-flex justify-content-end my-3">
                        <button id="saveBasic" class="btn btn-primary px-4">L??u</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="container d-flex justify-content-center mt-5">
            <div class="card shadow" style="width: 50rem;">
                <div class="card-body">
                    <h5 class="card-title ms-1">Th??ng tin li??n h???</h5>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <div class="row" style="transform: rotate(0);">
                                <div class="col-md-3">
                                    <p class="text-muted">Email</p>
                                </div>
                                <div class="col-md-8">
                                    <p class="fw-bold"><?php echo $_SESSION['user']['mail']; ?></p>
                                </div>
                                <div class="col-md-1">
                                    <i class="fas fa-angle-right"></i>
                                </div>
                                <!-- <a class="stretched-link" data-bs-toggle="collapse" href="#info4" role="button" aria-expanded="false" aria-controls="info4"></a> -->
                            </div>
                            <!-- <div class="collapse multi-collapse" id="info4">
                                <input type="email" class="form-control" placeholder="Nh???p email m???i">
                            </div> -->
                        </li>
                        <li class="list-group-item">
                            <div class="row" style="transform: rotate(0);">
                                <div class="col-md-3">
                                    <p class="text-muted">??i???n tho???i</p>
                                </div>
                                <div class="col-md-8">
                                    <p id="showPhone" class="fw-bold"><?php echo $_SESSION['user']['sdt']; ?></p>
                                </div>
                                <div class="col-md-1">
                                    <i class="fas fa-angle-right"></i>
                                </div>
                                <a class="stretched-link" data-bs-toggle="collapse" href="#info5" role="button" aria-expanded="false" aria-controls="info5"></a>
                            </div>
                            <div class="collapse multi-collapse" id="info5">
                                <input id="phone" type="tel" class="form-control" placeholder="Nh???p s??? ??i???n tho???i m???i">
                            </div>
                        </li>
                    </ul>
                    <div class="d-flex justify-content-end my-3">
                        <button id="saveContact" class="btn btn-primary px-4">L??u</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="container d-flex justify-content-center mt-5">
            <div class="card shadow" style="width: 50rem;">
                <div class="card-body">
                    <h5 class="card-title ms-1">M???t kh???u</h5>
                    <h6 class="card-subtitle mb-2 ms-1 text-muted">M???t m???u kh???u an to??n gi??p b???o v??? t??i kho???n OnTest c???a b???n</h6>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <div class="row" style="transform: rotate(0);">
                                <div class="col-md-3">
                                    <p class="text-muted">M???t kh???u</p>
                                </div>
                                <div class="col-md-8">
                                    <p class="fw-bold fs-3" style="margin:0; line-height:0.5;">...................</p>
                                </div>
                                <div class="col-md-1">
                                    <i class="fas fa-angle-right"></i>
                                </div>
                                <a class="stretched-link" data-bs-toggle="collapse" href="#info6" role="button" aria-expanded="false" aria-controls="info6"></a>
                            </div>
                            <div class="collapse multi-collapse" id="info6">
                                <input id="pass1" type="password" class="form-control" placeholder="Nh???p m???t kh???u m???i">
                                <input id="pass2" type="password" class="form-control mt-2" placeholder="Nh???p l???i m???t kh???u m???i">
                            </div>
                        </li>
                    </ul>
                    <div class="d-flex justify-content-end my-3">
                        <button id="savePass" class="btn btn-primary px-4">L??u</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php footer() ?>
</body>

</html>