jQuery(document).ready(function ($) {
    $('#llh-cover-upload').on('click', function (e) {
        e.preventDefault();

        const imageFrame = wp.media({
            title: 'Select Book Cover',
            multiple: false,
            library: { type: 'image' },
            button: { text: 'Use this image' }
        });

        imageFrame.on('select', function () {
            const attachment = imageFrame.state().get('selection').first().toJSON();
            $('#llh_cover').val(attachment.url);
            $('#llh-cover-preview').attr('src', attachment.url).show();
        });

        imageFrame.open();
    });
});
