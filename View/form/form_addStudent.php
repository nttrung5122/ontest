<!-- 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->

<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#formAddstudent">
            ' . $label . '
        </button> -->

<div class="modal fade" id="formAddstudent" tabindex="-1" aria-labelledby="popupLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="popupLabel">Thêm học sinh vào lớp</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Nội dung của pop-up -->
            <div class="modal-body">
                <div class="form-floating">
                    <textarea class="form-control" placeholder="Nhập tài khoản học sinh tại đây" id="txtListstudent" style="height: 100px"></textarea>
                    <label for="floatingTextarea2">Danh sách tài khoản</label>
                </div>
            </div>
            <div class="modal-footer">
                <!-- data-bs-dismiss="modal" - đóng cửa sổ popup -->
                <button type="button" class="btn btn-primary" id="btnAddstudent">Thêm</button>
            </div>
        </div>
    </div>
</div>