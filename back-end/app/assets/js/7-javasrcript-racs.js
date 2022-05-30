const UrlCepTurismo = urlName+'/racs/criar-turismo/cep';
const UrlTurismo    =  urlName+'/racs/criar-turismo';
const UrlCepServico = urlName+'/racs/criar-servico/cep';
const UrlServico    =  urlName+'/racs/criar-servico';


const LoadingAppCep = () => document.getElementById('loadingAppCep').innerHTML = '<div class="preloader-wrapper small active"><div class="spinner-layer spinner-blue-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';
const ParandoLoadingAppCep = () => document.getElementById('loadingAppCep').innerHTML = '';

const LoadingApp = () => document.getElementById('loadingApp').innerHTML = '<div class="preloader-wrapper small active"><div class="spinner-layer spinner-blue-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';
const ParandoLoadingApp = () => document.getElementById('loadingApp').innerHTML = '';
//Busca o cep quando sai do foco

$('#cepAppTurismo').on('blur', function (event) {
    
    if(document.querySelector("#cepAppTurismo").value.length == 9){
        event.preventDefault();
       LoadingAppCep();
        var dados=$(this).serialize();
        $.ajax({
        url: getRoot(UrlCepTurismo),
            type: 'post',
            dataType: 'json',
            data: dados,
            success: function (response) {
                if(response.retorno == 'success'){
                inputsAddresSrv(response.inputs);
                ParandoLoadingAppCep();
                }else{
                    M.toast({   html: `<span class="lighten-2">${response.erros}</span><button class="btn-flat toast-action"><i class="material-icons yellow-text">error_outline</i></button>`,
                        classes: 'rounded',
                        inDuration: 5000,
                        outDuration:5000,
                    });

                    //clearInputsAddresSrv();
                    ParandoLoadingAppCep();
                    
                }
            }
        });
    }

});
//Busca mascasra para ocep
$('#cepAppTurismo').on('focus', function () {

    var id=$(this).attr("id");

    if(id == "cepAppTurismo"){VMasker(document.querySelector("#cepAppTurismo")).maskPattern("99999-999");}
   
});

///Formulario de informação dos dados do app
$("#formAppTurismo").on("submit",function(event){

    event.preventDefault();
    var form_img = new FormData(document.getElementById("formAppTurismo"));
    LoadingApp();
    $.ajax({
         url: getRoot(UrlTurismo),
         method: 'post',
         data: form_img,
         dataType: 'json',
         cache: false,
         contentType: false,
         processData: false,
        success: function (response) {
            $('.loading').empty();
            if(response.retorno == 'erro'){
                getCaptcha();
                $.each(response.erros,function(key,value){
                    M.toast({   html: `<span class="lighten-2">${value}</span><button class="btn-flat toast-action"><i class="material-icons yellow-text">error_outline</i></button>`,
                        classes: 'rounded, red',
                        inDuration: 5000,
                        outDuration:5000,
                    });
                });
            }else{
                $.each(response.success,function(key,value){
                    getCaptcha();
                    M.toast({   html: `<span>${value}</span><button class="btn-flat toast-action"><i class="material-icons blue-text">thumb_up</i></button>`,
                        classes: 'rounded, green',
                        inDuration: 5000,
                        outDuration:5000,
                    });
                });
                setTimeout(() => {window.location.href = response.page}, 3000);
            }
            ParandoLoadingApp();
        }
    });
});








//Busca o cep quando sai do foco
$('#cepAppServico').on('blur', function (event) {
    
    if(document.querySelector("#cepAppServico").value.length == 9){
        event.preventDefault();
       LoadingAppCep();
        var dados=$(this).serialize();
        $.ajax({
        url: getRoot(UrlCepServico),
            type: 'post',
            dataType: 'json',
            data: dados,
            success: function (response) {
                if(response.retorno == 'success'){
                inputsAddresSrv(response.inputs);
                ParandoLoadingAppCep();
                }else{
                    M.toast({   html: `<span class="lighten-2">${response.erros}</span><button class="btn-flat toast-action"><i class="material-icons yellow-text">error_outline</i></button>`,
                        classes: 'rounded',
                        inDuration: 5000,
                        outDuration:5000,
                    });

                    //clearInputsAddresSrv();
                    ParandoLoadingAppCep();
                    
                }
            }
        });
    }

});
//Busca mascasra para ocep
$('#cepAppServico').on('focus', function () {

    var id=$(this).attr("id");

    if(id == "cepAppServico"){VMasker(document.querySelector("#cepAppServico")).maskPattern("99999-999");}
   
});

///Formulario de informação dos dados do app
$("#formAppServico").on("submit",function(event){

    event.preventDefault();
    var form_img = new FormData(document.getElementById("formAppServico"));
    LoadingApp();
    $.ajax({
         url: getRoot(UrlServico),
         method: 'post',
         data: form_img,
         dataType: 'json',
         cache: false,
         contentType: false,
         processData: false,
        success: function (response) {
            $('.loading').empty();
            if(response.retorno == 'erro'){
                getCaptcha();
                $.each(response.erros,function(key,value){
                    M.toast({   html: `<span class="lighten-2">${value}</span><button class="btn-flat toast-action"><i class="material-icons yellow-text">error_outline</i></button>`,
                        classes: 'rounded, red',
                        inDuration: 5000,
                        outDuration:5000,
                    });
                });
            }else{
                $.each(response.success,function(key,value){
                    getCaptcha();
                    M.toast({   html: `<span>${value}</span><button class="btn-flat toast-action"><i class="material-icons blue-text">thumb_up</i></button>`,
                        classes: 'rounded, green',
                        inDuration: 5000,
                        outDuration:5000,
                    });
                });
                setTimeout(() => {window.location.href = response.page}, 3000);
            }
            ParandoLoadingApp();
        }
    });
});