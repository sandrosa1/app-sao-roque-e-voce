// ------------------------------------------arquivo para sistema SRV----------------------------\\
const UrlSrvConfigCep = urlName+'/srv/configuracao/cep';
const UrlSrvConfig = urlName+'/srv/configuracao';
const UrlSrvDetalhes = urlName+'/srv/detalhes';
const LoadingCep = () => document.getElementById('loadingCep').innerHTML = '<div class="preloader-wrapper small active"><div class="spinner-layer spinner-green-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';
const ParandoLoadingCep = () => document.getElementById('loadingCep').innerHTML = '';
const LoadingConfig = () => document.getElementById('loading').innerHTML = '<div class="preloader-wrapper small active"><div class="spinner-layer spinner-green-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';
const BreakLoadingConfig = () => document.getElementById('loading').innerHTML = '';

// Modal de ajuda do form de detalhes
$(document).ready(function(){
    $('.modal').modal();
  });

//Busca mascasra para ocep
$('#cep, #telefone, #celular').on('focus', function () {

    var id=$(this).attr("id");

    if(id == "cep"){VMasker(document.querySelector("#cep")).maskPattern("99999-999")};
    if(id == "telefone"){VMasker(document.querySelector("#telefone")).maskPattern("(99)9999-9999")};
    if(id == "celular"){VMasker(document.querySelector("#celular")).maskPattern("(99)99999-9999")};

});

const inputsAddresSrv = (result) => {
    for(const campo in result){
        if(document.querySelector("#"+campo)){
            document.querySelector("#"+campo).value = result[campo]
        }
    }
}
const clearInputsAddresSrv = () => {
   
    document.querySelector("#cep").value = '';
    document.querySelector("#logradouro").value = '';
    document.querySelector("#bairro").value = '';
    document.querySelector("#localidade").value = '';
        
}


//Saiu do focus
$('#cep').on('blur', function (event) {
    if(document.querySelector("#cep").value.length == 9){
        
        event.preventDefault();
        LoadingCep();
        var dados=$(this).serialize();
        $.ajax({
        url: getRoot(UrlSrvConfigCep),
            type: 'post',
            dataType: 'json',
            data: dados,
            success: function (response) {
                if(response.retorno == 'success'){
                inputsAddresSrv(response.inputs)
                ParandoLoadingCep();
                }else{
                
                    M.toast({   html: `<span class="lighten-2">${response.erros}</span><button class="btn-flat toast-action"><i class="material-icons yellow-text">error_outline</i></button>`,
                        classes: 'rounded',
                        inDuration: 5000,
                        outDuration:5000,
                    });

                    clearInputsAddresSrv();
                    ParandoLoadingCep();
                    
                }
            }
        });
    }

});

$(document).ready(function(){
    $('select').formSelect();
  });

$("#formConfig").on("submit",function(event){
    event.preventDefault();
    LoadingConfig()
    var dados=$(this).serialize();
    $.ajax({
        url: getRoot(UrlSrvConfig),
        type: 'post',
        dataType: 'json',
        data: dados,
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
                setTimeout(() => {window.onload}, 3000);
            }
            BreaKLoadingConfig()
        }
    });
});

//Busca mascasra para ocep
$('#semana, #sabado, #domingo, #feriado').on('focus', function () {

    var id=$(this).attr("id");

    if(id == "semana"){VMasker(document.querySelector("#semana")).maskPattern("99:99 - 99:99")};
    if(id == "sabado"){VMasker(document.querySelector("#sabado")).maskPattern("99:99 - 99:99")};
    if(id == "domingo"){VMasker(document.querySelector("#domingo")).maskPattern("99:99 - 99:99")};
    if(id == "feriado"){VMasker(document.querySelector("#feriado")).maskPattern("99:99 - 99:99")};

});


$("#formDetahes").on("submit",function(event){
    event.preventDefault();
    LoadingConfig()
    var dados = $(this).serialize();
    $.ajax({
        url: getRoot(UrlSrvDetalhes),
        type: 'post',
        dataType: 'json',
        data: dados,
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
            
            }
            
            BreakLoadingConfig() 
        }
    });
});



$(function(){

    $('#slide img:eq(0)').addClass("ativo").show();
    setInterval(slide,5000);
    
    function slide(){
    
        //Se a proxima imagem existir
        if($('.ativo').next().length){
    
            //Esconde a 1ª img, remove a classe ativo, mostra a proxima img e adiciona a classe ativo nela
            $('.ativo').fadeOut().removeClass("ativo").next().fadeIn().addClass("ativo");
    
        }else{ //Se for a ultima img do carrosel
    
            //Dá fadeOut na img, remove a classe ativo
            $('.ativo').fadeOut().removeClass("ativo");
            //Mostra a 1ª img do carrosel
            $('#slide img:eq(0)').fadeIn().addClass("ativo");
    
        }
    
    } });