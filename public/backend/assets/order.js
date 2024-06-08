$(document).ready(function () {
    var modal = $('.modal');
    var btn = $('.add-product');
    var span = $('.close');

    $('form').on('keyup keypress', function (e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });
    $("form").submit(function () {
        alert("Submitted");
        updateOrdeItems();
    });
    btn.click(function () {
        modal.show();
    });
    span.click(function () {
        modal.hide();
    });
    $(window).on('click', function (e) {
        if ($(e.target).is('.modal')) {
            modal.hide();
        }
    });
    var updateOrdeItems = function () {
        // var listProduct = $('input[name="list-product"]');
        var dataOrder = $('.data-order-item');
        var listData = [];
        dataOrder.each(function (index) {
            listData.push($(this).data());
        });
        // console.log(listData.length == 0);
        if(listData.length == 0){
            $('.list-product-order').hide();
            $('.total-container').hide();
            $('.no-product-text').show();
        }else{
            $('.list-product-order').show();
            $('.total-container').show();
            $('.no-product-text').hide();
        }
        $('.list-order-item').val(window.JSON.stringify(listData));

    }
    updateOrdeItems();
    $('#select-all-product').change(function () {
        if ($(this).is(':checked')) {
            $('.checkItem').each(function () {
                $(this).prop('checked', true);
            });
        } else {
            $('.checkItem').prop('checked', false);
        }
    })
    // Add product to order 
    $('#addProduct').click(function () {
        $('input.checkItem:checked').each(function () {
            // console.log($(this).closest('tr').data())
            var dataTr = $(this).closest('tr').data();
            // console.log(dataTr.list_color)
            // color
            var product_colors = `<select class="order_item_color">`;
            dataTr.list_color.forEach(function (e) {
                product_colors += `<option ${e == dataTr.product_color ? "selected" : ""}>${e}</option>`;
            })
            product_colors += '</select>';
            // size
            var product_sizes = `<select class="order_item_size">`;
            dataTr.list_size.forEach(function (e) {
                product_sizes += `<option ${e == dataTr.product_size ? "selected" : ""}>${e}</option>`;
            })
            product_sizes += '</select>';
            var tr = `
            <tr class="data-order-item" data-id="0"
                data-product_id="${dataTr.product_id}"
                data-product_name="${dataTr.product_name}" 
                data-product_qty="1"
                data-product_price="${dataTr.product_price}"
                data-product_color="${dataTr.product_color}"
                data-product_size="${dataTr.product_size}">
                <td>
                    <img style="width:80px; height:80px"
                        src="${dataTr.product_thumbnail}" alt="Not found">
                </td>
                <td>
                    ${dataTr.product_name}
                </td>
                <td>
                    ${dataTr.product_price}
                </td>
                <td>
                    <button type="button" class="uk-button quantity-decrese">-</button>
                    <input type="number" class="input-quantity"
                        value="1">
                    <button type="button" class="uk-button quantity-increse">+</button>
                </td>
                <td class="total-price">
                    ${dataTr.product_price}
                </td>
                <td>
                    ${product_colors} 
                </td>
                <td >
                    ${product_sizes} 
                </td>
                <td>
                    <button type="button" class="uk-button delete-product">&#x2715;</button>
                </td>
                </tr>
            `;
            $('.list-product-order').append(tr);
            updateOrdeItems();
           
        });
        // updateOrdeItems();
        $('input[type="checkbox"]').each(function () {
            $(this).prop('checked', false);
        });
        updateTotalMoney();
        modal.hide();
    });
    // Pagination list product in modal
    var currentPage = 1;
    var lastPage;

    function displayListProduct(product_list) {
        $('.product-table tbody').find('tr').remove();
        // console.log(product_list);
        product_list.forEach(element => {
            var product_colors = `<select class="color">`;
            JSON.parse(element.product_colors).forEach(function (e) {
                product_colors += `<option>${e}</option>`;
            })
            product_colors += '</select>';
            var product_sizes = `<select class="size">`;
            JSON.parse(element.product_sizes).forEach(function (e) {
                product_sizes += `<option>${e}</option>`;
            })
            product_sizes += '</select>';
            var tr = `<tr data-product_id="${element.id}" data-product_name="${element.name}"
                                data-product_qty="1" data-product_color="${JSON.parse(element.product_colors)[0]}" data-product_size="${JSON.parse(element.product_sizes)[0]}"
                                data-product_price='${element.sale_price}'
                                data-list_color='${element.product_colors}'
                                data-list_size='${element.product_sizes}'
                                data-product_thumbnail="http://shopgiayxinh.local/${element.thumbnail}">
                                <td class="uk-text-middle">
                                    <input class="select-all checkItem" id="checkItem" type="checkbox"
                                        value="${element.id}">
                                </td>
                                <td><img style="width: 60px;height: 60px" src="http://shopgiayxinh.local/${element.thumbnail}"
                                        alt="Notfound"></td>
                                <td class="uk-text-middle">${element.name}
                                </td>
                                <td class="uk-text-middle">${element.product_price}</td>
                                <td class="uk-text-middle">${element.sale_price}</td>
                                <td class="uk-text-middle">
                                ${product_colors} 
                                </td>
                                <td class="uk-text-middle">
                                ${product_sizes}
                                </td>
                            </tr>`;
            $('.product-table tbody').append(tr);
        });
        $(document).on('change', 'select.color', function (event) {
            $(this).closest('tr').attr('data-product_color', $(this).val());
        });
        $(document).on('change', 'select.size', function (event) {
            $(this).closest('tr').attr('data-product_size', $(this).val());
        });
        $('#product-pagination').html('');
        for (let index = 1; index <= lastPage; index++) {
            $('#product-pagination').append(
                `<button type="button" class="uk-button button-page">${index}</button>`);
        }
        $('.button-page').each(function () {
            if ($(this).text() == currentPage) {
                $(this).addClass('uk-button-primary')
            }
            $(this).on('click', function () {
                if (currentPage != $(this).text()) {
                    currentPage = $(this).text();
                    getDataProductFromController(currentPage);
                }
            });
        });
    }
    getDataProductFromController(currentPage);
    function getDataProductFromController(page) {
        search = $('#search').val();
        $.ajax({
            url: '/admin/products/getList?search=' + search + '&page=' + page,
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                lastPage = data.last_page;
                displayListProduct(data.data);

            }
        });
    }
    // displayListProduct();
    $('#nextPage').on('click', function () {
        if (currentPage < (lastPage)) {
            currentPage++;
            getDataProductFromController(currentPage);
        }
    });
    $('#prevPage').on('click', function () {
        if (currentPage > 1) {
            currentPage--;
            getDataProductFromController(currentPage);
        }
    });

    $('#search').keyup(function (e) {
        if (e.which === 13) {
            currentPage = 1;
            getDataProductFromController(currentPage);
        }
    });
    $('#btnSearchProduct').on('click', function () {
        getDataProductFromController(1);
    });


    function updateQuantity(input, value) {
        input.val(value);
        if (input.val() < 1) {
            input.val(1);
        }
        if (input.val() > 100) {
            input.val(100);
        }
        var tr = input.closest('tr');
        tr.data('product_qty', input.val());
        input.closest('tr').find('td.total-price').text(tr.data('product_qty') * tr.data('product_price'));
        updateOrdeItems();
        updateTotalMoney();
    }
    $(document).on('input', '.input-quantity', function (event) {
        if ($(this).val() < 1) {
            $(this).val(1);
        }
        if ($(this).val() > 100) {
            $(this).val(100);
        }
        updateQuantity($(this), $(this).val());
    });
    $(document).on('click', '.quantity-decrese', function (event) {
        var inputQuantity = $(this).closest('td').find('.input-quantity');
        updateQuantity(inputQuantity, inputQuantity.val() - 1);
    });
    $(document).on('click', '.quantity-increse', function (event) {
        var inputQuantity = $(this).closest('td').find('.input-quantity');
        updateQuantity(inputQuantity, +inputQuantity.val() + 1);
    });
    $(document).on('change', 'select.order_item_color', function (event) {
        $(this).closest('tr').data('product_color', $(this).val());
        updateOrdeItems();
    });
    $(document).on('change', 'select.order_item_size', function (event) {
        $(this).closest('tr').data('product_size', $(this).val());
        updateOrdeItems();
    });
    $(document).on('click', '.delete-product', function (event) {
        $(this).closest('tr').remove();
        updateOrdeItems();
        updateTotalMoney();
    });
    $(document).on('click', '.edit-product', function(){
        $(this).closest('tr').find('.item-edit').css("display","block");
        $(this).closest('tr').find('.item-detail').css("display","none");
    });
    function updateTotalMoney() {
        var valueInput = JSON.parse($('input[name="list_order_item"]').val())
        // console.log('value',JSON.parse(valueInput));
        var totalAllPrice = 0;
        valueInput.forEach(element => {
            totalAllPrice += (element.product_qty*element.product_price)
            // console.log('total',totalAllPrice);
        });
        // console.log('total',totalAllPrice);
        $('.total-all-product span').text(totalAllPrice);
        $('.total-pay span').text(totalAllPrice + Number($('.ship span').text()));
    }
    updateTotalMoney();
    // Get Place
    if(window.location.pathname == "/admin/orders/create"){
        getProvince();
    }
     function getProvince(){
        $.ajax({
            url: '/province',
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                data.forEach(element =>{
                    var option = `<option value=${element.id}>${element._name}</option>`;
                    $('select[name="province"]').append(option);
                })
                

            }
        });
    }
    
    function getDistrict(province_id,current){
        $('select[name="district"]').find('option').remove();
        $('select[name="district"]').append('<option value="">Chọn quận/huyện</option>')
        $.ajax({
            url: '/district/'+province_id,
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                data.forEach(element =>{
                    var option = `<option value=${element.id}>${element._name}</option>`;
                    $('select[name="district"]').append(option);
                })
                

            }
        });
    }
    function getWard(district_id){
        $('select[name="ward"]').find('option').remove();
        $('select[name="ward"]').append('<option value="">Chọn phường/xã</option>')
        $.ajax({
            url: '/ward/'+district_id,
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                data.forEach(element =>{
                    var option = `<option value=${element.id}>${element._name}</option>`;
                    $('select[name="ward"]').append(option);
                })
                

            }
        });
    }
    $(document).on('change', 'select[name="province"]', function (event) {
        console.log($(this).val())
        getDistrict($(this).val());
    });
    $(document).on('change', 'select[name="district"]', function (event) {
        // console.log($(this).val())
        getWard($(this).val());
    });
});