import React from 'react';
import {
  StyleSheet,
  Text,
  View,
  ScrollView,
  Image,
  TouchableOpacity
} from 'react-native';
import NavPages from '../../componentes/NavPages';
import BuscarBar from '../../componentes/BuscarBar';
import MenuPages from '../../componentes/MenuPages';
import CardServicos from '../../componentes/CardServicos';

export default function App(){
  return (
    <View style={estilos.container}>
        <ScrollView showsVerticalScrollIndicator={false}>
            <View style={{flex:1}}>      
                <NavPages 
                    icon={require('../../images/menubar/servico.png')}
                    title={'Serviços'}/>
                <BuscarBar title={'Serviços'}/>
                   {/* <View style={{marginTop:20, alignItems:'center'}}>
                        <ScrollView horizontal={true} showsHorizontalScrollIndicator={false}> */}
                <View style={{flexDirection:'row', marginTop:20, justifyContent:'space-around'}}>
                        <MenuPages 
                            icon={require('../../images/servicos/iconhospital.png')}
                            title={'Hospitais'}/>
                        <MenuPages 
                            icon={require('../../images/servicos/iconmecanico.png')}
                            title={'Mecânicos'}/>
                        <MenuPages 
                            icon={require('../../images/servicos/iconbanco.png')}
                            title={'Bancos'}/>
                        <MenuPages 
                            icon={require('../../images/servicos/iconfarmacia.png')}
                            title={'Farmácias'}/>
                       {/* </ScrollView> //caso queira adicionar mais icones de serviço barra menu horizontal */}
                </View>
                <Image source={require('../../images/line.png')} style={{alignSelf:'center', resizeMode:'contain', marginVertical:20}}/> 
                <View style={{paddingHorizontal:30}}>
                    <Text style={estilos.h1}>Destaques</Text>
                    <Text style={estilos.txt}>
                        Os serviços mais próximos de você.
                    </Text>                   
                </View>

              <View style={{marginBottom:30}}>
                <CardServicos 
                title={'Santa Casa de São Roque'}
                rua={'Rua Santa Isabel, 186'}
                funcionamento={'Aberto 24 horas'}
                contato={'(11) 4719-9360'}
                distancia={'3'}
                img={require('../../images/servicos/santacasa.png')}
                />
                <CardServicos 
                title={'Banco do Brasil'}
                rua={'Rua Quinze de Novembro, 60'}
                funcionamento={'Segunda a sexta - 10h às 16h'}
                contato={'(11) 4712-6085'}
                distancia={'5'}
                img={require('../../images/servicos/bancobrasil.png')}
                />
                <CardServicos 
                title={'Unimed'}
                rua={'Rua Capitão José Vicente de Moraes,97'}
                funcionamento={'Aberto 24 horas'}
                contato={'(11) 4784-8484'}
                distancia={'11'}
                img={require('../../images/servicos/unimed.png')}
                />
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
        fontSize:24,
        fontFamily:'Poppins-Regular',
        color:'#910046',
    },
    txt:{
        fontSize:15,
        fontFamily:'Poppins-Regular',
        color:'#414141',
    },
});