import React,{useState,useEffect} from 'react';
import {
  StyleSheet,
  SafeAreaView,
  Text,
  View,
  ImageBackground,
  Image,
  TextInput,
  TouchableOpacity,
  Dimensions,
  KeyboardAvoidingView,
  Modal
} from 'react-native';
import axios from "axios";
import Globais from '../../componentes/Globais';
import AS_Usuario from '@react-native-async-storage/async-storage'

export default function App({navigation}){
    const baseURL = "http://www.racsstudios.com/api/v1/login";
    const [email,setEmail] = useState('');
    const [senha,setSenha] = useState('');
    const [confirmacao,setConfirmacao] = useState('');
    const [mostrar,setMostrar] = useState(false);
    const [mostrarerro,setMostrarerro] = useState(false);
    const [curso, setCurso] = useState('--')
  
    const Armazenar = (chave, valor) => {
        AS_Usuario.setItem(chave,valor)
    }

  
    const getData = async () => {
        try {
        const value = await AS_Usuario.getItem('@storage_Key')
        console.log(value)
        if(value !== null) {
            //          
        }
        } catch(e) {
        // error reading value
        }
    }
    

    console.log(Globais.nome)

    function login() {
        axios.post(baseURL, {           
            email: email,
            senha: senha
          })
          .then((response) => {
            setConfirmacao(response.data);
          }).catch(error => {
            setError(error.response.data);
            });
      }

      
      
      if (confirmacao){          
          if(confirmacao.error == 'Email ou senha inválido!' || confirmacao.error == 'Senha ou Email inválido!'){
              setMostrarerro(true);
              setConfirmacao()        
            }
            if (confirmacao.retorne == true) {                
            setMostrar(true);
            Armazenar('nome',confirmacao.nomeUsuario)
            Armazenar('sobrenome',confirmacao.sobreNome)
            Armazenar('email',confirmacao.email)
            Armazenar('data',confirmacao.dataNascimento)
            Armazenar('dicasRestaurantes',String(confirmacao.dicasRestaurantes))
            Armazenar('dicasTurismo',String(confirmacao.dicasPontosTuristicos))
            Armazenar('dicasHospedagens',String(confirmacao.dicasHospedagens))
            Armazenar('ativaLocalizacao',String(confirmacao.ativaLocalizacao))
            Armazenar('alertaNovidade',String(confirmacao.alertaNovidade))
            Armazenar('alertaEventos',String(confirmacao.alertaEventos))
            getData()
            setConfirmacao()       
        }
    }
      



  return (
    <SafeAreaView style={estilos.conteiner}>            
        <ImageBackground source={require('../../images/backgroundlogin.png')} style={estilos.imagemfundo} resizeMode='cover'>
            <View style={estilos.conteudo}>
                <TouchableOpacity onPress={() => navigation.navigate('Home')}>
                <Image source={require('../../images/logo.png')} style={{width:'100%', resizeMode:'contain'}}/>
                </TouchableOpacity>
                <Text>{}</Text>
            </View>
            <KeyboardAvoidingView style={{flex:1}}
            behavior={Platform.OS === 'ios' ? "padding" : "height"}
            >
            <View style={estilos.conteudo2}>
                <Text style={{fontSize:24,marginTop:50,fontFamily:'Poppins-SemiBold', color:'#910046'}}>Login</Text>
                <TextInput onChangeText={setEmail} value={email} placeholder="E-mail" placeholderTextColor={'#910046'} style={estilos.input}>
                </TextInput>
                <TextInput onChangeText={setSenha} value={senha} placeholder="Senha"  placeholderTextColor={'#910046'} secureTextEntry={true} style={estilos.input}>
                </TextInput>
                <TouchableOpacity  style={estilos.btn} onPress={login}>
                    <Text style={{fontSize:24,fontFamily:'Poppins-Regular',color:'#910046', letterSpacing:2, paddingTop:5}}>ENTRAR</Text>
                </TouchableOpacity>
                </View>
            </KeyboardAvoidingView>
                <View style={estilos.conteudo3}>
                <TouchableOpacity onPress={() => navigation.navigate('EsqueciSenha')}>
                    <Text style={{fontSize:14,color:'#DCDCDC',textAlign:'center', fontFamily:'Poppins-Regular'}}>Esqueceu sua senha?</Text>
                </TouchableOpacity>
                <TouchableOpacity  onPress={() => navigation.navigate('Cadastro')}>
                    <Text style={{fontSize:14,fontFamily:'Poppins-Regular',color:'#DCDCDC',textAlign:'center', }}>Ainda não é usuário?   <Text style={{fontSize:14,fontFamily:'Poppins-Bold'}}>Crie sua conta aqui!</Text></Text>
                </TouchableOpacity>                
            </View>

            <View>
                <Modal visible={mostrarerro} transparent={true}>
                    <View style={{flex:1, alignItems:'center', backgroundColor:'rgba(0, 0 , 0, 0.8)'}}>
                        <View style={estilos.containerModal}>
                            <View style={{alignItems:'flex-end'}}>
                                <TouchableOpacity onPress={()=> {setMostrarerro(false)}}>
                                    <Image source={require('../../images/configuracao/close.png')}/>
                                </TouchableOpacity>
                            </View>
                            <View style={{flex:1, alignItems:'center',justifyContent:'center'}}>
                                    <Image source={require('../../images/configuracao/dangericon.png')}/>
                                    <Text style={[estilos.txtModal,{paddingVertical:5}]}>E-mail ou Senha inválido!</Text>                                   
                                    <Text style={[estilos.txtModal,{marginTop:0}]}>Tente novamente.</Text>                                   
                            </View>                    
                        </View>
                    </View>
                </Modal>
            </View>    
            <View>
                <Modal visible={mostrar} transparent={true}>
                    <View style={{flex:1, alignItems:'center', backgroundColor:'rgba(0, 0 , 0, 0.8)'}}>
                        <View style={estilos.containerModal}>
                            <View style={{alignItems:'flex-end'}}>
                                <TouchableOpacity onPress={() => navigation.navigate('Home')}>
                                    <Image source={require('../../images/configuracao/close.png')}/>
                                </TouchableOpacity>
                            </View>
                            <View style={{flex:1, alignItems:'center',justifyContent:'center'}}>
                                    <Image source={require('../../images/configuracao/sucesso.png')}/>
                                    <Text style={[estilos.txtModal,{paddingVertical:5}]}>Bem vindo! @@@@</Text>  
                                    <TouchableOpacity  style={estilos.btn2} onPress={() => navigation.navigate('Home')}>
                                        <Text style={{fontSize:24,fontFamily:'Poppins-Regular',color:'#fff', letterSpacing:2, paddingTop:5}}>ok</Text>
                                    </TouchableOpacity>                                 
                            </View>                    
                        </View>
                    </View>
                </Modal>
            </View>    

        </ImageBackground>
    </SafeAreaView>
  );
};

