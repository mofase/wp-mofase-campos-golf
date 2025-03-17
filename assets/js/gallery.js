jQuery(document).ready(function($) {
    var file_frame;
    $('#galeria_de_imagenes_button').on('click', function(event) {
        event.preventDefault();
        if (file_frame) {
            file_frame.open();
            return;
        }
        file_frame = wp.media.frames.file_frame = wp.media({
            title: 'Seleccione o suba imágenes',
            button: {
                text: 'Usar estas imágenes',
            },
            multiple: true
        });
        file_frame.on('select', function() {
            var attachments = file_frame.state().get('selection').map(function(attachment) {
                attachment = attachment.toJSON();
                return attachment;
            });
            var attachmentIDs = attachments.map(function(attachment) {
                return attachment.id;
            });
            $('#galeria_de_imagenes').val(attachmentIDs.join(','));
            var previewHTML = attachments.map(function(attachment) {
                return '<img src="'+attachment.url+'" style="max-width: 100px; margin: 5px;" />';
            }).join('');
            $('#galeria_de_imagenes_preview').html(previewHTML);
        });
        file_frame.open();
    });
});