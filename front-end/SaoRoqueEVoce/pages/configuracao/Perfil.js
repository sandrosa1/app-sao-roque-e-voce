import React from 'react';
import {
  StyleSheet,
  Text,
  View,
  TextInput,
  TouchableOpacity
} from 'react-native';
import Header from '../../componentes/Header';
import Globais from '../../componentes/Globais';

export default function App(){
  let nome = Globais.dados?.usernome
  let sobrenome = Globais.dados?.usersobrenome
  let dataNascimento = Globais.dados?.usernascimento
  let email = Globais.dados?.useremail

  return (
    <View style={estilos.container}>
      <Header goingback={true} space={true}/>
        <View style={{paddingHorizontal:30}}>
              <Text style={estilos.h1}>Perfil</Text>
              <Text style={estilos.txt}>
                  Atualize suas informações.
              </Text>            
        </View>
      {}
      <View style={{flex:2, paddingHorizontal:30}}>
        <View style={{marginTop:15}}>
          <Text style={estilos.miniText}>Nome</Text>
          <TextInput placeholder={nome} placeholderTextColor={'#414141'} style={estilos.input}>            
          </TextInput>
        </View>
        <View style={{marginTop:15}}>
          <Text style={estilos.miniText}>Sobrenome</Text>
          <TextInput placeholder={sobrenome} placeholderTextColor={'#414141'} style={estilos.input}>            
          </TextInput>
        </View>
        <View style={{marginTop:15}}>
          <Text style={estilos.miniText}>Data de Nascimento</Text>
          <TextInput placeholder={dataNascimento} placeholderTextColor={'#414141'} style={estilos.input}>            
          </TextInput>
        </View>
        <View style={{marginTop:15}}>
          <Text style={estilos.miniText}>E-mail</Text>
          <TextInput placeholder={email} placeholderTextColor={'#414141'} style={estilos.input}>            
          </TextInput>
        </View>
      </View>
      <View style={estilos.containerBtn}>
      <TouchableOpacity  style={estilos.btn} >
        <Text style={{fontSize:24,fontFamily:'Poppins-Regular',color:'#CDCDCD',padding:5, letterSpacing:2}}>Salvar</Text>
      </TouchableOpacity>
      </View>


    </View>
   
  );
};

const estilos = StyleSheet.create({
    container:{
        flex:1,
    },
    h1:{
        fontSize:24,
        fontFamily:'Poppins-Regular',
        color:'#910046',
    },
    txt:{
      bottom:5,
      fontSize:12,
      fontFamily:'Poppins-Regular',
      color:'#414141'
    },
    miniText:{
        color:'#8E8E8E',
        fontSize:12,
        top:10,
        marginLeft:5,
      },
    input:{
        fontSize:18,
        borderBottomWidth:1,
        borderColor:'#C4C4C4',
        paddingBottom:-10,
        color:'#000'
      },
      btn:{
        marginTop:25,
        width:'80%',
        height:45,
        borderRadius:33,
        backgroundColor: "#910046",
        alignItems:'center',
        justifyContent:'center'
    },
    containerBtn:{ 
        flex:1,
        justifyContent:'center',     
        marginTop:30,       
        alignItems:'center',
    },

});

