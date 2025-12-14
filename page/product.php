<?php 
$cate1 = dd_q("SELECT * FROM category WHERE id = ? and of != 0 LIMIT 1", [$_GET['cate']]);
$cate = $cate1->fetch(PDO::FETCH_ASSOC);
if ($cate['id'] == ($_GET['cate'])) {

if (!isset($_GET['cate'])) : 
// echo "<script>window.location.href = '?page=home';</script>";
?>

<div class="mt-2 px-5 py-3">
<div class="flex mb-4">
  <div class="w-3/4 h-12">
  <p class="text-xl px-2 py-2 bg-main text-left">รายการสินค้าทั้งหมด</p>
  </div>
  <div class="w-1/4 h-12 text-right">
  <p class="text-lg px-2 py-2 bg-<?php echo $config['bgcolor'];?> rounded-xl text-center <?php echo $config['textcolor'];?>">เพิ่มเติม</p>
  
  </div>
</div>

<div class="justify-center grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-3 transition-transform duration-300 ease-in-out ">
   <?php $find = dd_q("SELECT * FROM category ORDER BY id ASC ");
        while ($row = $find->fetch(PDO::FETCH_ASSOC)) {
            // $stock = dd_q("SELECT * FROM box_stock WHERE p_id = ? ORDER BY id ASC", [$row["id"]]);
            // $count = $stock->rowCount();
            ?>  
            <div class="border rounded-xl px-4 py-4">

<img src="<?php echo $row["img"];?>" class="border text-center item-center w-full mb-2 transition duration-300 ease-in-out transform hover:scale-105 hover:grayscale" style="border-radius:2vh;">
        
<p><?php echo $row["name"];?></p>

<a href="?page=product&cate=<?php echo $row["id"];?>"><button class="btnslide bg-gray-100 px-2 py-2 mt-2 mb-1"><i class="fa-solid fa-circle-check"></i>&nbsp;สั่งซื้อสินค้า</button></a>

</div>
            <?php } ?>
          
  
</div>

</div>

    <?php else : ?>
        
        <div class="grid justify-items-end">
        <button class="px-2 py-2 bg-red-400 text-end rounded-xl mb-2 text-white" onclick="history.back()">
        <i class="fa-regular fa-circle-chevron-left"></i> ย้อนกลับ
        </button>
        </div>


<div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-2xl">
  <div class="md:flex">
    <div class="md:shrink-0">
    <img src="<?php echo $cate['img'];?>" class="h-48 w-full object-cover md:h-full md:w-64" style="border-radius:2vh;" data-aos="fade-right">
    </div>
    <div class="p-8" style="word-wrap: break-word; word-break: break-word; overflow-wrap: break-word;" data-aos="fade-left">
      <div class="uppercase tracking-wide text-lg text-main font-semibold"><?php echo $cate['name'];?></div>
      <p class="mt-1 text-slate-500 text-sm" style="word-wrap: break-word; word-break: break-word; overflow-wrap: break-word;"><?php echo nl2br($cate['des']);?></p>
    </div>
  </div>
</div>





<div class="justify-center grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 transition-transform duration-300 ease-in-out px-3 py-3">
   <?php 
        $find = dd_q("SELECT * FROM box_product WHERE c_type = ? and of = 1 ORDER BY id ASC", [$_GET['cate']]);
            while ($row = $find->fetch(PDO::FETCH_ASSOC)) {
            $stock = dd_q("SELECT * FROM box_stock WHERE p_id = ? ORDER BY id ASC", [$row["id"]]);
            $count = $stock->rowCount();
            ?> 
<?php if($count != 0) {;?>
<div class="border-1 hover:border-<?php echo $config['bgcolor'];?> rounded-xl px-4 py-4 text-center shadow-sm" 
     data-id="<?php echo $row['id']; ?>" 
     data-name="<?php echo $row['name']; ?>" 
     data-price="<?php echo $row['price']; ?>" 
     data-des="<?php echo nl2br($row['des']); ?>" 
     onclick="showDetail(this)">
     <p class="text-xl text-main"><?php echo $row["name"];?></p>

<?php if($user['rank'] == 0) {;?>
<p class="text-lg text-gray-500">ราคา <?php echo $row["price"];?> บาท</p>
<?php } else {?>
    <span class="text-sm text-gray-400">จากปกติ <del class="text-red-500 text-sm"> <?php echo $row["price"];?></del> บาท</span>
<p class="text-lg text-gray-500">ราคา <?php echo $row["pricevip"];?> บาท</p>
<?php } ?>
     <?php } else { ?>
        <div class="bg-gray-300 rounded-xl px-4 py-4 text-center shadow-sm">
        <p class="text-xl text-gray-500"><?php echo $row["name"];?></p>
        <?php if($user['rank'] == 0) {;?>
<p class="text-lg text-gray-500">ราคา <?php echo $row["price"];?> บาท</p>
<?php } else {?>
    <span class="text-sm text-gray-400">จากปกติ <del class="text-red-500 text-sm"> <?php echo $row["price"];?></del> บาท</span>
<p class="text-lg text-gray-500">ราคา <?php echo $row["pricevip"];?> บาท</p><?php } ?>
        <?php } ?>

</div>
            <?php } ?>
</div>



<div class="px-2 py-2" class="hidden" >
    <div class="px-2 py-2" id="showDetailproduct">
    </div>
</div>



<div class="col-start-1 col-end-7 text-center " style="margin-bottom: 10px;">

    <button onclick="BuyProduct()" class="px-3 py-2 bg-<?php echo $config['bgcolor'];?> w-100 rounded-xl btnslide <?php echo $config['textcolor'];?>">
    เลือกสินค้าก่อนชำระเงิน
    </button>
</div>

<?php endif ?>
<?php } else { echo "<script>window.location.href = '?page=home';</script>"; ?>
<?php } ?>
<br><br><div class="px-10 py-10"></div>




