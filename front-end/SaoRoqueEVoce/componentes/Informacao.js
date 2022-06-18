import React from 'react';
import {StyleSheet, Text, View, TouchableOpacity,Dimensions,Image} from 'react-native';
import {useNavigation} from '@react-navigation/native';

export default function App({dados}) {
  const navigation = useNavigation();

  const dado = dados
  return (
    <View>
            <View
              style={{alignItems: 'center', marginBottom: 5, marginTop: 10}}>
              <View
                style={{flex: 1, flexDirection: 'row', alignItems: 'center'}}>
                <Image
                  source={require('../images/paginadetalhes/localizacao.png')}
                />
                <Text style={[estilos.txtDistancia,{color:'#000'}]}>
                  Você está a ?? km de distância.
                </Text>
              </View>
            </View>

            <View style={{alignItems: 'center', marginVertical: 10}}>
              <View
                style={{
                  width:
                    Dimensions.get('window').width -
                    Dimensions.get('window').width * 0.009,
                  flexDirection: 'row',
                  flexWrap: 'wrap',
                }}>
                {dado.complemeto?.estacionamento ? (
                  <View style={estilos.miniicon}>
                    <Image
                      source={require('../images/paginadetalhes/estacionamento.png')}
                    />
                    <Text style={estilos.txticon}>Estacionamento</Text>
                  </View>
                ) : (
                  <View></View>
                )}

                {dado.complemeto?.arCondicionado ? (
                  <View style={estilos.miniicon}>
                    <Image
                      source={require('../images/paginadetalhes/arcondicionado.png')}
                    />
                    <Text style={estilos.txticon}>Ar-Condicionado</Text>
                  </View>
                ) : (
                  <View></View>
                )}

                {dado.complemeto?.acessibilidade ? (
                  <View style={estilos.miniicon}>
                    <Image
                      source={require('../images/paginadetalhes/acessibilidade.png')}
                    />
                    <Text style={estilos.txticon}>Acessibilidade</Text>
                  </View>
                ) : (
                  <View></View>
                )}

                {dado.complemeto?.academia ? (
                  <View style={estilos.miniicon}>
                    <Image
                      source={require('../images/paginadetalhes/academia.png')}
                    />
                    <Text style={estilos.txticon}>Academia</Text>
                  </View>
                ) : (
                  <View></View>
                )}

                {dado.complemeto?.piscina ? (
                  <View style={estilos.miniicon}>
                    <Image
                      source={require('../images/paginadetalhes/piscina.png')}
                    />
                    <Text style={estilos.txticon}>Piscina</Text>
                  </View>
                ) : (
                  <View></View>
                )}

                {dado.complemeto?.wiFi ? (
                  <View style={estilos.miniicon}>
                    <Image
                      source={require('../images/paginadetalhes/wifi.png')}
                    />
                    <Text style={estilos.txticon}>Wi-fi</Text>
                  </View>
                ) : (
                  <View></View>
                )}

                {dado.complemeto?.refeicao ? (
                  <View style={estilos.miniicon}>
                    <Image
                      source={require('../images/paginadetalhes/refeicao.png')}
                    />
                    <Text style={estilos.txticon}>Refeição</Text>
                  </View>
                ) : (
                  <View></View>
                )}

                {dado.complemeto?.trilhas ? (
                  <View style={estilos.miniicon}>
                    <Image
                      source={require('../images/paginadetalhes/trilhas.png')}
                    />
                    <Text style={estilos.txticon}>Trilhas</Text>
                  </View>
                ) : (
                  <View></View>
                )}
              </View>
            </View>

            <Image
              source={require('../images/line3.png')}
              style={{
                alignSelf: 'center',
                resizeMode: 'contain',
                marginVertical: 10,
              }}
            />

            <View style={{paddingHorizontal: 30, marginVertical: 10}}>
              <Text
                style={{
                  fontFamily: 'Poppins-Regular',
                  color: '#414141',
                  fontSize: 14,
                }}>
                {dado.complemeto?.descricao}
              </Text>
            </View>

            <View style={{alignItems: 'center', marginVertical: 10}}>
              <Image
                source={require('../images/line.png')}
                style={{
                  alignSelf: 'center',
                  resizeMode: 'contain',
                  marginVertical: 10,
                }}
              />
              <TouchableOpacity
                onPress={() =>
                  navigation.navigate('PaginaDetalhes', {hookReload: 'hook'+Math.random()})
                }>
                <View style={{flexDirection: 'row'}}>
                  <Text
                    style={{
                      fontFamily: 'Poppins-Regular',
                      fontSize: 18,
                      color: '#910046',
                    }}>
                    Comentários
                  </Text>
                  <View style={{width: 50, marginLeft: 5}}>
                    <Image
                      style={{marginLeft: 5, width: 21, height: 21}}
                      source={require('../images/paginadetalhes/minichat.png')}
                    />
                    <Text style={[estilos.txt,{color:"#000"}]}>{dado.avaliacao}</Text>
                  </View>
                </View>
              </TouchableOpacity>
              <Image
                source={require('../images/line.png')}
                style={{
                  alignSelf: 'center',
                  resizeMode: 'contain',
                  marginVertical: 10,
                }}
              />
            </View>

            <View
              style={{paddingHorizontal: 25, marginTop: 25, marginBottom: 30}}>
              <View style={{flexDirection: 'row', alignItems: 'center'}}>
                <Image
                  style={{width: 30, height: 30}}
                  source={require('../images/servicos/funcionamento.png')}
                />
                <Text style={[estilos.h1, {fontSize: 18,paddingTop:5, color:"#000", fontFamily:'Poppins-SemiBold'}]}>
                  Horário de Funcionamento
                </Text>
              </View>
              <View style={{marginRight: 50}}>
                <View
                  style={{
                    flexDirection: 'row',
                    paddingHorizontal: 25,
                    marginTop: 20,
                    justifyContent: 'space-between',
                  }}>
                  <Text style={[estilos.txtDistancia, {fontSize: 15}]}>
                    Seg a Sex{' '}
                  </Text>
                  <Text
                    style={{
                      fontFamily: 'Poppins-Regular',
                      color: '#414141',
                      fontSize: 14,
                    }}>
                    {dado.complemeto?.semana}
                  </Text>
                </View>
                <View
                  style={{
                    flexDirection: 'row',
                    paddingHorizontal: 25,
                    justifyContent: 'space-between',
                  }}>
                  <Text style={[estilos.txtDistancia, {fontSize: 15}]}>
                    Sábado{' '}
                  </Text>
                  <Text
                    style={{
                      fontFamily: 'Poppins-Regular',
                      color: '#414141',
                      fontSize: 14,
                    }}>
                    {dado.complemeto?.sabado}
                  </Text>
                </View>
                <View
                  style={{
                    flexDirection: 'row',
                    paddingHorizontal: 25,
                    justifyContent: 'space-between',
                  }}>
                  <Text style={[estilos.txtDistancia, {fontSize: 15}]}>
                    Domingo{' '}
                  </Text>
                  <Text
                    style={{
                      fontFamily: 'Poppins-Regular',
                      color: '#414141',
                      fontSize: 14,
                    }}>
                    {dado.complemeto?.domingo}
                  </Text>
                </View>
                <View
                  style={{
                    flexDirection: 'row',
                    paddingHorizontal: 25,
                    justifyContent: 'space-between',
                  }}>
                  <Text style={[estilos.txtDistancia, {fontSize: 15}]}>
                    Feriado{' '}
                  </Text>
                  <Text
                    style={{
                      fontFamily: 'Poppins-Regular',
                      color: '#414141',
                      fontSize: 14,
                    }}>
                    {dado.complemeto?.feriado}
                  </Text>
                </View>
              </View>
            </View>

            <View
              style={{paddingHorizontal: 30, marginTop: 15, marginBottom: 30}}>
              {dado.logradouro ? (
                <View
                  style={{
                    flexDirection: 'row',
                    alignItems: 'center',
                    marginBottom: 20,
                  }}>
                  <Image
                    source={require('../images/paginadetalhes/rota.png')}
                  />
                  <Text
                    style={{
                      fontFamily: 'Poppins-Regular',
                      color: '#414141',
                      fontSize: 14,
                      marginLeft: 15,
                    }}>
                    {dado.logradouro}, {dado.numero} - {dado.bairro}
                  </Text>
                </View>
              ) : (
                <View></View>
              )}
              {dado.telefone ? (
                <View
                  style={{
                    flexDirection: 'row',
                    alignItems: 'center',
                    marginBottom: 20,
                  }}>
                  <Image
                    source={require('../images/paginadetalhes/contato.png')}
                  />
                  <Text
                    style={{
                      fontFamily: 'Poppins-Regular',
                      color: '#414141',
                      fontSize: 14,
                      marginLeft: 15,
                    }}>
                    {dado.telefone}
                  </Text>
                </View>
              ) : (
                <View></View>
              )}
              {dado.site ? (
                <View
                  style={{
                    flexDirection: 'row',
                    alignItems: 'center',
                    marginBottom: 20,
                  }}>
                  <Image
                    source={require('../images/paginadetalhes/site.png')}
                  />
                  <Text
                    style={{
                      fontFamily: 'Poppins-Regular',
                      color: '#414141',
                      fontSize: 14,
                      marginLeft: 15,
                    }}>
                    {dado.site}
                  </Text>
                </View>
              ) : (
                <View></View>
              )}
            </View>
          </View>
  );
}

