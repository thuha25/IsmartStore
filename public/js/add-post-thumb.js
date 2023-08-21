$(document).ready(function () {
    $(".preview .add-file-btn").click(function () {
        $("input[type='file']#post-thumb").click();
    });
    $(document).on('click', ".preview .black-bg", function () {
        $("input[type='file']#post-thumb").click();
    });
    $("input[type='file']#post-thumb").on('change', function () {
        let img_src = URL.createObjectURL(event.target.files[0]);
        strHTML = "<div class=\"post-thumb-container\">" +
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

    $(document).on('click', ".post-category", function () {
        let checkBoxes = $(this).find("input[type='checkbox']");
        checkBoxes.prop("checked", !checkBoxes.prop("checked"));
        $(this).toggleClass("post-category-active");
        if (checkBoxes.prop('checked')) {
            let post_cat_name = checkBoxes.closest('li').find('span').text();
            let post_cat_value = checkBoxes.attr("value");
            let strHTML = "<li>" +
                "<div class=\"post-category-active\" data-id=\""+post_cat_value+"\">" +
                "<span><i class=\"fas fa-times\"></i>"+post_cat_name+"</span>" +
                "</div>" +
                "</li>";
            $(".selected-categories ul").append(strHTML);
        };
        if(!checkBoxes.prop('checked')){
            let checkBoxesValue = checkBoxes.attr("value");
            $(".selected-categories ul li").each(function(){
                let postCategoryValue = $(this).find(".post-category-active").attr("data-id");
                if(postCategoryValue == checkBoxesValue){
                    $(this).remove();
                }
            });
        }
    });
    $(document).on('click', '.selected-categories .post-category-active', function () {
        let postCategoryValue = $(this).attr("data-id");
        $(".post-category").find("input[type='checkbox']").each(function(){
            if($(this).attr("value") == postCategoryValue){
                $(this).prop('checked',false);
                $(this).closest(".post-category").toggleClass("post-category-active");

            }
        });
        $(this).closest('li').remove();
    });
});
