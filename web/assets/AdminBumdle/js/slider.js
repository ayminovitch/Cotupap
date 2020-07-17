Dropzone.options.formWithDropzone = {
    autoProcessQueue: false,
    uploadMultiple: false,
    paramName: "files",
    parallelUploads: 10,
    maxFiles: 1,
    addRemoveLinks: true,
    acceptedFiles: 'image/*',
    init: function(){
        var dropZone = this;
        this.on("maxfilesexceeded", function(file) {
            this.removeAllFiles();
            this.addFile(file);
        });
        $('#submit').click(function(e){
            e.preventDefault();
            e.stopPropagation();
            dropZone.processQueue();
        });

        dropZone.on("success", function(file, response) {
            if(dropZone.getAcceptedFiles().length > 0){
                location.reload();
                // $.gritter.add({
                //     title : 'Upload Complete',
                //     text : response.message + '\n\nA total of: ' + dropZone.getAcceptedFiles().length + ' images uploaded successfully!',
                //     class_name : 'gritter-success'
                // })
            }else{
                $.gritter.add({
                    title : 'Upload Incomplete',
                    text : response.message,
                    class_name : 'gritter-error'
                })
            }
        });
    }
}

function removeSlider(sliderId, url) {
    console.log(sliderId);
    $.ajax({
        type: "post",
        url: url,
        data: {
            'id': sliderId,
        },
        success: function(response) {
            location.reload();
        },
    });
}