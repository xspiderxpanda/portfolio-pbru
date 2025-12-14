<center>
        <h3 class="text-white mb-2">&nbsp;
            <span class="bg-stone-800 px-2 py-1 rounded-3xl"><i class="fa-duotone fa-browser text-green-300"></i></span>
            &nbsp;  อัปโหลดรูปภาพ</h3>
    </center>

                        <div class="px-2 py-2">
                       
                         <font color="red">*อัพโหลดได้เฉพาะ .jpeg , .jpg , .png </font>
                        
                         <input type="file" name="img_file" id="img_file" required   class="form-control" accept="image/jpeg, image/png, image/jpg"> 
                         
                        

                         
                        </div>
                         <button type="submit" id="upload_btn" class="bg-green-500 mt-2 w-100 mb-1 px-2 py-2 p-3 rounded-lg">Upload File</button>
                        <br>
                        <br>
                    <table class="table table-striped  table-hover table-responsive table-bordered" id="table">
                        <thead class="text-center">
                            <tr>
                                <th scope="col" class="text-center" >#</th>
                                <th scope="col" class="text-center">Image</th>
                                <th scope="col" class="text-center">Copy</th>
                                <th scope="col" class="text-center">Delete</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php
                          
                $q = dd_q("SELECT * FROM tbl_uploads");
            while($k = $q->fetch(PDO::FETCH_ASSOC)){
                            ?>
                            <tr>
                                <td><?= $k['no'];?></td>
                                <td class="text-center"><center><img src="upload/<?= $k['img_file'];?>" width="95px;" class="text-center"></center></td>
                                <td>

                                <input type="text" class="form-control text-center " value="<?php echo "https://", $_SERVER["SERVER_NAME"]; ?>/upload/<?php echo $k['img_file']; ?>" id="myInput_<?= $k['no']; ?>">                                   
                                    <button class="btn btn-success px-2 py-2 mt-2 mb-1" onclick="Copyfunc('myInput_<?= $k['no']; ?>')">COPY URL</button>
                                </td>
                                <td><button class="btn btn-danger mt-1 mb-1 px-3 py-3" onclick="del('<?php echo $k['no']; ?>')">DELETE</button></td>
                                 

                                 <script>
    function Copyfunc(inputId) {
        var copyText = document.getElementById(inputId); // ใช้ inputId ที่ส่งมา
        copyText.select();
        copyText.setSelectionRange(0, 99999); // เลือกข้อความทั้งหมด
        document.execCommand("copy");

        Swal.fire(
            'สำเร็จ',
            'คัดลอกลิ้งค์รูปภาพเรียบร้อย',
            'success'
        );
    }
</script>       
                            <?php } ?>
                        </tbody>
                    </table>
                    <br>
          


<script>
$(document).ready(function() {
    $("#upload_btn").click(function(event) {
        event.preventDefault();
        var formData = new FormData();
        formData.append('img_name', $("#img_name").val());
        formData.append('img_file', $("#img_file")[0].files[0]);
        $.ajax({
            type: 'POST',
            url: 'system/backend/upload.php',
            data: formData,
            contentType: false,
            processData: false,
        }).done(function(res) {
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ',
                text: res.message
            }).then(function() {
                window.location = "?page=<?php echo $_GET['page'];?>";
            });
        }).fail(function(jqXHR) {
            var res = jqXHR.responseJSON || { message: 'เกิดข้อผิดพลาด' };
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: res.message
            });
        });
    });
});
</script>
<script type="text/javascript">
   $(document).ready(function () {
        $('#table').dataTable( {
        "order": [[ 0, "desc" ]]
} );
    });
    function del(img_id) {
    Swal.fire({
        title: 'ยืนยันที่จะลบ?',
        text: "คุณแน่ใจหรือว่าจะลบรูปภาพ หมายเลข : " + img_id,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ลบเลย'
    }).then((result) => {
        if (result.isConfirmed) {
            var formData = new FormData();
            formData.append('id', img_id);
            $.ajax({
                type: 'POST',
                url: 'system/backend/upload_del.php',
                data: formData,
                contentType: false,
                processData: false,
            }).done(function(res) {
                 result = res;
                Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ',
                    text: result.message
                }).then(function() {
                    window.location = "?page=<?php echo $_GET['page']; ?>";
                });
            }).fail(function(jqXHR) {
                console.log(jqXHR);
                res = jqXHR.responseJSON;
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    text: res.message
                });
            });
        }
    });
}

</script>
