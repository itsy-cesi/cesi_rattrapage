$(function(){
    $.cookie('user_token')&&$.ajax({type:'POST',url:'/api/'});
    $('input').on('keypress click',function(){
        $(`input[name="${$(this).attr('name')}"]`).removeClass('is-invalid');
    });
    $('*[name="register_form"],*[name="login_form"]').submit(function(event){
        event.preventDefault();
        const form=$(this),
        formInputs=form.serializeArray().reduce((obj,item)=>(obj[item.name]=item.value,obj),{});
        $.ajax({
            type:'POST',
            url:form.attr('action'),
            headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
            data:JSON.stringify(formInputs),
            contentType:'application/json',
            success:function(data){
                console.log(data);
                data.type==='redirect'&&(document.location=data.redirect);
            },
            statusCode:{
                422:function(xhr){
                    console.log(xhr.responseText);
                    $(':input').removeClass('is-invalid');
                    Object.entries(JSON.parse(xhr.responseText).error).forEach(([field,message])=>(
                        $(form).find(`input[name="${field}"]:not([class*="is-invalid"])`).addClass('is-invalid'),
                        $(form).find(`div[name="valid-${field}"]`).html(message)
                    ));
                },
                401:function(xhr){
                    new Noty({
                        timeout:3000,
                        type:'error',
                        theme:'mint',
                        text:JSON.parse(xhr.responseText).error
                    }).show();
                }
            }
        });
    });
});