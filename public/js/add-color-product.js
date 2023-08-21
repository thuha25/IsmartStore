$(document).ready(function () {
    $(document).on('click', ".product_color", function () {
        let checkBoxes = $(this).find("input[type='checkbox']");
        checkBoxes.prop("checked", !checkBoxes.prop("checked"));
        $(this).toggleClass("product-color-active");
        if (checkBoxes.prop('checked')) {
            let product_color_name = checkBoxes.closest('li').find('span').text();
            let product_color_value = checkBoxes.attr("value");
            let strHTML = "<li>" +
                "<div class=\"product-color-active\" data-id=\""+product_color_value+"\">" +
                "<span><i class=\"fas fa-times\"></i>"+product_color_name+"</span>" +
                "</div>" +
                "</li>";
            $(".selected-color ul").append(strHTML);
        };
        if(!checkBoxes.prop('checked')){
            let checkBoxesValue = checkBoxes.attr("value");
            $(".selected-color ul li").each(function(){
                let productColorValue = $(this).find(".product-color-active").attr("data-id");
                if(productColorValue == checkBoxesValue){
                    $(this).remove();
                }
            });
        }
    });
    $(document).on('click', '.selected-color .product-color-active', function () {
        let productColorValue = $(this).attr("data-id");
        $(".product_color").find("input[type='checkbox']").each(function(){
            if($(this).attr("value") == productColorValue){
                $(this).prop('checked',false);
                $(this).closest(".product_color").toggleClass("product-color-active");

            }
        });
        $(this).closest('li').remove();
    });
});
