<?php
$documents_list_discipline = isset($_SESSION['documents_list_discipline']) ? $_SESSION['documents_list_discipline'] : '';
$documents_list_work = isset($_SESSION['documents_list_work']) ? $_SESSION['documents_list_work'] : '';
$documents_list_type = isset($_SESSION['documents_list_type']) ? $_SESSION['documents_list_type'] : '';

if ($documents_list_discipline != "") {
    $condition = " AND `discipline` = '" . $documents_list_discipline . "'";
} else {
    $condition = "";
}
if ($documents_list_work != "") {
    $condition = " AND `work` = '" . $documents_list_work . "'";
    $condition .= $condition;
} else {
    $condition .= "";
}
if ($documents_list_type != "") {
    $condition .= " AND `type` = '" . $documents_list_type . "'";
    $condition .= $condition;
} else {
    $condition .= "";
}

$strSQL = "SELECT * FROM `documents` WHERE `approved` = 4" . $condition;
$objQuery = $conDB->sqlQuery($strSQL);
?>
<div class="row">
    <div class="col-sm-3">
        <div class="form-group">
            <label>Discipline <em></em></label>
            <select class="custom-select" onchange="setFilter('documents_list_discipline',this.value)">
                <option value="" <?php if ($documents_list_discipline == '') {
                                        echo "selected";
                                    } ?>>All</option>
                <?php
                $sql2 = "SELECT DISTINCT `discipline` FROM `documents` WHERE `approved` = 4";
                $objQueryDisc = $conDB->sqlQuery($sql2);

                while ($objResult = mysqli_fetch_assoc($objQueryDisc)) { ?>
                    <option value="<?php echo $objResult['discipline']; ?>" <?php if ($documents_list_discipline == $objResult['discipline']) {
                                                                                echo "selected";
                                                                            } ?>>
                        <?php echo $objResult['discipline']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label>Work <em></em></label>
            <select class="custom-select" onchange="setFilter('documents_list_work',this.value)">
                <option value="" <?php if ($documents_list_work == '') {
                                        echo "selected";
                                    } ?>>All</option>
                <?php
                if ($documents_list_discipline != "") {
                    $condition2 = " AND `discipline` = '$documents_list_discipline'";
                }
                $sql2 = "SELECT DISTINCT `work` FROM `documents` WHERE `approved` = 4" . $condition2;
                $objQueryWork = $conDB->sqlQuery($sql2);

                while ($objResult = mysqli_fetch_assoc($objQueryWork)) { ?>
                    <option value="<?php echo $objResult['work']; ?>" <?php if ($documents_list_work == $objResult['work']) {
                                                                            echo "selected";
                                                                        } ?>>
                        <?php echo $objResult['work']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label>Type <em></em></label>
            <select class="custom-select" onchange="setFilter('documents_list_type',this.value)">
                <option value="" <?php if ($documents_list_type == '') {
                                        echo "selected";
                                    } ?>>All</option>
                <?php
                if ($documents_list_work != "") {
                    $condition2 = " AND `work` = '$documents_list_work'";
                }
                $sql2 = "SELECT DISTINCT `type` FROM `documents` WHERE `approved` = 4" . $condition2;
                $objQueryType = $conDB->sqlQuery($sql2);

                while ($objResult = mysqli_fetch_assoc($objQueryType)) { ?>
                    <option value="<?php echo $objResult['type']; ?>" <?php if ($documents_list_type == $objResult['type']) {
                                                                            echo "selected";
                                                                        } ?>>
                        <?php echo $objResult['type']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </div>
</div>