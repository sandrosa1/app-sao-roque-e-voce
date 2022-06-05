import React, {useState, useEffect,useRef} from 'react';
import {StyleSheet, Text, View, ScrollView, Image, TouchableOpacity, Dimensions} from 'react-native';
import NavPages from '../../componentes/NavPages';
import axios from 'axios';

export default function App() {
  const [dados, setDados] = useState([]);
  const scrollRef = useRef();
  const {width, height} = Dimensions.get('window');

  useEffect(() => {
    loadApi();
  }, []);

  async function loadApi() {
     const response = await axios.get(`http://www.racsstudios.com/api/v1`);
    setDados(response.data);
  }
  return (
    <View style={estilos.container}>
      <ScrollView 
      onLayout={(event)=>console.log(event.nativeEvent.layout)}
      showsVerticalScrollIndicator={false}
       ref={scrollRef}
       style={{width:width, height:height}}>
        <View style={{flex: 1}}>
          <NavPages
            icon={require('../../images/menubar/quemsomos.png')}
            title={'Quem Somos'}
          />

          <View style={{paddingHorizontal: 30}}>
            <Text
              style={{
                fontFamily: 'Roboto-Bold',
                fontSize: 30,
                color: '#000',
                textAlign: 'center',
              }}>
              {dados.autor}
            </Text>
            <Text style={estilos.h1}>Sobre</Text>
            <Text style={estilos.txt}>{dados.descricao}</Text>
            <Text style={estilos.h1}>Nossa missão</Text>
            <Text style={estilos.txt}>{dados.missao}</Text>
            <Text style={estilos.h1}>Nossa visão</Text>
            <Text style={estilos.txt}>{dados.visao}</Text>
            <Text style={estilos.h1}>Nossos valores</Text>
            <Text style={estilos.txt}>{dados.valores}</Text>
          </View>
          <Image
            source={require('../../images/line.png')}
            style={{alignSelf: 'center', resizeMode: 'contain'}}
          />
          <View style={{paddingHorizontal: 30, marginTop: 10}}>
            <Text style={estilos.h1}>Contato</Text>
            <View style={estilos.contatoContainer}>
              <Image
                style={estilos.img}
                source={require('../../images/quemsomos/facebook.png')}
              />
              <Text style={estilos.txtContato}>{dados.facebook}</Text>
            </View>
            <View style={estilos.contatoContainer}>
              <Image
                style={estilos.img}
                source={require('../../images/quemsomos/instagram.png')}
              />
              <Text style={estilos.txtContato}>{dados.instagran}</Text>
            </View>
            <View style={estilos.contatoContainer}>
              <Image
                style={estilos.img}
                source={require('../../images/quemsomos/whatsapp.png')}
              />
              <Text style={estilos.txtContato}>{dados.whatsapp}</Text>
            </View>
            <View style={estilos.contatoContainer}>
              <Image
                style={estilos.img}
                source={require('../../images/quemsomos/email.png')}
              />
              <Text style={estilos.txtContato}>{dados.email}</Text>
            </View>
            <View style={estilos.contatoContainer}>
              <Image
                style={estilos.img}
                source={require('../../images/quemsomos/site.png')}
              />
              <Text style={estilos.txtContato}>{dados.site}</Text>
            </View>
          </View>
          <View
            style={{
              paddingHorizontal: 30,
              flexDirection: 'row',
              alignItems: 'center',
              justifyContent: 'center',
            }}>
            <Text
              style={[
                estilos.txt,
                {fontFamily: 'Poppins-Regular', color: '#910046'},
              ]}>
              Versão{' '}
            </Text>
            <Text
              style={[
                estilos.txt,
                {fontFamily: 'Poppins-SemiBold', color: '#000'},
              ]}>
              {dados.versao}
            </Text>
          </View>
        </View>       
        <TouchableOpacity onPress={()=> {scrollRef.current.scrollTo({x:0,y:0,animated:true})}}> 
          <Text>ir ao topo</Text>
      </TouchableOpacity>
      </ScrollView>
    </View>
  );
}

const estilos = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: 'center',
  },
  h1: {
    marginTop: 15,
    fontSize: 24,
    fontFamily: 'Poppins-Regular',
    color: '#910046',
  },
  txt: {
    marginVertical: 10,
    marginBottom: 20,
    fontSize: 15,
    fontFamily: 'Poppins-Regular',
    color: '#414141',
  },
  contatoContainer: {
    flexDirection: 'row',
    paddingVertical: 10,
  },
  txtContato: {
    paddingLeft: 15,
    fontFamily: 'Poppins-Regular',
    fontSize: 15,
    color: '#414141',
  },
  img: {
    height: 25,
    width: 25,
    resizeMode: 'contain',
  },
});
