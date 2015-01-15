(function() {
    tinymce.PluginManager.add('IA_fbv_button', function(editor, url) {
        editor.addButton('IA_fbv_button', {
            text: '',
            icon: "fb-video",
            onclick: function() {
                editor.windowManager.open({
                    title: 'Add Facebook Video',
                    body: [{
                        type: 'textbox',
                        name: 'fbvideo_link',
                        label: 'Facebook Video URL',
                        value: ''
                    }, {
                        type: 'textbox',
                        name: 'fbvideo_width',
                        label: 'Width',
                        value: '500'
                    }, {
                        type: 'textbox',
                        name: 'fbvideo_height',
                        label: 'Height',
                        value: '400'
                    }, {
                        type: 'listbox',
                        name: 'fbvideo_video_only',
                        label: 'Display Only Video',
                        'values': [{
                            text: 'Yes',
                            value: '1'
                        }, {
                            text: 'No',
                            value: '0'
                        }]
                    }],
                    onsubmit: function(e) {
                        editor.insertContent(
                            '[fbvideo link="' +
                            e.data.fbvideo_link +
                            '" width="' +
                            e.data.fbvideo_width +
                            '" height="' +
                            e.data.fbvideo_height +
                            '" onlyvideo="' +
                            e.data.fbvideo_video_only +
                            '"]');
                    }
                });
            }
        });
    });
})();
 