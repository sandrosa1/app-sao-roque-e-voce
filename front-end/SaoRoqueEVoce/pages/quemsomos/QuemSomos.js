import React from 'react';
import {
  StyleSheet,
  Text,
  View,
  ScrollView,
  Image,
} from 'react-native';
import NavPages from '../../componentes/NavPages';

export default function App(){
  return (
    <View style={estilos.container}>
        <ScrollView showsVerticalScrollIndicator={false}>
            <View style={{flex:1}}>      
                <NavPages 
                    icon={require('../../images/menubar/quemsomos.png')}
                    title={'Quem Somos'}/>

                <View style={{paddingHorizontal:30}}>
                    <Text style={estilos.h1}>Sobre</Text>
                    <Text style={estilos.txt}>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime mollitia,
                    molestiae quas vel sint commodi repudiandae consequuntur voluptatum laborum
                    numquam blanditiis harum quisquam eius sed odit fugiat iusto fuga praesentium
                    optio, eaque rerum!Voluptatum laborum
                    numquam blanditiis harum quisquam eius sed odit fugiat iusto fuga praesentium
                    optio, eaque rerum!
                    </Text>                   
                </View> 
                <Image source={require('../../images/line.png')} style={{alignSelf:'center', resizeMode:'contain'}}/> 
                <View style={{paddingHorizontal:30, marginTop:10}}>
                    <Text style={estilos.h1}>Contato</Text>
                   <View style={estilos.contatoContainer}>
                       <Image style={estilos.img} source={require('../../images/quemsomos/facebook.png')}/>
                       <Text style={estilos.txtContato}>saoroqueevoce</Text>
                   </View>
                   <View style={estilos.contatoContainer}>
                       <Image style={estilos.img} source={require('../../images/quemsomos/instagram.png')}/>
                       <Text style={estilos.txtContato}>@saoroqueevoce</Text>
                   </View>
                   <View style={estilos.contatoContainer}>
                       <Image style={estilos.img} source={require('../../images/quemsomos/whatsapp.png')}/>
                       <Text style={estilos.txtContato}>(11) 9 9999-999</Text>
                   </View>
                   <View style={estilos.contatoContainer}>
                       <Image style={estilos.img} source={require('../../images/quemsomos/email.png')}/>
                       <Text style={estilos.txtContato}>saoroqueevoce@email.com</Text>
                   </View>
                   <View style={estilos.contatoContainer}>
                       <Image style={estilos.img} source={require('../../images/quemsomos/site.png')}/>
                       <Text style={estilos.txtContato}>www.racsstudios.com/</Text>
                   </View>
                </View>              
            </View>
        </ScrollView>
    </View>
   
  );
};

const estilos = StyleSheet.create({
    container:{
        flex:1,
        justifyContent:'center'
    },
    h1:{
        marginTop:15,
        fontSize:24,
        fontFamily:'Poppins-Regular',
        color:'#910046',
    },
    txt:{
        marginVertical:10,
        marginBottom:20,
        fontSize:15,
        fontFamily:'Poppins-Regular',
        color:'#414141',
    },
    contatoContainer:{
        flexDirection:'row',
        paddingVertical:10
    },
    txtContato:{
        paddingLeft:15,
        fontFamily:'Poppins-Regular',
        fontSize:15,
        color:'#414141'
    },
    img:{
        height:25,
        width:25,
        resizeMode:'contain'
    }
});