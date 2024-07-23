<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<script src="dist/js/crypto.js"></script>
<script src="dist/js/bootstrap-datepicker.js"></script>
<script src="dist/datatables/datatables.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/super-build/ckeditor.js"></script>

<script>
    $("#lineItem").DataTable({
        "stateSave": true,
        "paging": true,
        "responsive": true,
        "lengthChange": true,
        "searching": true,
        "autoWidth": false,
        "ordering": true,
        "info": true,
    });

    function slecetblank(doc_id, table) {
        $.post("services/addlineitem.php", {
                doc_id: doc_id,
                table: table
            })
            .done(function(data) {
                window.location.reload();
            });
        return false;
    }

    function slecetcustomer(doc_id, id, table) {
        $.post("services/selectcustomer.php", {
                doc_id: doc_id,
                id: id,
                table: table
            })
            .done(function(data) {
                //console.log(data);
                window.location.reload();
            });
        return false;
    }

    function slecetsupplier(doc_id, id, table) {
        $.post("services/selectsupplier.php", {
                doc_id: doc_id,
                id: id,
                table: table
            })
            .done(function(data) {
                window.location.reload();
            });
        return false;
    }

    function slecetproduct_line(doc_id, item_id, code, description, uom, unitprice, table) {
        $.post("services/selectproduct_line.php", {
                doc_id: doc_id,
                item_id: item_id,
                code: code,
                description: description,
                uom: uom,
                unitprice: unitprice,
                table: table,
            })
            .done(function(data) {
                console.log(data);
                window.location.reload();
            });
        return false;
    }

    function slecetproduct(doc_id, id, table) {
        $.post("services/selectproduct.php", {
                doc_id: doc_id,
                id: id,
                table: table
            })
            .done(function(data) {
                console.log(data);
                window.location.reload();
            });
        return false;
    }

    function slecetDeliveryorder(doc_id, id, table) {
        $.post("services/selectdeliveryorder.php", {
                doc_id: doc_id,
                id: id,
                table: table
            })
            .done(function(data) {
                console.log(data);
                window.location.reload();
            });
        return false;
    }

    function slecetinventory(doc_id, id, table) {
        $.post("services/selectinventory.php", {
                doc_id: doc_id,
                id: id,
                table: table
            })
            .done(function(data) {
                console.log(data);
                window.location.reload();
            });
        return false;
    }

    //function filter/search
    function setFilter(param, value) {
        $.post("services/setfilter.php", {
                param: param,
                value: value
            })
            .done(function(data) {
                console.log(value);
                window.location.reload();
            });
        return false;
    }

    function updateValue(table, id, field, value) {
        $('#success-alert').hide();
        let myPromise = new Promise(function(myResolve, myReject) {
            setTimeout(function() {
                myResolve(true);
            }, 100);
        });
        $.post("services/updatevalue.php", {
                table: table,
                id: id,
                field: field,
                value: value
            })
            .done(function(data) {
                myPromise.then(function(value) {
                    var divElement = document.getElementById("success-alert");
                    divElement.style.display = "block";
                    console.log(data);
                    setValue(data);
                    $('#success-alert').fadeOut(3000, function() {
                        $('#success-alert').hide();
                    });
                });
            });
    }

    function updateValue_lineid(table, id, field, value) {
        $('#success-alert').hide();
        let myPromise = new Promise(function(myResolve, myReject) {
            setTimeout(function() {
                myResolve(true);
            }, 100);
        });
        $.post("services/updatevalue_lineid.php", {
                table: table,
                id: id,
                field: field,
                value: value
            })
            .done(function(data) {
                myPromise.then(function(value) {
                    var divElement = document.getElementById("success-alert");
                    divElement.style.display = "block";
                    console.log(data);
                    setValue(data);
                    $('#success-alert').fadeOut(3000, function() {
                        $('#success-alert').hide();
                    });
                });
            });
    }

    function postValue(table, field, value) {
        $('#success-alert').hide();
        let myPromise = new Promise(function(myResolve, myReject) {
            setTimeout(function() {
                myResolve(true);
            }, 100);
        });
        $.post("services/postvalue.php", {
                table: table,
                field: field,
                value: value
            })
            .done(function(data) {
                myPromise.then(function(value) {
                    var divElement = document.getElementById("success-alert");
                    divElement.style.display = "block";
                    console.log(data);
                    setValue(data);
                    $('#success-alert').fadeOut(3000, function() {
                        $('#success-alert').hide();
                    });
                });
            });
    }

    function postRequestDownload(doc_no, request) {
        $('#success-alert').hide();
        let myPromise = new Promise(function(myResolve, myReject) {
            setTimeout(function() {
                myResolve(true);
            }, 100);
        });
        $.post("services/add_request.php", {
                doc_no: doc_no,
                request: request
            })
            .done(function(data) {
                myPromise.then(function(value) {
                    var divElement = document.getElementById("success-alert");
                    divElement.style.display = "block";
                    console.log(data);
                    setValue(data);
                    $('#success-alert').fadeOut(3000, function() {
                        $('#success-alert').hide();
                    });
                });
            });
    }

    function postRequestDelete(doc_no, request) {
        $('#success-alert').hide();
        let myPromise = new Promise(function(myResolve, myReject) {
            setTimeout(function() {
                myResolve(true);
            }, 100);
        });
        $.post("services/add_reqDelete.php", {
                doc_no: doc_no,
                request: request
            })
            .done(function(data) {
                myPromise.then(function(value) {
                    var divElement = document.getElementById("success-alert");
                    divElement.style.display = "block";
                    console.log(data);
                    setValue(data);
                    $('#success-alert').fadeOut(3000, function() {
                        $('#success-alert').hide();
                    });
                });
            });
    }

    function postRequestRevise(doc_no, request) {
        $('#success-alert').hide();
        let myPromise = new Promise(function(myResolve, myReject) {
            setTimeout(function() {
                myResolve(true);
            }, 100);
        });
        $.post("services/add_reqRevise.php", {
                doc_no: doc_no,
                request: request
            })
            .done(function(data) {
                myPromise.then(function(value) {
                    var divElement = document.getElementById("success-alert");
                    divElement.style.display = "block";
                    console.log(data);
                    setValue(data);
                    $('#success-alert').fadeOut(3000, function() {
                        $('#success-alert').hide();
                    });
                });
            });
    }

    function selectno(noseries, id, seriesid, table) {
        $.post("services/selectnoseries.php", {
                noseries: noseries,
                id: id,
                seriesid: seriesid,
                table: table
            })
            .done(function(data) {
                var myObj = JSON.parse(data);
                if (myObj.alerts != null) {
                    document.getElementById('message').innerHTML = myObj.alerts;
                } else {
                    console.log(data);
                    window.location.reload();
                }
            });
        return false;
    };

    function setValue(value) {
        var myObj = JSON.parse(value);
        if (myObj.totalamount != null) {
            document.getElementById(myObj.totalamount_id).value = myObj.totalamount;
        }
        if (myObj.total != null) {
            document.getElementById('total').value = myObj.total;
        }
        if (myObj.discount != null) {
            document.getElementById('discount').value = myObj.discount;
        }
        if (myObj.amt_excl_vat != null) {
            document.getElementById('amt_excl_vat').value = myObj.amt_excl_vat;
        }
        if (myObj.vat != null) {
            document.getElementById('vat').value = myObj.vat;
        }
        if (myObj.amt_incl_vat != null) {
            document.getElementById('amt_incl_vat').value = myObj.amt_incl_vat;
        }
    }

    function updateAmount(table, id, field, value) {
        $.post("services/updatevalue_line.php", {
                table: table,
                id: id,
                field: field,
                value: value
            })
            .done(function(data) {
                setValue(data);
            });
        return false;
    };

    //function delete with id
    function setDelete(table, id, name, redirect) {
        document.getElementById('messageContent').innerHTML = '<div class="row col-md-12">' +
            '<p>Do you want to delete this <span class=\"text-danger\">"' + name +
            '"</span> <?php echo "<em>Yes or No?</em>"; ?></p>' +
            '</div>' +
            '<button type="button" class="btn btn-primary" onclick="deletePost(' + "'" + table + "','" + id + "','" +
            redirect + "'" + ')">Yes</button> ' +
            '<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>';
        $('#messageModal').modal('show');
    }

    function setCopy(table, id, name) {
        document.getElementById('messageContent').innerHTML = '<div class="row col-md-12">' +
            '<p>Do you want to copy this <span class=\"text-primary\">"' + name +
            '"</span> <?php echo "<em>Yes or No?</em>"; ?></p>' +
            '</div>' +
            '<button type="button" class="btn btn-primary" onclick="copyPost(' + "'" + table + "','" + id + "'" +
            ')">Yes</button> ' +
            '<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>';
        $('#messageModal').modal('show');
    }

    function setCopy2(table, id, name) {
        document.getElementById('messageContent').innerHTML = '<div class="row col-md-12">' +
            '<p>Do you want to copy this <span class=\"text-primary\">"' + name +
            '"</span> <?php echo "<em>Yes or No?</em>"; ?></p>' +
            '</div>' +
            '<button type="button" class="btn btn-primary" onclick="copy2Post(' + "'" + table + "','" + id + "'" +
            ')">Yes</button> ' +
            '<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>';
        $('#messageModal').modal('show');
    }

    function setCreate(table, name) {
        document.getElementById('messageContent').innerHTML = '<div class="row col-md-12">' +
            '<p>Do you want to create this <span class=\"text-info\">"' + name +
            '"</span> <?php echo "<em>Yes or No?</em>"; ?></p>' +
            '</div>' +
            '<button type="button" class="btn btn-primary" onclick="createPage(' + "'" + table + "'" + ')">Yes</button> ' +
            '<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>';
        $('#messageModal').modal('show');
    }

    //sendmail
    function sendMail(to, approval_name, method_statement, doc_no, createdby, date, type, from) {
        const subject = 'REQUEST TO APPROVE, CONSTRUCTION METHOD STATEMENT';
        const htmlContent = `<html>
        <head>
            <title>CONSTRUCTION METHOD STATEMENT</title>
        </head>
        <body>
            <h2>Dear ${approval_name}, requires you to approve ${type} document</h2>
            Document no. : ${doc_no}</br>
            Method Statement : ${method_statement}</br>
            Created By : ${createdby}</br>
            Report Date : ${date}</br>
            Please click below link to access to platform.</br></br>
            <a href="https://apps.powerapps.com/play/e/default-99e38c91-bab9-419c-84c0-4054b0b25b8b/a/678ec0e2-7e4f-410a-9b0d-60b6a3ffd9d0?tenantId=99e38c91-bab9-419c-84c0-4054b0b25b8b&hint=5f12378a-f320-429c-9d1b-8329f014a7c9&sourcetime=1721374709794&source=portal" 
            target="_blank" style="color:#ffffff; text-decoration:none; font-family:Segoe UI Semibold,SegoeUISemibold,Segoe UI,SegoeUI,Roboto,&quot;Helvetica Neue&quot;,Arial,sans-serif; font-weight:600; padding:12px 16px 12px 16px; text-align:left; line-height:1; font-size:16px; display:inline-block; border:0; border-radius:4px; background: #0078d7;" >CLICK TO OPEN APP</a>
            </br></br>Thank you</br>${from}
        </body>
    </html>`;
        $.post("services/sendmail.php", {
                to: to,
                subject: subject,
                htmlContent: htmlContent
            })
            .done(function(data) {
                var myObj = JSON.parse(data);
                if (myObj.alert != '') {
                    alert(myObj.alert)
                }
            });
        return false;
    }

    //Function Approve Document
    function Approved(id, doc_no, value) {
        let approved = Number(value) + 1;
        document.getElementById('messageContent').innerHTML = '<div class="row col-md-12">' +
            '<p>Do you want to approve this document: ' + doc_no +
            '</p></div>' +
            '<button type="button" class="btn btn-success" onclick="postApproved(' + "'" + id + "'" + ',' + "'" + approved + "'" + ')">Yes</button> ' +
            '<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>';
        $('#messageModal').modal('show');
    }
    //Function Approve Document
    function postApproved(id, value) {
        updateValue('documents', id, 'approved', value);
        window.location.href = "approval_create.php"
        window.location.href = "approval_create.php"
    }

    //Function Approve req Download in detail_download.php
    function reqApproved(id, doc_no) {
        document.getElementById('messageContent').innerHTML = '<div class="row col-md-12">' +
            '<p>Do you want to approve this document: ' + doc_no +
            '</p></div>' +
            '<button type="button" class="btn btn-success" onclick="acceptReq(' + "'" + id + "'" + ')">Yes</button> ' +
            '<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>';
        $('#messageModal').modal('show');
    }
    //Function Approve req Download in detail_download.php
    function acceptReq(id) {
        updateValue('request', id, 'status_req', '2');
        const currentDate = new Date();
        currentDate.setDate(currentDate.getDate() + 7);
        const expire = currentDate.toISOString().split('T')[0];
        updateValue('request', id, 'expire', expire);
        window.location.href = 'approval_download.php';
    }

    //Funtion Reject req Download in detail_download.php
    function reqReject(id, doc_no) {
        document.getElementById('messageContent').innerHTML = '<div class="row col-md-12">' +
            '<p>Do you want to approve this document: ' + doc_no +
            '</p></div>' +
            '<button type="button" class="btn btn-success" onclick="rejectReq(' + "'" + id + "'" + ')">Yes</button> ' +
            '<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>';
        $('#messageModal').modal('show');
    }
    //Funtion Reject req Download in detail_download.php
    function rejectReq(id) {
        updateValue('request', id, 'status_req', '0');
        // updateValue('request', id, 'request', null);
        updateValue('request', id, 'expire', null);
        window.location.href = 'approval_download.php';
    }

    //Function Approve req Download in detail_revise.php
    function revApproved(id, doc_no, doc_id) {
        document.getElementById('messageContent').innerHTML = '<div class="row col-md-12">' +
            '<p>Do you want to approve this document: ' + doc_no +
            '</p></div>' +
            '<button type="button" class="btn btn-success" onclick="acceptRev(' + "'" + id + "'" + ',' + "'" + doc_id + "'" + ')">Yes</button> ' +
            '<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>';
        $('#messageModal').modal('show');
    }
    //Function Approve req Download in detail_revise.php
    function acceptRev(id, doc_id) {
        updateValue('request', id, 'status_rev', '2');
        draftDocument(id, doc_id);
        window.location.href = 'approval_revise.php';
    }
    //Function Draft
    function draftDocument(id, doc_id) {
        $.post("services/draft.php", {
                id: id,
                doc_id: doc_id
            })
            .done(function(data) {
                var myObj = JSON.parse(data);
                if (myObj.alerts != null) {
                    console.log(myObj.alerts);
                } else {
                    window.location.href = myObj.redirect;
                }
            });
        return false;
    };

    //Funtion Reject req Revise in detail_revise.php
    function revReject(id, doc_no) {
        document.getElementById('messageContent').innerHTML = '<div class="row col-md-12">' +
            '<p>Do you want to approve this document: ' + doc_no +
            '</p></div>' +
            '<button type="button" class="btn btn-success" onclick="rejectRev(' + "'" + id + "'" + ')">Yes</button> ' +
            '<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>';
        $('#messageModal').modal('show');
    }
    //Funtion Reject req Revise in detail_revise.php
    function rejectRev(id) {
        updateValue('request', id, 'status_rev', '0');
        // updateValue('request', id, 'req_revise', null);
        window.location.href = 'approval_revise.php';
    }

    //Function Reject Document
    function Reject(id, doc_no) {
        document.getElementById('messageContent').innerHTML = '<div class="row col-md-12">' +
            '<p>Do you want to reject this content: ' + doc_no +
            '</p></div>' +
            '<button type="button" class="btn btn-success" onclick="postReject(' + "'" + id + "'" + ')">Yes</button> ' +
            '<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>';
        $('#messageModal').modal('show');
    }
    //Function Reject Document
    function postReject(id) {
        updateValue('documents', id, 'approved', '0');
        window.location.href = 'approval_create.php';
    }

    //function send req Download
    function RequestDownload(id, to, approval_name, method_statement, doc_no, createdby, date ,type) {
        document.getElementById('messageContent').innerHTML = '<div class="row col-md-12">' +
            '<p>Do you want to request download this document: ' + doc_no +
            '</p></div>' +
            '<button type="button" class="btn btn-success" onclick="reqDownload(' + "'" + id + "'" + ',' + "'" + to + "'" + ',' + "'" + approval_name + "'" + ',' + "'" + method_statement + "'" + ',' + "'" + doc_no + "'" + ',' + "'" + createdby + "'" + ',' + "'" + date + "'" + ',' + "'" + type + "'" + ')">Yes</button> ' +
            '<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>';
        $('#messageModal').modal('show');
    }
    //function send req Download
    function reqDownload(id, to, approval_name, method_statement, doc_no, createdby, date, type, from) {
        let request = document.getElementById('request').value;
        postRequestDownload(doc_no, request);
        sendMail(to, approval_name, method_statement, doc_no, createdby, date, type, from);
        window.location.href = 'request.php';
    }

    //function send req Revise
    function RequestRevise(id, to, approval_name, method_statement, doc_no, createdby, date, type) {
        document.getElementById('messageContent').innerHTML = '<div class="row col-md-12">' +
            '<p>Do you want to request revise this document: ' + doc_no +
            '</p></div>' +
            '<button type="button" class="btn btn-success" onclick="reqRevise(' + "'" + id + "'" + ',' + "'" + to + "'" + ',' + "'" + approval_name + "'" + ',' + "'" + method_statement + "'" + ',' + "'" + doc_no + "'" + ',' + "'" + createdby + "'" + ',' + "'" + date + "'" + ',' + "'" + type + "'" + ')">Yes</button> ' +
            '<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>';
        $('#messageModal').modal('show');
    }
    //function send req Revise
    function reqRevise(id, to, approval_name, method_statement, doc_no, createdby, date, type, from) {
        let request = document.getElementById('request').value;
        postRequestRevise(doc_no, request);
        sendMail(to, approval_name, method_statement, doc_no, createdby, date, type, from);
        window.location.href = 'request.php';
    }

    //function send req Delete
    function sendDelete(id, to, approval_name, method_statement, doc_no, createdby, date, type) {
        document.getElementById('messageContent').innerHTML = '<div class="row col-md-12">' +
            '<p>Do you want to delete this document: ' + doc_no +
            '</p></div>' +
            '<button type="button" class="btn btn-success" onclick="sendDeleteDocument(' + "'" + id + "'" + ',' + "'" + to + "'" + ',' + "'" + approval_name + "'" + ',' + "'" + method_statement + "'" + ',' + "'" + doc_no + "'" + ',' + "'" + createdby + "'" + ',' + "'" + date + "'" + ',' + "'" + type + "'" + ')">Yes</button> ' +
            '<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>';
        $('#messageModal').modal('show');
    }
    //function send req Delete
    function sendDeleteDocument(id, to, approval_name, method_statement, doc_no, createdby, date, type, from) {
        let request = document.getElementById('request').value;
        postRequestDelete(doc_no, request)
        sendMail(to, approval_name, method_statement, doc_no, createdby, date, type, from);
        window.location.href = 'request.php';
    }

    //Function Approve req Delete in detail.del.php
    function approveDelete(id, doc_no, doc_id) {
        document.getElementById('messageContent').innerHTML = '<div class="row col-md-12">' +
            '<p>Do you want to delete this document: ' + doc_no +
            '</p></div>' +
            '<button type="button" class="btn btn-success" onclick="acceptDelete(' + "'" + id + "'" + ',' + "'" + doc_id + "'" + ')">Yes</button> ' +
            '<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>';
        $('#messageModal').modal('show');
    }
    //Function Approve req Delete in detail.del.php
    function acceptDelete(id, doc_id) {
        updateValue('documents', doc_id, 'enable', '0');
        updateValue('request', id, 'status_del', '2');
        window.location.href = 'approval_del.php';
    }

    //Function Reject req Delete in detail.del.php
    function rejectDelete(id, doc_no) {
        document.getElementById('messageContent').innerHTML = '<div class="row col-md-12">' +
            '<p>Do you want to delete this document: ' + doc_no +
            '</p></div>' +
            '<button type="button" class="btn btn-success" onclick="deleteReject(' + "'" + id + "'" + ')">Yes</button> ' +
            '<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>';
        $('#messageModal').modal('show');
    }
    //Function Reject req Delete in detail.del.php
    function deleteReject(id) {
        updateValue('request', id, 'status_del', '0');
        // updateValue('request', id, 'req_delete', null);
        window.location.href = 'approval_del.php';
    }

    //Function Save as word in documents_edit.php
    function saveWord(id, to, approval_name, method_statement, doc_no, createdby, date ,type, from) {
        document.getElementById('messageContent').innerHTML = '<div class="row col-md-12">' +
            '<p>Do you want to save this documents: ' + doc_no +
            '</p></div>' +
            '<button type="button" class="btn btn-success" onclick="updateWord(' + "'" + id + "'" + ',' + "'" + to + "'" + ',' + "'" + approval_name + "'" + ',' + "'" + method_statement + "'" + ',' + "'" + doc_no + "'" + ',' + "'" + createdby + "'" + ',' + "'" + date + "'" + ',' + "'" + type + "'" + ')">Yes</button> ' +
            '<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>';
        $('#messageModal').modal('show');
    }
    //Function Save as word in documents_edit.php
    function updateWord(id, to, approval_name, method_statement, doc_no, createdby, date, type, from) {
        sendMail(to, approval_name, method_statement, doc_no, createdby, date, type, from);
        updateValue('documents', id, 'approved', '1');
        window.location.href = 'save_word.php?no=' + id;
    }

    //Function Save Comment in reason_reject.php
    function saveComment(id, doc_no) {
        document.getElementById('messageContent').innerHTML = '<div class="row col-md-12">' +
            '<p>Do you want to save this comment: ' + doc_no +
            '</p></div>' +
            '<button type="button" class="btn btn-success" onclick="updateComment(' + "'" + id + "'" + ')">Yes</button> ' +
            '<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>';
        $('#messageModal').modal('show');
    }
    //Function Save Comment in reason_reject.php
    function updateComment(id) {
        let comment = document.getElementById('comment').value;
        updateValue_lineid('documents_line_cont', id, 'comment', comment);
        // window.history.back();
        window.location.reload();
    }

    //Function Next page Comment in reason_reject.php
    function nextComment(id, next_id) {
        let comment = document.getElementById('comment').value;
        updateValue_lineid('documents_line_cont', id, 'comment', comment);
        // window.history.back();
        window.location.href = "reason_reject.php?no=" + next_id;
    }

    function nextReject(id, next_id) {
        window.location.href = "view_comment.php?no=" + next_id;
    }

    function setCreateInput(table, name, field) {
        document.getElementById('messageContent').innerHTML = '<div class="row col-md-12">' +
            '<p>Do you want to create this <span class=\"text-info\">"' + name +
            '"</span> <?php echo "<em>Yes or No?</em>"; ?></p>' +
            '</div>' +
            '<div class="row">' +
            '<div class="form-group col-md-12">' +
            '<label>Name <em>ชื่อ</em></label>' +
            '<input id="new_name" class="form-control" />' +
            '</div>' +
            '</div>' +
            '<button type="button" class="btn btn-primary" onclick="createPost2(' + "'" + table + "'" + ',' + "'" +
            field + "'" + ',document.getElementById(\'new_name\').value)">Yes</button> ' +
            '<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>';
        $('#messageModal').modal('show');
    }

    function setCancelDoc(table, name, id) {
        document.getElementById('messageContent').innerHTML = '<div class="row col-md-12">' +
            '<p>Do you want to cancel this <span class=\"text-info\">"' + name +
            '"</span> <?php echo "<em>Yes or No?</em>"; ?></p>' +
            '</div>' +
            '<div class="row">' +
            '<div class="form-group col-md-12">' +
            '<label>Reason <em>เหตุผลในการยกเลิก</em></label>' +
            '<input id="description_reason" class="form-control" />' +
            '</div>' +
            '</div>' +
            '<button type="button" class="btn btn-primary" onclick="cancelPost(' + "'" + table + "'" + ',' + "'" + id +
            "'" + ',document.getElementById(\'description_reason\').value)">Yes</button> ' +
            '<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>';
        $('#messageModal').modal('show');
    }

    function md5(value) {
        return CryptoJS.MD5(value).toString();
    }

    function postedPost(table, id) {
        $.post("services/posting.php", {
                table: table,
                id: id,
                field: 'posted',
                value: '1'
            })
            .done(function(data) {
                var myObj = JSON.parse(data);
                if (myObj.alerts != null) {
                    alert(myObj.alerts);
                } else {
                    if (table == 'purchaseorder') {
                        $.post("services/posted_po.php", {
                            id: id
                        });
                    }
                    window.location.reload();
                }
            });
        return false;
    }

    function deletePost(table, id, redirect) {
        $.post("services/delete.php", {
                table: table,
                id: id
            })
            .done(function(data) {
                console.log(data)
                if (redirect == '') {
                    window.location.reload();
                } else {
                    window.location.href = redirect;
                }

            });
        return false;
    };

    function copyPost(table, id) {
        $.post("services/copy.php", {
                table: table,
                id: id,
            })
            .done(function(data) {
                var myObj = JSON.parse(data);
                if (myObj.alerts != null) {
                    console.log(myObj.alerts);
                } else {
                    window.location.href = myObj.redirect;
                }
            });
        return false;
    };

    function copy2Post(table, id) {
        $.post("services/copy2.php", {
                table: table,
                id: id,
            })
            .done(function(data) {
                var myObj = JSON.parse(data);
                if (myObj.alerts != null) {
                    console.log(myObj.alerts);
                } else {
                    window.location.href = myObj.redirect;
                }
            });
        return false;
    };

    function copyPost2(table, id) {
        $.post("services/create_form_inv.php", {
                table: table,
                id: id,
            })
            .done(function(data) {
                var myObj = JSON.parse(data);
                if (myObj.alerts != null) {
                    console.log(myObj.alerts);
                } else {
                    window.location.href = myObj.redirect;
                }
            });
        return false;
    };

    function createPost(table) {
        $.post("services/create.php", {
                table: table,
            })
            .done(function(data) {
                var myObj = JSON.parse(data);
                if (myObj.alerts != null) {
                    document.getElementById('message').innerHTML = myObj.alerts;
                    console.log(myObj.alerts);
                } else {
                    window.location.href = myObj.redirect;
                }
            });
        return false;
    };

    function createPage(table) {
        window.location.href = 'create_document.php';
    };

    function createPost2(table, field, value) {
        $.post("services/create2.php", {
                table: table,
                field: field,
                value: value,
            })
            .done(function(data) {
                var myObj = JSON.parse(data);
                if (myObj.alerts != null) {
                    document.getElementById('message').innerHTML = myObj.alerts;
                    console.log(myObj.alerts);
                } else {
                    window.location.href = myObj.redirect;
                }
            });
        return false;
    };

    function cancelPost(table, id, value) {
        $.post("services/cancel.php", {
                table: table,
                id: id,
                value: value,
            })
            .done(function(data) {
                var myObj = JSON.parse(data);
                if (myObj.alerts != null) {
                    document.getElementById('message').innerHTML = myObj.alerts;
                    console.log(myObj.alerts);
                } else {
                    window.location.reload();
                }
            });
        return false;
    };

    function switchChange(doc_id, content_id, value) {
        if (value.value === '0') {
            value.value = '1';
        } else {
            value.value = '0';
        }
        checkDocLine(doc_id, content_id, value.value);
    }

    function checkDocLine(doc_id, content_id, value) {
        $.post("services/updatedoc_line.php", {
                doc_id: doc_id,
                content_id: content_id,
                value: value
            })
            .done(function(data) {
                console.log(data)
            });
        return false;
    }

    //Function reload content in documents_edit.php
    function reloadContent(doc_id) {
        $.post("services/updatedoc_content.php", {
                doc_id: doc_id,
            })
            .done(function(data) {
                window.location.reload()
                console.log(data)
            });
        return false;
    }

    function changeCompany() {
        $('#change_company').submit(function() {
            $.ajax({
                    type: 'POST',
                    url: 'services/change_company.php',
                    data: $(this).serialize()
                })
                .done(function(data) {
                    var myObj = JSON.parse(data);
                    if (myObj.alerts != null) {
                        document.getElementById('message').innerHTML = myObj.alerts;
                    }
                    if (myObj.redirect != null) {
                        window.location.href = myObj.redirect;
                    }
                    return false;
                })
                .fail(function() {
                    alert("การโพสต์ล้มเหลว");
                });
            return false;
        })
    }

    //Function upload image in documents_line_edit.php
    function setUpload(type, id, doc_id, redirect, selectSize, doc_no) {
        document.getElementById('type').value = type;
        document.getElementById('id').value = id;
        document.getElementById('doc_id').value = doc_id;
        document.getElementById('redirect').value = redirect;
        document.getElementById('selectSize').value = selectSize;
        document.getElementById('doc_no').value = doc_no;
    }
    $("#form_uploadfile").on("submit", function(e) {
        e.preventDefault();
        uploadFile();
    });
    async function uploadFile() {
        const form = document.getElementById('form_uploadfile');
        let formData = new FormData(form);
        formData.append("file", $('#file')[0].files[0]);
        try {
            const response = await fetch('services/uploadfile.php', {
                method: "POST",
                body: formData
            })
            window.location.reload();
        } catch (error) {
            console.error("Error:", error);
        }
    }

    function receiveitem(doc_id, po_line_id, qty) {
        $.post("services/receiveitems.php", {
                doc_id: doc_id,
                po_line_id: po_line_id,
                qty: qty,
            })
            .done(function(data) {
                var myObj = JSON.parse(data);
                if (myObj.alerts != null) {
                    console.log(myObj.alerts);
                } else {
                    window.location.reload();
                }
            });
        return false;

    }

    function setFieldValue(value, table) {
        if (table == 'location') {
            document.getElementById('selectlocation_id').value = value;
        } else {
            document.getElementById('selectlot_id').value = value;
        }
    }

    function convertDateFormat(dateString) {
        // Split the input date string into day, month, and year parts
        var parts = dateString.split('/');

        // Create a new Date object using the day, month, and year (months are zero-based)
        var dateObject = new Date(parts[2], parts[1] - 1, parts[0]);

        // Extract year, month, and day from the Date object
        var year = dateObject.getFullYear();
        var month = ('0' + (dateObject.getMonth() + 1)).slice(-2); // Adding 1 to month as it's zero-based
        var day = ('0' + dateObject.getDate()).slice(-2);

        // Construct the formatted date string in 'yyyy-mm-dd' format
        var formattedDate = year + '-' + month + '-' + day;

        return formattedDate;
    }
</script>