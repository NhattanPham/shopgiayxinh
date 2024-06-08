jQuery(document).ready(function ($) {
    // $(document).ready(function () {
    let dataTransfer = new DataTransfer();
    $('.uk-sortable').on({
        'start.uk.sortable': function () {
            updateDataImages();
        },
        'move.uk.sortable': function () {
            updateDataImages();
        },
        'change.uk.sortable': function () {
            updateDataImages();
        }
    });

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

    function displayImages(event) {
        const files = event.target.files;
        $.each(files, function (index, file) {
            const reader = new FileReader();
            reader.onload = function () {
                const imageName = file.name;
                const divTag = `
                    <div class="uk-width-1-5 imageItem" data-name="${imageName}" data-isadd="true" data-size="${file.size}">
                    <div class="thumbnail-container">
                        <img class="uk-thumbnail" src="${reader.result}" alt="Not found">
                        <i class="uk-icon-close removeImage"></i>
                    </div>
                    </div>`;
                $("#imageContainer").append(divTag);
            };
            reader.readAsDataURL(file);
            dataTransfer.items.add(file);
        });
        updateDataImages();
        console.log("Data transfer", $("#images")[0].files);
    }

    function updateDataImages() {
        // console.log('sortable',$('.uk-sortable').data("sortable").serialize());
        listImage = $('.uk-sortable').data("sortable").serialize();
        $('input[name="listimage"]').val(window.JSON.stringify(listImage));
        const filesSaveTransfer = new DataTransfer();
        $.each(listImage, function (index, data) {
            for (let i = 0; i < dataTransfer.files.length; i++) {
                const file = dataTransfer.files[i];
                if (file.name === data.name && data.isadd && file.size == data.size) {
                    filesSaveTransfer.items.add(file);
                }
            }
        });
        $("#images")[0].files = filesSaveTransfer.files;
        console.log("fileSave", $("#images")[0].files);
        console.log('files', $("#addImage")[0].files);
    }
    $(document).on('click', '.removeImage', function (event) {
        $(this).closest('div.imageItem').remove();
        updateDataImages();
        // updateFilesInput();
    });
    $("form[name='adminForm']").on('submit', function () {
        updateDataImages();

    });

    $("#addImage").on("change", displayImages);
});