<script>
    
let Product_id = null; 
let Product_name = null; 

function showDetail(element) {
    const id = element.getAttribute("data-id");
    const name = element.getAttribute("data-name");
    const price = element.getAttribute("data-price");
    const des = element.getAttribute("data-des");
    Product_id = id;
    Product_name = name;
    const detailSection = document.getElementById("showDetailproduct");
    detailSection.innerHTML = `
        <div class="flex justify-between text-center text-gray-500 mb-2">
            <div>ชื่อสินค้า</div>
            <div>${name}</div>
        </div>
        <div class="flex justify-between text-center text-gray-500 mb-2">
            <div>ราคา</div>
            <div>${price} บาท</div>
        </div>
        <p class="text-lg text-main font-bold">รายละเอียด</p>
        <div class="text-gray-500 mt-2 mb-2 text-sm">
            ${des}
        </div>
    `;
    detailSection.classList.remove("hidden");
}
function BuyProduct() {
    if (Product_id) {
        Swal.fire({
            title: "ยืนยันการสั่งซื้อ",
            text: `ยืนยันสั่งซื้อ ${Product_name} ?`,
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "ยืนยันการสั่งซื้อ",
            cancelButtonText: "ยกเลิก"
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData();
                formData.append("product_id", Product_id);
                $.ajax({
                    type: 'POST',
                    url: 'system/buyproduct.php',
                    data: formData,
                    contentType: false,
                    processData: false,
                }).done(function(res) {
                    try {
                        const response = typeof res === "string" ? JSON.parse(res) : res;
                        if (response.status === "success") {
                            Swal.fire({
                                icon: 'success',
                                title: 'สำเร็จ',
                                text: response.msg
                            }).then(function() {
                                window.location.href = `?page=profile`;
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาด',
                                text: response.msg
                            });
                        }
                    } catch (e) {
                        Swal.fire({
                            icon: 'error',
                            title: 'ข้อผิดพลาด',
                            text: "รูปแบบการตอบกลับจากเซิร์ฟเวอร์ไม่ถูกต้อง"
                        });
                    }
                }).fail(function(err) {
                    Swal.fire({
                        icon: 'error',
                        title: 'ข้อผิดพลาด',
                        text: "ไม่สามารถติดต่อเซิร์ฟเวอร์ได้"
                    });
                });
            }
        });
    } else {
        Swal.fire({
            icon: 'warning',
            title: 'กรุณาเลือกสินค้า',
            text: "คุณยังไม่ได้เลือกสินค้าใดๆ"
        });
    }
}


</script>