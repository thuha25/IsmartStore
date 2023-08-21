$(document).ready(function () {
    $(".preview .add-file-btn").click(function () {
        $("input[type='file']#images-product").click();
    });
    $(document).on('click', ".preview .black-bg", function () {
        $("input[type='file']#images-product").click();
    });
    $("input[type='file']#images-product").on('change', function () {
        let img_src = URL.createObjectURL(event.target.files[0]);
        strHTML = "<div class=\"images-product-container\">" +
            "<div class=\"black-bg\">" +
            "<div class=\"change-img-btn\">" +
            "<span>" +
            "<i class=\"fas fa-pen\"></i>" +
            "</span>" +
            "</div>" +
            "</div>" +
            "<img src=\"" + img_src + "\" alt=\"\">" +
            "</div>";

        $(".preview").html(strHTML);
    });
});
