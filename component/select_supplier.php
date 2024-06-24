
<div id="selectsupplier" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog"
    aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card-body">
                <table id="supplierselectTable" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th width="10">No.<br><em>ลำดับ</em></th>
                            <th width="10">Tools<br><em>เครื่องมือ</em></th>
                            <th width="200">Code<br><em>รหัสผู้ขาย</em></th>
                            <th>Name<br><em>ชื่อ</em></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 	
                            $index = 1;
                            $strSQL_supp = "SELECT * FROM `supplier` WHERE `company_id` = '".$_SESSION['user_company']."' AND `enable` = 1 ORDER BY `name` DESC";
                            $objQuery_supp = $conDB->sqlQuery($strSQL_supp);
                            while($objResult_supp = mysqli_fetch_assoc($objQuery_supp)) { 
                        ?>
                        <tr onDblClick="slecetsupplier('<?php echo $get_id;?>','<?php echo $objResult_supp['id'] ?>','<?php echo ADD_TO_DOC;?>')">
                            <td><?php echo $index++; ?></td>
                            <td style="padding:5px;"><button class="btn btn-success"
                                    onclick="slecetsupplier('<?php echo $get_id;?>','<?php echo $objResult_supp['id'] ?>','<?php echo ADD_TO_DOC;?>')">Select</button>
                            </td>
                            <td><?php echo $objResult_supp['no'] ?></td>
                            <td><?php echo $objResult_supp['name'] ?></td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>