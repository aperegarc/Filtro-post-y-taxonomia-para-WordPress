jQuery(document).ready(function($) {
    // Extraer post_type y taxonomy del contenedor #post-grid
    var $postGrid = $('#post-grid');
    var postType = $postGrid.data('post-type');
    var taxonomy = $postGrid.data('taxonomy');
    
    $(document).on('click', '.filter-category', function(e) {
        e.preventDefault();
        var category_id = $(this).data('category');
        
        $.ajax({
            url: postGridAjax.ajaxurl,
            type: 'POST',
            data: {
                action: 'load_posts_by_category',
                category_id: category_id,
                post_type: postType,
                taxonomy: taxonomy
            },
            beforeSend: function() {
                $postGrid.html('<p>Cargando...</p>');
            },
            success: function(response) {
                $postGrid.html(response);
            }
        });
    });
});
