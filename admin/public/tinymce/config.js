tinymce.init({
    selector: 'textarea#content',
    // theme : "advanced",
    height: 350,
    width:"",
    plugins: [
        "codemirror advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor colorpicker textpattern imagetools code fullscreen"
    ],
    toolbar1: "undo redo bold italic underline strikethrough cut copy paste| alignleft aligncenter alignright alignjustify bullist numlist outdent indent blockquote searchreplace | table | hr removeformat | subscript superscript | charmap emoticons ltr rtl | spellchecker | visualchars visualblocks nonbreaking template pagebreak restoredraft | link unlink anchor image media | insertdatetime preview | forecolor backcolor print fullscreen code",
    toolbar2: "styleselect formatselect fontselect fontsizeselect",
    image_advtab: true,
    menubar: false,
    code_dialog_height: 400,
    encoding: 'html',
    entity_encoding : 'raw', //Sửa lỗi khi hiển thị code có dấu tiếng việt
    schema: 'html5',
    toolbar_items_size: 'small',
    relative_urls: false, 
    cleanup_on_startup: false,
    trim_span_elements: false,
    verify_html: false,
    cleanup: false,
    convert_urls: false,
    element_format : 'html',
    remove_script_host : false,
    force_br_newlines : true,
    force_p_newlines : false,
    forced_root_block : '',
});

tinymce.init({
	 selector: 'textarea#desc',
	 toolbar_items_size: 'small',
	 height: 130,
	 width:"",
	 menubar: false,
	 plugins: [
		"advlist autolink lists link image charmap print preview hr anchor pagebreak",
		"searchreplace wordcount visualblocks visualchars fullscreen",
		"insertdatetime media nonbreaking save table contextmenu directionality",
		"emoticons template paste textcolor colorpicker textpattern imagetools code fullscreen"
	],
	toolbar1: "undo redo bold italic underline | alignleft aligncenter alignright alignjustify bullist numlist outdent indent blockquote link unlink anchor | preview | forecolor backcolor fullscreen code",
	image_advtab: true,
	menubar: false,
	code_dialog_height: 200,
	encoding: 'html',
	entity_encoding : 'raw', //Sửa lỗi khi hiển thị code có dấu tiếng việt
	schema: 'html5',
	toolbar_items_size: 'small',
    relative_urls: false,
    remove_script_host : false,
});	