const estilos = StyleSheet.create({
    container: {
      flex: 1,
      justifyContent: 'center',
    },
    menuBar: {
      Flex: 1,
      marginTop: 18,
    },
    h1: {
      marginLeft: 10,
      fontSize: 24,
      fontFamily: 'Poppins-Regular',
      color: '#910046',
    },
    txt: {
      fontSize: 12,
      fontFamily: 'Roboto-Bold',
      position: 'absolute',
      top: 8,
      left: 18,
      color: '#910046',
    },
    txtDistancia: {
      fontSize: 18,
      fontFamily: 'Roboto-Bold',
      color: '#910046',
      marginLeft: 15,
    },
  
    slideView: {
      width: '100%',
      justifyContent: 'center',
      alignItems: 'center',
      marginBottom: 15,
    },
    carousel: {
      flex: 1,
      overflow: 'visible',
    },
    carouselImg: {
      alignSelf: 'center',
      width:
        Dimensions.get('window').width - Dimensions.get('window').width * 0.2,
      height:
        Dimensions.get('window').height - Dimensions.get('window').height * 0.7,
      borderRadius: 12,
      backgroundColor: 'rgba(0,0,0,0.5)',
      resizeMode: 'cover',
      maxHeight: 225,
    },
    carouselText: {
      padding: 15,
      color: '#FFF',
      position: 'absolute',
      bottom: 10,
      left: 2,
      fontWeight: 'bold',
    },
    carouselIcon: {
      position: 'absolute',
      top: 15,
      right: 15,
    },
    img: {
      height: 18,
      width: 18,
    },
    miniicon: {
      flexDirection: 'row',
      width:'33%',
      alignItems: 'center',
      marginVertical: 8,
      marginLeft:1
    },
    txticon: {
      fontSize: 9.6,
      fontFamily: 'Poppins-Regular',
      color: '#414141',
      paddingLeft:1.5
    },
  });
  