
function clean(url) {
    window.location.href = url;
}
jQuery(document).ready(function ($) {
    // toggle menu sidebar
    $(".toggle-sidebar").on("click", function () {
        $(".sidebar").toggleClass("active");
    });
    $.fn.submitList = function (task = '') {
        $("input[name='task']:hidden").val(task);
        if (task == 'changeAction') {
            let flag = 0;
            $("input[name='ids[]']:checkbox").each(function () {
                if ($(this).is(":checked")) {
                    flag = 1;
                    return false;
                }
            });
            if (flag == 1) {
                let select_action = $("select[name='action']").val();
                if (select_action == 'delete') {
                    UIkit.modal.confirm('Bạn chắc chắn muốn xóa không?', function () {
                        $("form[name='adminList']").submit();
                        return false;
                    })
                } else {
                    if (select_action.length > 0) {
                        $("form[name='adminList']").submit();
                    } else {
                        UIkit.modal.alert("Bạn chưa chọn hành động!");
                    }
                }
            } else {
                UIkit.modal.alert("Bạn chưa chọn mục nào!", { center: true });
            }
        } else {
            $("form[name='adminList']").submit();
        }
    }

    $.fn.changeNumbePage = function (url) {
        $(location).attr('href', url);
        // console.log(1)
    }
    $('.select-all').on('change', function () {
        if ($(this).is(':checked')) {
            $("input[name='ids[]']").each(function () {
                $(this).prop('checked', true);
            });
        } else {
            $("input[name='ids[]']").each(function () {
                $(this).prop('checked', false);
            });
        }
    });
    $.fn.submitForm = function (action = '') {
        $("input[name='action']:hidden").val(action);
        $("form[name='adminForm']").submit();
    }

    // Product
    $(".colors-input-tag").keydown(function (event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            const tagContent = $(this).val().trim();
            if (tagContent !== '') {
                $(".colors-list-tag").append('<li data-value="' + tagContent + '">' + tagContent + '<button class="del-tag">X</button></li>');
                getTags('colors');
                $(this).val('');
            }
        }
    });

    $(".colors-list-tag").click(function (event) {
        if (event.target.classList.contains('del-tag')) {
            event.target.parentNode.remove();
            getTags('colors');
        }
    });
    $(".sizes-input-tag").keydown(function (event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            const tagContent = $(this).val().trim();
            if (tagContent !== '') {
                $(".sizes-list-tag").append('<li data-value="' + tagContent + '">' + tagContent + '<button class="del-tag">X</button></li>');
                getTags('sizes');
                $(this).val('');
            }
        }
    });

    $(".sizes-list-tag").click(function (event) {
        if (event.target.classList.contains('del-tag')) {
            event.target.parentNode.remove();
            getTags('sizes');
        }
    });
    function getTags(type) {
        let tags = '';
        $("." + type + "-list-tag li").each(function () {
            if (tags == '') {
                tags = $(this).data('value');
            } else {
                tags += ',' + $(this).data('value');
            }
        })
        $("input[name='" + type + "']:hidden").val(tags);
    }
    // Display thumbnail
    function displayThumbnail(event) {
        $('#thumbnail-container').find('img').remove();
        const file = event.target.files[0];
        const reader = new FileReader();
        reader.onload = function () {
            const imgTag = `<img class="uk-thumbnail" src="${reader.result}"
                                alt="Not found">`;
            $('#thumbnail-container').append(imgTag);
        }
        reader.readAsDataURL(file);
    }

    $("#thumbnail").on('change',displayThumbnail);
    // Menu

    $('.select-menu-all').on('change', function () {
        let type = $(this).data('menu_type');
        if (this.checked) {
            $('.' + type).find('input[type="checkbox"]').each(function () {
                $(this).prop("checked", true);
            })
        } else {
            $('.' + type).find('input[type="checkbox"]').each(function () {
                $(this).prop("checked", false);
            })
        }
    });

    function updateListData() {
        var listdata = $('.uk-nestable').data("nestable").serialize();
        console.log(listdata);
        var input = $('input[name="list_data"]:hidden');
        input.val(window.JSON.stringify(listdata));
    }
    updateListData();
    $('.uk-nestable').on({
        'start.uk.nestable': function () {
            updateListData();
        },
        'move.uk.nestable': function () {
            updateListData();
        },
        'change.uk.nestable': function () {
            updateListData();
        }
    });
    function clearAllAttr() {
        $('.options').find('input[name="menu_name"]').val('');
        $('.options').find('input[name="menu_url"]').val('');
        $('input[type="checkbox"]').each(function () {
            $(this).prop('checked', false);
        })
    }
    $.fn.addMenuItem = function (type) {
        if (type == 'options') {
            let menuName = $('.options').find('input[name="menu_name"]').val();
            let menuUrl = $('.options').find('input[name="menu_url"]').val();
            createMenu('options', menuName, 0, '', '', menuUrl);
        } else {
            var list = $('.' + type).find('input[type="checkbox"]:checked').not('.select-menu-all');
            list.each(function () {
                createMenu(type, $(this).data('name'), $(this).data('type_id'), '', '', $(this).data('url'));
            })
        }
        clearAllAttr();
    }
    function createMenu(type, name, type_id, menu_class, rel, url) {
        $('.uk-nestable').append(`<li class="uk-nestable-item" data-id="new"
        data-name="${name}"
        data-type="${type}"
        data-type_id="${type_id}"
        data-class="${menu_class}" data-rel="${rel}" data-url="${url}"
    >
    <div class="uk-nestable-panel">
                <i class="uk-nestable-handle uk-icon uk-icon-bars uk-margin-small-right"></i> <span>${name}</span>
                <button class="uk-button uk-button-mini uk-accordion-toggle uk-float-right" type="button">
                    <i class="uk-icon-chevron-down"></i>
                </button>
    </div>
            <div class="uk-accordion-content uk-form-horizontal uk-margin-top">
                <div class="uk-form-row">
                    <label class="uk-form-label">Tiêu đề</label>
                    <div class="uk-form-controls">
                        <input  class="uk-width-1-2 name_menu" type="text" name="" value="${name}">
                    </div>
                </div>
                <div class="uk-form-row">
                    <label class="uk-form-label">URL</label>
                    <div class="uk-form-controls">
                        <input class="uk-width-1-2 url_menu" type="text" ${type!='options'?"readonly":""} name="" value="${url}" >
                    </div>
                </div>
                <div class="uk-form-row">
                    <label class="uk-form-label">Class</label>
                    <div class="uk-form-controls">
                        <input class="uk-width-1-2 class_menu" type="text" name="" value="">
                    </div>
                </div>
                <div class="uk-form-row">
                    <label class="uk-form-label">Rel</label>
                    <div class="uk-form-controls">
                        <input class="uk-width-1-2 rel_menu" type="text" name="" value="">
                    </div>
                </div>
                <div class="uk-form-row"></div>
                <div class="uk-form-row">
                    <label class="uk-form-label">Target</label>
                    <div class="uk-form-controls">
                        <label>
                            <input type="checkbox" class="target_menu" value="1" > Cửa sổ mới
                        </label>
                    </div>
                </div>
                <div class="uk-form-row">
                    <button type="button" class="uk-button uk-button-link remove-menu"><i class="uk-icon-close"></i> Xóa bỏ</button>
                </div>
            </div>
    </li>`);
        UIkit.accordion($('.uk-nestable')).update();
        updateListData();
    }
    // $('.rel_menu').each(function () {
    //     $(this).on('change', function () {
    //         var value = $(this).val();
    //         var li = $(this).closest('li.uk-nestable-item');
    //         li.attr('data-rel', value);
    //     })
    // });
    $(document).on('change','.name_menu',function(){
        var value = $(this).val();
        var li = $(this).closest('li.uk-nestable-item');
        var span = li.find('span:first');
        li.attr('data-name', value);
        span.text(value);
        updateListData();
    });
    $(document).on('change','.url_menu',function(){
        var value = $(this).val();
            var li = $(this).closest('li.uk-nestable-item');
            li.attr('data-url', value);
            updateListData();
    });
    $(document).on('change','.class_menu',function(){
        $(this).on('change', function () {
            var value = $(this).val();
            var li = $(this).closest('li.uk-nestable-item');
            li.attr('data-class', value);
            updateListData();
        })
    });
    $(document).on('change','.rel_menu',function(){
        var value = $(this).val();
            var li = $(this).closest('li.uk-nestable-item');
            li.attr('data-rel', value);
            updateListData();
    });
    $(document).on('click','.remove-menu',function(){
        var li = $(this).closest('li.uk-nestable-item');
        li.remove();
        updateListData();
    })
    // $('.remove-menu').each(function () {
    //     $(this).on('click', function () {
    //         var li = $(this).closest('li.uk-nestable-item');
    //         li.remove();
    //         updateListData();
    //     })
    // });
});

var editor_config = {
    path_absolute: "/admin/",
    selector: "#description",
    plugins: [
        "autoresize advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor colorpicker textpattern"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
    relative_urls: false,
    file_browser_callback: function (field_name, url, type, win) {
        var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName(
            'body')[0].clientWidth;
        var y = window.innerHeight || document.documentElement.clientHeight || document
            .getElementsByTagName('body')[0].clientHeight;

        var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
        if (type == 'image') {
            cmsURL = cmsURL + "&type=Images";
        } else {
            cmsURL = cmsURL + "&type=Files";
        }

        tinyMCE.activeEditor.windowManager.open({
            file: cmsURL,
            title: 'Filemanager',
            width: x * 0.8,
            height: y * 0.8,
            resizable: "yes",
            close_previous: "no"
        });
    }
};

tinymce.init(editor_config);