const estilos = StyleSheet.create({
    conteiner:{
        flex:1,
    },
    imagemfundo:{      
        width: Dimensions.get('window').width,
        height: Dimensions.get('window').height,   
    },
    conteudo:{
        justifyContent:'flex-end',
        paddingHorizontal:40       
    },
    conteudo2:{
        flex:2,
        padding:40,        
        alignItems:'center',
        justifyContent:'center'
    },
    conteudo3:{
        flex:1,
        padding:40,        
        alignItems:'center',
        justifyContent:'space-around',

    },
    input:{
        width:'90%',
        marginTop:15,        
        padding:2,
        fontSize:17,
        borderBottomWidth:1,
        borderColor:'#D8d8d8',
        fontFamily:'Poppins-Regular',
        color:'#000'
    },
    btn:{
        marginTop:45,
        width:'90%',
        height:45,
        backgroundColor: "lightgray",
        borderRadius:33,
        alignItems:'center',
        justifyContent:'center',
    },
    btn2:{
        marginTop:5,
        width:'50%',
        height:45,
        backgroundColor: "#910046",
        borderRadius:33,
        alignItems:'center',
        justifyContent:'center',
    },
    containerModal:{
        alignSelf:'center',
        width:350,
        height:230,
        padding:20,
        borderRadius:30,
        backgroundColor:'#fff',
        elevation:5,
        top:'25%'        
    },
    btnBg:{
        width:100,
        height:45,backgroundColor:'#CCC',
        borderRadius:34, alignItems:'center',
        justifyContent:'center',
        marginHorizontal:20
    },
    txtModal:{
        fontSize:18,
        fontFamily:'Poppins-Regular',
        margin:10,
        color:'#000'

    }
   
});


