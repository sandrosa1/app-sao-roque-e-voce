import React,{useState} from 'react';
import {
  StyleSheet,
  Text,
  View,
  Image,
  TouchableOpacity,
  ScrollView,
  Modal
} from 'react-native';
import Header from '../../componentes/Header';
import CardMeusComentarios from '../../componentes/CardMeusComentarios';

export default function App(){
const [mostrar,setMostrar] = useState(false)
  return (
    <View style={estilos.container}>
         <ScrollView showsVerticalScrollIndicator={false}>
      <Header goingback={true}/>
        <View style={{paddingHorizontal:30}}>
              <Text style={estilos.h1}>Meus Comentários</Text>
              <Text style={estilos.txt}>
                  Reveja ou apague seus comentários.
              </Text>            
        </View>
        <CardMeusComentarios
        title={'Ski-Mountain Park'}
        data={'03 fevereiro 2022'}
        comentario={'Eveniet aliquid culpa officia aut! Impedit sit sunt quaerat, odit tenetur error, harum nesciunt ipsum debitis quas aliquid. Reprehenderit,quia. Quo neque error repudiandae.'}
        estrelas={3}
        />
        <CardMeusComentarios
        title={'Vila Don Patto'}
        data={'15 abril 2022'}
        comentario={'Harum nesciunt ipsum debitis quas aliquid. Reprehenderit,quia. Quo neque error repudiandae.'}
        estrelas={3}
        />
        <CardMeusComentarios
        title={'Hotel Villa Rossa'}
        data={'12 dezembro 2021'}
        comentario={'Ipsum debitis quas aliquid. Quo neque error repudiandae.'}
        estrelas={3}
        />
        <CardMeusComentarios
        title={'Morro do Saboó'}
        data={'12 novembro 2021'}
        comentario={'Debitis quas aliquid. Reprehenderit,quia. Quo neque error repudiandae. accusantium nemo autem. Veritatis obcaecati tenetur iure eius earum ut molestias architecto voluptate aliquam nihil, eveniet aliquid culpa officia aut!'}
        estrelas={3}
        />

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
                                    <Image source={require('../../images/configuracao/warningicon.png')}/>
                                    <Text style={[estilos.txt,{paddingVertical:5}]}>Você deseja apagar o seu comentário?</Text>
                                    <View style={{flexDirection:'row', padding:10}}>
                                    <TouchableOpacity style={estilos.btnBg} onPress={()=>{setMostrar(false)}}>
                                        <Text style={[estilos.txtModal,{color:'#707070'}]}>Não</Text>
                                    </TouchableOpacity> 
                                    <TouchableOpacity style={[estilos.btnBg,{backgroundColor:'#920046'}]}>
                                        <Text style={[estilos.txt,{color:'#FFF'}]}>Sim</Text>
                                    </TouchableOpacity> 
                                </View>
                            </View>                    
                        </View>
                    </View>
                </Modal>
            </View>        
        </View>
        
        </ScrollView>
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
    txtTitle:{
        fontSize:18,
        fontFamily:'Roboto-Bold',
        color:'#000',
    },
    txtData:{
        fontSize:12,
        fontFamily:'Poppins-Regular',
        color:'#920046'
    },
    txtComantario:{
        fontSize:14,
        fontFamily:'Poppins-Regular',
        color:'#414141'
    }

});

