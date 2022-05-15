import React,{useState,useEffect} from 'react';
import {
  StyleSheet,
  View,
  Image,  
 ActivityIndicator
} from 'react-native';
import Globais from '../../componentes/Globais';

export default function App({navigation}){  
  
    setTimeout(()=>{navigation.navigate('Home')},1500);                
    
  return (
    <View style={estilos.container}>
        <View style={{flex:1,alignItems:'center', backgroundColor:'rgba(0, 0 , 0, 0.05)', justifyContent:'center', paddingBottom:200}}>
             <View>
                <Image source={require('../../images/logo.png')} style={{width:250,resizeMode:'contain'}}/>
            </View>
                <View style={{alignItems:'center', justifyContent: 'center'}}>
                    <ActivityIndicator size={75} color="#910046"/>
                </View>
        </View>
    </View>   
  );
};

const estilos = StyleSheet.create({
    container:{
        flex:1,
        justifyContent:'center'
    },     
});