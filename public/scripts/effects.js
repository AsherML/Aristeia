$(document).ready(function(){
    $(".read_more").click(function(){
        var temp_id=($(this).attr('id'));
        temp_id=temp_id.substring(0, temp_id.length-9);
        console.log(temp_id);
        $("#"+temp_id+"_more").removeClass("hidden");
        $(this).addClass('hidden');
    });

    $(".read_less").click(function(){
        var temp_id=($(this).attr('id'));
        temp_id=temp_id.substring(0, temp_id.length-6);
        console.log(temp_id);
        $("#"+temp_id+"_more").addClass("hidden");
        $("#"+temp_id+"_expander").removeClass('hidden');
    });
    $("#open_login").click(function(){
        if($("ul.login").hasClass("hidden")){
            $("ul.login").removeClass("hidden");
            $("form.hidden").removeClass('hidden');
        }
        else{
            $("ul.login").addClass("hidden");
            $('form.login').addClass("hidden")
        }
    })
    $("#add_book").click(function(){
        if($(".popup").hasClass("hidden")){
            $(".popup").removeClass("hidden");
        }
    })
    $("#close_popup").click(function(){
        if(!$(".popup").hasClass("hidden")){
            $(".popup").addClass("hidden");
        }
    })
    $(".container").mouseenter(function(){
        $(this).find("img").addClass("darken");
        $(this).find(".book_delete").removeClass("hidden");
    })
    $(".container").mouseleave(function(){
        $(this).find(".book_delete").addClass("hidden");
        $(this).find("img").removeClass("darken");

    })



})
