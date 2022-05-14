import React,{useState,useEffect} from 'react';
import {
  StyleSheet,
  Text,
  View,
  TouchableOpacity,
  TextInput,
  Modal,
  Image,
  KeyboardAvoidingView,
  Platform,
  ScrollView
} from 'react-native';
import CheckBox from '@react-native-community/checkbox';
import Header from '../../componentes/Header';
import { TextInputMask } from 'react-native-masked-text'
import axios from "axios";


export default function App({navigation}){
    const baseURL = 'http://www.racsstudios.com/api/v1/user/';
    const [isSelected, setSelection] = useState(false);
    const [nome,setNome] = useState('');
    const [sobrenome,setSobrenome] = useState('');
    const [dataNascimento,setDataNascimento] = useState('');
    const [email,setEmail] = useState('');
    const [senha,setSenha] = useState('');
    const [erronome,setErronome] = useState('');  
    const [errosobrenome,setErrosobrenome] = useState('');  
    const [errodatanascimento,setErrodatanascimento] = useState('');  
    const [erroemail,setErroemail] = useState('');  
    const [errosenha,setErrosenha] = useState('');  
    const [erroselect,setErroselect] = useState('');  
    const [inputnome,setInputnome] = useState('');  
    const [inputsobrenome,setInputsobrenome] = useState('');  
    const [inputdatanascimento,setInputdatanascimento] = useState('');  
    const [inputemail,setInputemail] = useState('');  
    const [inputsenha,setInputsenha] = useState('');  
    const [mostrar,setMostrar] = useState(false);
    const [confirmacao,setConfirmacao] = useState();
    const [error,setError] = useState();
    const [versenha,setVersenha] = useState(true);
    const [iconsenha,setIconsenha] = useState(require('../../images/eye1.png'));
    


    const validar = () =>{
        let error = false;
        const re = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
        const se = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})");
      

        setErronome('');
        setErrosobrenome('');
        setErrodatanascimento('');
        setErroemail('');
        setErrosenha('');
        
        if(nome == ''){
            setErronome('Preencha o seu nome!');
            error = true;
        }
        if(sobrenome == ''){
            setErrosobrenome('Preencha o seu sobrenome!');
            error = true;
        }
        if(dataNascimento == ''){
            setErrodatanascimento('Preencha a sua data de nascimento!');
            error = true;
        }  
        if(!re.test(String(email).toLocaleLowerCase())){
            setErroemail('Insira um e-mail válido!');
            error = true;
        }
        if(email == ''){
            setErroemail('Preencha o seu email!');
            error = true;
        }
        if(!se.test(senha)){
            setErrosenha('Mínimo 8 caractéres contendo pelo menos 1: minúsculo, maiúsculo, numérico, especial')
            error = true;
        } 
        if(senha == ''){
            setErrosenha('Preencha a sua senha!')
            error = true;
        } 
        if(isSelected == false){
            setErroselect("Selecione que você leu e concorda com os \nTermos de Uso e a Política de Privacidade")
            error = true;
        } 

        return !error
    }
        
    const selection = () =>{
        setSelection(!isSelected)
        setErroselect('')
    }

    const mostrarsenha = () =>{
        setVersenha(!versenha)
        if(versenha == true){
            setIconsenha(require('../../images/eye0.png'))
        } else {
            setIconsenha(require('../../images/eye1.png'))
        }
    }
    const createPost = () => {
        if(validar()){
        
        axios.post(baseURL, {           
            nomeUsuario: nome,
            sobreNome: sobrenome,
            dataNascimento: dataNascimento,
            email: email,
            senha: senha,
          })
          .then((response) => {
            setConfirmacao(response.data);          
          }).catch(error => {
            setError(error.response.data);
            });        
      }};

      useEffect(()=>{
        if(error){
            setErroemail('E-mail já cadastrado!')
            setError()
            return           
        }
        
        if(confirmacao){
            setMostrar(true);
        }
    },[createPost]);

    console.log(confirmacao);
    console.log(error);

  return (
    <View style={estilos.container}>
        <KeyboardAvoidingView
        behavior={Platform.OS === 'ios' ? "padding" : "height"}
        keyboardVerticalOffset={-10}
        style={{flex:3}}
        >
        <ScrollView style={{flex:3}}>
        <Header/>
            <View style={{paddingHorizontal:40, alignItems:'center',justifyContent:'center'}}>
            <Text style={{fontSize:24,fontFamily:'Poppins-Regular', color:'#910046', alignSelf:'flex-start'}}>Crie a sua conta</Text>
                <View style={{ width:'100%', marginTop:15, marginBottom:25}}>
                <Text style={{position:'absolute',top:-15, color:'#8E8E8E', fontFamily:'Poppins-Regular'}}>{inputnome}</Text>
                <TextInput value={nome} onChangeText={value => {setNome(value); setErronome(''); setInputnome('Nome')}} placeholder="Nome" placeholderTextColor={'#414141'} style={estilos.input}>
                </TextInput>
                <Text style={{position:'absolute',top:35, color:'#910046'}}>{erronome}</Text>
                </View>

                <View style={{ width:'100%', marginTop:15, marginBottom:25}}>
                <Text style={{position:'absolute',top:-15, color:'#8E8E8E', fontFamily:'Poppins-Regular'}}>{inputsobrenome}</Text>
                <TextInput value={sobrenome} onChangeText={value => {setSobrenome(value); setErrosobrenome(''); setInputsobrenome('Sobrenome')}} placeholder="Sobrenome" placeholderTextColor={'#414141'} style={estilos.input}>
                </TextInput>
                <Text style={{position:'absolute',top:35, color:'#910046'}}>{errosobrenome}</Text>
                </View>

                <View style={{ width:'100%', marginTop:15, marginBottom:25}}>
                <Text style={{position:'absolute',top:-15, color:'#8E8E8E', fontFamily:'Poppins-Regular'}}>{inputdatanascimento}</Text>
                {/* <TextInput value={dataNascimento} onChangeText={value => {setDataNascimento(value); setErrodatanascimento(''); setInputdatanascimento('Dada de Nascimento')}} placeholder="Data de Nascimento" keyboardType='numeric' placeholderTextColor={'#414141'} style={estilos.input}>
                </TextInput> */}
                <TextInputMask
                    type={'custom'}
                    options={{ mask: '99/99/9999'}}
                    value={dataNascimento}
                    onChangeText={value => {setDataNascimento(value); setErrodatanascimento(''); setInputdatanascimento('Dada de Nascimento')}}
                    placeholder="Data de Nascimento"
                    keyboardType='numeric' placeholderTextColor={'#414141'} style={estilos.input}
                />
                <Text style={{position:'absolute',top:35, color:'#910046'}}>{errodatanascimento}</Text>
                </View>

                <View style={{ width:'100%', marginTop:15, marginBottom:25}}>
                <Text style={{position:'absolute',top:-15, color:'#8E8E8E', fontFamily:'Poppins-Regular'}}>{inputemail}</Text>
                <TextInput value={email} onChangeText={value => {setEmail(value); setErroemail(''); setInputemail('E-mail')}} placeholder="E-mail" keyboardType='email-address' placeholderTextColor={'#414141'} style={estilos.input}>
                </TextInput>
                <Text style={{position:'absolute',top:35, color:'#910046'}}>{erroemail}</Text>
                </View>

                <View style={{ width:'100%', marginTop:15, marginBottom:25, flexDirection:'row', alignItems:'center'}}>
                <View style={{width:'100%'}}>
                <Text style={{position:'absolute',top:-15, color:'#8E8E8E', fontFamily:'Poppins-Regular'}}>{inputsenha}</Text>
                <TextInput value={senha} onChangeText={value => {setSenha(value); setErrosenha(''); setInputsenha('Senha')}} placeholder="Senha" secureTextEntry={versenha} placeholderTextColor={'#414141'} style={estilos.input}>
                </TextInput>
                <Text style={{position:'absolute',top:35, color:'#910046'}}>{errosenha}</Text>
                </View>
                <TouchableOpacity style={{position:'absolute', right:10}} onPress={mostrarsenha}>
                    <View style={{padding:7}}>
                    <Image style={{width:25,height:25}} source={iconsenha}/>
                    </View>
                </TouchableOpacity>
                </View>

            <View style={estilos.conteudo2}>
                <CheckBox 
                value={isSelected}
                onValueChange={selection}
                style={{ transform: [{ scaleX: 1.5 }, { scaleY: 1.5 }] }}
                tintColors={{ true: '#910046', false: '#910046' }}
                />
                <View style={{flexDirection:'row', flexWrap:'wrap', paddingLeft:10}}>
                    <Text style={{color:'#414141'}}>Li e concordo com os </Text>
                    <TouchableOpacity onPress={() => navigation.navigate('Termos')}><Text style={{textDecorationLine:'underline', color:'#000'}}>Termos de Uso</Text></TouchableOpacity>
                    <Text style={{color:'#414141'}}> e com a </Text>
                    <TouchableOpacity onPress={() => navigation.navigate('Politica')}><Text style={{textDecorationLine:'underline', color:'#000'}}>Política de privacidade.</Text></TouchableOpacity>
                </View>                
                <Text style={{position:'absolute',top:60, left:20,color:'#910046'}}>{erroselect}</Text>
            </View>
      </View>
      </ScrollView>
    </KeyboardAvoidingView>
             
             <View style={{flex:1,alignItems:'center',justifyContent:'center',}}>
                <TouchableOpacity  style={estilos.btn} onPress={createPost}>
                    <Text style={{fontSize:24,fontFamily:'Poppins-Regular',color:'#fff',paddingTop:5}}>Cadastrar</Text>
                </TouchableOpacity>
                <TouchableOpacity  style={estilos.btn2} onPress={() => navigation.navigate('Login')}>
                    <Text style={{fontSize:24,fontFamily:'Poppins-Regular',color:'#910046',paddingTop:5}}>Cancelar</Text>
                </TouchableOpacity>
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
                                    <Text style={[estilos.txtModal,{paddingVertical:5}]}>Conta criada com sucesso!</Text>                                   
                            </View>                    
                        </View>
                    </View>
                </Modal>
            </View>      
        

    </View>

    
   
  );
};

const estilos = StyleSheet.create({
    container:{
        flex:1,     
    },
    conteudo2:{        
        paddingTop:15,
        paddingHorizontal:30,   
        flexDirection:'row',
        alignItems:'flex-start',
        marginBottom:50,
    },
    input:{             
        padding:2,
        fontSize:17,
        borderBottomWidth:1,
        borderColor:'#D8d8d8',
        fontFamily:'Poppins-Regular',
        color:'#000',
    },
    btn:{
        marginTop:20,
        width:'90%',
        height:45,
        borderRadius:33,
        backgroundColor: "#910046",
        alignItems:'center',
        justifyContent:'center'
    },
    btn2:{
        marginTop:20,
        width:'90%',
        height:45,
        borderRadius:33,
        backgroundColor: "#CCC",
        alignItems:'center',
        justifyContent:'center'
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
        marginTop:25,
        color:'#000'

    }

});


