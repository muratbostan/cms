$(document).ready(function(){
  $(".news_type_select").change(function(){
    if($(this).val() === "image"){
        $(".image_upload_con").fadeIn();
        $(".video_url_con").hide();
    }else{
        $(".image_upload_con").hide();
        $(".video_url_con").fadeIn();
    }
  })
})
