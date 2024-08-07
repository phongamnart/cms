<?php
include("_check_session.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $documents_line  = 0;
    $doc_type  = "documents_line";
    $ismenu = 1;
    $current_menu = "documents";
    $get_id = isset($_GET['no']) ? $_GET['no'] : '';
    $get_mode = isset($_GET['m']) ? $_GET['m'] : '';
    include_once('_head.php');
    $conDB = new db_conn();
    $strSQL = "SELECT `documents_line`.`id` AS `id`, `documents_line`.`doc_id` AS `doc_id`, `contents`.`name` AS `name` FROM `documents_line` LEFT JOIN `contents` ON `documents_line`.`content_id` = `contents`.`id` WHERE md5(`documents_line`.`id`) = '$get_id' LIMIT 1";
    $objQuery = $conDB->sqlQuery($strSQL);
    while ($objResult = mysqli_fetch_assoc($objQuery)) {
        $id = $objResult['id'];
        $doc_id = $objResult['doc_id'];
        $name = $objResult['name'];
    }
    $doc_no = '';
    $strSQL = "SELECT * FROM `documents` WHERE `id` = '$doc_id' LIMIT 1";
    $objQuery = $conDB->sqlQuery($strSQL);
    while ($objResult = mysqli_fetch_assoc($objQuery)) {
        $doc_no = $objResult['doc_no'];
    }
    $strSQL2 = "SELECT * FROM `documents_line_cont` WHERE md5(`line_id`) = '$get_id'";
    $objQuery_line = $conDB->sqlQuery($strSQL2);

    $strSQL3 = "SELECT * FROM `documents_line` WHERE md5(`id`) = '$get_id'";
    $objQuery3 = $conDB->sqlQuery($strSQL3);
    while ($objResult = mysqli_fetch_assoc($objQuery3)) {
        $line_id = $objResult['id'];
        $next_id = $line_id + 1;
        $back_id = $line_id - 1;
    }

    $strSQL4 = "SELECT * FROM `documents_line` WHERE `doc_id` = '$doc_id' ORDER BY `id` DESC LIMIT 1";
    $objQuery4 = $conDB->sqlQuery($strSQL4);
    while ($objResult = mysqli_fetch_assoc($objQuery4)) {
        $last_line_id = $objResult['id'];
    }

    $strSQL5 = "SELECT * FROM `documents_line` WHERE `doc_id` = '$doc_id' ORDER BY `id` ASC LIMIT 1";
    $objQuery5 = $conDB->sqlQuery($strSQL5);
    while ($objResult = mysqli_fetch_assoc($objQuery5)) {
        $start_line_id = $objResult['id'];
    }

    if (md5($doc_no . '1') == $get_mode) {
        $documents_line  = 2;
    }

    ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include_once('_navbar.php'); ?>
        <?php include_once('_menu.php'); ?>
        <?php
        if ($documents_line > 1) {
            $mode = "";
            $mode_select = "";
        } else {
            $mode = "readonly";
            $mode_select = "disabled";
        }
        ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1><?php echo $doc_no . " : " . $name; ?></h1>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <section class="content">
                <!-- Main content -->
                <div>
                    <!-- menu header -->
                    <?php if ($mode != "readonly") { ?>
                        <button type="button" class="btn btn-app flat" onclick="checkUnsavedChanges(() => { window.location.href='documents_edit.php?no=<?php echo md5($doc_id) . '&m=' . md5($doc_no . '1'); ?>' })" title="Discard">
                            <img src="dist/img/icon/multiply.svg" style="padding:3px;" width="24"><br>
                            Discard
                        </button>
                    <?php } else { ?>
                        <button type="button" class="btn btn-app flat" onclick="checkUnsavedChanges(() => { window.location.href='documents_edit.php?no=<?php echo md5($doc_id); ?>' })" title="Discard">
                            <img src="dist/img/icon/multiply.svg" style="padding:3px;" width="24"><br>
                            Discard
                        </button>
                    <?php } ?>
                    <?php if ($id > $start_line_id) { ?>
                        <button type="button" class="btn btn-app flat" onclick="checkUnsavedChanges(() => { backContent('<?php echo md5($back_id); ?>','<?php echo $get_mode; ?>') })" title="Next">
                            <img src="dist/img/icon/back.png" width="24"><br>
                            Back
                        </button>
                    <?php } ?>
                    <?php if ($id < $last_line_id) { ?>
                        <button type="button" class="btn btn-app flat" onclick="checkUnsavedChanges(() => { nextContent('<?php echo md5($next_id); ?>','<?php echo $get_mode; ?>') })" title="Next">
                            <img src="dist/img/icon/forward.png" width="24"><br>
                            Next
                        </button>
                    <?php } ?>
                </div><!-- /menu header -->
                <div class="row" style="padding: 0px 10px;">
                    <!-- General 1 -->
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body row">
                                <div class="col-md-12">
                                    <?php
                                    $strSQL_cancel = "SELECT * FROM `documents_line` WHERE md5(`id`) = '$get_id' AND `comment` IS NOT NULL AND `comment` != '' LIMIT 1";
                                    $objQuery_cancel = $conDB->sqlQuery($strSQL_cancel);
                                    while ($objResult_cancel = mysqli_fetch_assoc($objQuery_cancel)) {
                                        if ($objResult_cancel['created_reject'] != "") {
                                            $created_reject = date("d/m/Y", strtotime($objResult_cancel['created_reject']));
                                        }
                                    ?>
                                        <div class="alert alert-warning alert-dismissible">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                            <h5><i class="fa fa-exclamation-circle text-warning"></i> Comment by <?php echo $objResult_cancel['rejectby']; ?> at <?php echo $created_reject ?></h5>
                                            Comment : <?php echo $objResult_cancel['comment']; ?><br>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-md-12">
                                    <?php
                                    $index = 0;
                                    while ($objResult_line = mysqli_fetch_assoc($objQuery_line)) {
                                        $index++;
                                    ?>
                                        <?php if ($objResult_line['is_image'] == 0) { ?>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Paragraph <?php echo $index; ?><em></em></label>
                                                        <?php if ($mode != "readonly") { ?>
                                                            <img src="dist/img/icon/edit.svg" onclick="setTextEditor(<?php echo $objResult_line['id'] ?>)" title="Edit" width="30" style="padding: 5px;cursor: pointer;" />
                                                            <img src="dist/img/icon/save.svg" id="submit<?php echo $objResult_line['id'] ?>" title="Save" width="30" style="padding: 5px;cursor: pointer;" />
                                                            <img src="dist/img/icon/delete.png" onclick="delContent('documents_line_cont','<?php echo $objResult_line['id']; ?>','Content','','<?php echo $objResult_line['line_id']; ?>')" title="Delete" width="30" style="padding: 5px;cursor: pointer;" />
                                                            <span id="warning<?php echo $objResult_line['id'] ?>" class="text-danger" style="font-size: 14px; display: none;"> * ยังไม่กด Save ระวังข้อมูลหาย!!!</span>
                                                        <?php } ?>
                                                        <div class="editor-container">
                                                            <div class="editorTextArea" style="border: 1px solid #b3b7bb; padding: 12px;" name="editor_content[]" id="editor<?php echo $objResult_line['id'] ?>">
                                                                <?php echo $objResult_line['content']; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } elseif ($objResult_line['is_image'] == 1) { ?>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Paragraph <?php echo $index; ?><em></em></label>
                                                        <?php if ($mode != "readonly") { ?>
                                                            <img src="dist/img/icon/delete.png" onclick="delContent('documents_line_cont','<?php echo $objResult_line['id']; ?>','Image','','<?php echo $objResult_line['line_id']; ?>')" title="Delete" width="30" style="padding: 5px;cursor: pointer;" /><br>
                                                        <?php } ?>
                                                        <img src="<?php echo substr($objResult_line['content'], 3) ?>" alt="" height="300px" />
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } elseif ($objResult_line['is_image'] == 2) { ?>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Paragraph <?php echo $index; ?><em></em></label>
                                                        <?php if ($mode != "readonly") { ?>
                                                            <img src="dist/img/icon/delete.png" onclick="delContent('documents_line_cont','<?php echo $objResult_line['id']; ?>','Image','','<?php echo $objResult_line['line_id']; ?>')" title="Delete" width="30" style="padding: 5px;cursor: pointer;" /><br>
                                                        <?php } ?>
                                                        <img src="<?php echo substr($objResult_line['content'], 3) ?>" alt="" height="300px" />
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <input type="hidden" name="" id="input_id<?php echo $objResult_line['id'] ?>" value="<?php echo md5($objResult_line['id']) ?>">
                                    <?php } ?>

                                    <div class="row">
                                        <?php if ($mode != "readonly") { ?>
                                            <button type="button" class="btn btn-app flat" onclick="checkUnsavedChanges(() => { addContent('<?php echo $id; ?>', '0', '<?php echo $doc_id; ?>') })" title="Add Text">
                                                <img src="dist/img/icon/text.svg" width="24"><br>
                                                Add Text
                                            </button>
                                            <button type="button" class="btn btn-app flat" onclick="checkUnsavedChanges(() => { setUpload('documents_line_cont','<?php echo $id; ?>','<?php echo $doc_id; ?>','','1', '<?php echo $doc_no; ?>'); $('#uploadfile').modal('show'); })" title="Add Image">
                                                <img src="dist/img/icon/image.png" width="24"><br>
                                                Add Image
                                            </button>
                                            <button type="button" class="btn btn-app flat" onclick="checkUnsavedChanges(() => { setUpload('documents_line_cont','<?php echo $id; ?>','<?php echo $doc_id; ?>','','2', '<?php echo $doc_no; ?>'); $('#uploadfile').modal('show'); })" title="Add Image Full Page">
                                                <img src="dist/img/icon/image.png" width="24"><br>
                                                Add Image One Page
                                            </button>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /General 1 -->
                <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content" style="padding-top: 20px;">
                            <center>
                                <p id="callbackMsg"></p>
                            </center>
                        </div>
                    </div>
                </div>
        </div>
        </section>
        <?php include_once('_footer.php'); ?>
    </div>
    <?php include_once('_script.php'); ?>
    <script>
        let unsavedChanges = false;
        let editors = {};
        let saveTimeouts = {};

        function addContent(line_id, is_image, doc_id) {
            $.post("services/add_content.php", {
                    line_id: line_id,
                    is_image: is_image,
                    doc_id: doc_id
                })
                .done(function(data) {
                    console.log(data);
                    window.location.reload();
                });
            return false;
        }

        function setTextEditor(id) {
            const editorElement = document.querySelector('#editor' + id);
            const warningElement = document.querySelector('#warning' + id);

            if (editors[id]) {
                console.log('Editor already exists for id: ' + id);
                return;
            }

            CKEDITOR.ClassicEditor.create(editorElement, {
                    toolbar: {
                        items: [
                            'undo', 'redo',
                            'alignment', '|',
                            'fontColor', 'fontBackgroundColor', 'highlight', '|',
                            'bold', 'italic', 'underline', 'subscript', 'superscript', '|',
                            'bulletedList', 'numberedList', '|',
                            'outdent', 'indent', '|',
                            'insertTable', '|',
                            'horizontalLine', 'pageBreak', '|',
                        ],
                        shouldNotGroupWhenFull: true
                    },
                    list: {
                        properties: {
                            styles: true,
                            startIndex: true,
                            reversed: true
                        }
                    },
                    link: {
                        decorators: {
                            addTargetToExternalLinks: true,
                            defaultProtocol: 'https://',
                            toggleDownloadable: {
                                mode: 'manual',
                                label: 'Downloadable',
                                attributes: {
                                    download: 'file'
                                }
                            }
                        }
                    },
                    placeholder: 'Enter your text here...',
                    removePlugins: [
                        'AIAssistant',
                        'CKBox',
                        'CKFinder',
                        'EasyImage',
                        'MultiLevelList',
                        'RealTimeCollaborativeComments',
                        'RealTimeCollaborativeTrackChanges',
                        'RealTimeCollaborativeRevisionHistory',
                        'PresenceList',
                        'Comments',
                        'TrackChanges',
                        'TrackChangesData',
                        'RevisionHistory',
                        'Pagination',
                        'WProofreader',
                        'MathType',
                        'SlashCommand',
                        'Template',
                        'DocumentOutline',
                        'FormatPainter',
                        'TableOfContents',
                        'PasteFromOfficeEnhanced',
                        'CaseChange'
                    ]
                })
                .then(newEditor => {
                    editors[id] = newEditor;
                    console.log('Editor created for id: ' + id, newEditor);

                    newEditor.model.document.on('change:data', () => {
                        unsavedChanges = true;

                        if (saveTimeouts[id]) {
                            clearTimeout(saveTimeouts[id]);
                        }

                        saveTimeouts[id] = setTimeout(() => {
                            saveEditorContent(id);
                        }, 2000); // Wait 2 seconds before saving
                    });
                })
                .catch(error => {
                    console.error(error);
                });

            warningElement.style.display = 'inline';
        }

        function saveEditorContent(id) {
            const input_id = document.getElementById('input_id' + id).value;
            let editorData = editors[id].getData();

            const parser = new DOMParser();
            const doc = parser.parseFromString(editorData, 'text/html');
            const paragraphs = doc.querySelectorAll('p');

            paragraphs.forEach(p => {
                p.style.margin = '0px';
            });

            editorData = doc.body.innerHTML;

            console.log(editorData);
            updateValue('documents_line_cont', input_id, 'content', editorData);
            document.querySelector('#warning' + id).style.display = 'none';
            unsavedChanges = false;
        }

        function checkUnsavedChanges(callback) {
            if (unsavedChanges) {
                if (confirm('คุณยังไม่ได้บันทึกข้อความ, แน่ใจใช่ไหมว่าจะออกจากหน้านี้')) {
                    callback();
                }
            } else {
                callback();
            }
        }
    </script>

</html>