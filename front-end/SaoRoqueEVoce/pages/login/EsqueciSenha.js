import React,{useState} from 'react';
import {
  StyleSheet,
  Text,
  View,
  TextInput,
  Image,
  TouchableOpacity,
  Modal
} from 'react-native';
import { useNavigation } from '@react-navigation/native';
import Header from '../../componentes/Header';
import BtnCancelar from '../../componentes/BtnCancelar';
import CheckBox from '@react-native-community/checkbox';

export default function App(){
    const navigation = useNavigation();
    const [isSelected, setSelection] = useState(false);
    const [mostrar,setMostrar] = useState(false)
  return (
    <View style={estilos.container}>
      <Header/>
      <View style={{flex:1,paddingHorizontal:30,}}>
            <Text style={estilos.h1}>Redefina a sua senha</Text>
            <Text style={estilos.txt}>
                Para redefinir a sua senha, digite o seu e-mail cadastrado.
            </Text>
        </View>
            <View style={{flex:3,paddingHorizontal:30, marginTop:20}}>
                <TextInput placeholder="E-mail" placeholderTextColor={'#910046'} style={estilos.input}></TextInput>
            <View style={estilos.conteudoCkecbox}>
                <View style={estilos.checkbox}>
                <CheckBox
                value={isSelected}
                onValueChange={setSelection}
                style={{ transform: [{ scaleX: 1.5 }, { scaleY: 1.5 }] }}
                tintColors={{ true: '#910046', false: '#910046' }}
                />
                <Text style={[estilos.txt, {paddingLeft:10}]}>Não sou um robô</Text>
                </View>
                <Image
                source={require('../../images/captchalogo.png')}
                />                
                </View>
            </View>
            <View style={estilos.conteudo}>
            <TouchableOpacity  style={estilos.btn} onPress={()=>{setMostrar(true)}}>
                    <Text style={{fontSize:24,fontFamily:'Poppins-Regular',color:'#CDCDCD',padding:5, letterSpacing:2}}>Enviar</Text>
                </TouchableOpacity>
            <BtnCancelar/>
            </View>
            <View>    
            <View>
                <Modal visible={mostrar} transparent={true}>
                    <View style={{flex:1, alignItems:'center', backgroundColor:'rgba(0, 0 , 0, 0.8)'}}>
                        <View style={estilos.containerModal}>
                            <View style={{alignItems:'flex-end'}}>
                                <TouchableOpacity onPress={() => navigation.navigate('Login')}>
                                    <Image source={require('../../images/configuracao/close.png')}/>
                                </TouchableOpacity>
                            </View>
                            <View style={{flex:1, alignItems:'center',justifyContent:'center'}}>
                                    <Image source={require('../../images/configuracao/sucesso.png')}/>
                                    <Text style={[estilos.txtModal,{paddingVertical:20}]}>Enviamos para seu e-mail instruções para redefinir a sua senha.</Text>  
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
        paddingBottom:10,
    },
    txt:{
        fontSize:17,
        fontFamily:'Poppins-Regular',
        color:'#414141'
    },
    input:{
        width:'100%',
        marginTop:15,
        marginBottom:20,        
        padding:2,
        fontSize:17,
        borderBottomWidth:1,
        borderColor:'#D8d8d8',
        fontFamily:'Poppins-Regular',
        color:'#000'
    },
    conteudoCkecbox:{
        marginTop:30,
        flexDirection:'row',
        alignItems:'center',
        borderWidth:1,
        padding:20,
        borderRadius:10,
        borderColor:'#C4CDCD',
        justifyContent:'space-around',
        backgroundColor:'#EEE'             
    },
    checkbox:{
        flexDirection:'row',
        alignItems:'center',
        justifyContent:'space-between',       
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
    conteudo:{      
        flex:2,
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
        fontSize:15,
        fontFamily:'Poppins-Regular',
        textAlign:'center'

    }

});

