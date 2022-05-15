import React from 'react';
import {
  StyleSheet,
  Text,
  View,
  TouchableOpacity,
  Image
} from 'react-native';
import { useNavigation } from '@react-navigation/native';


export default function App(props){
  const navigation = useNavigation();
  
  let goingback = props.goingback
  let logado = props.logado
  let login = props.login
  let space = props.space
  let br = props.nobr

  return (
      <View>
        <View style={estilos.conteudo}>              
              {goingback?
              <View style={{flex:1,justifyContent:'center',alignItems:'center'}}>                
                  <TouchableOpacity style={{padding:10,right:10}} onPress={() => navigation.goBack()}>
                    <Image style={{width:30, height:30, resizeMode:'cover'}} source={require('../images/goingback.png')}/>
                  </TouchableOpacity>
                </View>                         
              :              
              <View style={{flex:1}}></View>}

              <View style={{flex:2, alignItems:'center',justifyContent:'center'}}>
              <Image source={require('../images/logo.png')} style={{width:156,height:57, resizeMode:'contain'}}/>
              </View>
             
              {logado?
              <View style={{flex:1,alignItems:'center',justifyContent:'center'}}>
                <TouchableOpacity onPress={() => navigation.navigate('Configuracao')}>
                <Image style={estilos.img} source={require('../images/paginadetalhes/avatar.png')}/>
              </TouchableOpacity>
              </View>: <View></View>}              
              
              {login ? 
              <View style={{flex:1,alignItems:'center',justifyContent:'center'}}>     
              <TouchableOpacity onPress={() => navigation.navigate('Login')}>
                            <Text style={{alignSelf:'baseline',fontSize:18,color:'#910046',fontFamily:'Poppins-SemiBold'}}>Login</Text>
              </TouchableOpacity></View>:<View></View>}

              {space ? <View style={{flex:1}}></View> : <View></View>} 
       </View>  

       {br?<Text></Text>:<Image source={require('../images/line.png')} style={{alignSelf:'center', margin:10, resizeMode:'contain'}}/>}
    </View>
   
  );
};

const estilos = StyleSheet.create({
    conteudo:{              
        width:'100%',
        flexDirection:'row',
        marginTop:15        
    },
    img:{
      height:45,
      width:45,
      resizeMode:'contain'
    }
});


