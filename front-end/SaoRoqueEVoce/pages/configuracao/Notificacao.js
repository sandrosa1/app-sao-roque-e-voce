import React, {useState} from 'react';
import {
  StyleSheet,
  Text,
  View,
  Switch
} from 'react-native';
import Header from '../../componentes/Header';
import SwitchBtn from '../../componentes/SwitchBtn';

export default function App(){
    const [ligado,setLigado] = useState(false)
    const toggle=()=> setLigado(previousState => !previousState)

  return (
    <View style={estilos.container}>
      <Header goingback={true}/>
        <View style={{paddingHorizontal:30}}>
              <Text style={estilos.h1}>Notificações</Text>
              <Text style={estilos.txt}>
                  Ajuste os alertas que deseja receber.
              </Text>            
        </View> 

        <View style={{flex:1, paddingHorizontal:30, marginTop:30,}}>
            <View style={{flexDirection:'row', justifyContent:'center'}}>
                <View style={{flex:3,justifyContent:'center'}}>
                    <Text style={estilos.txtOption}>Aleta de novidades</Text>
                </View>
                <View style={{flex:1, padding:15}}>
                    <SwitchBtn/>
                </View>
            </View>        
            <View style={{flexDirection:'row', justifyContent:'center'}}>
                <View style={{flex:3,justifyContent:'center'}}>
                    <Text style={estilos.txtOption}>Dicas de Pontos Turísticos</Text>
                </View>
                <View style={{flex:1, padding:15}}>
                   <SwitchBtn/>
                </View>
            </View>        
            <View style={{flexDirection:'row', justifyContent:'center'}}>
                <View style={{flex:3,justifyContent:'center'}}>
                    <Text style={estilos.txtOption}>Dicas de Restaurantes</Text>
                </View>
                <View style={{flex:1, padding:15}}>
                   <SwitchBtn/>
                </View>
            </View>        
            <View style={{flexDirection:'row', justifyContent:'center'}}>
                <View style={{flex:3,justifyContent:'center'}}>
                    <Text style={estilos.txtOption}>Dicas de Hospedagens</Text>
                </View>
                <View style={{flex:1, padding:15}}>
                   <SwitchBtn/>
                </View>
            </View>        
            <View style={{flexDirection:'row', justifyContent:'center'}}>
                <View style={{flex:3,justifyContent:'center'}}>
                    <Text style={estilos.txtOption}>Alerta de Eventos</Text>
                </View>
                <View style={{flex:1, padding:15}}>
                   <SwitchBtn/>
                </View>
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

});

