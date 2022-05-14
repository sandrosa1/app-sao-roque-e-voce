import React from 'react';
import {
  StyleSheet,
  Text,
  View,
} from 'react-native';
import Header from '../../componentes/Header';
import BtnVoltar from '../../componentes/BtnVoltar';

export default function App(){
  return (
    <View style={estilos.container}>
      <Header/>
      <View style={{flex:4,paddingHorizontal:30,}}>
            <Text style={estilos.h1}>Política de Privacidade</Text>
            <Text style={estilos.txt}>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime mollitia, molestiae quas vel sint commodi repudiandae consequuntur voluptatum laborum
                numquam blanditiis harum quisquam eius sed odit fugiat iusto fuga praesentium
                optio, eaque rerum! Provident similique accusantium nemo autem. Veritatis
                obcaecati tenetur iure eius earum ut molestias architecto voluptate aliquam
                nihil, eveniet aliquid culpa officia aut! Impedit sit sunt quaerat, odit,
                tenetur error, harum nesciunt ipsum debitis quas aliquid. Reprehenderit,
                quia. Quo neque error repudiandae fuga?
            </Text>
            <View style={{flex:1,alignItems:'center',justifyContent:'center',}}>
            <BtnVoltar/>
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
    }

});


