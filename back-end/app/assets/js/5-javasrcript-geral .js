//----------------Mudar par o dominio-------/
// Esta arquivo contem rotas de configurações de entradas para o sistema e validação dos inputs inicias
const urlName = 'app-sao-roque-e-voce/back-end';
const urlCadastro = urlName+'/cadastro';
const urlLogin = urlName+'/srv/login';
const urlRedefinePassword = urlName+'/srv/redefinir_senha';
const urlNewPassword = urlName+'/srv/nova_senha';
const urlLoginRacs = urlName+'/racs/login';
const urlContatoRacs = urlName+'/contato';


//Pega o local 
function getRoot(url)
{
    var root = "http://"+document.location.hostname+"/"+url;
    return root;
}


//Sistema de loadind
const gif = getRoot(urlName+'/img/anime.gif');
const logoSrv  =  getRoot(urlName+'/img/logo-srv-200.png');
const logoRacs =  getRoot(urlName+'/img/logo-racs-100.png');
const CarregandoLoading  = () => document.getElementById('root').innerHTML = `<img  class="gif" src='${gif}' alt="Logomarca da WEF">`;
const ParandoLoading     = () => document.getElementById('root').innerHTML = `<img  src='${logoSrv}' alt="Logomarca da ">`;
const LoadingRacs        = () => document.getElementById('root').innerHTML = `<img  class="gif" src='${gif}' alt= Loading">`;
const ParandoLoadingRacs = () => document.getElementById('root').innerHTML = `<img  src='${logoRacs}' alt="Logomarca da RACS" style="width: 70px;">`;

//Mascara de validação para campos númericos
//https://github.com/vanilla-masker/vanilla-masker
//Listen the input element masking it to format with pattern.
$('#cpf , #birthDate, #phone').on('focus', function () {

    var id=$(this).attr("id");

    if(id == "cpf"){VMasker(document.querySelector("#cpf")).maskPattern("999.999.999-99");}

    if(id == "birthDate"){VMasker(document.querySelector("#birthDate")).maskPattern("99/99/9999");}

    if(id == "phone"){VMasker(document.querySelector("#phone")).maskPattern("(99)-999999999");}

});

//Para ataques a senha do tipo força bruta
function getCaptcha()
{
    grecaptcha.ready(function() {
        grecaptcha.execute( sitekey, {action: 'homepage'}).then(function(token) {
          const gRecaptchaResponse=document.querySelector("#g-recaptcha-response").value=token;
        });
    });
}
//Inicia o captcha
getCaptcha();
//Ajax do formulário de cadastro de clientes
$("#formCadastro").on("submit",function(event){
    event.preventDefault();
    CarregandoLoading();
    var dados=$(this).serialize();
    $.ajax({
       url: getRoot(urlCadastro),
        type: 'post',
        dataType: 'json',
        data: dados,
        success: function (response) {
            $('.retornoCad').empty();
            if(response.retorno == 'erro'){
                getCaptcha();
                $.each(response.erros,function(key,value){
                    M.toast({   html: `<span class="lighten-2">${value}</span><button class="btn-flat toast-action"><i class="material-icons yellow-text">error_outline</i></button>`,
                        classes: 'rounded',
                        inDuration: 5000,
                        outDuration:5000,
                    });
                });
            }else{
                $.each(response.success,function(key,value){
                    M.toast({   html: `<span>${value}</span><button class="btn-flat toast-action"><i class="material-icons green-text">thumb_up</i></button>`,
                        classes: 'rounded',
                        inDuration: 5000,
                        outDuration:5000,
                    });
                });
                setTimeout(() => { window.location.href = response.page }, 6000);
                
            }
            ParandoLoading();
        }
    });
});

//CapsLock
$("#senha").keypress(function(e){
    kc=e.keyCode?e.keyCode:e.which;
    sk=e.shiftKey?e.shiftKey:((kc==16)?true:false);
    if(((kc>=65 && kc<=90) && !sk)||(kc>=97 && kc<=122)&&sk){
        $(".resultadoForm").html("Caps Lock Ligado");
    }else{
        $(".resultadoForm").empty();
    }
});



