function uploadImages(url,data,id,image)
{
    var swfu;
    swfu = new SWFUpload({
        // Backend Settings
        upload_url: url,
        post_params: data,
        // File Upload Settings
        file_size_limit : "2 MB",   // 2MB
        file_types : "*.jpg;*.bmp;*.png;*.jpeg;*.gif;*.pdf;*.xls;*.doc;*.ppt",
        file_types_description : "All Files",
        file_upload_limit : "0",

        file_queue_error_handler : fileQueueError,
        file_dialog_complete_handler : fileDialogComplete,
        upload_progress_handler : uploadProgress,
        upload_error_handler : uploadError,
        upload_success_handler : uploadSuccess,
        upload_complete_handler : uploadComplete,

        // Button Settings
        button_image_url : image[1],
        button_placeholder_id : id,
        button_width: 100,
        button_height: 34,
        button_text : '<div class="btnText">'+image[2]+'</div>',
        button_text_style : ".btnText{ color:#ffffff;size:16px;width:100%;text-align:center;}",
        button_text_top_padding: 5,
        button_text_left_padding: 5,
        button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
        button_cursor: SWFUpload.CURSOR.HAND,
        // Flash Settings
        flash_url : image[0],
        custom_settings : {
            upload_target : "divFileProgressContainer"
        },
        // Debug Settings
        debug: false
    });
}
function fileQueueError(file, errorCode, message){
try {
        var error = "";
        switch (errorCode) {
            case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
                imageName = window.path+"/images/zerobyte.gif";
                break;
            case SWFUpload.SWFUpload.errorCode_QUEUE_LIMIT_EXCEEDED:
                error = "Upload too many files";
                break;
            case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
                imageName = window.path+"/images/toobig.gif";
                break;
            case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
            case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE:
            default:
                error = message;
                break;
        }
        alert(error);
        // return;

    } 
    catch (ex) {
        this.debug(ex);
    }
    
    
}

function fileDialogComplete(numFilesSelected, numFilesQueued){
    try {
        if (numFilesQueued > 0) {
            this.startUpload();
        }
    } 
    catch (ex) {
        this.debug(ex);
    }
}

function uploadProgress(file, bytesLoaded){

    try {
        var percent = Math.ceil((bytesLoaded / file.size) * 100);
        
        var progress = new FileProgress(file, this.customSettings.upload_target);
        progress.setProgress(percent);
        if (percent === 100) {
            progress.setStatus("Create thumbnail");
            progress.toggleCancel(false, this);
        }
        else {
            progress.setStatus("Uploading");
            progress.toggleCancel(true, this);
        }
    } 
    catch (ex) {
        this.debug(ex);
    }
}

function uploadSuccess(file, serverData){
   eval(serverData);
}

function uploadComplete(file){
    try {
        if (this.getStats().files_queued > 0) {
            this.startUpload();
        }else {
            var progress = new FileProgress(file, this.customSettings.upload_target);
            progress.setComplete();
            progress.setStatus("all files upload succeed");
            progress.toggleCancel(false);
        }
    }catch (ex) {
        this.debug(ex);
    }
}

function uploadError(file, errorCode, message){
    try {
        switch (errorCode) {
            case SWFUpload.UPLOAD_ERROR.HTTP_ERROR:
            this.debug("Error Code: HTTP_ERROR, file: " + file.name + ", error: " + message);
            break;
            case SWFUpload.UPLOAD_ERROR.UPLOAD_FAILED:
            this.debug("Error Code: UPLOAD_FAILED, file: " + file.name + ", size: " + file.size + ", error: " + message);
            break;
            case SWFUpload.UPLOAD_ERROR.IO_ERROR:
            this.debug("Error Code: IO_ERROR, file: " + file.name + ", error: " + message);
            break;
            case SWFUpload.UPLOAD_ERROR.SECURITY_ERROR:
            this.debug("Error Code: SECURITY_ERROR, file: " + file.name + ", error: " + message);
            break;
            case SWFUpload.UPLOAD_ERROR.UPLOAD_LIMIT_EXCEEDED:
            this.debug("Error Code: UPLOAD_LIMIT_EXCEEDED, file: " + file.name + ", size: " + file.size + ", error: " + message);
            break;
            case SWFUpload.UPLOAD_ERROR.FILE_VALIDATION_FAILED:
            this.debug("Error Code: FILE_VALIDATION_FAILED, file: " + file.name + ", size: " + file.size + ", error: " + message);
            break;
            case SWFUpload.UPLOAD_ERROR.FILE_CANCELLED:
            // If there aren't any files left (they were all cancelled) disable the cancel button
            this.debug("Error Code: FILE_CANCELLED");
            break;
            case SWFUpload.UPLOAD_ERROR.UPLOAD_STOPPED:
            this.debug("Error Code:UPLOAD_STOPPED");
            break;
            default:
            this.debug("Error Code: " + errorCode + ", file: " + file.name + ", size: " + file.size + ", error: " + message);
            break;
        }
    } catch (ex) {
        this.debug(ex);
    }
}

