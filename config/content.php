<?php
if($_SESSION['user_language'] == 'th'){
    /*##### MENU #####*/
    define('MENU0','Dashboard');
    define('MENU1','การจัดซื้อ');
    define('MENU1_1','ใบสั่งซื้อ');
    define('MENU1_2','รายการผู้ขาย');
    define('MENU1_3','รายการรับสินค้า');

    define('MENU2','การขาย');
    define('MENU2_1','ใบสั่งขาย');
    define('MENU2_2','รายการลูกค้า');
    define('MENU2_3','รายกการสินค้า');
    define('MENU2_4','รายการราคาสินค้า');
    define('MENU2_5','ขายสด');
    define('MENU2_6','ใบแจ้งหนีั');
    define('MENU2_7','รับคืน,ลดหนี้');
    define('MENU2_8','เพิ่มหนี้');
    define('MENU2_9','ใบส่งของ');
    define('MENU2_10','ใบสั่งผลิต');


    define('MENU3','จัดการสินค้า');
    define('MENU3_1','รายการสินค้าคงคลัง');
    define('MENU3_2','รายการหมวดหมู่');
    define('MENU3_3','รายการหมวดหมู่ย่อย');
    define('MENU3_4','รายการสิ่งของ');
    define('MENU3_5','รายการ FDA');
    define('MENU3_6','รายการหน่วยนับ');
    define('MENU3_6','ปรับปรุงสินค้าคงคลัง');

    define('MENU4','รายงาน');

    define('MENU5','ตั้งค่า');
    define('MENU5_1','ตั้งค่าบริษัท');
    define('MENU5_2','ตั้งค่าเลขที่เอกสาร');
    define('MENU5_3','ตั้งค่าตำแหน่งที่ตั้ง');
    define('MENU5_4','ล๊อต');
    define('MENU5_5','Payment Terms');
    

    define('MENU6','จัดการระบบ');
    define('MENU6_1','ผู้ใช้งาน');
    define('MENU6_2','บริษัท');

    /*##### BUTTON #####*/
    define('BTN_NEW','สร้างใหม่');
    define('BTN_DELETE','ลบ');
    define('BTN_EDIT','แก้ไข');
    define('BTN_COPY','คัดลอก & สร้างใหม่');
    define('BTN_EXPORT','ส่งออก');
    define('BTN_IMPORT','นำเข้า');
    define('BTN_PRINT','พิมพ์');
    define('BTN_POST','ผ่านรายการ');
    define('BTN_DISCARD','กลับ');
    define('BTN_YES','ตกลง');
    define('BTN_CANCEL','ยกเลิก');
    define('BTN_SELECT','เลือก');
    define('BTN_ACTION','ดำเนินการ');
    define('BTN_ASSIGN','ขอคำขออนุมัติ');
    define('BTN_ATTACH','ไฟล์แนบ');
    define('BTN_GETBYSO','สร้างจากใบสั่งขาย');
    define('BTN_UPDATE','อัปเดต');
    define('BTN_CREATEWO','สร้างใบสั่งผลิต');
    define('BTN_CRE_CN','สร้างใบลดหนี้');
    define('BTN_CRE_DN','สร้างใบเพิ่มหนี้');
    define('BTN_GETBYPO','รับสิ้นค้าจากใบสั่งซื้อ');
    define('BTN_REPASS','รีเซ็ตรหัสผ่าน');
    define('BTN_SHOW','แสดงทั้งหมด');
    define('BTN_SELECTALL','เลือกทั้งหมด');

    /*##### CONTENT #####*/
    define('ALERT','แจ้งเตือน');
    define('CODE','รหัส');
    define('MESSAGE','ข้อความ');
    define('CHANGEPASS','เปลี่ยนรหัสผ่าน');
    define('CHANGECOMPANY','เปลี่ยนบริษัท');
    define('SERIESNO','หมายเลขซีรีส์');
    define('CUSTOMER','ลูกค้า');
    define('SUPPLIER','ผู้ชาย');
    define('UPLOAD','อัพโหลดไฟล์');
    define('SIGNOUT','ออกจากระบบ');
    define('MESSAGE1','อัปเดตเรียบร้อยแล้ว');
    define('MESSAGE2','คุณต้องการลบรายการ');
    define('MESSAGE3','คุณต้องการเปลี่ยนรหัสผ่าน');
    define('MESSAGE4','คุณต้องการออกจากระบบ');
    define('MESSAGE5','หมายเลขซีรีส์นี้มีอยู่แล้ว โปรดตรวจสอบ');
    define('MESSAGE6','ค่านี้ต้องไม่เป็นค่าว่าง โปรดตรวจสอบ');
    define('MESSAGE10','ใช่ หรือ ไม่?');
    define('MESSAGE11','คุณต้องการทำสำเนารายการ');
    define('MESSAGE12','คุณต้องการยืนยันรายการ');
    define('MESSAGE13','คุณต้องการสร้างเอกสาร');
    define('MESSAGE14','ไอดีผู้ใช้นี้มีอยู่แล้ว โปรดตรวจสอบ');
    define('MESSAGE15','คุณต้องการสร้างเอกสาร <span class="text-danger">"ใบลดหนี้"</span>  โดย');
    define('MESSAGE16','คุณต้องการสร้างเอกสาร  <span class="text-danger">"ใบเพิ่มหนี้"</span> โดย');
    define('MESSAGE17','คุณต้องการรีเซ็ตรหัสผ่าน');
    define('MESSAGE18','รหัสผ่านไม่ตรงกัน');
    define('MESSAGE19','คุณต้องการยกเลิกเอกสาร');

}else{
    /*##### MENU #####*/
    define('MENU0','Dashboard');
    define('MENU1','Purchase');
    define('MENU1_1','Purchase Orders');
    define('MENU1_2','Supplier');
    define('MENU1_3','Goods Receipt');

    define('MENU2','Sales');
    define('MENU2_1','Sale Orders');
    define('MENU2_2','Customer');
    define('MENU2_3','Product');
    define('MENU2_4','Price Lists');
    define('MENU2_5','Cash Sale');
    define('MENU2_6','Invoice');
    define('MENU2_7','Credit Note');
    define('MENU2_8','Debit Note');
    define('MENU2_9','Delivery Orders');
    define('MENU2_10','Work Orders');

    define('MENU3','Inventory');
    define('MENU3_1','Product Stock');
    define('MENU3_2','Category');
    define('MENU3_3','Classification');
    define('MENU3_4','Inventory');
    define('MENU3_5','FDA');
    define('MENU3_6','Unit Of Measure');
    define('MENU3_7','Adjust Stock');

    define('MENU4','Reports');

    define('MENU5','Setting');
    define('MENU5_1','Company');
    define('MENU5_2','Series No.');
    define('MENU5_3','Location');
    define('MENU5_4','Lot');
    define('MENU5_5','Payment Terms');

    define('MENU6','Administrator');
    define('MENU6_1','Users');
    define('MENU6_2','Companys');


    /*##### BUTTON #####*/
    define('BTN_NEW','New');
    define('BTN_DELETE','Delete');
    define('BTN_EDIT','Edit');
    define('BTN_COPY','Copy & New');
    define('BTN_EXPORT','Export');
    define('BTN_IMPORT','Import');
    define('BTN_PRINT','Print');
    define('BTN_POST','Posting');
    define('BTN_DISCARD','Discard');
    define('BTN_YES','Yes');
    define('BTN_CANCEL','Cancel');
    define('BTN_SELECT','Select');
    define('BTN_ACTION','Action');
    define('BTN_ASSIGN','Request Approval');
    define('BTN_ATTACH','Attach');
    define('BTN_GETBYSO','Create form SO.');
    define('BTN_UPDATE','Update');
    define('BTN_CREATEWO','Create WO.');
    define('BTN_CRE_CN','Credit Note');
    define('BTN_CRE_DN','Debit Note');
    define('BTN_GETBYPO','Receive form PO.');
    define('BTN_REPASS','Reset Password');
    define('BTN_SHOW','Show All');
    define('BTN_SELECTALL','Select All');


    /*##### CONTENT #####*/
    define('ALERT','Alert');
    define('CODE','Code');
    define('MESSAGE','Message');
    define('CHANGEPASS','Change Password');
    define('CHANGECOMPANY','Change Company');
    define('SERIESNO','Series No.');
    define('CUSTOMER','Customer');
    define('SUPPLIER','Supplier');
    define('UPLOAD','Upload File');
    define('SIGNOUT','Sign Out');
    define('MESSAGE1','Updated Successfully');
    define('MESSAGE2','Do you want to delete this');
    define('MESSAGE3','Do you want to change password');
    define('MESSAGE4','Do you want to signout');
    define('MESSAGE5','This series no is already exists. Please check.');
    define('MESSAGE6','This value cannot be null. Please check.');
    define('MESSAGE10','Yes or No?');
    define('MESSAGE11','Do you want to copy this');
    define('MESSAGE12','Do you want to post this');
    define('MESSAGE13','Do you want to create this');
    define('MESSAGE14','This username is already exists. Please check.');
    define('MESSAGE15','Do you want to create <span class="text-danger">"Credit note"</span> by');
    define('MESSAGE16','Do you want to create <span class="text-danger">"Debit note"</span> by');
    define('MESSAGE17','Do you want to reset password');
    define('MESSAGE18','Password is not match');
    define('MESSAGE19','Do you want to cancel this');
}
?>