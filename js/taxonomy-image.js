jQuery(document).ready(function($) {
    function media_upload(button_class) {
        var _custom_media = true,
            _orig_send_attachment = wp.media.editor.send.attachment;
        $('body').on('click', button_class, function(e) {
            var button_id = '#' + $(this).attr('id');
            var send_attachment_bkp = wp.media.editor.send.attachment;
            var button = $(button_id);
            _custom_media = true;
            wp.media.editor.send.attachment = function(props, attachment) {
                if (_custom_media) {
                    $('#taxonomy-image-id').val(attachment.id);
                    $('#taxonomy-image-wrapper').html('<img src="' + attachment.url + '" style="max-width:100%;"/>');
                } else {
                    return _orig_send_attachment.apply(button_id, [props, attachment]);
                }
            }
            wp.media.editor.open(button);
            return false;
        });
    }
    media_upload('.taxonomy-media-button.button');
    $('body').on('click', '.taxonomy-media-remove', function() {
        $('#taxonomy-image-id').val('');
        $('#taxonomy-image-wrapper').html('');
    });
});