function FileProgress(file, targetID){
    this.fileProgressID = "divFileProgress";
    
    this.fileProgressWrapper = document.getElementById(this.fileProgressID);
    if (!this.fileProgressWrapper) {
        this.fileProgressWrapper = document.createElement("div");
        this.fileProgressWrapper.className = "progressWrapper";
        this.fileProgressWrapper.id = this.fileProgressID;
        
        this.fileProgressElement = document.createElement("div");
        this.fileProgressElement.className = "progressContainer";
        
        var progressCancel = document.createElement("a");
        progressCancel.className = "progressCancel";
        progressCancel.href = "#";
        progressCancel.style.visibility = "hidden";
        progressCancel.appendChild(document.createTextNode(" "));
        
        var progressText = document.createElement("div");
        progressText.className = "progressName";
        progressText.appendChild(document.createTextNode(file.name));
        
        var progressBar = document.createElement("div");
        progressBar.className = "progressBarInProgress";
        
        var progressStatus = document.createElement("div");
        progressStatus.className = "progressBarStatus";
        progressStatus.innerHTML = "&nbsp;";
        
        this.fileProgressElement.appendChild(progressCancel);
        this.fileProgressElement.appendChild(progressText);
        this.fileProgressElement.appendChild(progressStatus);
        this.fileProgressElement.appendChild(progressBar);
        
        this.fileProgressWrapper.appendChild(this.fileProgressElement);
        
        document.getElementById(targetID).appendChild(this.fileProgressWrapper);
        fadeIn(this.fileProgressWrapper, 0);
        
    }
    else {
        this.fileProgressElement = this.fileProgressWrapper.firstChild;
        this.fileProgressElement.childNodes[1].firstChild.nodeValue = file.name;
    }
    
    this.height = this.fileProgressWrapper.offsetHeight;
    
}

FileProgress.prototype.setProgress = function(percentage){
    this.fileProgressElement.className = "progressContainer green";
    this.fileProgressElement.childNodes[3].className = "progressBarInProgress";
    this.fileProgressElement.childNodes[3].style.width = percentage + "%";
};
FileProgress.prototype.setComplete = function(){
    this.fileProgressElement.className = "progressContainer blue";
    this.fileProgressElement.childNodes[3].className = "progressBarComplete";
    this.fileProgressElement.childNodes[3].style.width = "";
    
};
FileProgress.prototype.setError = function(){
    this.fileProgressElement.className = "progressContainer red";
    this.fileProgressElement.childNodes[3].className = "progressBarError";
    this.fileProgressElement.childNodes[3].style.width = "";
    
};
FileProgress.prototype.setCancelled = function(){
    this.fileProgressElement.className = "progressContainer";
    this.fileProgressElement.childNodes[3].className = "progressBarError";
    this.fileProgressElement.childNodes[3].style.width = "";
    
};
FileProgress.prototype.setStatus = function(status){
    this.fileProgressElement.childNodes[2].innerHTML = status;
};

FileProgress.prototype.toggleCancel = function(show, swfuploadInstance){
    this.fileProgressElement.childNodes[0].style.visibility = show ? "visible" : "hidden";
    if (swfuploadInstance) {
        var fileID = this.fileProgressID;
        this.fileProgressElement.childNodes[0].onclick = function(){
            swfuploadInstance.cancelUpload(fileID);
            return false;
        };
    }
};