// Envia o formulario para redefinir a senha
$("#formRedefinePassword").on("submit",function(event){
    event.preventDefault();
    CarregandoLoading();
    var dados=$(this).serialize();
    $.ajax({
        url: getRoot(urlRedefinePassword),
        type: 'post',
        dataType: 'json',
        data: dados,
        success: function (response) {
          if(response.retorno == 'success'){
            //$('.loginFormulario').hide();
            $.each(response.success,function(key,value){
                M.toast({   html: `<span>${value}</span><button class="btn-flat toast-action"><i class="material-icons green-text">thumb_up</i></button>`,
                    classes: 'rounded',
                    inDuration:5000,
                    outDuration:5000,
                });
            });   
            setTimeout(() => { window.location.href = response.page }, 6000);

          }else{
              getCaptcha();
              if(response.tentativas == true){
               // $('.loginFormulario').hide();
              }
              $('.resultadoForm').empty();
              $.each(response.erros, function(key, value){
                  $('.resultadoForm').append(value + '<br>');
              });
            }
            ParandoLoading();
        }
    });
});

//Envia o formulario para criar a nova senha
$("#formNewPassword").on("submit",function(event){
    event.preventDefault();
    CarregandoLoading();
    var dados=$(this).serialize();
    $.ajax({
        url: getRoot(urlNewPassword),
        type: 'post',
        dataType: 'json',
        data: dados,
        success: function (response) {
          if(response.retorno == 'success'){
            // $('.loginFormulario').hide();
            $.each(response.success,function(key,value){
                M.toast({   html: `<span>${value}</span><button class="btn-flat toast-action">
                <i class="material-icons green-text">thumb_up</i></button>`,
                    classes: 'rounded',
                    inDuration: 5000,
                    outDuration:5000,
                });
            });
            setTimeout(() => { window.location.href = response.page }, 6000);
          }else{
              getCaptcha();
              if(response.tentativas == true){
                //$('.loginFormulario').hide();
              }
              $('.resultadoForm').empty();
              $.each(response.erros, function(key, value){
                  $('.resultadoForm').append(value + '<br>');
              });
            }
            ParandoLoading();
        }
    });
});


//Formulario de login
$("#formLogin").on("submit",function(event){
    CarregandoLoading();
    event.preventDefault();
    var dados=$(this).serialize();
    $.ajax({
       url: getRoot(urlLogin),
        type: 'post',
        dataType: 'json',
        data: dados,
        success: function (response) {
          if(response.retorno == 'success'){
            window.location.href = response.page;
          }else{
              getCaptcha();
              if(response.tentativas == true){
                //$('.loginFormulario').hide();
              }
              $('.resultadoForm').empty();
              $.each(response.erros, function(key, value){
                  $('.resultadoForm').append(value + '<br>');
              });
            }
            ParandoLoading();
        }
    });
    
});

//Formulario de login
$("#formLoginRacs").on("submit",function(event){
    CarregandoLoading();
    event.preventDefault();
    var dados=$(this).serialize();
    $.ajax({
       url: getRoot(urlLoginRacs),
        type: 'post',
        dataType: 'json',
        data: dados,
        success: function (response) {
          if(response.retorno == 'success'){
            window.location.href = response.page;
          }else{
              getCaptcha();
              if(response.tentativas == true){
                //$('.loginFormulario').hide();
              }
              $('.resultadoForm').empty();
              $.each(response.erros, function(key, value){
                  $('.resultadoForm').append(value + '<br>');
              });
            }
            ParandoLoadingRacs();
        }
    });
    
});



//Formulario de contato
$("#formContato").on("submit",function(event){
    event.preventDefault();
    LoadingRacs();
    var dados=$(this).serialize();
    $.ajax({
       url: getRoot(urlContatoRacs),
        type: 'post',
        dataType: 'json',
        data: dados,
        success: function (response) {
            //$('.retornoCad').empty();
            if(response.retorno == 'erro'){
                getCaptcha();
                $.each(response.erros,function(key,value){
                    M.toast({   html: `<span class="lighten-2">${value}</span><button class="btn-flat toast-action"><i class="material-icons yellow-text">error_outline</i></button>`,
                        classes: 'rounded',
                        inDuration: 5000,
                        outDuration:5000,
                    });
                });
            }else{
                $.each(response.success,function(key,value){
                    M.toast({   html: `<span>${value}</span><button class="btn-flat toast-action"><i class="material-icons green-text">thumb_up</i></button>`,
                        classes: 'rounded',
                        inDuration: 5000,
                        outDuration:5000,
                    });
                });
                
            }
            ParandoLoading();
        }
    });
});
