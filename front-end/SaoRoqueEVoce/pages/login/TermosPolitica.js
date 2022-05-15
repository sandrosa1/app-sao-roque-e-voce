import React from 'react';
import {
  StyleSheet,
  Text,
  View,
} from 'react-native';
import Header from '../../componentes/Header';
import BtnVoltar from '../../componentes/BtnVoltar';

export default function App({route}){

  let title = route.params.title
  let text = route.params.text

  return (
    <View style={estilos.container}>
      <Header space={true} goingback={true}/>
      <View style={{flex:4,paddingHorizontal:30,}}>
            <Text style={estilos.h1}>{title}</Text>
            <Text style={estilos.txt}>
              {text}
            </Text>
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
    }

});


