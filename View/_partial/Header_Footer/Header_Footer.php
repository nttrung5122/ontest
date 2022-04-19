<?php
function head()
{
    echo '<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <!-- cần bổ sung -->
                    <img src="logo.png" alt="Avatar Logo" style="width:40px;" class="rounded-pill">
                </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                <div class="collapse navbar-collapse d-lg-inline-flex flex-row-reverse" id="navbarSupportedContent">
                    <ul class="navbar-nav gap-5" style="margin-right: 100px;">
                        <li class="nav-item">
                            <a class="nav-link fs-4 text-nowrap" href="#">Giới Thiệu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fs-4 text-nowrap" href="#">Liên Lạc</a>
                        </li>
                        <button type="button" class="btn btn-success col-3 shadow fs-5">Đăng nhập</button>
                        <button type="button" class="btn btn-outline-warning col-3 shadow fs-5" data-bs-toggle="modal" data-bs-target="#form_signUp" >Đăng ký</button>
                    </ul>
                </div>
            </div>
        </nav>';
}
function footer()
{
    echo '<div class="row p-5" style="background-color: #82dda5; margin-right:0px">
            <div class="col-3 m-auto">
                <a class="navbar-brand" href="#">
                <!-- cần bổ sung -->
                <img src="logo.png" alt="Avatar Logo" style="width:40px;" class="rounded-pill">
                </a>
                <!-- cần bổ sung -->
                <p> &copy;copyright 2022 .... All Rights Reserved</p>
            </div>
            <div class="col-3 m-auto ps-5">
                <h5>Email</h5>
                <!-- cần bổ sung -->
                <p>...@gmail.com</p>
                <h5>Địa chỉ</h5>
                <p>273 An D. Vương, Phường 3, Quận 5, Thành phố Hồ Chí Minh</p>
            </div>
            <div class="col-3 m-auto text-center">
                <h5>Thông tin</h5>
                <a class="nav-link link-dark" href="#">Giới Thiệu</a>
                <a class="nav-link link-dark" href="#">Liên Lạc</a>
            </div>
        </div>';
}