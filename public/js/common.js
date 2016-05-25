$(document).ready(function() {

    //Всплывающий календарь
    $("input#date").datepicker({});

    //Маска для ввода телефона
    $("#phone").mask("(999) 999-99-99",{placeholder:"x"});
    $("#phone2").mask("(999) 999-99-99",{placeholder:"x"});
    $("#phone3").mask("(999) 999-99-99",{placeholder:"x"});
    $("#phone4").mask("(999) 999-99-99",{placeholder:"x"});
    $("#schedule").mask("c 99:99 - 99:99",{placeholder:"0"});
    $("#lunch").mask("c 99:99 - 99:99",{placeholder:"0"});

    //верхний отступ для админ меню
    var adminMenu = $('.admin-menu-wrapper');
    if(adminMenu.html())
        $('body > div.wrapper').css({'margin-top':adminMenu.height()+'px'});

    //Визуализация удаления изображения при редактировании концерта
    var deleteImgLink = $('#delete-img');

    if($('a').is(deleteImgLink))
    {
        var thumbField = $('#form-edit-account .form-item-imgthumb');
        var addImgField = $('#form-edit-account .form-item-img').remove();

        deleteImgLink.click(function(){

            thumbField.after(addImgField).remove();
            return false;
        });
    }

    //easyTooltip для информации о концерте на главной странице
  /*
  var toolTips = [];
  $(".concert-list-item").each(function(e){
    var key = $(this).data('key')
    toolTips[key] = $('#item-'+key);
  });
*/
  $(".concert-list-item").easyTooltip();







    //End code...
});