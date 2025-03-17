jQuery(document).ready(function($) {
    $('#golf-course-ranking button').on('click', function() {
        var ranking = $(this).data('ranking');
        var postId = <?php echo get_the_ID(); ?>;

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'save_golf_course_ranking',
                post_id: postId,
                ranking: ranking,
            },
            success: function(response) {
                alert('Gracias por tu voto!');
            }
        });
    });
});