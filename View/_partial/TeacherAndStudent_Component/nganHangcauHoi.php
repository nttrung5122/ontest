<div class="col-sm-12 mt-3 px-5">
    <!-- Bự quá chỉnh lại col-8 -->
    <!-- Ngân hàng câu hỏi -->
    <div class="p-3 pb-5 border">
        <div class="d-flex justify-content-end">
            <button class="btn btn-primary">Tạo câu hỏi</button>
        </div>
        <!-- Script and sytle for Ngân Hàng Câu hỏi -->
        <script>
            function timCauhoi() {
                // tạo biến
                var input, filterByinput, filterByradio, table, tr, td, i, txtValue;
                input = document.getElementById("searchCauhoi");
                radio = document.getElementsByName("loaiCauhoi");
                filterByinput = input.value.toUpperCase();
                filterByradio = radio.value;
                table = document.getElementById("bangCauhoi");
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
                table = document.getElementById("bangCauhoi");
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
            // tạo mảng câu hỏi đã chọn
            var questionArr = [];

            function taoMangcauhoi(macauhoi) {
                // console.log(macauhoi);
                var checkBox = document.getElementById(macauhoi);
                if (checkBox.checked == true) {
                    questionArr.push(macauhoi);
                } else {
                    for (let i = 0; i < questionArr.length; i++) {
                        if (questionArr[i] == macauhoi) {
                            questionArr.splice(i, 1);
                        }
                    }
                }
                // console.log(questionArr);
            }
        </script>
        <?php include './View/_partial/testPage/themCauhoi_vaoTable.php'; ?>
        <style>
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
        <div class="row align-items-start">
            <div class="text-center fw-bold fs-2 mb-3">Ngân hàng câu hỏi</div>
            <div class="col">
                <!-- select chọn thể loại (nhóm câu hỏi) -->
                <select class="form-select" aria-label="Loại câu hỏi" onchange="timCauhoiRadio(this)">
                    <option hidden value="" selected>Loại câu hỏi</option>
                    <option value="">Tất cả</option>

                    <option value="Nông nghiệp">Nông nghiệp</option>
                    <option value="Công nghệ thông tin">Công nghệ thông tin</option>
                    <option value="Hài hước">Hài hước</option>
                </select>
            </div>
            <!-- Filter lọc tìm câu hỏi -->
            <div class="col-sm-6">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="timCauhoi"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg></span>
                    <input type="text" class="form-control" placeholder="Tìm câu hỏi" aria-label="searchCauhoi" aria-describedby="timCauhoi" id="searchCauhoi" onkeyup="timCauhoi()">
                </div>
            </div>
        </div>
        <!-- Bảng câu hỏi -->
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="bangCauhoi">
                <thead class="table-light">
                    <tr>
                        <th scope="col" width="9%">Mã</th>
                        <th scope="col" width="70%">Câu hỏi</th>
                        <th scope="col" width="22%">Loại</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Luôn đặt các mô đun bên dưới thẻ này -->
                    <?php
                    themcauhoiModules::themCauhoi_NoCheckBox(1, 'Bò không ăn cỏ', 'Nông nghiệp');
                    themcauhoiModules::themCauhoi_NoCheckBox(2, 'Gạch và đá', 'Xây dựng');
                    themcauhoiModules::themCauhoi_NoCheckBox(3, 'Java là gì?', 'Công nghệ thông tin');
                    themcauhoiModules::themCauhoi_NoCheckBox(4, 'Có 1 đàn chim đậu trên cành, người thợ săn bắn cái rằm. Hỏi chết mấy con?', 'Hài hước');

                    ?>
                </tbody>
            </table>
        </div>

        <!-- nút -->
        <!-- <div class="d-grid gap-2 col-2">
            <button class="btn btn-primary mt-3" type="button" style="margin-right:0;">Lưu lại</button>
        </div> -->
    </div>
</div>