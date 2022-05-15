import React from 'react';
import {
  StyleSheet,
  Text,
  View,
  ScrollView,
  Image,
  TouchableOpacity
} from 'react-native';
import { useNavigation } from '@react-navigation/native';
import Header from '../../componentes/Header';

export default function App(){
const navigation = useNavigation();
  return (
    <View style={estilos.container}>
        <ScrollView showsVerticalScrollIndicator={false}>
            <View> 
                <Header goingback={true} space={true}/>              

               <View style={estilos.containerMenu}>
                <View style={estilos.containerOpcao}>
                    <TouchableOpacity style={estilos.btn} onPress={() => navigation.navigate('Perfil')}>
                        <Image style={estilos.img} source={require('../../images/configuracao/perfil.png')}/>
                        <Text style={estilos.txt}>Perfil</Text>
                    </TouchableOpacity>
                </View>
               </View>
               <View style={estilos.containerMenu}>
                <View style={estilos.containerOpcao}>
                    <TouchableOpacity style={estilos.btn} onPress={() => navigation.navigate('Comentarios')}>
                        <Image style={estilos.img} source={require('../../images/configuracao/comentarios.png')}/>
                        <Text style={estilos.txt}>Comentários</Text>
                    </TouchableOpacity>
                </View>
               </View>
               <View style={estilos.containerMenu}>
                <View style={estilos.containerOpcao}>
                    <TouchableOpacity style={estilos.btn} onPress={() => navigation.navigate('Ajustes')}>
                        <Image style={estilos.img} source={require('../../images/configuracao/configuracao.png')}/>
                        <Text style={estilos.txt}>Configurações</Text>
                    </TouchableOpacity>
                </View>
               </View>
               <View style={estilos.containerMenu}>
                <View style={estilos.containerOpcao}>
                    <TouchableOpacity style={estilos.btn} onPress={() => navigation.navigate('Notificacao')}>
                        <Image style={estilos.img} source={require('../../images/configuracao/notificacao.png')}/>
                        <Text style={estilos.txt}>Notificações</Text>
                    </TouchableOpacity>
                </View>
               </View>
               <View style={estilos.containerMenu}>
                <View style={estilos.containerOpcao}>
                    <TouchableOpacity style={estilos.btn} onPress={() => navigation.navigate('QuemSomos')}>
                        <Image style={estilos.img} source={require('../../images/configuracao/quemsomos.png')}/>
                        <Text style={estilos.txt}>Quem Somos</Text>
                    </TouchableOpacity>
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
        justifyContent:'center',
    },
    containerMenu:{
        paddingHorizontal:40,
        marginTop:2,
    },
    containerOpcao:{
        borderBottomWidth:1,
        paddingVertical:15,
        paddingHorizontal:5,
        borderColor:'#C4C4C4',
    },
    txt:{
        fontFamily:'Roboto-Bold',
        fontSize:20,
        color:'#000',
        paddingLeft:20,
    },
    btn:{
        flexDirection:'row',
        alignItems:'center'
    },
    img:{
        height:35,
        width:35,
        resizeMode:'contain'
    }    
});