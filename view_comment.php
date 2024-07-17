<?php
include("_check_session.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $documents_line  = 2;
    $doc_type  = "documents_line";
    $ismenu = 1;
    $current_menu = "documents";
    $get_id = $_GET['no'];
    $mail = $_SESSION['user_mail'];
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
    $strSQL2 = "SELECT * FROM `documents_line_cont` WHERE md5(`line_id`) = '$get_id' AND `doc_id` = '$doc_id'";
    $objQuery_line = $conDB->sqlQuery($strSQL2);

    $strSQL3 = "SELECT * FROM `documents_line_cont` WHERE md5(`line_id`) = '$get_id'";
    $objQuery3 = $conDB->sqlQuery($strSQL3);
    while ($objResult = mysqli_fetch_assoc($objQuery3)) {
        $line_id = $objResult['line_id'];
        $next_id = $line_id + 1;
    }

    $strSQL4 = "SELECT * FROM `documents_line_cont` WHERE `doc_id` = '$doc_id' ORDER BY `id` DESC LIMIT 1";
    $objQuery4 = $conDB->sqlQuery($strSQL4);
    while ($objResult = mysqli_fetch_assoc($objQuery4)) {
        $last_line_id = $objResult['line_id'];
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
                            <!-- <h1><?php echo $id . " = " . $last_line_id; ?></h1> -->
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <section class="content">
                <!-- Main content -->
                <div>
                    <!-- menu header -->
                    <button type="button" class="btn btn-app flat" onclick="window.location.href='view_notapproved.php?no=<?php echo md5($doc_id); ?>'" title="Discard">
                        <img src="dist/img/icon/multiply.svg" style="padding:3px;" width="24"><br>
                        Discard
                    </button>
                    <?php if ($id < $last_line_id) { ?>
                        <button type="button" class="btn btn-app flat" onclick="nextReject('<?php echo md5($line_id); ?>','<?php echo md5($next_id); ?>')" title="Next">
                            <img src="dist/img/icon/forward.png" width="24"><br>
                            Next
                        </button>
                    <?php } elseif ($id = $last_line_id) {
                        //nothing
                    } ?>

                </div><!-- /menu header -->
                <div class="row" style="padding: 0px 10px;">
                    <!-- General 1 -->
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body row">
                                <div class="col-md-12">
                                    <?php
                                    $index = 0;
                                    $comment = '';
                                    while ($objResult_line = mysqli_fetch_assoc($objQuery_line)) {
                                        $index++;
                                    ?>
                                        <?php if ($objResult_line['is_image'] == 0) { ?>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Content <?php echo $index; ?><em></em></label>
                                                        <div class="editor-container" style="display: flex;">
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
                                                        <label>Content <?php echo $index; ?><em></em></label><br>
                                                        <img src="<?php echo substr($objResult_line['content'], 3) ?>" alt="" height="300px" />
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Content <?php echo $index; ?><em></em></label><br>
                                                        <img src="<?php echo substr($objResult_line['content'], 3) ?>" alt="" height="300px" />
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <input type="hidden" name="" id="input_id<?php echo $objResult_line['id'] ?>" value="<?php echo md5($objResult_line['id']) ?>">
                                        <?php $comment = $objResult_line['comment']; ?>
                                    <?php } ?>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <textarea class="form-control" name="comment" id="comment" placeholder="Comment..."><?php echo $comment ?></textarea>
                                        </div>
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
    <!-- <?php include("_test_ck.php"); ?> -->
    <script>
        function addContent(line_id, is_image) {
            $.post("services/add_content.php", {
                    line_id: line_id,
                    is_image: is_image
                })
                .done(function(data) {
                    console.log(data);
                    window.location.reload();
                });
            return false;
        }

        function setTextEditor(id) {
            let editor;
            CKEDITOR.ClassicEditor.create(document.querySelector('#editor' + id), {
                    toolbar: {
                        items: [
                            'undo', 'redo',
                            'alignment', '|',
                            'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
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
                    fontFamily: {
                        options: ['Browallia New'],
                        supportAllValues: true,
                        default: 'Browallia New'
                    },
                    fontSize: {
                        options: [20],
                        supportAllValues: true,
                        default: '20px'
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
                    removePlugins: [
                        // 'ExportPdf',
                        // 'ExportWord',
                        'AIAssistant',
                        'CKBox',
                        'CKFinder',
                        'EasyImage',
                        // 'Base64UploadAdapter',
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
                    editor = newEditor;
                    console.log(newEditor)
                })
                .catch(error => {
                    console.error(error);
                });

            document.querySelector('#submit' + id).addEventListener('click', () => {
                const input_id = document.getElementById('input_id' + id).value
                const editorData = editor.getData();
                console.log(editorData)
                updateValue('documents_line_cont', input_id, 'content', editorData);
            });

        };
    </script>

</html>