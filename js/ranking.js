jQuery(document).ready(function($) {
    $('#golf-course-ranking button').on('click', function() {
        var ranking = $(this).data('ranking');
        $.post(golfCourseRanking.ajax_url, {
            action: 'golf_course_ranking',
            post_id: golfCourseRanking.post_id,
            ranking: ranking
        }, function(response) {
            if (response.success) {
                alert('Ranking actualizado a ' + ranking + ' estrellas.');
            } else {
                alert('Error al actualizar el ranking.');
            }
        });
    });
});