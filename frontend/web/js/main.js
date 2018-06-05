/* 
 * Project Name: eulims * 
 * Copyright(C)2018 Department of Science & Technology -IX * 
 * Developer: Eng'r Nolan F. Sunico  * 
 * 01 31, 18 , 1:42:50 PM * 
 * Module: main * 
 */
jQuery(document).ready(function ($) {
    $('.btn-modal').click(function () {
        ShowModal(this.name, this.value,true,'600px');
    }); 
    // --- Delete action (bootbox) ---
    yii.confirm = function (message, ok, cancel) {
        var title = $(this).data("title");
        var confirm_label = $(this).data("ok");
        var cancel_label = $(this).data("cancel");
        
        bootbox.confirm(
            {
                title: title,
                message: message,
                buttons: {
                    confirm: {
                        label: confirm_label,
                        className: 'btn-danger btn-flat'
                    },
                    cancel: {
                        label: cancel_label,
                        className: 'btn-default btn-flat'
                    }
                },
                callback: function (confirmed) {
                    if (confirmed) {
                        !ok || ok();
                    } else {
                        !cancel || cancel();
                    }
                }
            }
        );
        // confirm will always return false on the first call
        // to cancel click handler
        return false;
    };
});
function MessageBox(){
    krajeeDialog.dialog(
        'This is a <b>custom dialog</b>. The dialog box is <em>draggable</em> by default and <em>closable</em> ' +
        '(try it). Note that the Ok and Cancel buttons will do nothing here until you write the relevant JS code ' +
        'for the buttons within "options". Exit the dialog by clicking the cross icon on the top right.',
        function (result) {alert(result);}
    );
}
function ConfirmBox(Title, Message){
    bootbox.confirm(
        {
            title: Title,
            message: Message,
            buttons: {
                confirm: {
                        label: 'Yes',
                        className: 'btn-danger btn-flat'
                },
                cancel: {
                        label: 'No',
                        className: 'btn-default btn-flat'
                }
            },
            callback: function (confirmed) {
                if (confirmed) {
                    !ok || ok();
                } else {
                    !cancel || cancel();
                }
            }
        }
    );
}
function ShowModal(header,url,closebutton,width){
    if(closebutton===undefined){
        closebutton=true;
    }
    if(width===undefined){
       width='600px'; 
    }
    $(".close").prop('disabled',!closebutton);
    $('#modalContent').html("<div style='text-align:center;'><img src='/images/img-loader64.gif' alt=''></div>");
    $('.modal-title').html();
    var dialog=$("#modal").modal({
        backdrop: false,
        show: true,
        draggable: true
    });
    dialog.init(function(){
        setTimeout(function(){
            dialog.find('.modal-title').html(header);
            dialog.find('.modal-dialog ').css({
               width: width
            });
            dialog.find('#modalContent').load(url);
        }, 5);
    });
}

function LoadModal(header,url,closebutton,width){
    ShowModal(header,url,closebutton, width);
}
function printPartOfPage(elementId) {
    var printContent = document.getElementById(elementId);
    var windowUrl = 'about:blank';
    var uniqueName = new Date();
    var windowName = 'Print' + uniqueName.getTime();
    var printWindow = window.open(windowUrl, windowName, 'left=50000,top=50000,width=0,height=0');

    printWindow.document.write(printContent.innerHTML);
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
    printWindow.close();
}
function MessageBox(Message,Title="System Message",labelYes="",labelCancel="", WithCallback=false) {
    var labelButton=(labelYes==="") && (labelCancel==="");
    if(labelButton && FuncName===""){
        bootbox.alert({
            title: Title,
            message: Message,
            size: 'medium'
        });
        return true;
    }else if(!labelButton && !WithCallback){
        bootbox.confirm({
            title: Title,
            message: Message,
            buttons: {
                cancel: {
                    label: labelCancel,
                    className: 'btn-default'
                },
                confirm: {
                    label: labelYes,
                    className: 'btn-success'
                }
            },
            callback: function (result) {
                return true;
            }
        });
    }else if(!labelButton && WithCallback){
        bootbox.confirm({
            title: Title,
            message: Message,
            buttons: {
                cancel: {
                    label: labelCancel,
                    className: 'btn-default'
                },
                confirm: {
                    label: labelYes,
                    className: 'btn-success'
                }
        },
        callback: function (result) {
           if(result){//yes
               ConfirmCallback();
           }else{//No
               CancelCallBack();
           }
        }
        });
    }
}
  $('body').on('click','#max-scroll',function(){
      //alert('yy');
        scrolldesc = $('#scroll-description').text();
        if(scrolldesc=="Minimize") {
            $('#scroll-description').text('Maximize');
            $('.table-scroll').removeClass('max-scroll');
            $('#max-scroll i').removeClass('fa fa-caret-up');
            $('#max-scroll i').addClass('fa fa-caret-down');
        }else{
            $('#scroll-description').text('Minimize');
            $('.table-scroll').addClass('max-scroll');
            $('#max-scroll i').removeClass('fa fa-caret-down');
            $('#max-scroll i').addClass('fa fa-caret-up');
        }

    });
