import React, {useState} from 'react';
import {
  StyleSheet,
  Text,
  View,
  TouchableOpacity,
  Image,
  Modal
} from 'react-native';
import Header from '../../componentes/Header';
import SwitchBtn from '../../componentes/SwitchBtn';
import AlertModal from '../../componentes/AlertModal';

export default function App(){
    const [mostrar,setMostrar] = useState(false)

   
  return (
    <View style={estilos.container}>
      <Header goingback={true}/>
        <View style={{paddingHorizontal:30}}>
              <Text style={estilos.h1}>Configurações</Text>
              <Text style={estilos.txt}>Ajuste suas configurações.</Text>            
        </View> 

        <View style={{flex:1, paddingHorizontal:30, marginTop:30,}}>
            <View style={{flexDirection:'row', justifyContent:'center'}}>
                <View style={{flex:3,justifyContent:'center'}}>
                    <Text style={estilos.txtOption}>Ativar localização</Text>
                </View>
                <View style={{flex:1, padding:15}}>
                    <SwitchBtn/>
                </View>
            </View>        
        </View> 
        <View style={estilos.containerBtn}>
        <TouchableOpacity  style={estilos.btn}>
            <Text style={{fontSize:24,fontFamily:'Poppins-Regular',color:'#fff',padding:5,}}>Sair da Conta</Text>
        </TouchableOpacity>
        <TouchableOpacity  style={[estilos.btn, {backgroundColor:'#ff3434'}]} onPress={()=>{setMostrar(true)}}>
            <Text style={{fontSize:24,fontFamily:'Poppins-Regular',color:'#fff',padding:5, letterSpacing:2}}>Deletar Conta</Text>
        </TouchableOpacity>
      </View>

        <View>    
            <View>
                <Modal visible={mostrar} transparent={true}>
                    <View style={{flex:1, alignItems:'center', backgroundColor:'rgba(0, 0 , 0, 0.8)'}}>
                        <View style={estilos.containerModal}>
                            <View style={{alignItems:'flex-end'}}>
                                <TouchableOpacity onPress={()=>{setMostrar(false)}}>
                                    <Image source={require('../../images/configuracao/close.png')}/>
                                </TouchableOpacity>
                            </View>
                            <View style={{flex:1, alignItems:'center',justifyContent:'center'}}>
                                    <Image source={require('../../images/configuracao/dangericon.png')}/>
                                    <Text style={[estilos.txt,{paddingVertical:5}]}>Você deseja deletar a sua conta?</Text>
                                    <View style={{flexDirection:'row', padding:10}}>
                                    <TouchableOpacity style={estilos.btnBg} onPress={()=>{setMostrar(false)}}>
                                        <Text style={[estilos.txtModal,{color:'#707070'}]}>Não</Text>
                                    </TouchableOpacity> 
                                    <TouchableOpacity style={[estilos.btnBg,{backgroundColor:'#920046'}]}>
                                        <Text style={[estilos.txtModal,{color:'#FFF'}]}>Sim</Text>
                                    </TouchableOpacity> 
                                </View>
                            </View>                    
                        </View>
                    </View>
                </Modal>
            </View>        
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
    txtOption:{
        fontSize:16,
        fontFamily:'Poppins-Regular',
        color:'#414141'
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
        fontSize:17,
        fontFamily:'Poppins-Regular',

    }

});

