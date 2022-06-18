import React from 'react';
import {
  StyleSheet,
  Text,
  View,
  ImageBackground,
  TouchableOpacity,
  Dimensions,
  Image,
} from 'react-native';
import {useNavigation} from '@react-navigation/native';

export default function App({data}) {
  const navigation = useNavigation();

  return (
    <View style={{alignItems: 'center'}}>
      <TouchableOpacity
        style={{flex: 1}}
        onPress={() => navigation.navigate('PaginaDetalhes', {id: data.idApp})}>
        <View style={estilos.cardcontainer}>
          <ImageBackground
            source={{uri: data.img1}}
            resizeMode="cover"
            style={estilos.cardbody}>
            <View style={estilos.bgInfo}></View>
            <View style={estilos.containerInfo}>
              <Text style={estilos.txtCard}>{data.nomeFantasia}</Text>
              <Image
                style={{bottom: 10}}
                source={require('../images/line.png')}
              />
            </View>
          </ImageBackground>
        </View>
      </TouchableOpacity>
    </View>
  );
}

const estilos = StyleSheet.create({
  cardcontainer: {
    flex: 1,
    width:
      Dimensions.get('window').width - Dimensions.get('window').width * 0.15,
    height:
      Dimensions.get('window').height - Dimensions.get('window').height * 0.7,
    marginVertical: 15,
    maxHeight: 225,
  },
  cardbody: {
    flex: 1,
    borderRadius: 20,
    justifyContent: 'flex-end',
    alignItems: 'center',
    overflow: 'hidden',
    elevation: 5,
    shadowColor: '#000',
    shadowOpacity: 1,
    shadowOffset: {
      width: 2,
      height: 3,
    },
  },
  bgInfo: {
    backgroundColor: 'white',
    opacity: 0.65,
    width: '100%',
    height: 50,
    justifyContent: 'flex-end',
    borderBottomLeftRadius: 17,
    borderBottomRightRadius: 17,
  },
  containerInfo: {
    width: '100%',
    alignItems: 'center',
    position: 'absolute',
    height: 50,
    bottom: 0,
  },
  txtCard: {
    width: '100%',
    height: '100%',
    fontSize: 20,
    fontFamily: 'Roboto-Bold',
    color: 'black',
    textAlign: 'center',
    textAlignVertical: 'center',
    textShadowColor: '#FFF',
    textShadowOffset: {width: 1, height: 1},
    textShadowRadius: 2,
  },
});
