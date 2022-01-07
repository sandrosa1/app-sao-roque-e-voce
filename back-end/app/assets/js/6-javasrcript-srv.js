// ------------------------------------------arquivo para sistema SRV----------------------------\\
const urlSrvDetalhesCep = urlName+'/srv/configuracao/cep';
const CarregandoLoadingSrv = () => document.getElementById('loadingCep').innerHTML = '<div class="preloader-wrapper small active"><div class="spinner-layer spinner-green-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';
const ParandoLoadingSrv = () => document.getElementById('loadingCep').innerHTML = '';

// Modal de ajuda do form de detalhes
$(document).ready(function(){
    $('.modal').modal();
  });

//Busca mascasra para ocep
$('#cep').on('focus', function () {

    VMasker(document.querySelector("#cep")).maskPattern("99999-999");

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
        CarregandoLoadingSrv();
        var dados=$(this).serialize();
        $.ajax({
        url: getRoot(urlSrvDetalhesCep),
            type: 'post',
            dataType: 'json',
            data: dados,
            success: function (response) {
                if(response.retorno == 'success'){
                inputsAddresSrv(response.inputs)
                ParandoLoadingSrv();
                }else{
                
                    M.toast({   html: `<span class="lighten-2">${response.erros}</span><button class="btn-flat toast-action"><i class="material-icons yellow-text">error_outline</i></button>`,
                        classes: 'rounded',
                        inDuration: 5000,
                        outDuration:5000,
                    });

                    clearInputsAddresSrv();
                    ParandoLoadingSrv();
                    
                }
            }
        });
    }

});

$(document).ready(function(){
    $('select').formSelect();
  });