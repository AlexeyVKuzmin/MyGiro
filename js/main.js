// Выделение активной кнопки Главного меню при клике
var menuContainer = document.getElementById("selmenu");
var btns = menuContainer.getElementsByClassName("limenu");
for (var i = 0; i < btns.length; i++) {
  btns[i].addEventListener("click", function(){
    var current = document.getElementsByClassName("active");
    current[0].className = current[0].className.replace(" active", "");
    this.className += " active";
  });
}
// Выделение активной кнопки Главного меню при скроллинге
jQuery(function ($) {
    $(window).scroll(function(){
        $(".section").each(function () {
          var window_top = $(window).scrollTop();
          var div_top = $(this).offset().top;
          var div_1 = $(this).attr('id');
            if (window_top > div_top - 120){
                $('#selmenu').find('a').removeClass('active');
                $('#selmenu').find('a[class="'+div_1+'"]').addClass('active');
            }
            else{
                $('#selmenu').find('a[class="'+div_1+'"]').removeClass('active');
                };
        });
	});
});

/*Выбор категорий оборудования*/
filterSelection("all")
function filterSelection(c) {
  var x, i;
  x = document.getElementsByClassName("column");
  if (c == "all") c = "";
  for (i = 0; i < x.length; i++) {
    w3RemoveClass(x[i], "show");
    if (x[i].className.indexOf(c) > -1) w3AddClass(x[i], "show");
  }
}

function w3AddClass(element, name) {
  var i, arr1, arr2;
  arr1 = element.className.split(" ");
  arr2 = name.split(" ");
  for (i = 0; i < arr2.length; i++) {
    if (arr1.indexOf(arr2[i]) == -1) {element.className += " " + arr2[i];}
  }
}

function w3RemoveClass(element, name) {
  var i, arr1, arr2;
  arr1 = element.className.split(" ");
  arr2 = name.split(" ");
  for (i = 0; i < arr2.length; i++) {
    while (arr1.indexOf(arr2[i]) > -1) {
      arr1.splice(arr1.indexOf(arr2[i]), 1);     
    }
  }
  element.className = arr1.join(" ");
}

var btnContainer = document.getElementById("BtnContainer");
var btns = btnContainer.getElementsByClassName("btn");
for (var i = 0; i < btns.length; i++) {
  btns[i].addEventListener("click", function(){
    var current = document.getElementsByClassName("act");
    current[0].className = current[0].className.replace("act", "");
    this.className += " act";
  });
}

/*кнопка "наверх"*/
document.addEventListener("DOMContentLoaded", function () {
  const backToTop = document.getElementById("back-to-top");
 
  // Показать/скрыть кнопку при прокрутке страницы
  window.addEventListener("scroll", function () {
    if (window.pageYOffset>350) {
      backToTop.style.display = "block";
    } else {
      backToTop.style.display = "none";
    }
  });
 
  // Плавная прокрутка при клике на кнопку "наверх"
  backToTop.addEventListener("click", function (event) {
    event.preventDefault();
    window.scrollTo({ top: 0, behavior: "smooth" });
  });
});

