$(document).ready(function() {
    $('.nav-link.active .sub-menu').slideDown();
    $('#sidebar-menu .arrow').click(function() {
        $(this).parents('li').children('.sub-menu').slideToggle();
        $(this).toggleClass('fa-angle-right fa-angle-down');
    });

    $("input[name='checkall']").click(function() {
        var checked = $(this).is(':checked');
        $('.table-checkall tbody tr td input:checkbox').prop('checked', checked);
    });
    
});


var backToTop = document.getElementById("back_to_top");
var headerFix = document.querySelector(".header_nav_fix");
var btnMore = document.querySelector(".btn__more");
var chooseColor = document.querySelectorAll(".color__item");
backToTop.style.display = "none";
headerFix.style.display = "none";
$(".product__img_slider").slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    fade: true,
    asNavFor: ".product__img_slider_nav",
});
$(".product__img_slider_nav").slick({
    slidesToShow: 4,
    slidesToScroll: 1,
    asNavFor: ".product__img_slider",
    dots: false,
    arrows: false,
    centerMode: false,
    focusOnSelect: true,
});

window.onscroll = function () {
    if (this.scrollY > 300) {
        backToTop.style.display = "block";
        headerFix.style.display = "block";
    } else {
        backToTop.style.display = "none";
        headerFix.style.display = "none";
    }
};
chooseColor.forEach((item) => {
    item.onclick = function () {
        chooseColor.forEach((i) => {
            if (i.classList.contains("active")) {
                i.classList.remove("active");
            }
        });
        item.classList.add("active");
        document.querySelector(".color__err").style.display = "none";
    };
});
var is_more = false;
if (btnMore) {
    btnMore.onclick = function (e) {
        if (is_more) {
            document.querySelector(".product__desc").style.height = "400px";
            btnMore.innerHTML = "xem thêm";
            is_more = false;
        } else {
            document.querySelector(".product__desc").style.height = "auto";
            btnMore.innerHTML = "Thu gọn";
            is_more = true;
        }
    };
}
$(document).ready(function () {
    $(".slider__content").slick({
        autoplay: true,
        autoplaySpeed: 3000,
        dots: true,

    });
    $(".product__carousel").slick({
        slidesToShow: 5,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
    });
    var citis = document.getElementById("city");
    var districts = document.getElementById("district");
    var wards = document.getElementById("ward");
    var Parameter = {
        url: "https://raw.githubusercontent.com/kenzouno1/DiaGioiHanhChinhVN/master/data.json",
        method: "GET",
        responseType: "application/json",
    };
    var promise = axios(Parameter);
    promise.then(function (result) {
        renderCity(result.data);
    });

    function renderCity(data) {
        for (const x of data) {
            citis.options[citis.options.length] = new Option(x.Name, x.Name);
        }
        citis.onchange = function () {
            districts.length = 1;
            wards.length = 1;
            if (this.value != "") {
                const result = data.filter(n => n.Name === this.value);

                for (const k of result[0].Districts) {
                    districts.options[districts.options.length] = new Option(k.Name, k.Name);
                }
            }
        };
        districts.onchange = function () {
            wards.length = 1;
            const dataCity = data.filter((n) => n.Name === citis.value);
            if (this.value != "") {
                const dataWards = dataCity[0].Districts.filter(n => n.Name === this.value)[0].Wards;

                for (const w of dataWards) {
                    wards.options[wards.options.length] = new Option(w.Name, w.Name);
                }
            }
        };
    }
});
