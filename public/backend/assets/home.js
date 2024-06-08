$(document).ready(function () {
    $('#total-all').text(Number($('#total').text()) + Number($('#ship').text()));

    if (window.location.pathname == "/checkout") {
        getProvince();
    }
    function getProvince() {
        $.ajax({
            url: '/province',
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                data.forEach(element => {
                    var option = `<option value=${element.id}>${element._name}</option>`;
                    $('select[name="province"]').append(option);
                })


            }
        });
    }

    function getDistrict(province_id, current) {
        $('select[name="district"]').find('option').remove();
        $('select[name="district"]').append('<option value="">Chọn Quận/Huyện</option>')
        $.ajax({
            url: '/district/' + province_id,
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                data.forEach(element => {
                    var option = `<option value=${element.id}>${element._name}</option>`;
                    $('select[name="district"]').append(option);
                })


            }
        });
    }

    function getWard(district_id) {
        $('select[name="ward"]').find('option').remove();
        $('select[name="ward"]').append('<option value="">Chọn Phường/Xã</option>')
        $.ajax({
            url: '/ward/' + district_id,
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                data.forEach(element => {
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