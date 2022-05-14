import React,{useState,useRef} from 'react';
import {
  StyleSheet,
  Text,
  View,
  ScrollView,
  Image,
  Dimensions,
  TouchableOpacity,
} from 'react-native';
import { useNavigation } from '@react-navigation/native';
import NavPages from '../componentes/NavPages';
import CardComentarios from '../componentes/CardComentarios';


export default function App(props){
    const navigation = useNavigation();
    const [rank,setRank] = useState(0);

    let ranks = rank
    
    let arrayrank= []

    let i = 0
    for(i=0 ; i<5 ; i++){
        if(ranks > 0.5){
             arrayrank[i] = require('../images/paginadetalhes/star1.png')
            ranks = ranks - 1
        } else {
            if(ranks <= 0.5 && ranks > 0){
             arrayrank[i] = require('../images/paginadetalhes/star2.png')
             ranks = 0
        } else {
            arrayrank[i]= require('../images/paginadetalhes/star0.png')
        }
    }}
  

  return (
    <View style={estilos.container}>
     
                <View style={{marginHorizontal:30}}>
                    <Text style={estilos.h1}>O que você achou desse local?</Text>
                    <Text style={estilos.txt}>
                        Escolha de 1 a 5 estrelas para classificar.
                    </Text>            
                </View>
              
               <View style={{marginHorizontal:30, flexDirection:'row', justifyContent:'space-between'}}>
                <View style={{flexDirection:'row',}}>
                    <TouchableOpacity onPress={()=>setRank(1)}>
                    <Image style={estilos.star} source={arrayrank[0]}/>                                       
                    </TouchableOpacity>
                    <TouchableOpacity onPress={()=>setRank(2)}>
                    <Image style={estilos.star} source={arrayrank[1]}/>                                       
                    </TouchableOpacity>
                    <TouchableOpacity onPress={()=>setRank(3)}>
                    <Image style={estilos.star} source={arrayrank[2]}/>                                       
                    </TouchableOpacity>
                    <TouchableOpacity onPress={()=>setRank(4)}>
                    <Image style={estilos.star} source={arrayrank[3]}/>                                       
                    </TouchableOpacity>
                    <TouchableOpacity onPress={()=>setRank(5)}>
                    <Image style={estilos.star} source={arrayrank[4]}/>                               
                    </TouchableOpacity>
                </View>
                <View>
                <TouchableOpacity onPress={() => navigation.navigate('PaginaDetalhes',{id:id})}>
                            <View style={{flexDirection:'row'}}>
                                <Text style={{fontFamily:'Poppins-Regular', fontSize:18, color:'#910046',}}>Informações</Text>                               
                            </View>
                        </TouchableOpacity>
                </View>
               </View>

                <View style={{marginVertical:20}}>
                    <View style={{flexDirection:'row', justifyContent:'space-between', marginHorizontal:30}}>
                        <View style={{flexDirection:'row'}}>
                            <Text style={estilos.h1}>Avaliações</Text>
                            <View style={{width:50}}>
                                <Image style={{marginLeft:5, width:21, height:21}} source={require('../images/paginadetalhes/minichat.png')}/>
                                <Text style={{fontSize:12,fontFamily:'Roboto-Bold',position:'absolute',top:8,left:18,color:'#910046',}}>134</Text>
                                </View>
                        </View>
                        <View style={{flexDirection:'row', alignItems:'center'}}>
                            <Text style={[estilos.h1,{fontSize:15, paddingRight:10, top:2}]}>?/5</Text>
                            <View style={{flexDirection:'row',}}>
                            <Image style={estilos.ministar} source={require('../images/paginadetalhes/star0.png')}/>
                            <Image style={estilos.ministar} source={require('../images/paginadetalhes/star0.png')}/>
                            <Image style={estilos.ministar} source={require('../images/paginadetalhes/star0.png')}/>
                            <Image style={estilos.ministar} source={require('../images/paginadetalhes/star0.png')}/>
                            <Image style={estilos.ministar} source={require('../images/paginadetalhes/star0.png')}/>                                
                        </View>
                        </View>

                    </View>
                    
                    <Image source={require('../images/paginadetalhes/line.png')} style={{alignSelf:'center', resizeMode:'contain'}}/> 
                    
                    <View>
                    <CardComentarios
                    title={'Renata Dias'}
                    data={'03 fevereiro 2022'}
                    comentario={'Eveniet aliquid culpa officia aut! Impedit sit sunt quaerat, odit tenetur error, harum nesciunt ipsum debitis quas aliquid. Reprehenderit,quia. Quo neque error repudiandae.'}
                    estrelas={3}
                    />
                    <CardComentarios
                    title={'Joana Machado'}
                    data={'23 maio 2021'}
                    comentario={'Maxime mollitia, molestiae quas vel sint commodi repudiandae consequuntur voluptatum laborum                 numquam blanditiis harum quisquam eius sed odit fugiat iusto fuga praesentium optio, eaque rerum!'}
                    estrelas={4}
                    />
                    <CardComentarios
                    title={'Júlio Cesar'}
                    data={'03 maio 2021'}
                    comentario={'Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime mollitia, molestiae quas vel sint commodi repudiandae consequuntur'}
                    estrelas={5}
                    />
                    <CardComentarios
                    title={'Renata Dias'}
                    data={'03 fevereiro 2022'}
                    comentario={'Eveniet aliquid culpa officia aut! Impedit sit sunt quaerat, odit tenetur error, harum nesciunt ipsum debitis quas aliquid. Reprehenderit,quia. Quo neque error repudiandae.'}
                    estrelas={2}
                    />
                    </View>
                    <View style={{marginVertical:5}}>
                        <TouchableOpacity style={{flexDirection:'row', alignItems:'center', justifyContent:'center'}}>
                        <Image style={{marginHorizontal:10}} source={require('../images/paginadetalhes/mais.png')}/>
                        <Text style={[estilos.h1,{fontSize:14}]}>Carregar mais comentários</Text>
                        </TouchableOpacity>
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
    menuBar:{
        Flex:1,
        marginTop:18,
    },
    h1:{
        fontSize:18,
        fontFamily:'Poppins-Regular',
        color:'#910046',
    },
    txt:{
        fontSize:13,
        fontFamily:'Poppins-Light', 
        color:'#414141',
        bottom:8
    },
    txtDistancia:{
        fontSize:18,
        fontFamily:'Roboto-Bold',    
        color:'#910046',
        marginLeft:15
    },
    
    slideView:{
        width: '100%',
        justifyContent: 'center',
        alignItems: 'center',
        marginVertical:15,     
    },
    carousel:{
        flex:1,
        overflow:'visible'
    },
    carouselImg:{
        alignSelf: 'center',
        width: Dimensions.get('window').width-Dimensions.get('window').width*0.2,
        height: Dimensions.get('window').height-Dimensions.get('window').height*0.72,
        borderRadius: 12,
        backgroundColor: 'rgba(0,0,0,0.5)'
    },
    carouselText:{
        padding: 15,
        color: '#FFF',
        position: 'absolute',
        bottom: 10,
        left: 2,
        fontWeight: 'bold'
    },
    carouselIcon:{
        position:'absolute',
        top: 15,
        right: 15,
    },
    star:{
        height:30,
        width:30,
        marginRight:5,
    },
    ministar:{
        height:20,
        width:20
    }
});