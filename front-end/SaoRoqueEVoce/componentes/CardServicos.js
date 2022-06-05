import React from 'react';
import {
  StyleSheet,
  Text,
  View,
  TouchableOpacity,
  Image,
  Dimensions,
} from 'react-native';
import {useNavigation} from '@react-navigation/native';

export default function App(props) {
  const navigation = useNavigation();

  let title = props.title;
  let rua = props.rua;
  let funcionamento = props.funcionamento;
  let contato = props.contato;
  let distancia = props.distancia;
  let img = props.img;

  return (
    <View style={estilos.container}>
      <View style={estilos.cardBody}>
        <View style={estilos.conteudo1}>
          <Text style={estilos.title}>{props.title}</Text>
          <View style={{flex: 1, justifyContent: 'space-evenly', marginTop: 5}}>
            <Text
              style={{
                fontFamily: 'Poppins-Regular',
                color: '#000',
                fontSize: 14,
              }}>
              {props.rua}
            </Text>
            <View style={{flexDirection: 'row', alignItems: 'center'}}>
              <Image
                style={estilos.img}
                source={require('../images/servicos/funcionamento.png')}
              />
              <Text style={estilos.txtConteudo}>{props.funcionamento}</Text>
            </View>
            <View style={{flexDirection: 'row', alignItems: 'center'}}>
              <Image
                style={estilos.img}
                source={require('../images/servicos/contato.png')}
              />
              <Text style={estilos.txtConteudo}>{props.contato}</Text>
            </View>
          </View>
        </View>
        <View
          style={{
            flex: 1,
            alignItems: 'center',
            padding: 15,
            justifyContent: 'space-between',
          }}>
          <View>
            <Text style={estilos.title}>{props.distancia} km</Text>
            <TouchableOpacity>
              <Image
                style={estilos.img}
                source={require('../images/servicos/rota.png')}
              />
            </TouchableOpacity>
          </View>
          <Image style={estilos.img} source={props.img} />
        </View>
      </View>
    </View>
  );
}

const estilos = StyleSheet.create({
  container: {
    alignItems: 'center',
    paddingVertical: 15,
    marginTop: 10,
  },
  cardBody: {
    width:
      Dimensions.get('window').width - Dimensions.get('window').width * 0.15,
    height:
      Dimensions.get('window').height - Dimensions.get('window').height * 0.76,
    borderWidth: 2,
    borderRadius: 15,
    borderColor: '#910046',
    flexDirection: 'row',
  },
  conteudo1: {
    width: 260,
    height: 170,
    paddingVertical: 15,
    paddingHorizontal: 15,
  },
  title: {
    fontFamily: 'Roboto-Bold',
    color: '#000',
    fontSize: 16,
  },
  txtConteudo: {
    fontFamily: 'Poppins-Regular',
    color: '#000',
    fontSize: 14,
    paddingLeft: 10,
  },
  img: {
    height: 35,
    width: 35,
    resizeMode: 'contain',
  },
});
